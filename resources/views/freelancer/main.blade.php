@extends('freelancer.layouts.app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" crossorigin="anonymous">

    <div class="container-employer pt-4 px-4">
        <div class="content">
            <div class="border rounded py-4 px-4" style="background-color: #fff;">
                <h1 class="h4 text-dark mb-0" style="font-size: 17px;">Dashboard</h1>
            </div>
            <div class="mt-3 pt-2">
                <div class="w-100 d-grid gap-2" id="dashboard-main-detail">
                    <span class="shadow-sm border rounded py-3 px-0 d-flex align-items-center justify-content-center" style="background-color: #fff;">
                        <div class="col-4 d-flex justify-content-center">
                            <i style="font-size: 25px;" class="mdi mdi-currency-usd text-dark"></i>
                        </div>
                        <div class="col-8 d-flex justify-content-start">
                            <div class="">
                                <p class="mb-0 text-dark" style="font-size: 14.5px;">Earning (annual)</p>
                                <small class="text-muted fst-normal" style="font-size: 13px;">$ 0</small>
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
                                <small class="text-muted fst-normal" style="font-size: 13px;">{{ count($orders->where('status', 'pending')) }} Orders</small>
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
                                <small class="text-muted fst-normal" style="font-size: 13px;">{{ count($orders->where('status', 'approved')) }} Services</small>
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
                                <small class="text-muted fst-normal" style="font-size: 13px;">{{ count($orders->where('status', 'completed')) }} Services</small>
                            </div>
                        </div>
                    </span>
                </div>
                <div class="row mx-0 h-100 mt-4">
                    <div class="col-lg-8 col-12 px-0 mb-lg-0 mb-3">
                        <div class="border rounded shadow-sm" style="background-color: #fff;">
                            <div class="d-flex align-items-center justify-content-between border-bottom p-4">
                                <h1 class="h6 mb-0 text-dark">Services</h1>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('freelancer.create-service') }}" class="btn px-3 btn-sm btn-outline-dark"><i class="fa-solid fa-plus"></i></a>
                                    <a href="{{ route('freelancer.services') }}" class="btn px-3 btn-sm btn-primary"><i class="mdi mdi-arrow-top-right-thin"></i></a>
                                </div>
                            </div>
                            <div class="pb-3">
                                <div class="row mx-0 py-3 border-bottom mb-2">
                                    <div class="col-lg-5 col-8 d-flex align-items-center justify-content-lg-center justify-content-center">
                                        <small class="mb-0" style="font-size: 13px;">Service Details</small>
                                    </div>
                                    <div class="col-2 d-lg-flex d-none align-items-center justify-content-center">
                                        <small class="mb-0" style="font-size: 13px;">Price</small>
                                    </div>
                                    <div class="col-2 d-lg-flex d-none align-items-center justify-content-center">
                                        <small class="mb-0" style="font-size: 13px;">Sold</small>
                                    </div>
                                    <div class="col-lg-2 col-4 d-flex align-items-center justify-content-lg-end justify-content-center">
                                        <small class="mb-0" style="font-size: 13px;">Status</small>
                                    </div>
                                </div>
                                <div class="px-4 w-100 row mx-0" id="parent-show-services" style="row-gap: 5px;">
                                    @foreach ($services as $index => $service)
                                        <div class="d-flex align-items-center px-2 py-2">
                                            <div class="col-lg-5 col-12 d-flex align-items-start justify-content-start gap-3 ms-sm-0 ms-2">
                                                <a href="{{ route('services', $service->slug) }}" class="d-block">
                                                    <div class="rounded" style="height: 65px; width: 65px; overflow: hidden;">
                                                        @foreach (explode(',', $service->image) as $key => $value)
                                                            @if ($key === 0)
                                                                <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </a>
                                                <?php
                                                    $category_name = $service->category;
                                                    $pathCategories = file_get_contents(public_path('json/category.json'));
                                                    $data = json_decode($pathCategories, true);
                                                    
                                                    $filter = array_filter($data, function($category) use($category_name) {
                                                        return $category['slug'] === $category_name;
                                                    });
                                                ?>
                                                <div class="d-flex align-items-start justify-content-start flex-column mt-1 pe-4 w-100">
                                                    <small class="text-dark d-block text-break lh-sm" style="font-size: 13px;">{{ Str::limit($service->title, 30) }}</small>
                                                    <small class="mb-0 text-muted" style="font-size: 12px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                                                    <div class="d-lg-none d-flex align-items-center justify-content-between mt-2 w-100">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <small class="mb-0 text-dark">{{ '$' . $service->price }}</small>
                                                            <div class="d-flex align-items-center justify-content-center gap-1 ps-2 ms-2 border-start">
                                                                <i class="mdi mdi-text-box-check-outline" style="font-size: 15px;"></i>
                                                                <small class="text-muted">{{ $service->order->where('status', 'completed')->count() }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-lg-none d-flex flex-row-reverse">
                                                            <div class="d-flex align-items-center justify-content-center gap-1 ps-1">
                                                                <i class="fa-solid fa-circle text-success" style="font-size: 12.5px;"></i>
                                                                <small class="text-muted">{{ $service->status }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center">
                                                <small class="" style="font-size: 13px;">{{ '$' . $service->price }}</small>
                                            </div>
                                            <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center gap-1">
                                                <i class="mdi mdi-text-box-check-outline" style="font-size: 15px;"></i>
                                                <small class="mb-1" style="font-size: 13px;">{{ count($service->order->where('status', 'completed')) }}</small>
                                            </div>
                                            <div class="col-lg-3 col-0 d-lg-flex d-none align-items-center justify-content-center">
                                                <div class="mb-0 d-flex align-items-center justify-content-center gap-2">
                                                    <i class="fa-solid fa-circle {{ $service->status != 'active' ? 'text-muted' : 'text-success' }}" style="font-size: 13px;"></i>
                                                    <small class="pb-1" style="font-size: 13px;">{{ $service->status }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12 pe-lg-0 ps-lg-3 px-0">
                        <div class="border rounded shadow-sm" style="background-color: #fff;">
                            <div class="d-flex align-items-center justify-content-between border-bottom p-4">
                                <h1 class="h6 mb-0 text-dark">Orders</h1>
                                <a href="{{ route('freelancer.services') }}" class="btn px-3 btn-sm btn-primary"><i class="mdi mdi-arrow-top-right-thin"></i></a>
                            </div>
                            <div class="py-2 px-2">
                                @foreach($pendings as $pending)
                                    <div class="p-3 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center justify-content-start gap-3">
                                            <div class="">
                                                <div class="rounded-circle border" style="height: 43px; width: 43px; overflow: hidden;">
                                                    <img src="{{ $pending->user->image != 'null' ? asset('images/' . $pending->user->image) : asset('brand/unknown.png') }}" class="w-100 h-100">
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start justify-content-center flex-column">
                                                <small class="text-dark lh-1" style="font-size: 13px;">{{ $pending->user->name }}</small>
                                                <small class="text-muted" style="font-size: 12px;">{{ $pending->status }}</small>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1">
                                            <i class="mdi mdi-message-text"></i>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection