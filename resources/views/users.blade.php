@extends('layouts.app')

@section('content')
<style>
    #select {
        overflow: hidden;
        height: 35px;
    }
    select {
        border-right: 10px solid transparent;
        font-size: 13px;
        outline: none;
        border-color: transparent;
    }
    select option {
        font-size: 14px;
    }
</style>
    <div class="container-lg">
        <div class="row d-flex align-items-start justify-content-between flex-md-row flex-column" style="height: max-content">
            <div class="col-md-4 col-12 rounded-3 px-4 pb-4 border-bottom">
                <div class="border-bottom py-4 d-flex align-items-center justify-content-start">
                    <div class="w-100 d-flex align-items-center justify-content-start gap-4 position-relative">
                        <div class="rounded-3 border" style="height: 80px; width: 80px; overflow: hidden;">
                            <img src="{{ $freelancer->image !== null ? asset('images/' . $freelancer->image) : asset('brand/unknown.png') }}" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="d-flex flex-column align-items-start justify-content-center">
                            <small class="fw-bold mb-0 lh-1">{{ $freelancer->name }}</small>
                            <small class="text-muted" style="font-size: 12.5px;">{{ $freelancer->skills }}</small>
                        </div>
                        <div class="dropdown position-absolute" style="top: 0px; right: 0px;">
                            <i class="fa-solid fa-ellipsis-vertical p-1" data-bs-toggle="dropdown"></i>
                            <div class="dropdown-menu dropdown-menu-start p-0">
                                <li class="dropdown-item py-2 btn">
                                    <div class="d-flex align-items-center justify-content-start gap-3">
                                        <input type="hidden" id="user_id" value="{{ Auth::id() }}">
                                        <input type="hidden" id="freelancer_id" value="{{ $freelancer->id }}">
                                        @if (auth()->check())
                                            <i class="mdi mdi-bell-outline text-muted {{ count(auth()->user()->notify->where('freelancer_id', $freelancer->id)) != 1 ? 'd-block' : 'd-none' }}" id="notify" style="font-size: 15px;"></i>
                                            <i class="mdi mdi-bell-ring text-muted {{ count(auth()->user()->notify->where('freelancer_id', $freelancer->id)) == 1 ? 'd-block' : 'd-none' }}" id="disnotify" style="font-size: 15px;"></i>
                                        @else
                                            <form action="{{ route('login') }}" method="get">
                                                @csrf
                                                <button type="submit" class="border-0" style="background: unset;">
                                                    <i class="mdi mdi-bell-outline text-muted" style="font-size: 15px;"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <small class="text-muted" style="font-size: 13px;">Notification</small>
                                    </div>
                                </li>
                                <li class="dropdown-item py-2 btn">
                                    <div class="d-flex align-items-center justify-content-start gap-3">
                                        <i class="fa-regular fa-message text-muted" style="font-size: 13.5px;"></i>
                                        <small class="text-muted" style="font-size: 13px;">Message</small>
                                    </div>
                                </li>
                            </div>
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
                                <small class="text-muted">{{ count($freelancer->service) }} services</small>
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
                            <h1 class="h4 text-dark fw-bold">About {{ $freelancer->name }}</h1>
                            <div class="mt-3">
                                <small class="text-muted">{{ $freelancer->about ?? 'Nothing About Freelancer.' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="px-sm-3 px-0 m-0 d-flex align-items-center justify-content-between">
                        <div class="col-md-3 col-2 d-sm-block d-none px-0">
                            <small class="text-dark d-block" style="font-size: 13.5px;"><span id="filter-count">{{ count($freelancer->service) }}</span> Results</small>
                        </div>
                        <div class="d-flex align-items-center justify-content-end w-100 gap-md-2 gap-0">
                            <div class="col-md-5 col-sm-4 col-6 px-md-0 px-1">
                                <div class="rounded-3 border" id="select">
                                    <select name="" id="select-sort" class="ps-3 w-100 text-dark h-100">
                                        <option value="">Sort By</option>
                                        <option value="">Latest</option>
                                        <option value="">Oldest</option>
                                        <option value="">Top Order</option>
                                        <option value="">Lowest Order</option>
                                        <option value="">Top Rating</option>
                                        <option value="">Lowest Rating</option>
                                        <option value="">Top Price</option>
                                        <option value="" selected>Lowest Price</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $freelancer->name }}" id="freelancer-name">
                            <div class="col-md-5 col-sm-4 col-6 px-md-0 px-1">
                                <div class="rounded-3 border" id="select">
                                    <select name="" class="ps-3 w-100 text-dark h-100" onchange="return filterCategories(this)">
                                        <option value="all">Categories</option>
                                        @foreach ($freelancer->service->pluck('category') as $value)
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="py-3 px-0">
                            <div class="row mx-0 d-flex justify-content-start align-items-center" id="display-user-services">
                                @foreach ($freelancer->service as $service)
                                    <div class="col-sm-6 col-12">
                                        <a href="{{ route('services', $service->slug) }}" class="text-decoration-none">
                                            <div class="d-flex align-items-center justify-content-center flex-column">
                                                <div class="rounded w-100 position-relative" style="height: 220px; overflow: hidden;">
                                                    @foreach (explode(',', $service->image) as $key => $image)
                                                        @if ($key === 0)
                                                            <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;">
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
                                                        <input type="hidden" value="{{ $service->id }}">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
