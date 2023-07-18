<div class="w-100" style="border-top: 3px solid #2891e1; background-color: #fff;">
    <footer class="container-lg pt-5 pb-md-0 pb-5 px-md-0 px-3">
        <div class="d-flex align-items-center justify-content-lg-between justify-content-md-around justify-content-center flex-md-row flex-column py-3 gap-5">
            <div class="d-flex align-items-md-start align-items-center justify-content-center flex-column gap-4">
                <a href="{{ route('home') }}" class="">
                    <img src="{{ asset('brand/jobshort.png') }}" alt="" style="width: 110px;" loading="lazy">
                </a>
                <div class="d-flex align-items-center justify-content-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-sm rounded-pill py-2 px-sm-4 px-3 btn-primary">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-sm rounded-pill py-2 px-sm-4 px-3 border">Register</a>
                    @else
                        <a href="{{ route('profile.main') }}" class="btn btn-sm rounded-pill py-2 px-sm-4 px-3 btn-primary">Profile</a>
                        <a href="{{ route('freelancer.main') }}" class="btn btn-sm rounded-pill py-2 px-sm-4 px-3 border">Freelancer</a>
                    @endguest
                </div>
                <ul class="list-unstyled d-flex mb-0">
                    <li class="">
                        <a class="link-body-emphasis" id="link_personal_footer" target="_blank" href="https://www.linkedin.com/in/fyqq">
                            <i class="fa-brands fa-linkedin"></i>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="link-body-emphasis" id="link_personal_footer" target="_blank" href="https://github.com/fyyqq">
                            <i class="fa-brands fa-github"></i>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="link-body-emphasis" id="link_personal_footer" target="_blank" href="https://twitter.com/afiqqimy">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </li>
                    <li class="ms-3">
                        <a class="link-body-emphasis" id="link_personal_footer" target="_blank" href="mailto:afiqakimy123@gmail.com">
                            <i class="fa-solid fa-envelope" style="font-size: 14px;"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="row mx-0 gap-lg-5 gap-md-4 gap-3" id="footer_link">
                <ul class="navbar-nav align-items-md-start align-items-center justify-content-center gap-2 col-sm">
                    <small><a href="{{ route('home') }}" class="dropdown-item">Home</a></small>
                    <small><a href="{{ route('categories') }}" class="dropdown-item">Categories</a></small>
                    <small><a href="{{ route('profile.main') }}" class="dropdown-item">Profile</a></small>
                    <small><a href="{{ route('freelancer.main') }}" class="dropdown-item">Freelancer</a></small>
                </ul>
                <ul class="navbar-nav align-items-md-start align-items-center justify-content-center gap-2 col-sm">
                    <small><a href="{{ route('notification') }}" class="dropdown-item">Notification</a></small>
                    <small><a href="#" class="dropdown-item">PortFolio</a></small>
                    <small><a href="#" class="dropdown-item">About</a></small>
                    <small><a href="#" class="dropdown-item">Contact</a></small>
                </ul>
                <ul class="navbar-nav align-items-md-start align-items-center justify-content-center gap-2 col-sm">
                    <small><a href="#" class="dropdown-item">Privacy Policy</a></small>
                    <small><a href="#" class="dropdown-item">FAQ</a></small>
                    <small><a href="#" class="dropdown-item">Term Of Service</a></small>
                    <small><a href="#" class="dropdown-item">Terms and Conditions</a></small>
                </ul>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between py-4 mt-4 border-top">
            <p class="text-dark" style="font-size: 13.5px;">&copy; 2023 Jobshort Inc.</p>
            <p class="text-dark" style="font-size: 13.5px;">Terms Of Service</p>
        </div>
    </footer>
</div>