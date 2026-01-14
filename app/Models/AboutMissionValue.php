<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutMissionValue extends Model
{
    protected $table = 'about_mission_values';

    protected $fillable = [
        'badge',
        'title',
        'mission_text',
        'short_description',
        'sort_order',
        'is_active',
    ];
}
