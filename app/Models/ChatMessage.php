<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chat_messages';

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'is_read',
        'message',
        'from_role',
    ];

    /**
     * Message bhejne wala user
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    /**
     * Message receive karne wala user
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
