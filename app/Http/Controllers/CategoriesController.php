<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Service;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(string $slug) {

        $pathCategories = file_get_contents(public_path('json/category.json'));
        $data =  json_decode($pathCategories, true);

        $filteredCategories = array_filter($data, function($category) use ($slug) {
            return $category['slug'] == $slug;
        });

        foreach($filteredCategories as $value) {
            $data = Service::where('category', $value['name'])->get();
        }

        return $data;

        return view('view-category', [
            "dataJobs" => $data,
            "dataCategory" => $filteredCategories
        ]);
    }
}
