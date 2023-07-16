@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row mx-0">
            <div class="col-md-8 col-12 pe-2">
                <div class="d-flex align-items-start justify-content-start flex-sm-row flex-column gap-3 shadow-sm ps-3 pe-4 py-3 position-relative flex-row" style="background-color: #fff;">
                    <div id="parent_image_category">
                        <div class="rounded border" id="category_image">
                            <img src="{{ asset('category' . $category['image']) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                        </div>
                    </div>
                    <div class="pt-md-2 pb-md-2 pt-1 pb-5">
                        <h1 class="h5 mb-2 text-dark"><i class="{{ $category['icon'] }} me-2"></i>{{ $category['name'] }}</h1>
                        <small class="d-block lh-sm text-muted" style="font-size: 13px;">{{ $category['about'] }}</small>
                        <div class="position-absolute bottom-0 d-flex align-items-center justify-content-between pb-3">
                            <div class="d-flex align-items-center justify-content-start gap-1">
                                <i class="mdi mdi-text-box-check-outline" style="font-size: 17px;"></i>
                                <small class="text-muted" style="font-size: 14px;">{{ empty($count->order) ? '0' : $count->order->where('status', 'completed')->count() }}</small>
                            </div>
                            <span class="mx-2 text-muted" style="font-size: 14px; transform: translateY(-1px);">|</span>
                            <div class="d-flex align-items-center justify-content-start gap-1">
                                <i class="fa-solid fa-star text-warning" style="font-size: 14px;"></i>
                                <small class="text-muted" style="font-size: 14px;">{{ empty($count->order) ? '0' : $count->rating->max('stars') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 row mx-0" style="{{ count($services) > 0 ? 'row-gap: 15px;' : 'height: 450px; display: grid; place-items: center;' }}">
                @if (count($services) > 0)
                <div class="d-flex align-items-center justify-content-between flex-row-reverse w-100 gap-md-2 gap-0">
                    <div class="col-md-3 col-5 px-md-0 px-1">
                        <div class="rounded-3 border" id="select">
                            <select name="" class="ps-3 w-100 text-dark h-100" style="font-size: 13px;" onchange="return sortCategoryService(this)">
                                <option value="normal" selected>Sort By</option>
                                <option value="latest">Latest</option>
                                <option value="oldest">Oldest</option>
                                <option value="highest-order">Highest Order</option>
                                <option value="lowest-order">Lowest Order</option>
                                <option value="highest-rating">Highest Rating</option>
                                <option value="lowest-rating">Lowest Rating</option>
                                <option value="highest-price">Highest Price</option>
                                <option value="lowest-price">Lowest Price</option>
                            </select>
                        </div>
                        <input type="hidden" id="category_name" value="{{ $category['name'] }}">
                    </div>
                    <div class="px-1">
                        <small class="text-dark">{{ count($services) }} results</small>
                    </div>
                </div>
                <span id="service_container" class="row mx-0" style="row-gap: 15px;">
                    @foreach ($services as $key => $service)
                        <div class="col-sm-6 col-12">
                            <a href="{{ route('services', $service->slug) }}" class="d-block text-decoration-none">
                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <div class="rounded w-100 position-relative" style="height: 220px; overflow: hidden;">
                                        @foreach (explode(',', $service->image) as $key => $image)
                                            @if ($key === 0)
                                                <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                            @endif
                                        @endforeach
                                        @if (!auth()->check())
                                            <form action="{{ route('login') }}" method="get">
                                                @csrf
                                                <button type="submit" class="border-0" style="background: unset;">
                                                    <i class="fa-regular fa-heart position-absolute" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                                </button>
                                            </form>
                                        @else
                                            <i class="fa-solid fa-heart position-absolute unwishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-block' : 'd-none' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                            <input type="hidden" value="{{ route('wishlist-service', $service->id) }}" id="wishlist_path">
                                            <input type="hidden" value="{{ route('unwishlist-service', $service->id) }}" id="unwishlist_path">
                                            <i class="fa-regular fa-heart position-absolute wishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-none' : 'd-block' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                        @endif
                                    </div>
                                    <div class="p-2 w-100 mt-1">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <p class="mb-0 text-dark" style="width: 95%; font-size: 14.5px;">{{ Str::limit($service->title, 35) }}</p>
                                            <div class="d-flex align-items-center justify-content-end flex-row-reverse">
                                                <i class="fa-solid fa-star text-warning" style="font-size: 13.5px;"></i>
                                                <small class="me-1 text-dark" style="font-size: 13.5px;">{{ $service->rating->max('stars') < 1 ? '0' : $service->rating->max('stars') . '.0' }}</small>
                                            </div>
                                        </div>
                                        <small class="text-muted d-block" style="font-size: 12px;">{{ $service->category }}</small>
                                        <div class="mt-2 d-flex align-items-center justify-content-between">
                                            <small class="mb-0 text-dark" style="font-size: 14.5px;">{{ '$' . $service->price }}</small>
                                            <small class="mb-0 text-dark"><i class="me-1 mdi mdi-text-box-check-outline"></i>{{ count($service->order->where('status', 'completed')) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </span>
                @else
                    <div class="d-flex align-items-center justify-content-center flex-column gap-3">
                        <i class="fa-regular fa-folder-open" style="font-size: 35px;"></i>
                        <small class="text-muted text-center">Empty Service Category</small>
                    </div>
                @endif
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="ps-2 pt-1 pb-2 d-flex align-items-center justify-content-start gap-2">
                    <i class="mdi mdi-magnify" style="font-size: 17px;"></i>
                    <small class="mb-0 text-dark">More Categories</small>
                </div>
                <div class="d-md-grid d-none" style="row-gap: 10px;">
                    @foreach ($categories as $value)
                        <a href="{{ route('category', $value['slug']) }}" class="text-decoration-none">
                            <div class="border shadow-sm w-100 d-flex align-items-center justify-content-center flex-column" style="height: 200px; background-color: #fff;">
                                <i class="{{ $value['icon'] }} fs-1 text-dark"></i>
                                <h1 class="h6 text-muted">{{ $value['name'] }}</h1>
                            </div>
                        </a>
                    @endforeach
                    <a href="{{ route('categories') }}" class="text-decoration-none">
                        <div class="border shadow-sm w-100 d-flex align-items-center justify-content-center flex-column" style="height: 200px; background-color: #fff;">
                        <i class="mdi mdi-view-dashboard fs-1 text-dark"></i>
                        <h1 class="h6 text-muted">More Services</h1>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection