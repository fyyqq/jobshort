<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Chatify\Traits\HasChats;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasChats;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // public function getProfileImageAttribute()
    // {
    //     if ($this->profile_image) {
    //         return asset('path/to/profile/images/' . $this->profile_image);
    //     }
        
    //     return asset('path/to/default/profile/image.jpg');
    // }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function freelancer() {
        return $this->hasOne(Freelancer::class);
    }

    public function wishlist() {
        return $this->hasMany(Wishlist::class);
    }

    public function order() {
        return $this->hasMany(Order::class);
    }

    public function rating() {
        return $this->hasMany(Rating::class);
    }

    public function notification() {
        return $this->hasMany(Notification::class, 'notifiable_id');
    }

    public function notify() {
        return $this->hasMany(Notify::class);
    }
}
