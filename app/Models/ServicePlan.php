<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePlan extends Model
{
    protected $fillable = [
        'name', 'tagline','featured','status','sort_order','button_text',
    ];

    public function durations()
    {
        return $this->hasMany(ServicePlanDuration::class);
    }
}
