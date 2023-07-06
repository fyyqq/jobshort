@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row d-flex align-items-start justify-content-between flex-md-row flex-column" style="height: max-content">
            <div class="col-md-4 col-12 rounded-3 shadow-md px-4 pb-4 border-bottom">
                <div class="border-bottom py-4 d-flex align-items-center justify-content-start">
                    <div class="w-100 d-flex align-items-center justify-content-start gap-4 position-relative">
                        <div class="rounded-3" style="height: 80px; width: 80px; overflow: hidden;">
                            <img src="{{ asset('images/' . $freelancer->image) }}" class="w-100 h-100" style="object-fit: cover;">
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
                                        <i class="fa-regular fa-bell text-muted {{ count(auth()->user()->notify->where('freelancer_id', $freelancer->id)) != 1 ? 'd-block' : 'd-none' }}" id="notify" style="font-size: 15px;"></i>
                                        <i class="fa-solid fa-bell text-muted {{ count(auth()->user()->notify->where('freelancer_id', $freelancer->id)) == 1 ? 'd-block' : 'd-none' }}" id="disnotify" style="font-size: 15px;"></i>
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
                                <small class="text-muted">{{ count($freelancer->service) }} Services</small>
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
                                <small class="text-muted">4.0 Stars</small>
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
                    <div class="col-4 w-100 border-bottom mb-md-3 mb-0" style=" height: max-content;">
                        <div class="px-3 py-4">
                            <h1 class="h4 text-dark fw-bold">About {{ $freelancer->name }}</h1>
                            <div class="mt-3">
                                <small class="text-muted">{{ $freelancer->about ?? 'No About Me Yet.' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 w-100 px-0" style="height: max-content;">
                        <div class="d-none align-items-center justify-content-start border py-3" style="">
                            <ul class="navbar-nav d-flex flex-row">
                                <li class="px-4 border-end" style="cursor: pointer;">All</li>
                                <li class="px-4" style="cursor: pointer;">Ratings</li>
                            </ul>
                        </div>
                        <div class="py-3">
                            <div class="row mx-0 d-flex justify-content-start align-items-center" style="row-gap: 10px;">
                                @foreach ($freelancer->service as $service)
                                    <div class="col-sm-6 col-12 px-sm-3">
                                        <a href="{{ route('services', $service->slug) }}" class="text-decoration-none">
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
                                                        <p class="mb-0 text-dark" style="width: 95%;">{{ Str::limit($service->title, 15) }}</p>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
