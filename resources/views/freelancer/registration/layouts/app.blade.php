@extends('layouts.app')

@section('content')

    <div class="mt-3 container-lg pb-5">
        <div class="border shadow-sm rounded" style="background-color: #fff;">
            <div class="py-4 ms-2 border-bottom px-4">
                <h1 class="h6 text-start mb-0 text-dark">Freelancer Information</h1>
            </div>
            <div class="mt-4">
                @yield('pages')
            </div>
        </div>
    </div>

@endsection