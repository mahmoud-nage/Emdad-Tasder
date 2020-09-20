<?php

namespace App\Events;

use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notificaiton;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notificaiton)
    {
        $this->notificaiton = $notificaiton;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notification');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->notificaiton->id,
            'title' => $this->notificaiton->title,
            'body' => $this->notificaiton->body,
            'created_at' => $this->notificaiton->created_at->toDateString(),
            'conversation' => $this->notificaiton->Conversation
        ];
    }
}
