<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user1_id;
    public $user2_id;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user1_id, $user2_id, $message)
    {
        if ($user1_id < $user2_id) {
            $this->user1_id = $user1_id;
            $this->user2_id = $user2_id;
        } else {
            $this->user1_id = $user2_id;
            $this->user2_id = $user1_id;
        }
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Private Channel
        return new PrivateChannel(
            // チャンネル名はuser_idを小さい順に繋げたもの
            "channel-message-sent_between-{$this->user1_id}-and-{$this->user2_id}",
            $this->message
        );
    }
}
