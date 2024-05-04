@extends('layouts.master')

@section('title') Career @endsection

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
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
            <form id="careerForm" action="{{$action}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
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
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="position">Position <span class="required">*</span></label>
                                            <input type="text" name="position" class="form-control" id="position" placeholder="Position" value="{{@$career->position}}" required> 
                                        </div>
                                    </div>
                                    <div class="col-md-8" id="workplace">
                                        <label for="workplace">Workplace <span class="required">*</span></label>
                                        @if (!@$career['workplace'])
                                            <div ids="1" class="inWorkP form-group row">
                                                <div class="col-md-10">
                                                    <input type="text" name="workplace[]" class="form-control" id="workplace1" placeholder="Workplace" required="">
                                                </div>
                                            </div>
                                        @else
                                        @foreach ($career['workplace'] as $key => $item)
                                            <div ids="{{$key}}" id="inWorkP{{$key}}" class="inWorkP form-group row">
                                                <div class="col-md-10">
                                                    <input type="text" name="workplace[]" class="form-control" id="workplace1" placeholder="Workplace" value="{{$item}}" required="">
                                                </div>
                                            @if ($key>0)
                                                <div class="col-md-2"><a href="javascript: void(0);" onclick='deleteWorkplace("{{$key}}")' class="text-danger"><i class="mdi mdi-delete font-size-22"></i></a></div>
                                            @endif
                                            </div>
                                        @endforeach
                                        @endif

                                    </div>
                                    <div class="col-md-6">
                                        <a type="button" style="color: white" class="btn btn-success mb-2" onclick="addWorkplace()">add row</a>
                                    </div>
                                    <div class="col-md-8" id="description">
                                        <label for="description">Description <span class="required">*</span></label>
                                        @if (!@$career['description'])
                                            <div ids="1" class="inDes form-group row">
                                                <div class="col-md-10">
                                                    <input type="text" name="description[]" class="form-control" id="description1" placeholder="Description" required="">
                                                </div>
                                            </div>
                                        @else
                                        @foreach ($career['description'] as $key => $item)
                                            <div ids="{{$key}}" id="inDes{{$key}}" class="inDes form-group row">
                                                <div class="col-md-10">
                                                    <input type="text" name="description[]" class="form-control" id="description1" placeholder="Description" value="{{@$item}}" required="">
                                                </div>
                                            @if ($key>0)
                                                <div class="col-md-2"><a href="javascript: void(0);" onclick='deleteDescription("{{$key}}")' class="text-danger"><i class="mdi mdi-delete font-size-22"></i></a></div>
                                            @endif
                                            </div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <a type="button" style="color: white" class="btn btn-success mb-2" onclick="addDescription()">add row</a>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                        <label for="elm1">Other</label>
                                        <textarea name="detail" id="elm1">{{@$career['detail']}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                            <div class="custom-file">
                                                <input name="banner" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$career->banner}}" @empty($career->banner) required @endempty >
                                                <label class="custom-file-label" for="customFile">@isset($career->banner) {{$career->banner}} @else Choose Picture @endisset</label>
                                            </div>
                                        <span class="required"> &nbsp; Suitable scale 650 x 900 pixels.</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="nameImg">Name image <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="{{pathinfo(@$career->banner, PATHINFO_FILENAME)}}" id="nameImg" name="banner_name" required>
                                        </div>
                                        {{-- <div class="col-md-12"> --}}
                                            <div class="form-group">
                                                <img class="img-thumbnail imagePreview"@if(!isset($career->banner)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/career/'.@$career->banner) }}" data-holder-rendered="true">
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                                    
                                {{-- <div class="row"> --}}
                                {{-- </div> --}}
                            </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metatitle">Meta Title</label>
                                    <input id="metatitle" name="meta_title" type="text" placeholder="Meta Title" class="form-control" value="{{@$career->meta_title}}">
                                </div>
                                <div class="form-group">
                                    <label for="metakeywords">Meta Keywords</label>
                                    <input id="metakeywords" name="meta_keywords" type="text" placeholder="Meta Keywords" class="form-control" value="{{@$career->meta_keywords}}">
                                </div>
                            </div>
        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metadescription">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Meta Description" rows="5">{{@$career->meta_description}}</textarea>
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
            function addWorkplace(){
                var inWorkP = $('.inWorkP:last-child').attr('ids');
                var id = inWorkP+1;
                $('#workplace').append('<div id="inWorkP'+id+'" ids="'+id+'" class="inWorkP form-group row">'+
                                            '<div class="col-md-10">'+
                                            '<input type="text" name="workplace[]" class="form-control" placeholder="Workplace" required="">'+
                                            '</div>'+
                                            '<div class="col-md-2"><a href="javascript: void(0);" onclick=deleteWorkplace("'+id+'") class="text-danger"><i class="mdi mdi-delete font-size-22"></i></a></div>');
            }
            function deleteWorkplace(id){
                $('#inWorkP'+id).remove();
            }
            function addDescription(){
                var inDes = $('.inDes:last-child').attr('ids');
                var id = inDes+1;
                $('#description').append('<div id="inDes'+id+'" ids="'+id+'" class="inDes form-group row">'+
                                            '<div class="col-md-10">'+
                                            '<input type="text" name="description[]" class="form-control" placeholder="Description" required="">'+
                                            '</div>'+
                                            '<div class="col-md-2"><a href="javascript: void(0);" onclick=deleteDescription("'+id+'") class="text-danger"><i class="mdi mdi-delete font-size-22"></i></a></div>');
            }
            function deleteDescription(id){
                $('#inDes'+id).remove();
            }
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