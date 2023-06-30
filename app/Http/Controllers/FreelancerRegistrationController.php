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
        return view('employer.registration.personal', [
            'data' => Freelancer::where('user_id', auth()->user()->id)->first()
        ]);
    }

    public function address()
    {
        return view('employer.registration.address', [
            'data' => Freelancer::where('user_id', auth()->user()->id)->first()
        ]);
    }

    public function storePersonal(Request $request)
    {
        
        $validateStore = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'contact' => 'required'
        ]);
        
        $employer = new Freelancer();
        $employer->user_id = Auth::id();
        $employer->name = $validateStore['name'];
        $employer->number = $validateStore['number'];
        $employer->contact = $validateStore['contact'];
        $employer->save();

        return redirect()->route('employer.registration-address');
    }
    
    public function updatePersonal(Request $request) {
        
        $employer = Freelancer::where('user_id', Auth::id())->first();
        
        $validateUpdate = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'contact' => 'required'
        ]);
        
        $employer->user_id = Auth::id();
        $employer->employer_type = $request->input('employer_type');
        $employer->name = $validateUpdate['name'];
        $employer->number = $validateUpdate['number'];
        $employer->contact = $validateUpdate['contact'];
        $employer->save();
        
        return redirect()->route('employer.registration-address');
    }

    public function storeAddress(Request $request)
    {
        $employer = Freelancer::where('user_id', Auth::id())->first();

        $validateStore = $request->validate([
            'address' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postcode' => 'required'
        ]);

        $employer->address = $validateStore['address'];
        $employer->country = $validateStore['country'];
        $employer->country = $validateStore['country'];
        $employer->state = $validateStore['state'];
        $employer->city = $validateStore['city'];
        $employer->postcode = $validateStore['postcode'];
        $employer->save();

        $user = User::where('id', Auth::id())->first();
        $user->roles = '2';
        $user->save();

        return redirect()->route('employer');
    }
}
