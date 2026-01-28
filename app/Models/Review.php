<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;

class Review extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'rating',
        'review',
        'country',
        'state',
        'city',
        'status',      // 0: Pending, 1: Approved, 2: Rejected
        'is_featured',  // Boolean: Show on home page highlight
        'approved_at',  // When the admin clicked approve
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'status' => 'integer',    // Changed from boolean to integer for multiple states
        'is_featured' => 'boolean',
        'rating' => 'integer',
        'approved_at' => 'datetime',
    ];

    // --- SCOPES FOR EASY QUERIES ---

    /**
     * Scope to only get approved reviews
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    /**
     * Scope to only get featured reviews for the homepage
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)->where('status', 1);
    }

    /**
     * Relationship: Review belongs to a user (optional)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Media collections
     */
    public function registerMediaCollections(): void
    {
        // Collection for User Profile/Avatar within the review
        $this->addMediaCollection('avatar')->singleFile();

        // Collection for product/service images attached to review
        $this->addMediaCollection('review_images')->singleFile();
    }
}