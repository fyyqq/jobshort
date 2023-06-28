@extends('profile.layouts.app')

@section('profile')
    <header class="pb-4 border shadow-sm" style="background-color: #fff;">
        <div class="p-4 border-bottom">
            <h1 class="h5 mb-1 text-dark">Applied Status</h1>
            <small class="text-muted" style="font-size: 13px;">You Applied Job Status. Check your current status</small>
        </div>
        <div class="mt-3 px-4">
            <div class="row mx-0 d-flex justify-content-center align-items-center position-relative" style="gap: 20px; height: max-content;">
                <div class="d-flex align-items-center justify-content-start flex-column border rounded" style="background-color:#fff;">
                    <div href="{{ route('jobs', $data->job->slug) }}" class="w-100 py-3 px-3 text-decoration-none position-relative">
                        <div class="d-flex align-items-center pe-5 w-100 justify-content-between">
                            <a href="{{ route('jobs', $data->job->slug) }}" class="text-dark">
                                <h1 class="h6 mb-1 fw-bold" style="font-size: 17px;">{{ $data->job->title }}</h1>
                            </a>
                            <i class="fa-regular fa-heart position-absolute" style="top: 20px; right: 20px; font-size: 16px;"></i>
                            <input type="hidden" value="{{ $data->job->slug }}" id="slug">
                        </div>
                        <div class="d-flex align-items-center justify-content-start mb-2" style="column-gap: 8px;">
                            <small class="text-muted mb-0">{{ $data->job->employer->name }}</small>
                        </div>
                        <div class="d-flex align-items-center justify-content-start mb-2" style="column-gap: 5px;">
                            <span class="badge rounded-1 text-muted border px-2">{{ 'RM' . $data->job->salary }}</span>
                            <span class="badge rounded-1 text-muted border px-2">{{ $data->job->type }}</span>
                            <span class="badge rounded-1 text-muted border px-2">{{ $data->job->category }}</span>
                        </div>
                        <div class="w-100 d-flex align-items-center justify-content-between">
                            <small class="text-muted" style="font-size: 13px;">Posted {{ $data->job->created_at->diffForHumans() }}</small>
                            <a href="{{ route('profile.applied-status', $data->slug) }}" class="text-decoration-none text-light badge @if ($data->status == 'pending') bg-warning @elseif ($data->status == 'approved') bg-success @else bg-danger @endif px-2 fw-normal" style="padding-bottom: 7px;">{{ $data->status }}</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between w-100 p-3 border-top">
                        <div class="d-flex justify-content-start align-items-start flex-row">
                            <div class="rounded-circle" style="height: 50px; width: 50px; overflow: hidden;">
                                <img src="{{ asset('images/6464bec7bc92d.jpg') }}" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                            <div class="ms-3 d-flex align-items-start justify-content-center flex-column" style="transform: translateY(4px);">
                                <a href="{{ route('users', strtolower($data->job->employer->name)) }}" class="text-decoration-none mb-0 text-dark fw-bold" style="font-size: 14px;">{{ $data->job->employer->name }}</a>
                                <small class="text-muted" style="font-size: 13px;">Joined at {{ $data->job->employer->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <a href="" class="btn px-3" style="border: 1.5px solid #2891e1">
                            <i class="fa-solid fa-message py-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection