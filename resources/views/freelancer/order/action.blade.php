@foreach ($orders as $order)
    <div class="d-flex align-items-center justify-content-start flex-column border rounded px-md-3 px-1" id="order_container" style="background-color:#fff;">
        <div class="{{ (Route::currentRouteName() == 'freelancer.order-completed') ? 'd-flex' : 'd-none' }} align-items-center justify-content-between w-100 p-3">
            <div class="">
                <small class="mb-0 text-dark" id="order-time">Order at {{ $order->created_at->diffForHumans() }}</small>
            </div>
            <div class="d-flex align-items-center" style="column-gap: 5px;">
                {{-- Button Modal Ratings --}}
                @if ($order->rating)
                    <button type="button" class="btn btn-sm btn-success text-light" id="order-action" data-bs-toggle="modal" data-bs-target="#modal_review{{ $order->ratings->id }}">Show Rating<i class="fa-solid fa-chevron-right ms-2" style="font-size: 12px;"></i></button>
                    {{-- Modal --}}
                    <div class="modal fade" id="modal_review{{ $order->ratings->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Rating & Review</h1>
                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex align-items-start justify-content-start flex-column">
                                        <div class="px-2">
                                            <div class="border rounded {{ $order->ratings->images != null ? 'd-block' : 'd-none' }}" style="width: 80px; height: 80px; overflow: hidden;">
                                                <img src="{{ asset('images/' . $order->ratings->images) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                                            </div>
                                            <div class="my-2">
                                                @for ($i = 0; $i < $order->ratings->stars; $i++)
                                                    <i class="fa-solid fa-star text-warning" style="font-size: 14px;"></i>
                                                @endfor
                                            </div>
                                            <p class="mb-2 text-dark" style="font-size: 14px;">{{ $order->ratings->title }}</p>
                                            <p class="mb-0 text-muted" style="font-size: 14px;">{{ $order->ratings->review }}</p>
                                            <div class="mt-2 w-100 text-start">
                                                <small class="text-dark" style="font-size: 13px;">Posted - {{ $order->ratings->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="{{ (Route::is('freelancer.order-approved') || Route::is('freelancer.order-rejected') || Route::is('freelancer.order-completed')) ? 'd-none' : 'd-flex' }} align-items-center justify-content-between w-100 p-3">
            <div class="">
                <small class="mb-0 text-dark" id="order-time">Order at {{ $order->created_at->diffForHumans() }}</small>
            </div>
            <div class="d-flex align-items-center" style="column-gap: 5px;">
                @if (Route::is('freelancer.order') || Route::is('freelancer.order-pending'))
                    <input type="hidden" id="order_id" value="{{ $order->id }}">
                    <button class="btn btn-sm btn-success approve-btn" id="order-action">Approved</button>
                @endif
            </div>
        </div>
        <div class="w-100 py-3 px-3 text-decoration-none position-relative border-top border-bottom">
            <a href="{{ route('services', $order->service->slug) }}" class="text-decoration-none d-flex align-items-start w-100 justify-content-start text-dark">
                <div class="rounded" style="height: 80px; width: 80px; overflow: hidden;">
                    @foreach (explode(',', $order->service->image) as $key => $value)
                        @if ($key === 0)
                            <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                        @endif
                    @endforeach
                </div>
                <?php
                    $category_name = $order->service->category;
                    $pathCategories = file_get_contents(public_path('json/category.json'));
                    $data = json_decode($pathCategories, true);
                    
                    $filter = array_filter($data, function($category) use($category_name) {
                        return $category['slug'] === $category_name;
                    });
                ?>
                <div class="ms-3 d-flex flex-column justify-content-center align-items-start" style="flex-grow: 1;">
                    <p class="mb-1" id="service-order-title">{{  Str::limit($order->service->title, 50) }}</p>
                    <div class="d-flex align-items-center justify-content-start" style="column-gap: 5px;">
                        <span class="badge rounded-1 text-muted border px-2" id="order-price">{{ '$' . $order->service->price }}</span>
                        <span class="badge rounded-1 text-muted border px-2" id="order-category">{{ !empty($filter) ? array_column($filter, 'name')[0] : 'null' }}</span>
                    </div>
                    <div class="mt-2 w-100 text-md-end text-start">
                        @if (Route::is('freelancer.order') || Route::is('freelancer.order-pending'))
                            <span class="badge bg-warning px-2 fw-normal" id="order-status">{{ $order->status }}</span>
                        @elseif (Route::is('freelancer.order-approved'))
                            <span class="badge bg-success px-2 fw-normal" id="order-status">{{ $order->status }}</span>
                        @elseif (Route::is('freelancer.order-rejected'))
                            <span class="badge bg-danger px-2 fw-normal" id="order-status">{{ $order->status }}</span>
                        @elseif (Route::is('freelancer.order-completed'))
                            <span class="badge bg-dark px-2 fw-normal" id="order-status">{{ $order->status }}</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        <div class="d-flex align-items-center justify-content-between w-100 px-3 py-3">
            <div class="d-flex justify-content-start align-items-center flex-row">
                <a href="{{ route('users', strtolower($order->user->name)) }}" id="order-img" class="rounded-circle text-decoration-none" style="overflow: hidden;">
                    <img src="{{ asset('images/' . $order->user->image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                </a>
                <div class="ms-3 d-flex align-items-center justify-content-center">
                    <small class="mb-0 text-dark fw-bold" style="font-size: 14px;">{{ $order->user->name }}</small>
                </div>
            </div>
            <div class="pe-lg-4 pe-2">
                <i class="mdi mdi-message-reply-text text-dark" style="font-size: 20px;"></i>
            </div>
        </div>
    </div>
@endforeach