<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Order;
use App\Models\Notify;
use App\Models\Service;
use App\Models\Freelancer;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ServiceNotification;
use Illuminate\Support\Facades\Notification;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $service = Service::where('freelancer_id', $freelancer->id)->latest()->get();
        
        return view('freelancer.service.index', [
            "services" => $service
        ]);
    }
    
    public function all() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $service = Service::where('freelancer_id', $freelancer->id)->latest()->get();

        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $service]);
        } else {
            return view('freelancer.service.index', ["services" => $service]);
        }
    }
    
    public function active() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $service = Service::where('freelancer_id', $freelancer->id)->where('status', 'active')->latest()->get();

        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $service]);
        } else {
            return view('freelancer.service.index', ["services" => $service]);
        }
    }
    
    public function archive() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $service = Service::where('freelancer_id', $freelancer->id)->where('status', 'archive')->latest()->get();

        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $service]);
        } else {
            return view('freelancer.service.index', ["services" => $service]);
        }
    }

    // Filter Search 
    public function searchServices(Request $request) {
        $keyword = $request->query('keyword');
        
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)
        ->where('title', 'like', "$keyword%")->get();

        return response()->json($services);
    }

    // Filter SortBy
    public function sortByOldest() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')
        ->where('freelancer_id', $freelancer->id)
        ->orderBy('id', 'asc')->get();
        
        return response()->json($services);
    }

    public function sortByTopOrder() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')
        ->where('freelancer_id', $freelancer->id)
        ->withCount(['order as top_order' => function ($query) {
            $query->where('status', 'completed');
        }])->orderByDesc('top_order')->get();
        
        return response()->json($services);
    }
    
    public function sortByTopRating() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with(['order', 'rating' => function ($query) {
            $query->orderByDesc('stars');
        }])->where('freelancer_id', $freelancer->id)->get();

        return response()->json($services);
    }
    
    // Filter
    public function sortByNormal() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)->latest()->get();
        
        return response()->json($services);
    }

    public function sortByHighPrice() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)->orderBy('price', 'desc')->get();
        
        return response()->json($services);
    }

    public function sortByLowPrice() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)->orderBy('price', 'asc')->get();
        
        return response()->json($services);
    }

    public function updateArchive(string $slug) {
        $service = Service::where('freelancer_id', auth()->user()->freelancer->id)->where('slug', $slug)->first();
        $service->status = "archive";
        $confirmArchive = $service->save();

        if ($confirmArchive) {
            return true;
        }
    }

    public function archiveItems(Request $request) {
        $selected = $request->input('selectedItems');
        $confirmArchive = Service::whereIn('slug', $selected)->update(['status' => 'archive']);

        if ($confirmArchive) {
            return true;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicesPath = file_get_contents(public_path('json/category.json'));
        $data = json_decode($servicesPath, true);
        
        return view('freelancer.create', [
            "categories" => $data 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $freelancer = Freelancer::where('user_id', Auth::id())->first();

        $validateStore = $request->validate([
            'title' => ['required', 'max:100'],
            'category' => ['required'],
            'price' => ['required'],
            'images' => ['required', 'min:5'],
            'images.*' => ['image', 'mimes:png,jpg,jpeg'],
        ], [
            'title.required' => 'Title is required.',
            'category.required' => 'Category is required.',
            'price.required' => 'Price is required.',
            'images.required' => 'Image is required.',
            'images.min' => 'Upload minimum 5 images.',
            'images.*.mimes' => 'Invalid image format.',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $modifiedPath = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $modifiedPath);
                $imagePaths[] = $modifiedPath;
            }
        } else {
            $imagePaths = null;
        }
        
        $slug = $freelancer->id . uniqid();

        $service = new Service();
        $service->freelancer_id = $freelancer->id;
        $service->title = $validateStore['title'];
        $service->slug = strtolower($slug);
        $service->image = implode(',', $imagePaths);
        $service->description = $request->input('description');
        $service->category = $validateStore['category'];
        $service->price = $validateStore['price'];
        $saved = $service->save();

        if ($saved) {
            $userNotifies = Notify::where('freelancer_id', $freelancer->id)->get();
            $userIDs = collect($userNotifies)->pluck('user_id')->toArray();
            $users = User::whereIn('id', $userIDs)->get();

            Notification::send($users, new ServiceNotification($service));

            return redirect()->route('freelancer.services')->with('success', 'New service has been uploaded');
        } else {
            return redirect()->back()->with('error', 'Failed to upload');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $servicesPath = file_get_contents(public_path('json/category.json'));
        $services =  json_decode($servicesPath, true);
        
        return view('freelancer.edit', [
            "service" => Service::where('slug', $slug)->first(),
            "categories" => $services
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $service = Service::where('slug', $slug)->first();

        $validateUpdate = $request->validate([
            'title' => ['required', 'max:100'],
            'category' => 'required',
            'price' => 'required',
        ], [
            'title.required' => 'Title is required.',
            'category.required' => 'Category is required.',
            'price.required' => 'Price is required.',
        ]);
        
        // if new image was created
        if ($request->hasFile('images')) {
            $imgArray = [];
            foreach ($request->file('images') as $image) {
                $modifiedPath = uniqid() . '.' . $image->getClientOriginalExtension();
                // $image->move(public_path('images'), $modifiedPath);
                array_push($imgArray, $modifiedPath);
            }
            // if old image still have
            if (!empty($request->input('oldImages'))) {
                // old image & new image
                $images = array_merge($request->input('oldImages'), $imgArray);
            } else {
                // if old images remove
                $images = $imgArray;
            }
        } else {
            $images = $request->input('oldImages');
        }

        // return $request->input('oldImages');
        // return $imgArray;
        
        $service->freelancer_id = $service->freelancer_id;
        $service->title = $validateUpdate['title'];
        $service->slug = strtolower($service->slug);
        $service->image = implode(',', $images);
        $service->description = $request->input('description');
        $service->category = $validateUpdate['category'];
        $service->price = $validateUpdate['price'];
        $confirmUpdate = $service->save();

        $countImages = count($images);
        if ($countImages >= 5 && $confirmUpdate)  {
            return redirect()->route('freelancer.services')->with('success', 'My service has been updated'); 
        } else {
            return redirect()->back()->withErrors(['images' => 'Upload minimum 5 images.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $slug = Service::where('freelancer_id', auth()->user()->freelancer->id)->where('slug', $slug)->first();
        $confirmDelete = $slug->delete();

        if ($confirmDelete) {
            return true;
        }
    }

    public function deletedItems(Request $request) {
        $selected = $request->input('selectedItems');
        $confirmDelete = Service::whereIn('slug', $selected)->delete();
        
        if ($confirmDelete) {
            return true;
        }
    }
}
