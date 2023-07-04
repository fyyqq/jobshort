@extends('layouts.app')

@section('content')
    <div class="container-xl pb-5">
        <div class="my-4 ps-3">
            <h1 class="h4 text-dark">{{ $service->title }}</h1>
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted">{{ $service->freelancer->country }}</small>
                    <small class="text-muted">|</small>
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-star" style="font-size: 13.5px;"></i>
                        <small class="text-muted ms-1">3 out of 5 stars</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3 me-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 13.5px; cursor: pointer;"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-heart unwishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-block' : 'd-none' }}"></i>
                        <input type="hidden" value="{{ $service->id }}">
                        <i class="fa-regular fa-heart wishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-none' : 'd-block' }}"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid mt-3 rounded-3" id="service-gallery-container" style="overflow: hidden;">
            <div class="d-md-none d-block">
                <div id="carouselMDExample" class="carousel slide carousel-fade">
                    <div class="carousel-inner bg-dark mb-4 shadow-1-strong rounded-3" id="service-img-mobile" style="overflow: hidden;">
                        @foreach (explode(',', $service->image) as $key => $value)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}" data-fancybox="gallery-phone" data-src="{{ asset('images/' . $value) }}">
                                <div class="d-flex align-items-center justify-content-center" style="height: 100%;">
                                    <img src="{{ asset('images/' . $value) }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
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
            <div class="d-md-block d-none">
                <div class="position-relative bg-dark d-flex align-items-center justify-content-center" style="height: 400px;">
                    @foreach (explode(',', $service->image) as $key => $value)
                        @if ($key === 0)
                            <a href="{{ asset('images/' . $value) }}" class="w-100 detail-image" style="height: auto; overflow: hidden;" data-fancybox="gallery" data-src="{{ asset('images/' . $value) }}">
                                <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover">
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="" style="height 400px;">
                <div class="d-md-grid d-none h-100 w-100" id="gallery-img">
                    {{-- Display --}}
                    @foreach (explode(',', $service->image) as $key => $value)
                        @if ($key >= 1 && $key < 5)
                            <a href="{{ asset('images/' . $value) }}" class="detail-image" style="height: 197px; overflow: hidden;" data-fancybox="gallery" data-src="{{ asset('images/' . $value) }}">
                                <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover">
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
        <div class="mt-4" style="height: max-content;">
            <div class="row mx-0">
                <div class="col-md-7 col-12 px-0">
                    <div class="py-md-3 py-2 px-md-4 px-3 border rounded-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="{{ route('users', $service->freelancer->name) }}" class="text-decoration-n one rounded-circle" style="height: 50px; width: 50px; overflow: hidden;">
                                <img src="{{ asset('images/' . $service->freelancer->image) }}" alt="" class="w-100 h-100" style="object-fit: cover">
                            </a>
                            <a href="{{ route('users', $service->freelancer->name) }}" class="text-decoration-none">
                                <small class="text-dark ms-3">{{ $service->freelancer->name }}</small>
                            </a>
                        </div>
                        <div class="d-flex align-items-center justify-content-center pe-3">
                            <input type="hidden" id="user_id" value="{{ Auth::id() }}">
                            <input type="hidden" id="freelancer_id" value="{{ $service->freelancer->id }}">
                            <i class="fa-regular fa-bell text-muted {{ count(auth()->user()->notify->where('freelancer_id', $service->freelancer->id)) != 1 ? 'd-block' : 'd-none' }}" id="notify" style="font-size: 18px;"></i>
                            <i class="fa-solid fa-bell text-muted {{ count(auth()->user()->notify->where('freelancer_id', $service->freelancer->id)) == 1 ? 'd-block' : 'd-none' }}" id="disnotify" style="font-size: 18px;"></i>
                        </div>
                    </div>
                    <div class="my-4 px-md-0 px-2">
                        <h1 class="text-dark mb-3 h5">About this</h1>
                        <div class="">
                            <small class="text-muted d-block mb-2">@for ($i = 1; $i <= 5; $i++) &nbsp; @endfor {{ $service->description }}</small>
                        </div>
                    </div>
                    <div class="pt-3 border-top">
                        <div class="row mx-0 border-bottom pb-4">
                            <div class="col-4 border-end d-flex align-items-start justify-content-center flex-column" style="row-gap: 8px;">
                                <p class="mb-0 text-muted">Total Reviews</p>
                                <div class="d-flex jusitfy-content-center flex-column">
                                    <h1 class="{{ count($reviews) < 1 ? 'h5' : 'h4' }} text-dark mb-1">{{ count($reviews) < 1 ? 'No Review' : count($reviews) }}</h1>
                                    <small class="text-muted" style="font-size: 12.5px;">Growth in review on this year</small>
                                </div>
                            </div>
                            <div class="col-4 border-end d-flex align-items-start justify-content-center flex-column" style="row-gap: 8px;">
                                <p class="mb-0 text-muted">Average Ratings</p>
                                <div class="d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center justify-content-start mb-1">
                                        <h1 class="{{ count($reviews) < 1 ? 'h5' : 'h4' }} text-dark mb-0">{{ count($reviews) < 1 ? 'No Review' : $reviews->max('stars') . '.0' }}</h1>
                                        <div class="ms-2">
                                            @for ($i = 0; $i < $reviews->max('stars'); $i++)
                                                <i class="fa-solid fa-star text-warning" style="font-size: 14px;"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <small class="text-muted" style="font-size: 12.5px;">Average rating on this year</small>
                                </div>
                            </div>
                            <div class="col-4 d-flex align-items-start justify-content-center flex-column" style="row-gap: 8px;">
                                <div class="w-100 d-flex flex-column-reverse">
                                    <div class="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-danger" style="font-size: 12px; width: 10%"></div>
                                    </div>
                                    <div class="progress mb-1" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-warning" style="font-size: 12px; width: 25%"></div>
                                    </div>
                                    <div class="progress mb-1" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-info" style="font-size: 12px; width: 50%"></div>
                                    </div>
                                    <div class="progress mb-1" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-primary" style="font-size: 12px; width: 75%"></div>
                                    </div>
                                    <div class="progress mb-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar bg-success" style="font-size: 12px; width: 100%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 d-grid" style="row-gap: 6px;">
                            @foreach ($reviews as $review)
                                <div class="d-flex align-items-start justify-content-start py-3 px-2 rounded border">
                                    <div class="mx-3">
                                        <div class="rounded-circle border" style="height: 45px; width: 45px; overflow: hidden;">
                                            <img src="{{ asset('images/' . $review->user->image) }}" class="w-100 h-100" style="object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="pe-4">
                                        <div class="d-flex align-items-start justify-content-center flex-column">
                                            <div class="w-100 d-flex align-items-start justify-content-start">
                                                <a href="{{ route('services', $review->user->name) }}" class="text-dark text-decoration-none fw-bold" style="font-size: 14px;">{{ $review->user->name }}</a>
                                            </div>
                                            <div class="w-100 d-flex align-items-center justify-content-between my-1">
                                                <div class="d-flex align-items-center justify-content-start" style="column-gap: 2px;">
                                                    @for ($i = 1; $i <= $review->stars; $i++)
                                                        <i class="fa-solid fa-star text-warning" style="font-size: 12.5px;"></i>
                                                    @endfor
                                                </div>
                                                <small class="text-muted" style="font-size: 13.5px;">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                            <small class="text-dark">{{ $review->title }}</small>
                                            <div class="my-2 rounded border border-dark" style="height: 65px; width: 65px; overflow: hidden;">
                                                <img src="{{ asset('images/' . $review->images) }}" class="w-100 h-100" style="object-fit: cover;">
                                            </div>
                                            <div class="">
                                                <small class="text-muted">{{ Str::limit($review->review, 200) }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mt-2 w-100 text-center">
                                <a href="{{ route('reviews', $service->slug) }}" class="text-decoration-none fw-bold {{ count($reviews) < 1 ? 'd-none' : '' }}" style="color: #2891e1">See More <i class="ms-2 fa-solid fa-chevron-right" style="font-size: 14px;"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5 ps-3 pe-0 d-md-flex d-none justify-content-center align-items-start position-relative">
                    <div class="border shadow-sm rounded-3" style="height: 450px; position: sticky; top: 100px; width: 90%;">
                        <div class="p-4 border-bottom d-flex justify-content-start align-items-end">
                            <h1 class="h5 mb-0 text-dark">RM {{ $service->price }}</h1>
                            <small class="text-muted ms-2">per service</small>
                        </div>
                        <div class="px-3 position-absolute w-100" style="bottom: 15px; left: 50%; transform: translateX(-50%);">
                            <div class="d-flex align-items-center justify-content-center gap-1" style="flex-flow: 1;">
                                {{-- <form action="{{ route('pay') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ $service->price }}"> --}}
                                    <a href="{{ route('chatify') }}" class="btn btn-dark py-2">
                                        <i class="fa-regular fa-message text-light" style="font-size: 15px;"></i>
                                    </a>
                                {{-- </form> --}}
                                <div class="w-100">
                                    <?php
                                        $userOrder = auth()->user()->order->where('service_id', $service->id)->sortByDesc('created_at')->first();
                                        $rejectOrCompleted = $userOrder && in_array($userOrder->status, ['rejected', 'completed']);
                                        $pendingOrApproved = $userOrder && in_array($userOrder->status, ['pending', 'approved']);
                                    ?>
                                    @if ($rejectOrCompleted)
                                        <input type="hidden" id="service_id" value="{{ $service->id }}">
                                        <button class="btn px-3 py-2 text-light w-100" id="order-btn" style="background-color: #2891e1;">Place Order</button>
                                        {{-- <a href="{{ route('payment', $service->slug) }}" class="btn px-3 py-2 text-light w-100" style="background-color: #2891e1;">Place Order</a> --}}
                                        <input type="hidden" id="freelancer_id" value="{{ $service->freelancer->id }}">
                                    @elseif ($pendingOrApproved)
                                        @if ($userOrder->status === 'pending')
                                            <a href="{{ route('profile.applied') }}" class="btn px-3 py-2 text-light w-100" style="background-color: #2891e1;">Check Your Order</a>
                                        @elseif ($userOrder->status === 'approved')
                                            <a href="{{ route('profile.applied-approved') }}" class="btn px-3 py-2 text-light w-100" style="background-color: #2891e1;">Check Your Order</a>
                                        @endif
                                    @else
                                        <input type="hidden" id="service_id" value="{{ $service->id }}">
                                        <button class="btn px-3 py-2 text-light w-100" id="order-btn" style="background-color: #2891e1;">Place Order</button>
                                        <input type="hidden" id="freelancer_id" value="{{ $service->freelancer->id }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-4 mt-4 border-top">
            <p class="mb-0 text-center text-dark">Similiar Product</p>
        </div>
        <div class="w-100">
            <div class="owl-carousel owl-theme">
                @for ($i = 0; $i < 5; $i++)
                    <div class="item rounded-3" id="similiar-product">
                        <div class="border" style="height: 70%;">
                            <img src="{{ asset('images/64887eb279f0e.jpg') }}" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="border px-3 py-2" style="height: 30%;">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <p class="mb-0 text-dark">Lorem, ipsum dolor</p>
                                <i class="fa-solid fa-star" style="font-size: 13.2px"></i>
                            </div>
                            <small class="text-muted" style="font-size: 13px;">Klang, Selangor</small>
                        </div>
                    </div>
                @endfor
                <div class="item bg-dark d-flex align-items-center justify-content-center flex-column rounded-3 border border-primary" id="similiar_product" style="height: 290px; width: 350px; overflow: hidden;">
                    <h1 class="h6 text-light">See More Product Similiar</h1>
                    <a href="" class="btn btn-sm btn-primary col-3">See More</a>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Mobile Navbar --}}
<div class="shadow-sm {{ Route::currentRouteName() === 'services' ? 'd-block' : 'd-none' }}">
    <div class="" id="mobile-navbar">
        <div class="row mx-0">
            <div class="d-flex align-items-center justify-content-between ps-4 pe-3">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-comment text-muted" style="font-size: 18px;"></i>
                </div>
                <div class="d-flex align-items-center jusitfy-content-center gap-3">
                    <h1 class="h5 mb-0 text-dark">{{ 'RM' . $service->price }}</h1>
                    <button type="button" class="w-100 btn text-light px-4" style="background-color: #2891e1;" data-bs-toggle="modal" data-bs-target="#orderModal">Order</button>
                </div>
            </div>
        </div>
    </div>
</div>