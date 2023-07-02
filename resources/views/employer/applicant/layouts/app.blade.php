@extends('employer.layouts.app')

@section('content')
<div class="container-employer pt-4 px-4">
    <div class="content">
        <div class="py-lg-3 py-2 px-3 d-sm-block d-none">
            <h1 class="h4 text-dark mb-0 font-monospace">Service Order</h1>
        </div>
        <div class="border rounded my-2" style="background-color: #fff;">
            <ul class="navbar-nav px-3" id="parent-order-menu">
                <div class="d-flex align-items-center justify-content-start">
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant') }}" class="btn p-3 rounded-0" id="order-menu-link">Pending</a>
                        <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant-approved' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant-approved') }}" class="btn p-3 rounded-0" id="order-menu-link">Approved</a>
                        <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant-rejected' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant-rejected') }}" class="btn p-3 rounded-0" id="order-menu-link">Rejected</a>
                        <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant-completed' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant-completed') }}" class="btn p-3 rounded-0" id="order-menu-link">Completed</a>
                        <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                    </li>
                </div>
            </ul>
            {{ auth()->user()->freelancer->order }}
        </div>
        @yield('pages')
    </div>
</div>
@endsection