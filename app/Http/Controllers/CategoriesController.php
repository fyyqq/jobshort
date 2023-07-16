<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index() {
        return Service::all();
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
}
