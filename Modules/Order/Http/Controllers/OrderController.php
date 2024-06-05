<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Modules\Order\Http\Requests\CreateOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Order\Services\OrderService;
use Modules\Order\Services\NotificationService;

class OrderController extends Controller
{
    protected $order_service;
    protected $notification_service;

    public function __construct(OrderService $order_service, NotificationService $notification_service)
    {
        $this->order_service = $order_service;
        $this->notification_service = $notification_service;
    }

    /**
     * Retrieves an order by its ID.
     * 
     * @param int $order_id The ID of the order to retrieve.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the order data or an error message.
     */
    public function getOrder($order_id) 
    {
        $order = $this->order_service->getOrderById($order_id);
        
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        } 

        return response()->json($order);
    }

    /**
     * Retrieves all active orders.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response containing a list of active orders or an error message.
     */
    public function getAllOrders()
    {
        $orders = $this->order_service->getAllActiveOrders();

        if (!$orders) {
            return response()->json(['message' => 'Orders not found'], 404);
        } 

        return response()->json($orders);
    }

    /**
     * Creates a new order and sends a notification to Telegram.
     * 
     * @param \Illuminate\Http\Request $request The HTTP request containing order details.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating order creation success and returning the created order.
     */
    public function create(CreateOrderRequest $request)
    {
        $order = $this->order_service->createOrder($request);

        $this->notification_service->sendOrderNotification($order);

        return response()->json(['message' => 'Order successfully created', 'order' => $order], 201);
    }

    /**
     * Updates an existing order by its ID.
     * 
     * @param int $order_id The ID of the order to update.
     * @param \Illuminate\Http\Request $request The HTTP request containing updated order details.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating order update success or an error message.
     */
    public function update($order_id, CreateOrderRequest $request)
    {
        $order = $this->order_service->updateOrder($order_id, $request);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['message' => 'Order successfully updated'], 200);
    }

    /**
     * Marks an order as inactive (soft delete) by its ID.
     * 
     * @param int $order_id The ID of the order to mark as inactive.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success of the operation or an error message.
     */
    public function safeDelete($order_id)
    {
        $result = $this->order_service->deleteOrder($order_id);

        if (!$result) {
            return response()->json(['message' => 'Order not found'], 404);
        } 

        return response()->json(['message' => 'Order was successfully deleted'], 200);
    }

}
