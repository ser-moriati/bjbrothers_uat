@extends('layouts.master')

@section('title') Banner @endsection

@section('css') 
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css')}}">


@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
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
            <form id="newsForm" action="{{url('admin/home/insert/banner')}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                {{-- <h4 class="card-title">Basic Information</h4> --}}
    <div class="col-sm-12">
        <div class="form-group">
            <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                </div>
            </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                    <div class="custom-file">
                                        <input name="title_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$news->title_image}}" @empty($news->title_image) required @endempty >
                                        <label class="custom-file-label" for="customFile">@isset($news->title_image) {{$news->title_image}} @else Choose Picture @endisset</label>
                                    </div>
                                    <span class="required"> &nbsp; Suitable scale 800 x 533 pixels.</span>
                                </div>
                                <div class="form-group">
                                    <img class="img-thumbnail imagePreview"@if(!isset($news->title_image)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/news/'.@$news->title_image) }}" data-holder-rendered="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nameImg">Name image <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{pathinfo(@$news->title_image, PATHINFO_FILENAME)}}" id="nameImg" name="title_image_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">URL <span class="required">*</span></label>
                                    <input type="text" class="form-control"  id="url" name="url" required>
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">ALT (for SEO)</label>
                                    <input type="text" class="form-control"  id="alt" name="alt">
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
        </div><br>
        </div>
    </div>
    <!-- end row -->
</div>

                        <!-- end row -->
                <!-- end modal -->
@endsection
@section('script')
        <script>
            function readURL(input) {
                const size =  
                    (input.files[0].size / 1024 / 1024).toFixed(2); 

                if (size > 2) { 
                    $('.custom-file-input').val(null);
                    alert("The image size must not exceed 2 MB."); 
                    return false;
                }
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
                readURL(t);
            }
        </script>
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>


        <script src="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('ckfinder/ckfinder.js')}}"></script>

        <script>

        var editor = CKEDITOR.replace('elm1');
        CKFinder.setupCKEditor( editor );

        </script>
@endsection