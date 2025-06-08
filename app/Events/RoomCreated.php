<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    public function broadcastOn()
    {
        return new Channel('rooms');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->room->id,
            'title' => $this->room->title,
            'price' => $this->room->price,
            'address' => $this->room->address,
            'created_at' => $this->room->created_at->toDateTimeString()
        ];
    }
} 