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
                                                        <label for="elm1">แผนที่</label>
                                                        <input type="text" class="form-control" id="detail" name="detail" oninput="iframeMap(this.value)" value="{{@$about->detail}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <iframe id="iframeMap" src="{{ @$about->detail }}" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>รูปภาพ
                                                            <span class="required">* The image size must not exceed 2 MB.</span></label>
                                                        <div class="custom-file">
                                                            <input name="image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$about->image}}" @empty($about->image) required @endempty >
                                                            <label class="custom-file-label" for="customFile">@isset($about->image) {{$about->image}} @else Choose Picture @endisset</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <img class="img-thumbnail imagePreview"@if(!isset($about->image)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/about/'.@$about->image) }}" data-holder-rendered="true">
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="about_companyName">Detail</label>
                                                        <textarea type="text" name="about_company_detail" class="form-control" id="about_companyName" rows="5" placeholder="Detail">{{@$about_company->about_company_detail}}</textarea>
                                                    </div>
                                                </div>--}}
                                                <script>
                                                    function iframeMap(value){
                                                        $('#iframeMap').attr('src',value)
                                                    }
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();
                                                            $('.imagePreview').show();
                                                            reader.onload = function(e) {
                                                            $('.imagePreview').attr('src', e.target.result);
                                                            }
                                                            
                                                            reader.readAsDataURL(input.files[0]); // convert to base64 string
                                                            var nameImg = $('#nameImg').val();
                                                            if(nameImg == ''){
                                                                var aboutCode = $('#aboutCode').val();
                                                                var aboutName = $('#aboutName').val();
                                                                
                                                                $('#nameImg').val(aboutCode+'_'+aboutName);
                                                            }
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-12" style="display: flex">
                            <div class="col-sm-6">
                                <h5>
                                    <b>ประวัติบริษัท</b>
                                </h5>
                            </div>
                            <div class="col-sm-6 text-sm-right">
                                <a href="{{$page_url}}/add" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> New {{$page}}</a>
                            </div>
                        </div><!-- end col-->
                        <div class="col-sm-12 btnDeleteAll" style="display: none">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="btnDeleteAll()"><i class="mdi mdi-delete mr-1"></i> Delete all</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th width="50%">Name</th>
                                    <th>Create</th>
                                    <th>Update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkbox-list" onchange="checkList()" id="customCheck{{$num}}" value="{{$value->id}}">
                                            <label class="custom-control-label" for="customCheck{{$num}}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->updated_at}}</td>
                                    <td>
                                        <a href="{{$page_url}}/edit/{{$value->id}}" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                        <a href="javascript: void(0);" onclick="deleteFromTable({{$value->id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @include('layouts/data-notfound')
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">Showing &nbsp;<b>{{$from}}</b>&nbsp; to &nbsp;<b>{{$to}}</b>&nbsp; of &nbsp;<b>{{$total}}</b>&nbsp; entries</div>
                        <ul class="pagination pagination-rounded justify-content-end col-sm-6 mb-2">
                        {{  $list_data->links() }}
                        </ul>
                    </div>
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
                $('#business').val(contents);
                // console.log(contents);
            });
            $('.summernote2').summernote({
                height: 300
            }).on('summernote.change', function(we, contents, $editable) {
                $('#factory').val(contents);
                // console.log(contents);
            });
        </script>
@endsection