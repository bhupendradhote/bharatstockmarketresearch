<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * All fields except 'id' and 'timestamps' are included here.
     */
    protected $fillable = [
        'user_id',
        'certificate_name',
        'certificate_number',
        'issued_by',
        'issue_date',
        'expiry_date',
        'file_path',
        'file_extension',
        'description',
        'status',
    ];

    /**
     * Dates casting to professional carbon instances
     */
    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Relationship: A Certificate belongs to a User.
     * This helps in getting the owner of the certificate easily.
     */
  /**
 * Get the user that owns the certificate.
 */
public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(User::class);
}
}