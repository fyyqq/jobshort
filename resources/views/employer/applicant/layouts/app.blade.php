@extends('employer.layouts.app')

@section('content')
<div class="container-employer pt-4 px-4">
    <div class="content pb-4 pb-4">
        <div class="py-4 px-4 border rounded" style="background-color: #fff;">
            <h1 class="h4 text-dark mb-1">My Applicant</h1>
            <small class="text-muted">Manage your candidate that apply your posting jobs.</small>
        </div>
        <div class="border rounded my-2" style="background-color: #fff;">
            <ul class="navbar-nav px-3">
                <div class="d-flex align-items-center justify-content-start">
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant') }}" class="btn p-3 rounded-0">Pending</a>
                        <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant-approved' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant-approved') }}" class="btn p-3 rounded-0">Approved</a>
                        <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant-rejected' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant-rejected') }}" class="btn p-3 rounded-0">Rejected</a>
                        <small class="position-absolute" style="top: 15%; right: 5px; font-size: 12px;"></small>
                    </li>
                    <li class="position-relative {{ Route::currentRouteName() === 'employer.applicant-completed' ? 'border-bottom border-2 border-primary' : '' }}">
                        <a href="{{ route('employer.applicant-completed') }}" class="btn p-3 rounded-0">Completed</a>
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