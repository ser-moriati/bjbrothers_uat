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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="about_category_customer_name">Name <span class="required">*</span></label>
                                        <input type="text" name="about_category_customer_name" class="form-control" id="about_category_customer_name" placeholder="Name" value="{{@$about_aboutcatecustomer->about_category_customer_name}}" required>
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
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
@endsection