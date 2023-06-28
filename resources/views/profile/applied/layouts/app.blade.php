@extends('profile.layouts.app')

@section('profile')
    <header class="pb-4">
        <div class="p-4 border" style="background-color: #fff;">
            <h1 class="h5 mb-1 text-dark">Orders</h1>
            <small class="text-muted" style="font-size: 13px;">Your Orders. Check if your orders accepted</small>
        </div>
        <div class="border my-2" style="background-color: #fff;">
            <ul class="navbar-nav px-3">
                <div class="d-flex align-items-center justify-content-start">
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied') }}" class="btn p-3 rounded-0">Pending</a>
                        <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'pending')) }}</span>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied-approved' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied-approved') }}" class="btn p-3 rounded-0">Approved</a>
                        <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'approved')) }}</span>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied-rejected' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied-rejected') }}" class="btn p-3 rounded-0">Rejected</a>
                        <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'rejected')) }}</span>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'profile.applied-completed' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('profile.applied-completed') }}" class="btn p-3 rounded-0">Completed</a>
                        <span class="badge rounded-circle text-dark position-absolute" style="top: 10px; right: 0px; font-size: 10px;">{{ count(auth()->user()->order->where('status', 'completed')) }}</span>
                    </li>
                </div>
            </ul>
        </div>
        <div class="">
            @yield('pages')
        </div>
    </header>
@endsection