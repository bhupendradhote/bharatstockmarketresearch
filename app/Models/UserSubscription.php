<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    /* ===============================
     * 🔓 MASS ASSIGNABLE FIELDS
     * =============================== */
    protected $fillable = [
        'user_id',
        'service_plan_id',
        'service_plan_duration_id',

        // Subscription period
        'start_date',
        'end_date',
        'status',
        'is_auto_renew',

        // Payment basics
        'amount',
        'currency',
        'payment_gateway',
        'payment_reference',

        // Razorpay fields
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'payment_status',

        // Raw payment response
        'payment_payload',
    ];

    /* ===============================
     * 🧬 TYPE CASTING
     * =============================== */
    protected $casts = [
        'start_date'      => 'date',
        'end_date'        => 'date',
        'is_auto_renew'   => 'boolean',
        'amount'          => 'decimal:2',
        'payment_payload' => 'array',
    ];

    /* ===============================
     * 🔗 RELATIONSHIPS
     * =============================== */

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
        return $this->belongsTo(
            ServicePlanDuration::class,
            'service_plan_duration_id'
        );
    }

    /* ===============================
     * 🧠 BUSINESS HELPERS
     * =============================== */

    /**
     * Is subscription active?
     */
    // public function isActive(): bool
    // {
    //     return $this->status === 'active'
    //         && $this->payment_status === 'paid'
    //         && now()->lte($this->end_date);
    // }
    public function isActive(): bool
{
    return $this->status === 'active'
        && in_array($this->payment_status, ['paid', 'demo'])
        && now()->lte($this->end_date);
}

    public function isDemo(): bool
{
    return $this->status === 'active' &&
    $this->payment_status === 'demo';
}

    /**
     * Is subscription expired?
     */
    public function isExpired(): bool
    {
        return now()->gt($this->end_date);
    }

    /**
     * Is payment completed?
     */
    public function isPaymentSuccessful(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Mark subscription as paid (after Razorpay verify)
     */
    public function markAsPaid(array $razorpayData = []): void
    {
        $this->update([
            'payment_status'       => 'paid',
            'razorpay_payment_id'  => $razorpayData['razorpay_payment_id'] ?? null,
            'razorpay_signature'   => $razorpayData['razorpay_signature'] ?? null,
            'payment_payload'      => $razorpayData,
            'status'               => 'active',
        ]);
    }

    /**
     * Mark subscription as failed
     */
    public function markAsFailed(array $payload = []): void
    {
        $this->update([
            'payment_status'  => 'failed',
            'payment_payload' => $payload,
            'status'          => 'cancelled',
        ]);
    }

        /**
     * Subscription has many invoices
     */
    public function invoices()
    {
        return $this->hasMany(
            Invoice::class,
            'user_subscription_id'
        );
    }
}
