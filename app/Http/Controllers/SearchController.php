<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');

        $result = Service::where('title', 'LIKE', '%' . $search . '%')
        ->orWhere('category', 'LIKE', '%' . $search . '%')->get();

        return view('search', [
            "data" => $result
        ]);
    }
}
