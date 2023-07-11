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
@endforeach