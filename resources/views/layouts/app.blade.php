<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Icon --}}
        <title>{{ config('app.name', 'Laravel') }}</title>
        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        {{-- Fancybox --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        {{-- Swal Alert --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
        {{-- Owl Carousel --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        {{-- Google Icon --}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
        {{-- CSS --}}
        <link rel="stylesheet" href="{{ asset('styles.css') }}">
        {{-- Izitoast --}}
        <link rel="stylesheet" href="{{ asset('izitoast/iziToast.min.css') }}">
        {{-- MDB --}}
        {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet"/> --}}
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <style>
        #app:hover .material-symbols-outlined {
            color: #fff;
        }
    </style>
    <body>
        <div id="app" class="position-relative">
            <a href="/chatify" class="text-decoration-none badge rounded-circle" id="chat" >
                <span class="material-symbols-outlined" style="font-size: 22px;">forum</span>
            </a>
            @include('shortcuts.navbar')
            <main class="pb-5" style="margin-top: 100px;">
                @yield('content')
            </main>
            {{-- Mobile Navbar --}}
            <div class="shadow-sm {{ Route::currentRouteName() === 'jobs' ? 'd-none' : 'd-block' }}">
                <div class="" id="mobile-navbar">
                    <div class="row mx-0 d-flex align-items-center justify-content-around" id="main">
                        <a href="{{ route('home') }}" class="text-decoration-none col-2 h-100 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-house {{ Route::currentRouteName() === 'home' ? 'text-dark' : 'text-muted' }}" style="font-size: 19px;"></i>
                        </a>
                        <a href="{{ route('profile.saved-jobs') }}" class="text-decoration-none col-2 h-100 d-flex align-items-center justify-content-center">
                            <i class="fa-regular text-muted fa-heart" style="font-size: 19px;"></i>
                        </a>
                        <a href="" class="text-decoration-none col-2 h-100 d-flex align-items-center justify-content-center">
                            <div class="position-relative">
                                @if (Auth::check() && count(auth()->user()->notification) < 1)
                                    <span class="badge rounded-circle position-absolute d-flex align-items-center justify-content-center m-0 p-0" style="top: -7px; right: -5px; font-size: 11.5px; height: 15.5px; width: 15.5px; background-color: #2891e1;">{{ count(auth()->user()->notification) }}</span>
                                @endif
                                <i class="fa-regular text-muted fa-bell" style="font-size: 19px;"></i>
                            </div>
                        </a>
                        <a href="{{ route('profile.main') }}" class="text-decoration-none col-2 h-100 d-flex align-items-center justify-content-center">
                            @if (Route::currentRouteName() === 'profile.main')
                                <i class="fa-solid fa-user text-dark" style="font-size: 19px;"></i>
                            @else
                                <i class="fa-regular fa-user text-muted" style="font-size: 19px;"></i>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('izitoast/iziToast.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://kit.fontawesome.com/5e539df1ae.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
        {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script> --}}
        <script src="{{ asset('script.js') }}"></script>
    </body>
</html>
