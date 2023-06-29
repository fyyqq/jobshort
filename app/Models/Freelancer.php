<?php

namespace App\Models;

use App\Chatify\Traits\HasChats;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Freelancer extends Model
{
    use HasFactory, Notifiable, HasChats;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rating() {
        return $this->hasMany(Rating::class);
    }

    public function service() {
        return $this->hasMany(Service::class);
    }

    public function notify() {
        return $this->hasMany(Notify::class);
    }
}