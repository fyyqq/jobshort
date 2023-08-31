<div class="sidebar px-lg-2 px-md-0 px-3" style="height: max-content;">
    <div class="py-xl-3 px-md-3 px-2 pt-3 pb-4 w-100 border-bottom d-flex align-items-center justify-content-start gap-3 position-relative">
        <div class="border rounded-3" style="height: 45px; width: 45px; overflow: hidden;">
            <img src="{{ (auth()->user()->image != null) ? asset('images/' . auth()->user()->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="">
                <p class="mb-0 me-1 lh-sm" style="font-size: 13px;">{{ auth()->user()->name }}</p>
                <small class="text-muted" style="font-size: 11.5px;">{{ auth()->user()->email }}</small>
            </div>
        </div>
        <div class="d-md-none d-block position-absolute" style="right: 10px; cursor: pointer;">
            <i class="mdi mdi-logout" data-bs-target="tooltip" title="Logout" onclick="event.preventDefault(); return logout()"></i>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
    <ul class="mt-md-0 my-md-0 my-2 navbar-nav justify-content-center align-items-center flex-md-column flex-row w-100 py-2" style="column-gap: 10px;">
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
        <?php
            $countPendingOrders = count(auth()->user()->order->where('status', 'pending'));
        ?>
        <li class="nav-item w-100">
            <a href="{{ route('profile.order') }}" class="{{ Route::is('profile.order*') ? 'text-dark' : 'text-muted' }} ps-md-4 ps-0 py-md-3 py-md-2 py-3 text-decoration-none d-flex align-items-center justify-content-center position-relative" id="sidebar-link" data-bs-toggle="tooltip" title="orders">
                @if (Auth::check() && $countPendingOrders > 0)
                    <span class="badge fw-normal d-md-none d-flex align-items-center justify-content-center bg-primary rounded-circle position-absolute m-0 p-0" style="top: 3px; right: 3px; height: 14.5px; width: 14.5px; font-size: 9.5px;">{{ $countPendingOrders }}</span>
                @endif
                <div class="col-md-2 col-none">
                    <i class="fa-solid fa-briefcase" id="sidebar-icon"></i>
                </div>
                <div class="col-md-9 d-md-flex d-none">
                    <small class="position-relative" style="font-size: 13.5px;">Orders 
                        @if (Auth::check() && $countPendingOrders > 0)
                            <span class="badge fw-normal d-md-flex d-none align-items-center justify-content-center bg-primary rounded-circle position-absolute m-0 p-0" style="top: -5px; right: -25px; height: 14.5px; width: 14.5px; font-size: 9.5px;">{{ $countPendingOrders }}</span>
                        @endif
                    </small>
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
