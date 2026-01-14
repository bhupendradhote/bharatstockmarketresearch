<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    protected $table = 'notification_users';

    protected $fillable = [
        'notification_id',
        'user_id',
        'read_at',
        'is_active',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Notification ka content
     */
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    /**
     * Receiver user (admin / user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
