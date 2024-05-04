@extends('layouts.master')

@section('title') About @endsection

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
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css')}}">
<link rel="stylesheet" href="{{ URL::asset('admin/dropzone/5.5.1/dropzone.css')}}">
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
                        {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">about</a></li> --}}
                        <?php if(isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                            <form id="about_companyForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="elm1">บริการของเรา</label>
                                                        <textarea class="summernote" id="elm1">{{@$about_service->detail}}</textarea>
                                                        <input type="hidden" id="detail" name="detail" value="{{@$about_service->detail}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="elm1">วิธีการสั่งซื้อ</label>
                                                        <textarea class="summernote2" id="elm1">{{@$about_service->detail_2}}</textarea>
                                                        <input type="hidden" id="detail_2" name="detail_2" value="{{@$about_service->detail_2}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="elm1">วิธีการชำระเงิน</label>
                                                        <textarea class="summernote3" id="elm1">{{@$about_service->detail_3}}</textarea>
                                                        <input type="hidden" id="detail_3" name="detail_3" value="{{@$about_service->detail_3}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="elm1">วิธีการจัดส่ง</label>
                                                        <textarea class="summernote4" id="elm1">{{@$about_service->detail_4}}</textarea>
                                                        <input type="hidden" id="detail_4" name="detail_4" value="{{@$about_service->detail_4}}">
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
        </div>
    </div>
    
@include('layouts/modal')
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        {{-- <script src="{{ URL::asset('admin/dropzone-5.7.0/dist/dropzone.js')}}"></script> --}}
        {{-- <script src="{{ URL::asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script> --}}
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js')}}"></script>

        <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <!-- form repeater js -->
        <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
        <script>
            $('.summernote').summernote({
                height: 300
            }).on('summernote.change', function(we, contents, $editable) {
                $('#detail').val(contents);
                // console.log(contents);
            });
            $('.summernote2').summernote({
                height: 300
            }).on('summernote.change', function(we, contents, $editable) {
                $('#detail_2').val(contents);
                // console.log(contents);
            });
            $('.summernote3').summernote({
                height: 300
            }).on('summernote.change', function(we, contents, $editable) {
                $('#detail_3').val(contents);
                // console.log(contents);
            });
            $('.summernote4').summernote({
                height: 300
            }).on('summernote.change', function(we, contents, $editable) {
                $('#detail_4').val(contents);
                // console.log(contents);
            });
        </script>
@endsection