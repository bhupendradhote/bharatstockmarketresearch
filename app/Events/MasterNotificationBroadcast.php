<?php

namespace App\Events;

use App\Models\MasterNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MasterNotificationBroadcast implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $userId;
    public $isGlobal;

    public function __construct(MasterNotification $notification)
    {
        $this->notification = $notification;
        $this->userId = $notification->user_id;
        $this->isGlobal = $notification->is_global;
    }

    public function broadcastOn()
    {
        if ($this->isGlobal) {
            return new Channel('public-notifications');
        }

        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'master.notification';
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->notification->id,
            'type' => $this->notification->type,
            'severity' => $this->notification->severity,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'data' => $this->notification->data,
            'is_global' =>$this->notification->is_global,
            // 'created_at' => $this->notification->created_at->toDateTimeString(),
        ];
    }
}