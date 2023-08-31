<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Notify;
use App\Models\Service;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ServiceNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\type;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() 
    {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with(['order', 'rating'])->where('freelancer_id', $freelancer->id)->latest()->get();

        return view('freelancer.service.index', [
            "services" => $services
        ]);
    }
    
    public function all() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with(['order', 'rating'])->where('freelancer_id', $freelancer->id)->where('status', 'active')->latest()->get();

        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }
    
    public function archive() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with(['order', 'rating'])->where('freelancer_id', $freelancer->id)->where('status', 'archive')->latest()->get();

        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }

    // Filter Search 
    public function searchServices(Request $request) {
        $keyword = $request->query('keyword');
        
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)->where('status', 'active')->where('title', 'like', "$keyword%")->get();

        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }

    // Filter SortBy
    public function sortByOldest() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')
        ->where('freelancer_id', $freelancer->id)
        ->orderBy('id', 'asc')->get();
        
        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }

    public function sortByTopOrder() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')
        ->where('freelancer_id', $freelancer->id)
        ->withCount(['order as top_order' => function ($query) {
            $query->where('status', 'completed');
        }])->orderByDesc('top_order')->get();
        
        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }
    
    public function sortByTopRating() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with(['order', 'rating' => function ($query) {
            $query->orderByDesc('stars');
        }])->where('freelancer_id', $freelancer->id)->get();

        
        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }
    
    // Filter
    public function sortByNormal() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)->latest()->get();
        
        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }

    public function sortByHighPrice() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)->orderBy('price_after_fee', 'desc')->get();
        
        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }

    public function sortByLowPrice() {
        $freelancer = Freelancer::where('user_id', auth()->user()->id)->first();
        $services = Service::with('order', 'rating')->where('freelancer_id', $freelancer->id)->orderBy('price_after_fee', 'asc')->get();
        
        if (request()->ajax()) {
            return view('freelancer.service.action', ["services" => $services]);
        } else {
            return view('freelancer.service.index', ["services" => $services]);
        }
    }

    public function updateActive(string $slug) {
        $service = Service::where('freelancer_id', auth()->user()->freelancer->id)->where('slug', $slug)->first();
        $service->status = "active";
        $confirmActive = $service->save();

        if ($confirmActive) {
            return true;
        }
    }

    public function activeItems(Request $request) {
        $selected = $request->input('selectedItems');
        $confirmActive = Service::whereIn('slug', $selected)->update(['status' => 'active']);

        if ($confirmActive) {
            return true;
        }
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
            'category' => 'required',
            'price' => 'required',
            'price_after_fee' => 'required',
            'min_delivery' => ['required', 'numeric', 'integer'],
            'max_delivery' => ['required', 'numeric', 'integer'],
            'images' => ['required', 'min:5', 'max:2048'],
            'images.*' => ['mimes:png,jpg,jpeg'],
        ], [
            'title.required' => 'Title is required!',
            'category.required' => 'Category is required!',
            'price.required' => 'Price is required!',
            'min_delivery.required' => 'Minimum day is required!',
            'max_delivery.required' => 'Maximum day is required!',
            'images.required' => 'Image is required!',
            'images.max' => 'Upload minimum 5 images!',
            'images.size' => 'Image file too big!',
            'images.*.mimes' => 'Invalid image format!',
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
        $service->price_after_fee = $validateStore['price_after_fee'];
        $service->min_delivery = $validateStore['min_delivery'];
        $service->max_delivery = $validateStore['max_delivery'];
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
            'price_after_fee' => 'required',
            'min_delivery' => ['required', 'numeric', 'integer'],
            'max_delivery' => ['required', 'numeric', 'integer'],
        ], [
            'title.required' => 'Title is required!',
            'category.required' => 'Category is required!',
            'price.required' => 'Price is required!',
            'min_delivery.required' => 'Minimum day is required!',
            'max_delivery.required' => 'Maximum day is required!',
        ]);

        function deleteImages($images) {
            foreach ($images as $image) {
                if (file_exists(public_path('images/' . $image))) {
                    unlink(public_path('images/' . $image));
                }
            }
        }

        $existingImages = explode(',', $service->image);
        $oldImages = $request->input('oldImages');

        // if new image Added
        if ($request->hasFile('images')) {

            $imgArray = [];

            foreach ($request->file('images') as $image) {
                $modifiedPath = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $modifiedPath);
                array_push($imgArray, $modifiedPath);
            }
            
            if (!empty($oldImages)) {
                // if new image added && something change to oldImages                
                $diffImages = array_diff($existingImages, $oldImages);
                deleteImages($diffImages);
                
                $images = array_merge($oldImages, $imgArray);
            } else {
                // If oldImages doesn't exists
                deleteImages($existingImages);
                $images = $imgArray;
            }
        } else {
            // If there's no new images added             
            $diffImages = array_diff($existingImages, $oldImages);
            deleteImages($diffImages);

            $images = $oldImages;
        }

        $service->freelancer_id = $service->freelancer_id;
        $service->title = $validateUpdate['title'];
        $service->slug = strtolower($service->slug);
        $service->description = $request->input('description');
        $service->category = $validateUpdate['category'];
        $service->price = $validateUpdate['price'];
        $service->price_after_fee = $validateUpdate['price_after_fee'];
        $service->image = implode(',', $images);
        $service->min_delivery = $validateUpdate['min_delivery'];
        $service->max_delivery = $validateUpdate['max_delivery'];
        $confirmUpdate = $service->save();

        $countImages = count($images);
        if ($countImages >= 5 && $confirmUpdate)  {
            return redirect()->route('freelancer.services')->with('success', 'My service has been updated!'); 
        } else {
            return redirect()->back()->withErrors(['images' => 'Upload minimum 5 images.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $service = Service::where('freelancer_id', auth()->user()->freelancer->id)
        ->where('slug', $slug)->first();
        $confirmDelete = $service->delete();
        
        $images = explode(',', $service->image);

        foreach ($images as $image) {
            if (file_exists(public_path('images/' . $image))) {
                unlink(public_path('images/' . $image));
            }
        }

        if ($confirmDelete) {
            return true;
        }
    }

    public function deletedItems(Request $request) {
        $selected = $request->input('selectedItems');
        $serviceSelected = Service::whereIn('slug', $selected)->get();
        foreach ($serviceSelected as $service) {
            $images = explode(',', $service->image);
            foreach ($images as $image) {
                if (file_exists(public_path('images/' . $image))) {
                    unlink(public_path('images/' . $image));
                }
            }
        }

        $confirmDelete = Service::whereIn('slug', $selected)->delete();
        
        if ($confirmDelete) {
            return true;
        }
    }
}
