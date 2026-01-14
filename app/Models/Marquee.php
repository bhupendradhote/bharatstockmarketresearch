<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marquee extends Model
{
    use HasFactory;

    protected $table = 'marquees';

    protected $fillable = [
        'title',
        'description',
        'content',
        'is_active',
        'start_at',
        'end_at',
        'display_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_at'  => 'datetime',
        'end_at'    => 'datetime',
    ];

    /**
     * Scope: Active marquee for frontend
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_at')
                  ->orWhere('start_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_at')
                  ->orWhere('end_at', '>=', now());
            });
    }
}
