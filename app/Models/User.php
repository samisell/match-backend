<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'location',
        'occupation',
        'education',
        'quote',
        'profile_summary',
        'interests',
        'is_admin', // Make is_admin fillable
        'matched', // Make matched fillable
        'otp',
        'otp_expires_at',
    ];

    /**
     * Get all of the tags for the user.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'interests' => 'array',
        'otp_expires_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $url = config('app.url') . '/password-reset?token=' . $token . '&email=' . $this->email;
        
        $this->notify(new \App\Notifications\DynamicNotification('forgot_password', [
            'reset_link' => $url,
        ]));
    }

    /**
     * Check if the user's profile is complete.
     *
     * @return bool
     */
    public function isProfileComplete()
    {
        return !empty($this->age) && 
               !empty($this->location) && 
               !empty($this->occupation) && 
               !empty($this->interests) &&
               count($this->interests) > 0;
    }
}