<?php

namespace App\Events;

use App\Link;
use App\Room;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewLink implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $link;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Fetch Room the message was sent to
        $room = Room::where('id', $this->link->toRoom)->firstOrFail();
        
        // Create a new Public Channel with Room hash in the name
        return new Channel('room-channel.'.$room->hash);
    }

    public function broadcastWith()
    {

        // $user = User::where('id', $this->link->from)->firstOrFail();

        // $this->link->name = $user->name;

        return [ "link" => $this->link ];
    }
}
