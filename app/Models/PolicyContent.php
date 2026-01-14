<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PolicyContent extends Model
{
    protected $fillable = [
        'policy_master_id', 
        'content', 
        'updates_summary', 
        'version_number', 
        'is_active'
    ];

    /**
     * Content kis policy ka hai ye janne ke liye.
     */
    public function master(): BelongsTo
    {
        return $this->belongsTo(PolicyMaster::class, 'policy_master_id');
    }
}