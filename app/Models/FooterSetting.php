<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $fillable = [
        'email',
        'address',
        'phone',
        'copyright_text',
    ];
}
