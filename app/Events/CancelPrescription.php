<?php

namespace App\Events;

use App\Prescription;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CancelPrescription implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $prescription;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Prescription $prescription)
    {
        $this->prescription = $prescription;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('cancel.prescription.'.$this->prescription->id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->prescription->id,
            'user' => $this->prescription->User,
            'address' => $this->prescription->Address,
            'attachment' => $this->prescription->attachment,
            'notes' => $this->prescription->notes,
            'monthly' => $this->prescription->monthly,
            'created_at' => $this->prescription->created_at,
        ];
    }
}
