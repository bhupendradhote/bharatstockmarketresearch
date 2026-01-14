<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'category_id', 
        // 'user_id',
        'title', 
        'slug', 
        'short_description', 
        'content', 
        'content_json', 
        'news_type', 
        'location', 
        'source_name', 
        'source_url', 
        'video_url',
        'meta_title', 
        'meta_description', 
        'meta_keywords', 
        'reading_time', 
        'is_featured',
        'is_trending',
        'status', 
        'published_at', 
        'scheduled_for', 
        'view_count', 
        'like_count', 
        'share_count',
        'priority_weight',
        'canonical_url', 
        'table_of_contents'
    ];

    protected $casts = [
        'content_json'       => 'array',
        'meta_keywords'      => 'array',
        'table_of_contents'  => 'array',
        'is_featured'        => 'boolean',
        'is_trending'        => 'boolean',
        'published_at'       => 'datetime',
        'scheduled_for'      => 'datetime',
        'view_count'         => 'integer',
        'like_count'         => 'integer',
        'share_count'        => 'integer',
        'priority_weight'    => 'integer',
    ];

    /**
     * Relationship: News kis category ki hai.
     */
    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }

    /**
     * Relationship: Kis user/author ne news likhi hai.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for Published News: Sirf vahi news jo public hain.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
}