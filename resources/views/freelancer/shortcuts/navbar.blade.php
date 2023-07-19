<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<nav class="navbar navbar-expand bg-light py-3 shadow-sm d-md-none d-flex fixed-top">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('freelancer.main') }}" style="font-size: 13.8px;">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('freelancer.order') }}" style="font-size: 13.8px;">Order</a>
                </li>
                <li class="nav-item dropdown" style="cursor: pointer;">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"style="font-size: 13.8px;">Service</a>
                    <ul class="dropdown-menu dropdown-menu-left py-0" style="overflow: hidden;">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('freelancer.services') }}" style="font-size: 12.5px;">Services</a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('freelancer.create-service') }}" style="font-size: 12.5px;">Create</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex align-items-center justify-content-center" style="column-gap: 25px;">
                <a href="{{ route('freelancer.create-service') }}" class="text-decoration-none">
                    <i class="fa-solid fa-plus text-muted" style="font-size: 15px;"></i>
                </a>
                <a href="{{ route('freelancer.notification') }}" class="text-decoration-none">
                    <i class="fa-regular fa-bell text-muted" style="font-size: 15px;"></i>
                </a>
                <li class="nav-item dropdown d-flex align-items-center">
                    <div class="rounded-circle border" style="height: 40px; width: 40px; overflow: hidden; cursor: pointer;" data-bs-toggle="dropdown">
                        <img src="{{ is_null(auth()->user()->freelancer->image) ? asset('brand/unknown.png') : asset('images/' . auth()->user()->freelancer->image) }}" class="w-100 h-100" style="object-fit: cover;" loading="lazy">
                    </div>
                    <ul class="dropdown-menu border border-1 p-0" style="transform: translate(-120px, 5px); width: 160px;">
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('freelancer.profile') }}" style="font-size: 12.5px;">Profile</a>
                        </li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.main') }}" style="font-size: 12.5px;">Main</a>
                        </li>
                        <li>
                            <span class="dropdown-item pt-2 pb-1" href="#">
                                <div class="ps-0 form-check form-switch d-flex justify-content-between flex-row-reverse">
                                    <input class="form-check-input shadow-none" type="checkbox" id="darkmode">
                                    <label for="darkmode" class="text-start" style="font-size: 12.5px;">Dark Mode</label>
                                </div>
                            </span>
                        </li>
                        <li>
                            <a class="dropdown-item py-2 row mx-0" href="" style="font-size: 12.5px;">Settings</a>
                        </li>
                        <div class="dropdown-divider my-0"></div>
                        <li>
                            <span class="dropdown-item py-2" id="btn-logout" href="" onclick="event.preventDefault(); return logout()" style="font-size: 12.5px; cursor: pointer;">{{ __('Logout') }}</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>


<script>
    function logout() {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-sm px-3 py-2 btn-primary',
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Confirm Logout ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            position: 'center',
            confirmButtonText: 'Logout',
            showCloseButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>