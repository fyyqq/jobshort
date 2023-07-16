@extends('profile.layouts.app')


@section('profile')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
    
    <header class="px-4 pb-0 border shadow-sm" style="background-color: #fff;">
        <div class="py-4 ms-2 border-bottom">
            <h1 class="h5 mb-0 text-dark">My Address</h1>
        </div>
        @if (is_null(auth()->user()->country))
            <form action="{{ route('profile.store-address') }}" method="POST" class="mt-3">
                @csrf
        @else
            <form action="{{ route('profile.update-address') }}" method="post">
                @csrf
                @method('PUT')
        @endif
            <div class="form-floating mb-3 col-lg-8 col-12">
                <textarea type="text" class="form-control mt-4 shadow-none @error('address') is-invalid @enderror" style="font-size: 14px; height: 100px;" id="address" name="address">{{ (auth()->user()->roles != '0') ? ((auth()->user()->address) != null ? Auth::user()->address : old('address') ) : old('address') }}</textarea>
                <label class="ps-0 text-dark" for="address">Address :</label>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <div class="row mb-3 col-lg-8 col-12 position-relative">
                <div class="form-floating col-sm-6 col-12 mb-sm-0 mb-3" id="country">
                    <input type="text" class="form-control country-input shadow-none @error('country') is-invalid @enderror" style="font-size: 14px;" id="location" name="country" autocomplete="off" value="{{ (auth()->user()->roles != '0') ? ((auth()->user()->country != null) ? auth()->user()->country : '') : '' }}">
                    <label class="text-dark" for="country">Country :</label>
                    @error('country')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                    <ul class="suggestion-list col-sm-6 col-12"></ul>
                </div>
                <div class="form-floating col-sm-6 col-12">
                    <select name="state" class="form-control shadow-none @error('state') is-invalid @enderror" id="state">
                        @if (auth()->user()->roles != '0' && auth()->user()->state != null)
                            <option value="{{ (auth()->user()->state != null) ? auth()->user()->state : old('state') }}" {{ (auth()->user()->state != null) ? 'selected' : '' }}>{{ (auth()->user()->state != null) ? auth()->user()->state : old('state') }}</option>
                            @if (auth()->user()->state != null)
                                @foreach ($dataStates as $state)
                                    <option value="{{ $state }}">{{ $state }}</option>
                                @endforeach
                            @endif
                        @else
                            <option value="" id="empty-option">Select States</option>
                        @endif
                    </select>
                    <label class="text-dark" for="state">State :</label>
                    @error('state')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3 col-lg-8 col-12 position-relative">
                <div class="form-floating col-sm-6 col-12 mb-sm-0 mb-3">
                    <select name="city" id="city" class="form-control shadow-none @error('city') is-invalid @enderror">
                        @if (auth()->user()->roles != '0' && auth()->user()->city != null)
                            <option value="{{ (auth()->user()->city != null) ? auth()->user()->city : old('city') }}" {{ (auth()->user()->city != null) ? 'selected' : '' }}>{{ (auth()->user()->city != null) ? auth()->user()->city : old('city') }}</option>
                            @if (auth()->user()->city != null)
                                @foreach ($dataCities as $city)
                                    <option value="{{ $city }}">{{ $city }}</option>
                                @endforeach
                            @endif
                        @else
                            <option value="" id="empty-option">Select Cities</option>
                        @endif
                    </select>
                    <label class="text-dark" for="city">City :</label>
                    @error('city')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="form-floating col-sm-6 col-12 mb-2">
                    <input type="number" class="form-control shadow-none @error('postcode') is-invalid @enderror" style="font-size: 14px;" id="postcode" name="postcode" value="{{ (auth()->user()->roles != '0') ? ((auth()->user()->postcode != null) ? auth()->user()->postcode : old('postcode')) : old('postcode') }}" autocomplete="off">
                    <label class="text-dark" for="postcode">Postcode :</label>
                    @error('postcode')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                {{-- <label for="" class="form-label text-muted">Map Location</label>
                <div class="form-floating col-12 mt-2">
                    <div class="w-100 border rounded" style="height: 250px;">
                        <img src="https://i.stack.imgur.com/HILmr.png" class="w-100 h-100 rounded" loading="lazy">
                    </div>
                </div> --}}
                <div class="text-end mt-4 pe-0">
                    @if (is_null(auth()->user()->country))
                        <button type="submit" class="btn btn-primary px-3" style="background-color: #2891e1; font-size: 14.5px;">Submit</button>
                    @else
                        <button type="submit" class="btn btn-primary px-3" style="background-color: #2891e1; font-size: 14.5px;">Submit Changes</button>
                    @endif
                </div>
            </div>
        </form>
    </header>
@endsection
