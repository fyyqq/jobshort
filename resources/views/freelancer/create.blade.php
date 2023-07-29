@extends('freelancer.layouts.app')


@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <div class="container-employer pt-4 px-lg-4 px-2">
        <div class="content">
            <div class="border rounded py-md-4 py-3 px-md-4 px-3 d-flex align-items-center justify-content-start gap-3" style="background-color: #fff;">
                <div class="py-1 px-2" style="cursor: pointer;" onclick="return goToPreviousPage()">
                    <i class="fa-solid fa-chevron-left"></i>
                </div>
                <h1 class="h4 text-dark mb-0" style="font-size: 17px;">Create Service</h1>
            </div>
            <div class="mt-2 ps-md-5 ps-4 pe-3 py-4 border" id="create-jobs" style="background-color: #fff;">
                <form action="{{ route('freelancer.post-service') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row mx-0 col-12">
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column" style="overflow: hidden;">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Gallery :</label>
                            <div class="mt-2 w-100 d-flex align-items-center justify-content-start" id="add-image-container">
                                <div class="d-flex" id="child-container">
                                    <div>
                                        <div class="me-2 border border-secondary rounded position-relative d-flex align-items-center justify-content-center" id="serviceImage">
                                            <i class="mdi mdi-sync position-absolute text-light d-none" style="font-size: 25px; top: 50%; left: 50%; transform: translate(-50%, -50%);"></i>
                                            <img src="" class="w-100 h-100 d-none" style="object-fit: cover;" loading="lazy">
                                            <i class="mdi mdi-image" style="font-size: 25px;"></i>
                                            <input type="file" name="images[]" id="profile-img" accept=".png, .jpg, .jpeg" onchange="return insertImage(this)">
                                            {{-- icon remove image --}}
                                            <span class="text-light position-absolute p-1 d-none" id="delete_image" style="top: 0; right: 0;">
                                                <i class="fa-solid fa-xmark" style="font-size: 11px;"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="addImageContainer d-flex align-items-center justify-content-start"></div>
                                    <div>
                                        <div id="addImage" data-bs-toggle="tooltip" title="Add Images" class="border border-secondary rounded position-relative d-flex align-items-center justify-content-center">
                                            <i class="fa-solid fa-plus" style="font-size: 18px;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2 d-flex align-items-start justify-content-between w-100">
                                <div class="d-flex align-items-start flex-column">
                                    <div id="emailHelp" class="text-start form-text lh-1" style="font-size: 12.5px;">Support <b>JPG</b>, <b>JPEG</b> &  <b>PNG</b> file.</div>
                                    <div id="emailHelp" class="text-start form-text" style="font-size: 12.5px;"><b>5</b> images required.</div>
                                </div>
                                <div id="emailHelp" class="text-end form-text" style="font-size: 12.5px;"><span id="lengthImg">1</span> | 15</div>
                            </div>
                            @if($errors->has('images'))
                                <span class="text-start w-100 text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $errors->first('images') }}</small>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 col-12 row mx-0">
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Title :</label>
                            <input type="text" class="form-control shadow-none w-10" id="title" name="title" value="{{ old('title') }}">
                            @error('title')
                                <span class="text-start w-100 text-danger mt-1" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="description" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Description :</label>
                            <textarea name="description" id="description" class="form-control w-100 shadow-none" rows="6">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-start w-100 text-danger mt-2" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="title" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Category :</label>
                            <div class="position-relative w-100">
                                <select name="category" id="" class="form-control shadow-none">
                                    <option value="" selected>Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['slug'] }}" {{ old('category') === $category['name'] ? 'selected' : '' }}>{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-caret-down position-absolute" style="top: 50%; right: 10px; transform: translateY(-2px);"></i>
                            </div>
                            @error('category')
                                <span class="text-start w-100 text-danger mt-1" role="alert">
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
                            @error('price')
                                <span class="text-start w-100 text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="w-100 text-md-start text-end">
                        <button type="submit" class="btn btn-sm btn-primary px-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    @if(session('error'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1800
            });
        </script>
    @endif
@endsection

