<div class="sidebar shadow-sm d-md-block d-none">
    <a href="{{ route('home') }}" class="text-decoration-none sidebar-logo py-4 border-bottom d-flex align-items-center justify-content-center">
        <img src="{{ asset('brand/jobshort.png') }}" style="width: 82px;">
    </a>
    <span class="material-symbols-outlined rounded-circle border" id="btn_open_close">arrow_right</span>
    <a href="{{ route('employer.profile') }}" id="side-profile" class="text-decoration-none profile d-flex align-items-center justify-content-start border-bottom px-4 py-3 position-relative">
        <div class="d-flex align-items-center justify-content-start flex-row">
            <div class="rounded-circle shadow-sm border border-3 border-light" style="height: 50px; width: 50px; overflow: hidden;">
                <img src="{{ is_null(auth()->user()->freelancer->image) ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' : asset('images/' . auth()->user()->freelancer->image) }}" class="w-100 h-100" style="object-fit: cover;">
            </div>
            <div class="mt-1 ms-3">
                <h6 class="text-dark mb-0">{{ auth()->user()->freelancer->name }}</h6>
            </div>
        </div>
        <span class="material-symbols-outlined" id="profile-icon">arrow_forward_ios</span>
    </a>
    <div class="link-list">
        <ul class="navbar-nav">
            <li class="dropdown-item">
                <a href="{{ route('employer.main') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() === 'employer.main' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined">space_dashboard</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0">Dashboard</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.jobs') }}" class="text-decoration-none d-flex row mx-0 {{ Request::is('account/freelancer/services*') ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined">work</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0">My Services</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.create-service') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.create-service' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined">add</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0">Add Service</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.applicant') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.applicant' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined">clinical_notes</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0">Orders</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.notification') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.notification' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined">notifications</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0">Notification</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.profile') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.profile' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined">account_circle</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0">Profile</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="" class="text-decoration-none d-flex row mx-0">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined">logout</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0">Logout</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</div>