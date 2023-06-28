@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row mx-0 position-relative d-flex justify-content-center align-items-top" style="flex-wrap: wrap; column-gap: 20px; height: max-content;">
            <aside class="px-0 col-md-3 col-12 mb-3 d-md-block d-none">
                <div class="rounded-3 pb-4 border" style="background-color: #fff; position: sticky; top: 100px;">
                    <div class="py-3 border-bottom">
                        <h1 class="text-dark h5 mb-0 text-center" style="font-size: 16px;">Filter Jobs</h1>
                    </div>
                    <div class="px-4" id="filter-list">
                        <div class="mt-3">
                            <small class="text-dark mb-0">Job Type :</small>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="job_type" id="offline">
                                <label class="form-check-label" for="offline">
                                    <small class="text-dark">Offline</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="job_type" id="online">
                                <label class="form-check-label" for="online">
                                    <small class="text-dark">Online</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0">freelancer Type :</small>
                            <div class="form-check mt-2">
                                <input class="form-check-input shadow-none" type="radio" name="freelancer_type" id="all" checked>
                                <label class="form-check-label" for="all">
                                    <small class="text-dark">All</small>
                                </label>
                            </div>
                            <div class="form-check my-1">
                                <input class="form-check-input shadow-none" type="radio" name="freelancer_type" id="individual">
                                <label class="form-check-label" for="individual">
                                    <small class="text-dark">Individual</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" name="freelancer_type" id="company">
                                <label class="form-check-label" for="company">
                                    <small class="text-dark">Company</small>
                                </label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <small class="text-dark mb-0">Salary Range :</small>
                            <div class="mt-3 d-flex align-items-start justify-content-center flex-column" style="row-gap: 10px;">
                                <input type="text" class="rounded-3 border py-1 px-3 w-100" placeholder="Min Price" name="" id="">
                                <input type="text" class="rounded-3 border py-1 px-3 w-100" placeholder="Max Price" name="" id="">
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
            <section class="rounded-3 col-md-8 col-12" style="height: max-content;">
                <div class="mb-3 mt-2 d-flex align-items-center jusitfy-content-start" style="column-gap: 15px;">
                    <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 14px;"></i>
                    <h1 class="mb-0 h6 text-dark fw-bold">{{ count($data) }} "<?php echo $_GET['search'] ?>" Jobs</h1>
                </div>
                @if (count($data) > 0)
                    <div class="d-grid" style="grid-template-columns: repeat(2, 1fr); gap: 15px;">
                        @foreach ($data as $key => $service)
                            <a href="{{ route('jobs', $service->slug) }}" class="text-decoration-none">
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
                        @endforeach
                    </div>
                @else
                    <div class="d-flex align-items-center justify-content-center flex-column" style="height: 550px;">
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <iframe src="https://giphy.com/embed/xXsFlH4StljYG5iBvQ" width="270" height="150" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
                            <p>
                                <a href="https://giphy.com/gifs/greenday-green-day-billie-joe-armstrong-xXsFlH4StljYG5iBvQ"></a>
                            </p>
                            <h1 class="text-dark mb-0 h5">No Jobs Found !</h1>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection