<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'reason',
        'title',
        'message',
        'url',
        'sender_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Kisne notification bheji (admin / user / system)
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Ye notification kis-kis ko mili
     */
    public function recipients()
    {
        return $this->hasMany(NotificationUser::class, 'notification_id');
    }
}
