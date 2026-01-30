<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WatchlistScript extends Model
{
    use HasFactory;

    protected $table = 'watchlist_scripts';

    protected $fillable = [
        'watchlist_id',
        'symbol',
        'trading_symbol',
        'token',
        'exchange',
        'ltp',
        'net_change',
        'percent_change',
        'is_positive',
    ];

    /**
     * Get the watchlist that owns the script.
     */
    public function watchlist() 
    {
        return $this->belongsTo(Watchlist::class);
    }
}