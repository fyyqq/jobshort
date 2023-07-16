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

    public function showService(string $slug) {
        $service_id = Service::where('slug', $slug)->first()->id;

        return view('service-detail', [
            "service" => Service::where('slug', $slug)->first(),
            "services" => Service::all(),
            "reviews" => Rating::where('service_id', $service_id)->get()
        ]);
    }

    public function login()
    {
        return view('homepage');
    }
}
