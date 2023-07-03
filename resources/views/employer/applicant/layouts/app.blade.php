@extends('employer.layouts.app')

@section('content')
<div class="container-employer pt-md-4 pt-3 px-lg-4 px-2">
    <div class="content">
        <div class="border rounded py-md-4 py-3 px-md-4 px-3 d-flex align-items-center justify-content-start gap-3" style="background-color: #fff;">
            <div class="py-1 px-2" style="cursor: pointer;" onclick="return goToPreviousPage()">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
            <h1 class="h4 text-dark mb-0 d-md-block d-none" style="font-size: 20px;">Service Order</h1>
            <h1 class="h4 text-dark mb-0 d-md-none d-block" style="font-size: 17px;">Service Order</h1>
        </div>
        <div class="border rounded my-2" style="background-color: #fff;">
            <ul class="navbar-nav px-md-3 px-2" id="parent-order-menu">
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