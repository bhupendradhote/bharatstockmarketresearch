<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',             // flat | percent
        'value',
        'min_amount',
        'global_limit',
        'used_global',
        'per_user_limit',
        'expires_at',
        'active',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'active' => 'boolean',
    ];

    /* ===================== RELATIONS ===================== */

    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    /* ===================== SCOPES ===================== */

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>=', now());
        });
    }

    /* ===================== HELPERS ===================== */

    public function isExpired(): bool
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }

    public function isGlobalLimitReached(): bool
    {
        return $this->global_limit !== null
            && $this->used_global >= $this->global_limit;
    }

    public function calculateDiscount(float $amount): float
    {
        if ($this->type === 'flat') {
            return min($this->value, $amount);
        }

        return ($amount * $this->value) / 100;
    }

    public function isApplicableOn(float $amount): bool
    {
        if ($this->min_amount === null) return true;

        return $amount >= $this->min_amount;
    }
}