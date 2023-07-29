<div class="sidebar px-lg-2 px-md-0 px-3" style="height: max-content;">
    <div class="row mx-0 py-xl-3 pt-3 pb-4 w-100 border-bottom">
        <div class="col-md-2 col-1">
            <div class="profile-picture border rounded-3" style="height: 45px; width: 45px; overflow: hidden;">
                <img src="{{ (auth()->user()->image != null) ? asset('images/' . auth()->user()->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
            </div>
        </div>
        <div class="col-md-10 col-11 ps-xl-2 ps-3 profile-info d-flex align-items-center justify-content-start">
            <div class="ms-md-3 ms-sm-2 ms-4">
                <p class="mb-0 me-1 lh-sm" style="font-size: 13px;">{{ auth()->user()->name }}</p>
                <small class="text-muted" style="font-size: 11.5px;">{{ auth()->user()->email }}</small>
            </div>
        </div>
    </div>
    <ul class="mt-md-0 mt-2 navbar-nav justify-content-center align-items-center flex-md-column flex-row w-100 py-2" style="column-gap: 10px;">
        <li class="nav-item w-100">
            <a href="{{ route('profile.main') }}" class="{{ Route::is('profile.main') ? 'text-dark' : 'text-muted' }} ps-md-4 ps-0 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="profile">
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-user" id="sidebar-icon"></i>
                </div>
                <div class="col-md-9 d-md-flex d-none">
                    <small class="" style="font-size: 13.5px;">Profile</small>
                </div>
            </a>
        </li>
        @if (auth()->user()->roles != '2')
            <li class="nav-item w-100">
                <a href="{{ route('freelancer.registration') }}" class="{{ Route::is('freelancer.registration') ? 'text-dark' : 'text-muted' }} ps-md-4 ps-0 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="freelancer">
                    <div class="col-md-2 col-none">
                        <i class="fa-solid fa-user-check" id="sidebar-icon"></i>
                    </div>
                    <div class="col-md-9 d-md-flex d-none">
                        <small class="" style="font-size: 13.5px;">Freelancer Registration</small>
                    </div>
                </a>
            </li>
        @else
            <li class="nav-item w-100">
                <a href="{{ route('freelancer.main') }}" class="{{ Route::is('freelancer.main') ? 'text-dark' : 'text-muted' }} ps-md-4 ps-0 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="freelancer">
                    <div class="col-md-2 col-none">
                        <i class="fa-solid fa-user-check" id="sidebar-icon"></i>
                    </div>
                    <div class="col-md-9 d-md-flex d-none">
                        <small class="" style="font-size: 13.5px;">Freelancer</small>
                    </div>
                </a>
            </li>
        @endif
        <li class="nav-item w-100">
            <a href="{{ route('profile.order') }}" class="{{ Route::is('profile.order*') ? 'text-dark' : 'text-muted' }} ps-md-4 ps-0 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="orders">
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-briefcase" id="sidebar-icon"></i>
                </div>
                <div class="col-md-9 d-md-flex d-none">
                    <small class="" style="font-size: 13.5px;">Orders</small>
                </div>
            </a>
        </li>
        <li class="nav-item w-100">
            <a href="{{ route('profile.saved-services') }}" class="{{ Route::is('profile.saved-services') ? 'text-dark' : 'text-muted' }} ps-md-4 ps-0 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center" id="sidebar-link" data-bs-toggle="tooltip" title="wishlist">
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-heart text-muted" id="sidebar-icon"></i>
                </div>
                <div class="col-md-9 d-md-flex d-none">
                    <small class="" style="font-size: 13.5px;">Wishlist</small>
                </div>
            </a>
        </li>
    </ul>
</div>
