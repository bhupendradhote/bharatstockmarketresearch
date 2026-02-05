<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = [
        'user_id',
        'subject',
        'issue',
        'description',
        'priority',
        'status',
        'opened_at',
        'resolved_at',
        'resolution_days'
    ];

    // When admin opens ticket
    public function markOpen()
    {
        $this->status = 'Open';
        $this->opened_at = now();
        $this->save();
    }

    // When resolved
    public function markResolved()
    {
        $this->status = 'Resolved';
        $this->resolved_at = now();

        $start = $this->opened_at ?? $this->created_at;

        $this->resolution_days = $start->diffInDays(now());

        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}