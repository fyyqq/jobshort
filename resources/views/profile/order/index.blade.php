@extends('profile.order.layouts.app')

@section('pages')
    <div class="row mx-0 d-flex justify-content-center align-items-center position-relative" style="gap: 15px; {{ count($orders) < 1 ? ' height: 450px;' : 'max-content' }}">
        @if (count($orders) < 1)
            <div class="position-absolute text-center" style="transform: translateY(-20px);">
                <i class="fa-regular fa-folder-open d-block mb-3" style="font-size: 35px;"></i>
                @if (Route::currentRouteName() == 'profile.applied')
                    <small class="mb-0 text-muted">No Pending Order</small>
                @elseif (Route::currentRouteName() == 'profile.applied-approved')
                    <small class="mb-0 text-muted">No Approved Order</small>
                @elseif (Route::currentRouteName() == 'profile.applied-rejected')
                    <small class="mb-0 text-muted">No Rejected Order</small>
                @elseif (Route::currentRouteName() == 'profile.applied-completed')
                    <small class="mb-0 text-muted">No Completed Order</small>
                @endif
            </div>
        @else
            @foreach ($orders as $order)
                <div class="d-flex align-items-center justify-content-start flex-column border rounded" style="background-color:#fff;">
                    <div class="{{ $order->status === 'rejected' ? 'd-none' : 'd-flex' }} align-items-center justify-content-between w-100 p-3 border-bottom">
                        <div class="">
                            <small class="mb-0 text-dark" style="font-size: 13px;">Order at {{ $order->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="d-flex align-items-center" style="column-gap: 5px;">
                            @if (Route::currentRouteName() == 'profile.applied')
                                <button class="btn btn-sm btn-outline-danger reject-btn" id="order-action-btn">Cancel</button>
                                <input type="hidden" id="order_id" value="{{ $order->id }}">
                            @elseif (Route::currentRouteName() == 'profile.applied-approved')
                                <button class="btn btn-sm btn-outline-danger reject-btn" id="order-action-btn">Cancel</button>
                                <input type="hidden" id="order_id" value="{{ $order->id }}">
                                <button class="btn btn-sm btn-dark complete-btn" id="order-action-btn">Completed</button>
                            @elseif (Route::currentRouteName() == 'profile.applied-completed')
                                @if ($order->rating)
                                    <button type="button" class="btn btn-sm btn-success text-light" data-bs-toggle="modal" data-bs-target="#modal_review{{ $order->ratings->id }}">Show Rating<i class="fa-solid fa-chevron-right ms-2" style="font-size: 12px;"></i></button>
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
                                                                <img src="{{ asset('images/' . $order->ratings->images) }}" class="w-100 h-100" style="object-fit: cover;">
                                                            </div>
                                                            <div class="my-2">
                                                                @for ($i = 0; $i < $order->ratings->stars; $i++)
                                                                    <i class="fa-solid fa-star text-warning" style="font-size: 14px;"></i>
                                                                @endfor
                                                            </div>
                                                            <p class="mb-2 text-dark" style="font-size: 14px;">{{ $order->ratings->title }}</p>
                                                            <p class="mb-0 text-muted" style="font-size: 14px;">{{ $order->ratings->review }}</p>
                                                            <div class="mt-2 w-100 text-end">
                                                                <small class="text-muted" style="font-size: 13px;">Posted - {{ $order->ratings->created_at->diffForHumans() }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <button type="button" class="btn btn-sm text-light" data-bs-toggle="modal" data-bs-target="#modal_rating{{ $order->id }}" style="background-color: #2891e1;">Review & Rating<i class="fa-solid fa-chevron-right ms-2" style="font-size: 12px;"></i></button>
                                    {{-- Modal --}}
                                    <div class="modal fade" id="modal_rating{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content px-2">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Review & Ratings</h5>
                                                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form class="formRating" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label for="recipient-name" class="col-form-label">Images :</label>
                                                            <div class="mt-1 d-flex align-items-center justify-content-start" style="column-gap: 10px;">
                                                                <div class="border border-dark rounded position-relative d-flex align-items-center justify-content-center" style="height: 85px; width: 85px;">
                                                                    <img src="" class="w-100 h-100 d-none" style="object-fit: cover;">
                                                                    <input type="file" class="position-absolute w-100 h-100" name="images" id="" accept="image/png, image/jpeg, image/jpg" style="top: 0; left: 0; opacity: 0; cursor: pointer; font-size: .01px;" onchange="return autoImage(this)">
                                                                    <i class="fa-regular fa-image" style="font-size: 18px;"></i>
                                                                    <i class="fa-solid fa-xmark position-absolute p-1 d-none" id="remove_image" style="font-size: 13px; top: 0px; right: 0px;"></i>
                                                                </div>
                                                            </div>
                                                            <div id="emailHelp" class="mt-2 w-100 text-start form-text" style="font-size: 13px;">Support <b>MP4</b>, <b>JPG</b>, <b>JPEG</b> &  <b>PNG</b> file.</div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Star :</label>
                                                            <div class="d-flex align-items-center justify-content-start flex-row mt-1" id="stars" style="column-gap: 5px;">
                                                                <i class="fa-regular fa-star" style="font-size: 17px;"></i>
                                                                <i class="fa-regular fa-star" style="font-size: 17px;"></i>
                                                                <i class="fa-regular fa-star" style="font-size: 17px;"></i>
                                                                <i class="fa-regular fa-star" style="font-size: 17px;"></i>
                                                                <i class="fa-regular fa-star" style="font-size: 17px;"></i>
                                                            </div>
                                                            <input type="hidden" name="stars" id="starLength">
                                                            
                                                        </div>
                                                        <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                                                        <input type="hidden" name="freelancer_id" value="{{ $order->freelancer->id }}">
                                                        <input type="hidden" name="service_id" value="{{ $order->service->id }}">
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <div class="mb-3">
                                                            <label for="recipient-name" class="col-form-label">Title :</label>
                                                            <input type="text" name="title" class="form-control shadow-none" id="recipient-name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="review" class="col-form-label">Message :</label>
                                                            <textarea name="review" class="form-control shadow-none" id="review"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="submit-rating" class="btn btn-sm btn-primary px-4">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('services', $order->service->slug) }}" class="w-100 py-3 px-3 text-decoration-none position-relative text-dark">
                        <div class="d-flex align-items-start w-100 justify-content-start">
                            <div class="rounded" id="order-profile-img" style="overflow: hidden;">
                                @foreach (explode(',', $order->service->image) as $key => $value)
                                    @if ($key === 0)
                                        <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @endif
                                @endforeach
                            </div>
                            <div class="ms-3 d-flex flex-column justify-content-start align-items-start" style="flex-grow: 1;">
                                <div class="d-flex align-items-center justify-content-between w-100">
                                    <p class="mb-1" id="order-profile-title">{{ Str::limit($order->service->title, 50) }}</p>
                                    <div class="">
                                        <i class="fa-solid fa-heart unwishlist {{ count(auth()->user()->wishlist->where('service_id', $order->service->id)) == 1 ? 'd-block' : 'd-none' }}"></i>
                                        <input type="hidden" value="{{ $order->service->id }}">
                                        <i class="fa-regular fa-heart wishlist {{ count(auth()->user()->wishlist->where('service_id', $order->service->id)) == 1 ? 'd-none' : 'd-block' }}"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start" style="column-gap: 5px;">
                                    <span class="badge rounded-1 text-muted border px-2" style="font-size: 11.5px;">{{ 'RM' . $order->service->price }}</span>
                                    <span class="badge rounded-1 text-muted border px-2" style="font-size: 11.5px;">{{ $order->service->category }}</span>
                                </div>
                                <div class="mt-2 w-100 text-sm-end text-start">
                                    @if (Route::currentRouteName() == 'profile.applied')
                                        <span class="badge bg-warning px-2 fw-normal" id="status-order">{{ $order->status }}</span>
                                    @elseif (Route::currentRouteName() == 'profile.applied-approved')
                                        <span class="badge bg-success px-2 fw-normal" id="status-order">{{ $order->status }}</span>
                                    @elseif (Route::currentRouteName() == 'profile.applied-rejected')
                                        <span class="badge bg-danger px-2 fw-normal" id="status-order">{{ $order->status }}</span>
                                    @elseif (Route::currentRouteName() == 'profile.applied-completed')
                                        <span class="badge bg-dark px-2 fw-normal" id="status-order">{{ $order->status }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="d-flex align-items-center justify-content-between w-100 p-3 border-top">
                        <div class="d-flex justify-content-start align-items-center flex-row">
                            <div class="rounded-circle" id="order-freelancer-profile" style="overflow: hidden;">
                                <img src="{{ $order->freelancer->image !== null ? asset('images/' . $order->freelancer->image) : asset('brand/unknown.png') }}" class="w-100 h-100" style="object-fit: cover;">
                            </div>
                            <div class="ms-3 d-flex align-items-start justify-content-center flex-column">
                                <a href="{{ route('users', strtolower($order->service->freelancer->name)) }}" class="text-decoration-none mb-0 text-dark" style="font-size: 14px;">{{ $order->service->freelancer->name }}</a>
                            </div>
                        </div>
                        {{-- <a href="" class="btn btn-sm px-3" id="order-chat-btn" style="background-color: #2891e1;">
                            <i class="fa-solid fa-message py-1"></i>
                        </a> --}}
                        <div class="pe-4">
                            <i class="fa-solid fa-message text-dark"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection