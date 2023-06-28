<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
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
}
