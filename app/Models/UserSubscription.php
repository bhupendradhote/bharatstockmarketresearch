<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_plan_id',
        'service_plan_duration_id',
        'start_date',
        'end_date',
        'status',
        'is_auto_renew',
        'payment_reference',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_auto_renew' => 'boolean',
    ];

    /* ===================== RELATIONS ===================== */

    /**
     * Subscription belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Subscription belongs to a service plan
     */
    public function plan()
    {
        return $this->belongsTo(ServicePlan::class, 'service_plan_id');
    }

    /**
     * Subscription belongs to a plan duration
     */
    public function duration()
    {
        return $this->belongsTo(ServicePlanDuration::class, 'service_plan_duration_id');
    }

    /* ===================== HELPERS (OPTIONAL) ===================== */

    /**
     * Check if subscription is active
     */
    public function isActive()
    {
        return $this->status === 'active' && now()->lte($this->end_date);
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired()
    {
        return now()->gt($this->end_date);
    }
}
