@extends('auth.layouts.app')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">

@section('content')

    <div class="login-side d-flex align-items-center justify-content-center">
        <div class="form-login p-4 shadow-sm border">
            <div class="text-center pb-2 mb-3 border-bottom position-relative">
                <span class="position-absolute d-md-none d-block" style="top: 25%; left: 0; transform: translateY(-50%); cursor: pointer;" onclick="return window.history.back();">
                    <i class="fa-solid fa-arrow-left fs-5 text-muted"></i>
                </span>
                <h1 class="h5 text-dark">Register</h1>
            </div>
            <div class="content">
                <img src="{{ asset('brand/unknown.png') }}">
            </div>
            <form action="{{ route('register') }}" method="POST" class="mt-3">
                @csrf
                <div class="{{ $errors->has('name') ? 'mb-1' : 'mb-2' }}">
                    <label for="name" class="form-label">Username :</label>
                    <input type="text" name="name" class="form-control shadow-none  @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" id="name" autofocus >
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12.5px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="{{ $errors->has('email') ? 'mb-1' : 'mb-2' }}">
                    <label for="email" class="form-label">Email Address :</label>
                    <input type="email" name="email" class="form-control shadow-none  @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email" id="email" >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <small class="fw-bold" style="font-size: 12.5px;">{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password :</label>
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control shadow-none" autocomplete="current-password" id="password">
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
                    <label for="password_confirmation" class="form-label">Confirm Password :</label>
                    <div class="position-relative">
                        <input type="password" name="password_confirmation" autocomplete="new-password" class="form-control shadow-none" autocomplete="new-password" id="password-confirm">
                        <i class="fa-sharp fa-regular fa-eye"></i>
                        <i class="fa-sharp fa-regular fa-eye-slash"></i>
                    </div>
                </div>
                <div class="w-100 d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary w-100 text-uppercase">Submit</button>
                </div>
                <div class="w-100 text-start mt-3">
                    <a href="{{ route('login') }}" class="form-check-label text-decoration-none" style="font-size: 13px;">Have account ?</a>
                </div>
            </form>
        </div>
    </div>

    {{-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@if(session('success'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1800
            });
        });
    </script>
@endif
