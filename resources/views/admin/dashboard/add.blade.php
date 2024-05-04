@extends('layouts.master')

@section('title') Home @endsection

@section('css') 

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css')}}">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css"> --}}
<link rel="stylesheet" href="{{ URL::asset('admin/dropzone/5.5.1/dropzone.css')}}">
{{-- <script src="{{ URL::asset('admin/dropzone-5.7.0/dist/dropzone.css')}}"></script> --}}
        
{{-- <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css"> --}}
        {{-- <link href="{{ URL::asset('assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css" /> --}}
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}">

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
            <form id="productForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                {{-- <h4 class="card-title">Basic Information</h4> --}}
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="productCode">Product Code <span class="required">*</span></label>
                                        <input type="text" name="product_code" class="form-control" id="productCode" placeholder="Product code" value="{{@$product->product_code}}" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="productName">Product name <span class="required">*</span></label>
                                        <input type="text" name="product_name" class="form-control" id="productName" placeholder="Product name" value="{{@$product->product_name}}" required="">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_price">Price <span class="required">*</span></label>
                                                <input type="number" name="product_price" class="form-control" id="product_price" placeholder="Price" value="{{@$product->product_price}}" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_version">Version</label>
                                                <input type="text" name="product_version" class="form-control" id="product_version" placeholder="Version" value="{{@$product->product_version}}">
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                {{-- <div class="row"> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Picture <span class="required">*</span></label>
                                            <div class="custom-file">
                                                <input name="product_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$product->product_image}}" @empty($product->product_image) required @endempty >
                                                <label class="custom-file-label" for="customFile">@isset($product->product_image) {{$product->product_image}} @else Choose Picture @endisset</label>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-12"> --}}
                                            <div class="form-group">
                                                <img class="img-thumbnail imagePreview"@if(!isset($product->product_image)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/product/'.@$product->product_image) }}" data-holder-rendered="true">
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                {{-- </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category <span class="required">*</span></label>
                                        <select required name="category_id" id="category" class="form-control">
                                            <option value="" selected hidden>Category</option>
                                            @foreach ($category as $item)
                                                <option @if (isset($product->ref_category_id)) @if ($product->ref_category_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->category_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid Category.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subCategory">Sub category <span class="required">*</span></label>
                                        <select required name="sub_category_id" id="subCategory" class="form-control">
                                            <option value="" selected hidden>Sub category</option>
                                            @foreach ($sub_category as $item)
                                                <option @if (isset($product->ref_sub_category_id)) @if ($product->ref_sub_category_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->sub_category_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid Sub category.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="brand">Brand <span class="required">*</span></label>
                                        <select required name="brand_id" id="brand" class="form-control">
                                            <option value="" selected hidden>Brand</option>
                                            @foreach ($brand as $item)
                                                <option @if (isset($product->ref_brand_id)) @if ($product->ref_brand_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->brand_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid Brand.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="product_sizes">Product Size</label>
                                        <select name="product_sizes[]" id="product_sizes" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                                        @foreach ($size as $value)
                                            <option value="{{$value->id}}" @if(isset($product)) @if (in_array($value->id,$product->product_sizes)) selected @endif @endif >{{$value->size_name}}</option>
                                        @endforeach    
                                        
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="product_colors">Product Color</label>
                                        <select name="product_colors[]" id="product_colors" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                                        @foreach ($color as $value)
                                            <option value="{{$value->id}}" @if(isset($product)) @if (in_array($value->id,$product->product_colors)) selected @endif @endif >{{$value->color_name}}</option>
                                        @endforeach    
                                        
                                        </select>

                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                        {{-- <h4 class="card-title">Description</h4> --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="productVideo">Video</label><br><span class="card-title-desc">https://www.youtube.com/watch?v=</span><span style="color: red">ET9SHYzMz_4</span>
                                    <input type="text" name="product_video" onkeyup="changeVDO(this.value)" class="form-control" id="productVideo" placeholder="ET9SHYzMz_4" value="{{@$product->product_video}}">
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                        {{-- <label for="productVideo">&nbsp;</label> --}}
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="videoYoutube" class="embed-responsive-item" src="https://www.youtube.com/embed/{{@$product->product_video}}"></iframe>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                <label for="elm1">Detailed Description</label>
                                {{-- <textarea name="product_description" class="summernote" id="productDescription" placeholder="Detailed Description">{{@$product->product_description}}</textarea> --}}
                                <textarea name="product_description" id="elm1">{{@$product->product_description}}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-10">
                                <div class="form-group">

                                    <label>File</label>
                                    @isset($product->product_files)
                                        @foreach ($product->product_files as $item)
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden" name="product_file_id[]" class="btn btn-default" value="{{$item->id}}"/>
                                                            <mark>{{$item->file_name}}</mark>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="button" class="btn btn-primary btn-block inner" value="Delete"/>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endisset
                                    {{-- <div class="col-md-10">
                                        <div class="form-group"> --}}
                                            <div data-repeater-list="outer-group" class="outer">
                                                <div data-repeater-item class="outer">
                                                    <div class="inner-repeater">
                                                        <div data-repeater-list="inner-group" class="inner form-group">
                                                            {{-- <label>File</label> --}}
                                                            <div data-repeater-item class="inner mb-3 row">
                                                            <div class="col-md-6">
                                                                <div class="custom-file">
                                                                    <input type="file" name="product_file" class="form-control" accept=".pdf">
                                                                    {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}
                                                                </div>
                                                            </div>
                                                                <div class="col-md-2 col-4">
                                                                    <input data-repeater-delete type="button" class="btn btn-primary btn-block inner" value="Delete"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input data-repeater-create type="button" class="btn btn-success inner" value="Add Number"/>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        {{-- <h4 class="card-title">Meta Data</h4> --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metatitle">Meta Title</label>
                                    <input id="metatitle" name="meta_title" type="text" placeholder="Detailed Title" class="form-control" value="{{@$product->meta_title}}">
                                </div>
                                <div class="form-group">
                                    <label for="metakeywords">Meta Keywords</label>
                                    <input id="metakeywords" name="meta_keywords" type="text" placeholder="Detailed Keywords" class="form-control" value="{{@$product->meta_keywords}}">
                                </div>
                            </div>
        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metadescription">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Meta Description" rows="5">{{@$product->meta_description}}</textarea>
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
        
        <div class="card" @if (!@$product)
        style="pointer-events: none;opacity: 0.4;"
        @endif>
            <div class="card-body">

                <h4 class="card-title">Gallerys</h4>

                {{-- <div> --}}
                    <div class="dropzone" id="my-dropzone">
                    {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">                                     --}}
                        <div class="dz-message needsclick">
                            <div class="mb-3">
                                <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                            </div>
                            
                            <h4>Drop files here or click to upload.</h4>
                        </div>
                    </div>
                {{-- </div> --}}

            </div>
        </div>
            {{-- <div class="row"@if (!isset($product))
                style="
                pointer-events: none;
                opacity: 0.4;"
            @endif>
                <div class="col-12"> --}}
                {{-- </div> <!-- end col -->
            </div> <!-- end row --> --}}
            {{-- <button class="btn btn-primary" id="submitBtn" onclick="submit()">Save</button> --}}

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
        {{-- <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script> --}}
        <script src="{{ URL::asset('admin/dropzone/5.5.1/dropzone.js')}}"></script>
        {{-- <script>
            $(document).ready(function(){
                $("#submitBtn").click(function(e){
                        $("#productForm").submit();
                    // $(this).hide();
                });
            });
            $("input").on('keyup', function (e) {
                if (e.keyCode === 13) {
                        $("#productForm").submit();
                }
            });
        </script> --}}
        <script>
            // $("#productForm").submit(function(event){
            //     event.preventDefault(); //prevent default action 
            //     var post_url = $(this).attr("action"); //get form action url
            //     var request_method = $(this).attr("method"); //get form GET/POST method
            //     var form_data = $(this).serialize(); //Encode form elements for submission
                
            //     $.ajax({
            //         url : post_url,
            //         type: request_method,
            //         data : form_data
            //     }).done(function(response){ //
            //         // $("#server-results").html(response);
                    
            //     });
            // });
            function gh(t){
                console.log(t.value);
            }
            function changeVDO(t) {
                $("#videoYoutube").attr("src", "https://www.youtube.com/embed/"+t);
            }
            
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
                readURL(t);
            }
        </script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            Dropzone.autoDiscover = false;
            var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
            // imageDataArray variable to set value in crud form
            var imageDataArray = new Array;
            // fileList variable to store current files index and name
            var fileList = new Array;
            var i = 0;
            $(function(){
                uploader = new Dropzone(".dropzone",{
                    url: "{{url('admin/product/uploadGallery')}}/{{@$product->id}}",
                    paramName : "file",
                    params: function params(files, xhr, chunk) { return { '_token' : "{{csrf_token()}}" }; },
                    uploadMultiple :false,
                    acceptedFiles : "image/*,video/*,audio/*",
                    addRemoveLinks: true,
                    forceFallback: false,
                    maxFilesize: 256, // Set the maximum file size to 256 MB
                    parallelUploads: 100,
                });
                
                // $.get("{{url('admin/product/gallery')}}/{{@$product->id}}", function(data) {
                //     $.each(data, function(key,value){
                //     console.log(key);
                //         // return 
                //         var mockFile = { name: value.name, size: value.size };
                        
                //         thisDropzone.options.addedfile.call(thisDropzone, mockFile);
        
                //         thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "uploads/"+value.name);
                        
                //     });
                // });
                //end drop zone
                // return console.log(uploader);
                uploader.on("success", function(file,response) {
                    // console.log(fileList);
                    imageDataArray.push(response)
                    fileList[i] = {
                        "serverFileName": response,
                        "fileName": file.name,
                        "fileId": i
                    };
                    // console.log(response);
                    i += 1;
                    // $('#tew').html('<input type="file" name="files_u" value="'+response+'">');
                });
                uploader.on("removedfile", function(file) {
                    var rmvFile = "";
                    for (var f = 0; f < fileList.length; f++) {
                        if (fileList[f].fileName == file.name) {
                            // remove file from original array by database image name
                            imageDataArray.splice(imageDataArray.indexOf(fileList[f].serverFileName), 1);
                            $('#product_gallerys').val(imageDataArray);
                            // get removed database file name
                            rmvFile = fileList[f].serverFileName;
                            // get request to remove the uploaded file from server
                            $.get( "{{url('admin/product/deleteGallery')}}/{{@$product->id}}", { file: rmvFile } )
                            .done(function( data ) {
                                //console.log(data)
                            });
                            // reset imageDataArray variable to set value in crud form
                            
                            // console.log(imageDataArray)
                        }
                    }
                    
                });
            });
        </script>
        <!-- plugin js -->
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
        <script type="text/javascript" src="{{ URL::asset('ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('ckfinder/ckfinder.js')}}"></script>

        <script>

        var editor = CKEDITOR.replace('elm1');
        CKFinder.setupCKEditor( editor );

        </script>
@endsection