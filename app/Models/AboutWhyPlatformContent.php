<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutWhyPlatformContent extends Model
{
    protected $table = 'about_why_platform_contents';

    protected $fillable = [
        'section_id',
        'content',
        'sort_order',
        'is_active',
    ];

    // Relationship: Paragraph belongs to section
    public function section()
    {
        return $this->belongsTo(AboutWhyPlatformSection::class, 'section_id');
    }
}
