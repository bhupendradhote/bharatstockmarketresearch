<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'content',
        'detail',
        'published_at',
        'is_active'
    ];

    // Optional: Cast published_at to datetime object
    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
