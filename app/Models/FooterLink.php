<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    protected $fillable = [
        'footer_column_id',
        'label',
        'url',
        'sort_order',
        'status',
    ];

    // Belongs to a footer column
    public function column()
    {
        return $this->belongsTo(FooterColumn::class);
    }

    // Scope for active links
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
