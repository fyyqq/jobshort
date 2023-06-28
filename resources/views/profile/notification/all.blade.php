@extends('profile.layouts.app')

@section('profile')
    <header class="px-4 border" style="background-color: #fff;">
        <div class="pb-3 pt-4">
            <h1 class="h5 mb-0 text-dark">Notifications</h1>
        </div>
        <div class="row mx-0 mt-2">
            <ul class="mb-0 ps-0 d-flex align-items-center justify-content-start" style="list-style: none;">
                <li class="nav-item">
                    <a style="font-size: 14.5px; padding-bottom: 15px;" href="{{ route('profile.notification-all') }}" class="nav-link me-2 px-4 {{ Route::currentRouteName() == 'profile.notification-all' ? 'text-primary border-2 border-bottom border-primary' : 'text-muted' }}">All</a>
                </li>
                <li class="nav-item">
                    <a style="font-size: 14.5px; padding-bottom: 15px;" href="" class="nav-link me-1 px-2 text-muted">Following</a>
                </li>
                <li class="nav-item">
                    <a style="font-size: 14.5px; padding-bottom: 15px;" href="" class="nav-link px-4 text-muted">Saved</a>
                </li>
            </ul>
        </div>
    </header>
    <section class="">
        <div class="row mx-0 border" style="background-color: #fff; height: max-content;">
            <div class="col-sm-1 col-2 py-3 ps-3 pe-2 d-flex align-items-center justify-content-center">
                <div class="rounded-circle bg-secondary border" style="height: 45px; width: 45px;"></div>
            </div>
            <div class="col-sm-10 col-9 py-3">
                <div class="d-flex align-items-start justify-content-start flex-column">
                    <p class="mb-0"> <a href="" class="text-decoration-none text-dark mb-0 fw-bold">{{ auth()->user()->username }}</a> Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <small class="mb-0 text-muted mt-1" style="font-size: 13px;">12/2/2018</small>
                </div>
            </div>
            <div class="col-1 d-flex align-items-center justify-content-center">
                <div class="dropstart rounded-circle d-flex align-items-center justify-content-center pe-sm-0 pe-3" style="height: 30px; width: 30px; cursor: pointer;" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                    <ul class="dropdown-menu rounded-0 py-0">
                        <li>
                            <span class="dropdown-item py-2 d-flex align-items-center justify-content-start" style="font-size: 14px;">
                                <div class="col-2"><i class="fa-solid fa-check"></i></div>
                                <div class="col-10">Mark As Read</div>
                            </span>
                        </li>
                        <li>
                            <span class="dropdown-item py-2 d-flex align-items-center justify-content-start" style="font-size: 14px;">
                                <div class="col-2"><i class="fa-solid fa-bookmark"></i></div>
                                <div class="col-10">Saved</div>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
