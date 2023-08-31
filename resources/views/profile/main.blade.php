@extends('profile.layouts.app')

@section('profile')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />

    <header class="box pb-3">
        <div class="box-title border d-md-block d-none border p-3 mb-2" style="border-top-right-radius: 10px; border-top-left-radius: 10px;>
            <h6 class="m-0">Profile</h6>
        </div>
        <div class="box-title p-3 mb-2 d-md-none d-block">
            <h6 class="m-0">Profile</h6>
        </div>
    
        @if (auth()->user()->roles != '0')
            <form action="{{ route('profile.update') }}" method="POST" class="border" enctype="multipart/form-data">
                @method('PUT')
        @else
            <form action="{{ route('profile.registration') }}" method="POST" class="border" enctype="multipart/form-data">
        @endif
            @csrf
            <div class="row mx-0 flex-lg-row flex-column-reverse p-3">
                <div class="col-lg-8 col-12">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow-none @error('name') is-invalid @enderror" style="font-size: 13.5px;" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" autocomplete="off">
                        <label class="ps-0 text-dark" for="name">Username :</label>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div class="row mb-2 position-relative">
                        <div class="form-floating mb-3 col-sm-6 col-12">
                            <input type="number" class="form-control shadow-none @error('identification_number') is-invalid @enderror" style="font-size: 13.5px;" id="identification_number" name="identification_number" value="{{ (auth()->user()->roles != '0') ? old('identification_number', auth()->user()->identification_number) : old('identification_number') }}" autocomplete="off">
                            <label class="text-dark" for="identification_number">Identification No :</label>
                            @error('identification_number')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-floating mb-3 col-sm-6 col-12">
                            <input type="date" class="form-control shadow-none @error('birth_date') is-invalid @enderror" name="birth_date" id="birth_date" style="font-size: 13.5px;" value="{{ (auth()->user()->roles != '0') ? old('birth_date', auth()->user()->birth_date) : old('birth_date') }}">
                            <label class="text-dark" for="birth_date">Date of Birth :</label>
                            @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <label class="form-check-label text-muted" style="font-size: 11.5px;">Gender :</label>
                    <div class="d-flex align-items-center justify-content-start mb-2 mt-2" style="column-gap: 15px;">
                        <div class="form-check">
                            @if (auth()->user()->roles != '0')
                                <input class="shadow-none form-check-input" type="radio" name="gender" id="man" value="Man" {{ auth()->user()->gender == 'Man' ? 'checked' : '' }}>
                            @else
                                <input class="shadow-none form-check-input" type="radio" name="gender" id="man" value="Man" {{ old('gender') == 'Man' ? 'checked' : '' }}>
                            @endif
                            <label class="ps-0 text-dark" class="form-label text-muted" for="man" style="font-size: 13.5px;">Man</label>
                        </div>
                        <div class="form-check">
                            @if (auth()->user()->roles != '0')
                                <input class="shadow-none form-check-input" type="radio" name="gender" id="woman" value="Woman" {{ old('gender') == "Woman" && auth()->user()->gender == 'Woman' ? 'checked' : '' }}>
                            @else
                                <input class="shadow-none form-check-input" type="radio" name="gender" id="woman" value="Woman" {{ old('gender') == 'Woman' ? 'checked' : '' }}>
                            @endif
                            <label class="ps-0 text-dark" class="form-label text-muted" for="woman" style="font-size: 13.5px;">Woman</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea type="text" class="form-control mt-md-3 mt-2 shadow-none @error('about') is-invalid @enderror" style="font-size: 13.5px; height: 100px;" id="about" name="about">{{ (auth()->user()->roles != '0') ? old('about', auth()->user()->about) : old('about') }}</textarea>
                        <label class="ps-0 text-dark" for="about">About Me :</label>
                        @error('about')
                            <span class="invalid-feedback" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4 col-12 mt-lg-4 mt-0 py-lg-0 py-4">
                    <div class="d-flex align-items-center flex-column">
                        <div class="rounded-3" id="profile-image-form" style="overflow:hidden;">
                            <img src="{{ (auth()->user()->image == null) ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' : asset('images/' . auth()->user()->image) }}" class="w-100 h-100 border" style="object-fit: cover;" loading="lazy">
                        </div>
                        <div class="mt-4 position-relative">
                            <input type="text" name="" id="file_text" class="form-control shadow-none border-bottom text-center border-bottom" value="Choose a file..." style="font-size: 13.5px;">
                            <i class="fa-solid text-secondary fa-xmark p-1" style="position: absolute; right: 0; top: 10px; font-size: 13.5px; cursor: pointer; z-index: 999;" onclick="removeProfileImage(event)"></i>
                            <input type="file" name="image" id="profile-img" accept=".png, .jpg, .jpeg" onchange="insertProfileImage(this)">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end mb-3 me-3">
                <button type="submit" id="btn-profile-form" class="text-light btn btn-sm px-3" style="font-size: 13.5px;">{{ auth()->user()->roles != '0' ? 'Saved' : 'Submit' }}</button>
            </div>
        </form>
    </header>

@endsection
