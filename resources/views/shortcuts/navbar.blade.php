{{-- Bootstrap --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
{{-- Sweet Alert --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm py-3 fixed-top" style="border-bottom: 3px solid #2891e1;">
    <div class="container">
        <a class="navbar-brand d-md-block d-none" href="{{ route('home') }}">
            <img src="{{ asset('brand/jobshort.png') }}" style="width: 80px;">
        </a>
        @if (Route::currentRouteName() != 'home')
            <a class="navbar-brand d-md-none d-block py-2 px-3" style="cursor: pointer;" onclick="return goToPreviousPage()">
                <i class="fa-solid fa-chevron-left text-muted" style="font-size: 16.5px;"></i>
            </a>
        @else
            <a class="navbar-brand d-md-none d-block" href="{{ route('home') }}">
                <img src="{{ asset('brand/jobshort.png') }}" style="width: 80px;">
            </a>
        @endif
        <div class="collapse navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto"></ul>
            <!-- Center Side Of Navbar -->
            <form action="{{ route('search') }}" method="get" class="d-md-flex d-none" onsubmit="return jobSearch()">
                <div class="btn-group" role="group">
                    <input type="text" name="search" id="searchbar" class="px-3 py-2" placeholder="Search Jobs..." style="width: 300px; border: 1px solid rgb(218, 216, 216); border-top-left-radius: 20px; border-bottom-left-radius: 20px;" value="<?php echo $_GET['search'] ?? '' ?>">
                    <button type="submit" class="px-3 shadow-0" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px; border: 1px solid rgb(218, 216, 216);">
                        <i class="fa-solid fa-magnifying-glass text-muted" style="font-size: 15px;"></i>
                    </button>
                </div>
            </form>
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @endguest
                <li class="nav-item dropdown d-flex align-items-center">
                    <a href="{{ route('notification') }}" class="text-decoration-none position-relative">
                        <i class="fa-regular fa-bell text-muted" style="font-size: 18px;"></i>
                        @if (count(auth()->user()->notification) > 0)
                            <span class="badge d-flex align-items-center justify-content-center rounded-circle position-absolute m-0 p-0" style="top: -8px; right: -5px; background-color: #2891e1; height: 15px; width: 15px; font-size: 10px;">{{ count(auth()->user()->notification) }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
        <div class="d-flex align-items-center justify-content-center ms-4">
            <li class="nav-item dropdown d-flex align-items-center">
                <span class="rounded-circle dropdown-navbar border border-secondary" type="button" data-bs-toggle="dropdown" style="height: 42px; width: 42px;">
                    <img src="{{ (auth()->user()->image != null) ? asset('images/' . auth()->user()->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQG7WjONaOfilXR3bebrfe_zcjl58ZdAzJHYw&usqp=CAU' }}" class="w-100 rounded-circle h-100" style="object-fit: cover;">
                </span>
                <ul class="dropdown-menu border border-1 p-0" style="transform: translate(-138px, 5px); width: 180px;">
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('profile.main') }}">Profile</a>
                    </li>
                    @if (auth()->user()->roles == '1')
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('employer.main') }}">Freelancer</a>
                        </li>
                    @endif
                    <li>
                        <span class="dropdown-item pt-2 pb-1" href="#">
                            <div class="ps-0 form-check form-switch d-flex justify-content-between flex-row-reverse">
                                <input class="form-check-input shadow-none" type="checkbox" id="darkmode">
                                <label for="darkmode" class="text-start">Dark Mode</label>
                            </div>
                        </span>
                    </li>
                    <li>
                        <a class="dropdown-item py-2 row mx-0" href="">Settings</a>
                    </li>
                    <div class="dropdown-divider my-0"></div>
                    <li>
                        <a class="dropdown-item py-2" id="btn-logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
