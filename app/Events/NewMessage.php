<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $from_name;
    public $room_hash;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $from_name, $room_hash)
    {
        $this->message = $message;
        $this->from_name = $from_name;
        $this->room_hash = $room_hash;

        $this->dontBroadcastToCurrentUser();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Create a new Public Channel with Room hash in the name
        return new Channel('room-channel.'.$this->room_hash);
    }

    public function broadcastWith()
    {
        $this->message->name = $this->from_name;
        $this->message = array_except($this->message, array('created_at', 'updated_at'));

        return [ "message" => $this->message ];
    }
}
