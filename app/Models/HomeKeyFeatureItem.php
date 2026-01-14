<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HomeKeyFeatureItem extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'home_key_feature_items';

    protected $fillable = [
        'section_id',
        'title',
        'sort_order',
        'is_active',
    ];

    /**
     * Relation with section
     */
    public function section()
    {
        return $this->belongsTo(HomeKeyFeatureSection::class, 'section_id');
    }

    /**
     * Spatie media collection
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('feature_images')
            ->singleFile(); // only one image per item
    }
}
