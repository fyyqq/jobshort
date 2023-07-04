@extends('profile.layouts.app')

@section('profile')
    <header class="pb-4">
        <div class="box-title border p-3" style="border-top-right-radius: 10px; border-top-left-radius: 10px;">
            <h6 class="m-0">Orders</h6>
        </div>
        <div class="border my-2" id="parent-order-menu-link">
            <ul class="navbar-nav px-3">
                <div class="d-flex align-items-center justify-content-start">
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied') }}" class="btn p-sm-3 p-3 rounded-0" id="order-menu-link">Pending</a>
                        {{-- <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'pending')) }}</span> --}}
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied-approved' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied-approved') }}" class="btn p-sm-3 p-3 rounded-0" id="order-menu-link">Approved</a>
                        {{-- <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'approved')) }}</span> --}}
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied-rejected' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied-rejected') }}" class="btn p-sm-3 p-3 rounded-0" id="order-menu-link">Rejected</a>
                        {{-- <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'rejected')) }}</span> --}}
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied-completed' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied-completed') }}" class="btn p-sm-3 p-3 rounded-0" id="order-menu-link">Completed</a>
                        {{-- <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'completed')) }}</span> --}}
                    </li>
                </div>
            </ul>
        </div>
        <div class="">
            @yield('pages')
        </div>
    </header>
@endsection