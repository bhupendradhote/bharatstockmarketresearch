<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    protected $fillable = [
        'website_name',
        'logo_svg',
        'button_text',
        'button_link',
        'button_active'
    ];

    public function menus()
    {
        return $this->hasMany(HeaderMenu::class)->orderBy('order_no');
    }
}
