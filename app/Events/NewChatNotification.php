<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewChatNotification implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $fromUserId;
    public $fromUserName;
    public $message;
    public $toUserId;

    public function __construct(
        int $fromUserId,
        string $fromUserName,
        string $message,
        int $toUserId
    ) {
        $this->fromUserId = $fromUserId;
        $this->fromUserName = $fromUserName;
        $this->message = $message;
        $this->toUserId = $toUserId;
        
        Log::info('🔥 NewChatNotification Fired', [
            'from' => $fromUserId,
            'to'   => $toUserId,
            'msg'  => $message,
        ]);
    }

    public function broadcastOn()
    {
        // Broadcast to admin's private channel
        return new PrivateChannel('user.' . $this->toUserId);
    }

    public function broadcastAs()
    {
        return 'user-chat-notification';
    }
    
    public function broadcastWith()
    {
        return [
            'fromUserId' => $this->fromUserId,
            'fromUserName' => $this->fromUserName,
            'message' => $this->message,
            'toUserId' => $this->toUserId,
        ];
    }
}