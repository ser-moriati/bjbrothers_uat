@extends('layouts.master')

@section('title') Brand @endsection

@section('css') 

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}">

@endsection

@section('content')
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-brand-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
                        <?php if(!isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
                    <form action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="">
            <div class="card">
                <div class="card-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            {{-- <div data-repeater-list="outer-group" class="outer">
                                <div data-repeater-item class="outer">
                                    <div class="inner-repeater mb-12">
                                        <div data-repeater-list="inner-group" class="inner form-group">
                                            
                                            <div data-repeater-item=""> --}}
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="brandName">Brand name <span class="required">*</span></label>
                                                        <input type="text" name="brand_name" class="form-control" id="brandName" value="{{@$brand->brand_name}}" placeholder="Brand name" required>
                                                            <div class="invalid-feedback">
                                                                Please provide a valid Brand name.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="delete">&nbsp;</label>
                                                            {{-- <div class="col-md-3"> --}}
                                                                {{-- <input data-repeater-delete="" type="button" class="btn btn-primary btn-block inner" value="Delete"> --}}
                                                            {{-- </div> --}}
                                                        {{-- </div>
                                                    </div> --}}
                                                </div>
                                                {{-- 
                                            </div>
                                        </div>
                                        <input data-repeater-create="" type="button" class="btn btn-success inner" value="Add Number">
                                    </div>
                                </div>
                            </div> --}}
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

    <!-- end row -->
</div>
                        <!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
        {{-- <script src=""></script> --}}

        <!-- Calendar init -->
        <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script> 
@endsection