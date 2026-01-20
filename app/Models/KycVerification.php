<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycVerification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'digio_document_id',
        'customer_name',
        'customer_mobile',
        'customer_email',
        'reference_id',
        'transaction_id',
        'status',
        'kyc_details',
        'aadhaar_details',
        'kyc_completed_at',
        'kyc_expires_at',
        'raw_response',
        'callback_status',
        'callback_message'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'kyc_details' => 'array',
        'aadhaar_details' => 'array',
        'raw_response' => 'array',
        'kyc_completed_at' => 'datetime',
        'kyc_expires_at' => 'datetime'
    ];

    /**
     * Scope a query to only include approved KYC.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending KYC.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include failed KYC.
     */
    public function scopeFailed($query)
    {
        return $query->whereIn('status', ['failed', 'rejected', 'expired']);
    }

    /**
     * Scope a query to only include active (not expired) KYC.
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('kyc_expires_at')
              ->orWhere('kyc_expires_at', '>', now());
        });
    }

    /**
     * Scope a query to only include expired KYC.
     */
    public function scopeExpired($query)
    {
        return $query->where('kyc_expires_at', '<', now());
    }

    /**
     * Check if KYC is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if KYC is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if KYC is expired.
     */
    public function isExpired(): bool
    {
        return $this->kyc_expires_at && $this->kyc_expires_at < now();
    }

    /**
     * Check if KYC is active (approved and not expired).
     */
    public function isActive(): bool
    {
        return $this->isApproved() && !$this->isExpired();
    }

    /**
     * Get the Aadhaar number (masked if available).
     */
    public function getAadhaarNumberAttribute()
    {
        if (isset($this->aadhaar_details['masked_aadhaar'])) {
            return $this->aadhaar_details['masked_aadhaar'];
        }
        
        if (isset($this->aadhaar_details['aadhaar_number'])) {
            return $this->aadhaar_details['aadhaar_number'];
        }
        
        return null;
    }

    /**
     * Get the customer's full name from Aadhaar.
     */
    public function getFullNameAttribute()
    {
        return $this->aadhaar_details['name'] ?? $this->customer_name;
    }

    /**
     * Get the customer's date of birth.
     */
    public function getDateOfBirthAttribute()
    {
        return $this->aadhaar_details['date_of_birth'] ?? null;
    }

    /**
     * Get the customer's gender.
     */
    public function getGenderAttribute()
    {
        return $this->aadhaar_details['gender'] ?? null;
    }

    /**
     * Get the customer's address.
     */
    public function getAddressAttribute()
    {
        return $this->aadhaar_details['address'] ?? null;
    }

    /**
     * Get the KYC status with color for UI.
     */
    public function getStatusWithColorAttribute()
    {
        $statusColors = [
            'approved' => 'success',
            'pending' => 'warning',
            'failed' => 'danger',
            'rejected' => 'danger',
            'expired' => 'secondary'
        ];

        return [
            'text' => ucfirst($this->status),
            'color' => $statusColors[$this->status] ?? 'secondary'
        ];
    }

    /**
     * Get KYC age in days.
     */
    public function getAgeInDaysAttribute()
    {
        if (!$this->kyc_completed_at) {
            return null;
        }

        return $this->kyc_completed_at->diffInDays(now());
    }

    /**
     * Get days until expiry.
     */
    public function getDaysUntilExpiryAttribute()
    {
        if (!$this->kyc_expires_at) {
            return null;
        }

        return now()->diffInDays($this->kyc_expires_at, false);
    }

    /**
     * Approve this KYC.
     */
    public function approve(array $kycDetails = [], array $aadhaarDetails = [])
    {
        $this->update([
            'status' => 'approved',
            'kyc_details' => $kycDetails,
            'aadhaar_details' => $aadhaarDetails,
            'kyc_completed_at' => now()
        ]);

        return $this;
    }

    /**
     * Reject this KYC.
     */
    public function reject(string $reason = null)
    {
        $this->update([
            'status' => 'rejected',
            'kyc_completed_at' => now()
        ]);

        if ($reason) {
            // Store rejection reason
            $this->update([
                'callback_message' => $reason
            ]);
        }

        return $this;
    }

    /**
     * Mark KYC as failed.
     */
    public function markAsFailed(string $error = null)
    {
        $this->update([
            'status' => 'failed',
            'kyc_completed_at' => now()
        ]);

        if ($error) {
            $this->update([
                'callback_message' => $error
            ]);
        }

        return $this;
    }

    /**
     * Check if mobile number already has approved KYC.
     */
    public static function hasApprovedKyc(string $mobile): bool
    {
        return self::where('customer_mobile', $mobile)
            ->approved()
            ->active()
            ->exists();
    }

    /**
     * Get latest approved KYC for a mobile number.
     */
    public static function getLatestApprovedKyc(string $mobile)
    {
        return self::where('customer_mobile', $mobile)
            ->approved()
            ->active()
            ->latest('kyc_completed_at')
            ->first();
    }

    /**
     * Find KYC by Digio document ID.
     */
    public static function findByDocumentId(string $documentId)
    {
        return self::where('digio_document_id', $documentId)->first();
    }

    /**
     * Find KYC by reference ID.
     */
    public static function findByReferenceId(string $referenceId)
    {
        return self::where('reference_id', $referenceId)->first();
    }

    /**
     * Get all KYC records for a customer.
     */
    public static function getAllForCustomer(string $mobile)
    {
        return self::where('customer_mobile', $mobile)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}