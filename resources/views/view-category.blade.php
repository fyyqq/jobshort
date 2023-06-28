@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="container-lg mb-4 px-0">
            @foreach ($dataCategory as $category)
                <div class="d-flex align-items-start justify-content-start p-3 border rounded shadow-sm" style="background-color: #fff;">
                    <div class="rounded" style="height: 170px; width: 170px; overflow: hidden;">
                        <img src="{{ asset('imageCategories/' . $category['image']) }}" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                    <div class="ms-4 mt-2" style="width: 50%;">
                        <h1 class="h5 text-dark">{{ $category['name'] }}</h1>
                        <p class="mb-0 text-muted">{{ $category['about'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="position-relative border">
            <div class="position-absolute" style="top: 0; right: 0;">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            {{-- Desktop View --}}
            <div id="view-job" class="row mx-0 d-md-flex d-none align-items-start justify-content-center" style="column-gap: 15px;">
                <div class="col-5 px-0 d-flex align-items-center justify-content-center flex-column" style="row-gap: 10px;">
                    @foreach ($dataJobs as $jobs)
                        <div data-slug="{{ $jobs->slug }}" class="text-decoration-none position-relative border rounded-3 shadow-sm py-3 px-3 job-view" style="background-color:#fff; cursor: pointer; ">
                            <div class="d-flex align-items-center pe-5 w-100 justify-content-between">
                                <h1 class="h6 mb-1 text-dark" style="font-size: 17px;">{{ $jobs->title }}</h1>
                                @if (!auth()->check())
                                    <a href="{{ route('login') }}" class="text-decoration-none">
                                        <i class="fa-regular fa-heart position-absolute" style="top: 20px; right: 20px; font-size: 16px;"></i>
                                    </a>
                                @else
                                    <i class="fa-solid fa-heart position-absolute unwishlist {{ count(auth()->user()->wishlist->where('id', $jobs->id)) == 1 ? 'd-block' : 'd-none' }}" style="top: 20px; right: 20px; font-size: 16px;"></i>
                                    <input type="hidden" value="{{ $jobs->id }}">
                                    <i class="fa-regular fa-heart position-absolute wishlist {{ count(auth()->user()->wishlist->where('id', $jobs->id)) == 1 ? 'd-none' : 'd-block' }}" style="top: 20px; right: 20px; font-size: 16px;"></i>                                
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-start mb-0" style="column-gap: 8px;">
                                <p class="text-muted mb-0">{{ $jobs->employer->name }}</p>
                            </div>
                            <p class="text-muted mb-2">{{ $jobs->employer->city .' , '. $jobs->employer->state }}</p>
                            <div class="d-flex align-items-center justify-content-start mb-3" style="column-gap: 5px;">
                                <span class="badge rounded-1 text-muted border px-2">RM {{ $jobs->salary }}</span>
                                <span class="badge rounded-1 text-muted border px-2">{{ $jobs->type }}</span>
                                <span class="badge rounded-1 text-muted border px-2">{{ $jobs->category }}</span>
                            </div>
                            <div class="">
                                <small class="text-muted">{{ Str::limit($jobs->description, 250) }}</small>
                            </div>
                            <div class="w-100 text-end mt-4">
                                <small class="text-muted text-end" style="font-size: 13px;">Posted {{ $jobs->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-6 px-0 position-sticky" id="side-jobs" style="top: 95px;">
                </div>
            </div>
            {{-- Mobile View --}}
            <div class="row mx-0 d-md-none d-flex justify-content-center align-items-center" style="gap: 10px;">
                @foreach ($dataJobs as $jobs)
                    <a href="{{ route('jobs', $jobs->slug) }}" class="text-decoration-none d-block border rounded-3 shadow-sm py-3 px-3 position-relative list-job" style="height: max-content; background-color:#fff; cursor: pointer;">
                        <div class="d-flex align-items-center pe-5 w-100 justify-content-between">
                            <h1 class="h6 mb-1 fw-bold text-dark" style="font-size: 17px;">{{ Str::limit($jobs->title, 55) }}</h1>
                            <i class="{{ (auth()->check() && count(auth()->user()->wishlist->where('id', $jobs->id)) == 1) ? 'fa-solid' : 'fa-regular' }} fa-heart position-absolute" style="font-size: 18px; right: 10px; top: 3px;"></i>
                            <input type="hidden" value="{{ $jobs->slug }}" id="slug">
                        </div>
                        <div class="d-flex align-items-center justify-content-start mb-0" style="column-gap: 8px;">
                            <p class="text-muted mb-0">{{ $jobs->employer->name }}</p>
                        </div>
                        <p class="text-muted mb-2">{{ $jobs->employer->city .' , '. $jobs->employer->state }}</p>
                        <div class="d-flex align-items-center justify-content-start mb-3" style="column-gap: 5px;">
                            <span class="badge rounded-1 text-muted border px-2">RM {{ $jobs->salary }}</span>
                            <span class="badge rounded-1 text-muted border px-2">{{ $jobs->type }}</span>
                            <span class="badge rounded-1 text-muted border px-2">{{ $jobs->category }}</span>
                        </div>
                        <div class="">
                            <small class="text-muted">{{ Str::limit($jobs->description, 250) }}</small>
                        </div>
                        <div class="position-absolute w-100 text-end" style="right: 15px; bottom: 10px;">
                            <small class="text-muted text-end" style="font-size: 13px;">Posted {{ $jobs->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection