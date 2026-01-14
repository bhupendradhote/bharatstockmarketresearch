<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorCharterPolicyLog extends Model
{
    use HasFactory;

    protected $table = 'investor_charter_policy_logs';

    protected $fillable = [
        'policy_id',
        'action',
        'remarks',
        'performed_by',
    ];

    /* ===============================
       Relationships
    =============================== */

    /**
     * Policy related to this log
     */
    public function policy()
    {
        return $this->belongsTo(InvestorCharterPolicy::class, 'policy_id');
    }

    /**
     * User who performed action
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
