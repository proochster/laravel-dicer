<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PauseVideo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roomHash;
    public $videoUrl;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($roomHash, $videoUrl)
    {
        $this->roomHash = $roomHash;
        $this->videoUrl = $videoUrl;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('room-channel.'.$this->roomHash);
    }

    public function broadcastWith()
    {
        return [ "videoUrl" => $this->videoUrl ];
    }
}
