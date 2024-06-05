<?php

namespace Modules\BouquetBuilder\Services;

use Modules\BouquetBuilder\Entities\BouquetBuilder;
use Modules\BouquetBuilder\Entities\BouquetBuilderImages;
use Illuminate\Support\Facades\DB;
use Modules\BouquetBuilder\Http\Requests\CreateBouquetRequest;

class BouquetService
{
    /**
     * Retrieves a bouquet by its ID and associated images.
     * 
     * @param int $bouquet_id
     * @return mixed
     */
    public function getBouquetById($bouquet_id)
    {
        $bouquet = BouquetBuilder::find($bouquet_id);
        
        if (!$bouquet) {
            return null;
        }

        $images = DB::table('bouquet_builder_images')->where('bouquet_builder_id', $bouquet_id)->get();
        $bouquet->images = $images;

        return $bouquet;
    }

    /**
     * Retrieves all active bouquet builders with their main images.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAllActiveBouquets()
    {
        $bouquets = BouquetBuilder::where('active', 1)
            ->with(['images' => function ($query) {
                $query->select('bouquet_builder_id', 'image_path')->orderBy('id', 'asc'); 
            }])->get();

        return $bouquets->map(function ($bouquet) {
            $first_image = $bouquet->images->first(); 
            $bouquet->main_image = $first_image ? $first_image->image_path : null;
            unset($bouquet->images); 
            return $bouquet;
        });
    }

    /**
     * Creates a new bouquet order with optional images.
     * 
     * @param CreateBouquetRequest $request
     * @return BouquetBuilder
     */
    public function createBouquet(CreateBouquetRequest $request)
    {
        $validated_data = $request->validated();

        $order = BouquetBuilder::create($validated_data);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $bouquet_builder_img) {
                $path = $bouquet_builder_img->store('images/bouquet_builder', 'public');
                $images[] = new BouquetBuilderImages(['image_path' => $path]);
            }

            $order->images()->saveMany($images);
        }

        return $order;
    }

    /**
     * Marks a bouquet as inactive (soft delete) by its ID.
     * 
     * @param int $bouquet_id
     * @return bool
     */
    public function deleteBouquet($bouquet_id)
    {
        $bouquet = BouquetBuilder::find($bouquet_id);

        if (!$bouquet) {
            return false;
        }

        $bouquet->active = 0;
        $bouquet->save();

        return true;
    }
}
