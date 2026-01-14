<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class WhyChooseSection extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'badge',
        'heading',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('why_choose_image')->singleFile();
    }
}
