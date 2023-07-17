<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\Order;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function order() {
        return view('profile.order.index', [
            "orders" => Order::with(['freelancer', 'service'])->where('user_id', Auth::id())->where('status', 'pending')->latest()->get()
        ]);
    }
    
    public function pending() {
        $orders = Order::with(['freelancer', 'service'])->where('user_id', Auth::id())->where('status', 'pending')->latest()->get();
        
        if (request()->ajax()) {
            return view('profile.order.action', ["orders" => $orders]);
        } else {
            return view('profile.order.index', ["orders" => $orders]);
        }
    }
    
    public function approved() {
        $orders = Order::with(['freelancer', 'service'])->where('user_id', Auth::id())->where('status', 'approved')->latest()->get();
        
        if (request()->ajax()) {
            return view('profile.order.action', ["orders" => $orders]);
        } else {
            return view('profile.order.index', ["orders" => $orders]);
        }
    }
    
    public function rejected() {
        $orders = Order::with(['freelancer', 'service'])->where('user_id', Auth::id())->where('status', 'rejected')->latest()->get();
        
        if (request()->ajax()) {
            return view('profile.order.action', ["orders" => $orders]);
        } else {
            return view('profile.order.index', ["orders" => $orders]);
        }
    }
    
    public function completed() {
        $orders = Order::with(['freelancer', 'service'])->where('user_id', Auth::id())->where('status', 'completed')->latest()->get();
        
        if (request()->ajax()) {
            return view('profile.order.action', ["orders" => $orders]);
        } else {
            return view('profile.order.index', ["orders" => $orders]);
        }
    }

    public function index()
    {
        return view('profile.main');
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
    public function store(Request $request)
    {        
        $validateStore = $request->validate([
            'name' => ['required'],
            'identification_number' => ['required'],
        ]);
        
        if ($request->file('image') !== null) {
            $imagePath = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imagePath);
        } else {
            $imagePath = null;
        }

        $user = User::where('id', auth()->user()->id)->first();
        $user->name = $validateStore['name'];
        $user->identification_number = $validateStore['identification_number'];
        $user->birth_date = $request->input('birth_date');
        $user->gender = $request->input('gender');
        $user->about = $request->input('about');
        $user->image = $imagePath;
        if ($user->roles == '2') {
            $user->roles = '2';
        } elseif ($user->roles == '0') {
            $user->roles = '1';
        } else {
            $user->roles = '1';
        }
        $user->save();

        return redirect()->route('profile.main')->with('success', 'Profile Registration Successfully');
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
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateStore = $request->validate([
            'name' => ['required'],
            'identification_number' => ['required'],
            'image' => ['image', 'mimes:png,jpg,jpeg', 'max:5048'],
        ]);

        
        if ($request->hasFile('image')) {
            $imagePath = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imagePath);
            
            $imageFile = public_path('images/' . auth()->user()->image);
            if (file_exists($imageFile)) {
                try {
                    unlink($imageFile);
                } catch (\Exception $e) {}
            }
        } else {
            $imagePath = auth()->user()->image;
        }

        $user = User::where('id', auth()->user()->id)->first();
        $user->name = $validateStore['name'];
        $user->identification_number = $validateStore['identification_number'];
        $user->birth_date = $request->input('birth_date');
        $user->gender = $request->input('gender');
        $user->about = $request->input('about');
        $user->image = $imagePath;
        $user->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
