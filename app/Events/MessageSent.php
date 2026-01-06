<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use SerializesModels;

    public string $message;
    public string $senderId;
    public string $senderName;

    public function __construct(string $message, string $senderId, string $senderName)
    {
        $this->message    = $message;
        $this->senderId   = $senderId;
        $this->senderName = $senderName;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat');
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'message'    => $this->message,
            'senderId'   => $this->senderId,
            'senderName' => $this->senderName,
        ];
    }
}
