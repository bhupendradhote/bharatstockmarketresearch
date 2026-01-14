<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UserChatMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $fromUserId,
        public int $toUserId,
        public string $message
    ) {
        // 🔍 DEBUG: event fire hua ya nahi
        Log::info('🔥 UserChatMessageSent Fired', [
            'from' => $fromUserId,
            'to'   => $toUserId,
            'msg'  => $message,
        ]);
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->toUserId);
    }

    public function broadcastAs()
    {
        return 'user-chat-message';
    }
}
