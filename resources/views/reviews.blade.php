@extends('layouts.app')

@section('content')

    <div class="container-xl">
        <div class="row mx-0 mt-4">
            <div class="col-md-9 col-12 mt-3">
                <div class="shadow-sm border rounded px-1 row mx-0 mb-3 p-3">
                    <a href="{{ route('jobs', $service->slug) }}" class="text-decoration-none d-flex align-items-start justify-content-start gap-4 border-bottom pb-3">
                        <div class="rounded border" style="height: 150px; width: 200px; overflow: hidden;">
                            @foreach (explode(',', $service->image) as $key => $image)
                                @if ($key === 0)
                                    <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;">
                                @endif
                            @endforeach
                        </div>
                        <div class="py-1 w-100">
                            <div class="d-flex align-items-start justify-content-between">
                                <h1 class="h5 text-dark mb-0">{{ $service->title }}</h1>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <small class="text-dark mb-0 mt-1">{{ $service->rating->max('stars') . '.0' }}</small>
                                    <i class="fa-solid fa-star text-warning"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-start justify-content-center flex-column gap-1">
                                <small class="text-muted">{{ $service->category }}</small>
                                <small class="text-muted d-md-block d-none">{{ Str::limit($service->description, 180) }}</small>
                                <small class="text-muted d-md-none d-block">{{ Str::limit($service->description, 100) }}</small>
                            </div>
                        </div>
                    </a>
                    <div class="w-100 mt-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-end justify-content-start gap-1">
                            <h1 class="h4 text-dark mb-0">{{ '$' . $service->price }}</h1>
                            <small class="text-muted">per service</small>
                        </div>
                        <button class="btn text-light" style="font-size: 15px; background-color: #2891e1;">Place Order</button>
                    </div>
                </div>
                {{-- <h1 class="h4 text-dark">Review & Rating</h1> --}}
                <div class="row mx-0 border-bottom py-4 gap-sm-0 gap-3">
                    <div class="col-sm-4 col-12 border-end d-flex align-items-start justify-content-center flex-column" style="row-gap: 8px;">
                        <p class="mb-0 text-muted">Total Reviews</p>
                        <div class="d-flex jusitfy-content-center flex-column">
                            <h1 class="{{ count($reviews) < 1 ? 'h5' : 'h4' }} text-dark mb-1">{{ count($reviews) < 1 ? 'No Review' : count($reviews) }}</h1>
                            <small class="text-muted" style="font-size: 12.5px;">Growth in review on this year</small>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 border-end d-flex align-items-start justify-content-center flex-column" style="row-gap: 8px;">
                        <p class="mb-0 text-muted">Average Ratings</p>
                        <div class="d-flex justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-start mb-1">
                                <h1 class="{{ count($reviews) < 1 ? 'h5' : 'h4' }} text-dark mb-0">{{ count($reviews) < 1 ? 'No Review' : $reviews->max('stars') . '.0' }}</h1>
                                <div class="ms-2">
                                    @for ($i = 0; $i < $reviews->max('stars'); $i++)
                                        <i class="fa-solid fa-star text-warning" style="font-size: 14px;"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted" style="font-size: 12.5px;">Average rating on this year</small>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 d-flex align-items-start justify-content-center flex-column" style="row-gap: 8px;">
                        <div class="w-100 d-flex flex-column-reverse">
                            <div class="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-danger" style="font-size: 12px; width: 10%"></div>
                            </div>
                            <div class="progress mb-1" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-warning" style="font-size: 12px; width: 25%"></div>
                            </div>
                            <div class="progress mb-1" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-info" style="font-size: 12px; width: 50%"></div>
                            </div>
                            <div class="progress mb-1" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-primary" style="font-size: 12px; width: 75%"></div>
                            </div>
                            <div class="progress mb-1" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="font-size: 12px; width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gap-3">
                    @foreach ($reviews as $review)
                        <div class="row mx-0 mt-4">
                            <div class="col-md-4 col-2">
                                <div class="d-flex align-items-start justify-content-start gap-3">
                                    <div class="rounded-circle rounded-md" style="height: 50px; width: 50px; overflow: hidden;">
                                        <img src="{{ asset('images/' . $review->user->image) }}" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <div class="d-md-flex d-none align-items-center justify-content-start">
                                        <p class="text-dark fw-bold">{{ $review->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-9">
                                <h1 class="h6 text-dark fw-bold d-md-none d-block">{{ $review->user->name }}</h1>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="">
                                        @for ($i = 1; $i <= $review->stars; $i++)
                                            <i class="fa-solid fa-star text-warning" style="font-size: 14px;"></i>
                                        @endfor
                                    </div>
                                    <div class="">
                                        <small class="text-muted" style="font-size: 13px;">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p class="text-dark mb-1">{{ $review->title }}</p>
                                    <div class="my-2 rounded border" style="height: 75px; width: 75px; overflow: hidden;">
                                        <img src="{{ asset('images/' . $review->images) }}" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <small class="text-muted">{{ $review->review }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection