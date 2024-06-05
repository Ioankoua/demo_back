<?php

namespace Modules\CustomerTracker\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CustomerTracker\Services\CustomerTrackerService;
use Modules\CustomerTracker\Services\UniqueVisitorService;

class CustomerTrackerController extends Controller
{
    protected $customer_tracker_service;
    protected $unique_visitor_service;

    public function __construct(CustomerTrackerService $customer_tracker_service, UniqueVisitorService $unique_visitor_service)
    {
        $this->customer_tracker_service = $customer_tracker_service;
        $this->unique_visitor_service = $unique_visitor_service;
    }

    /**
     * Tracks product clicks by clients and increments the click count.
     * 
     * @param \Illuminate\Http\Request $request The HTTP request containing product and client IDs.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the number of unique clicks.
     */
    public function tracked(Request $request)
    {
        $product_id = (int) $request->input('product_id');
        $client_id = $request->input('client_id');

        $unique_clicks = $this->customer_tracker_service->trackProductClick($product_id, $client_id);

        return response()->json(['unique_clicks' => $unique_clicks], 201);
    }

    /**
     * Records unique visitors for the current date.
     * 
     * @param \Illuminate\Http\Request $request The HTTP request.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the visit was recorded successfully.
     */
    public function uniqueVisitors(Request $request)
    {
        $this->unique_visitor_service->recordUniqueVisitor();

        return response()->json(['message' => 'Visit recorded successfully.'], 201);
    }
}
