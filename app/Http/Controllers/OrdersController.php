<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderNotification;
use App\Notifications\ApproveNotification;
use App\Notifications\CompleteOrderNotification;
use Illuminate\Support\Facades\Notification;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('freelancer.order.index', [ 
            "orders" => Order::with(['service', 'rating', 'user'])
            ->where('freelancer_id', auth()->user()->freelancer->id)
            ->where('status', 'pending')->get()
        ]);
    }
    
    public function pending()
    {
        $orders = Order::with(['service', 'rating', 'user'])
        ->where('freelancer_id', auth()->user()->freelancer->id)
        ->where('status', 'pending')->get();

        if (request()->ajax()) {
            return view('freelancer.order.action', ["orders" => $orders]);
        } else {
            return view('freelancer.order.index', ["orders" => $orders]);
        }
    }
    
    public function approved()
    {
        $orders = Order::with(['service', 'rating', 'user'])
        ->where('freelancer_id', auth()->user()->freelancer->id)
        ->where('status', 'approved')->get();
     
        if (request()->ajax()) {
            return view('freelancer.order.action', ["orders" => $orders]);
        } else {
            return view('freelancer.order.index', ["orders" => $orders]);
        }
    }
    
    public function rejected()
    {
        $orders = Order::with(['service', 'rating', 'user'])
        ->where('freelancer_id', auth()->user()->freelancer->id)
        ->where('status', 'rejected')->get();
        
        if (request()->ajax()) {
            return view('freelancer.order.action', ["orders" => $orders]);
        } else {
            return view('freelancer.order.index', ["orders" => $orders]);
        }
    }
    
    public function completed()
    {
        $orders = Order::with(['service', 'rating', 'user'])
        ->where('freelancer_id', auth()->user()->freelancer->id)
        ->where('status', 'completed')->get();
        
        if (request()->ajax()) {
            return view('freelancer.order.action', ["orders" => $orders]);
        } else {
            return view('freelancer.order.index', ["orders" => $orders]);
        }
    }

    public function approve(string $id) 
    {
        $order = Order::where('id', $id)->first();
        $order->status = 'approved';
        $confirmOrder = $order->save();

        if ($confirmOrder) {
            $user = User::find($order->user_id);
            Notification::send($user, new ApproveNotification($order));

            return true;
        }
    }
    
    public function reject(string $id) 
    {
        $order = Order::where('id', $id)->first();
        $order->status = 'rejected';
        $confirmOrder = $order->save();

        if ($confirmOrder) {
            return true;
        }
    }
    
    public function complete(string $id) 
    {
        $order = Order::where('id', $id)->first();
        $order->status = 'completed';
        $confirmOrder = $order->save();

        if ($confirmOrder) {
            $freelancer = Freelancer::find($order->freelancer_id);
            Notification::send($freelancer, new CompleteOrderNotification($order));

            return true;
        }
    }

    public function store(string $service_id, string $freelancer_id) {
        $order = new Order();
        $order->user_id = Auth::id();
        $order->service_id = $service_id;
        $order->freelancer_id = $freelancer_id;
        $confirmOrder = $order->save();

        if ($confirmOrder) {
            $freelancer = Freelancer::find($freelancer_id);
            Notification::send($freelancer, new OrderNotification($order));
            
            return true;
        }
    }
}