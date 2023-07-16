<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {
        $pathCategories = file_get_contents(public_path('json/category.json'));
        $data = json_decode($pathCategories, true);

        return view('categories', [
            "categories" => $data
        ]);
    }

    public function show(string $slug) {

        $pathCategories = file_get_contents(public_path('json/category.json'));
        $data = json_decode($pathCategories, true);

        $category = array_filter($data, function($category) use ($slug) {
            return $category['slug'] === $slug;
        });

        $categoryName;
        foreach($category as $category) {
            $categoryName = ($category['name']);
        }
        
        $services = Service::where('category', $categoryName)->get();
        $serviceCount = Service::with(['order', 'rating'])->where('category', $categoryName)->first();

        $filterCategories = array_filter($data, function($category) use ($slug) {
            return $category['slug'] !== $slug;
        });

        $categories = array_slice($filterCategories, 0, 5);

        return view('category', [
            "category" => $category,
            "categories" => $categories,
            "services" => $services,
            "count" => $serviceCount,
        ]);
    }

    public function filter(string $name, string $type) {
        $services = Service::where('category', $name);

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
                }])->where('category', $name)->get();
                break;
            case 'lowest-rating':
                $filter = Service::with(['order', 'rating' => function($query) {
                    $query->orderBy('stars', 'asc');
                }])->where('category', $name)->get();
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
            return view('action', ["services" => $filter]);
        } else {
            return view('category', ["services" => $filter]);
        }
    }
}
