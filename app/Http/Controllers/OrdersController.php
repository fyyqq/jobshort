<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use App\Models\NotificationModel;
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
        return view('freelancer.order.pending', [ 
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'pending')->get()
        ]);
    }
    
    public function approved()
    {
        return view('freelancer.order.pending', [ 
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'approved')->get()
        ]);
    }
    
    public function rejected()
    {
        return view('freelancer.order.pending', [ 
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'rejected')->get()
        ]);
    }
    
    public function completed()
    {
        return view('freelancer.order.pending', [
            "orders" => Order::where('freelancer_id', auth()->user()->freelancer->id)->where('status', 'completed')->get()
        ]);
    }

    public function approve(string $id) 
    {
        $order = Order::where('id', $id)->first();
        $order->status = 'approved';
        $orders = $order->save();

        if ($orders) {
            $user = User::find($order->user_id);
            Notification::send($user, new ApproveNotification($order));
        }
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
        $orders = $order->save();

        if ($orders) {
            $freelancer = Freelancer::find($order->freelancer_id);
            Notification::send($freelancer, new CompleteOrderNotification($order));
        }
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

        // $notificationCount = NotificationModel::where('notifiable_id', Auth::id())->count();
        // return $notificationCount;
    }
}