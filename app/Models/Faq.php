<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'page_type',
        'page_slug',
        'question',
        'answer',
        'status',
        'sort_order',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope: Active FAQs only
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope: Page wise FAQs
     */
    public function scopeForPage($query, string $pageType, ?string $pageSlug = null)
    {
        return $query
            ->where('page_type', $pageType)
            ->when($pageSlug, function ($q) use ($pageSlug) {
                $q->where('page_slug', $pageSlug);
            });
    }
}
