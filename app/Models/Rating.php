<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function freelancer() {
        return $this->belongsTo(Freelancer::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
