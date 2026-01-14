<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipPlanAccess extends Model
{
    protected $table = 'tip_plan_access';

    protected $fillable = [
        'tip_id',
        'service_plan_id',
    ];

    public function tip()
    {
        return $this->belongsTo(Tip::class);
    }

    public function plan()
    {
        return $this->belongsTo(ServicePlan::class, 'service_plan_id');
    }

    public function duration()
    {
        return $this->belongsTo(ServicePlanDuration::class, 'service_plan_duration_id');
    }
}
