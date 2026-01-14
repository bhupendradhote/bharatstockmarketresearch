<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutCoreValue extends Model
{
    protected $table = 'about_core_values';

    protected $fillable = [
        'section_id',
        'icon',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    // Relationship: Value belongs to section
    public function section()
    {
        return $this->belongsTo(AboutCoreValueSection::class, 'section_id');
    }
}
