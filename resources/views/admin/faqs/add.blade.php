@extends('layouts.master')

@section('title') FAQ @endsection

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
                <form action="{{$action}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                      
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
                                    <label for="faqName">Name</label>
                                    <input type="text" name="faq_question" class="form-control" id="faqName"
                                        value="{{@$faq->faq_question}}" placeholder="Name">
                                    {{-- <div class="invalid-feedback">
                                            Please provide a valid Category name.
                                        </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="faqDetail">Detail</label>
                                    <textarea rows="4" name="faq_answer" class="form-control" id="faqDetail"
                                        placeholder="Detail">{{@$faq->faq_answer}}</textarea>
                                    {{-- <div class="invalid-feedback">
                                            Please provide a valid Category name.
                                        </div> --}}
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
    </div>
    <!-- end row -->
</div>
<!-- end row -->
<!-- end modal -->
@endsection

@section('script')
<script>
    function imgChange(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            $('.imagePreview').show();
            reader.onload = function (e) {
                $('.imagePreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
        // readURL(input);
    }
</script>
<!-- plugin js -->
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>

@endsection