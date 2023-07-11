@extends('layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

@section('content')
    <div class="row mx-0 container-xl profile pb-5 mt-md-3 mt-0 mx-auto gap-md-3 gap-0">
        @include('profile.shortcuts.sidebar')
        <div class="profile-content h-100 px-0">
            @yield('profile')
        </div>
        <div class="w-100 d-md-none d-block pb-5">
            <button class="btn btn-light px-3 w-100 py-2 border rounded-pill" style="background-color: #fff;" onclick="event.preventDefault(); return logout()">Logout</button>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
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
