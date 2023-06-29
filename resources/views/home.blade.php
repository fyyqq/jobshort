@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

@section('content')

    <div class="my-4">
        <div class="px-md-3 px-2 owl-carousel owl-theme">
            @foreach ($categories as $category)
            <a href="{{ route('categories', $category['slug']) }}" class="jobCategories row mx-0 text-decoration-none px-3 item d-flex align-items-center rounded-3 justify-content-center border py-3" style="cursor: pointer; height: max-content;">
                <small class="text-dark mb-0">{{ $category['name'] }}</small>
            </a>
            @endforeach
        </div>
    </div>
    <div class="container-xl">
        <div class="row mx-0" style="row-gap: 25px;">
            @foreach ($services as $service)
                <div class="col-lg-4 col-sm-6 col-12 px-md-3">
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
                </div>
            @endforeach
        </div>
    </div>

@endsection
    
@if(session('success'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1800
            });
        });
    </script>
@endif