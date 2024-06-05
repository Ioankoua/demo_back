<?php

namespace Modules\Order\Services;

use GuzzleHttp\Client;
use Modules\Order\Entities\Order;

class NotificationService
{
    protected $client;
    protected $telegram_token;
    protected $chat_id;

    public function __construct()
    {
        $this->client = new Client();
        $this->telegram_token = 'Ваш токен';
        $this->chat_id = 'ID чата или канала';
    }

    /**
     * Sends a notification to Telegram about a new order.
     * 
     * @param Order $order
     */
    public function sendOrderNotification(Order $order): void
    {
        $text = "Новый заказ: " . $order->name . " " . $order->lastname . " - " . $order->product;

        try {
            $this->client->post("https://api.telegram.org/bot{$this->telegram_token}/sendMessage", [
                'form_params' => [
                    'chat_id' => $this->chat_id,
                    'text' => $text,
                ]
            ]);
        } catch (\Exception $e) {
            // Логгирование ошибки, если необходимо
        }
    }
}
