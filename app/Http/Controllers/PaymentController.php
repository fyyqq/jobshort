<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use App\Models\Freelancer;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function index() {
        return view('payment.index');
    }

    public function session(Request $request) {
        Stripe::setApiKey(config('stripe.sk'));

        $service_id = $request->input('service_id');
        $service_price = $request->input('price') * 100;

        $service = Service::find($service_id);

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'USD',
                        'product_data' => [ 
                            'name' => $service->title
                        ],
                        'unit_amount' => $service_price
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success', $service->slug),
            'cancel_url' => route('cancel', $service->slug),
        ]);

        session(['session_id' => $session->id]);
        session(['session_service' => $service]);

        return redirect()->away($session->url);
    }

    public function success() {
        Stripe::setApiKey(config('stripe.sk'));
        $sessionId = session('session_id');
        $service = session('session_service');

        $stripeSession = \Stripe\Checkout\Session::retrieve($sessionId);
        
        $order = new Order();
        $order->user_id = Auth::id();
        $order->service_id = $service->id;
        $order->freelancer_id = $service->freelancer->id;
        $confirmOrder = $order->save();
    
        if ($confirmOrder) {
            $freelancer = Freelancer::find($service->freelancer->id);
            Notification::send($freelancer, new OrderNotification($order));
        }

        session()->put('detail', $stripeSession);
        session()->put('service', $service);

        return redirect()->route('order.success', $service->slug);
    }

    public function pages() {
        $detail = session('detail');
        $service = session('service');

        return view('payment.success', [
            'detail' => $detail,
            'service' => $service
        ]);
    }

    public function cancel() {
        $service = session('session_service');
        return redirect()->route('services', $service->slug);
    }
}
