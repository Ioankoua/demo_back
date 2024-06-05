<?php

namespace Modules\Product\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductCategories;
use Modules\Product\Entities\ProductSecondaryImage;
use Modules\CustomerTracker\Entities\ProductClickCount;
use Modules\Product\Http\Requests\CreateProductRequest;

class ProductService
{
    /**
     * Retrieves a product by its ID along with secondary images and categories.
     * 
     * @param int $product_id
     * @return Product|null
     */
    public function getProductById(int $product_id): ?Product
    {
        $product = Product::find($product_id);

        if ($product) {
            $secondary_images = DB::table('product_secondary_images')->where('product_id', $product_id)->get();
            $product->secondary_images = $secondary_images;

            $categories = DB::table('product_categories')
                ->join('category', 'product_categories.cat_id', '=', 'category.id')
                ->where('product_categories.product_id', $product_id)
                ->select('category.id', 'category.name')
                ->get();
            
            $product->categories = $categories;
        }

        return $product;
    }

    /**
     * Retrieves all active products with their click counts and category IDs.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAllActiveProducts()
    {
        $products = Product::where('active', 1)->orderBy('priority', 'desc')->get();

        $products->map(function ($product) {
            $click_count = ProductClickCount::where('product_id', $product->id)->value('click_count');
            $product->click_count = $click_count ?? 0;
            return $product;
        });

        $products->map(function ($product) {
            $categories = ProductCategories::where('product_id', $product->id)->pluck('cat_id');
            $product->category_ids = $categories->toArray(); 
            return $product;
        });

        return $products;
    }

    /**
     * Retrieves all deleted (inactive) products.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getDeletedProducts()
    {
        return Product::where('active', 0)->orderBy('priority', 'desc')->get();
    }

    /**
     * Creates a new product with optional main and secondary images, and assigns categories.
     * 
     * @param CreateProductRequest $request
     * @return Product
     */
    public function createProduct(CreateProductRequest $request): Product
    {
        $validated_data = $request->validated();

        return DB::transaction(function () use ($request, $validated_data) {
            if ($request->hasFile('main_image')) {
                $main_image_path = $request->file('main_image')->store('images/products', 'public');
                $validated_data['main_image'] = $main_image_path;
            }

            $product = Product::create($validated_data);

            if ($request->has('category_ids')) {
                $product->categories()->attach($request->category_ids);
            }

            if ($request->hasFile('secondary_images')) {
                $secondary_images = [];
                foreach ($request->file('secondary_images') as $secondary_image) {
                    $path = $secondary_image->store('images/secondary_images', 'public');
                    $secondary_images[] = new ProductSecondaryImage(['image_path' => $path]);
                }

                $product->secondaryImages()->saveMany($secondary_images);
            }

            return $product;
        });
    }

    /**
     * Updates an existing product by its ID, including images and categories.
     * 
     * @param int $product_id
     * @param CreateProductRequest $request
     * @return Product|null
     */
    public function updateProduct(int $product_id, CreateProductRequest $request): ?Product
    {
        $product = Product::find($product_id);

        if (!$product) {
            return null;
        }

        return DB::transaction(function () use ($product, $request, $product_id) {
            $validated_data = $request->validated();
            $product->update($validated_data);

            if ($request->hasFile('main_image')) {
                $this->deleteMainImg($product);
                $file = $request->file('main_image');
                $path = $file->store('images/products', 'public');
                $product->main_image = $path;
                $product->save();
            }

            if ($request->hasFile('secondary_images')) {
                $this->deleteSecondaryImg($product);
                ProductSecondaryImage::where('product_id', $product_id)->delete();
                foreach ($request->file('secondary_images') as $file) {
                    $path = $file->store('images/secondary_images', 'public');
                    ProductSecondaryImage::create([
                        'product_id' => $product_id,
                        'image_path' => $path
                    ]);
                }
            }

            $category_ids = $request->input('category_ids', []);
            ProductCategories::where('product_id', $product_id)->delete();
            foreach ($category_ids as $cat_id) {
                ProductCategories::create([
                    'product_id' => $product_id,
                    'cat_id' => $cat_id
                ]);
            }

            $product->save();

            return $product;
        });
    }

    /**
     * Deletes a product by its ID, including associated data such as images and categories.
     * 
     * @param int $product_id
     * @return bool
     */
    public function deleteProduct(int $product_id): bool
    {
        $product = Product::find($product_id);

        if (!$product) {
            return false;
        }

        DB::transaction(function () use ($product, $product_id) {
            DB::table('product_click_counts')->where('product_id', $product_id)->delete();
            DB::table('product_categories')->where('product_id', $product_id)->delete();
            DB::table('product_clicks')->where('product_id', $product_id)->delete();

            $this->deleteMainImg($product);
            $this->deleteSecondaryImg($product);

            $product->delete();
        });

        return true;
    }

    /**
     * Marks a product as inactive (soft delete) by its ID.
     * 
     * @param int $product_id
     * @return bool
     */
    public function softDeleteProduct(int $product_id): bool
    {
        $product = Product::find($product_id);

        if (!$product) {
            return false;
        }

        $product->active = 0;
        $product->save();

        return true;
    }

    /**
     * Activates a product by its ID.
     * 
     * @param int $product_id
     * @return bool
     */
    public function activateProduct(int $product_id): bool
    {
        $product = Product::find($product_id);

        if (!$product) {
            return false;
        }

        $product->active = 1;
        $product->save();

        return true;
    }

    /**
     * Deletes the main image of the given product from storage.
     * 
     * @param Product $product
     * @return void
     */
    private function deleteMainImg(Product $product): void
    {
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }
    }

    /**
     * Deletes all secondary images of the given product from storage.
     * 
     * @param Product $product
     * @return void
     */
    private function deleteSecondaryImg(Product $product): void
    {
        if ($product->secondaryImages) {
            foreach ($product->secondaryImages as $secondary_image) {
                Storage::disk('public')->delete($secondary_image->image_path);
            }
        }
    }
}
