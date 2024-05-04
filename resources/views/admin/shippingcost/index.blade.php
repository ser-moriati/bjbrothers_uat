@extends('layouts.master')

@section('title') Contact @endsection

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
                        {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li> --}}
                        <?php if(isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-sm-12">
            <form action="{{$action}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">

            {{-- <div class="col-12"> --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="weight">Weight</label> (Kg)
                                <div class="form-group input-group">
                                    <input id="weight" name="weight" type="text" placeholder="weight" class="form-control" value="{{@$shippingcost->weight}}">
                                </div>
                                <label for="shipping_cost">Shipping Cost</label>
                                <div class="form-group input-group">
                                    <input id="shipping_cost" name="shipping_cost" type="text" placeholder="shipping_cost" class="form-control" value="{{@$shippingcost->shipping_cost}}">
                                </div>
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
    </div>
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
        <script>
            function productSelect(){
                var id = $('#product').val();
                $.ajax({
                    type: "POST",
                    url: "{{$module}}/select_product",
                    data:{
                        id:id,
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function( result ) {
                        var tr = '';
                        result.forEach(element => {
                            tr += '<tr><td><img width="50" src="{{ URL::asset("upload/product")}}/'+element.product_image+'"></td><td>'+element.product_code+'</td><td>'+element.product_name+'</td><td>'+element.product_price+'</td></tr>';
                        });
                        $('#listProduct').html(tr);
                            // total();
                        }   
                    });
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
            function readURL2(input) {
                const size =  
                    (input.files[0].size / 1024 / 1024).toFixed(2); 

                if (size > 2) { 
                    $('.custom-file-input').val(null);
                    alert("The image size must not exceed 2 MB."); 
                    return false;
                }
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    $('.imagePreview2').show();
                    reader.onload = function(e) {
                    $('.imagePreview2').attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            function imgChange2(t) {
                readURL2(t);
            }
        </script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection