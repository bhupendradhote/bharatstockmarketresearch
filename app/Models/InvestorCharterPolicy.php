<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorCharterPolicy extends Model
{
    use HasFactory;

    protected $table = 'investor_charter_policies';

    protected $fillable = [
        'title',
        'version',
        'effective_from',
        'effective_to',
        'is_active',
        'is_archived',
        'description',
    ];

    protected $casts = [
        'effective_from' => 'date',
        'effective_to'   => 'date',
        'is_active'      => 'boolean',
        'is_archived'    => 'boolean',
    ];

    /* ===============================
       Relationships
    =============================== */

    /**
     * Pages under this policy version
     */
    public function pages()
    {
        return $this->hasMany(InvestorCharterPage::class, 'policy_id')
            ->orderBy('page_order');
    }

    /**
     * Audit logs for this policy
     */
    public function logs()
    {
        return $this->hasMany(InvestorCharterPolicyLog::class, 'policy_id')
            ->latest();
    }

    /* ===============================
       Scopes
    =============================== */

    /**
     * Get only active policy
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('is_archived', false);
    }

    /**
     * Get archived policies
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    /* ===============================
       Helpers
    =============================== */

    /**
     * Activate this policy & archive others
     */
    public function activate()
    {
        static::where('id', '!=', $this->id)
            ->update([
                'is_active'   => false,
                'is_archived' => true,
            ]);

        $this->update([
            'is_active'   => true,
            'is_archived' => false,
            'effective_from' => now(),
        ]);
    }
}
