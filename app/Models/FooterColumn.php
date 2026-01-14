<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterColumn extends Model
{
    protected $fillable = [
        'title',
        'sort_order',
        'status',
    ];

    // A footer column has many links
    public function links()
    {
        return $this->hasMany(FooterLink::class)
                    ->orderBy('sort_order');
    }

    // Scope for active columns
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
