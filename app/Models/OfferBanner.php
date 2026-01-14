<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit; // ✅ REQUIRED

class OfferBanner extends Model implements HasMedia
{
    use InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'slug',
        'heading',
        'sub_heading',
        'content',
        'highlight_text',

        'button1_text',
        'button1_link',
        'button1_target',

        'button2_text',
        'button2_link',
        'button2_target',

        'position',
        'is_active',
        'device_visibility',
        'start_date',
        'end_date',

        'view_count',
        'click_count',

        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'view_count' => 'integer',
        'click_count' => 'integer',
    ];

    /**
     * Media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('offer_banner_desktop')->singleFile();
        $this->addMediaCollection('offer_banner_mobile')->singleFile();
        $this->addMediaCollection('offer_banner_thumbnail')->singleFile();
    }

    /**
     * ✅ FIXED media conversions (Spatie v11+)
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('web')
            ->fit(Fit::Crop, 1920, 800)
            ->nonQueued();

        $this
            ->addMediaConversion('mobile')
            ->fit(Fit::Crop, 768, 1024)
            ->nonQueued();

        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Crop, 400, 200)
            ->nonQueued();
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrentlyVisible($query)
    {
        return $query
            ->where(fn ($q) =>
                $q->whereNull('start_date')->orWhere('start_date', '<=', now())
            )
            ->where(fn ($q) =>
                $q->whereNull('end_date')->orWhere('end_date', '>=', now())
            );
    }

    /**
     * Image helpers
     */
    public function getDesktopImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('offer_banner_desktop', 'web');
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('offer_banner_mobile', 'mobile');
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('offer_banner_thumbnail', 'thumb');
    }
}
