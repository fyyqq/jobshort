<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Freelancer;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employer.applicant.pending', [ 
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'pending')->get()
        ]);
    }
    
    public function approved()
    {
        return view('employer.applicant.pending', [ 
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'approved')->get()
        ]);
    }
    
    public function rejected()
    {
        return view('employer.applicant.pending', [ 
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'rejected')->get()
        ]);
    }
    
    public function completed()
    {
        return view('employer.applicant.pending', [
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'completed')->get()
        ]);
    }

    public function approve(string $id) 
    {
        $order = Order::where('id', $id)->first();
        $order->status = 'approved';
        $order->save();
    }
    
    public function reject(string $id) 
    {
        $order = Order::where('id', $id)->first();
        $order->status = 'rejected';
        $order->save();
    }
    
    public function complete(string $id) 
    {
        $order = Order::where('id', $id)->first();
        $order->status = 'completed';
        $order->save();
    }

    public function store(string $service_id, string $freelancer_id) {
        $order = new Order();
        $order->user_id = Auth::id();
        $order->service_id = $service_id;
        $order->freelancer_id = $freelancer_id;
        $orders = $order->save();

        if ($orders) {
            $freelancer = Freelancer::find($freelancer_id);
            Notification::send($freelancer, new OrderNotification($order));
        }
        
        return redirect()->back();
    }
}