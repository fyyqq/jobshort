<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use Illuminate\Http\Request;

class ChatifyController extends Controller
{
    public function __invoke($id) {
        $freelancer = Freelancer::findOrFail($id);
     }
}
