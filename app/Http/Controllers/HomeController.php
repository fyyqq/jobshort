<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Service;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $servicesPath = file_get_contents(public_path('json/category.json'));
        $data =  json_decode($servicesPath, true);

        $categories = array_slice($data, 0, 15);

        return view('home', [
            "services" => Service::with(['order', 'rating'])->where('status', 'active')->latest()->get(),
            "categories" => $categories
        ]);
    }

    public function show(string $slug) {
        $service = Service::with('freelancer')->where('slug', $slug)->first();

        return view('service-detail', [
            "service" => $service,
            "reviews" => Rating::where('service_id', $service->id)->limit(5)->get(),
            "similiar" => Service::with(['rating'])->where('category', $service->category)->where('slug', '!=', $slug)
            ->where('status', 'active')->limit(10)->get()
        ]);
    }

    public function user(string $name) {
        return view('users', [
            'freelancer' => Freelancer::with(['service'])->where('name', $name)->first()
        ]);
    }
    
    public function sortCategory(string $name, string $category) {
        $freelancer = Freelancer::where('name', $name)->first();
        $services = Service::with(['rating', 'order'])->where('freelancer_id', $freelancer->id)->where('status', 'active');

        if ($category === 'all') {
            $filter = $services->get();
        } else {
            $filter = $services->where('category', $category)->get();
        }

        if (request()->ajax()) {
            return view('action', [
                'services' => $filter,
                'countServices' => count($filter)
            ]);
        } else {
            return view('users', [
                'services' => $filter
            ]);
        }
    }
    
    public function sortFilter(string $name, string $type) {
        $freelancer = Freelancer::where('name', $name)->first();
        $services = Service::with(['rating', 'order'])->where('freelancer_id', $freelancer->id);

        switch ($type) {
            case 'latest':
                $filter = $services->latest()->get();
                break;
            case 'oldest':
                $filter = $services->orderBy('id', 'asc')->get();
                break;
            case 'highest-order':
                $filter = $services->withCount(['order as top_order' => function($query) {
                    $query->where('status', 'completed');
                }])->orderByDesc('top_order')->get();
                break;
            case 'lowest-order':
                $filter = $services->withCount(['order as low_order' => function($query) {
                        $query->where('status', 'completed');
                    }])->orderBy('low_order')->get();
                break;
            case 'highest-rating':
                $filter = Service::with(['order', 'rating' => function($query) {
                    $query->orderByDesc('stars');
                }])->where('freelancer_id', $freelancer->id)->get();
                break;
            case 'lowest-rating':
                $filter = Service::with(['order', 'rating' => function($query) {
                    $query->orderBy('stars', 'asc');
                }])->where('freelancer_id', $freelancer->id)->get();
                break;
            case 'highest-price': 
                $filter = $services->orderBy('price', 'desc')->get();
                break;
            case 'lowest-price':
                $filter = $services->orderBy('price', 'asc')->get();
                break;
            default:
                $filter = $services->get();
                break;
        }

        if (request()->ajax()) {
            return view('action', [
                'services' => $filter
            ]);
        } else {
            return view('users', [
                'services' => $filter
            ]);
        }
    }

    public function login()
    {
        return view('homepage');
    }
}
