<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageCampaignLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_campaign_id',
        'user_id',
        'delivered_at',
        'seen_at',
        'status',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'seen_at'      => 'datetime',
    ];

    /**
     * Relationship: campaign
     */
    public function campaign()
    {
        return $this->belongsTo(MessageCampaign::class, 'message_campaign_id');
    }

    /**
     * Relationship: user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark message as seen
     */
    public function markAsSeen(): void
    {
        if (!$this->seen_at) {
            $this->update([
                'seen_at' => now(),
                'status'  => 'seen',
            ]);
        }
    }
}
