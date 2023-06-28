@extends('employer.applicant.layouts.app')

@section('pages')
    <div class="row mx-0 d-flex justify-content-center align-items-center position-relative" style="row-gap: 10px; {{ count($orders) < 1 ? 'height: 500px;' : 'height: max-content;' }}">
        @if (count($orders) < 1)
            <div class="position-absolute text-center" style="transform: translateY(-20px);">
                <i class="fa-regular fa-folder-open" style="font-size: 35px;"></i>
                @if (Route::currentRouteName() == 'employer.applicant')
                    <p class="mb-0 text-muted mt-3">No Pending Orders.</p>
                @elseif (Route::currentRouteName() == 'employer.applicant-approved')
                    <p class="mb-0 text-muted mt-3">No Approved Orders.</p>
                @elseif (Route::currentRouteName() == 'employer.applicant-rejected')
                    <p class="mb-0 text-muted mt-3">No Rejected Orders.</p>
                @elseif (Route::currentRouteName() == 'employer.applicant-completed')
                    <p class="mb-0 text-muted mt-3">No Completed Orders.</p>
                @endif
            </div>
        @else
            @foreach ($orders as $order)
                <div class="d-flex align-items-center justify-content-start flex-column border rounded" style="background-color:#fff;">
                    <div class="{{ (Route::currentRouteName() == 'employer.applicant-completed') ? 'd-flex' : 'd-none' }} align-items-center justify-content-between w-100 p-3">
                        <div class="">
                            <p class="mb-0 text-dark">Review & Ratings</p>
                        </div>
                        <div class="d-flex align-items-center" style="column-gap: 5px;">
                            {{-- Button Modal Ratings --}}
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
                    <div class="{{ (Route::currentRouteName() == 'employer.applicant-approved' || Route::currentRouteName() == 'employer.applicant-rejected' || Route::currentRouteName() == 'employer.applicant-completed') ? 'd-none' : 'd-flex' }}
                    align-items-center justify-content-between w-100 p-3">
                        <div class="">
                            <small class="mb-0 text-dark">Order at {{ $order->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="d-flex align-items-center" style="column-gap: 5px;">
                            @if (Route::currentRouteName() == 'employer.applicant')
                                <input type="hidden" id="order_id" value="{{ $order->id }}">
                                <button class="btn btn-sm btn-success approve-btn">Approved</button>
                            @elseif (Route::currentRouteName() == 'employer.applicant-rejected')
                                <button class="btn btn-sm btn-success approve-btn">Approved</button>
                                <input type="hidden" id="order_id" value="{{ $order->id }}">
                            @endif
                        </div>
                    </div>
                    <div class="w-100 py-3 px-3 text-decoration-none position-relative border-top border-bottom">
                        <a href="{{ route('jobs', $order->service->slug) }}" class="text-decoration-none d-flex align-items-start w-100 justify-content-start text-dark">
                            <div class="rounded" style="height: 80px; width: 80px; overflow: hidden;">
                                @foreach (explode(',', $order->service->image) as $key => $value)
                                    @if ($key === 0)
                                        <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @endif
                                @endforeach
                            </div>
                            <div class="ms-3 d-flex flex-column justify-content-center align-items-start" style="flex-grow: 1;">
                                <p class="mb-1">{{  Str::limit($order->service->title, 50) }}</p>
                                <div class="d-flex align-items-center justify-content-start" style="column-gap: 5px;">
                                    <span class="badge rounded-1 text-muted border px-2">{{ 'RM' . $order->service->price }}</span>
                                    <span class="badge rounded-1 text-muted border px-2">{{ $order->service->category }}</span>
                                </div>
                                <div class="mt-2 w-100 text-md-end text-start">
                                    @if (Route::currentRouteName() == 'employer.applicant')
                                        <span class="badge bg-warning px-2 fw-normal" style="font-size: 13px; padding-bottom: 5px;">{{ $order->status }}</span>
                                    @elseif (Route::currentRouteName() == 'employer.applicant-approved')
                                        <span class="badge bg-success px-2 fw-normal" style="font-size: 13px; padding-bottom: 5px;">{{ $order->status }}</span>
                                    @elseif (Route::currentRouteName() == 'employer.applicant-rejected')
                                        <span class="badge bg-danger px-2 fw-normal" style="font-size: 13px; padding-bottom: 5px;">{{ $order->status }}</span>
                                    @elseif (Route::currentRouteName() == 'employer.applicant-completed')
                                        <span class="badge bg-dark px-2 fw-normal" style="font-size: 13px; padding-bottom: 5px;">{{ $order->status }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between w-100 p-3">
                        <div class="d-flex justify-content-start align-items-center flex-row">
                            <a href="{{ route('users', strtolower($order->user->name)) }}" class="rounded-circle text-decoration-none" style="height: 50px; width: 50px; overflow: hidden;">
                                <img src="{{ asset('images/' . $order->user->image) }}" class="w-100 h-100" style="object-fit: cover;">
                            </a>
                            <div class="ms-3 d-flex align-items-center justify-content-center">
                                <a href="{{ route('users', strtolower($order->user->name)) }}" class="text-decoration-none mb-0 text-dark fw-bold" style="font-size: 14px;">{{ $order->user->name }}</a>
                            </div>
                        </div>
                        <a href="" class="btn px-3 border border-secondary">
                            <i class="fa-solid fa-message py-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection