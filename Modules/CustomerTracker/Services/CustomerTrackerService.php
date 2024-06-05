<?php

namespace Modules\CustomerTracker\Services;

use Modules\CustomerTracker\Entities\ProductClick;
use Modules\CustomerTracker\Entities\ProductClickCount;

class CustomerTrackerService
{
    /**
     * Tracks product clicks by clients and increments the click count.
     * 
     * @param int $product_id
     * @param string $client_id
     * @return int
     */
    public function trackProductClick(int $product_id, string $client_id): int
    {
        $click_exists = ProductClick::where('product_id', $product_id)->where('client_id', $client_id)->exists();

        if (!$click_exists) {
            ProductClick::create([
                'product_id' => $product_id,
                'client_id' => $client_id
            ]);

            $click_count = ProductClickCount::firstOrCreate(
                ['product_id' => $product_id],
                ['click_count' => 0]
            );

            $click_count->increment('click_count');
        }

        return ProductClick::where('product_id', $product_id)->distinct('client_id')->count('client_id');
    }
}
