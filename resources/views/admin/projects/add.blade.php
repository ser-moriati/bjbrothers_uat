@extends('layouts.master')

@section('title') Project @endsection

@section('css') 
<style>
.img-wrap {
    position: relative;
}
.img-wrap .close {
    position: absolute;
    top: 2px;
    right: 4px;
    z-index: 100;
}
</style>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css')}}">
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
            <form id="projectForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
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
                        <input type="hidden" name="file_gallery_name" id="file_name">
                            <div class="row">
                                
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category <span class="required">*</span></label>
                                            <select required name="category_id" id="category" class="form-control">
                                                <option value="" selected hidden>Category</option>
                                                @foreach ($project_category as $item)
                                                    <option @if (isset($project->ref_category_id)) @if ($project->ref_category_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->project_category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    <div class="form-group">
                                        <label for="projectName">Name <span class="required">*</span></label>
                                        <input type="text" name="project_name" class="form-control" id="projectName" placeholder="name" value="{{@$project->project_name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="projectOwner">Owner</label>
                                        <input type="text" name="project_owner" class="form-control" id="projectOwner" placeholder="owner" value="{{@$project->project_owner}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="projectAddress">Address</label>
                                        <textarea type="text" name="project_address" class="form-control" id="projectAddress" placeholder="address" rows="3">{{@$project->project_address}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="projectDetail">Detail</label>
                                        <textarea type="text" name="project_detail" class="form-control" id="projectDetail" placeholder="detail" rows="8">{{@$project->project_detail}}</textarea>
                                    </div>
                                </div>
                                    
                                {{-- <div class="row"> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                            <div class="custom-file">
                                                <input name="project_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$project->project_image}}" @empty($project->project_image) required @endempty >
                                                <label class="custom-file-label" for="customFile">@isset($project->project_image) {{$project->project_image}} @else Choose Picture @endisset</label>
                                            </div>
                                        <span class="required"> &nbsp; Suitable scale 800 x 533 pixels.</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="nameImg">Name image <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="{{pathinfo(@$project->project_image, PATHINFO_FILENAME)}}" id="nameImg" name="project_image_name" required>
                                        </div>
                                        {{-- <div class="col-md-12"> --}}
                                            <div class="form-group">
                                                <img class="img-thumbnail imagePreview"@if(!isset($project->project_image)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/project/'.@$project->project_image) }}" data-holder-rendered="true">
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                {{-- </div> --}}
                            </div>
                    </div>
                </div>
                
                <div class="card" 
                {{-- @if (!@$project)
                style="pointer-events: none;opacity: 0.4;"
                @endif --}}
                >
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
                <div class="card" 
                {{-- @if (!@$project)
                style="pointer-events: none;opacity: 0.4;"
                @endif --}}
                >
                @if (@$project->gallerys)
                    <div class="card-body row">
                        @foreach ($project->gallerys as $gall)
                            <div class="col-sm-2 col-xl-1" id="gall{{$gall->id}}">
                                <div class="img-wrap">
                                    <span class="close"><a href="javascript: void(0);" onclick="deleteGallery('gall{{$gall->id}}')">&times;</a></span>
                                    <input type="hidden" name='last_gallery[]' value="{{$gall->id}}">
                                    <img class="img-thumbnail" src="{{ URL::asset('upload/project/gallerys/'.$gall->image_name) }}" data-holder-rendered="true">
                                </div>
                            </div>
                        @endforeach
                </div>
                @endif

                </div>
                        {{-- <h4 class="card-title">Meta Data</h4> --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metatitle">Meta Title</label>
                                    <input id="metatitle" name="meta_title" type="text" placeholder="Detailed Title" class="form-control" value="{{@$project->meta_title}}">
                                </div>
                                <div class="form-group">
                                    <label for="metakeywords">Meta Keywords</label>
                                    <input id="metakeywords" name="meta_keywords" type="text" placeholder="Detailed Keywords" class="form-control" value="{{@$project->meta_keywords}}">
                                </div>
                            </div>
        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metadescription">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Meta Description" rows="5">{{@$project->meta_description}}</textarea>
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
        
            {{-- <div class="row"@if (!isset($project))
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
        <script src="{{ URL::asset('admin/dropzone/5.5.1/dropzone.js')}}"></script>
        <script>
            
    document.getElementById("projectForm").addEventListener("submit", function(event){
        // event.preventDefault()
    })
            function deleteGallery(id){
                $('#'+id).remove();
            }
            function changeVDO(t) {
                $("#videoYoutube").attr("src", "https://www.youtube.com/embed/"+t);
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
                    url: "{{url('admin/project/uploadGallery')}}",
                    paramName : "file",
                    params: function params(files, xhr, chunk) { return { '_token' : "{{csrf_token()}}",'name':$('#projectName').val() }; },
                    uploadMultiple :false,
                    acceptedFiles : "image/*,video/*,audio/*",
                    addRemoveLinks: true,
                    forceFallback: false,
                    maxFilesize: 256, // Set the maximum file size to 256 MB
                    parallelUploads: 100,
                });
                
                // $.get("{{url('admin/project/gallery')}}/{{@$project->id}}", function(data) {
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
                    $('#file_name').val(imageDataArray);
                });
                uploader.on("removedfile", function(file) {
                    var rmvFile = "";
                    for (var f = 0; f < fileList.length; f++) {
                        if (fileList[f].fileName == file.name) {
                            // remove file from original array by database image name
                            imageDataArray.splice(imageDataArray.indexOf(fileList[f].serverFileName), 1);
                            $('#project_gallerys').val(imageDataArray);
                            // get removed database file name
                            rmvFile = fileList[f].serverFileName;
                            // get request to remove the uploaded file from server
                            $.get( "{{url('admin/project/deleteGallery')}}", { file: rmvFile } )
                            .done(function( data ) {
                                //console.log(data)
                            console.log(imageDataArray)

                            });
                            // reset imageDataArray variable to set value in crud form
                            $('#file_name').val(imageDataArray);
                            
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
@endsection