@extends('auth.layouts.app')

@section('content')
        <div class="login-side d-flex align-items-center justify-content-center">
            <div class="form-login px-4 pt-4 pb-3 shadow-sm border">
                <div class="text-center pb-2 mb-3 border-bottom position-relative">
                    <span class="position-absolute d-md-none d-block" style="top: 25%; left: 0; transform: translateY(-50%); cursor: pointer;" onclick="return window.history.back();">
                        <i class="fa-solid fa-arrow-left fs-5 text-muted"></i>
                    </span>
                    <h1 class="h5 text-dark">Reset Password</h1>
                </div>
                <div class="content">
                    <img src="https://static.vecteezy.com/system/resources/previews/016/730/158/original/refresh-icon-isolated-on-white-background-free-vector.jpg" style="width: 150px;">
                </div>
                <form action="{{ route('password.email') }}" method="POST" target="_self" id="submit-email">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address :</label>
                        <input type="email" name="email" class="form-control shadow-none  @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email" id="email" autofocus >
                        @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <small class="fw-bold" style="font-size: 12.5px;">{{ $message }}</small>
                                </span>
                        @enderror
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <button type="submit" class="btn btn-primary w-100 text-uppercase" style="font-size: 12px;">Send Password Reset</button>
                    </div>
                </form>
            </div>
        </div>
@endsection
