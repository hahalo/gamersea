<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SomeEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    private $username;
    private $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($username, $message)
    {
        $this->username = $username;
        $this->message = $message;
    }
    public function broadcastWith()
    {
        return [
            'username' => $this->username,
            'message' => $this->message,
        ];
    }
    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['chat-channel'];
    }
}