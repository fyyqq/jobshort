<?php

namespace App\Models;

use App\Models\User;
use App\Models\Rating;
use App\Models\Freelancer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ratings() {
        return $this->hasOne(Rating::class);
    }
}
