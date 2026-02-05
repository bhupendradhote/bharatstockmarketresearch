<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CouponUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'user_id',   
        'invoice_id',
        'times_used',
    ];

    /* ===================== RELATIONS ===================== */

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /* ===================== HELPERS ===================== */

    public function canUseMore(int $limit): bool
    {
        return $this->times_used < $limit;
    }
}