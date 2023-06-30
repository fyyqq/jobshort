<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notify;
use App\Models\Service;
use App\Models\Freelancer;
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
  
        return view('employer.jobs.services', [
            "services" => $service
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobsPath = file_get_contents(public_path('json/category.json'));
        $data = json_decode($jobsPath, true);
        
        return view('employer.create-service', [
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
            'images.*' => ['image', 'mimes:png,jpg,jpeg', 'required'],
            'title' => 'required',
            'category' => 'required',
            'price' => 'required',
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
        $service->image = implode(',', $imagePaths);
        $service->title = $validateStore['title'];
        $service->slug = strtolower($slug);
        $service->description = $request->input('description');
        $service->category = $validateStore['category'];
        $service->price = $validateStore['price'];
        $saved = $service->save();

        if ($saved) {
            $userNotifies = Notify::where('freelancer_id', $freelancer->id)->get();
            $userIDs = collect($userNotifies)->pluck('user_id')->toArray();
            $users = User::whereIn('id', $userIDs)->get();

            Notification::send($users, new ServiceNotification($service));
        }

        return redirect()->route('employer.jobs')->with('success', 'New service has been uploaded');   
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
        $jobsPath = file_get_contents(public_path('json/category.json'));
        $services =  json_decode($jobsPath, true);
        
        return view('employer.jobs.edit', [
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
            'title' => 'required',
            'description' => 'nullable',
            'category' => 'required',
            'price' => 'required'
        ]);
        
        $slug = uniqid();
    
        $freelancer = Freelancer::where('user_id', Auth::id())->first();
        $service->freelancer_id = $freelancer->id;
        $service->title = $validateUpdate['title'];
        $service->slug = strtolower($slug);
        $service->description = $validateUpdate['description'];
        $service->category = $validateUpdate['category'];
        $service->price = $validateUpdate['price'];
        $service->save();
    
        return redirect()->route('employer.jobs')->with('success', 'My service has been updated'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
