@extends('layouts.master')

@section('title') Project @endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
                        <?php if(!isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
            <div class="col-12">
                <form action="{{$action}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Save</button> &nbsp; &nbsp; 
                            <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                        </div>
                    </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoryName">Name</label>
                                    <input type="text" name="maintenance_category_name" class="form-control" id="categoryName"
                                        value="{{@$category->maintenance_category_name}}" placeholder="Name">
                                    {{-- <div class="invalid-feedback">
                                            Please provide a valid Category name.
                                        </div> --}}
                                </div>
                            </div>
                            {{-- <div class="row"> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                        <div class="custom-file">
                                            <input name="maintenance_category_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$category->maintenance_category_image}}" @empty($category->maintenance_category_image) required @endempty >
                                            <label class="custom-file-label" for="customFile">@isset($category->maintenance_category_image) {{$category->maintenance_category_image}} @else Choose Picture @endisset</label>
                                        </div>
                                    <span class="required"> &nbsp; Suitable scale 800 x 533 pixels.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="nameImg">Name image <span class="required">*</span></label>
                                        <input type="text" class="form-control" value="{{pathinfo(@$category->maintenance_category_image, PATHINFO_FILENAME)}}" id="nameImg" name="maintenance_category_image_name" required>
                                    </div>
                                    {{-- <div class="col-md-12"> --}}
                                        <div class="form-group">
                                            <img class="img-thumbnail imagePreview"@if(!isset($category->maintenance_category_image)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/maintenancecategory/'.@$category->maintenance_category_image) }}" data-holder-rendered="true">
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                            <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                            </div>
                        </div>
            </form>
            </div>
    </div>
    <!-- end row -->
</div>
<!-- end row -->
<!-- end modal -->
@endsection

@section('script')
<script>
    function imgChange(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            $('.imagePreview').show();
            reader.onload = function (e) {
                $('.imagePreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
        // readURL(input);
    }
</script>
<!-- plugin js -->
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>

@endsection