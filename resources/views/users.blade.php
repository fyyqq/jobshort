@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <div class="row d-flex align-items-start justify-content-between flex-md-row flex-column">
            <div class="col-md-4 col-12 rounded-3 px-4 pb-4 border-bottom">
                <div class="border-bottom py-4 d-flex align-items-center justify-content-start">
                    <div class="w-100 d-flex align-items-center justify-content-start gap-4 position-relative">
                        <div class="rounded-3 border" style="height: 80px; width: 80px; overflow: hidden;">
                            <img src="{{ $freelancer->image !== null ? asset('images/' . $freelancer->image) : asset('brand/unknown.png') }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                        </div>
                        <div class="d-flex flex-column align-items-start justify-content-center">
                            <small class="fw-bold mb-0 lh-1">{{ $freelancer->name }}</small>
                            <small class="text-muted" style="font-size: 12.5px;">{{ $freelancer->skills }}</small>
                        </div>
                        <div class="position-absolute" style="top: 0px; right: 0px;">
                            @if (auth()->check())
                            <input type="hidden" value="{{ Auth::id() }}" id="user_id">
                            <input type="hidden" value="{{ $freelancer->id }}" id="freelancer_id">
                                <i class="mdi mdi-bell-outline text-muted {{ count(auth()->user()->notify->where('freelancer_id', $freelancer->id)) != 1 ? 'd-block' : 'd-none' }}" id="notify" style="font-size: 16px; cursor: pointer;"></i>
                                <i class="mdi mdi-bell-ring text-muted {{ count(auth()->user()->notify->where('freelancer_id', $freelancer->id)) == 1 ? 'd-block' : 'd-none' }}" id="disnotify" style="font-size: 16px; cursor: pointer;"></i>
                            @else
                                <form action="{{ route('login') }}" method="get">
                                    @csrf
                                    <button type="submit" class="border-0" style="background: unset;">
                                        <i class="mdi mdi-bell-outline text-muted" style="font-size: 15px;"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="mt-4 pb-2">
                    <div class="row mt-4 mx-0 d-flex align-items-center justify-content-start">
                        <div class="col-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex align-items-center justify-content-start">
                                <small class="text-muted">{{ count($freelancer->service->where('status', 'active')) }} services</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mx-0 d-flex align-items-center justify-content-start">
                        <div class="col-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex align-items-center justify-content-start">
                                <small class="text-muted">{{ $freelancer->rating->max('stars') < 1 ? $freelancer->rating->max('stars')  : $freelancer->rating->max('stars') . '.0' }} stars</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mx-0 d-flex align-items-center justify-content-start">
                        <div class="col-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-globe"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex align-items-center justify-content-start">
                                <small class="text-muted">{{ $freelancer->country }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mx-0 d-flex align-items-center justify-content-start">
                        <div class="col-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-timeline"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex align-items-center justify-content-start">
                                <small class="text-muted">Joined in {{ $freelancer->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12 px-4 pt-0 pb-4 px-0 border-md-top border-none">
                <div class="row mx-0 d-flex align-items-center justify-content-center flex-column">
                    <div class="col-md-12 w-100 border-bottom mb-3" style=" height: max-content;">
                        <div class="px-3 py-4">
                            <h1 class="h5 text-dark fw-bold">About {{ $freelancer->name }}</h1>
                            <div class="mt-3">
                                <small class="text-muted">{{ $freelancer->about ?? 'Nothing About Freelancer.' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="px-sm-3 px-0 m-0 d-flex align-items-center justify-content-between">
                        <div class="col-md-3 col-2 d-sm-block d-none px-0">
                            <small class="text-dark d-block" style="font-size: 13.5px;"><span id="filter-count">{{ count($freelancer->service->where('status', 'active')) }}</span> Results</small>
                        </div>
                        <div class="d-flex align-items-center justify-content-end w-100 gap-md-2 gap-0">
                            <div class="col-sm-4 col-6 px-md-0 px-1">
                                <div class="rounded-3 border" id="select">
                                    <select name="" class="ps-3 w-100 text-dark h-100" style="font-size: 13px;" onchange="return sortService(this)">
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
                            </div>
                            <input type="hidden" value="{{ $freelancer->name }}" id="freelancer-name">
                            <div class="col-sm-4 col-6 px-md-0 px-1">
                                <div class="rounded-3 border" id="select">
                                    <select name="" class="ps-3 w-100 text-dark h-100" style="font-size: 13px;" onchange="return filterCategories(this)">
                                        <option value="all">Categories</option>
                                            @foreach ($freelancer->service->where('status', 'active')->pluck('category')->unique() as $value)
                                                <?php
                                                    $category_name = $value;
                                                    $pathCategories = file_get_contents(public_path('json/category.json'));
                                                    $data = json_decode($pathCategories, true);
                                                    
                                                    $filter = array_filter($data, function($category) use($category_name) {
                                                        return $category['slug'] === $category_name;
                                                    });
                                                ?>
                                                <option value="{{ $value }}">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3 px-0">
                        <div class="row mx-0 d-flex justify-content-start align-items-center" id="display-user-services" style="row-gap: 20px;">
                            @foreach ($freelancer->service->where('status', 'active') as $service)
                                <div class="col-sm-6 col-12">
                                    <a href="{{ route('services', $service->slug) }}" class="text-decoration-none">
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
                                                    <small class="mb-0 text-dark" style="font-size: 14.5px;">{{ '$' . $service->price_after_fee }}</small>
                                                    <small class="mb-0 text-dark"><i class="me-1 mdi mdi-text-box-check-outline"></i>{{ count($service->order->where('status', 'completed')) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
