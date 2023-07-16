@extends('freelancer.layouts.app')

@section('content')
    <div class="container-employer pt-md-4 pt-3 px-lg-4 px-2">
        <div class="content">
            <div class="border rounded py-md-4 py-3 px-md-4 px-3 d-flex align-items-center justify-content-start gap-3" style="background-color: #fff;">
                <div class="py-1 px-2" style="cursor: pointer;" onclick="return goToPreviousPage()">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <h1 class="h4 text-dark mb-0 d-md-block d-none" style="font-size: 20px;">Service Order</h1>
                <h1 class="h4 text-dark mb-0 d-md-none d-block" style="font-size: 17px;">Service Order</h1>
            </div>
            <div class="border rounded my-2" style="background-color: #fff;">
                <ul class="navbar-nav px-md-3 px-2" id="parent-order-menu">
                    <div class="d-flex align-items-center justify-content-start">
                        <li data-order-link="{{ route('freelancer.order-pending') }}" class="position-relative order-menu-link {{ Route::is('freelancer.order') || Route::is('freelancer.order-pending') ? 'border-bottom border-2 border-primary' : '' }}">
                            <span class="btn p-3 rounded-0" style="font-size: 14px;">Pending</span>
                            <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                        </li>
                        <li data-order-link="{{ route('freelancer.order-approved') }}" class="position-relative order-menu-link {{ Route::is('freelancer.order-approved') ? 'border-bottom border-2 border-primary' : '' }}">
                            <span class="btn p-3 rounded-0" style="font-size: 14px;">Approved</span>
                            <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                        </li>
                        <li data-order-link="{{ route('freelancer.order-rejected') }}" class="position-relative order-menu-link {{ Route::is('freelancer.order-rejected') ? 'border-bottom border-2 border-primary' : '' }}">
                            <span class="btn p-3 rounded-0" style="font-size: 14px;">Rejected</span>
                            <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                        </li>
                        <li data-order-link="{{ route('freelancer.order-completed') }}" class="position-relative order-menu-link {{ Route::is('freelancer.order-completed') ? 'border-bottom border-2 border-primary' : '' }}">
                            <span class="btn p-3 rounded-0" style="font-size: 14px;">Completed</span>
                            <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                        </li>
                    </div>
                </ul>
            </div>
            <div class="row mx-0 d-flex justify-content-center align-items-center position-relative" id="display-order" style="row-gap: 10px; height: max-content;">
                {{-- @if (count($orders) < 1)
                    <div class="position-absolute text-center" style="transform: translateY(-20px);">
                        <i class="fa-regular fa-folder-open" style="font-size: 35px;"></i>
                        @if (Route::currentRouteName() == 'freelancer.order')
                            <p class="mb-0 text-muted mt-3">No Pending Orders.</p>
                        @elseif (Route::currentRouteName() == 'freelancer.order-approved')
                            <p class="mb-0 text-muted mt-3">No Approved Orders.</p>
                        @elseif (Route::currentRouteName() == 'freelancer.order-rejected')
                            <p class="mb-0 text-muted mt-3">No Rejected Orders.</p>
                        @elseif (Route::currentRouteName() == 'freelancer.order-completed')
                            <p class="mb-0 text-muted mt-3">No Completed Orders.</p>
                        @endif
                    </div>
                @else --}}
                    @foreach ($orders as $order)
                        <div class="d-flex align-items-center justify-content-start flex-column border rounded px-md-3 px-1" style="background-color:#fff;">
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
                            <div class="{{ Route::is('freelancer.order-approved') || Route::is('freelancer.order-rejected') || Route::is('freelancer.order-completed') ? 'd-none' : 'd-flex' }} align-items-center justify-content-between w-100 p-3">
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
                                    <div class="ms-3 d-flex flex-column justify-content-center align-items-start" style="flex-grow: 1;">
                                        <p class="mb-1" id="service-order-title">{{  Str::limit($order->service->title, 50) }}</p>
                                        <div class="d-flex align-items-center justify-content-start" style="column-gap: 5px;">
                                            <span class="badge rounded-1 text-muted border px-2" id="order-price">{{ 'RM' . $order->service->price }}</span>
                                            <span class="badge rounded-1 text-muted border px-2" id="order-category">{{ $order->service->category }}</span>
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
                                    <i class="fa-solid fa-message text-dark"></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
                {{-- @endif --}}
            </div>
        </div>
    </div>
@endsection