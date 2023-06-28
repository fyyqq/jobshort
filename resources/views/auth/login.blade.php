@extends('auth.layouts.app')

@section('content')
        <div class="login-side d-flex align-items-center justify-content-center">
            <div class="form-login px-4 pt-4 pb-3 shadow-sm border">
                <div class="text-center pb-2 mb-3 border-bottom">
                    <h1 class="h4 text-muted">Login</h1>
                </div>
                <div class="content">
                    <img src="{{ asset('brand/unknown.png') }}">
                </div>
                <form action="{{ route('login') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="{{ $errors->has('email') ? 'mb-2' : 'mb-3' }}">
                        <label for="email" class="form-label">Email Address :</label>
                        <input type="email" name="email" class="form-control shadow-none  @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email" id="email" autofocus >
                        @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12.5px;">{{ $message }}</small>
                                </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">Password :</label>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control shadow-none " autocomplete="current-password" id="password">
                            <i class="fa-sharp fa-regular fa-eye"></i>
                            <i class="fa-sharp fa-regular fa-eye-slash"></i>
                        </div>    
                        @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12.5px;">{{ $message }}</small>
                                </span>
                        @enderror
                    </div>
                    <div class="mb-3 ps-0 text-end form-check w-100">
                        <a href="{{ route('password.request') }}" class="form-check-label text-decoration-none" style="font-size: 13px;">Forgot Password ?</a>
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary w-100 text-uppercase">Submit</button>
                    </div>
                    <div class="w-100 text-start mt-3">
                        <a href="{{ route('register') }}" class="form-check-label text-decoration-none" style="font-size: 13px;">Doesn't have account ?</a>
                    </div>
                </form>
            </div>
        </div>
@endsection
