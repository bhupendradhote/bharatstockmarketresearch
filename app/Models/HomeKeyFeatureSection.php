<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeKeyFeatureSection extends Model
{
    protected $table = 'home_key_feature_sections';

    protected $fillable = [
        'heading',
        'description',
        'is_active',
    ];

    /**
     * One section has many feature items
     */
    public function items()
    {
        return $this->hasMany(HomeKeyFeatureItem::class, 'section_id')
            ->orderBy('sort_order');
    }
}
