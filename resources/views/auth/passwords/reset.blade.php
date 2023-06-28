{{-- @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}


@extends('auth.layouts.app')

@section('content')
        <div class="login-side d-flex align-items-center justify-content-center">
            <div class="form-login px-4 pt-4 pb-3 shadow-sm border">
                <div class="text-center pb-2 mb-3 border-bottom">
                    <h1 class="h4 text-muted">New Password</h1>
                </div>
                <div class="content">
                    <img src="{{ asset('brand/man-avatar.png') }}">
                </div>
                <form method="POST" action="{{ route('password.update') }}" class="mt-4">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address :</label>
                        <input id="email" type="text" class="form-control shadow-none @error('email') is-invalid @enderror" name="email" value="{{ $email }}" disabled>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <small class="fw-bold" style="font-size: 12.5px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password :</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control shadow-none @error('password') is-invalid @enderror" autocomplete="new-password" id="password" autofocus>
                            <i class="fa-sharp fa-regular fa-eye"></i>
                            <i class="fa-sharp fa-regular fa-eye-slash"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <small class="fw-bold" style="font-size: 12.5px;">{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Confirm Password :</label>
                        <div class="position-relative">
                            <input type="password" name="password_confirmation" class="form-control shadow-none" autocomplete="new-password" id="password-confirm">
                            <i class="fa-sharp fa-regular fa-eye"></i>
                            <i class="fa-sharp fa-regular fa-eye-slash"></i>
                        </div>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary w-100 text-uppercase">Submit</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
