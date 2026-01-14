<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news_categories';

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'color_code', 
        'icon', 
        'is_active', 
        'order_priority', 
        'meta_title', 
        'meta_description'
    ];

    /**
     * Relationship: Ek Category me bahut saari News ho sakti hain.
     */
    public function news()
    {
        return $this->hasMany(News::class, 'category_id');
    }
}