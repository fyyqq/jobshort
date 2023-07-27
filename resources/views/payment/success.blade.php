@extends('layouts.app')

@section('content')
    <div class="container-md">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card" id="card_payment">
                <div class="card-header py-3 text-center" style="background-color: #fff;">
                    <h1 class="mb-0 h5">Payment Succeed <i class="ms-1 text-success mdi mdi-checkbox-marked-circle"></i></h1>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center flex-column">
                    <div class="rounded mt-3 mb-1">
                        <img src="{{ asset('brand/payment-success.png') }}" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="my-4 text-center" id="text_payment">
                        <small class="text-muted lh-sm fst-italic">Thank's for your order. Seller will be reach out to you as soon as possible.</small>
                    </div>
                    <div class="py-3 text-center border-top w-100 border-bottom">
                        <p class="mb-0 text-dark">Payment Information</p>
                    </div>
                    <div class="w-100 py-3 border-bottom">
                        <div class="row mx-0">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-dark">Payment Method :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-dark">{{ $detail->payment_method_types[0] }}</small>
                            </div>
                        </div>
                        <div class="row mx-0 mt-2">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-dark">Name :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-dark">{{ $detail->customer_details->name }}</small>
                            </div>
                        </div>
                        <div class="row mx-0 mt-2">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-dark">Email Address :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-dark">{{ $detail->customer_details->email }}</small>
                            </div>
                        </div>
                        <div class="row mx-0 mt-2">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-dark">Amount :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-dark">${{ $service->price }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 w-100 d-flex align-items-center justify-content-between">
                        <form action="{{ route('services', $service->slug) }}" method="get">
                            <button class="btn btn-sm border px-4"><i class="fa-solid fa-arrow-left"></i></button>
                        </form>
                        <a href="{{ route('profile.order') }}" class="btn btn-sm btn-primary px-3">Check Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection