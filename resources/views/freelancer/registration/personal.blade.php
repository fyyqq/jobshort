@extends('freelancer.registration.layouts.app')

@section('pages')
    <form action="{{ route('freelancer.post-registration') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row mx-0 flex-md-row flex-column-reverse">
            <div class="col-md-8 col-12">
                <div class="row mx-0">
                    <div class="row d-flex align-items-center justify-content-center mb-4">
                        <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                            <small class="text-muted" id="name-title" style="font-size: 13.5px;">* Username</small>
                        </div>
                        <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                            <input type="text" name="name" id="" class="form-control w-100 shadow-none @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row d-flex align-items-center justify-content-center mb-4">
                        <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                            <small class="text-muted" id="number-title" style="font-size: 13.5px;">* identification Number</small>
                        </div>
                        <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                            <input type="number" name="number" id="" class="form-control w-100 shadow-none @error('number') is-invalid @enderror" value="{{ old('number') }}">
                            @error('number')
                                <span class="text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row d-flex align-items-center justify-content-center mb-4">
                        <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                            <small class="text-muted" id="contact-title" style="font-size: 13.5px;">* Contact Number</small>
                        </div>
                        <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                            <input type="number" name="contact" id="" class="form-control w-100 shadow-none @error('contact') is-invalid @enderror" value="{{ old('contact') }}">
                            @error('contact')
                                <span class="text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row d-flex align-items-center justify-content-center mb-4">
                        <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                            <small class="text-muted" id="name-title" style="font-size: 13.5px;">* Skills</small>
                        </div>
                        <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                            <select name="skills" class="form-control w-100 shadow-none @error('skills') is-invalid @enderror" id="">
                                <option value="">Choose your skills</option>
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill->name }}">{{ ucfirst($skill->name) }}</option>
                                @endforeach
                            </select>
                            @error('skills')
                                <span class="text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row d-flex align-items-start justify-content-center mb-4">
                        <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                            <small class="text-muted" style="font-size: 13.5px;">* Country</small>
                        </div>
                        <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column position-relative">
                            <input type="text" class="form-control country-input shadow-none @error('country') is-invalid @enderror" style="font-size: 14px;" id="location" name="country" autocomplete="off" value="{{ old('country') }}">
                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                            <ul class="suggestion-list col-sm-6 col-12"></ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12 mb-md-0 mb-5">
                <div class="d-flex align-items-center justify-content-start justify-content-md-center flex-column"id="profile-image-form">
                    <div class="rounded-3" style="width: 90px; height: 90px; overflow:hidden;">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU" class="w-100 h-100 border" style="object-fit: cover;" id="seller_img">
                    </div>
                    <div class="row mx-0 mt-3 position-relative">
                        <input type="text" id="file_text" class="form-control shadow-none border-bottom text-center border-bottom" value="Choose a file...">
                        <i class="fa-solid text-secondary fa-xmark p-1" style="position: absolute; right: 0; top: 10px; font-size: 14px; cursor: pointer; z-index: 999; width: max-content;"></i>
                        <input type="file" name="image" id="profile-img" accept=".png, .jpg, .jpeg" value="" readonly>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 py-3 px-4 border-top mt-3">
            <div class="d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-sm btn-primary px-4 py-2">Submit</button>
            </div>
        </div>
    </form>
      
@endsection