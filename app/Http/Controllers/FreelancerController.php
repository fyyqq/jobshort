<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Employer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Middleware\Employee;
use App\Models\Application;
use App\Models\Freelancer;
use App\Models\Notification;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employer.main', [
            "dataJobs" => Service::where('freelancer_id', auth()->user()->freelancer->id)->get(),
            // "dataApplicant" => Application::where('freelancer_id', auth()->user()->freelancer->id)->get()
        ]);
    }

    public function profile() 
    {
        $dataFreelancer = Freelancer::where('user_id', Auth::id())->first();

        return view('employer.profile.profile', [
            "data" => $dataFreelancer
        ]);
    }

    public function address() 
    {
        $dataEmployer = Freelancer::where('user_id', Auth::id())->first();

        if ($dataEmployer->state != null && $dataEmployer->city != null) {
            $statePath = file_get_contents(public_path('json/states.json'));
            $states = json_decode($statePath);
    
            $cityPath = file_get_contents(public_path('json/states-cities.json'));
            $cities = json_decode($cityPath);
            $citiesOption = $cities;
            $statesOption = $dataEmployer->state;
            $findCities = $citiesOption->$statesOption;
            
            $filteredStates = array_filter($states, function($state) {
                $dataEmployer = Freelancer::where('user_id', auth()->user()->id)->first();
                return $state != $dataEmployer->state;
            });
            
            $filteredCities = array_filter($findCities, function($city) {
                $dataEmployer = Freelancer::where('user_id', auth()->user()->id)->first();
                return $city != $dataEmployer->city;
            });
        }

        return view('employer.profile.address', [
            "data" => $dataEmployer,
            "states" => $filteredStates,
            "cities" => $filteredCities
        ]);
    }

    public function live() 
    {
        // $employer = Employer::where('user_id', auth()->user()->id)->first();
        // $jobs = Job::where('freelancer_id', $freelancer->id)->where('status', 'live')->latest()->get();

        return view('employer.jobs.my-jobs', [
            // "dataJobs" => $jobs
        ]);
    }

    public function ongoing() 
    {
        // $employer = Employer::where('user_id', auth()->user()->id)->first();
        // $jobs = Job::where('freelancer_id', $freelancer->id)->where('status', 'ongoing')->latest()->get();

        return view('employer.jobs.my-jobs', [
            // "dataJobs" => $jobs
        ]);
    }

    public function complete() 
    {
        // $employer = Employer::where('user_id', auth()->user()->id)->first();
        // $jobs = Job::where('freelancer_id', $freelancer->id)->where('status', 'complete')->latest()->get();

        return view('employer.jobs.my-jobs', [
            // "dataJobs" => $jobs
        ]);
    }

    public function archive() 
    {
        // $employer = Employer::where('user_id', auth()->user()->id)->first();
        // $jobs = Job::where('freelancer_id', $freelancer->id)->where('status', 'archive')->latest()->get();

        return view('employer.jobs.my-jobs', [
            // "dataJobs" => $jobs
        ]);
    }

    public function notification() 
    {
        return view('employer.notification', [
            "notifications" => Notification::where('notifiable_id', Auth::id())->latest()->get()
        ]);
    }

    public function addService() 
    {
        $jobsPath = file_get_contents(public_path('json/category.json'));
        $data =  json_decode($jobsPath, true);
        
        return view('employer.add-jobs', [
            // "data" => Employer::where('user_id', Auth::id())->first(),
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
    public function update(Request $request, string $slug)
    {
        // $jobs = Job::where('slug', $slug)->first();
        
        $validateUpdate = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'category' => 'required',
            'salary' => 'nullable',
            'date' => 'nullable',
            'address' => 'required'
        ]);
        
        $slug = Str::slug($request->input('title')) . '_' . uniqid();

        // $employer = Employer::where('user_id', Auth::id())->first();
        // $jobs->freelancer_id = $freelancer->id;
        // $jobs->type = $request->input('type');
        // $jobs->title = $validateUpdate['title'];
        // $jobs->slug = strtolower($slug);
        // $jobs->description = $validateUpdate['description'];
        // $jobs->category = $validateUpdate['category'];
        // $jobs->salary = $validateUpdate['salary'];
        // $jobs->date = $validateUpdate['date'];
        // $jobs->address = $validateUpdate['address'];
        // $jobs->save();

        return redirect()->route('employer.jobs')->with('success', 'My jobs has been updated'); 
    }

    public function updateArchive(string $slug) {
        // $job = Job::where('slug', $slug)->first();
        // $job->status = 'archive';
        // $job->save();

        return redirect()->route('employer.archive-jobs');
    }

    public function updateProfile(Request $request, string $id) 
    {
        $freelancer = Freelancer::where('user_id', $id)->first();

        $validateStore = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'contact' => 'required'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imagePath);

            $image_path = public_path('images/' . $freelancer->image);

            if (file_exists($image_path)) {
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
    public function deletedItems(Request $request) {
        return $request->all();
    }

    public function destroy(string $slug)
    {
        $slug = Service::where('freelancer_id', auth()->user()->freelancer->id)->where('slug', $slug)->first();

        $slug->delete();

        return back()->with('success', 'My Jobs has been deleted');
    }
}
