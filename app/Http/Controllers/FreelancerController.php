<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Freelancer;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('freelancer.main', [
        ]);
    }

    public function profile() 
    {
        $skills_path = file_get_contents(public_path('json/skills.json'));
        $decode_data = json_decode($skills_path);        
        $dataFreelancer = Freelancer::where('user_id', Auth::id())->first();

        return view('freelancer.profile.index', [
            "data" => $dataFreelancer,
            "skills" => $decode_data
        ]);
    }

    public function notification() 
    {
        return view('freelancer.notifications.index', [
            "notifications" => Notification::where('notifiable_id', auth()->user()->freelancer->id)->latest()->get()
        ]);
    }

    public function addService() 
    {
        $servicesPath = file_get_contents(public_path('json/category.json'));
        $data =  json_decode($servicesPath, true);
        
        return view('freelancer.create-service', [
            "categories" => $data 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

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

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id) 
    {
        $freelancer = Freelancer::where('user_id', $id)->first();

        $validateStore = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'contact' => 'required',
            'country' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imagePath);

            $image_path = public_path('images/' . $freelancer->image);

            if (file_exists($image_path) && is_file($image_path)) {
                unlink($image_path);
            }
        } else {
            if (is_null($freelancer->image)) {
                $imagePath = null;
            } else {
                $imagePath = $freelancer->image;
            }
        }
        
        $freelancer->name = $validateStore['name'];
        $freelancer->number = $validateStore['number'];
        $freelancer->contact = $validateStore['contact'];
        $freelancer->about = $request->input('about');
        $freelancer->skills = $request->input('skills');
        $freelancer->image = $imagePath;
        $freelancer->save();

        return back()->with('success', 'Freelancer Profile Updated Successfully');
    }

    public function updateAddress(Request $request, string $id) {
        return $request->all();
    }

    /**
     * Remove the specified resource from storage.
     */
}
