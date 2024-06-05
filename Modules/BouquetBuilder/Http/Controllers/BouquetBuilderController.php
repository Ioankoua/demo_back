<?php

namespace Modules\BouquetBuilder\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\BouquetBuilder\Http\Requests\CreateBouquetRequest;
use Modules\BouquetBuilder\Services\BouquetService;

class BouquetBuilderController extends Controller
{
    protected $bouquet_service;

    public function __construct(BouquetService $bouquet_service)
    {
        $this->bouquet_service = $bouquet_service;
    }

    /**
     * Retrieves a bouquet by its ID and associated images.
     * 
     * @param int $bouquet_id The ID of the bouquet to retrieve.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the bouquet data or an error message.
     */
    public function getBouquet($bouquet_id) 
    {
        $bouquet = $this->bouquet_service->getBouquetById($bouquet_id);
        
        if (!$bouquet) {
            return response()->json(['message' => 'Bouquet not found'], 404);
        }

        return response()->json($bouquet);
    }

    /**
     * Retrieves all active bouquet builders with their main images.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response containing a list of active bouquet builders and their main images.
     */
    public function getAllBouquetBuilder()
    {
        $bouquets = $this->bouquet_service->getAllActiveBouquets();
        return response()->json($bouquets);
    }

    /**
     * Creates a new bouquet order with optional images.
     * 
     * @param \Illuminate\Http\Request $request The HTTP request containing order details and images.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating order creation success and returning the created order.
     */
    public function create(CreateBouquetRequest $request)
    {
        $order = $this->bouquet_service->createBouquet($request);
        return response()->json(['message' => 'Order successfully created', 'order' => $order], 201);
    }

    /**
     * Marks a bouquet as inactive (soft delete) by its ID.
     * 
     * @param int $bouquet_id The ID of the bouquet to mark as inactive.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success of the operation or an error message.
     */
    public function safeDelete($bouquet_id) 
    {
        $result = $this->bouquet_service->deleteBouquet($bouquet_id);

        if (!$result) {
            return response()->json(['message' => 'Bouquet not found'], 404);
        }

        return response()->json(['message' => 'Bouquet was successfully deleted'], 200);
    }
}
