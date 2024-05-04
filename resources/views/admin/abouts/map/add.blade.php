@extends('layouts.master')

@section('title') About @endsection

@section('css') 

<!-- Lightbox css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}">
{{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css')}}"> --}}
<link rel="stylesheet" href="{{ URL::asset('admin/dropzone/5.5.1/dropzone.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}">
@endsection

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
                        {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">Year/li> --}}
                        <?php if(!is_null($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <form id="about_companyForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                    <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="elm1">ชื่อ</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{@$about_map->name}}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="elm1">รายละเอียด</label>
                                <textarea name="detail" class="summernote" id="elm1">{{@$about_map->detail}}</textarea>
                                {{-- <textarea id="product_description" name="product_description" class="summernote">{{@$product->product_description}}</textarea> --}}
                                {{-- <input type="hidden" id="detail" name="detail" value="{{@$about_map->detail}}"> --}}
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
        </div><br>
        </div>
    </div>
    <!-- end row -->
</div>

                        <!-- end row -->
                <!-- end modal -->
@endsection
@section('script')

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        {{-- <script src="{{ URL::asset('admin/dropzone-5.7.0/dist/dropzone.js')}}"></script> --}}
        {{-- <script src="{{ URL::asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script> --}}
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js')}}"></script>

        <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
        {{-- <script src="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.js')}}"></script> --}}
        <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <!-- form repeater js -->
        <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>

        <script type="text/javascript" src="{{ URL::asset('ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('ckfinder/ckfinder.js')}}"></script>

        <script>

        var editor = CKEDITOR.replace('elm1');
        CKFinder.setupCKEditor( editor );

        </script>


@endsection