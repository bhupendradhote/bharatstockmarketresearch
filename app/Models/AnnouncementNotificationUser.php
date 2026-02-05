<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementNotificationUser extends Model
{
    protected $table = 'announcement_notification_users';

    protected $fillable = [
        'announcement_notification_id',
        'user_id',
        'read_at',
        'is_seen',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'is_seen' => 'boolean',
    ];

    /**
     * Which announcement
     */
    public function announcement()
    {
        return $this->belongsTo(
            AnnouncementNotification::class,
            'announcement_notification_id'
        );
    }

    /**
     * Which user read it
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}