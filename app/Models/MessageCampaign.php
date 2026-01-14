<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MessageCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'message',
        'image',  
        'content',
        'type',
        'is_active',
        'starts_at',
        'ends_at',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    /**
     * Relationship: campaign logs
     */
    public function logs()
    {
        return $this->hasMany(MessageCampaignLog::class);
    }

    /**
     * Scope: only active campaigns
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: currently valid (date based)
     */
    public function scopeCurrentlyVisible(Builder $query)
    {
        return $query
            ->where(function ($q) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', now());
            });
    }
}
