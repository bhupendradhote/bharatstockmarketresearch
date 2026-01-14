<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipUpdate extends Model
{
    protected $fillable = [
        'tip_id',
        'message',
        'price',
        'status_snapshot'
    ];

    public function tip()
    {
        return $this->belongsTo(Tip::class);
    }
}
