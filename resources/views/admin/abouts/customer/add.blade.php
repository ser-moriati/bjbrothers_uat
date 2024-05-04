@extends('layouts.master')

@section('title') About @endsection

@section('css') 

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
            <form id="about_customerForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                    <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                                {{-- <div class="row"> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                            <div class="custom-file">
                                                <input name="about_customer_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$about_customer->about_customer_image}}" @empty($about_customer->about_customer_image) required @endempty >
                                                <label class="custom-file-label" for="customFile">@isset($about_customer->about_customer_image) {{$about_customer->about_customer_image}} @else Choose Picture @endisset</label>
                                            </div>
                                            <span class="required"> &nbsp; Suitable scale 500 x 330 pixels.</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="nameImg">Name image <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="{{pathinfo(@$about_customer->about_customer_image, PATHINFO_FILENAME)}}" id="nameImg" name="about_customer_image_name" required>
                                        </div>
                                        {{-- <div class="col-md-12"> --}}
                                            <div class="form-group">
                                                <img class="img-thumbnail imagePreview"@if(!isset($about_customer->about_customer_image)) style="display: none;" @endif alt="{{@$about_customer->about_customer_image}}" width="200" src="{{ URL::asset('upload/about/aboutcustomer/'.@$about_customer->about_customer_image) }}" data-holder-rendered="true">
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                {{-- </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_customer_name">Name <span class="required">*</span></label>
                                        <input type="text" name="about_customer_name" class="form-control" id="about_customer_name" placeholder="Name" value="{{@$about_customer->about_customer_name}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category <span class="required">*</span></label>
                                        <select required name="category_id" id="category" class="form-control">
                                            <option value="" selected hidden>Category</option>
                                            @foreach ($category as $item)
                                                <option @if (isset($about_customer->ref_category_id)) @if ($about_customer->ref_category_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->about_category_customer_name}}</option>
                                            @endforeach
                                        </select>
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
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
@endsection