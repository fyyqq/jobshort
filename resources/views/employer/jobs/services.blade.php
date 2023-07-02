@extends('employer.jobs.layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />

@section('service-pages')
        <div class="mb-3">
            <div class="d-flex align-items-center justify-content-sm-between justify-content-center flex-sm-row flex-column gap-2">
                <div class="btn-group border" role="group" style="background-color: #fff;">
                    <button class="btn border p-0" style="font-size: 13.5px; width: 218px;">
                        <input type="text" name="" id="find-service" class="px-2 form-control shadow-none p-0 h-100 w-100 border-0" placeholder="Find Service..." style="font-size: 13.5px;">
                    </button>
                    <button class="btn border">
                        <i class="mdi mdi-magnify text-muted"></i>
                    </button>
                </div>
                <div class="dropdown">
                    <div class="btn-group border" data-bs-toggle="dropdown" role="group" style="background-color: #fff;">
                        <button class="btn border px-3" style="font-size: 13.5px;">Sort By</button>
                        <button class="btn border">
                            <i class="mdi mdi-menu-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-left py-0">
                            <button class="dropdown-item py-2" type="button">
                                <i class="me-2 mdi mdi-format-letter-case"></i>
                                <small class="text-muted" style="font-size: 12.5px;">Letter</small>
                            </button>
                            <button class="dropdown-item py-2" type="button">
                                <i class="me-2 mdi mdi-text-box-check-outline"></i>
                                <small class="text-muted" style="font-size: 12.5px;">Top Order</small>
                            </button>
                            <button class="dropdown-item py-2" type="button">
                                <i class="me-2 mdi mdi-star"></i>
                                <small class="text-muted" style="font-size: 12.5px;">Top Rating</small>
                            </button>
                        </div>
                    </div>
                    <div class="btn-group border" role="group" id="price-range" style="background-color: #fff;">
                        <button class="btn border" style="font-size: 13.5px;">Price Range</button>
                        <button class="btn border">
                            <i class="mdi mdi-unfold-more-horizontal"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mx-0 py-3 border mb-2 mt-4" style="background-color: #fff;">
                <div class="col-1 text-center d-flex align-items-center justify-content-center">
                    <input type="checkbox" name="" id="select-all-jobs" class="" onclick="allJobs()">
                </div>
                <div class="col-lg-4 col-8 d-flex align-items-center justify-content-start">
                    <small class="mb-0">Service Details</small>
                </div>
                <div class="col-2 d-lg-flex d-none align-items-center justify-content-center">
                    <small class="mb-0">Order</small>
                </div>
                <div class="col-2 d-lg-flex d-none align-items-center justify-content-center">
                    <small class="mb-0">Rating</small>
                </div>
                <div class="col-lg-3 col-2 d-flex align-items-center justify-content-lg-center justify-content-end">
                    <small class="mb-0">Action</small>
                </div>
            </div>
            <div class="w-100 row mx-0" style="row-gap: 7px;">
                @foreach ($services as $service)
                <div class="d-flex align-items-center px-0 py-2 border" style="background-color: #fff;">
                    <div class="col-1 px-0 d-flex align-items-center justify-content-center">
                        <input type="checkbox" name="" id="select-jobs">
                        <input type="hidden" name="slug" value="{{ $service->slug }}">
                    </div>
                    <div class="col-lg-4 col-8 d-flex align-items-start justify-content-start gap-3 ms-sm-0 ms-2">
                        <div class="rounded" style="height: 75px; width: 110px; overflow: hidden;">
                            @foreach (explode(',', $service->image) as $key => $value)
                                @if ($key === 0)
                                    <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;">
                                @endif
                            @endforeach
                        </div>
                        <div class="d-flex align-items-start justify-content-start flex-column mt-1 pe-4 w-100">
                            <small class="text-dark d-lg-block d-none text-break lh-sm">{{ Str::limit($service->title, 30) }}</small>
                            <small class="text-dark d-lg-none d-block lh-base">{{ Str::limit($service->title, 15) }}</small>
                            <small class="mb-0 text-muted" style="font-size: 12px;">{{ $service->category }}</small>
                            <div class="d-flex align-items-center justify-content-between mt-2 w-100">
                                <small class="mb-0 text-dark">${{ $service->price }}</small>
                                <div class="d-lg-none d-flex">
                                    <div class="d-flex align-items-center justify-content-center gap-1 pe-1 border-end">
                                        <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i>
                                        <small class="text-muted">3.0</small>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center gap-1 ps-1">
                                        <i class="mdi mdi-text-box-check-outline" style="font-size: 15px;"></i>
                                        <small class="text-muted">15</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center">
                        <div class="mb-0 d-flex align-items-center justify-content-center gap-2">
                            <i class="mdi mdi-text-box-check-outline" style="font-size: 13px;"></i>
                            <small class="">200</small>
                        </div>
                    </div>
                    <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center">
                        <div class="mb-0 d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i>
                            <small class="">4.0</small>
                        </div>
                    </div>
                    <div class="col-lg-3 col-2 d-flex align-items-lg-center align-items-end justify-content-center flex-column" style="row-gap: 5px;">
                        <div class="btn-group" role="group">
                            <button style="opacity: 0;">
                                <form action="{{ route('employer.update-archive-jobs', $service->slug) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm border btn-light px-3 d-md-block d-none">
                                        <small class="text-dark">Edit</small>
                                    </button>
                                </form>
                            </button>
                            <div class="btn-group dropdown">
                                <button type="button" class="border btn btn-light btn-sm" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-left py-0" style="overflow: hidden;">
                                    <button class="dropdown-item py-2" type="button">
                                        <i class="me-2 mdi mdi-archive"></i>
                                        <small class="text-muted" style="font-size: 12.5px;">Archive</small>
                                    </button>
                                    <form action="{{ route('employer.update-archive-jobs', $service->slug) }}" method="post" class="">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="dropdown-item py-2 d-md-none d-block">
                                            <i class="me-2 mdi mdi-pencil"></i>
                                            <small class="text-dark">Edit</small>
                                        </button>
                                    </form>
                                    <form action="{{ route('employer.delete-jobs', $service->slug) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item py-2" type="button">
                                            <i class="me-2 mdi mdi-delete"></i>
                                            <small class="text-muted" style="font-size: 12.5px;">Delete</small>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="w-100 d-flex align-items-center justify-content-end {{ count($services) < 1 ? 'd-none' : 'd-flex mt-3' }}">
                <button class="btn btn-md btn-danger px-4" onclick="deleteSelectedItems()">Delete</button>
            </div>
        </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
