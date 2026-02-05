<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterNotificationRead extends Model
{
    use HasFactory;

    protected $table = 'master_notification_reads';

    protected $fillable = [
        'master_notification_id',
        'user_id',
        'read_at',
        'acknowledged_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'acknowledged_at' => 'datetime',
    ];

    /**
     * The notification this read belongs to
     */
    public function notification()
    {
        return $this->belongsTo(
            MasterNotification::class,
            'master_notification_id'
        );
    }

    /**
     * The user who read it
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}