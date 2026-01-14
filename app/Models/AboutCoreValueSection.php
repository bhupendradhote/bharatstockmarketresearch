<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutCoreValueSection extends Model
{
    protected $table = 'about_core_value_sections';

    protected $fillable = [
        'badge',
        'title',
        'subtitle',
        'description',
        'sort_order',
        'is_active',
    ];

    // Relationship: One section has many values
    public function values()
    {
        return $this->hasMany(AboutCoreValue::class, 'section_id')
                    ->orderBy('sort_order');
    }
}
