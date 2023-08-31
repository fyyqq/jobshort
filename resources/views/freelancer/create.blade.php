@extends('freelancer.layouts.app')


@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <div class="container-freelancer pt-4 px-lg-4 px-2">
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
                            <input type="text" class="form-control shadow-none w-10" id="title" name="title" value="{{ old('title') }}" placeholder="Service Title">
                            @error('title')
                                <span class="text-start w-100 text-danger mt-1" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label for="description" class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Description :</label>
                            <textarea name="description" id="description" class="form-control w-100 shadow-none" rows="6" placeholder="Service Description">{{ old('description') }}</textarea>
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
                        <div class="mb-3 ps-0 d-flex align-items-start justify-content-start flex-column">
                            <label for="price" class="form-label w-100 mb-2 text-start" style="font-size: 13.5px;">Price :</label>
                            <div class="w-100">
                                <div class="input-group position-relative">
                                    <span class="input-group-text" data-bs-target="tooltip" title="Only USD currency is accepted in the payment system*">$</span>
                                    <input type="number" step="any" class="form-control shadow-none" name="price" value="{{ old('price') }}" style="transform: translateY(0px);" placeholder="How much you charge ?">
                                    <i class="mdi mdi-information-outline position-absolute info_price" style="top: 50%; right: 10px; transform: translateY(-50%);"></i>
                                    <div class="px-3 py-2 info_price_text rounded-3 border shadow-sm">we will increase the service fee by <b>10%</b> for each product you post on our platform. This increase aims to improve the quality and safety of our services for you and the buyers.</div>
                                    <div id="price_loader"></div>
                                </div>
                                <div class="d-flex align-items-center justify-content-start gap-1 ps-1 d-none" id="fees">
                                    <i class="mdi mdi-check-bold text-success" style="transform: translateY(2px);"></i>
                                    <div class="form-text text-success" style="font-size: 13px;">Include fees : <span id="price_fee"></span></div>
                                    <input type="hidden" name="price_after_fee">
                                </div>
                            </div>
                            @error('price')
                                <span class="text-start w-100 text-danger" role="alert">
                                    <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-4 ps-0 d-flex align-items-center justify-content-start flex-column">
                            <label class="form-label w-100 mb-1 text-start" style="font-size: 13.5px;">Delivery Duration (day) :</label>
                            <div class="d-flex align-items-center justify-content-start w-100 gap-3">
                                <div class="d-flex align-items-start justify-content-center flex-column w-100">
                                    <input type="number" id="delivery_input" class="form-control shadow-none w-10" id="min_delivery" name="min_delivery" value="{{ old('min_delivery') }}" placeholder="Minimum Day">
                                    @error('min_delivery')
                                        <span class="text-start w-100 text-danger" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <i class="mdi mdi-swap-horizontal"></i>
                                <div class="d-flex align-items-start justify-content-center flex-column w-100">
                                    <input type="number" id="delivery_input" class="form-control shadow-none w-10" id="max_delivery" name="max_delivery" value="{{ old('max_delivery') }}" placeholder="Maximum Day">
                                    @error('max_delivery')
                                        <span class="text-start w-100 text-danger" role="alert">
                                            <small class="fw-bold" style="font-size: 12px;">{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="{{ old('min_delivery') || old('max_delivery') ? 'd-flex' : 'd-none' }} align-items-center justify-content-start ps-1 mt-1 w-100 gap-1" id="delivery">
                                <i class="mdi mdi-check-bold text-success" style="transform: translateY(2px);"></i>
                                <div class="form-text text-success" style="font-size: 13px;">Delivery : <span id="delivery_duration">{{ old('min_delivery') || old('max_delivery') ? old('min_delivery') . ' - ' . old('max_delivery') : '0' }}</span> days</div>
                            </div>
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

