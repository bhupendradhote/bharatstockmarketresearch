<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterNotification extends Model
{
    use HasFactory;

    protected $table = 'master_notifications';

    protected $fillable = [
        'type',
        'severity',
        'title',
        'message',
        'data',
        'user_id',
        'is_global',
        'channel',
        'expires_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_global' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * If notification is for a single user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Who has read this notification
     */
    public function reads()
    {
        return $this->hasMany(MasterNotificationRead::class, 'master_notification_id');
    }
    

    /**
     * Quick check if user has seen it
     */
    public function isReadBy($userId)
    {
        return $this->reads()->where('user_id', $userId)->exists();
    }
}