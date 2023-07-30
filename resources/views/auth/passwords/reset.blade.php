@extends('auth.layouts.app')

@section('content')
        <div class="login-side d-flex align-items-center justify-content-center">
            <div class="form-login px-4 pt-4 pb-3 shadow-sm border">
                <div class="text-center pb-2 mb-3 border-bottom position-relative">
                    <span class="position-absolute d-md-none d-block" style="top: 25%; left: 0; transform: translateY(-50%);" onclick="return window.history.back();">
                        <i class="fa-solid fa-arrow-left fs-5 text-muted"></i>
                    </span>
                    <h1 class="h5 text-dark">New Password</h1>
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
