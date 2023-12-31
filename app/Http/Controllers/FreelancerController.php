<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Freelancer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    public function index()
    {
        $freelancer = auth()->user()->freelancer;
        $order = Order::with('service')->where('freelancer_id', $freelancer->id);

        return view('freelancer.main', [
            'freelancer' => $freelancer,
            'orders' => $order->get(),
            'services' => Service::where('freelancer_id', $freelancer->id)->latest()->limit(5)->get(),
            'pendings' => $order->where('status', 'pending')->latest()->limit(5)->get(),
        ]);
    }

    public function profile() 
    {
        $skills_path = file_get_contents(public_path('json/skills.json'));
        $skills = json_decode($skills_path);
        $dataFreelancer = Freelancer::where('user_id', Auth::id())->first();

        return view('freelancer.profile.index', [
            "data" => $dataFreelancer,
            "skills" => $skills
        ]);
    }

    public function notification() 
    {
        return view('freelancer.notifications.index', [
            "notifications" => Notification::where('notifiable_type', 'App\Models\Freelancer')
            ->where('notifiable_id', auth()->user()->freelancer->id)->latest()->get()
        ]);
    }
    
    public function inboxNotification() {
        $notifications = Notification::where('notifiable_type', 'App\Models\Freelancer')->where('notifiable_id', auth()->user()->freelancer->id)->latest()->get();
        
        if (request()->ajax()) {
            return view('freelancer.notifications.action', [
                'notifications' => $notifications
            ]);
        } else {
            return view('freelancer.notifications.index', [
                'notifications' => $notifications
            ]);
        }
    }
    
    public function orderNotification() {
        $notifications = Notification::where('notifiable_type', 'App\Models\Freelancer')->where('notifiable_id', auth()->user()->freelancer->id)
        ->where('type', 'App\Notifications\OrderNotification')->latest()->get();
        
        if (request()->ajax()) {
            return view('freelancer.notifications.action', [
                'notifications' => $notifications
            ]);
        } else {
            return view('freelancer.notifications.index', [
                'notifications' => $notifications
            ]);
        }
    }
    
    public function reviewNotification() {
        $notifications = Notification::where('notifiable_type', 'App\Models\Freelancer')->where('notifiable_id', auth()->user()->freelancer->id)
        ->where('type', 'App\Notifications\ReviewNotification')->latest()->get();

        if (request()->ajax()) {
            return view('freelancer.notifications.action', [
                'notifications' => $notifications
            ]);
        } else {
            return view('freelancer.notifications.index', [
                'notifications' => $notifications
            ]);
        }
    }
    
    public function update(Request $request, string $id) 
    {
        $freelancer = Freelancer::where('user_id', $id)->first();

        $validateStore = $request->validate([
            'name' => 'required',
            'number' => 'required',
            'contact' => 'required',
            'skills' => 'required',
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
        $freelancer->skills = $validateStore['skills'];
        $freelancer->country = $validateStore['country'];
        $freelancer->image = $imagePath;
        $freelancer->save();

        return back()->with('success', 'Freelancer Profile Updated Successfully');
    }
}
