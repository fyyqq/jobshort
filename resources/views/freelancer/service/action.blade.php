@foreach ($services as $service)
    <div class="d-flex align-items-center px-0 py-2 border" id="parent_service" style="background-color: #fff;">
        <div class="col-1 px-0 d-flex align-items-center justify-content-center">
            <input type="checkbox" id="select-services">
            <input type="hidden" name="slug" value="{{ $service->slug }}">
        </div>
        <div class="col-lg-4 col-8 d-flex align-items-start justify-content-start gap-3 ms-sm-0 ms-2">
            <a href="{{ route('services', $service->slug) }}" class="d-block">
                <div class="rounded" style="height: 75px; width: 77px; overflow: hidden;">
                    @foreach (explode(',', $service->image) as $key => $value)
                        @if ($key === 0)
                            <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                        @endif
                    @endforeach
                </div>
            </a>
            <?php
                $category_name = $service->category;
                $pathCategories = file_get_contents(public_path('json/category.json'));
                $data = json_decode($pathCategories, true);
                
                $filter = array_filter($data, function($category) use($category_name) {
                    return $category['slug'] === $category_name;
                });
            ?>
            <div class="d-flex align-items-start justify-content-start flex-column mt-1 pe-4 w-100">
                <small class="text-dark d-lg-block d-none text-break lh-sm">{{ Str::limit($service->title, 30) }}</small>
                <small class="text-dark d-lg-none d-block lh-base">{{ Str::limit($service->title, 15) }}</small>
                <small class="mb-0 text-muted" style="font-size: 12px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                <div class="d-flex align-items-center justify-content-between mt-2 w-100">
                    <small class="mb-0 text-dark">{{ '$' . $service->price }}</small>
                    <div class="d-lg-none d-flex flex-row-reverse">
                        <div class="d-flex align-items-center justify-content-center gap-1 ps-1">
                            <i class="fa-solid fa-star text-warning" style="font-size: 12.5px;"></i>
                            <small class="text-muted">{{ $service->rating->max('stars') > 0 ? $service->rating->max('stars').'.0' : '0' }}</small>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-1 pe-1 border-end">
                            <i class="mdi mdi-text-box-check-outline" style="font-size: 15px;"></i>
                            <small class="text-muted">{{ $service->order->where('status', 'completed')->count() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center">
            <div class="mb-0 d-flex align-items-center justify-content-center gap-2">
                <i class="mdi mdi-text-box-check-outline" style="font-size: 16px;"></i>
                <small class="">{{ $service->order->where('status', 'completed')->count() }}</small>
            </div>
        </div>
        <div class="col-lg-2 col-0 d-lg-flex d-none align-items-center justify-content-center">
            <div class="mb-0 d-flex align-items-center justify-content-center gap-2">
                <i class="fa-solid fa-star text-warning" style="font-size: 13px;"></i>
                <small class="">{{ $service->rating->max('stars') > 0 ? $service->rating->max('stars').'.0' : '0' }}</small>
            </div>
        </div>
        <div class="col-lg-3 col-2 d-flex align-items-lg-center align-items-end justify-content-center flex-column" style="row-gap: 5px;">
            <div class="btn-group" role="group">
                <a href="{{ route('freelancer.edit-services', $service->slug) }}" class="btn btn-sm border btn-light px-3 d-md-block d-none">
                    <small class="text-dark">Edit</small>
                </a>
                <div class="btn-group dropdown">
                    <button type="button" class="border btn btn-light btn-sm" data-bs-toggle="dropdown">
                        <i class="mdi mdi-dots-vertical"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-left py-0" style="overflow: hidden;">
                        @if (Route::is('freelancer.services') || Route::is('freelancer.services-all'))
                            <button class="dropdown-item py-2 archive-service-btn" type="button">
                                <small class="text-dark" style="font-size: 12.5px;">Archive</small>
                            </button>
                        @elseif (Route::is('freelancer.services-archive'))
                            <button class="dropdown-item py-2 active-service-btn" type="button">
                                <small class="text-dark" style="font-size: 12.5px;">Active</small>
                            </button>
                        @endif
                        <a href="{{ route('freelancer.edit-services', $service->slug) }}" type="button" class="dropdown-item py-2 d-md-none d-block">
                            <small class="text-dark" style="font-size: 12.5px;">Edit</small>
                        </a>
                        <input type="hidden" value="{{ $service->slug }}" id="service-slug">
                        <button class="dropdown-item py-2 delete-service-btn" type="button">
                            <small class="text-dark" style="font-size: 12.5px;">Delete</small>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach