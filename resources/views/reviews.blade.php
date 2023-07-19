@extends('layouts.app')

@section('content')

    <div class="container-xl">
        <div class="row mx-0 mt-4">
            <div class="col-lg-9 col-12 mt-3">
                <div class="shadow-sm border rounded position-relative w-100" style="background-color: #fff;">
                    <a href="{{ route('services', $service->slug) }}" class="text-decoration-none d-flex align-items-start justify-content-start flex-sm-row flex-column gap-3 ps-3 pe-4 py-3 flex-row">
                        <div id="parent_image_category">
                            <div class="rounded border" id="category_image">
                                @foreach (explode(',', $service->image) as $key => $image)
                                    @if ($key === 0)
                                        <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="pb-sm-2 pb-5 pt-sm-2 pt-0 w-100">
                            <div class="d-flex align-items-center justify-content-between lh-sm">
                                <h1 class="h5 mb-0 text-dark">{{ $service->title }}</h1>
                                <div class="d-flex align-items-center justify-content-end gap-1">
                                    <small class="text-dark">{{ $service->rating->max('stars') }}</small>
                                    <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i>
                                </div>
                            </div>
                            <?php
                                $category_name = $service->category;
                                $pathCategories = file_get_contents(public_path('json/category.json'));
                                $data = json_decode($pathCategories, true);
                                
                                $filter = array_filter($data, function($category) use($category_name) {
                                    return $category['slug'] === $category_name;
                                });
                            ?>
                            <small class="d-block lh-sm text-muted" style="font-size: 12.5px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                            <div class="mt-2">
                                <p class="mb-0 text-dark">${{ $service->price }}</p>
                            </div>
                        </div>
                    </a>
                    <div class="position-absolute w-100 bottom-0 pb-3 pe-3">
                        <div class="d-flex justify-content-end gap-1">
                            <button class="btn btn-dark"><i class="mdi mdi-message-text"></i></button>
                            @if (auth()->check())
                                <?php
                                    $userOrder = auth()->user()->order->where('service_id', $service->id)->sortByDesc('created_at')->first();
                                    $rejectOrCompleted = $userOrder && in_array($userOrder->status, ['rejected', 'completed']);
                                    $pendingOrApproved = $userOrder && in_array($userOrder->status, ['pending', 'approved']);
                                ?>
                                @if ($rejectOrCompleted)
                                    <input type="hidden" id="service_id" value="{{ $service->id }}">
                                    @if (auth()->check() && auth()->user()->roles != '0')
                                        <button class="btn px-3 btn-sm py-2 text-light order-btn" style="background-color: #2891e1; font-size: 14px;">Place Order</button>
                                        <form action="{{ route('profile.order') }}" method="get" class="d-none">
                                            @csrf
                                            <button type="submit" class="btn px-3 btn-sm py-2 text-light" style="background-color: #2891e1; font-size: 14px;">Check Order</button>
                                        </form>
                                    @else
                                        <form action="{{ route('profile.main') }}" method="get">
                                            @csrf
                                            <button type="submit" class="btn px-3 btn-sm py-2 text-light" style="background-color: #2891e1; font-size: 14px;">Place Order</button>
                                        </form>
                                    @endif
                                    <input type="hidden" id="freelancer_id" value="{{ $service->freelancer->id }}">
                                @elseif ($pendingOrApproved)
                                    @if ($userOrder->status === 'pending')
                                        <form action="{{ route('profile.order') }}" method="get">
                                            @csrf
                                            <button type="submit" class="btn px-3 btn-sm py-2 text-light" style="background-color: #2891e1; font-size: 14px;">Check Order</button>
                                        </form>
                                    @elseif ($userOrder->status === 'approved')
                                        <form action="{{ route('profile.order-approved') }}" method="get">
                                            @csrf
                                            <button type="submit" class="btn px-3 btn-sm py-2 text-light" style="background-color: #2891e1; font-size: 14px;">Check Order</button>
                                        </form>
                                    @endif
                                @else
                                {{-- No Order Yet. --}}
                                    <input type="hidden" id="service_id" value="{{ $service->id }}">
                                    @if (auth()->check() && auth()->user()->roles != '0')
                                        <button class="btn px-3 btn-sm py-2 text-light order-btn" style="background-color: #2891e1; font-size: 14px;">Place Order</button>
                                        <form action="{{ route('profile.order') }}" method="get" class="d-none">
                                            @csrf
                                            <button type="submit" class="btn px-3 btn-sm py-2 text-light" style="background-color: #2891e1; font-size: 14px;">Check Order</button>
                                        </form>
                                    @else
                                        <form action="{{ route('profile.main') }}" method="get">
                                            @csrf
                                            <button type="submit" class="btn px-3 btn-sm py-2 text-light" style="background-color: #2891e1; font-size: 14px;">Place Order</button>
                                        </form>
                                    @endif
                                    <input type="hidden" id="freelancer_id" value="{{ $service->freelancer->id }}">
                                @endif
                            @else
                                <form action="{{ route('profile.main') }}" method="get">
                                    @csrf
                                    <button type="submit" class="btn px-3 btn-sm py-2 text-light" style="background-color: #2891e1; font-size: 14.5px;">Place Order</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mx-0 border-bottom py-4 gap-sm-0 gap-4">
                    <div class="col-sm-4 col-12 d-flex align-items-sm-start align-items-center justify-content-center flex-column" style="row-gap: 8px;">
                        <p class="mb-0 text-muted">Total Orders</p>
                        <div class="d-flex jusitfy-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                <i class="me-2 mdi mdi-text-box-check-outline" style="font-size: 20px;"></i>
                                <h1 class="h5 text-dark mb-0">{{ count($service->order->where('status', 'completed')) < 1 ? 'No Orders' : count($service->order->where('status', 'completed')) }}</h1>
                            </div>
                            <small class="text-muted" style="font-size: 12.5px;">Growth in orders on this year</small>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 d-flex align-items-sm-start align-items-center justify-content-center flex-column" style="row-gap: 8px;">
                        <p class="mb-0 text-muted">Total Reviews</p>
                        <div class="d-flex jusitfy-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                <i class="me-2 mdi mdi-file-document-check-outline" style="font-size: 20px;"></i>
                                <h1 class="h5 text-dark mb-0">{{ count($reviews) < 1 ? 'No Review' : count($reviews) }}</h1>
                            </div>
                            <small class="text-muted" style="font-size: 12.5px;">Growth in review on this year</small>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 d-flex align-items-sm-start align-items-center justify-content-center flex-column" style="row-gap: 8px;">
                        <p class="mb-0 text-muted">Average Ratings</p>
                        <div class="d-flex justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-sm-start justify-content-center mb-1">
                                <h1 class="h5 text-dark mb-0">{{ count($reviews) < 1 ? 'No Review' : $reviews->max('stars') . '.0' }}</h1>
                                <div class="ms-2">
                                    @for ($i = 0; $i < $reviews->max('stars'); $i++)
                                        <i class="fa-solid fa-star text-warning" style="font-size: 14px;"></i>
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted" style="font-size: 12.5px;">Average rating on this year</small>
                        </div>
                    </div>
                </div>
                <div class="gap-3">
                    @foreach ($reviews as $review)
                        <div class="row mx-0 mt-4">
                            <div class="col-sm-4 col-2">
                                <div class="d-flex align-items-center justify-content-start gap-3">
                                    <div class="">
                                        <div class="rounded-circle rounded-md" style="height: 45px; width: 45px; overflow: hidden;">
                                            <img src="{{ asset('images/' . $review->user->image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                        </div>
                                    </div>
                                    <div class="d-sm-flex d-none align-items-center justify-content-start">
                                        <small class="text-dark mb-0" style="font-size: 13px;">{{ $review->user->name }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-9">
                                <small class="text-dark d-sm-none d-block">{{ $review->user->name }}</small>
                                <div class="d-flex align-items-center justify-content-start gap-2">
                                    <div class="">
                                        @for ($i = 1; $i <= $review->stars; $i++)
                                            <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i>
                                        @endfor
                                    </div>
                                    <div class="">
                                        <small class="text-muted" style="font-size: 12.5px;">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p class="text-dark mb-1">{{ $review->title }}</p>
                                    <div class="my-2 rounded border" style="height: 75px; width: 75px; overflow: hidden;">
                                        <img src="{{ asset('images/' . $review->images) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
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