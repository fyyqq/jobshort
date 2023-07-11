@extends('layouts.app')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />

@section('content')

    <div class="container-lg">
        <div class="row">
            <div class="col-md-3 left">
                <div class="py-3 mb-md-0 mb-2 rounded border" style="background-color: #fff;">
                    <ul class="navbar-nav px-3 flex-md-column flex-row gap-md-0 gap-4">
                        <a href="" class="text-decoration-none d-flex align-items-center justify-content-start gap-md-3 gap-0">
                            <i class="mdi mdi-inbox text-dark"></i>
                            <li class="nav-item py-2 border-bottom w-100 d-md-block d-none text-dark fw-bold" style="font-size: 13.5px;">Inbox</li>
                        </a>
                        <span class="d-flex align-items-center justify-content-start gap-md-3 gap-0" id="read-link" style="cursor: pointer;">
                            <i class="mdi mdi-email text-dark"></i>
                            <li class="nav-item py-2 border-bottom w-100 d-md-block d-none text-muted" style="font-size: 13.5px;">Read</li>
                        </span>
                        <a href="" class="text-decoration-none d-flex align-items-center justify-content-start gap-md-3 gap-0">
                            <i class="mdi mdi-email-open text-dark"></i>
                            <li class="nav-item py-2 d-md-block d-none text-muted" style="font-size: 13.5px;">Unread</li>
                        </a>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 right">
                <div class="box border shadow-sm rounded bg-white mb-3">
                    <div class="box-title border-bottom p-3">
                        <h6 class="m-0">Recent</h6>
                    </div>
                    <div class="box-body p-0" id="display-notification">
                        @foreach ($notifications as $index => $notification)
                            <?php 
                                $message = json_decode($notification->data)->message;
                                $user = json_decode($notification->data)->user;
                                $image = json_decode($notification->data)->image;
                                $id = json_decode($notification->data)->id;
                            ?>
                            <div class="p-3 d-flex align-items-center justify-content-between border-bottom parent-notification" style="cursor: pointer; {{ $notification->read_at != null ? 'border: unset;' : 'border-left: 3px solid #2891e1;' }} " data-bs-toggle="modal" data-bs-target="#{{ $index }}">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="dropdown-list-image mx-2">
                                        @if ($user === 'admin')
                                            <img class="rounded-circle border" src="{{ asset('brand/js-logo.jpg') }}" style="object-fit: cover;">
                                        @else
                                            <img class="rounded-circle border" src="{{ $image !== null ? asset('images/' . $image) : asset('brand/unknown.png') }}" style="object-fit: cover;">
                                        @endif
                                    </div>
                                    <div class="font-weight-bold mx-3">
                                        <small class="text-dark fw-bold d-block mb-0">{{ $user === 'admin' ? 'Jobshort ' . $user : $user }}</small>
                                        <small class="text-muted fw-normal" style="font-size: 12.5px;">{{ Str::limit($message, 100) }}</small>
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
                            <div class="modal fade" id="{{ $index }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $user }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ...
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection