{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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
                    <h1 class="h4 text-muted">Reset Password</h1>
                </div>
                <div class="content">
                    <img src="{{ asset('brand/man-avatar.png') }}">
                </div>
                <form action="{{ route('password.email') }}" method="POST" target="_self" style="margin-top: 100px;" id="submit-email">
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
