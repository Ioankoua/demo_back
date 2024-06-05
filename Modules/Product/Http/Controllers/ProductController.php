<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Http\Requests\CreateProductRequest;
use Modules\Product\Services\ProductService;

class ProductController extends Controller
{
    protected $product_service;

    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    /**
     * Retrieves a product by its ID along with secondary images and categories.
     * 
     * @param int $product_id The ID of the product to retrieve.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the product data or an error message.
     */
    public function getProduct($product_id) 
    {
        $product = $this->product_service->getProductById($product_id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    /**
     * Retrieves all active products with their click counts and category IDs.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response containing a list of active products or an error message.
     */
    public function getAllProducts() 
    {
        $products = $this->product_service->getAllActiveProducts();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Products not found'], 404);
        }

        return response()->json($products);
    }

    /**
     * Retrieves all deleted (inactive) products.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response containing a list of deleted products or an error message.
     */
    public function getDeletedProducts()
    {
        $products = $this->product_service->getDeletedProducts();

        if ($products->isEmpty()) {
            return response()->json(['message' => 'Products not found'], 404);
        }

        return response()->json($products);
    }

    /**
     * Creates a new product with optional main and secondary images, and assigns categories.
     * 
     * @param \Modules\Product\Http\Requests\CreateProductRequest $request The HTTP request containing product details.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating product creation success and returning the created product.
     */
    public function create(CreateProductRequest $request)
    {
        $product = $this->product_service->createProduct($request);

        return response()->json(['message' => 'Product successfully created', 'product' => $product], 201);
    }

    /**
     * Updates an existing product by its ID, including images and categories.
     * 
     * @param int $product_id The ID of the product to update.
     * @param \Modules\Product\Http\Requests\CreateProductRequest $request The HTTP request containing updated product details.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating product update success or an error message.
     */
    public function update($product_id, CreateProductRequest $request)
    {
        $product = $this->product_service->updateProduct($product_id, $request);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product successfully updated'], 200);
    }

    /**
     * Deletes a product by its ID, including associated data such as images and categories.
     * 
     * @param int $product_id The ID of the product to delete.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating product deletion success or an error message.
     */
    public function delete($product_id)
    {
        $result = $this->product_service->deleteProduct($product_id);

        if (!$result) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product successfully deleted'], 200);
    }

    /**
     * Marks a product as inactive (soft delete) by its ID.
     * 
     * @param int $product_id The ID of the product to mark as inactive.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success of the operation or an error message.
     */
    public function softDelete($product_id) 
    {
        $result = $this->product_service->softDeleteProduct($product_id);

        if (!$result) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product was successfully deleted'], 200);
    }

    /**
     * Activates a product by its ID.
     * 
     * @param int $product_id The ID of the product to activate.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success of the operation or an error message.
     */
    public function activate($product_id)
    {
        $result = $this->product_service->activateProduct($product_id);

        if (!$result) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product was successfully activated'], 200);
    }
}
