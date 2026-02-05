<?php

namespace App\Events;

use App\Models\AnnouncementNotification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnnouncementPublished implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $announcement;

    // ✅ Now expects AnnouncementNotification
    public function __construct(AnnouncementNotification $announcement)
    {
        $this->announcement = $announcement;
    }

    public function broadcastOn()
    {
        return new Channel('announcements');
    }

    public function broadcastAs()
    {
        return 'announcement.new';
    }
}