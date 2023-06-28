<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use PhpParser\Node\Stmt\Return_;

class AddressController extends Controller
{
    public function index() {

        $user = User::where('id', auth()->user()->id)->first();

        if ($user->state != null && $user->city != null) {
            $statePath = file_get_contents(public_path('json/states.json'));
            $states = json_decode($statePath);
    
            $cityPath = file_get_contents(public_path('json/states-cities.json'));
            $cities = json_decode($cityPath);
            $citiesOption = $cities;
            $statesOption = $user->state;
            $findCities = $citiesOption->$statesOption;
            
            $filteredStates = array_filter($states, function($state) {
                $user = User::where('id', auth()->user()->id)->first();
                return $state != $user->state;
            });
            
            $filteredCities = array_filter($findCities, function($city) {
                $user = User::where('id', auth()->user()->id)->first();
                return $city != $user->city;
            });
            
            return view('profile.address', [
                "dataStates" => $filteredStates,
                "dataCities" => $filteredCities
            ]);
        }
        return view('profile.address');
    }

    public function store(Request $request) {
        $validateStore = $request->validate([
            'country' => 'required',
            'state' => 'required',
            'city' => 'required'
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->address = $request->input('address');
        $user->country = $validateStore['country'];
        $user->state = $validateStore['state'];
        $user->city = $validateStore['city'];
        $user->postcode = $request->input('postcode');
        $user->save();

        return back()->with('success', 'Address Saved Successfully');
    }

    public function update(Request $request) {
        $validateStore = $request->validate([
            'country' => 'required',
            'state' => 'required',
            'city' => 'required'
        ]);

        $user = User::where('id', auth()->user()->id)->first();
        $user->address = $request->input('address');
        $user->country = $validateStore['country'];
        $user->state = $validateStore['state'];
        $user->city = $validateStore['city'];
        $user->postcode = $request->input('postcode');
        $user->save();

        return back()->with('success', 'Address Updated Successfully');
    }
}
