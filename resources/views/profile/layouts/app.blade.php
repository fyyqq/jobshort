@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

@section('content')
    <div class="row mx-0 container-fluid profile px-md-4 px-0 pb-5 mt-md-3 mt-0">
        @include('profile.shortcuts.sidebar')
        <div class="profile-content h-100 p-0">
            @yield('profile')
        </div>
    </div>
@endsection


@if(session('success'))
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
