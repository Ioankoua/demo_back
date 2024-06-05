<?php

namespace Modules\Order\Services;

use Modules\Order\Entities\Order;
use Modules\Order\Http\Requests\CreateOrderRequest;

class OrderService
{
    /**
     * Retrieves an order by its ID.
     * 
     * @param int $order_id
     * @return Order|null
     */
    public function getOrderById(int $order_id): ?Order
    {
        return Order::find($order_id);
    }

    /**
     * Retrieves all active orders.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAllActiveOrders()
    {
        return Order::where('active', 1)->get();
    }

    /**
     * Creates a new order.
     * 
     * @param CreateOrderRequest $request
     * @return Order
     */
    public function createOrder(CreateOrderRequest $request): Order
    {
        $validated_data = $request->validated();
        return Order::create($validated_data);
    }

    /**
     * Updates an existing order by its ID.
     * 
     * @param int $order_id
     * @param CreateOrderRequest $request
     * @return Order|null
     */
    public function updateOrder(int $order_id, CreateOrderRequest $request): ?Order
    {
        $order = Order::find($order_id);

        if (!$order) {
            return null;
        }

        $validated_data = $request->validated();
        $order->update($validated_data);

        return $order;
    }

    /**
     * Marks an order as inactive (soft delete) by its ID.
     * 
     * @param int $order_id
     * @return bool
     */
    public function deleteOrder(int $order_id): bool
    {
        $order = Order::find($order_id);

        if (!$order) {
            return false;
        }

        $order->active = 0;
        $order->save();

        return true;
    }
}
