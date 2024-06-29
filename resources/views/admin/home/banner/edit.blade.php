@extends('layouts.master')

@section('title') Home @endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<style>
    .search-box .form-control{
        padding-left:15px;
    }
    .search-box .search-icon {
        right: 13px;
        left: unset;
    }
</style>

@section('css') 

<!-- Lightbox css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}">

@endsection

<div class="container-fluid">
<input type="hidden" id='token' value="{{ csrf_token() }}">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li> --}}
                        <?php if(isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <form id="promotionForm" action="{{url('admin/home/update_banner')}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
            <div class="col-sm-12">
                <div class="form-group">
            <button class="btn btn-primary" id="submitBtn">Save</button>
                </div>
            </div>
            <div class="col-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @foreach( $row as $row)
                                <input type="hidden" name="id" value="{{ $row->banner_id}}">
                                <div class="form-group">
                                    <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                    <div class="custom-file">
                                        <input name="banner_name" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" @empty($row->banner_name) required @endempty >
                                        <label class="custom-file-label" for="customFile">@isset($row->banner_name) {{$row->banner_name}} @else Choose Picture @endisset</label>
                                    </div>
                                    <span class="required"> &nbsp; Suitable scale 1600 x 650 pixels</span>
                                </div>
                                <div class="form-group">
                                    <img class="img-thumbnail imagePreview"@if(!isset($row->banner_name)) style="display: none;" @endif src="{{ URL::asset('upload/home/'.@$row->banner_name) }}" data-holder-rendered="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nameImg">Name image <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{pathinfo(@$row->banner_name, PATHINFO_FILENAME)}}" id="nameImg" name="banner_name_name" required>
                                </div>
                                <div class="form-group">
                                        <label for="nameImg">URL <span class="required">*</span></label>
                                        <input type="text" class="form-control"  id="url" name="url" value="{{$row->banner_URL}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">ALT (for SEO)</label>
                                    <input type="text" class="form-control"  id="alt" name="alt" value="{{$row->banner_alt}}" >
                                </div>
                                @endforeach
                            </div>
                        </div>     
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
            <button class="btn btn-primary" id="submitBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
        <script>
          
            
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    $('.imagePreview').show();
                    reader.onload = function(e) {
                    $('.imagePreview').attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            function imgChange(t) {
                const size =  
                        (t.files[0].size / 1024 / 1024).toFixed(2); 

                    if (size > 2) { 
                        $('#customFile').val(null);
                         alert("The image size must not exceed 2 MB."); 
                         return false;
                    }
                readURL(t);
            }
        </script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection