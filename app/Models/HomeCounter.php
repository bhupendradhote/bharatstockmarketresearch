<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeCounter extends Model
{
    protected $fillable = [
        'value',
        'description',
        'sort_order',
        'is_active',
    ];
}
