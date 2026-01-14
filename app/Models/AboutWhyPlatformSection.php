<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutWhyPlatformSection extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'about_why_platform_sections';

    protected $fillable = [
        'badge',
        'heading',
        'subheading',
        'closing_text',
        'sort_order',
        'is_active',
    ];

    // MEDIA COLLECTION
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('why_platform_image')
             ->singleFile();
    }

    // RELATION
    public function contents()
    {
        return $this->hasMany(AboutWhyPlatformContent::class, 'section_id')
                    ->orderBy('sort_order');
    }
}
