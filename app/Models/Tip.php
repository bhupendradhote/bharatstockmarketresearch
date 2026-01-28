<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    protected $fillable = [
        'tip_type',
        'parent_id',
        'stock_name',
        'symbol_token',
        'exchange',
        'call_type',
        'category_id',
        'entry_price',
        'target_price',
        'target_price_2',
        'stop_loss',
        'cmp_price',
        'expiry_date',    
        'strike_price',    
        'option_type',
        'status',
        'trade_status', // <--- Added this
        'version',
        'admin_note',
        'created_by'
    ];

    protected $attributes = [
        'status' => 'active',
        'trade_status' => 'Open', // Default attribute
        'version' => 1,
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(TipCategory::class, 'category_id');
    }

    public function planAccess()
    {
        return $this->hasMany(TipPlanAccess::class);
    }
}