@extends('layouts.master')

@section('title') Quotation @endsection

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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-9">
                            <form method="GET" action="{{$page_url}}">
                                <div class="col-sm-3 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                    <input type="search" class="form-control" name="quotation_number" placeholder="Number..." value="{{@$query['quotation_number']}}">
                                        {{-- <i class="fas fa-times search-icon"></i> --}}
                                    </div>
                                </div>
                                <div class="col-sm-3 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="search" class="form-control" name="customer_name" placeholder="Customer name..." value="{{@$query['customer_name']}}">
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-2 d-inline-block">
                                        <button style="background-color: #556ee6; color:white" class="btn btn-rounded waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; search</button>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="col-sm-3">
                            <div class="text-sm-right">
                                <a href="{{$page_url}}/add" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> New {{$page}}</a>
                            </div>
                        </div><!-- end col--> --}}
                        <div class="col-sm-12 btnDeleteAll" style="display: none">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="btnDeleteAll()"><i class="mdi mdi-delete mr-1"></i> Delete all</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th width='1px' style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll"></label>
                                        </div>
                                    </th>
                                    <th width='1px'>#</th>
                                    <th>Quotation Number</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Qty Total</th>
                                    <th>View Details</th>
                                    <th>print</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{$value->number}}</a> </td>
                                    <td>{{$value->member_firstname}} {{$value->member_lastname}}</td>
                                    <td>
                                        {{date('d/m/Y', strtotime($value->created_at))}}
                                    </td>
                                    <td align="center">
                                        {{$value->qty_total}}
                                        {{-- ฿{{number_format($value->quotation_products->sum->quotation_total,2)}} --}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="modal({{$value}})">
                                          View Details
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{url('admin/quotation/pdf',$value->id)}}" class="mr-3 text-primary" target="_blank">print</a>
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
    


    <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="detailOrder">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Order number : <span class="text-primary" id="mOrderNumber"></span></p>
                    <p class="mb-4">Customer : <span class="text-primary" id="mCustomer"></span></p>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead>
                                <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody id="trProduct">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@include('layouts/modal')
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
<script>
    function modal(v){
        $('#mOrderNumber').html(v.number);
        $('#mCustomer').html(v.member_firstname+' '+v.member_lastname);
        $.ajax({
            type: "get",
            url: "{{url('get_modal')}}/"+v.number,
            dataType: "html",
            success: function(html) {
                $('#trProduct').html(html);
                $('#detailOrder').modal('show');
            },
            error: function() {
                // ดำเนินการเมื่อเกิดข้อผิดพลาดในการส่งคำขอ
                console.log('เกิดข้อผิดพลาดในการส่งคำขอ');
            }        
        });  
    }
</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection