@extends('freelancer.profile.layouts.app')

@section('pages')
   
        <div class="col-md-7 col-12 mt-md-0 mt-5" id="personal" style="height: max-content;">
            <div class="row mx-0">
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted" id="name-title">Name</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <input type="text" name="name" id="" class="form-control w-100 shadow-none @error('name') is-invalid @enderror" value="{{ old('name', $data->name) }}">
                        @error('name')
                            <span class="text-danger" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted text-end" id="name-title">Identification Number</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <input type="number" name="number" id="" class="form-control w-100 shadow-none @error('number') is-invalid @enderror" value="{{ old('number', $data->number) }}">
                        @error('number')
                            <span class="text-danger" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted" id="name-title">Phone Number</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <input type="number" name="contact" id="" class="form-control w-100 shadow-none @error('contact') is-invalid @enderror" value="{{ old('contact', $data->contact) }}">
                        @error('contact')
                            <span class="text-danger" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted" id="name-title">Skills</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <select name="skills" id="" class="form-control w-100 shadow-none">
                            @if ($data->skills != null)
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->name }}" {{ $data->skills === $skill->name ? 'selected' : '' }}>{{ ucfirst($skill->name) }}</option>
                                @endforeach
                            @else
                                <option value="">Choose your skills</option>
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->name }}" >{{ ucfirst($skill->name) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted" id="name-title">Country</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column position-relative">
                        <input type="text" class="form-control country-input shadow-none @error('country') is-invalid @enderror" style="font-size: 14px;" id="countryInput" name="country" autocomplete="off" value="{{ $data->country }}">
                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                    <ul class="suggestion-list col-sm-6 col-12 position-absolute w-100"></ul>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="row d-flex align-items-start justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start" style="transform: translateY(8px);">
                        <small class="text-muted" id="name-title">About Me</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <textarea type="number" name="about" id="" class="form-control w-100 shadow-none @error('about') is-invalid @enderror" style="height: 150px;">{{ old('about', $data->about) }}</textarea>
                        @error('about')
                            <span class="text-danger" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-12 px-md-0 px-3">
            <div class="d-flex align-items-center justify-content-start justify-content-md-center flex-column">
                <div class="rounded-3" style="width: 90px; height: 90px; overflow:hidden;">
                    <img src="{{ is_null(auth()->user()->freelancer->image) ? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' : asset('images/' . auth()->user()->freelancer->image) }}" class="w-100 h-100 border" style="object-fit: cover;" id="seller_img" loading="lazy">
                </div>
                <div class="row mx-0 mt-3 position-relative">
                    <input type="text" name="" id="file_text" class="form-control shadow-none border-bottom text-center border-bottom" value="Choose a file...">
                    <i class="fa-solid text-secondary fa-xmark p-1" style="position: absolute; right: 0; top: 10px; font-size: 14px; cursor: pointer; z-index: 999; width: max-content;"></i>
                    <input type="file" name="image" id="employer-img" accept=".png, .jpg, .jpeg" value="{{ $data->image }}" readonly onchange="return freelancerImage(this)">
                    @error('profile_image')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

@endsection