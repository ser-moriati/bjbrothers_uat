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
            <form id="shippingForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
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
                                        <label for="shippingName">bank name <span class="required">*</span></label>
                                        <input type="text" name="bank_name" class="form-control" id="bank_name" placeholder="name" value="{{@$bank->bank_name}}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="shippingDetail">bank number</label>
                                        <textarea type="text" name="bank_number" class="form-control" id="bank_number" placeholder="detail">{{@$bank->bank_number}}</textarea>
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
        
            {{-- <div class="row"@if (!isset($shipping))
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
            
    document.getElementById("shippingForm").addEventListener("submit", function(event){
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
                    url: "{{url('admin/shipping/uploadGallery')}}",
                    paramName : "file",
                    params: function params(files, xhr, chunk) { return { '_token' : "{{csrf_token()}}",'name':$('#shippingName').val() }; },
                    uploadMultiple :false,
                    acceptedFiles : "image/*,video/*,audio/*",
                    addRemoveLinks: true,
                    forceFallback: false,
                    maxFilesize: 256, // Set the maximum file size to 256 MB
                    parallelUploads: 100,
                });
                
                // $.get("{{url('admin/shipping/gallery')}}/{{@$shipping->id}}", function(data) {
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
                            $('#shipping_gallerys').val(imageDataArray);
                            // get removed database file name
                            rmvFile = fileList[f].serverFileName;
                            // get request to remove the uploaded file from server
                            $.get( "{{url('admin/shipping/deleteGallery')}}", { file: rmvFile } )
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