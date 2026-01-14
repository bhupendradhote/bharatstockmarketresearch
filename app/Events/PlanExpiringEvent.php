<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlanExpiringEvent implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $message;
    public $userId;
    public $daysLeft;

public function __construct($userId, $daysLeft)
{
    $this->userId = $userId;
    // Logic: Agar days 0 hain toh 'today' dikhao, warna number of days
    $timeString = ($daysLeft == 0) ? "today" : "$daysLeft day(s)";
    $this->message = "Alert: Your plan expires $timeString!";
}

    public function broadcastOn()
    {
        // Make sure the channel name matches what Pusher is showing
        return new PrivateChannel('user.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'plan.expiring';
    }

    // Add this method to ensure proper data structure
    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'daysLeft' => $this->daysLeft,
            'userId' => $this->userId
        ];
    }
}