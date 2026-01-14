<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePlanFeature extends Model
{
    protected $fillable = [
        'service_plan_duration_id','svg_icon','text',
    ];

    public function duration()
    {
        return $this->belongsTo(ServicePlanDuration::class, 'service_plan_duration_id');
    }
}
