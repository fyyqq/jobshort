@extends('profile.layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

@section('profile')

    <header class="pb-4 border shadow-sm" style="background-color: #fff;">
        <div class="p-4 border-bottom">
            <h1 class="h5 mb-1 text-dark">Saved Jobs</h1>
            <small class="text-muted" style="font-size: 13px;">Saved Your Jobs. If do you want apply sometimes.</small>
        </div>
        <div class="mt-3 px-3">
            <div class="row mx-0 d-flex justify-content-start align-items-center position-relative" style="gap: 15px; {{ count($wishlists) < 1 ? 'height: 450px;' : 'height: max-content;' }}">
                @if (count($wishlists) < 1)
                    <div class="position-absolute text-center" style="transform: translateY(-20px);">
                        <i class="fa-regular fa-folder-open" style="font-size: 35px;"></i>
                        <p class="mb-0 text-muted mt-3">No Jobs Saved Yet.</p>
                    </div>
                @else
                    @foreach ($wishlists as $wishlist)
                        <a href="{{ route('jobs', $wishlist->service->slug) }}" class="text-decoration-none border rounded-3 py-3 px-3 position-relative" style="height: max-content; background-color:#fff; cursor: pointer;">
                            <div class="d-flex align-items-center pe-5 w-100 justify-content-between">
                                <h1 class="h6 mb-1 fw-bold text-dark" style="font-size: 17px;">{{ Str::limit($wishlist->service->title, 55) }}</h1>
                                @if (!auth()->check())
                                    <a href="{{ route('login') }}" class="text-decoration-none">
                                        <i class="fa-regular fa-heart position-absolute" style="top: 15px; right: 20px; font-size: 16px;"></i>
                                    </a>
                                @else
                                    <i class="fa-solid fa-heart position-absolute unwishlist {{ count(auth()->user()->wishlist->where('service_id', $wishlist->service->id)) == 1 ? 'd-block' : 'd-none' }}" style="top: 15px; right: 20px; font-size: 16px;"></i>
                                    <input type="hidden" value="{{ $wishlist->service->id }}">
                                    <i class="fa-regular fa-heart position-absolute wishlist {{ count(auth()->user()->wishlist->where('service_id', $wishlist->service->id)) == 1 ? 'd-none' : 'd-block' }}" style="top: 15px; right: 20px; font-size: 16px;"></i>                                
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-start mb-0" style="column-gap: 8px;">
                                <p class="text-muted mb-0">{{ $wishlist->service->freelancer->name }}</p>
                            </div>
                            <p class="text-muted mb-2">{{ $wishlist->service->freelancer->city .' , '. $wishlist->service->freelancer->state }}</p>
                            <div class="d-flex align-items-center justify-content-start mb-3" style="column-gap: 5px;">
                                <span class="badge rounded-1 text-muted border px-2">RM {{ $wishlist->service->salary }}</span>
                                <span class="badge rounded-1 text-muted border px-2">{{ $wishlist->service->type }}</span>
                                <span class="badge rounded-1 text-muted border px-2">{{ $wishlist->service->category }}</span>
                            </div>
                            <div class="">
                                <small class="text-muted">{{ Str::limit($wishlist->service->description, 180) }}</small>
                            </div>
                            <div class="w-100 text-end mt-3">
                                <small class="text-muted text-end" style="font-size: 13px;">Posted {{ $wishlist->service->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </header>

@endsection
