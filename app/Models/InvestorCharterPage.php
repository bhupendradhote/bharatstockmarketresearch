<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorCharterPage extends Model
{
    use HasFactory;

    protected $table = 'investor_charter_pages';

    protected $fillable = [
        'policy_id',
        'page_title',
        'page_slug',
        'content',
        'page_order',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];

    /* ===============================
       Relationships
    =============================== */

    /**
     * Belongs to a policy version
     */
    public function policy()
    {
        return $this->belongsTo(InvestorCharterPolicy::class, 'policy_id');
    }

    /* ===============================
       Scopes
    =============================== */

    /**
     * Visible pages only
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }
}
