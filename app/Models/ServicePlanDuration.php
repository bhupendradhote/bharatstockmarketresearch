<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePlanDuration extends Model
{
    protected $fillable = [
        'service_plan_id','duration','duration_days','price',
    ];

    public function plan()
    {
        return $this->belongsTo(ServicePlan::class, 'service_plan_id');
    }

    public function features()
    {
        return $this->hasMany(ServicePlanFeature::class);
    }
}
