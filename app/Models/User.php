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
    use HasFactory, Notifiable, HasRoles,HasApiTokens,InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'image', 'address', 'city',
        'state', 'pincode', 'country', 'role_id', 'dob', 'gender', 'marital_status',
        'blood_group', 'bio', 'language_preference', 'social_links', 'adhar_card', 
        'adhar_card_name', 'pan_card', 'pan_card_name', 'business_name', 'business_type',
        'business_document', 'education_institute', 'education_degree', 'education_document', 
        'website', 'linkedin', 'twitter', 'facebook', 'hobbies', 'skills',
        'emergency_contact_name', 'emergency_contact_phone'
    ];

            /**
             * The attributes that should be hidden for serialization.
             *
             * @var array<int, string>
             */
            protected $hidden = [
                'password', 'remember_token',
            ];

            /**
             * The attributes that should be cast.
             *
             * @var array<string, string>
             */
            protected $casts = [
                'email_verified_at' => 'datetime',
                'password' => 'hashed',
                'dob' => 'date',
                'social_links' => 'array',
            ];


            // Optional: Register media collections
            public function registerMediaCollections(): void
            {
                $this->addMediaCollection('profile')
                    ->singleFile() // If you want only one profile image per user
                    ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
            }
            
            // Optional: Register media conversions (thumbnails)
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

                    /**
                 * User ke bheje hue messages
                 */
                public function sentMessages()
                {
                    return $this->hasMany(ChatMessage::class, 'from_user_id');
                }

                /**
                 * User ko aaye hue messages
                 */
                public function receivedMessages()
                {
                    return $this->hasMany(ChatMessage::class, 'to_user_id');
                }



                /**
                 * User ko aayi hui notifications
                 */
                public function notifications()
                {
                    return $this->hasMany(NotificationUser::class, 'user_id');
                }

                /**
                 * User ne bheji hui notifications
                 */
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

                 /**
     * User has many invoices
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }




}
