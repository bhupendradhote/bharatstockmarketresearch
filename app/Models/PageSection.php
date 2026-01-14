<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PageSection extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'page_type',
        'section_key',
        'title',
        'subtitle',
        'badge',
        'slug',
        'description',
        'content',
        'button_1_text',
        'button_1_link',
        'button_2_text',
        'button_2_link',
        'meta_title',
        'meta_description',
        'sort_order',
        'status',
    ];
}
