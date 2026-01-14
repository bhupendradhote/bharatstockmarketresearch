<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DownloadAppSection extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'download_app_section';

    protected $fillable = [
        'page_key',    
        'title',
        'heading',
        'description',
        'is_active',
    ];

    /**
     * Single image using Spatie Media Library
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile();
    }
}
