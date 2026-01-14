<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

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
        'status',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'status' => 'boolean',
        'rating' => 'integer',
    ];

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
        $this
            ->addMediaCollection('review_images')
            ->singleFile(); // remove if you want multiple images
    }
}
