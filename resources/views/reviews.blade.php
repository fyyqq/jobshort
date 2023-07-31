@extends('layouts.app')

@section('content')

    <div class="container-xl">
        <div class="row mx-0 mt-4">
            <div class="col-lg-9 col-12 mt-3">
                <div class="shadow-sm border rounded position-relative w-100" style="background-color: #fff;">
                    <a href="{{ route('services', $service->slug) }}" class="text-decoration-none d-flex align-items-start justify-content-start flex-sm-row flex-column ps-3 pe-4 py-3 flex-row">
                        <div id="parent_image_category">
                            <div class="rounded border" id="category_image">
                                @foreach (explode(',', $service->image) as $key => $image)
                                    @if ($key === 0)
                                        <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="ps-sm-3 ps-ms-0 py-sm-2 pt-2 pb-5 w-100">
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
                            <small class="d-block lh-base text-muted" style="font-size: 12px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                        </div>
                        <div class="mt-2 position-absolute bottom-0 end-0 p-3">
                            <h1 class="mb-0 text-dark h5">${{ $service->price }}</h1>
                        </div>
                    </a>
                </div>
                <div class="row mx-0 border d-flex align-items-center justify-content-between py-4 gap-sm-0 gap-4 my-3 rounded" style="background-color: #fff;">
                    <div class="col-sm-4 col-12 d-flex align-items-center justify-content-center flex-column" style="row-gap: 8px;">
                        <div class="d-flex jusitfy-content-center flex-column">
                            <p class="mb-0 text-muted text-sm-start text-center">Total Orders</p>
                            <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                <i class="me-2 mdi mdi-text-box-check-outline" style="font-size: 20px;"></i>
                                <h1 class="h5 text-dark mb-0">{{ count($service->order->where('status', 'completed')) < 1 ? 'No Orders' : count($service->order->where('status', 'completed')) }}</h1>
                            </div>
                            <small class="text-muted" style="font-size: 12.5px;">Growth in orders on this year</small>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 d-flex align-items-center justify-content-center flex-column" style="row-gap: 8px;">
                        <div class="d-flex jusitfy-content-center flex-column">
                            <p class="mb-0 text-muted text-sm-start text-center">Total Reviews</p>
                            <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                <i class="me-2 mdi mdi-file-document-check-outline" style="font-size: 20px;"></i>
                                <h1 class="h5 text-dark mb-0">{{ count($reviews) < 1 ? 'No Review' : count($reviews) }}</h1>
                            </div>
                            <small class="text-muted" style="font-size: 12.5px;">Growth in review on this year</small>
                        </div>
                    </div>
                    <div class="col-sm-4 col-12 d-flex align-items-center justify-content-center flex-column" style="row-gap: 8px;">
                        <div class="d-flex jusitfy-content-center flex-column">
                            <p class="mb-0 text-muted text-sm-start text-center">Total Reviews</p>
                            <div class="d-flex align-items-center justify-content-sm-start justify-content-center">
                                <h1 class="me-2 h5 text-dark mb-0">{{ $service->rating->max('stars') < 1 ? 'No Rating' : $service->rating->max('stars') . '.0' }}</h1>
                                @for($i = 1; $i <= $service->rating->max('stars'); $i++)
                                    <i class="mdi mdi-star text-warning" style="font-size: 20px;"></i>
                                @endfor
                            </div>
                            <small class="text-muted" style="font-size: 12.5px;">Growth in review on this year</small>
                        </div>
                    </div>
                </div>
                <div class="gap-3 card" style="background-color: #fff;">
                    <div class="card-header" style="background-color: #fff;">
                        <p class="mb-0">Reviews</p>
                    </div>
                    <div class="px-3">
                        @foreach ($reviews as $review)
                            <div class="row mx-0 py-3">
                                <div class="col-sm-4 col-2">
                                    <div class="d-flex align-items-center justify-content-start gap-3">
                                        <div class="">
                                            <div class="rounded-circle rounded-md" style="height: 42px; width: 42px; overflow: hidden;">
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
                                        <small class="text-dark mb-1">{{ $review->title }}</small>
                                        <div class="my-2 rounded border {{ is_null($review->images) ? 'd-none' : '' }}" style="height: 75px; width: 75px; overflow: hidden;">
                                            <img src="{{ asset('images/' . $review->images) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                        </div>
                                        <small class="text-muted" style="font-size: 13px;">{{ $review->review }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center border-top card-header" style="background-color: #fff;">
                        <small class="mb-0">End of Section</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection