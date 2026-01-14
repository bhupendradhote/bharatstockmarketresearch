<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
      'category_id', 'title', 'slug', 'short_description', 'content', 'content_json', 
      'meta_title', 'meta_description', 'meta_keywords', 'reading_time', 'is_featured',
       'status', 'published_at', 'scheduled_for', 'view_count', 'like_count', 'share_count',
        'canonical_url', 'table_of_contents'

    ];

    protected $casts = [
        'content_json'       => 'array',
        'meta_keywords'      => 'array',
        'table_of_contents'  => 'array',
        'is_featured'        => 'boolean',
        'published_at'       => 'datetime',
        'scheduled_for'      => 'datetime',
        'view_count'         => 'integer',
        'like_count'         => 'integer',
        'share_count'        => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
