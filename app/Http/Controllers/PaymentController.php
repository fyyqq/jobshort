<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
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
            'success_url' => route('success_payment', $service->slug),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request) {
    }
}
