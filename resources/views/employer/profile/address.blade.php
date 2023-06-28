@extends('employer.profile.layouts.app')

@section('pages')
   
    <div class="col-md-8 col-12" id="personal" style="height: max-content;">
        <div class="row mx-0">
            <div class="row d-flex align-items-start justify-content-center mb-4">
                <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start" style="transform: translateY(8px);">
                    <small class="text-muted">Address</small>
                </div>
                <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column">
                    <textarea name="address" id="" class="form-control shadow-none w-100" style="height: 100px;">{{ $data->address }}</textarea>
                    @error('address')
                        <span class="text-danger" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row d-flex align-items-start justify-content-center mb-4">
                <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                    <small class="text-muted">Country</small>
                </div>
                <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column position-relative">
                    <input type="text" class="form-control country-input shadow-none @error('country') is-invalid @enderror" style="font-size: 14px;" id="location" name="country" autocomplete="off" value="{{ $data->country }}">
                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                    <ul class="suggestion-list col-sm-6 col-12"></ul>
                </div>
            </div>
            <div class="row d-flex align-items-start justify-content-center mb-4">
                <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                    <small class="text-muted">State</small>
                </div>
                <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column position-relative">
                    <select name="state" class="form-control shadow-none @error('state') is-invalid @enderror" id="state">
                        <option value="{{ $data->state }}">{{ $data->state }}</option>
                        @foreach ($states as $state)
                            <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                        {{-- <option value="">Select State</option> --}}
                    </select>
                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row d-flex align-items-start justify-content-center mb-4">
                <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                    <small class="text-muted">City</small>
                </div>
                <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column position-relative">
                    <select name="city" class="form-control shadow-none @error('city') is-invalid @enderror" id="city">
                        <option value="{{ $data->city }}">{{ $data->city }}</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                        {{-- <option value="">Select City</option> --}}
                    </select>
                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row d-flex align-items-start justify-content-center mb-4">
                <div class="col-md-4 col-12 d-flex align-items-center justify-content-md-end justify-content-start">
                    <small class="text-muted">Postcode</small>
                </div>
                <div class="col-md-8 col-12 d-flex align-items-start justify-content-start flex-column position-relative">
                    <input type="number" class="form-control shadow-none @error('postcode') is-invalid @enderror" style="font-size: 14px;" id="postcode" name="postcode" value="{{ $data->postcode }}" autocomplete="off">
                    @error('postcode')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

@endsection