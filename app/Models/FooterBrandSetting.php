<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterBrandSetting extends Model
{
    protected $fillable = [
        'title',
        'icon_svg',
        'description',
        
        // Future-proof fields
        'subtitle',
        'content',
        'note',
        'button_text',
        'button_link',
        'image',
        'status',
        'sort_order',
    ];

    /**
     * Scope for active brand blocks
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
