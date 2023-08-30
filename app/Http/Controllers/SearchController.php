<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('keyword');

        $result = Service::with('rating')->where('status', 'active')
        ->where(function($query) use ($search) {
            $query->where('title', 'LIKE', '%' . $search . '%')
            ->orWhere('category', 'LIKE', '%' . $search . '%');
        })->get();

        return view('search', [
            "services" => $result
        ]);
    }

    public function autocomplete(Request $request) {
        $search = $request->input('keyword');
        $result = Service::where('title', 'LIKE', $search . '%')->where('status', 'active')->get();

        return response()->json($result);
    }

    // Filter

    public function filterSearch(string $value, string $type) {
        $services = Service::with('rating', 'order')
        ->where(function($query) use ($value) {
            $query->where('title', 'LIKE', '%' . $value . '%')
            ->orWhere('category', 'LIKE', '%' . $value . '%');
        })->where('status', 'active');

        switch ($type) {
            case 'latest_service':
                $filter = $services->latest()->get();
                break;
            case 'oldest_service':
                $filter = $services->orderBy('id', 'asc')->get();
                break;
            case 'highest_order':
                $filter = $services->withCount(['order as highest_order' => function($query) {
                    $query->where('status', 'completed');
                }])->orderBy('highest_order', 'desc')->get();
                break;
            case 'lowest_order':
                $filter = $services->withCount(['order as lowest_order' => function($query) {
                    $query->where('status', 'completed');
                }])->orderBy('lowest_order', 'asc')->get();
                break;
            case 'highest_rating':
                $filter = Service::with(['order', 'rating' => function($query) {
                    $query->orderBy('stars', 'desc');
                }])->where('title', 'LIKE', '%' . $value . '%')
                ->orWhere('category', 'LIKE', '%' . $value . '%')->get();
                break;
            case 'lowest_rating':
                $filter = Service::with(['order', 'rating' => function($query) {
                    $query->orderBy('stars', 'asc');
                }])->where('title', 'LIKE', '%' . $value . '%')
                ->orWhere('category', 'LIKE', '%' . $value . '%')->get();
                break;
            case 'highest_price':
                $filter = $services->orderBy('price_after_fee', 'desc')->get();
                break;
            case 'lowest_price':
                $filter = $services->orderBy('price_after_fee', 'asc')->get();
                break;
        }

        if (request()->ajax()) {
            return view('action', ["services" => $filter]);
        } else {
            return view('search', ["services" => $filter]);
        }
    }
    
    public function reset(string $value) {
        $filter = Service::where(function($query) use ($value) {
            $query->where('title', 'LIKE', '%' . $value . '%')
            ->orWhere('category', 'LIKE', '%' . $value . '%');
        })->where('status', 'active')->get();

        if (request()->ajax()) {
            return view('action', ["services" => $filter]);
        } else {
            return view('search', ["services" => $filter]);
        }
    }
}
