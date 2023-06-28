@extends('profile.layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

@section('profile')

    <header class="px-4 pb-3 border shadow-sm" style="background-color: #fff;">
        <div class="py-4 ms-2 border-bottom">
            <h1 class="h5 mb-0 text-dark">My Profile</h1>
        </div>
    
        @if (auth()->user()->roles != '0')
            <form action="{{ route('profile.employee-update') }}" method="POST" class="mt-3" enctype="multipart/form-data">
                @method('PUT')
        @else
            <form action="{{ route('profile.employee-registration') }}" method="POST" class="mt-3" enctype="multipart/form-data">
        @endif
            @csrf
            <div class="row mx-0 flex-lg-row flex-column-reverse">
                <div class="col-lg-8 col-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow-none @error('name') is-invalid @enderror" style="font-size: 14px;" id="name" name="name" value="{{ old('name') ? old('name') : auth()->user()->name }}" autocomplete="off">
                        <label class="ps-0 text-dark" for="name">Name :</label>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow-none @error('username') is-invalid @enderror" style="font-size: 14px;" id="username" name="username" value="{{ (auth()->user()->roles != '0') ? old('username', auth()->user()->username) : old('username') }}" autocomplete="off">
                        <label class="ps-0 text-dark" for="username">Username :</label>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div class="row mb-3 position-relative">
                        <div class="form-floating mb-3 col-sm-6 col-12">
                            <input type="number" class="form-control shadow-none @error('identification_number') is-invalid @enderror" style="font-size: 14px;" id="identification_number" name="identification_number" value="{{ (auth()->user()->roles != '0') ? old('identification_number', auth()->user()->identification_number) : old('identification_number') }}" autocomplete="off">
                            <label class="text-dark" for="identification_number">Identification No :</label>
                            @error('identification_number')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3 col-sm-6 col-12">
                            <input type="date" class="form-control shadow-none @error('birth_date') is-invalid @enderror" name="birth_date" id="birth_date" value="{{ (auth()->user()->roles != '0') ? old('birth_date', auth()->user()->birth_date) : old('birth_date') }}">
                            <label class="text-dark" for="birth_date">Date of Birth :</label>
                            @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <label class="form-check-label">Gender :</label>
                    <div class="d-flex align-items-center justify-content-start mt-2" style="column-gap: 15px;">
                        <div class="form-check">
                            {{-- <input class="shadow-none form-check-input" type="radio" name="gender" id="man" value="Man" {{ old('gender') == "Man" ? 'checked' : '' }}> --}}
                            <input class="shadow-none form-check-input" type="radio" name="gender" id="man" value="Man" {{ (auth()->user()->roles != '0') ? old('gender', auth()->user()->gender == "Man") ? 'checked' : '' : old('gender') }}>
                            <label class="ps-0 text-dark" class="form-label text-muted" for="man">Man</label>
                        </div>
                        <div class="form-check">
                            {{-- <input class="shadow-none form-check-input" type="radio" name="gender" id="woman" value="Woman" {{ old('gender') == "Woman" ? 'checked' : '' }}> --}}
                            <input class="shadow-none form-check-input" type="radio" name="gender" id="woman" value="Woman" {{ (auth()->user()->roles != '0') ? old('gender', auth()->user()->gender == "Woman") ? 'checked' : '' : old('gender') }}>
                            <label class="ps-0 text-dark" class="form-label text-muted" for="woman">Woman</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea type="text" class="form-control mt-lg-3 mt-2 shadow-none @error('about') is-invalid @enderror" style="font-size: 14px; height: 100px;" id="about" name="about">{{ (auth()->user()->roles != '0') ? old('about', auth()->user()->about) :  old('about') }}</textarea>
                        <label class="ps-0 text-dark" for="about">About Me :</label>
                        @error('about')
                            <span class="invalid-feedback" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-12 mt-lg-4 mt-2 pb-lg-0 pb-4">
                    <div class="d-flex align-items-center flex-column">
                        <div class="rounded-circle" style="width: 100px; height: 100px; overflow:hidden;">
                            <img src="{{ (auth()->user()->image == null) ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' : asset('images/' . auth()->user()->image) }}" class="w-100 h-100 border rounded-circle" style="object-fit: cover;" id="seller_img">
                        </div>
                        <div class="mt-4 position-relative">
                            <input type="text" name="" id="file_text" class="form-control shadow-none border-bottom text-center border-bottom" value="Choose a file...">
                            <i class="fa-solid text-secondary fa-xmark p-1" style="position: absolute; right: 0; top: 10px; font-size: 14px; cursor: pointer; z-index: 999;"></i>
                            <input type="file" name="image" id="profile-img" accept=".png, .jpg, .jpeg">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <a href="{{ route('profile.main') }}" class="btn btn-outline-dark px-3 {{ (auth()->user()->roles == '0') ? 'd-none' : '' }}" style="font-size: 14.5px;">Back to Default</a>
                <button type="submit" class="btn btn-primary px-3" style="background-color: #2891e1; font-size: 14.5px;"> {{ auth()->user()->roles != '0' ? 'Submit Changes' : 'Submit' }}</button>
            </div>
        </form>
    </header>

@endsection
