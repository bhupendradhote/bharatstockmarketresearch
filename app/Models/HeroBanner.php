<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class HeroBanner extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'page_key',
        'badge',
        'title',
        'subtitle',
        'description',
        'button_text_1',
        'button_link_1',
        'button_text_2',
        'button_link_2',
        // kept for backward compatibility
        'background_image',
        'mobile_background_image',
        'overlay_color',
        'text_color',
        'alignment',
        'vertical_position',
        'overlay_opacity',
        'show_badge',
        'show_buttons',
        'sort_order',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'show_badge' => 'boolean',
        'show_buttons' => 'boolean',
        'status' => 'boolean',
    ];

    // helper to get first media url for background image collection
    public function backgroundUrl($conversion = null)
    {
        if ($this->getFirstMediaUrl('background')) {
            return $this->getFirstMediaUrl('background', $conversion);
        }
        // fallback to DB field if present
        return $this->background_image ? asset($this->background_image) : null;
    }

    public function mobileBackgroundUrl($conversion = null)
    {
        if ($this->getFirstMediaUrl('mobile_background')) {
            return $this->getFirstMediaUrl('mobile_background', $conversion);
        }
        return $this->mobile_background_image ? asset($this->mobile_background_image) : null;
    }
}
