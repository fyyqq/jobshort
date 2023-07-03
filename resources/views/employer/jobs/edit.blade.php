@extends('employer.layouts.app')

@section('content')
    <div class="container-employer pt-md-4 pt-3 px-lg-4 px-2">
        <div class="content">
            <div class="border rounded py-md-4 py-3 px-md-4 px-3 d-flex align-items-center justify-content-start gap-3" style="background-color: #fff;">
                <div class="py-1 px-2" style="cursor: pointer;" onclick="return goToPreviousPage()">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <h1 class="h4 text-dark mb-0 d-md-block d-none" style="font-size: 20px;">Update Service</h1>
                <h1 class="h4 text-dark mb-0 d-md-none d-block" style="font-size: 17px;">Update Service</h1>
            </div>
            <div class="mt-2 ps-md-5 ps-4 pe-3 py-4 border" id="create-jobs" style="background-color: #fff;">
                <form action="/account/freelancer/services/update/{{ $service->slug }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mx-0 col-12">
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Gallery :</label>
                            <div class="mt-2 w-100 d-flex align-items-center justify-content-start">
                                <div class="me-2 border border-dark rounded position-relative d-flex align-items-center justify-content-center {{ $service->video != null ? 'bg-secondary' : '' }}" style="height: 95px; width: 95px; overflow: hidden; cursor: pointer;">
                                    @if ($service->video != null)
                                        <i class="fa-solid fa-play text-light" style="font-size: 20px;"></i>
                                    @else
                                        <input type="file" name="video" id="profile-img" accept=".mp4">
                                    @endif
                                </div>
                                <div class="d-flex align-items-center justify-content-start" id="add-image-container">
                                    @foreach (explode(',', $service->image) as $key => $value)
                                        <div class="me-2 border border-dark rounded position-relative d-flex align-items-center justify-content-center" style="height: 95px; width: 95px; overflow: hidden; cursor: pointer;">
                                            @if ($service->image != null)
                                                <img src="{{ asset('images/' . $value) }}" class="w-100 h-100" style="object-fit: cover;">
                                            @else
                                                <input type="file" name="images[]" id="profile-img" accept=".png, .jpg, .jpeg">
                                                <i class="fa-solid fa-image" style="font-size: 18px;"></i>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="addImageContainer d-flex align-items-center justify-content-start"></div>
                                <div id="addImage" class="border border-dark rounded position-relative d-flex align-items-center justify-content-center" style="height: 95px; width: 95px; overflow: hidden; cursor: pointer;">
                                    <i class="fa-solid fa-plus" style="font-size: 18px;"></i>
                                </div>
                            </div>
                            <div id="emailHelp" class="mt-2 w-100 text-start form-text" style="font-size: 13px;">Support <b>MP4</b>, <b>JPG</b>, <b>JPEG</b> &  <b>PNG</b> file.</div>
                            @error('images')
                                <span class="text-start w-100 text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-8 col-12 row mx-0">
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Title :</label>
                            <input type="text" class="form-control shadow-none w-10" id="title" name="title" value="{{ $service->title ?? old('title') }}">
                            @error('title')
                                <span class="text-start w-100 text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="description" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Description :</label>
                            <textarea name="description" id="description" class="form-control w-100 shadow-none" rows="4">{{ $service->description ?? old('description') }}</textarea>
                            @error('description')
                                <span class="text-start w-100 text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Service Category :</label>
                            <div class="position-relative w-100">
                                <select name="category" id="" class="form-control shadow-none">
                                    <option value="">Find Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['name'] }}" {{ $category['name'] == $service->category ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-caret-down position-absolute" style="top: 50%; right: 10px; transform: translateY(-2px);"></i>
                            </div>
                            @error('category')
                                <span class="text-start w-100 text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-start justify-content-start flex-column">
                            <label for="price" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Price Per Service :</label>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="position-relative" id="lower_price">
                                    <div class="currency mb-0 text-dark">RM</div>
                                    <input type="number" class="ps-5 form-control shadow-none w-100" placeholder="How much you charge ?" name="price" value="{{ $service->price ?? old('price') }}">
                                </div>
                            </div>
                            <div id="emailHelp" class="mt-2 form-text" style="font-size: 13.5px;">Change your currency from profile page.</div>
                        </div>
                    </div>
                    <div class="w-100 text-md-start text-end">
                        <button type="submit" class="btn btn-sm btn-primary px-3">Update Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection