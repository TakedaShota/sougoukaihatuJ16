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

    public ?int $userId;
    public ?string $guestId;
    public string $senderName;
    public ?string $message;
    public array $imageUrls;

    public function __construct(
        ?int $userId,
        ?string $guestId,
        string $senderName,
        ?string $message,
        array $imageUrls = []
    ) {
        $this->userId     = $userId;
        $this->guestId    = $guestId;
        $this->senderName = $senderName;
        $this->message    = $message;
        $this->imageUrls  = $imageUrls;
    }

    public function broadcastOn()
    {
        return new Channel('chat');
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        return [
            'userId'     => $this->userId,
            'guestId'    => $this->guestId,
            'senderName' => $this->senderName,
            'message'    => $this->message,
            'imageUrls'  => $this->imageUrls,
        ];
    }
}
