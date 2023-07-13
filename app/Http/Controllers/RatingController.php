<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Service;
use App\Notifications\ReviewNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class RatingController extends Controller
{
    public function index(string $slug) {
        $service = Service::where('slug', $slug)->first();

        return view('reviews', [
            "reviews" => Rating::where('service_id', $service->id)->get(),
            "service" => $service
        ]);
    }

    public function view(string $slug) {
        return view('freelancer.applicant.ratings', [
            "data" => Order::where('slug', $slug)->first()
        ]);
    }

    public function store(Request $request) {

        if ($request->hasFile('images')) {
            $imagePath = uniqid() . '.' . $request->file('images')->getClientOriginalExtension();
            $request->file('images')->move(public_path('images'), $imagePath);
        } else {
            $imagePath = null;
        }

        $rating = new Rating();
        $rating->order_id = $request->input('order_id');
        $rating->user_id = $request->input('user_id');
        $rating->freelancer_id = $request->input('freelancer_id');
        $rating->service_id = $request->input('service_id');
        $rating->images = $imagePath;
        $rating->stars = $request->input('stars');
        $rating->title = $request->input('title');
        $rating->review = $request->input('review');
        $rating->save();

        $order_id = $request->input('order_id');
        $order = Order::where('id', $order_id)->first();
        $order->rating = true;
        $orders = $order->save();

        if ($orders) {
            $freelancer = Freelancer::find($order->freelancer_id);
            Notification::send($freelancer, new ReviewNotification($order));
        }

        return route('profile.order-completed');
    }
}
