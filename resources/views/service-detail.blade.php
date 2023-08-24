@extends('layouts.app')

@section('content')
<style>
    .owl-carousel .owl-item .item {
        width: 320px;
        background-color: transparent;
    }
    .owl-carousel .owl-stage-outer {
        padding-left: 0px;
    }
    .owl-carousel .owl-nav {
        margin: 0px;
    }
    .owl-carousel .fa-angle-left, 
    .owl-carousel .fa-angle-right {
        font-size: 22px;
        position: absolute;
        top: 50%;
        transform: translateY(-100%);
        color: #333;
        height: 42px;
        width: 42px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background-color: #fff;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
    }
</style>
    {{-- Mobile Navbar --}}
    <div class="shadow-sm {{ Route::currentRouteName() === 'services' ? 'd-block' : 'd-none' }}">
        <div class="" id="mobile-navbar">
            <div class="row mx-0">
                <div class="d-flex align-items-center justify-content-between ps-4 pe-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="mdi mdi-message-text" style="font-size: 20px;"></i>
                    </div>  
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <h1 class="h6 mb-0 text-dark">{{ '$' . $service->price }}</h1>
                        <form action="{{ route('session', $service->slug) }}" method="post">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <input type="hidden" name="price" value="{{ $service->price }}">
                            <button type="submit" class="btn text-light w-100 py-2" style="background-color: #2891e1; font-size: 14px;">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-lg">
        <div class="mt-4 mb-3 ps-1">
            <h1 class="h4 text-dark d-md-block d-none">{{ $service->title }}</h1>
            <h1 class="h5 text-dark d-md-none d-block">{{ $service->title }}</h1>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted">{{ $service->freelancer->country }}</small>
                    <small class="text-muted">|</small>
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i>
                        @if (count($service->rating) > 0)
                            <small class="text-muted ms-1">{{ $service->rating->max('stars') }} Stars</small>
                        @else
                            <small class="text-muted ms-1">N/A</small>
                        @endif
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 me-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 13.5px; cursor: pointer;"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        @if (auth()->check())
                            <i class="fa-solid fa-heart unwishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-block' : 'd-none' }}"></i>
                            <input type="hidden" value="{{ route('wishlist-service', $service->id) }}" id="wishlist_path">
                            <input type="hidden" value="{{ route('unwishlist-service', $service->id) }}" id="unwishlist_path">
                            <i class="fa-regular fa-heart wishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-none' : 'd-block' }}"></i>
                        @else
                            <form action="{{ route('login') }}" method="get">
                                @csrf
                                <button type="submit" class="border-0" style="background: unset;">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid mt-3 rounded-3" id="service-gallery-container" style="overflow: hidden;">
            <div class="d-md-none d-block">
                <div id="carouselMDExample" class="carousel slide carousel-fade">
                    <div class="carousel-inner bg-dark mb-4 shadow-sm-strong rounded-3" id="service-img-mobile" style="overflow: hidden;">
                        @foreach (explode(',', $service->image) as $key => $value)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" data-fancybox="gallery-phone" data-src="{{ asset('images/' . $value) }}">
                                <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
                                    <img src="{{ asset('images/' . $value) }}" class="img-fluid w-100 h-100" style="object-fit: cover;" loading="lazy">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="d-none">
                        {{-- All Images --}}
                        @foreach (explode(',', $service->image) as $key => $value)
                            @if ($key > 4)
                                <a href="{{ asset('images/' . $value) }}" class="fancybox detail-image" data-fancybox="gallery-phonne"></a>
                            @endif
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMDExample"
                      data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Prev</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMDExample"
                    data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <div class="carousel-indicators" style="margin-bottom: -35px;">
                        @foreach (explode(',', $service->image) as $key => $value)
                            <button type="button" data-bs-target="#carouselMDExample" data-bs-slide-to="{{ $key }}" class="bg-dark rounded-circle {{ $key === 0 ? 'active' : '' }}" style="height: 7px; width: 7px;"></button>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="position-relative bg-dark d-md-flex d-none align-items-center justify-content-center">
                @foreach (explode(',', $service->image) as $key => $value)
                    @if ($key === 0)
                        <a href="{{ asset('images/' . $value) }}" class="w-100 detail-image" style="height: 100%; overflow: hidden;" data-fancybox="gallery" data-src="{{ asset('images/' . $value) }}">
                            <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover" loading="lazy">
                        </a>
                    @endif
                @endforeach
            </div>
            <div class="d-md-block d-none">
                <div class="d-md-grid d-none h-100 w-100" id="gallery-img">
                    {{-- Display --}}
                    @foreach (explode(',', $service->image) as $key => $value)
                        @if ($key >= 1 && $key < 5)
                            <a href="{{ asset('images/' . $value) }}" class="detail-image" style="overflow: hidden;" data-fancybox="gallery" data-src="{{ asset('images/' . $value) }}">
                                <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover" loading="lazy">
                            </a>
                        @endif
                    @endforeach
                </div>
                <div class="d-none">
                    {{-- All Images --}}
                    @foreach (explode(',', $service->image) as $key => $value)
                        @if ($key > 4)
                            <a href="{{ asset('images/' . $value) }}" class="fancybox detail-image" data-fancybox="gallery"></a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-md-4 mt-3 mb-2 pb-4 {{ count($similiar) > 0 ? 'border-bottom' : '' }}">
            <div class="row mx-0">
                <div class="col-md-7 col-12 px-0">
                    <div class="py-md-3 py-2 px-md-4 px-3 border rounded d-flex align-items-center justify-content-between" >
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="{{ route('users', strtolower($service->freelancer->name)) }}" class="text-decoration-none border rounded-circle" style="height: 38px; width: 38px; overflow: hidden;">
                                <img src="{{ $service->freelancer->image !== null ? asset('images/' . $service->freelancer->image) : asset('brand/unknown.png') }}" alt="" class="w-100 h-100" style="object-fit: cover" loading="lazy">
                            </a>
                            <a href="{{ route('users', strtolower($service->freelancer->name)) }}" class="text-decoration-none d-flex align-items-start justify-content-center flex-column">
                                <small class="text-dark ms-3 lh-sm">{{ $service->freelancer->name }}</small>
                                <small class="text-muted ms-3" style="font-size: 12px;">{{ $service->freelancer->skills }}</small>
                            </a>
                        </div>
                        <div class="d-flex align-items-center justify-content-center pe-3">
                            <input type="hidden" id="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" id="freelancer_id" value="{{ $service->freelancer->id }}">
                            @if (auth()->check())
                                <i class="mdi mdi-bell-outline text-muted {{ count(auth()->user()->notify->where('freelancer_id', $service->freelancer->id)) != 1 ? 'd-block' : 'd-none' }}" id="notify" style="font-size: 18px; cursor: pointer;"></i>
                                <i class="mdi mdi-bell-ring text-muted {{ count(auth()->user()->notify->where('freelancer_id', $service->freelancer->id)) == 1 ? 'd-block' : 'd-none' }}" id="disnotify" style="font-size: 18px; cursor: pointer;"></i>
                            @else
                                <form action="{{ route('login') }}" method="get">
                                    @csrf
                                    <button type="submit" class="border-0" style="background: unset;">
                                        <i class="mdi mdi-bell-outline text-muted" style="font-size: 17px;"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="my-4 px-2" style="word-wrap: break-word;">
                        <h1 class="h6 text-dark">About</h1>
                        @if ($service->description != null)
                            <small class="text-muted">{{ $service->description }}</small>
                        @else
                            <div class="d-flex align-items-center justify-content-center" style="height: 200px;">
                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <i class="mdi mdi-text-box-edit-outline fs-1"></i>
                                    <small class="mb-0 text-muted">No Description</small>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="">
                        <div class="row mx-0 rounded py-3 ps-sm-1 border ps-0" >
                            <div class="col-sm-4 col-12 d-flex align-items-sm-start mb-sm-0 mb-4 align-items-center justify-content-start flex-column" id="order_rating" style="row-gap: 8px;">
                                <p class="mb-0 text-dark">Total Orders</p>
                                <div class="d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                        <i class="me-2 mdi mdi-text-box-check-outline" style="font-size: 20px;"></i>
                                        <h1 class="h6 text-dark mb-0">{{ count($service->order->where('status', 'completed')) < 1 ? 'N/A' : count($service->order->where('status', 'completed')) }}</h1>
                                    </div>
                                    <small class="text-muted" style="font-size: 12.5px;">Growth in orders on this year</small>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12 d-flex align-items-sm-start mb-sm-0 mb-4 align-items-center justify-content-start flex-column" id="order_rating" style="row-gap: 8px;">
                                <p class="mb-0 text-dark">Total Reviews</p>
                                <div class="d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                        <i class="me-2 mdi mdi-file-document-check-outline" style="font-size: 20px;"></i>
                                        <h1 class="h6 text-dark mb-0">{{ count($reviews) < 1 ? 'N/A' : count($reviews) }}</h1>
                                    </div>
                                    <small class="text-muted" style="font-size: 12.5px;">Growth in reviews on this year</small>
                                </div>
                            </div>
                            <div class="col-sm-4 col-12 d-flex align-items-sm-start mb-0 align-items-center justify-content-start flex-column" id="order_rating" style="row-gap: 8px;">
                                <p class="mb-0 text-dark">Total Ratings</p>
                                <div class="d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                        <i class="me-2 mdi mdi-star text-warning" style="font-size: 20px;"></i>
                                        <h1 class="h6 text-dark mb-0">{{ count($reviews) < 1 ? 'N/A' : $reviews->max('stars') . '.0' }}</h1>
                                    </div>
                                    <small class="text-muted" style="font-size: 12.5px;">Growth in ratings on this year</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 {{ count($reviews) > 0 ? 'd-grid' : 'd-none' }}" style="row-gap: 6px;">
                            <div class="my-2">
                                <h1 class="h6 mb-0 text-sm-start text-center text-dark">Reviews</h1>
                            </div>
                            @foreach ($reviews as $review)
                                <div class="d-flex align-items-start justify-content-start py-3 px-2 rounded" >
                                    <div class="mx-3">
                                        <div class="rounded-circle border" style="height: 42px; width: 42px; overflow: hidden;">
                                            <img src="{{ $review->user->image !== null ? asset('images/' . $review->user->image) : asset('brand/unknown.png') }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                        </div>
                                    </div>
                                    <div class="pe-4">
                                        <div class="d-flex align-items-start justify-content-center flex-column">
                                            <div class="w-100 d-flex align-items-start justify-content-start">
                                                <a href="{{ route('services', $review->user->name) }}" class="text-dark text-decoration-none fw-bold" style="font-size: 13.5px;">{{ $review->user->name }}</a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center" style="column-gap: 2px;">
                                                    @for ($i = 1; $i <= $review->stars; $i++)
                                                        <i class="fa-solid fa-star text-warning" style="font-size: 12px;"></i>
                                                    @endfor
                                                </div>
                                                <small class="text-muted d-block ms-2" style="font-size: 13px;">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                            <small class="text-dark my-1">{{ $review->title }}</small>
                                            <div class="{{ is_null($review->images) ? 'd-none' : '' }} my-2 rounded border" style="height: 65px; width: 65px; overflow: hidden;">
                                                <img src="{{ asset('images/' . $review->images) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                            </div>
                                            <div class="">
                                                <small class="text-muted" style="font-size: 13.5px;">{{ Str::limit($review->review, 200) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-2 pt-2 w-100 text-center border-top">
                                <a href="{{ route('reviews', $service->slug) }}" class="text-muted {{ count($reviews) < 1 ? 'd-none' : '' }}" style="font-size: 13px;">See More</a>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="col-5 pe-0 d-md-flex d-none justify-content-end align-items-start">
                    <div class="border shadow-sm rounded-3 mx-xl-4 mx-lg-3 mx-0" style="position: sticky; top: 100px; width: 100%;">
                        <div class="p-4 border-bottom d-flex justify-content-start align-items-end">
                            <h1 class="h5 mb-0 text-dark">{{'$' . $service->price }}</h1>
                            <small class="ms-1 text-muted">per service</small>
                        </div>
                        <div class="order-detail px-4 pt-4 pb-3 h-100 w-100">
                            <div class="d-grid border-bottom pb-4 gap-4 w-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-muted">Subtotal</small>
                                    <small class="text-dark" style="font-size: 14.5px;">{{ '$' . $service->price }}</small>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-muted">Service Fee <i class="mdi mdi-information-outline text-dark"></i></small>
                                    <small class="text-dark" style="font-size: 14.5px;">{{ '$' . $service->price }}</small>
                                </div>
                            </div>
                            <div class="d-grid pt-4 gap-4 w-100">
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-muted">Total</small>
                                    <small class="text-dark" style="font-size: 14.5px;">{{ '$' . $service->price }}</small>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-muted">Delivery Time</small>
                                    <small class="text-dark" style="font-size: 14.5px;">{{ '$' . $service->price }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 w-100">
                            <div class="d-flex align-items-center justify-content-center gap-1" style="flex-flow: 1;">
                            <button class="btn btn-dark">
                                <i class="mdi mdi-message-text"></i>
                            </button>
                                <div class="w-100">
                                    <form action="{{ route('session', $service->slug) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                                        <input type="hidden" name="price" value="{{ $service->price }}">
                                        <button type="submit" class="btn text-light w-100 py-2" style="background-color: #2891e1; font-size: 14px;">Place Order</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2 position-relative {{ count($similiar) < 1 ? 'd-none' : 'd-block' }}">
            <div class="pb-4 pt-3 w-100 text-center">
                <small class="mb-0 text-dark">Similiar Services</small>
            </div>
            <div class="owl-carousel owl-theme">
                @foreach($similiar as $service)
                    <div class="item h-auto">
                        <a href="{{ route('services', $service->slug) }}" class="text-decoration-none">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div class="rounded position-relative border" id="similiar_image">
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
                                    <div class="lh-sm d-flex align-items-center justify-content-start">
                                        <p class="mb-0 text-dark" style="width: 95%; font-size: 14.5px;">{{ Str::limit($service->title, 35) }}</p>
                                        <div class="d-flex align-items-center justify-content-end flex-row-reverse">
                                            <i class="fa-solid fa-star text-warning" style="font-size: 13.5px;"></i>
                                            <small class="me-1 text-dark" style="font-size: 13.5px;">{{ $service->rating->max('stars') < 1 ? '0' : $service->rating->max('stars') . '.0' }}</small>
                                        </div>
                                    </div>
                                    <?php
                                        $category_name = $service->category;
                                        $pathCategories = file_get_contents(public_path('json/category.json'));
                                        $data = json_decode($pathCategories, true);
                                        
                                        $filter = array_filter($data, function($category) use($category_name) {
                                            return $category['slug'] === $category_name;
                                        });
                                    ?>
                                    <small class="text-muted d-block" style="font-size: 12px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                                    <div class="mt-2 d-flex align-items-center justify-content-between">
                                        <small class="mb-0 text-dark" style="font-size: 14.5px;">{{ '$' . $service->price }}</small>
                                        <small class="mb-0 text-dark"><i class="me-1 mdi mdi-text-box-check-outline"></i>{{ count($service->order->where('status', 'completed')) }}</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="item h-auto">
                    <a href="{{ route('category', $service->category) }}" class="text-decoration-none">
                        <div class="border w-100 d-flex align-items-center justify-content-center flex-column" style="height: 220px;">
                        <i class="mdi mdi-view-dashboard fs-1 text-dark"></i>
                        <h1 class="h6 text-muted">More Services</h1>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection