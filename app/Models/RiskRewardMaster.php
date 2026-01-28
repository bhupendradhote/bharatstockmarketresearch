<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RiskRewardMaster extends Model
{
    protected $table = 'risk_reward_masters';

    protected $fillable = [
        'calculation_type',
        'target1_value',
        'target2_value',
        'stoploss_value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'target1_value' => 'float',
        'target2_value' => 'float',
        'stoploss_value' => 'float',
    ];

    /**
     * Scope: only active master
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the single active master (GLOBAL)
     */
    public static function getActive(): ?self
    {
        return self::active()->first();
    }

    /**
     * Activate this master and deactivate others
     */
    public function activate(): void
    {
        self::where('is_active', true)->update(['is_active' => false]);

        $this->is_active = true;
        $this->save();
    }

    /**
     * Calculate Target 1, Target 2, Stop Loss
     *
     * @param float  $entryPrice
     * @param string $callType  BUY | SELL
     *
     * @return array
     */
    public function calculate(float $entryPrice, string $callType): array
    {
        $callType = strtoupper($callType);

        if ($this->calculation_type === 'percentage') {
            return $this->calculatePercentage($entryPrice, $callType);
        }

        return $this->calculatePrice($entryPrice, $callType);
    }

    /**
     * Percentage based calculation
     */
    protected function calculatePercentage(float $entry, string $callType): array
    {
        if ($callType === 'BUY') {
            return [
                'target1' => round($entry + ($entry * $this->target1_value / 100), 2),
                'target2' => $this->target2_value
                    ? round($entry + ($entry * $this->target2_value / 100), 2)
                    : null,
                'stoploss' => round($entry - ($entry * $this->stoploss_value / 100), 2),
            ];
        }

        // SELL
        return [
            'target1' => round($entry - ($entry * $this->target1_value / 100), 2),
            'target2' => $this->target2_value
                ? round($entry - ($entry * $this->target2_value / 100), 2)
                : null,
            'stoploss' => round($entry + ($entry * $this->stoploss_value / 100), 2),
        ];
    }

    /**
     * Fixed price based calculation
     */
    protected function calculatePrice(float $entry, string $callType): array
    {
        if ($callType === 'BUY') {
            return [
                'target1' => round($entry + $this->target1_value, 2),
                'target2' => $this->target2_value
                    ? round($entry + $this->target2_value, 2)
                    : null,
                'stoploss' => round($entry - $this->stoploss_value, 2),
            ];
        }

        // SELL
        return [
            'target1' => round($entry - $this->target1_value, 2),
            'target2' => $this->target2_value
                ? round($entry - $this->target2_value, 2)
                : null,
            'stoploss' => round($entry + $this->stoploss_value, 2),
        ];
    }
}
