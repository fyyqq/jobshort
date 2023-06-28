@extends('employer.registration.layouts.app')

@section('pages')
    {{-- <div class="container-lg mt-3">
        <div class="border shadow pb-4 rounded-3" style="background-color: #fff;">
            <div class="py-4 ms-2 border-bottom">
                <h1 class="h5 text-center mb-0 text-dark">Employer Registration</h1>
            </div>
            <form action="{{ route('employer.post-registration') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mx-0 mt-3 px-3">
                    <div class="col-md-3 col-12 mb-md-0 mb-4 border-end">
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <div class="me-md-0 me-4" style="height: 120px; width: 120px;" style="overflow: hidden;">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU" id="seller_img" class="rounded-circle w-100 h-100 border" style="object-fit: cover;">
                            </div>
                            <div class="d-flex flex-column">
                                <div class="mt-3 position-relative">
                                    <input type="text" name="" id="file_text" class="form-control shadow-none border-bottom text-center border-bottom" value="Choose a file...">
                                    <i class="fa-solid text-secondary fa-xmark" style="position: absolute; right: 0; top: 10px; font-size: 14px; cursor: pointer; z-index: 999;"></i>
                                    <input type="file" name="image" id="profile-img" accept=".png, .jpg, .jpeg">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-12" style="height: max-content;">
                        <div class="row mx-0">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control shadow-none @error('name') is-invalid @enderror" style="font-size: 14px;" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
                                    <label class="ps-0 text-dark" for="name">Name :</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control shadow-none @error('email') is-invalid @enderror" style="font-size: 14px;" id="email" name="email" value="{{ old('email') }}">
                                    <label class="ps-0 text-dark" for="name">Email address :</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control shadow-none @error('identification_number') is-invalid @enderror" style="font-size: 14px;" id="identification_number" name="identification_number" value="{{ old('identification_number') }}" autocomplete="off">
                                    <label class="ps-0 text-dark" for="identification_number">Identification No :</label>
                                    @error('identification_number')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control shadow-none @error('phone_number') is-invalid @enderror" style="font-size: 14px;" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" autocomplete="off">
                                    <label class="ps-0 text-dark" for="name">Phone Number :</label>
                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control shadow-none @error('about') is-invalid @enderror" style="font-size: 14px; height: 100px;" id="about" name="about">{{ old('about') }}</textarea>
                                    <label class="ps-0 text-dark" for="about">About Me :</label>
                                    @error('about')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <textarea type="text" class="form-control shadow-none @error('address') is-invalid @enderror" style="font-size: 14px; height: 100px;" id="address" name="address">{{ old('address') }}</textarea>
                                    <label class="ps-0 text-dark" for="address">Address :</label>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-md-6 col-12">
                                 <div class="form-floating mb-3">
                                    <input type="text" class="form-control country-input shadow-none @error('country') is-invalid @enderror" style="font-size: 14px;" id="location" name="country" autocomplete="off" value="">
                                    <label class="text-dark ps-0" for="country">Country :</label>
                                    @error('country')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                    <ul class="suggestion-list col-sm-6 col-12"></ul>
                                 </div>
                            </div>
                            <div class="col-md-6 col-12">
                                 <div class="form-floating mb-3">
                                    <select name="state" class="form-control shadow-none @error('state') is-invalid @enderror" id="state">
                                        <option value="">Select State</option>
                                    </select>
                                    <label class="text-dark ps-0" for="state">State :</label>
                                 </div>
                            </div>
                        </div>
                        <div class="row mx-0">
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                   <select name="city" class="form-control shadow-none @error('city') is-invalid @enderror" id="city">
                                       <option value="">Select City</option>
                                   </select>
                                   <label class="text-dark ps-0" for="city">City :</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating">
                                    <input type="number" class="form-control shadow-none @error('postcode') is-invalid @enderror" style="font-size: 14px;" id="postcode" name="postcode" value="" autocomplete="off">
                                    <label class="text-dark ps-0" for="postcode">Postcode :</label>
                                    @error('postcode')
                                        <span class="invalid-feedback" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="w-100 mt-3 text-end">
                            <button type="submit" class="btn btn-primary px-4" style="background-color: #2891e1; font-size: 14px;">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <form action="{{ (is_null($data) ? route('employer.post-registration') : route('employer.update-registration'))  }}" method="post">
        @if (is_null($data))
            @csrf
        @else
            @csrf
            @method('PUT')
        @endif
        <div class="col-md-8 col-12 mt-4" id="detail-information" style="height: max-content;">
            <div class="row d-flex align-items-center justify-content-center mb-4">
                <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                    <small class="text-muted">Employer Type</small>
                </div>
                <div class="col-md-8 col-12 mt-md-0 mt-3 d-flex align-items-center justify-content-start">
                    <div class="d-flex align-items-center justify-content-start" style="column-gap: 15px;">
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="radio" name="employer_type" id="individual" value="individual" {{ (is_null($data) || $data->employer_type == 'individual') ? 'checked' : '' }}>
                            <label style="font-size: 14px;" class="form-check-label" for="individual">Individual</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="radio" name="employer_type" id="company" value="company" {{ ($data && $data->employer_type == 'company') ? 'checked' : '' }}>
                            <label style="font-size: 14px;" class="form-check-label" for="company">Registered Business</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-0">
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted" id="name-title">Name</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <input type="text" name="name" id="" class="form-control w-100 shadow-none @error('name') is-invalid @enderror" value="{{ $data->name ?? old('name') }}">
                        @error('name')
                            <span class="text-danger" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted" id="number-title">identification Number</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <input type="number" name="number" id="" class="form-control w-100 shadow-none @error('number') is-invalid @enderror" value="{{ $data->number ?? old('number') }}">
                        @error('number')
                            <span class="text-danger" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row d-flex align-items-center justify-content-center mb-4">
                    <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                        <small class="text-muted" id="contact-title">Contact Number</small>
                    </div>
                    <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                        <input type="number" name="contact" id="" class="form-control w-100 shadow-none @error('contact') is-invalid @enderror" value="{{ $data->contact ?? old('contact') }}">
                        @error('contact')
                            <span class="text-danger" role="alert">
                                <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 py-3 border-top mt-3">
            <div class="d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-primary px-4">Next</button>
            </div>
        </div>
    </form>
      
@endsection