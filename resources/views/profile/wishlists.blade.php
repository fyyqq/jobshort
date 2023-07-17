@extends('profile.layouts.app')


@section('profile')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

    <header class="pb-4">
        <div class="box-title border p-3 mb-2" style="border-top-right-radius: 10px; border-top-left-radius: 10px; background-color: #fff;">
            <h6 class="m-0">Wishlist</h6>
        </div>
        <div class="mt-4">
            <div class="row mx-0 d-flex justify-content-start align-items-center position-relative" style="row-gap: 15px; {{ count($wishlists) < 1 ? 'height: 450px;' : 'height: max-content;' }}">
                @if (count($wishlists) < 1)
                    <div class="position-absolute text-center" style="transform: translateY(-20px);">
                        <i class="fa-regular fa-folder-open d-block mb-3" style="font-size: 35px;"></i>
                        <small class="mb-0 text-muted">No Service In Wishlist</small>
                    </div>
                @else
                    @foreach ($wishlists as $wishlist)
                        <div class="col-sm-6 col-12">
                            <a href="{{ route('services', $wishlist->service->slug) }}" class="text-decoration-none">
                                <div class="d-flex align-items-center justify-content-center flex-column">
                                    <div class="rounded w-100 position-relative" style="height: 220px; overflow: hidden;">
                                        @foreach (explode(',', $wishlist->service->image) as $key => $image)
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
                                            <i class="fa-solid fa-heart position-absolute unwishlist {{ count(auth()->user()->wishlist->where('service_id', $wishlist->service->id)) == 1 ? 'd-block' : 'd-none' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                            <input type="hidden" value="{{ $wishlist->service->id }}">
                                            <i class="fa-regular fa-heart position-absolute wishlist {{ count(auth()->user()->wishlist->where('service_id', $wishlist->service->id)) == 1 ? 'd-none' : 'd-block' }}" style="font-size: 18px; right: 15px; top: 10px;"></i>
                                        @endif
                                    </div>
                                    <div class="p-2 w-100 mt-1">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <p class="mb-0 text-dark" style="width: 95%; font-size: 14.5px;">{{ Str::limit($wishlist->service->title, 35) }}</p>
                                            <div class="d-flex align-items-center justify-content-end flex-row-reverse">
                                                <i class="fa-solid fa-star text-warning" style="font-size: 13.5px;"></i>
                                                <small class="me-1 text-dark" style="font-size: 13.5px;">{{ $wishlist->service->rating->max('stars') < 1 ? '0' : $wishlist->service->rating->max('stars') . '.0' }}</small>
                                            </div>
                                        </div>
                                        <?php
                                            $category_name = $wishlist->service->category;
                                            $pathCategories = file_get_contents(public_path('json/category.json'));
                                            $data = json_decode($pathCategories, true);
                                            
                                            $filter = array_filter($data, function($category) use($category_name) {
                                                return $category['slug'] === $category_name;
                                            });
                                        ?>
                                        <small class="text-muted d-block" style="font-size: 12px;">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</small>
                                        <div class="mt-2 d-flex align-items-center justify-content-between">
                                            <small class="mb-0 text-dark" style="font-size: 14.5px;">{{ '$' . $wishlist->service->price }}</small>
                                            <small class="mb-0 text-dark"><i class="me-1 mdi mdi-text-box-check-outline"></i>{{ count($wishlist->service->order->where('status', 'completed')) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </header>

@endsection
