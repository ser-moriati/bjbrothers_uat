@extends('layouts.master')

@section('title') Home @endsection

@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <style>
        .search-box .form-control {
            padding-left: 15px;
        }

        .search-box .search-icon {
            right: 13px;
            left: unset;
        }

    </style>

@section('css')

    <!-- Lightbox css -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css') }}">

@endsection

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{ $page }}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        {{-- <li class="breadcrumb-item"><a
                                href="javascript: void(0);">Product</a></li> --}}
                        <?php if (isset($page_before)) {
                        echo "<li class='breadcrumb-item active'>$page_before</li>";
                        } ?>
                        <li class="breadcrumb-item active">{{ $page }}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Product</h4>

                    <div class="text-center">
                        <div class="mb-4">
                            <i class="bx bx-box text-primary display-4"></i>
                        </div>
                        <h3>{{ number_format($total_product) }}</h3>
                        {{-- <p>San Francisco</p> --}}
                    </div>

                    <div class="table-responsive mt-4">
                        <table class="table table-centered table-nowrap">
                            <tbody>
                                @foreach ($category as $cate)                                    
                                <tr>
                                    <td style="width: 50px">
                                        <img style="background: #555555; margin:-8px" width="40" src="{{ URL::asset('upload/category/'.$cate->category_image)}}">
                                    </td>
                                    <td style="width: 60%">
                                        <p class="mb-0">{{$cate->category_name}}</p>
                                    </td>
                                    <td style="width: 25%">
                                        <h5 class="mb-0">{{$cate->product_total}}</h5>
                                    </td>
                                    {{-- <td>
                                        <div class="progress bg-transparent progress-sm">
                                            <div class="progress-bar bg-primary rounded" role="progressbar"
                                                style="width: 94%" aria-valuenow="94" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </td> --}}
                                </tr>    
                                @endforeach                                
                                <tr>
                                    <td>
                                        <p class="mb-0"></p>
                                    </td>
                                    <td style="width: 60%">
                                        <p class="mb-0">No type</p>
                                    </td>
                                    <td style="width: 25%">
                                        <h5 class="mb-0">{{$product_not_cate}}</h5>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
           
                <div class="col-md-4">
                    <a href="https://www.bjbrothers.com/admin/order?order_number=&customer_name=&status_id=">  
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Orders</p>
                                        <h4 class="mb-0 float-sm-left">{{ number_format($total_order) }}</h4> <span class="font-size-5"> &nbsp; orders</span>
                                    </div>

                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                                        <span class="avatar-title">
                                            <i class="bx bx-copy-alt font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                @foreach ($order_status as $order_sta)        
                         
                    <div class="col-md-4">
                        <a href="https://www.bjbrothers.com/admin/order?order_number=&customer_name=&status_id={{$order_sta->id}}">  
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="text-muted font-weight-medium"><span style="background-color: {{$order_sta->color_background}};color: {{$order_sta->color_code}}" class="badge badge-pill font-size-12">{{$order_sta->status_name}}</span></p>
                                            <h4 class="mb-0 float-sm-left">{{ number_format($order_sta->order_total) }}</h4> <span class="font-size-5"> &nbsp; orders</span>
                                        </div>

                                        <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                            <span class="avatar-title rounded-circle bg-primary">
                                                <i class="{{$order_sta->icon}} font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>    
                    </div>
                
                @endforeach

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="media">
                                        <div class="mr-3">
                                            <i class="bx bxs-user-detail text-primary display-4"></i>
                                            {{-- <img src="assets/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle img-thumbnail"> --}}
                                        </div>
                                        <div class="media-body align-self-center">
                                            <a href="https://www.bjbrothers.com/admin/member">
                                                <div class="text-muted">
                                                    <h5 class="mb-2">Customer</h5>
                                                    <p class="mb-0 font-size-16">{{ number_format($total_member) }} &nbsp; clients</p>
                                                </div>
                                            </a>    
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-5 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            @foreach ($member_category as $member_cate)   
                                        
                                                <div class="col-3">
                                                <a href="https://www.bjbrothers.com/admin/member?member_name=&company_name=&category_id={{$member_cate->id}}">
                                                    <div>
                                                        <p class="text-muted mb-2">{{$member_cate->category_name}}</p>
                                                        <h5 class="mb-0">{{ number_format($member_cate->member_total) }}</h5>
                                                    </div>
                                                </a>
                                                </div>
                                        
                                            @endforeach
                                            <div class="col-3">
                                                <a href="https://www.bjbrothers.com/admin/member/new">
                                                    <div>
                                                        <p class="text-muted mb-2">สมาชิกใหม่</p>
                                                        <h5 class="mb-0">{{ number_format($total_member_new) }}</h5>
                                                    </div>
                                                </a>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                 
                <div class="col-md-3">
                <a href="https://www.bjbrothers.com/admin/promotion">    
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">News and promotions</p>
                                    <h4 class="mb-0 float-sm-left">{{ number_format($promotion_total) }}</h4> <span class="font-size-5"> &nbsp; orders</span>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bxs-news font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>       
                <div class="col-md-3">
                <a href="https://www.bjbrothers.com/admin/project">    
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Project</p>
                                    <h4 class="mb-0 float-sm-left">{{ number_format($project_total) }}</h4> <span class="font-size-5"> &nbsp; orders</span>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="bx bx-briefcase-alt-2 font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                                    </a>
                </div>
                <div class="col-md-3">
                    <a href="https://www.bjbrothers.com/admin/faq">    
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Faq</p>
                                        <h4 class="mb-0 float-sm-left">{{ number_format($faq_total) }}</h4> <span class="font-size-5"> &nbsp; orders</span>
                                    </div>

                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-news font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>   
                </div>
                <div class="col-md-3">
                    <a href="https://www.bjbrothers.com/admin/faq">    
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-muted font-weight-medium">Contact new</p>
                                        <h4 class="mb-0 float-sm-left">{{ number_format($total_Subscribe_new) }}</h4> <span class="font-size-5"> &nbsp; contact</span>
                                    </div>

                                    <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-news font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>   
                </div>
            </div>
    <!-- end row -->
    <!-- end modal -->
@endsection

@section('script')
    <script>
        function productSelect() {
            var id = $('#product').val();
            $.ajax({
                type: "POST",
                url: "{{ $module }}/select_product",
                data: {
                    id: id,
                    '_token': "{{ csrf_token() }}",
                },
                success: function(result) {
                    var tr = '';
                    result.forEach(element => {
                        tr += '<tr><td><img width="50" src="{{ URL::asset('
                        upload / product ') }}/' + element.product_image + '"></td><td>' + element
                            .product_code + '</td><td>' + element.product_name + '</td><td>' +
                            element.product_price + '</td></tr>';
                    });
                    $('#listProduct').html(tr);
                    // total();
                }
            });
        }

        function changeVDO(t) {
            $("#videoYoutube").attr("src", "https://www.youtube.com/embed/" + t);
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
    <!-- Magnific Popup-->
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-element.init.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js') }}"></script>

    <!-- lightbox init js-->
    <script src="{{ URL::asset('assets/js/pages/lightbox.init.js') }}"></script>
@endsection
