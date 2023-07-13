<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('keyword');

        $result = Service::where('title', 'LIKE', '%' . $search . '%')
        ->orWhere('category', 'LIKE', '%' . $search . '%')->get();

        return view('search', [
            "data" => $result
        ]);
    }

    // Filter

    public function latestService(string $value) {
        $search = Service::with('rating', 'order')->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')->latest()->get();

        return response()->json($search);
    }

    public function oldestService(string $value) {
        $search = Service::with('rating', 'order')->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')->orderBy('id', 'asc')->get();
        
        return response()->json($search);
    }
    
    public function highestOrder(string $value) {
        $search = Service::with('rating', 'order')->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')
        ->withCount(['order as top_order' => function($query) {
            $query->where('status', 'completed');
        }])->orderByDesc('top_order')->get();

        return response()->json($search);
    } 
    
    public function lowestOrder(string $value) {
        $search = Service::with('rating', 'order')->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')
        ->withCount(['order as low_order' => function($query) {
            $query->where('status', 'completed');
        }])->orderBy('low_order')->get();

        return response()->json($search);
    } 
    
    public function highestRating(string $value) {
        $search = Service::with(['rating' => function($query) {
            $query->orderByDesc('stars');
        }, 'order'])->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')->get();
        
        return response()->json($search);
    }
    
    public function lowestRating(string $value) {
        $search = Service::with('rating', 'order')
        ->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')->get();
            
        return response()->json($search);
    }
    
    public function highestPrice(string $value) {
        $search = Service::with('rating', 'order')->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')->orderBy('price', 'desc')->get();
        
        return response()->json($search);
    }
    
    public function lowestPrice(string $value) {
        $search = Service::with('rating', 'order')->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')->orderBy('price', 'asc')->get();
        
        return response()->json($search);
    }
    
    public function reset(string $value) {
        $search = Service::with('rating', 'order')->where('title', 'LIKE', '%' . $value . '%')
        ->orWhere('category', 'LIKE', '%' . $value . '%')->get();

        return response()->json($search);
    }
}
