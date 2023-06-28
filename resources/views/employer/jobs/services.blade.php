@extends('employer.jobs.layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

@section('service-pages')
        <div class="px-sm-3 px-0 mb-3">
            <div class="row mx-0 border py-3 rounded" style="background-color: #fff;">
                <div class="col-1 text-center d-flex align-items-center justify-content-center">
                    <input type="checkbox" name="" id="select-all-jobs" class="" onclick="allJobs()">
                </div>
                <div class="col-2 d-flex align-items-center justify-content-start">
                    <p class="mb-0">Image</p>
                </div>
                <div class="col-3 d-flex align-items-center justify-content-start">
                    <p class="mb-0">Title</p>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-start">
                    <p class="mb-0">Category</p>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <p class="mb-0">Price</p>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <p class="mb-0">Action</p>
                </div>
            </div>
            <div class="mt-2">
                <div class="w-100 row mx-0" style="row-gap: 7px;">
                    @foreach ($services as $service)
                        <div class="row mx-0 border py-2 rounded" style="background-color: #fff;">
                            <div class="col-1 text-center d-flex align-items-center justify-content-center">
                                <input type="checkbox" name="" id="select-jobs">
                                <input type="hidden" name="slug" value="{{ $service->slug }}">
                            </div>
                            <div class="col-2">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded" style="height: 76px; width: 76px; overflow: hidden;">
                                        @foreach (explode(',', $service->image) as $key => $value)
                                            @if ($key === 0)
                                                <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;">
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 d-flex align-items-center justify-content-start">
                                <p class="mb-0">{{ Str::limit($service->title, 15) }}</p>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-start">
                                <p class="mb-0">{{ $service->category }}</p>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-center">
                                <p class="mb-0">RM {{ $service->price }}</p>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-center flex-column" style="row-gap: 5px;">
                                {{-- <div class="dropdown border rounded-circle d-flex align-items-center justify-content-center" style="height: 40px; width: 40px; cursor: pointer;" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                    <ul class="dropdown-menu dropdown-menu-end" style="background-color: #fff; z-index: 999;">
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('jobs', $service->slug) }}">View</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2" href="{{ route('employer.edit-jobs', $service->slug) }}">Edit</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('employer.delete-jobs', $service->slug) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2">Delete</button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('employer.update-archive-jobs', $service->slug) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="dropdown-item py-2">Archive</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div> --}}
                                <a href="{{ route('jobs', $service->slug) }}" class="badge text-light text-decoration-none bg-primary">view</a>
                                <a href="{{ route('employer.edit-jobs', $service->slug) }}" class="badge text-dark text-decoration-none bg-warning">edit</a>
                                <form action="{{ route('employer.delete-jobs', $service->slug) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="badge bg-danger border-0">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-100 d-flex align-items-center justify-content-end {{ count($services) < 1 ? 'd-none' : 'd-flex mt-3' }}">
                <button class="btn btn-md btn-danger px-4" onclick="deleteSelectedItems()">Delete</button>
            </div>
        </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
