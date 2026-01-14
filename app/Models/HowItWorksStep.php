<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HowItWorksStep extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'how_it_works_steps';

    protected $fillable = [
        'section_id',
        'short_title',
        'title',
        'description',
        'highlight_text',
        'icon',
        'link_text',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Step belongs to section
     */
    public function section()
    {
        return $this->belongsTo(HowItWorksSection::class, 'section_id');
    }

    /**
     * Spatie Media Collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('how_it_works_step')
             ->singleFile();
    }
}
