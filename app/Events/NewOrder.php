<?php

namespace App\Events;

use App\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewOrder implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('order');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->order->id,
            'user_id' => $this->order->user_id,
            'address_id' => $this->order->address_id,
            'branch_id' => $this->order->branch_id,
            'delivery_type' => $this->order->delivery_type,
            'status_id' => $this->order->status_id,
            'total_amount' => $this->order->total_amount,
            'amount' => $this->order->amount,
            'tax' => $this->order->tax,
            'promo_code_id' => $this->order->promo_code_id,
            'discount' => $this->order->discount,
            'discount_type' => $this->order->discount_type,
            'created_at' => $this->order->created_at,
            'user' => $this->order->User,
            'branch' => $this->order->Branch,
            'address' => $this->order->Address,
            'details' => $this->order->details,
            'status' => $this->order->Status,
        ];
    }
}
