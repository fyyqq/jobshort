@extends('layouts.app')

@section('content')
    <div class="container-md">
        <div class="d-flex justify-content-center align-items-center">
            <div class="card" id="card_payment">
                <div class="card-header py-3 text-center" style="background-color: #fff;">
                    <h1 class="mb-0 h5 text-dark">Your Payment Successfull <i class="ms-1 text-success mdi mdi-checkbox-marked-circle"></i></h1>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center flex-column">
                    <div class="rounded mt-3 mb-1">
                        <img src="{{ asset('brand/payment-success.png') }}" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="my-4 text-center" id="text_payment">
                        <small class="text-muted lh-1">Thank's for your order. Seller will be reach out to as soon as possible.</small>
                    </div>
                    <div class="py-3 text-center border-top w-100 border-bottom">
                        <p class="mb-0 text-dark">Payment Information</p>
                    </div>
                    <div class="w-100 py-3 border-bottom">
                        <div class="row mx-0">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-muted">Payment Method :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-muted">Visa</small>
                            </div>
                        </div>
                        <div class="row mx-0 mt-2">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-muted">Name :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-muted">Muhamad Afiq Hakimi</small>
                            </div>
                        </div>
                        <div class="row mx-0 mt-2">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-muted">Email Address :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-muted">Afiqakimy123@gmail.com</small>
                            </div>
                        </div>
                        <div class="row mx-0 mt-2">
                            <div class="col-4 d-flex align-items-center justify-content-start">
                                <small class="text-muted">Amount :</small>
                            </div>
                            <div class="col-8 d-flex align-items-center justify-content-end">
                                <small class="text-muted">$1</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 w-100 d-flex align-items-center justify-content-between">
                        <form action="{{ route('home') }}" method="get">
                            <button class="btn btn-sm border px-4"><i class="fa-solid fa-arrow-left"></i></button>
                        </form>
                        <button class="btn btn-sm btn-primary px-3">Check Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection