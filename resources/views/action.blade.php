@foreach ($services->where('status', 'active') as $service)
    <div class="col-sm-6 col-12">
        <a href="{{ route('services', $service->slug) }}" class="text-decoration-none">
            <div class="d-flex align-items-center justify-content-center flex-column">
                <div class="rounded w-100 position-relative" style="height: 220px; overflow: hidden;">
                    @foreach (explode(',', $service->image) as $key => $image)
                        @if ($key === 0)
                            <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                        @endif
                    @endforeach
                    @if (!auth()->check())
                        <form action="{{ route('login') }}" method="get">
                            @csrf
                            <button type="submit" class="border-0" style="background: unset;">
                                <i class="fa-regular fa-heart position-absolute" style="font-size: 18px; right: 15px; top: 10px;"></i>
                            </button>
                        </form>
                    @else
                        <i class="fa-solid fa-heart position-absolute unwishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-block' : 'd-none' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                        <input type="hidden" value="{{ route('wishlist-service', $service->id) }}" id="wishlist_path">
                        <input type="hidden" value="{{ route('unwishlist-service', $service->id) }}" id="unwishlist_path">
                        <i class="fa-regular fa-heart position-absolute wishlist {{ count(auth()->user()->wishlist->where('service_id', $service->id)) == 1 ? 'd-none' : 'd-block' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                    @endif
                </div>
                <div class="p-2 w-100 mt-1">
                    <div class="lh-sm d-flex align-items-center justify-content-start">
                        <p class="mb-0 text-dark" style="width: 95%; font-size: 14.5px;">{{ Str::limit($service->title, 35) }}</p>
                        <div class="d-flex align-items-center justify-content-end flex-row-reverse">
                            <i class="fa-solid fa-star text-warning" style="font-size: 13.5px;"></i>
                            <small class="me-1 text-dark" style="font-size: 13.5px;">{{ $service->rating->max('stars') < 1 ? '0' : $service->rating->max('stars') . '.0' }}</small>
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
                    <small class="text-muted d-block" style="font-size: 12px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                    <div class="mt-2 d-flex align-items-center justify-content-between">
                        <small class="mb-0 text-dark" style="font-size: 14.5px;">{{ '$' . $service->price }}</small>
                        <small class="mb-0 text-dark"><i class="me-1 mdi mdi-text-box-check-outline"></i>{{ count($service->order->where('status', 'completed')) }}</small>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endforeach
