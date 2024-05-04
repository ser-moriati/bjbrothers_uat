@extends('layouts.master')

@section('title') Category @endsection

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
                <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                    <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <img class="img-thumbnail" style="background: #555555;" alt="{{@$category->category_image}}"
                                width="100" src="{{ URL::asset('upload/category/'.@$category->category_image) }}"
                                data-holder-rendered="true">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="categoryName">Name <span class="required">*</span></label>
                                    <input type="text" name="category_name" class="form-control" id="categoryName"
                                        value="{{@$category->category_name}}" placeholder="Name" required>
                                    {{-- <div class="invalid-feedback">
                                            Please provide a valid Category name.
                                        </div> --}}
                                </div>
                                <div class="form-group">
                                    <label for="categoryDetail">Detail</label>
                                    <textarea rows="4" name="category_detail" class="form-control" id="categoryDetail"
                                        placeholder="Detail">{{@$category->category_detail}}</textarea>
                                    {{-- <div class="invalid-feedback">
                                            Please provide a valid Category name.
                                        </div> --}}
                                </div>
                                <div class="form-group">
                                    <label>Banner <span class="required">* The image size must not exceed 2 MB.</span></label>
                                    <div class="custom-file">
                                        <input name="banner_image" type="file" class="custom-file-input" accept="image/*" id="customFile"
                                            onchange="imgChange(this,1)" value="{{@$category->banner_image}}"
                                            @empty($category->banner_image) required @endempty>
                                        <label class="custom-file-label"
                                            for="customFile">@isset($category->banner_image) {{$category->banner_image}}
                                            @else Choose Picture @endisset</label>
                                    </div>
                                    <span class="required"> &nbsp; Suitable scale 500 x 600 pixels.</span>
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">Name image <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{pathinfo(@$category->banner_image, PATHINFO_FILENAME)}}" id="nameImg" name="banner_image_name" required>
                                </div>
                                {{-- <div class="col-md-12"> --}}
                                <div class="form-group">
                                    <img class="img-thumbnail imagePreview1" @if(!isset($category->banner_image))
                                    style="display: none;" @endif alt="200x200"
                                    src="{{ URL::asset('upload/category/'.@$category->banner_image) }}"
                                    data-holder-rendered="true">
                                </div>
                        </div>
                        <div class="col-md-6">
                            {{-- </div> --}}
                            
                            <div class="form-group">
                                <label>Image (home) <span class="required">* The image size must not exceed 2 MsssB.</span></label>
                                <div class="custom-file">
                                    <input name="image_home" type="file" class="custom-file-input" accept="image/*" id="customFile"
                                        onchange="imgChange(this,2)" value="{{@$category->image_home}}"
                                        @empty($category->image_home) required @endempty>
                                    <label class="custom-file-label"
                                        for="customFile">@isset($category->image_home) {{$category->image_home}}
                                        @else Choose Picture @endisset</label>
                                </div>
                                <span class="required"> &nbsp; Suitable scale 1200 x 600 pixels.</span>
                            </div>
                            <div class="form-group">
                                <label for="nameImg">Name image <span class="required">*</span></label>
                                <input type="text" class="form-control" value="{{pathinfo(@$category->image_home, PATHINFO_FILENAME)}}" id="nameImg" name="image_home_name" required>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <img class="img-thumbnail imagePreview2" @if(!isset($category->image_home))
                                style="display: none;" @endif alt="200x200"
                                src="{{ URL::asset('upload/category/'.@$category->image_home) }}"
                                data-holder-rendered="true">
                            </div>
                        </div>
                        </div>
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
    function imgChange(input,id) {
        const size =  
                (input.files[0].size / 1024 / 1024).toFixed(2); 

            if (size > 2) { 
                $('.custom-file-input').val(null);
                 alert("The image size must not exceed 2 MB."); 
                 return false;
            }
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            $('.imagePreview'+id).show();
            reader.onload = function (e) {
                $('.imagePreview'+id).attr('src', e.target.result);
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