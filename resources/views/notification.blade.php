@extends('layouts.app')


@section('content')

    <div class="container-lg">
        <div class="row mx-0">
            <div class="col-md-3 col-12 px-md-3 px-0 mb-md-0 mb-3">
                <div class="d-flex align-items-center justify-content-center flex-md-column flex-row" style="">
                    <div class="py-2 ps-3 w-100 border-bottom bg-primary text-light">All</div>
                    <div class="py-2 ps-3 w-100 border-bottom">Following</div>
                    <div class="py-2 ps-3 w-100 border-bottom">Archive</div>
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="pb-4 pt-2 px-3 border-bottom">
                    <h1 class="h5 mb-1 text-dark">Notification</h1>
                    <small class="text-muted">{{ count($notifications) }} Notification</small>
                </div>
                <div class="mt-2 {{ count($notifications) < 1 ? 'd-flex align-items-center justify-content-center' : '' }}" style="{{ count($notifications) < 1 ? 'height: 70vh; overflow-y: scroll;' : 'height: max-content;' }}">
                    @forelse ($notifications as $notification)
                    <small class="text-danger">{{ $notification }}</small>
                        <?php 
                            $message = json_decode($notification->data)->message;
                            $user = json_decode($notification->data)->user;
                            $image = json_decode($notification->data)->image;
                        ?>
                        <div class="py-2 pe-3 d-flex align-items-center justify-content-between border mb-2 position-relative" style="">
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded-circle mx-4" style="height: 42px; width: 42px; overflow: hidden;">
                                    @if ($user === 'admin')
                                        <img src="{{ asset('brand/js-logo.jpg') }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <img src="{{ asset('images/' . $image) }}" class="w-100 h-100" style="object-fit: cover;">
                                    @endif
                                </div>
                                <div class="d-flex align-items-start justify-content-center flex-column pe-3">
                                    <small class="text-dark fw-bold">{{ $user }}</small>
                                    <small class="text-muted" style="font-size: 13px">{{ Str::limit($message, 90) }}</small>
                                    <small class="text-muted mt-1" style="font-size: 11px;">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="dropdown p-1">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" style="height: 42px; width: 42px; cursor: pointer;">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                    <ul class="dropdown-menu p-0 rounded-0" style="background-color: #fff;">
                                        <li class="notification-read">
                                            <a class="row mx-0 dropdown-item py-2" style="font-size: 13px;">
                                                <i class="p-0 col-1 fa-solid fa-eye-slash" style="font-size: 12.5px;"></i>
                                                <p class="col-11 mb-0 d-inline-block text-muted">Read</p>
                                            </a>
                                        </li>
                                        <input type="hidden" name="" value="{{ $notification->id }}" id="notification-id">
                                        <li class="notification-delete">
                                            <a class="row mx-0 dropdown-item py-2" style="font-size: 13px;">
                                                <i class="p-0 col-1 fa-solid fa-trash" style="transform: translateX(1px);"></i>
                                                <p class="col-11 mb-0 d-inline-block text-muted">Delete</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h1 class="h4 text-dark">No Notification.</h1>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
@endsection