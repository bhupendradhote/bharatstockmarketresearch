<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipCategory extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function tips()
    {
        return $this->hasMany(Tip::class, 'category_id');
    }
}
