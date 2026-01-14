<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HowItWorksSection extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'how_it_works_sections';

    protected $fillable = [
        'badge',
        'heading',
        'sub_heading',
        'description',
        'cta_text',
        'cta_url',
        'alignment',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * One section has many steps
     */
    public function steps()
    {
        return $this->hasMany(HowItWorksStep::class, 'section_id')
                    ->orderBy('sort_order');
    }

    /**
     * Spatie Media Collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('how_it_works_section')
             ->singleFile();
    }
}
