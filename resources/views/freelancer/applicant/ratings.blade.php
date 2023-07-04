@extends('employer.applicant.layouts.app')

@section('pages')
    <div class="row mx-0 d-flex justify-content-center align-items-center position-relative" style="row-gap: 10px;">
        <div class="d-flex align-items-center justify-content-start flex-column border rounded" style="background-color:#fff;">
            <div class="w-100 py-3 px-3 text-decoration-none position-relative border-top border-bottom">
                <div class="d-flex align-items-center pe-5 w-100 justify-content-start">
                    <a href="{{ route('jobs', $data->job->slug) }}" class="text-dark">
                        <h1 class="h6 mb-1 fw-bold" style="font-size: 17px;">{{ $data->job->title }}</h1>
                    </a>
                </div>
                <div class="d-flex align-items-center justify-content-start mb-2" style="column-gap: 8px;">
                    <p class="text-muted mb-0">{{ $data->job->employer->name }}</p>
                </div>
                <div class="d-flex align-items-center justify-content-start mb-2" style="column-gap: 5px;">
                    <span class="badge rounded-1 text-muted border px-2">{{ 'RM' . $data->job->salary }}</span>
                    <span class="badge rounded-1 text-muted border px-2">{{ $data->job->type }}</span>
                    <span class="badge rounded-1 text-muted border px-2">{{ $data->job->category }}</span>
                </div>
                <div class="w-100 d-flex align-items-center justify-content-between">
                    <small class="text-muted" style="font-size: 13px;">Posted {{ $data->job->created_at->diffForHumans() }}</small>
                    <span class="badge bg-dark px-2 fw-normal" style="font-size: 13px; padding-bottom: 5px;">{{ $data->status }}</span>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between w-100 p-3">
                <div class="d-flex justify-content-start align-items-start flex-row">
                    <a href="{{ route('users', strtolower($data->user->name)) }}" class="rounded-circle text-decoration-none" style="height: 50px; width: 50px; overflow: hidden;">
                        <img src="{{ asset('images/' . $data->user->profile_image) }}" class="w-100 h-100" style="object-fit: cover;">
                    </a>
                    <div class="ms-3 d-flex align-items-start justify-content-center flex-column" style="transform: translateY(4px);">
                        <a href="{{ route('users', strtolower($data->user->name)) }}" class="text-decoration-none mb-0 text-dark fw-bold" style="font-size: 14px;">{{ $data->user->name }}</a>
                        <small class="text-muted" style="font-size: 13px;">Joined at {{ $data->user->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                <a href="" class="btn px-3" style="border: 1.5px solid #2891e1">
                    <i class="fa-solid fa-message py-1"></i>
                </a>
            </div>
        </div>
    </div>
@endsection