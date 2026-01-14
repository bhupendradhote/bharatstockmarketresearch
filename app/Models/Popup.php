<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Popup extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'content_type',
        'content',
        'image',
        'button_text',
        'button_url',
        'is_dismissible',
        'priority',
        'status',
    ];
}
