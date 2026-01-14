<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PolicyMaster extends Model
{
    protected $fillable = ['name', 'slug', 'title', 'description', 'is_enabled'];

    /**
     * Saare purane aur naye versions pane ke liye.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(PolicyContent::class, 'policy_master_id');
    }

    /**
     * Sirf wahi content jo abhi LIVE hai.
     */
    public function activeContent(): HasOne
    {
        return $this->hasOne(PolicyContent::class, 'policy_master_id')
                    ->where('is_active', true);
    }
}