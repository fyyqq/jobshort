@extends('employer.layouts.app')

{{-- Bootstrap --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

@section('content')
    <div class="container-employer pt-4 px-md-4 px-0">
        <div class="content pb-4">
            <div class="py-4 px-4 shadow-sm rounded border" style="background-color: #fff;">
                <h1 class="h4 text-dark mb-1">My Jobs</h1>
                <small class="mb-3" style="color: rgba(136, 136, 136, 0.868);">A place to manage the workbook of the work you create.</small>
            </div>
            {{-- <div class="mt-3 shadow-sm rounded border" style="height: 150px; background-color: #fff;">
                <div class="row mx-0">
                    <div class="col-8"></div>
                    <div class="col-4 d-flex align-items-center justify-content-end position-relative">
                        <input type="text" class="form-control shadow-none" placeholder="Search Title...">
                        <i class="fa-solid fa-magnifying-glass text-muted position-absolute" style="top: 50%; right: 0; transform: translate(-20px, -25%); font-size: 12px;"></i>
                    </div>
                </div>
            </div> --}}
            <div class="mt-3">
                <div class="mb-3 border-bottom">
                    <div class="row mx-0 shadow-sm rounded border" style="background-color: #fff;">
                        <div class="col-2 d-flex align-items-center justify-content-center {{ Route::currentRouteName() === 'employer.jobs' ? 'border-3 border-bottom border-primary fw-bold text-primary' : '' }}">
                            <a href="{{ route('employer.jobs') }}" class="text-dark text-decoration-none py-3">All</a>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-center {{ Route::currentRouteName() === 'employer.live-jobs' ? 'border-3 border-bottom border-primary fw-bold text-primary' : '' }}">
                            <a href="{{ route('employer.live-jobs') }}" class="text-dark text-decoration-none py-3">Live</a>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-center {{ Route::currentRouteName() === 'employer.on-jobs' ? 'border-3 border-bottom border-primary fw-bold text-primary' : '' }}">
                            <a href="{{ route('employer.on-jobs') }}" class="text-dark text-decoration-none py-3">On-Work</a>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-center {{ Route::currentRouteName() === 'employer.complete-jobs' ? 'border-3 border-bottom border-primary fw-bold text-primary' : '' }}">
                            <a href="{{ route('employer.complete-jobs') }}" class="text-dark text-decoration-none py-3">Completed</a>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-center {{ Route::currentRouteName() === 'employer.archive-jobs' ? 'border-3 border-bottom border-primary fw-bold text-primary' : '' }}">
                            <a href="{{ route('employer.archive-jobs') }}" class="text-dark text-decoration-none py-3">Archived</a>
                        </div>
                    </div>
                </div>
                @yield('service-pages')
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


@if (session('success'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1800
            });
        });
    </script>
@endif