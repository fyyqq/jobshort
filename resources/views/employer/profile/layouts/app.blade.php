@extends('employer.layouts.app')

@section('content')
    <div class="container-employer pt-4 px-4">
        <div class="content shadow-sm border pb-4" style="background-color: #fff;">
            <div class="border-bottom pt-4 px-4 shadow-sm">
                <h1 class="h4 text-dark mb-1">Freelancer Profile</h1>
                <small class="mb-3" style="color: rgba(136, 136, 136, 0.868);">View your profile status and update your freelancer profile.</small>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-start">
                        <a href="{{ route('employer.profile') }}" class="text-decoration-none {{ Route::currentRouteName() === 'employer.profile' ? 'border-bottom border-3 border-primary' : '' }} px-4 py-3 profile-employer-btn" style="cursor: pointer;">
                            <p class="mb-0 text-dark">Personal</p>
                        </a>
                        <a href="{{ route('employer.profile-address') }}" class="text-decoration-none {{ Route::currentRouteName() === 'employer.profile-address' ? 'border-bottom border-3 border-primary' : '' }} px-4 py-3 profile-employer-btn" style="cursor: pointer;">
                            <p class="mb-0 text-dark">Address</p>
                        </a>
                    </div>
                </div>
            </div>
            @if (Route::currentRouteName() === 'employer.profile')
                <form action="{{ route('freelancer.profile-update', auth()->user()->freelancer->user_id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            @elseif (Route::currentRouteName() === 'freelancer.profile-address')
                {{-- <form action="{{ route('employer.address-update', auth()->user()->employer->user_id) }}" method="post" enctype="multipart/form-data"> --}}
                @csrf
                @method('PUT')
            @endif
                <div class="form-profile mt-5 px-3 d-flex align-items-start justify-content-start flex-md-row flex-column-reverse">
                    @yield('pages')
                </div>
                <div class="w-100 text-end mt-4 px-3">
                    <button type="submit" class="btn btn-primary px-3">Submit Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection