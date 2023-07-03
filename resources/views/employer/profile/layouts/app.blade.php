@extends('employer.layouts.app')

@section('content')
    <div class="container-employer pt-4 px-4">
        <div class="content pb-4">
            <div class="border rounded py-4 px-4" style="background-color: #fff;">
                <h1 class="h4 text-dark mb-0 d-md-block d-none" style="font-size: 20px;">Services</h1>
                <h1 class="h4 text-dark mb-0 d-md-none d-block" style="font-size: 17px;">Services</h1>
            </div>
            <div class="mt-2 border pb-3" style="background-color: #fff;">
                {{-- <div class="d-flex align-items-center justify-content-start border-bottom px-2">
                    <a href="{{ route('employer.profile') }}" class="text-decoration-none {{ Route::currentRouteName() === 'employer.profile' ? 'border-bottom border-3 border-primary' : '' }} px-md-4 px-3 py-3 profile-employer-btn" style="cursor: pointer;">
                        <small class="text-dark d-block">Personal</small>
                    </a>
                    <a href="{{ route('employer.profile-address') }}" class="text-decoration-none {{ Route::currentRouteName() === 'employer.profile-address' ? 'border-bottom border-3 border-primary' : '' }} px-md-4 px-3 py-3 profile-employer-btn" style="cursor: pointer;">
                        <small class="text-dark d-block">Address</small>
                    </a>
                    <a href="" class="text-decoration-none px-md-4 px-3 py-3 profile-employer-btn" style="cursor: pointer;">
                        <small class="text-dark d-block">Account</small>
                    </a>
                </div> --}}
                <ul class="navbar-nav px-md-3 px-2 border-bottom shadow-sm" id="parent-order-menu">
                    <div class="d-flex align-items-center justify-content-start">
                        <li class="position-relative {{ Route::currentRouteName() === 'employer.profile' ? 'border-bottom border-2 border-primary' : '' }}">
                            <a href="{{ route('employer.profile') }}" class="btn p-3 rounded-0" id="order-menu-link">Personal</a>
                            <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                        </li>
                        <li class="position-relative {{ Route::currentRouteName() === 'employer.profile-address' ? 'border-bottom border-2 border-primary' : '' }}">
                            <a href="{{ route('employer.profile-address') }}" class="btn p-3 rounded-0" id="order-menu-link">Address</a>
                            <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                        </li>
                        <li class="position-relative">
                            <a href="" class="btn p-3 rounded-0" id="order-menu-link">Account</a>
                            <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                        </li>
                    </div>
                </ul>
                <div class="px-3">
                    @if (Route::currentRouteName() === 'employer.profile')
                        <form action="{{ route('freelancer.profile-update', auth()->user()->freelancer->user_id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    @elseif (Route::currentRouteName() === 'freelancer.profile-address')
                        <form action="{{ route('employer.address-update', auth()->user()->freelancer->user_id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                    @endif
                        <div class="form-profile mt-5 px-3 d-flex align-items-start justify-content-start flex-md-row flex-column-reverse">
                            @yield('pages')
                        </div>
                        <div class="w-100 text-end mt-4 px-3">
                            <button type="submit" class="btn btn-sm px-3 text-light py-2" style="background-color: #2891e1;">Submit Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection