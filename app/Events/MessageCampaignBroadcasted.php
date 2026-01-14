<?php

namespace App\Events;

use App\Models\MessageCampaign;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class MessageCampaignBroadcasted implements ShouldBroadcastNow
{
    use SerializesModels;

    public $campaign;

    public function __construct(MessageCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    // ✅ PUBLIC CHANNEL (NO AUTH)
    public function broadcastOn(): Channel
    {
        return new Channel('all-users');
    }

    public function broadcastAs(): string
    {
        return 'message.campaign.sent';
    }

   public function broadcastWith(): array
{
    return [
        'id'          => $this->campaign->id,
        'title'       => $this->campaign->title,
        'description' => $this->campaign->description,
        'message'     => $this->campaign->message,
        'content'     => $this->campaign->content,
        'type'        => $this->campaign->type,
        'image'       => $this->campaign->image, // 🔑 IMAGE URL
    ];
}

}
