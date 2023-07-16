<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Service;
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
            "services" => Service::all(),
            "categories" => $categories
        ]);
    }

    public function show(string $slug) {
        $service = Service::with('freelancer')->where('slug', $slug)->first();
        
        return view('service-detail', [
            "service" => $service,
            "reviews" => Rating::where('service_id', $service->id)->limit(5)->get(),
            "similiar" => Service::where('category', $service->category)->get()
        ]);
    }

    public function login()
    {
        return view('homepage');
    }
}
