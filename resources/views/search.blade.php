@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <div class="row mx-0 position-relative d-flex justify-content-center align-items-top" style="flex-wrap: wrap; column-gap: 20px; height: max-content;">
            <aside class="px-0 col-md-3 col-12 mb-3 d-md-block d-none">
                <div class="rounded-3 pb-4 border" style="background-color: #fff; position: sticky; top: 100px;">
                    <div class="py-3 border-bottom">
                        <h1 class="text-dark h5 mb-0 text-center" style="font-size: 15px;">Filter</h1>
                    </div>
                    <div class="px-4" id="filter-list">
                        <input type="hidden" value="<?php echo $_GET['keyword'] ?>" id="search_value">
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Time Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="latest_service">
                                <label class="form-check-label" for="latest_service">
                                    <small class="text-muted" style="font-size: 12.5px;">Latest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="oldest_service">
                                <label class="form-check-label" for="oldest_service">
                                    <small class="text-muted" style="font-size: 12.5px;">Oldest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Order Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="highest_order">
                                <label class="form-check-label" for="highest_order">
                                    <small class="text-muted" style="font-size: 12.5px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="lowest_order">
                                <label class="form-check-label" for="lowest_order">
                                    <small class="text-muted" style="font-size: 12.5px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Rating Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="highest_rating">
                                <label class="form-check-label" for="highest_rating">
                                    <small class="text-muted" style="font-size: 12.5px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="lowest_rating">
                                <label class="form-check-label" for="lowest_rating">
                                    <small class="text-muted" style="font-size: 12.5px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Price Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="highest_price">
                                <label class="form-check-label" for="highest_price">
                                    <small class="text-muted" style="font-size: 12.5px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="lowest_price">
                                <label class="form-check-label" for="lowest_price">
                                    <small class="text-muted" style="font-size: 12.5px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn text-light btn-sm w-100" onclick="return resetFilter(this)" style="background-color: #2891e1; font-size: 13px;">Reset</button>
                        </div>
                    </div>
                </div>
            </aside>
            <section class="rounded-3 col-md-8 col-12 px-0" style="height: max-content;">
                <div class="mb-3 mt-2 px-2 d-flex align-items-center jusitfy-content-md-start justify-content-between">
                    <div class="d-flex align-items-center justify-content-start gap-3">
                        <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 14px;"></i>
                        <small class="mb-0 text-dark">{{ count($services) }} result "<span class="fw-bold"><?php echo $_GET['keyword'] ?></span>"</small>
                    </div>
                </div>
                @if (count($services) > 0)
                    <div class="row mx-0" id="display_service" style="row-gap: 15px;">
                        @foreach ($services as $key => $service)
                            <div class="col-sm-6 col-12">
                                <a href="{{ route('services', $service->slug) }}" class="d-block text-decoration-none">
                                    <div class="d-flex align-items-center justify-content-center flex-column">
                                        <div class="rounded w-100 position-relative border" style="height: 220px; overflow: hidden;">
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
                {{-- Filter Mobile --}}
                <div class="shadow-sm border" id="filter-mobile-container">
                    <div class="w-100 position-relative">
                        <span class="bg-secondary position-absolute rounded-pill" style="height: 4px; width: 40%; top: 10px; left: 50%; transform: translateX(-50%);"></span>
                    </div>
                    <div class="px-4 mt-5" id="filter-list">
                        <div class="">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Time Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="latest_service">
                                <label class="form-check-label" for="latest_service">
                                    <small class="text-muted" style="font-size: 12.5px;">Latest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="oldest_service">
                                <label class="form-check-label" for="oldest_service">
                                    <small class="text-muted" style="font-size: 12.5px;">Oldest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Order Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="highest_order">
                                <label class="form-check-label" for="highest_order">
                                    <small class="text-muted" style="font-size: 12.5px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="lowest_order">
                                <label class="form-check-label" for="lowest_order">
                                    <small class="text-muted" style="font-size: 12.5px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Rating Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="highest_rating">
                                <label class="form-check-label" for="highest_rating">
                                    <small class="text-muted" style="font-size: 12.5px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="lowest_rating">
                                <label class="form-check-label" for="lowest_rating">
                                    <small class="text-muted" style="font-size: 12.5px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-dark mb-0" style="font-size: 13.5px;">Price Range :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="highest_price">
                                <label class="form-check-label" for="highest_price">
                                    <small class="text-muted" style="font-size: 12.5px;">Highest</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="filter" id="lowest_price">
                                <label class="form-check-label" for="lowest_price">
                                    <small class="text-muted" style="font-size: 12.5px;">Lowest</small>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="shadow-sm rounded-pill d-md-none d-flex align-items-center justify-content-center" id="filter-search" onclick="return openFilter(this)">
            <p class="text-light mb-0">Filter</p>
        </div>
    </div>
@endsection
