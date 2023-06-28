@extends('layouts.app')

@section('content')
    
    <div class="container-lg pb-5">
        <div class="px-4 pt-4 shadow-sm" style="background-color: #fff; border-radius: 15px;">
            <div class="d-flex align-items-center justify-content-between position-relative pe-4">
                <h1 class="text-dark h4">{{ $dataJobs->title }}</h1>
                @if (!auth()->check())
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        <i class="fa-regular fa-heart position-absolute" style="top: 10px; right: 20px; font-size: 20px;"></i>
                    </a>
                @else
                    <i class="fa-solid fa-heart position-absolute unwishlist {{ count(auth()->user()->wishlist->where('id', $dataJobs->id)) == 1 ? 'd-block' : 'd-none' }}" style="top: 10px; right: 20px; font-size: 20px;"></i>
                    <input type="hidden" value="{{ $dataJobs->id }}">
                    <i class="fa-regular fa-heart position-absolute wishlist {{ count(auth()->user()->wishlist->where('id', $dataJobs->id)) == 1 ? 'd-none' : 'd-block' }}" style="top: 10px; right: 20px; font-size: 20px;"></i>                                
                @endif
            </div>
            <div class="d-flex mb-2 align-items-start justify-content-center flex-column">
                <small class="text-dark">{{ $dataJobs->employer->name }}</small>
                <small class="text-dark">{{ $dataJobs->employer->city . ' , ' . $dataJobs->employer->state }}</small>
            </div>
            <div class="d-flex mt-2 align-items-center justify-content-start" style="column-gap: 7px;">
                <span class="badge rounded-1 text-muted border border-dark px-2">RM {{ $dataJobs->salary }}</span>
                <span class="badge rounded-1 text-muted border border-dark px-2">{{ $dataJobs->type }}</span>
                <span class="badge rounded-1 text-muted border border-dark px-2">{{ $dataJobs->category }}</span>
            </div>
            <div class="mt-3">
                <small class="text muted">{{ Str::limit($dataJobs->description, 450) }}</small>
            </div>
            <div class="mt-3">
                <div class="py-3 d-flex align-items-center justify-content-between border-top">
                    <div class="d-flex align-items-center justify-content-start">
                        <div class="rounded-circle" style="height: 60px; width: 60px; overflow: hidden;">
                            <img src="{{ asset('images/6464bea3cd344.jpg') }}" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="ms-4 d-flex align-items-start justify-content-center flex-column">
                            <p class="text-dark mb-0">{{ $dataJobs->employer->name }}</p>
                            <small class="text-muted" style="transform: translateY(-3px);">{{ $dataJobs->employer->employer_type }}</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="" class="badge text-decoration-none py-2 px-3 d-flex align-items-center justify-content-center text-dark border border-dark" style="column-gap: 10px;">
                            <i class="fa-solid fa-message text-dark"></i>
                            <p class="mb-0 text-uppercase">Chat</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-4 mt-4 shadow-sm" style="background-color: #fff; border-radius: 15px;">
            <div class="p-4 border-bottom">
                <h1 class="h5 mb-0 text-dark">Employer Information</h1>
            </div>
            <div class="row mx-0 mt-4">
                <div class="col-md-6 col-12 py-3">
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">Name</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->name }}</div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">Phone Number</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->contact }}</div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">Email Address</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->user->email }}</div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">Country</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->country }}</div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">State</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->state }}</div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">City</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->city }}</div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">Address</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->address }}</div>
                    </div>
                    <div class="row mx-0">
                        <div class="col-4 d-flex align-items-start justify-content-start py-1">Postcode</div>
                        <div class="col-8 py-1">{{ $dataJobs->employer->postcode }}</div>
                    </div>
                </div>
                <div class="col-md-6 col-12 py-3 mt-md-0 mt-2">
                    <div class="rounded-3" style="overflow: hidden;">
                        <img src="https://media.wired.com/photos/59269cd37034dc5f91bec0f1/191:100/w_1280,c_limit/GoogleMapTA.jpg" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 text-end mt-3">
            <input type="hidden" name="" value="{{ $dataJobs->employer->id }}">
            {{-- {{ auth()->user()->application->where('job_id', $dataJobs->id)->get() }} --}}
            {{-- @if (is_null(auth()->user()->application->where('job_id', $dataJobs->id)->first()) && $dataJobs->status != 'live')
                <button class="btn btn-dark px-4 text-light" disabled>Expired</button>
            @else
                @if (auth()->user()->application->where('job_id', $dataJobs->id)->first()->status != 'completed')
                    <a href="{{ route('profile.applied') }}" class="btn px-4 text-light" style="background-color: #2891e1;">View Apply</a>
                @elseif ($dataJobs->status != 'live')
                    <button class="btn btn-dark px-4 text-light" disabled>Expired</button>
                @else
                    <button class="btn btn-dark px-4 text-light" disabled>Expired</button>
                @endif
            @endif --}}
            <input type="hidden" name="" value="{{ $dataJobs->slug }}">
        </div>
    </div>
@endsection
