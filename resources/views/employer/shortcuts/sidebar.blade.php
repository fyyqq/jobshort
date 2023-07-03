<div class="sidebar shadow-sm d-md-block d-none">
    <a href="{{ route('home') }}" class="text-decoration-none sidebar-logo py-4 border-bottom d-flex align-items-center justify-content-center position-relative">
        <img src="{{ asset('brand/jobshort.png') }}" style="width: 82px;">
        <span class="material-symbols-outlined rounded-circle border" id="btn_open_close">arrow_right</span>
    </a>
    <a href="{{ route('employer.profile') }}" id="side-profile" class="text-decoration-none profile d-flex align-items-center justify-content-start border-bottom px-4 py-3 position-relative">
        <div class="d-flex align-items-center justify-content-start flex-row">
            <div class="rounded shadow-sm border border-3 border-light" style="height: 50px; width: 50px; overflow: hidden;">
                <img src="{{ is_null(auth()->user()->freelancer->image) ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' : asset('images/' . auth()->user()->freelancer->image) }}" class="w-100 h-100" style="object-fit: cover;">
            </div>
            <div class="mt-1 pb-1 ms-3 d-flex flex-column justify-content-center">
                <p class="text-dark mb-0 lh-sm" style="font-size: 15px;">{{ auth()->user()->freelancer->name }}</p>
                <small class="text-muted" style="font-size: 12.5px">designer</small>
            </div>
        </div>
    </a>
    <div class="link-list">
        <ul class="navbar-nav">
            <li class="dropdown-item">
                <a href="{{ route('employer.main') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() === 'employer.main' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined" style="font-size: 21px;">space_dashboard</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0" style="font-size: 14.5px;">Dashboard</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.jobs') }}" class="text-decoration-none d-flex row mx-0 {{ Request::is('account/freelancer/services*') ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined" style="font-size: 21px;">work</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0" style="font-size: 14.5px;">My Service</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.create-service') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.create-service' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined" style="font-size: 21px;">add</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0" style="font-size: 14.5px;">Add Service</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.applicant') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.applicant' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined" style="font-size: 21px;">clinical_notes</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0" style="font-size: 14.5px;">Orders</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.notification') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.notification' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined" style="font-size: 21px;">notifications</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0" style="font-size: 14.5px;">Notification</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item">
                <a href="{{ route('employer.profile') }}" class="text-decoration-none d-flex row mx-0 {{ Route::currentRouteName() == 'employer.profile' ? 'active' : '' }}">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined" style="font-size: 21px;">account_circle</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0" style="font-size: 14.5px;">Profile</p>
                    </div>
                </a>
            </li>
            <li class="dropdown-item border-top w-100 position-absolute bottom-0">
                <a href="{{ route('profile.main') }}" class="text-decoration-none d-flex align-items-center row mx-0">
                    <div class="col-4 d-flex justify-content-end align-items-center">
                        <span class="material-symbols-outlined fs-6">arrow_back_ios_new</span>
                    </div>
                    <div class="col-8 d-flex justify-content-start align-items-center">
                        <p class="mb-0" style="font-size: 14.5px;">Main</p>
                    </div>
                </a>
            </li>
         </ul>
    </div>
</div>