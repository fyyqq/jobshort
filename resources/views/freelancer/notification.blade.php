@extends('freelancer.layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />

@section('content')
    <div class="container-employer pt-md-4 pt-3 px-lg-4 px-2">
        <div class="content">
            <div class="border rounded py-md-4 py-3 px-md-4 px-3 d-flex align-items-center justify-content-start gap-3" style="background-color: #fff;">
                <div class="py-1 px-2" style="cursor: pointer;" onclick="return goToPreviousPage()">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <h1 class="h4 text-dark mb-0 d-md-block d-none" style="font-size: 20px;">Notification</h1>
                <h1 class="h4 text-dark mb-0 d-md-none d-block" style="font-size: 17px;">Notification</h1>
            </div>
            <div class="mt-2">
                <div class="box border shadow-sm rounded bg-white mb-3">
                    <div class="d-flex align-items-center justify-content-between px-2 border-bottom">
                        <span class="d-flex align-items-center justify-content-start lh-1 w-100">
                            <div class="box-title py-3 px-md-4 px-3 {{ Route::currentRouteName() === 'freelancer.notification' ? 'border-bottom border-2 border-primary' : '' }}">
                                <h6 class="m-0" id="order-menu-link">Inbox</h6>
                            </div>
                            <div class="dropdown box-title py-3 ps-md-4 pe-md-3 ps-3 pe-2 d-flex align-items-center justify-content-center gap-1" data-bs-toggle="dropdown" style="cursor: pointer;">
                                <h6 class="m-0" id="order-menu-link">Orders</h6>
                                <i class="mdi mdi-menu-down"></i>
                                <div class="dropdown-menu dropdown-menu-left py-0">
                                    <button class="dropdown-item py-3" type="button">
                                        <small class="text-dark" style="font-size: 12.5px;">Approved</small>
                                    </button>
                                    <button class="dropdown-item py-3" type="button">
                                        <small class="text-dark" style="font-size: 12.5px;">Completed</small>
                                    </button>
                                </div>
                            </div>
                            <div class="box-title py-3 px-md-4 px-3">
                                <h6 class="m-0" id="order-menu-link">Review</h6>
                            </div>
                        </span>
                        <span class="d-flex align-items-center justify-content-end">
                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-light btn-sm rounded" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right py-0">
                                    <button class="dropdown-item py-2" type="button">
                                        <i class="me-2 mdi mdi-email-open"></i>
                                        <small class="text-muted" style="font-size: 12.5px;">Read</small>
                                    </button>
                                    <button class="dropdown-item py-2" type="button">
                                        <i class="me-2 mdi mdi-email"></i>
                                        <small class="text-muted" style="font-size: 12.5px;">Unread</small>
                                    </button>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="box-body p-0">
                        @foreach ($notifications as $notification)
                            <?php 
                                $message = json_decode($notification->data)->message;
                                $user = json_decode($notification->data)->user;
                                $image = json_decode($notification->data)->image;
                                $id = json_decode($notification->data)->id;
                            ?>
                            <div class="p-3 d-flex align-items-center justify-content-between border-bottom parent-notification" style="{{ $notification->read_at != null ? 'border: unset;' : 'border-left: 3px solid #2891e1;' }} ">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="dropdown-list-image mx-2">
                                        @if ($user === 'admin')
                                            <img class="rounded-circle border" src="{{ asset('brand/js-logo.jpg') }}" style="object-fit: cover; width: 45px; height: 45px;">
                                        @else
                                            <img class="rounded-circle border" src="{{ $image != null ? asset('images/' . $image) : asset('brand/unknown.png') }}" style="object-fit: cover; width: 45px; height: 45px;">
                                        @endif
                                    </div>
                                    <div class="font-weight-bold mx-3">
                                        <small class="text-dark fw-bold d-block mb-0" id="notification-username">{{ $user === 'admin' ? 'Jobshort ' . $user : $user }}</small>
                                        <small class="text-muted fw-normal d-sm-block d-none" style="font-size: 12.5px;">{{ Str::limit($message, 100) }}</small>
                                        <small class="text-muted fw-normal d-sm-none d-block" style="font-size: 12px;">{{ Str::limit($message, 50) }}</small>
                                    </div>
                                </div>
                                <span class="ml-auto mb-0 d-md-flex d-none align-items-center gap-1">
                                    <input type="hidden" id="notification-id" value="{{ $id }}">
                                    <button type="button" class="btn btn-light btn-sm rounded unread {{ $notification->read_at != null ? 'd-block' : 'd-none' }}" data-bs-toggle="tooltip" title="Mark as unread">
                                        <i class="mdi mdi-email"></i>
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm rounded read {{ $notification->read_at != null ? 'd-none' : 'd-block' }}" data-bs-toggle="tooltip" title="Mark as read">
                                        <i class="mdi mdi-email-open"></i>
                                    </button>
                                    <button class="btn btn-light btn-sm rounded notification-delete" data-bs-toggle="tooltip" title="Delete">
                                        <i class="mdi mdi-delete"></i>
                                    </button>
                                </span>
                                <span class="ml-auto mb-0 d-md-none d-block">
                                    <div class="btn-group dropdown">
                                        <button type="button" class="btn btn-light btn-sm rounded" data-bs-toggle="dropdown">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right py-0">
                                            <input type="hidden" id="notification-id" value="{{ $id }}">
                                            <button class="dropdown-item py-2 unread {{ $notification->read_at != null ? 'd-block' : 'd-none' }}" type="button">
                                                <i class="me-2 mdi mdi-email"></i>
                                                <small class="text-muted" style="font-size: 12.5px;">Mark as Unread</small>
                                            </button>
                                            <button class="dropdown-item py-2 read {{ $notification->read_at != null ? 'd-none' : 'd-block' }}" type="button">
                                                <i class="me-2 mdi mdi-email-open"></i>
                                                <small class="text-muted" style="font-size: 12.5px;">Mark as Read</small>
                                            </button>
                                            <button class="dropdown-item py-2 notification-delete">
                                                <i class="me-2 mdi mdi-delete" style="font-size: 18px;"></i>
                                                <small class="text-muted">Delete</small>
                                            </button>
                                        </div>
                                    </div>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection