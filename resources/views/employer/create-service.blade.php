@extends('employer.layouts.app')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

@section('content')
    <div class="container-employer pt-md-4 pt-3 px-lg-4 px-2">
        <div class="content">
            <div class="border rounded py-4 py-3 px-4" style="background-color: #fff;">
                <h1 class="h4 text-dark mb-0 d-md-block d-none" style="font-size: 20px;">Create Service</h1>
                <h1 class="h4 text-dark mb-0 d-md-none d-block" style="font-size: 17px;">Create Service</h1>
            </div>
            <div class="mt-2 ps-md-5 ps-4 pe-3 py-4 border" id="create-jobs" style="background-color: #fff;">
                <form action="{{ route('employer.post-service') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mx-0 col-12">
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Service Gallery :</label>
                            <div class="mt-2 w-100 d-flex align-items-center justify-content-start" id="add-image-container">
                                <div class="me-2 border border-dark rounded position-relative d-flex align-items-center justify-content-center" style="height: 95px; width: 95px; overflow: hidden;">
                                    <img src="" class="w-100 h-100 d-none" style="object-fit: cover;">
                                    <input type="file" name="images[]" id="profile-img" accept=".png, .jpg, .jpeg" onchange="return autoImage(this)">
                                    <i class="fa-solid fa-image" style="font-size: 18px;"></i>
                                    <i class="p-1 fa-solid fa-xmark position-absolute d-none" style="font-size: 13px; top: 0; right: 0;"></i>
                                </div>
                                <div class="addImageContainer d-flex align-items-center justify-content-start"></div>
                                <div id="addImage" class="border border-dark rounded position-relative d-flex align-items-center justify-content-center" style="height: 95px; width: 95px; overflow: hidden; cursor: pointer;">
                                    <i class="fa-solid fa-plus" style="font-size: 18px;"></i>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div id="emailHelp" class="mt-2 w-100 text-start form-text" style="font-size: 13px;">Support <b>MP4</b>, <b>JPG</b>, <b>JPEG</b> &  <b>PNG</b> file.</div>
                                <div id="emailHelp" class="mt-2 w-100 text-end text-dark form-text" style="font-size: 13px;"><span id="lengthImg">1</span> | 15</div>
                            </div>
                            @error('images')
                                <span class="text-start w-100 text-danger mt-2" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12 row mx-0">
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Service Title :</label>
                            <input type="text" class="form-control shadow-none w-10" id="title" name="title" value="{{ old('title') }}">
                            @error('title')
                                <span class="text-start w-100 text-danger mt-2" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="description" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Service Description :</label>
                            <textarea name="description" id="description" class="form-control w-100 shadow-none" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-start w-100 text-danger mt-2" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Service Category :</label>
                            <div class="position-relative w-100">
                                <select name="category" id="" class="form-control shadow-none">
                                    <option value="" selected>Find Service Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['name'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-caret-down position-absolute" style="top: 50%; right: 10px; transform: translateY(-2px);"></i>
                            </div>
                            @error('category')
                                <span class="text-start w-100 text-danger mt-2" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-start justify-content-start flex-column">
                            <label for="price" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Price :</label>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="position-relative">
                                    <span class="currency mb-0 text-dark px-2">RM</span>
                                    <input type="number" class="ps-5 form-control shadow-none w-100" name="price" value="{{ old('price') }}">
                                </div>
                            </div>
                            <div id="emailHelp" class="mt-2 form-text" style="font-size: 13px;">Change your currency from profile page.</div>
                        </div>
                    </div>
                    <div class="w-100 text-md-start text-end">
                        <button type="submit" class="btn btn-sm btn-primary px-3">Post Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
