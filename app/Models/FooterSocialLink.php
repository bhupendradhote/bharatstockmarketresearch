<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSocialLink extends Model
{
    protected $fillable = [
        'label',
        'icon',
        'url',
        'sort_order',
        'status',
    ];

    // Scope for active icons
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
