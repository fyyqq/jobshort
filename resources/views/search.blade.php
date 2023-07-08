@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row mx-0 position-relative d-flex justify-content-center align-items-top" style="flex-wrap: wrap; column-gap: 20px; height: max-content;">
            <aside class="px-0 col-md-3 col-12 mb-3 d-md-block d-none" style="background-color: #fff;">
                <div class="rounded-3 pb-4 border" style="background-color: #fff; position: sticky; top: 100px;">
                    <div class="py-3 border-bottom">
                        <h1 class="text-dark h5 mb-0 text-center" style="font-size: 16px;">Filter Services</h1>
                    </div>
                    <div class="px-4" id="filter-list">
                        <input type="hidden" value="<?php echo $_GET['keyword'] ?>" id="search_value">
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Time Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="time_range" id="latest_service" onclick="return timeRange(this)">
                                <label class="form-check-label" for="latest_service">
                                    <small class="text-muted" style="font-size: 13px;">Latest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="time_range" id="oldest_service" onclick="return timeRange(this)">
                                <label class="form-check-label" for="oldest_service">
                                    <small class="text-muted" style="font-size: 13px;">Oldest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Order Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="order_range" id="highest_order" onclick="return orderRange(this)">
                                <label class="form-check-label" for="highest_order">
                                    <small class="text-muted" style="font-size: 13px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="order_range" id="lowest_order" onclick="return orderRange(this)">
                                <label class="form-check-label" for="lowest_order">
                                    <small class="text-muted" style="font-size: 13px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Rating Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="rating_range" id="highest_rating" onclick="return ratingRange(this)">
                                <label class="form-check-label" for="highest_rating">
                                    <small class="text-muted" style="font-size: 13px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="rating_range" id="lowest_rating" onclick="return ratingRange(this)">
                                <label class="form-check-label" for="lowest_rating">
                                    <small class="text-muted" style="font-size: 13px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Price Range :</small>
                            <div class="mt-2 d-flex align-items-start justify-content-center flex-column" style="row-gap: 6px;">
                                <input type="text" class="form-control shadow-none border py-1 px-3 w-100" placeholder="Min Price" name="" id="" style="font-size: 13px;">
                                <input type="text" class="form-control shadow-none border py-1 px-3 w-100" placeholder="Max Price" name="" id="" style="font-size: 13px;">
                            </div>
                            <div class="mt-3">
                                <button class="btn text-light btn-sm w-100" style="background-color: #2891e1; font-size: 13px;">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <section class="rounded-3 col-md-8 col-12 px-0 px-3" style="height: max-content;">
                <div class="mb-3 mt-2 d-flex align-items-center jusitfy-content-md-start justify-content-between">
                    <div class="d-flex align-items-center justify-content-start gap-3">
                        <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 14px;"></i>
                        <small class="mb-0 text-dark">{{ count($data) }} result "<span class="fw-bold"><?php echo $_GET['keyword'] ?></span>"</small>
                    </div>
                    <div class="d-md-none d-flex align-items-center justify-content-end">
                        <button class="btn btn-light border" style="font-size: 14px;"><i class="fa-solid fa-filter me-2" style="font-size: 13px;"></i>Filter</button>
                    </div>
                </div>
                @if (count($data) > 0)
                    <div class="row mx-0" id="display_service">
                        @foreach ($data as $key => $service)
                            <div class="col-sm-6 col-12">
                                <a href="{{ route('services', $service->slug) }}" class="d-block text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-center flex-column">
                                        <div class="rounded w-100 position-relative" style="height: 220px; overflow: hidden;">
                                            @foreach (explode(',', $service->image) as $key => $image)
                                                @if ($key === 0)
                                                    <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;">
                                                @endif
                                            @endforeach
                                            @if (!auth()->check())
                                                <a href="{{ route('login') }}" class="text-decoration-none">
                                                    <i class="fa-regular fa-heart position-absolute" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                                </a>
                                            @else
                                                <i class="fa-solid fa-heart position-absolute unwishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-block' : 'd-none' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                                <input type="hidden" value="{{ $service->id }}">
                                                <i class="fa-regular fa-heart position-absolute wishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-none' : 'd-block' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                            @endif
                                        </div>
                                        <div class="p-2 w-100">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <p class="mb-0 text-dark" style="width: 95%;">{{ Str::limit($service->title, 35) }}</p>
                                                <div class="d-flex align-items-center justify-content-end mt-2 flex-row-reverse">
                                                    <i class="fa-solid fa-star text-dark" style="font-size: 13.5px;"></i>
                                                    <small class="me-2 text-dark" style="font-size: 13.5px;">4.5</small>
                                                </div>
                                            </div>
                                            <small class="text-muted" style="font-size: 13px;">Klang ,  Selangor</small>
                                            <div class="mt-2 d-flex">
                                                <small class="mb-0 text-dark">{{ 'RM' . $service->price }}</small>
                                                <small class="mb-0 ms-1 text-muted">per service</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center flex-column" style="height: 550px;">
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <iframe src="https://giphy.com/embed/xXsFlH4StljYG5iBvQ" width="270" height="150" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
                            <p>
                                <a href="https://giphy.com/gifs/greenday-green-day-billie-joe-armstrong-xXsFlH4StljYG5iBvQ"></a>
                            </p>
                            <h1 class="text-dark mb-0 h5">No Services Found !</h1>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection