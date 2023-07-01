<div class="sidebar pb-md-3 pb-0 pt-2 px-lg-2 px-md-0 px-3" style="height: max-content;">
    <div class="row mx-0 py-xl-3 pt-3 pb-4 w-100 position-relative border-bottom">
        <div class="text-end position-absolute top-0 p-1">
            <a href="{{ route('profile.main') }}" class="text-muted">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
        </div>
        <div class="col-md-2 col-1">
            <div class="profile-picture rounded-circle" style="height: 45px; width: 45px; overflow: hidden;">
                <img src="{{ (auth()->user()->image != null) ? asset('images/' . auth()->user()->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' }}" class="w-100 h-100" style="object-fit: cover;">
            </div>
        </div>
        <div class="col-md-10 col-11 ps-xl-2 ps-3 profile-info d-flex align-items-center justify-content-start">
            <div class="ms-md-3 ms-sm-2 ms-4">
                <p class="mb-0 fw-bold me-1" style="font-size: 14px;">{{ auth()->user()->name }}</p>
                <small class="text-muted" style="font-size: 12px;">{{ auth()->user()->email }}</small>
            </div>
        </div>
    </div>
    <ul class="navbar-nav justify-content-center align-items-center flex-md-column flex-row w-100 gap-md-0 gap-sm-4 gap-2 my-md-0 my-4 px-md-4 px-0">
        <li class="nav-item w-100">
            <a href="{{ route('profile.main') }}" class="{{ Route::currentRouteName() === 'profile.main' ? 'text-primary' : 'text-muted' }} text-muted px-md-3 px-4 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="profile">
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-user" id="sidebar-icon"></i>
                </div>
                <div class="col-md-10 d-md-flex d-none">
                    <small class="" style="font-size: 13.5px;">Profile</small>
                </div>
            </a>
        </li>
        <li class="nav-item w-100">
            <a href="{{ route('employer.main') }}" class="{{ Route::currentRouteName() === 'employer.main' ? 'text-primary' : 'text-muted' }} px-md-3 px-4 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="freelancer">
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-user-check" id="sidebar-icon"></i>
                </div>
                <div class="col-md-10 d-md-flex d-none">
                    <small class="" style="font-size: 13.5px;">Freelancer</small>
                </div>
            </a>
        </li>
        <li class="nav-item w-100">
            <a href="{{ route('profile.applied') }}" class="{{ Route::currentRouteName() === 'profile.applied' ? 'text-primary' : 'text-muted' }} px-md-3 px-4 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="orders">
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-briefcase" id="sidebar-icon"></i>
                </div>
                <div class="col-md-10 d-md-flex d-none">
                    <small class="" style="font-size: 13.5px;">Orders</small>
                </div>
            </a>
        </li>
        <li class="nav-item w-100">
            <a href="{{ route('profile.saved-jobs') }}" class="{{ Route::currentRouteName() === 'profile.saved-jobs' ? 'text-primary' : 'text-muted' }} px-md-3 px-4 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="wishlist">
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-heart text-muted" id="sidebar-icon"></i>
                </div>
                <div class="col-md-10 d-md-flex d-none">
                    <small class="" style="font-size: 13.5px;">Wishlist</small>
                </div>
            </a>
        </li>
    </ul>
</div>
