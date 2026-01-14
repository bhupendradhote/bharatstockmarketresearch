<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Package extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'packages';

    protected $fillable = [
        'package_type',       // optional category type
        'name',
        'slug',
        'description',
        'features',
        'amount',
        'discount_percentage',
        'discount_amount',
        'final_amount',
        'trial_days',
        'duration',
        'validity_type',
        'meta_title',
        'meta_description',
        'is_featured',
        'status',
        'max_devices',
        'telegram_support',
        'sort_order',
    ];

    protected $casts = [
        'features'            => 'array',
        'is_featured'         => 'boolean',
        'status'              => 'boolean',
        'amount'              => 'decimal:2',
        'discount_amount'     => 'decimal:2',
        'discount_percentage' => 'integer',
        'final_amount'        => 'decimal:2',
        'trial_days'          => 'integer',
        'duration'            => 'integer',
        'max_devices'         => 'integer',
        'telegram_support'    => 'boolean',
        'sort_order'          => 'integer',
    ];

    /**
     * Register Media Collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }

    /**
     * Optional: Media conversions
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10);
    }

    /**
     * Accessor for final price
     */
    public function getFinalPriceAttribute()
    {
        if ($this->discount_amount > 0) {
            return $this->amount - $this->discount_amount;
        }

        if ($this->discount_percentage > 0) {
            return $this->amount - ($this->amount * ($this->discount_percentage / 100));
        }

        return $this->amount;
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('image');
    }

    /**
     * Relationship with PackageCategory (if needed)
     */
    public function category()
    {
        return $this->belongsTo(PackageCategory::class, 'package_type', 'name');
    }

    /**
     * Scope for featured packages
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
