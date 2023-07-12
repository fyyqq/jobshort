@foreach ($notifications as $index => $notification)
    <?php 
        // $title = json_decode($notification->data)->title;
        $message = json_decode($notification->data)->message;
        $user = json_decode($notification->data)->user;
        $image = json_decode($notification->data)->image;
        $id = json_decode($notification->data)->id;
    ?>
    <div class="pe-4 d-flex align-items-center justify-content-between border-bottom parent-notification" style="cursor: pointer; {{ $notification->read_at != null ? 'border: unset;' : 'border-left: 3px solid #2891e1;' }} ">
        <div class="p-3 d-flex align-items-center justify-content-start w-100" data-bs-toggle="modal" data-bs-target="{{ '#abc' . $index }}">
            <div class="dropdown-list-image mx-2">
                @if ($user === 'admin')
                    <img class="rounded-circle border" src="{{ asset('brand/js-logo.jpg') }}" style="object-fit: cover;">
                @else
                    <img class="rounded-circle border" src="{{ $image !== null ? asset('images/' . $image) : asset('brand/unknown.png') }}" style="object-fit: cover;">
                @endif
            </div>
            <div class="font-weight-bold mx-3">
                <small class="text-dark fw-bold d-block mb-0">{{ $user === 'admin' ? 'Jobshort ' . $user : $user }}</small>
                <small class="text-muted fw-normal" style="font-size: 12.5px;">{{ Str::limit($message, 90) }}</small>
                {{-- <small class="text-muted fw-normal" style="font-size: 12.5px;">{{ Str::limit($title, 90) }}</small> --}}
            </div>
        </div>
        <span class="ml-auto mb-0 d-md-flex d-none align-items-center gap-2">
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
    <div class="modal fade" id="{{ 'abc' . $index }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content pb-3">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">Notification</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="pt-2 pb-3 px-3 d-flex align-items-center justify-content-start gap-3 border-bottom">
                        <div class="rounded-circle border" style="height: 50px; width: 50px; overflow: hidden;">
                            @if ($user === 'admin')
                                <img class="w-100 h-100" src="{{ asset('brand/js-logo.jpg') }}" style="object-fit: cover;">
                            @else
                                <img class="w-100 h-100" src="{{ $image !== null ? asset('images/' . $image) : asset('brand/unknown.png') }}" style="object-fit: cover;">
                            @endif
                        </div>
                        <div class="d-flex align-items-start justify-content-center flex-column">
                            <small class="text-dark lh-sm">{{ $user === 'admin' ? 'Jobshort ' . $user : $user }}</small>
                            <small class="text-muted" style="font-size: 12px;">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="mt-3 mb-2 row mx-0">
                        <small class="text-dark d-block lh-lg fw-bold">Title :</small>
                        {{-- <small class="text-dark">{{ $title != null ? $title : '' }}</small> --}}
                    </div>
                    <div class="row mx-0">
                        <small class="text-dark d-block lh-lg fw-bold">Message :</small>
                        <small class="text-dark" style="font-size: 13.5px;">{{ $message }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach