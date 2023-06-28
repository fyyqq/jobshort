@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="row d-flex align-items-start justify-content-between flex-md-row flex-column" style="height: max-content">
            <div class="col-md-4 col-12 rounded-3 shadow-sm px-4 py-4 border" style="background-color: #fff; position: sticky; top: 90px;">
                <div class="pb-4 pt-3 d-flex align-items-center justify-content-center flex-column border-bottom">
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <div class="rounded-circle" style="height: 100px; width: 100px; overflow: hidden;">
                            <img src="{{ asset('images/6464bec7bc92d.jpg') }}" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="mt-2 text-center">
                            <p class="mb-0 text-dark">{{ $data->name }}</p>
                            <small class="text-muted">{{ $data->user->roles === 2 ? 'Employer' : '' }}</small>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pb-2">
                    <div class="row mt-4 mx-0 d-flex align-items-center justify-content-start">
                        <div class="col-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex align-items-center justify-content-start">
                                <small class="text-muted">{{ Str::ucfirst($data->employer_type) }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 mx-0 d-flex align-items-center justify-content-start">
                        <div class="col-2">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-briefcase"></i>
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="d-flex align-items-center justify-content-start">
                                <small class="text-muted">{{ count($data->job) }} Jobs</small>
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
                                <small class="text-muted">Joined at {{ $data->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-12 px-4 pt-0 pb-4 px-0">
                <div class="row mx-0 d-flex align-items-center justify-content-center flex-column">
                    <div class="col-4 w-100 border mb-md-3 mb-0" style="background-color: #fff; height: max-content;">
                        <div class="px-3 py-4">
                            <h1 class="h5 text-dark fw-bold">About Me</h1>
                            <div class="mt-4 row mx-0">
                                <div class="mb-3 d-flex align-items-center justify-content-start col-6" style="column-gap: 20px;">
                                    <i class="fa-solid fa-globe"></i>
                                    <p class="text-muted mb-0">{{ $data->country }}</p>
                                </div>
                                <div class="mb-3 d-flex align-items-center justify-content-start col-6" style="column-gap: 20px;">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <p class="text-muted mb-0">{{ $data->city . ' , ' . $data->state }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-center col-6" style="column-gap: 20px;">
                                    <i class="fa-solid fa-map-pin"></i>
                                    <p class="text-muted mb-0">{{ $data->address }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <small class="text-muted">{{ $data->about ?? 'No About Me Yet.' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-8 w-100 px-0" style="height: max-content;">
                        <div class="d-flex align-items-center justify-content-start border py-3" style="background-color: #fff;">
                            <ul class="navbar-nav d-flex flex-row">
                                <li class="px-4 border-end" style="cursor: pointer;">All</li>
                                <li class="px-4" style="cursor: pointer;">Ratings</li>
                            </ul>
                        </div>
                        <div class="py-3">
                            <div class="row mx-0 d-flex justify-content-center align-items-center" style="row-gap: 15px;">
                                @foreach ($data->job as $job)
                                    <div class="col-12">
                                        <a href="{{ route('jobs', $job->slug) }}" class="text-decoration-none position-relative d-block border rounded-3 py-3 px-3 " style="height: max-content; background-color:#fff; cursor: pointer;">
                                            <div class="d-flex align-items-center pe-5 w-100 justify-content-between">
                                                <h1 class="h6 mb-1 fw-bold text-dark" style="font-size: 17px;">{{ Str::limit($job->title, 55) }}</h1>
                                                <i class="{{ (Auth::check() && count(auth()->user()->wishlist->where('id', $job->id)) == 1) ? 'fa-solid' : 'fa-regular' }} fa-heart position-absolute" style="top: 15px; right: 20px; font-size: 16px;"></i>
                                                <input type="hidden" name="" value="{{ $job->slug }}">
                                            </div>
                                            <div class="d-flex align-items-center justify-content-start mb-0" style="column-gap: 8px;">
                                                <p class="text-muted mb-0">{{ $data->name }}</p>
                                            </div>
                                            <p class="text-muted mb-2">{{ $data->city .' , '. $data->state }}</p>
                                            <div class="d-flex align-items-center justify-content-start mb-3" style="column-gap: 5px;">
                                                <span class="badge rounded-1 text-muted border px-2">RM {{ $job->salary }}</span>
                                                <span class="badge rounded-1 text-muted border px-2">{{ $job->type }}</span>
                                                <span class="badge rounded-1 text-muted border px-2">{{ $job->category }}</span>
                                            </div>
                                            <div class="">
                                                <small class="text-muted">{{ Str::limit($job->description, 150) }}</small>
                                            </div>
                                            <div class="w-100 text-end">
                                                <small class="text-muted text-end" style="font-size: 13px;">Posted {{ $job->created_at->diffForHumans() }}</small>
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
