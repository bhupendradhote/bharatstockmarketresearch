<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementNotification extends Model
{
    protected $table = 'announcement_notifications';

    protected $fillable = [
        'title',
        'type',
        'short_message',
        'detail',
        'published_at',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Admin/User who created announcement
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Users who have seen/read this announcement
     */
    public function users()
    {
        return $this->hasMany(
            AnnouncementNotificationUser::class,
            'announcement_notification_id'
        );
    }

    /**
     * Only unread users (useful for analytics)
     */
    public function unreadUsers()
    {
        return $this->hasMany(
            AnnouncementNotificationUser::class,
            'announcement_notification_id'
        )->whereNull('read_at');
    }
}