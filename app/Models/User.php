<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Models\ChatMessage;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'image', 'address', 'city',
        'state', 'pincode', 'country', 'role_id', 'dob', 'gender', 'marital_status',
        'blood_group', 'bio', 'language_preference', 'social_links', 'adhar_card', 
        'adhar_card_name', 'pan_card', 'pan_card_name', 'business_name', 'business_type',
        'business_document', 'education_institute', 'education_degree', 'education_document', 
        'website', 'linkedin', 'twitter', 'facebook', 'hobbies', 'skills',
        'emergency_contact_name', 'emergency_contact_phone',
        'bsmr_id' 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dob' => 'date',
        'social_links' => 'array',
    ];


    protected static function boot()
        {
            parent::boot();

            static::creating(function ($user) {
                if (empty($user->bsmr_id)) {
                    $datePrefix = date('Ymd');

                    $lastUser = self::whereNotNull('bsmr_id')
                                    ->orderBy('id', 'desc')
                                    ->first();

                    if ($lastUser) {
                        $parts = explode('-', $lastUser->bsmr_id);
                        
                        if (isset($parts[1])) {
                            $sequence = intval($parts[1]) + 1;
                        } else {
                            $sequence = 1;
                        }
                    } else {
                        $sequence = 1;
                    }

                    $user->bsmr_id = $datePrefix . '-' . str_pad($sequence, 2, '0', STR_PAD_LEFT);
                }
            });
        }

    // --- MEDIA ---

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')
            ->singleFile() 
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }
            
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->nonQueued();
            
        $this->addMediaConversion('medium')
            ->width(300)
            ->height(300)
            ->nonQueued();
    }

    // --- RELATIONSHIPS ---

    public function sentMessages()
    {
        return $this->hasMany(ChatMessage::class, 'from_user_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(ChatMessage::class, 'to_user_id');
    }

    public function notifications()
    {
        return $this->hasMany(NotificationUser::class, 'user_id');
    }
  
    public function sentNotifications()
    {
        return $this->hasMany(Notification::class, 'sender_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now());
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function kycVerification()
    {
        return $this->hasOne(\App\Models\KycVerification::class);
    }
public function watchlists()
{
    return $this->hasMany(Watchlist::class);
}
}
