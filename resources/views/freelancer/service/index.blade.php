@extends('freelancer.layouts.app')

@section('content')
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />

    <div class="container-employer pt-4 px-lg-4 px-2">
        <div class="content pb-4">
            <div class="border rounded py-md-4 py-3 px-md-4 px-3 d-flex align-items-center justify-content-start gap-3" style="background-color: #fff;">
                <div class="py-1 px-2" style="cursor: pointer;" onclick="return goToPreviousPage()">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <h1 class="h4 text-dark mb-0" style="font-size: 17px;">Services</h1>
            </div>
            <div class="mt-3">
                <div class="d-flex align-items-center justify-content-sm-between justify-content-center flex-sm-row flex-column gap-2">
                    <div class="btn-group border" role="group" style="background-color: #fff;">
                        <button class="btn border p-0" style="font-size: 13.5px; width: 218px;">
                            <input type="text" name="keyword" id="find-service" class="px-2 form-control shadow-none p-0 h-100 w-100 border-0" placeholder="Find Service..." style="font-size: 13.5px;" onkeyup="return searchServices(this)">
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
                                <button class="dropdown-item py-2" type="button" onclick="return sortByOldest(this)">
                                    <i class="me-2 mdi mdi-format-letter-case"></i>
                                    <small class="text-muted" style="font-size: 12.5px;">Oldest</small>
                                </button>
                                <button class="dropdown-item py-2" type="button" onclick="return sortByTopOrder(this)">
                                    <i class="me-2 mdi mdi-text-box-check-outline"></i>
                                    <small class="text-muted" style="font-size: 12.5px;">Top Order</small>
                                </button>
                                <button class="dropdown-item py-2" type="button" onclick="return sortByTopRating(this)">
                                    <i class="me-2 mdi mdi-star"></i>
                                    <small class="text-muted" style="font-size: 12.5px;">Top Rating</small>
                                </button>
                            </div>
                        </div>
                        <div class="btn-group border" role="group" style="background-color: #fff;" onclick="return priceRangeTop(this)">
                            <button class="btn border" style="font-size: 13.5px;">Price Range</button>
                            <button class="btn border">
                                <i class="mdi mdi-unfold-more-horizontal"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs mt-3">
                    <li class="nav-item">
                        <span class="nav-link text-dark px-4 service-link {{ Route::is('freelancer.services') || Route::is('freelancer.services-all') ? 'active' : '' }}" data-service-link="{{ route('freelancer.services-all') }}" style="font-size: 14.5px;">All</span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link text-dark service-link {{ Route::is('freelancer.services-archive') ? 'active' : '' }}" data-service-link="{{ route('freelancer.services-archive') }}" style="font-size: 14.5px;">Archive</span>
                    </li>
                </ul>
                <div class="row mx-0 py-3 border-end border-start border-bottom mb-2" style="background-color: #fff;">
                    <div class="col-1 text-center d-flex align-items-center justify-content-center">
                        <input type="checkbox" name="" id="select-all-services">
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
                <div class="w-100 row mx-0 {{ count($services) < 1 ? 'align-items-center justify-content-center' : '' }}" id="parent-show-services" style="{{ count($services) < 1 ? 'height: 400px;' : 'height: max-content;' }} row-gap: 7px;">
                    <div class="{{ count($services) < 1 ? 'd-flex' : 'd-none' }} align-items-center justify-content-center flex-column gap-3">
                        <i class="fa-regular fa-folder-open" style="font-size: 35px;"></i>
                        <p class="mb-0 text-muted">No Services Yet</p>
                    </div>
                    @foreach ($services as $index => $service)
                        <div class="d-flex align-items-center px-0 py-2 border" id="parent_service" style="background-color: #fff;">
                            <div class="col-1 px-0 d-flex align-items-center justify-content-center">
                                <input type="checkbox" id="select-services">
                                <input type="hidden" name="slug" value="{{ $service->slug }}">
                            </div>
                            <div class="col-lg-4 col-8 d-flex align-items-start justify-content-start gap-3 ms-sm-0 ms-2">
                                <a href="{{ route('services', $service->slug) }}" class="d-block">
                                    <div class="rounded" style="height: 75px; width: 77px; overflow: hidden;">
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
                                    <small class="text-dark d-lg-block d-none text-break lh-sm">{{ Str::limit($service->title, 30) }}</small>
                                    <small class="text-dark d-lg-none d-block lh-base">{{ Str::limit($service->title, 15) }}</small>
                                    <small class="mb-0 text-muted" style="font-size: 12px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                                    <div class="d-flex align-items-center justify-content-between mt-2 w-100">
                                        <small class="mb-0 text-dark">{{ '$' . $service->price }}</small>
                                        <div class="d-lg-none d-flex flex-row-reverse">
                                            <div class="d-flex align-items-center justify-content-center gap-1 ps-1">
                                                <i class="fa-solid fa-star text-warning" style="font-size: 12.5px;"></i>
                                                <small class="text-muted">{{ $service->rating->max('stars') > 0 ? $service->rating->max('stars').'.0' : '0' }}</small>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center gap-1 pe-1 border-end">
                                                <i class="mdi mdi-text-box-check-outline" style="font-size: 15px;"></i>
                                                <small class="text-muted">{{ $service->order->where('status', 'completed')->count() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center">
                                <div class="mb-0 d-flex align-items-center justify-content-center gap-2">
                                    <i class="mdi mdi-text-box-check-outline" style="font-size: 16px;"></i>
                                    <small class="">{{ $service->order->where('status', 'completed')->count() }}</small>
                                </div>
                            </div>
                            <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center">
                                <div class="mb-0 d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i>
                                    <small class="">{{ $service->rating->max('stars') > 0 ? $service->rating->max('stars').'.0' : '0' }}</small>
                                </div>
                            </div>
                            <div class="col-lg-3 col-2 d-flex align-items-lg-center align-items-end justify-content-center flex-column" style="row-gap: 5px;">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('freelancer.edit-services', $service->slug) }}" class="btn btn-sm border btn-light px-3 d-md-block d-none">
                                        <small class="text-dark">Edit</small>
                                    </a>
                                    <div class="btn-group dropdown">
                                        <button type="button" class="border btn btn-light btn-sm" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-left py-0" style="overflow: hidden;">
                                            @if (Route::is('freelancer.services') || Route::is('freelancer.services-all'))
                                                <button class="dropdown-item py-2 archive-service-btn" type="button">
                                                    <small class="text-dark" style="font-size: 12.5px;">Archive</small>
                                                </button>
                                            @elseif (Route::is('freelancer.services-archive'))
                                                <button class="dropdown-item py-2 active-service-btn" type="button">
                                                    <small class="text-dark" style="font-size: 12.5px;">Active</small>
                                                </button>
                                            @endif
                                            <a href="{{ route('freelancer.edit-services', $service->slug) }}" type="button" class="dropdown-item py-2 d-md-none d-block">
                                                <small class="text-dark" style="font-size: 12.5px;">Edit</small>
                                            </a>
                                            <input type="hidden" value="{{ $service->slug }}" id="service-slug">
                                            <button class="dropdown-item py-2 delete-service-btn" type="button">
                                                <small class="text-dark" style="font-size: 12.5px;">Delete</small>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="w-100 d-flex align-items-center mt-3 justify-content-end gap-2 {{ count($services) < 1 ? 'd-none' : 'd-flex' }}">
                    <button class="btn btn-sm btn-dark px-3 {{ Route::is('freelancer.services') || Route::is('freelancer.services-all') ? '' : 'd-none' }}" id="archive_btn" onclick="return archiveSelectedItems()">Archive</button>
                    <button class="btn btn-sm btn-success px-3 {{ Route::is('freelancer.services-archive') ? '' : 'd-none' }}" id="active_btn" onclick="return activeSelectedItems()">Active</button>
                    <button class="btn btn-sm btn-danger px-3" onclick="return deleteSelectedItems()">Delete</button>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1800
            });
        </script>
    @endif
@endsection

