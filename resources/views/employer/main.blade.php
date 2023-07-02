@extends('employer.layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" crossorigin="anonymous">

@section('content')
<div class="container-employer pt-4 px-4">
    <div class="content">
        <div class="p-4 border" style="background-color: #fff;">
            <h1 class="h4 text-dark mb-1">My Dashboard</h1>
        </div>
        <div class="mt-3 py-4 px-2" style="height: 550px;">
            <div class="w-100 d-grid gap-2" id="dashboard-main-detail">
                <span class="shadow-sm border rounded py-3 px-0 d-flex align-items-center justify-content-center" style="background-color: #fff;">
                    <div class="col-4 d-flex justify-content-center">
                        <i style="font-size: 25px;" class="mdi mdi-currency-usd text-dark"></i>
                    </div>
                    <div class="col-8 d-flex justify-content-start">
                        <div class="">
                            <p class="mb-0 text-dark" style="font-size: 14.5px;">Earning (annual)</p>
                            <small class="text-muted fst-normal" style="font-size: 13px;">RM 0</small>
                        </div>
                    </div>
                </span>
                <span class="shadow-sm border rounded py-3 px-0 d-flex align-items-center justify-content-center" style="background-color: #fff;">
                    <div class="col-4 d-flex justify-content-center">
                        <span class="mdi mdi-camera-timer text-dark" style="font-size: 25px;"></span>
                    </div>
                    <div class="col-8 d-flex justify-content-start">
                        <div class="">
                            <p class="mb-0 text-dark" style="font-size: 14.5px;">Pending Order</p>
                            <small class="text-muted fst-normal" style="font-size: 13px;">0 Orders</small>
                        </div>
                    </div>
                </span>
                <span class="shadow-sm border rounded py-3 px-2 d-flex align-items-center justify-content-center" style="background-color: #fff;">
                    <div class="col-4 d-flex justify-content-center">
                        <i style="font-size: 27px;" class="mdi mdi-progress-clock text-dark"></i>
                    </div>
                    <div class="col-8 d-flex justify-content-start">
                        <div class="">
                            <p class="mb-0 text-dark" style="font-size: 14.5px;">Progress Order</p>
                            <small class="text-muted fst-normal" style="font-size: 13px;">0 Services</small>
                        </div>
                    </div>
                </span>
                <span class="shadow-sm border rounded py-3 px-2 d-flex align-items-center justify-content-center" style="background-color: #fff;">
                    <div class="col-4 d-flex justify-content-center">
                        <i style="font-size: 27px;" class="mdi mdi-text-box-check-outline text-dark"></i>
                    </div>
                    <div class="col-8 d-flex justify-content-start">
                        <div class="">
                            <p class="mb-0 text-dark" style="font-size: 14.5px;">Order Completed</p>
                            <small class="text-muted fst-normal" style="font-size: 13px;">0 Services</small>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>
@endsection