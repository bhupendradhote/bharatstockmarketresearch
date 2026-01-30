<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Watchlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    /**
     * Get the scripts associated with the watchlist.
     */
    public function scripts() 
    {
        return $this->hasMany(WatchlistScript::class);
    }
}