<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FreelancerRegistrationController extends Controller
{
    public function index()
    {
        $skills_path = file_get_contents(public_path('json/skills.json'));
        $decode_data = json_decode($skills_path);

        return view('freelancer.registration.personal', [
            'skills' => $decode_data
        ]);
    }

    public function store(Request $request)
    {
        
        $validateStore = $request->validate([
            'name' => 'unique:freelancers,name',
            'number' => 'required',
            'contact' => 'required',
            'country' => 'required',
        ]);
        
        if ($request->hasFile('image')) {
            $imagePath = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imagePath);
        } else {
            $imagePath = null;
        }

        $freelancer = new Freelancer();
        $freelancer->user_id = Auth::id();
        $freelancer->name = $validateStore['name'];
        $freelancer->number = $validateStore['number'];
        $freelancer->contact = $validateStore['contact'];
        $freelancer->country = $validateStore['country'];
        $freelancer->skills = $request->input('skills');
        $freelancer->image = $imagePath;
        $registration_confirmation = $freelancer->save();

        if ($registration_confirmation) {
            $user = User::find(Auth::id());
            $user->roles = 2;
            $user->save();
        }

        return redirect()->route('freelancer.main');
    }
}
