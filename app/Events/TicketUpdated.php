<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class TicketUpdated implements ShouldBroadcastNow
{
    use SerializesModels;

    public $ticket;

    public function __construct(Ticket $ticket)
    {
        // reload fresh to include timestamps + status
        $this->ticket = $ticket->fresh();
        $this->ticket = $ticket->toArray();

        // 3. Spatie Media URL manually add karein (Ye Pusher mein dikhega)
        $this->ticket['image_url'] = $ticket->getFirstMediaUrl('tickets');
    }

    public function broadcastOn()
    {
        return new Channel('tickets');
    }

    public function broadcastAs()
    {
        return 'ticket.updated';
    }
}