<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon_svg',
        'title',
        'slug',
        'link',
        'order_no',
        'show_in_header',
        'status',
    ];

    /**
     * Scope for only active & visible header menus
     */
    public function scopeVisible($query)
    {
        return $query->where('status', 1)->where('show_in_header', 1);
    }

    /**
     * Always order by order_no
     */
    protected static function booted()
    {
        static::addGlobalScope('order', function ($query) {
            $query->orderBy('order_no', 'asc');
        });
    }

    public function header()
{
    return $this->belongsTo(HeaderSetting::class);
}

}
