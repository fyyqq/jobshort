<div class="sidebar px-xl-4 px-3 pb-md-3 pb-0 border">
    <div class="py-xl-3 py-3 w-100 border-bottom d-flex align-items-start justify-content-start">
        <div class="profile-picture rounded-circle" style="height: 70px; width: 70px;">
            <img src="{{ (auth()->user()->image != null) ? asset('images/' . auth()->user()->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' }}" class="w-100 h-100" style="object-fit: cover;">
        </div>
        <div class="profile-info pt-xl-2 pt-3 ps-xl-3 ps-2">
            <div class="d-flex align-items-center justify-content-start">
                <p class="mb-0 name fw-bold me-1">{{ auth()->user()->name }}</p>
                <img src="{{ asset('brand/verify.png') }}" style="width: 17px;">
            </div>
            <small class="text-muted email">{{ is_null(auth()->user()->username) ? '@unknown' : '@' . auth()->user()->username }}</small>
            <a href="{{ route('profile.main') }}">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
        </div>
    </div>
    <ul class="list-group list-group-flush mt-xl-2 mt-0 d-md-flex d-none">
        <li class="list-group-item">
            <div class="row mx-0">
                <div class="col-1 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-user" style="font-size: 13px; transform:translateX(1px);"></i>
                </div>
                <div class="col-10">
                    <a href="{{ route('profile.main') }}" class="text-dark profile-dropdown">My Profile</a>
                </div>
                <div class="ms-4" id="profile-dropdown-menu">   
                    <div class="d-flex align-items-start justify-content-start flex-column" style="row-gap: 5px;">
                        <a href="{{ route('profile.main') }}" class="{{ Route::currentRouteName() === 'profile.main' ? 'text-primary' : 'text-muted' }}" style="font-size: 13px;">Profile</a>
                        <a href="{{ route('profile.address') }}" class="{{ Route::currentRouteName() === 'profile.address' ? 'text-primary' : 'text-muted' }}" style="font-size: 13px;">Address</a>
                    </div>
                </div>
            </div>
        </li>
        @if (auth()->user()->roles != '2')
            <li class="list-group-item pt-2">
                <div class="row mx-0">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-check" style="font-size: 13px; transform:translateX(3px);"></i>
                    </div>
                    <div class="col-10">
                        <a href="{{ route('employer.registration-personal') }}" class="">Being a Freelancer</a>
                    </div>
                </div>
            </li>
        @elseif (auth()->user()->roles == '2')
            <li class="list-group-item">
                <div class="row mx-0">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-user-check" style="font-size: 13px; transform: translateX(2px);"></i>
                    </div>
                    <div class="col-10">
                        <a href="{{ route('employer.main') }}" class="">Freelancer</a>
                    </div>
                </div>
            </li>
        @endif
        {{-- <li class="list-group-item">
            <div class="row mx-0">
                <div class="col-1 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-bell" style="font-size: 13px;"></i>
                </div>
                <div class="col-10">
                    <a href="{{ route('profile.notification-all') }}" class="{{ Route::currentRouteName() === 'profile.notification-all' ? 'text-primary' : '' }}">Notification</a>
                </div>
            </div>
        </li> --}}
        {{-- @if (auth()->user()->roles != 0) --}}
            <li class="list-group-item">
                <div class="row mx-0">
                    <div class="col-1 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-briefcase" style="font-size: 13px;"></i>
                    </div>
                    <div class="col-10">
                        <a href="{{ route('profile.applied') }}" class="{{ Route::currentRouteName() === 'profile.applied' ? 'text-primary' : '' }}">Orders</a>
                    </div>
                </div>
            </li>
        {{-- @endif --}}
        <li class="list-group-item">
            <div class="row mx-0">
                <div class="col-1 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-heart text-dark" style="font-size: 13px;"></i>
                </div>
                <div class="col-10">
                    <a href="{{ route('profile.saved-jobs') }}" class="{{ Route::currentRouteName() === 'profile.saved-jobs' ? 'text-primary' : '' }}">Wishlist</a>
                </div>
            </div>
        </li>
        <li class="list-group-item">
            <div class="row mx-0">
                <div class="col-1 d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-gear" style="font-size: 13px;"></i>
                </div>
                <div class="col-10">
                    <a href="" class="">Settings</a>
                </div>
            </div>
        </li>
    </ul>
</div>