<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'user_subscription_id',
        'invoice_number',
        'amount',
        'currency',
        'payment_gateway',
        'payment_reference',
        'invoice_date',
        'service_start_date',
        'service_end_date',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'service_start_date' => 'date',
        'service_end_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }
      public function couponUsage()
    {
        return $this->hasOne(CouponUsage::class);
    }

    // (optional quick access)
    public function coupon()
    {
        return $this->hasOneThrough(
            Coupon::class,
            CouponUsage::class,
            'invoice_id',
            'id',
            'id',
            'coupon_id'
        );
    }
}
