@extends('layouts.app')

@section('content')

    <div class="mt-3">
        <div class="container-lg px-4 border shadow-sm rounded" style="background-color: #fff;">
            <div class="py-4 ms-2 border-bottom">
                <h1 class="h6 text-start mb-0 text-dark">Employer Information</h1>
            </div>
            @yield('pages')
        </div>
    </div>

@endsection