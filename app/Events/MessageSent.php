<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $senderId;
    public string $senderName;
    public ?string $message;
    public array $imageUrls;

    public function __construct($message, $senderId, $senderName, $imageUrls = [])
{
    $this->message = $message;
    $this->senderId = $senderId;
    $this->senderName = $senderName;
    $this->imageUrls = $imageUrls;
}

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }
}


