@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <div class="w-100 pt-3 pb-4">
            <h2 class="h4 text-dark text-center">Categories</h2>
        </div>
        <div class="row mx-0" style="row-gap: 15px;">
            @foreach($categories as $category)
                <div class="col-xl-3 col-md-4 col-6">
                    <a href="{{ route('category', $category['slug']) }}" class="text-decoration-none px-5 bg-light border rounded w-100 d-flex align-items-center justify-content-center flex-column" id="box_categories">
                        <i class="{{ $category['icon'] }} fs-3 text-dark"></i>
                        <small class="text-muted mb-0 text-center">{{ $category['name'] }}</small>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection