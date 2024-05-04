@extends('layouts.master')

@section('title') Order @endsection

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
    .right-aligned {
        text-align: right;
        max-width: 8ch;
        overflow: hidden;
   }
   .fullscreen {
        margin: 4%;
        top: 0;
        left: 0;
        min-width: 90% !important;
        height: 100% !important;
    }
   
        .hidden {
            display: none;
        }
  
</style>
<!-- Include SweetAlert CSS and JS files -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>


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
                        <div class="col-sm-12">
                            <form method="GET" action="{{$page_url}}">
                                <div class="col-sm-2 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                    <input type="search" class="form-control" name="order_number" placeholder="order number..." value="{{@$query['order_number']}}">
                                        {{-- <i class="fas fa-times search-icon"></i> --}}
                                    </div>
                                </div>
                                <div class="col-sm-2 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="search" class="form-control" name="customer_name" placeholder="customer name..." value="{{@$query['customer_name']}}">
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-2 mb-2 d-inline-block">
                                    <select name="status_id" class="form-control">
                                        <option value="">Status</option>
                                        @foreach($status as $sta)
                                            <option @empty(!@$query['status_id']) @if($sta->id == $query['status_id']) selected @endif @endempty value="{{$sta->id}}">{{$sta->status_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 mb-2 d-inline-block">
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
                                <tr align="center">
                                    {{-- <th width='1px' style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll"></label>
                                        </div>
                                    </th> --}}
                                    <th width='1px'>#</th>
                                    <th>Order Number</th>
                                    <th>Customer Name</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th style="width: 100px;">Status</th>
                                    <th>Payment Method</th>
                                   
                                    <th>Update</th>
                                    <th>Payment</th>
                                    <th>Success</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    {{-- <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td> --}}
                                    <td>{{$num++}}</td>
                                    <td><a onclick="modal({{$value}})" class=" text-primary font-weight-bold" style="text-decoration: underline; color: blue;">{{$value->order_number}}</a></td>

                                    <td>{{$value->member_firstname}} {{$value->member_lastname}}</td>
                                    <td>
                                        {{date('d/m/Y', strtotime($value->created_at))}}
                                    </td>
                                    <td>
                                        ฿{{number_format($value->order_products->sum->order_total,2)}}
                                    </td>
                                    <td>
                                    @php
                                    $log = DB::table('log')
                                    ->leftJoin('order_status', 'order_status.id', '=', 'log.status')
                                    ->leftJoin('users', 'users.id', '=', 'log.user_id')
                                    ->where('log.id_order', $value->id)
                                    ->select('users.name as users_name', 'order_status.status_name as status_name','log.status as statusid')
                                    ->get();
                                    @endphp

                                    <a onclick="modal_log({{$log}})" style="cursor: pointer;" >    <span style="background-color: {{$value->color_background}};color: {{$value->color_code}}" class="badge badge-pill font-size-12">
                                     @if($value->ref_order_status_id == 7){{$value->status_name}} ( Admin )
                                     @elseif($value->ref_order_status_id == 2)
                                     {{$value->status_name}} ( Admin )
                                     @elseif($value->ref_order_status_id == 3)
                                     {{$value->status_name}} ( Super Admin )
                                     @elseif($value->ref_order_status_id == 4)
                                     {{$value->status_name}} ( Admin )
                                     @else
                                     {{$value->status_name}}
                                     @endif   
                                    </span></a>
                                        
                                        {{-- <div class="col-sm-3 mt-2 mb-2 d-inline-block">
                                            <select onchange="subCateByCate(this.value)" name="status_id" class="form-control">
                                                @foreach($status as $cate)
                                                    <option @empty(!@$query['status_id']) @if($cate->id == $query['status_id']) selected @endif @endempty value="{{$cate->id}}">{{$cate->status_name}}</option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                    </td>
                                    <!-- <td>
                                        {{$value->payment_name}}
                                    </td> -->
                                    <td>
                                        ชำระเงินผ่านการโอนเงิน
                                    </td>
                                   
                                    <td>
                                        @if($value->ref_order_status_id == 7)
                                        <button type="button" class="btn btn-warning btn-sm btn-rounded" onclick="modal_edit({{$value}})">
                                                <i class='bx bx-edit'></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn  btn-secondary btn-sm btn-rounded" onclick="modal_edit({{$value}})" disabled>
                                                <i class='bx bx-edit'></i>
                                        </button>
                                        @endif
                                    </td>
                                    <td>   
                                        @if($value->ref_order_status_id == 1)
                                            @if(empty($value->transfer_date))
                                                <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="modal_Payment({{$value}})" disabled>
                                                        <i class='bx bxs-credit-card'></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn  btn-secondary btn-sm btn-rounded" onclick="modal_Payment({{$value}})">
                                                        <i class='bx bxs-credit-card'></i>
                                                </button>
                                            @endif
                                        @elseif($value->ref_order_status_id == 2)
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="modal_Payment({{$value}})">
                                                <i class='bx bxs-credit-card'></i>
                                        </button>
                                        @elseif($value->ref_order_status_id == 3)
                                        <button type="button" class="btn btn-warning btn-sm btn-rounded" onclick="modal_Payment({{$value}})">
                                                <i class='bx bxs-credit-card'></i>
                                        </button>
                                        @else
                                        <button type="button" class="btn  btn-secondary btn-sm btn-rounded" onclick="modal_Payment({{$value}})" disabled>
                                                <i class='bx bxs-credit-card'></i>
                                        </button>
                                        @endif   


                                    </td>
                                    <td>
                                        @if($value->ref_order_status_id == 1)
                                        <button type="button" class="btn  btn-success btn-sm btn-rounded" onclick="ChangStatus({{$value->id}},4)" disabled>
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                        </button>
                                        @endif
                                        @if($value->ref_order_status_id == 2)
                                        <button type="button" class="btn  btn-success btn-sm btn-rounded" onclick="ChangStatus({{$value->id}},4)" disabled>
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                        </button>
                                        @endif
                                        @if($value->ref_order_status_id == 3)
                                        <button type="button" class="btn  btn-success btn-sm btn-rounded" onclick="ChangStatus({{$value->id}},4)" disabled>
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                        </button>
                                        @endif
                                        @if($value->ref_order_status_id == 4)
                                            <button type="button" class="btn  btn-warning btn-sm btn-rounded" onclick="ChangStatusSuccess({{$value->id}},4)">
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                            </button>
                                        @endif
                                        @if($value->ref_order_status_id == 8)
                                            <button type="button" class="btn  btn-danger btn-sm btn-rounded" onclick="modal_cancel({{$value}})">
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                            </button>
                                        @endif
                                        @if($value->ref_order_status_id == 5)
                                            <button type="button" class="btn   btn-secondary btn-sm btn-rounded" onclick="ChangStatus({{$value->id}},4)" disabled>
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                            </button>
                                        @endif
                                        
                                        @if($value->ref_order_status_id == 6)
                                        <button type="button" class="btn  btn-success btn-sm btn-rounded" onclick="ChangStatus({{$value->id}},4)" disabled>
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                        </button>
                                        @endif 
                                        @if($value->ref_order_status_id == 7)
                                        <button type="button" class="btn  btn-success btn-sm btn-rounded" onclick="ChangStatus({{$value->id}},4)" disabled>
                                            <i class=" mdi mdi-check-circle font-size-14"></i>
                                              
                                        </button>
                                        @endif
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2 mb-2">Order number : </div><div class="col-4 text-primary" id="mOrderNumber"></div>
                        <div class="col-1 mb-2">Email : </div><div class="col-5 text-primary" id="mOrderEmail"></div>
                        <div class="col-2 mb-2">Customer : </div><div class="col-4 text-primary" id="mCustomer"></div>
                        <div class="col-1 mb-2">Tel : </div><div class="col-5 text-primary" id="mOrderTel"></div>
                        <div class="col-2 mb-2">Shipping : </div><div class="col-10 text-primary" id="ShippingAddress"></div>
                        <div class="col-2 mb-2">TaxID : </div><div class="col-10 text-primary" id="member_TaxID"></div>
                        <div class="col-2 mb-2">หลักฐานการชำระ : </div>
                        <div class="col-10">
                            <span class="text-primary" id="imgdetail"></span>
                           
                        </div>
                        <div class="col-2 mb-2">ใบเสร็จ : </div>
                        <div class="col-10">
                            <span class="text-primary" id="filedetail"></span>
                           
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-centered table-nowrap col-9">
                            <thead>
                                <tr>
                                <th width="100px" scope="col">Image</th>
                                <th scope="col">Product Name</th>
                                <th width="1px" scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody id="trProduct">
                                
                            </tbody>
                        </table>

                        <table class="table table-centered table-nowrap col-3">
                            <thead>
                                <tr style="text-align: center;">
                                    <th colspan="2">Summary</th>
                                </tr>
                            </thead>
                            <tbody id="trProduct_summary">
                        
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
    <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="detailOrde_cancel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2 mb-2">Order number : </div><div class="col-4 text-primary" id="mOrderNumber_cancel"></div>
                        <div class="col-1 mb-2">Email : </div><div class="col-5 text-primary" id="mOrderEmail_cancel"></div>
                        <div class="col-2 mb-2">Customer : </div><div class="col-4 text-primary" id="mCustomer_cancel"></div>
                        <div class="col-1 mb-2">Tel : </div><div class="col-5 text-primary" id="mOrderTel_cancel"></div>
                        <div class="col-2 mb-2">Shipping : </div><div class="col-10 text-primary" id="ShippingAddress_cancel"></div>
                        <div class="col-2 mb-2">TaxID : </div><div class="col-10 text-primary" id="member_TaxID_cancel"></div>
                        <div class="col-2 mb-2">สาเหตุที่ยกเลิก : </div><div class="col-10 text-danger" id="remark_cancel"></div>
                    </div>

                    <div class="row">
                        <table class="table table-centered table-nowrap col-9">
                            <thead>
                                <tr>
                                <th width="100px" scope="col">Image</th>
                                <th scope="col">Product Name</th>
                                <th width="1px" scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody id="trProduct_cancel">
                                
                            </tbody>
                        </table>

                        <table class="table table-centered table-nowrap col-3">
                            <thead>
                                <tr style="text-align: center;">
                                    <th colspan="2">Summary</th>
                                </tr>
                            </thead>
                            <tbody id="trProduct_summary_cancel">
                        
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <p id="ChangStatus_Cancel_cancel"></p>
                    <p id="ChangStatus_cancel"></p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="detaillog">
        <div class="modal-dialog modal-dialog-centered modal-l" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">บันทึกการแก้ไขข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead>
                                <tr>
                                <th width="" scope="col">ชื่อ</th>
                                <th scope="col">รายละเอียด</th>
                                <th scope="col">สถานะ</th>
                             
                                </tr>
                            </thead>
                            <tbody id="trdetaillog">
                                
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
    <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="detailOrde_cancel">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2 mb-2">Order number : </div><div class="col-4 text-primary" id="mOrderNumber_cancel"></div>
                        <div class="col-1 mb-2">Email : </div><div class="col-5 text-primary" id="mOrderEmail_cancel"></div>
                        <div class="col-2 mb-2">Customer : </div><div class="col-4 text-primary" id="mCustomer_cancel"></div>
                        <div class="col-1 mb-2">Tel : </div><div class="col-5 text-primary" id="mOrderTel_cancel"></div>
                        <div class="col-2 mb-2">Shipping : </div><div class="col-10 text-primary" id="ShippingAddress_cancel"></div>
                        <div class="col-2 mb-2">TaxID : </div><div class="col-10 text-primary" id="member_TaxID_cancel"></div>
                        <div class="col-2 mb-2">สาเหตุที่ยกเลิก : </div><div class="col-10 text-danger" id="remark_cancel"></div>
                    </div>

                    <div class="row">
                        <table class="table table-centered table-nowrap col-9">
                            <thead>
                                <tr>
                                <th width="100px" scope="col">Image</th>
                                <th scope="col">Product Name</th>
                                <th width="1px" scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody id="trProduct_cancel">
                                
                            </tbody>
                        </table>

                        <table class="table table-centered table-nowrap col-3">
                            <thead>
                                <tr style="text-align: center;">
                                    <th colspan="2">Summary</th>
                                </tr>
                            </thead>
                            <tbody id="trProduct_summary_cancel">
                        
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <p id="ChangStatus_Cancel_cancel"></p>
                    <p id="ChangStatus_cancel"></p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<form id="" action="{{url('admin/order/update_detailPayment/')}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">    
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="detailPayment">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2 mb-2">Order number : </div><div class="col-4 text-primary" id="mOrderNumber_detailPayment"></div>
                        <div class="col-2 mb-2">Customer : </div><div class="col-4 text-primary" id="mCustomer_detailPayment"></div>
                        <div class="col-2 mb-2">บัญชีที่โอนเงิน : </div><div class="col-4 text-primary" id="bank_detailPayment"></div>
                        <div class="col-2 mb-2">จำนวนเงินที่โอน : </div><div class="col-4 text-primary" id="transfer_amount_detailPayment"></div>
                        <div class="col-2 mb-2">วันที่ชำระเงิน : </div><div class="col-4 text-primary" id="transfer_date_detailPayment"></div>
                        <div class="col-2 mb-2">เวลาที่ชำระเงิน : </div><div class="col-4 text-primary" id="transfer_time_detailPayment"></div>
                        <div class="col-2 mb-2">หลักฐานการชำระ : </div>
                        <div class="col-10">
                            <span class="text-primary" id="img"></span>
                            <span class="text-primary" id="id"></span>
                        </div>
                        <div class="col-2 mb-2">หมายเหตุ : </div><div class="col-10"><textarea class="form-control" id="Comment" name="Comment" rows="3"></textarea></div>
                        <div class="col-2 mb-2">    <span class="text-primary" id="file_">   แนบใบเสร็จ : </span> </div><div class="col-10"><input type="file" id="file" name="file" class="form-control" multiple /> </div>
                     
                        <div class="col-2 mb-2">บริษัทขนส่งสินค้า:</div><div class="col-10">  <input type="text" name="Transport_type" id="Transport_type" class="form-control" list="type_transport" required></p>
                            <datalist id="type_transport">
                                @if(!empty($transport))
                                    @foreach($transport as $_transport)
                                        @if(!empty($_transport->Transport_type))
                                            <option value="{{ $_transport->Transport_type }}">{{ $_transport->Transport_type }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </datalist>
                        </div>
                        <div class="col-2 mb-2">หมายเลขพัสดุ :</div><div class="col-10"><input type="text" name="Tracking_Number" id="Tracking_Number" class="form-control" required></p></div>
                        <div class="col-2 mb-2">    <span class="text-primary" id="file_">   แนบไฟล์ขนส่ง : </span> </div><div class="col-10"><input type="file" id="Tracking_file" name="Tracking_file" class="form-control" multiple /> </div>
                    </div>
                </div>
                <div class="modal-footer">
                @if(@Auth::user()->level == 1)
                <p id="ChangStatus_Payment"></p>
                @endif   
                     <p id="save_"></p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>

    <form id="newsForm" action="{{url('admin/order/update')}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="edit_detailOrder">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div>
                        
                    </div>
                        <div class="row">
                            <div class="col-2 mb-2">Order number : </div><div class="col-4 text-primary" id="mOrderNumber_edit"></div>
                            <div class="col-1 mb-2">Email : </div><div class="col-5 text-primary" id="mOrderEmail_edit"></div>
                            <div class="col-2 mb-2">Customer : </div><div class="col-4 text-primary" id="mCustomer_edit"></div>
                            <div class="col-1 mb-2">Tel : </div><div class="col-5 text-primary" id="mOrderTel_edit"></div>
                            <div class="col-2 mb-2">Shipping : </div><div class="col-10 text-primary" id="ShippingAddress_edit"></div>
                            <div class="col-2 mb-2">Receipt : </div><div class="col-10 text-primary" id="ReceiptAddress_edit"></div>
                            <div class="col-2 mb-2">TaxIDt : </div><div class="col-10 text-primary" id="member_TaxID_edit"></div>
                         
                        </div>

                        <div class="row">
                            <table class="table table-centered table-nowrap col-9">
                                <thead>
                                    <tr>
                                    
                                    <th scope="col">Product Name</th>
                                    <th width="1px" scope="col" style="text-align: center;">Price</th>
                                    </tr>
                                </thead>
                                <tbody id="trProduct_edit">
                            
                                </tbody>
                            </table>

                            <table class="table table-centered table-nowrap col-3">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th colspan="2">Summary</th>
                                    </tr>
                                </thead>
                                <tbody id="trProduct_summary_edit">
                            
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <p id="ChangStatus_Cancel"></p>
                        <p id="ChangStatus"></p>
                        <button class="btn btn-primary" id="submitBtn">บันทึกการแก้ไข</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="modalChangshipping" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">ยืนยันการทำรายการ ?</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                    <div class="swal2-content"><div id="swal2-content" style="display: block;">ยกเลิกคำสั่งซื้อและส่งอีเมล์ไปยังลูกค้า รายการที่ถูกยกเลิกจะไม่สามารถย้อนกลับมาแก้ไขได้อีก กดยืนยันเพื่อทำรายการ</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                    <div class="swal2-actions"><button type="button" class="swal2-confirm swal2-styled confirmChangStatus" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="confirmChangStatus()">Confirm</button><button onclick="cancelDelete()" type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">Cancel</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalChangcancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">ยืนยันการทำรายการ ?</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                    <div class="swal2-content"><div id="swal2-content" style="display: block;">ยกเลิกคำสั่งซื้อและส่งอีเมล์ไปยังลูกค้า รายการที่ถูกยกเลิกจะไม่สามารถย้อนกลับมาแก้ไขได้อีก กดยืนยันเพื่อทำรายการ</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                    <div class="swal2-actions"><button type="button" class="swal2-confirm swal2-styled confirmChangStatus" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="confirmChangStatus()">Confirm</button><button onclick="cancelDelete()" type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">Cancel</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalChangSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">ยืนยันการทำรายการ ?</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                    <div class="swal2-content"><div id="swal2-content" style="display: block;">ยืนยันการจัดส่งสินค้าและรับสินค้าจากทางลูกค้า รายการที่ถูกยืนยันจะไม่สามารถย้อนกลับมาแก้ไขได้อีก กดยืนยันเพื่อทำรายการ</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                    <div class="swal2-actions"><button type="button" class="swal2-confirm swal2-styled confirmChangStatus" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="confirmChangStatus()">Confirm</button><button onclick="cancelDelete()" type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">Cancel</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalChangStatus_Payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">ยืนยันการทำรายการ ?</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                    <div class="swal2-content"><div id="swal2-content" style="display: block;">ยืนยันการแนบใบเสร็จและจัดส่งสินค้า รายการที่ถูกยืนยันจะไม่สามารถย้อนกลับมาแก้ไขได้อีก กดยืนยันเพื่อทำรายการ</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                    <div class="swal2-actions"><button type="button" class="swal2-confirm swal2-styled confirmChangStatus" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="confirmChangStatus()">Confirm</button><button onclick="cancelDelete()" type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">Cancel</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalChangSuccess_cancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">ยืนยันการทำรายการ ?</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                    <div class="swal2-content"><div id="swal2-content" style="display: block;">ยืนยันที่จะปฏิเสธคำขอร้องยกเลิกคำสั่งซื้อจากทางลูกค้า รายการที่ถูกยืนยันจะไม่สามารถย้อนกลับมาแก้ไขได้อีก กดยืนยันเพื่อทำรายการ</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                    <div class="swal2-actions"><button type="button" class="swal2-confirm swal2-styled confirmChangStatus" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="confirmChangStatus()">Confirm</button><button onclick="cancelDelete()" type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">Cancel</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalChangStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">ยืนยันการทำรายการ ?</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                    <div class="swal2-content"><div id="swal2-content" style="display: block;">ยืนยันคำสั่งซื้อและส่งอีเมล์ไปยังลูกค้า รายการที่ถูกยืนยันจะไม่สามารถย้อนกลับมาแก้ไขได้อีก กดยืนยันเพื่อทำรายการ</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                    <div class="swal2-actions"><button type="button" class="swal2-confirm swal2-styled confirmChangStatus" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="confirmChangStatus()">ยืนยัน</button><button onclick="cancelDelete()" type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">ยกเลิก</button></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade exampleModal" tabindex="-1" id="detailshipping"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
       
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">shipping Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div>
                    </div>
                        <input type="hidden" name="id" id="id" class="">
                        <p class="mb-2">Transport type:  <input type="text" name="Transport_type" id="Transport_type" class="form-control" list="type_transport" required></p>
                        <datalist id="type_transport">
                            @if(!empty($transport))
                                @foreach($transport as $_transport)
                                    @if(!empty($_transport->Transport_type))
                                        <option value="{{ $_transport->Transport_type }}">{{ $_transport->Transport_type }}</option>
                                    @endif
                                @endforeach
                            @endif
                        </datalist>
                        <p class="mb-4">Tracking Number :<input type="text" name="Tracking_Number" id="Tracking_Number" class="form-control" required></p>
                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-primary" onclick="shipping_save()">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
                
            </div>
        
    </div>

    <div class="modal fade" id="imagemodal" tabindex="-2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog fullscreen">
        <div class="modal-content">              
          <div class="modal-body" style="text-align: center;">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <img src="" class="imagepreview" style="height: 95%; width: 95%;" >
            <embed src="" class="filepreview" frameborder="0" width="100%" height="400px">
          </div>
        </div>
      </div>
    </div>
    <script>
        function toggleInput() {
            var inputContainer = document.getElementById("inputContainer");
            var checkBox = document.getElementById("check_Shipping");
            if (checkBox.checked) {
                var sub_total = 0;
                $('.sum_inline').each(function () {
                    sub_total = parseFloat(sub_total) + parseFloat($(this).val());
                });
                if ($('#checkvat').is(':checked')) {
                    var vat = parseFloat(sub_total) * 0.07;
                    var total = parseFloat(sub_total) + vat;
                } else {
                    var total = parseFloat(sub_total) ;
                }

                $('#sum_vatl').text('฿ ' + vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                $('#sum_total').text('฿ ' + total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                inputContainer.classList.add("hidden");
                $('#Shipping').val('0.00');
            } else {
                inputContainer.classList.remove("hidden");
            }
        }
        function changecheckvat() {
            // ตรวจสอบการทำงานเมื่อ checkbox เปลี่ยนสถานะ
            if ($('#checkvat').is(':checked')) {
                calculateTotalWithVAT();
            } else {
                calculateTotalWithoutVAT();
            }
        }
        function calculateTotalWithVAT() {
            var sub_total = 0;
            $('.sum_inline').each(function () {
                sub_total = parseFloat(sub_total) + parseFloat($(this).val());
            });
            if ($('#check_Shipping').is(':checked')) {
                var vat = parseFloat(sub_total) * 0.07;
                var total = parseFloat(sub_total) + vat;
            } else {
                const ShippingInput = document.getElementById("Shipping");
                let Shipping = parseInt(ShippingInput.value, 10);
                var vat = parseFloat(sub_total) * 0.07;
                var total = parseFloat(sub_total) + vat+ parseFloat(Shipping);
            }
            $('#sum_vatl').text('฿ ' + vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
            $('#sum_total').text('฿ ' + total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));

           
        }
        function calculateTotalWithoutVAT() {
            var sub_total = 0;
            $('.sum_inline').each(function () {
                sub_total = parseFloat(sub_total) + parseFloat($(this).val());
            });

            if ($('#check_Shipping').is(':checked')) {
                var vat = 0.00;
                var total = parseFloat(sub_total) ;
            } else {
                const ShippingInput = document.getElementById("Shipping");
                let Shipping = parseInt(ShippingInput.value, 10);
                var vat = 0.00;
                var total = parseFloat(sub_total) + parseFloat(Shipping);
            }
           


            $('#sum_vatl').text('฿ ' + vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
            $('#sum_total').text('฿ ' + total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));

        }
        function myFunction_Shipping(e) {
            const id_order =  e;
            const ShippingInput = document.getElementById("Shipping");
            let orderTotal = 0; // สร้างตัวแปรเพื่อเก็บผลรวม
            ShippingInput.addEventListener("change", function(event) {
                event.preventDefault();
                let Shipping = parseInt(ShippingInput.value, 10);
                if (!isNaN(Shipping)) {
                    var sub_total = 0;
                    $('.sum_inline').each(function(){
                        sub_total = parseFloat(sub_total) + parseFloat($(this).val());
                    });
                    
                    if ($('#checkvat').is(':checked')) {
                        var vat = parseFloat(sub_total) * 0.07;
                        $('#sum_vatl').text('฿ '+vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        var total = parseFloat(sub_total) + parseFloat(Shipping) + parseFloat(vat);
                        $('#sum_total').text('฿ '+total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                    } else {
                        var vat = 0.00;
                        $('#sum_vatl').text('฿ '+vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        var total = parseFloat(sub_total) + parseFloat(Shipping);
                        $('#sum_total').text('฿ '+total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                    }
                    
                }
            });
        }


    </script>
@include('layouts/modal')
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')

<script>
    var id = null;
    var status = null;
    function ChangStatus(i,s){
        id = i;
        status = s;
        $('#modalChangStatus').modal('show');
    }

    function ChangStatuscan(i,s){
        id = i;
        status = s;
        $('#modalChangcancel').modal('show');
    }
    function ChangStatusSuccess(i,s){
        id = i;
        status = s;
        $('#modalChangSuccess').modal('show');
    }

    function ChangStatus_Payment(i,s){
        id = i;
        status = s;
        $('#modalChangStatus_Payment').modal('show');
    }
    function ChangStatusSuccess_cancel(i,s){
        id = i;
        status = s;
        $('#modalChangSuccess_cancel').modal('show');
    }



    function shipping(id){
        $('#id').val(id);
        $('#detailshipping').modal('show');
    }

    function shipping_save() {
    // Get input values
    var id = $('#id').val();
    var Transport_type = $('#Transport_type').val();
    var Tracking_Number = $('#Tracking_Number').val();

    // Create data object for AJAX request
    var requestData = {
        '_token': '{{ csrf_token() }}',
        'id': id,
        'Transport_type': Transport_type,
        'Tracking_Number': Tracking_Number
    };

    // Send AJAX request
    $.ajax({
        type: "post",
        url: "/admin/order/Tracking_Number",
        data: requestData,
        success: function (result) {
            if (result == 1) {
                // Show a SweetAlert with a timer
                Swal.fire({
                    title: 'ระบบกำลังจัดส่งอีเมล์!',
                    html: 'กรุณาสักครู่ระบบจะจัดส่งเสร็จภายใน<b></b> ',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        const timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 10);

                        // Handle the timer expiration
                        Swal.get().then((modal) => {
                            modal.timer.then((time) => {

                                console.log('I was closed by the timer');
                                location.reload();
                            });
                        });
                    },
                    willClose: () => {
                        location.reload();
                        clearInterval(timerInterval);
                   
                    }
                });
            } else {
                // Handle the case when result is not 1
            }
        }
    });
}


    function confirmChangStatus(){
                Swal.fire({
                    title: 'ระบบกำลังจัดส่งอีเมล์!',
                    html: 'กรุณาสักครู่ระบบจะจัดส่งเสร็จภายใน<b></b> ',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        const timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft();
                        }, 10);

                        // Handle the timer expiration
                        Swal.get().then((modal) => {
                            modal.timer.then((time) => {

                                console.log('I was closed by the timer');
                                location.reload();
                            });
                        });
                    },
                    willClose: () => {
                        $.ajax({
                            type: "post",
                            url: "/admin/order/confirmChangStatus/"+id,
                            data:{
                                '_token': '{{ csrf_token() }}',
                                'status': status
                            },
                            success: function( result ) {
                                if(result == 1){
                                    $('#modalChangcancel').modal('hide');
                                    $('#modalChangStatus').modal('hide');
                                    $('#modalChangSuccess').modal('hide');
                                    // setTimeout(function(){
                                        location.reload();
                                    // }, 500);
                                }else{
                                }
                            }   
                        });
                        location.reload();
                        clearInterval(timerInterval);
                   
                    }
                });
       
    }
    function confirmChangSuccess(){
              
                        $.ajax({
                            type: "post",
                            url: "/admin/order/confirmChangStatus/"+id,
                            data:{
                                '_token': '{{ csrf_token() }}',
                                'status': status
                            },
                            success: function( result ) {
                                if(result == 1){
                                    $('#modalChangcancel').modal('hide');
                                    $('#modalChangStatus').modal('hide');
                                    $('#modalChangSuccess').modal('hide');
                                    // setTimeout(function(){
                                        location.reload();
                                    // }, 500);
                                }else{
                                }
                            }   
                        });
                        
       
    }
    function cancelDelete(){
        $('#modalChangcancel').modal('hide');
        $('#modalChangStatus').modal('hide');
        $('#modalChangSuccess').modal('hide');
        $('#ChangStatus_Payment').modal('hide');
    }

    function modal(v){
        var image_url = 'popup(\'/upload/slip/'+v.transfer_image+'\')';
        $('#imgdetail').html('<p onclick="'+image_url+'" style="cursor: pointer;"><i class="fas fa-file-image"></i> ตรวจสอบ</p>');
        var file_url = 'popup_file(\'/upload/slip/'+v.receipt+'\')';
            $('#filedetail').html('<p onclick="'+file_url+'" style="cursor: pointer;"><i class="fas fa-file-image"></i> ตัวอย่าง</p>');
        $('#mOrderNumber').html(v.order_number);
        $('#mOrderEmail').html(v.ship_email);
        $('#mOrderTel').html(v.ship_phone);
        $('#mCustomer').html(v.member_firstname+' '+v.member_lastname);
        $('#member_TaxID').text(v.member_TaxID);
        var imgPayPic = +'<p class="mb-2">Payment Notification :</p>'
        +'<div class="col-12 zoom-gallery" style="display: flex">'
            +'<a id="aPayPic" target="_blank" href="/upload/slip/'+v.transfer_image+'" class="float-left"><img id="imgPayPic" src="/upload/slip/'+v.transfer_image+'" width="150px" alt=""></a>'
        +'</div>'
        +'<hr>'

        $('#imgPayPic').attr(imgPayPic);
        $('#ShippingAddress').html(v.ship_first_name+' '+v.ship_last_name+' | '+v.ship_address+' '+v.ship_district_name+' '+v.ship_amphure_name+' '+v.ship_province_name+' '+v.ship_zipcode);
        $('#ReceiptAddress').html(v.receipt_first_name+' '+v.receipt_last_name+' | '+v.receipt_address+' '+v.receipt_district_name+' '+v.receipt_amphure_name+' '+v.receipt_province_name+' '+v.receipt_zipcode);
        var order_total = 0;
        var tr = '';
        if(v.color == null){
            if(v.size == null){
                v.order_products.forEach(el => {
                    tr += '<tr>'
                            +'<th style="vertical-align: top !important;" scope="row">'
                                +'<div class="zoom-gallery">'
                                    +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                +'</div>'
                            +'</th>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>' 
                                 +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'</h5>'

                                    +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                +'</div>'
                            +'</td>'
                            +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }else{
                v.order_products.forEach(el => {
                    tr += '<tr>'
                            +'<th style="vertical-align: top !important;" scope="row">'
                                +'<div class="zoom-gallery">'
                                    +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                +'</div>'
                            +'</th>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>'
                                    +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                    +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                +'</div>'
                            +'</td>'
                            +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                            
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }
        }else{
            if(v.size == null){
                v.order_products.forEach(el => {
                            tr += '<tr>'
                                    +'<th style="vertical-align: top !important;" scope="row">'
                                        +'<div class="zoom-gallery">'
                                            +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                        +'</div>'
                                    +'</th>'
                                    +'<td style="vertical-align: top !important;">'
                                        +'<div>'
                                            +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                        +'</div>'
                                    +'</td>'
                                    +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                                +'</tr>';
                                order_total = parseInt(order_total)+parseInt(el.order_total);
                        });
            }else{
                v.order_products.forEach(el => {
                    tr += '<tr>'
                            +'<th style="vertical-align: top !important;" scope="row">'
                                +'<div class="zoom-gallery">'
                                    +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                +'</div>'
                            +'</th>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>'
                                +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                    +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                +'</div>'
                            +'</td>'
                            +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }
        }

        var sum = parseInt(v.shipping_cost)+parseInt(v.vat)+parseInt(order_total);
        var show_vat = parseFloat(v.vat);
        var tr_summary = '';
        tr_summary += '<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Sub Total :</h6>'
                    +'</td>'
                    +'<td>฿ '+order_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    +'</td>'
                +'</tr>'
                +'<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Shipping :</h6>'
                    +'</td>'
                    +'<td>฿ '+v.shipping_cost
                        
                    +'</td>'
                +'</tr>'
                  +'<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Vat :</h6>'
                    +'</td>'
                    +'<td>฿ '+show_vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                        
                    +'</td>'
                +'</tr>'
                +'<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Total :</h6>'
                    +'</td>'
                    +'<td>฿ '+ sum.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    +'</td>'
                +'</tr>'
        $('#detailOrder').modal('show');
        $('#trProduct').html(tr);
        $('#trProduct_summary').html(tr_summary);
    }
    function modal_log(v){
        console.log(v);
        var tr = '';
      
                v.forEach(el => {
                    if (el.statusid == 7) {
                        var status = "บันทึกแก้ไขรายคำสั่งซื้อ";
                    } else if (el.statusid == 1) {
                        var status = "ยืนยันรายการคำสั่งซื้อและส่งเมล์";
                    } else if(el.statusid == 3) {
                        // กรณีที่ไม่ตรงเงื่อนไขใด ๆ
                        var status = "ตรวจสอบการชำระเงินเงิน";
                    } else if(el.statusid == 4) {
                        var status = "ยืนยันการชำระเงินและจัดส่ง";
                    } else if(el.statusid == 5) {
                        var status = "จัดส่งสำเร็จ เสร็จสิ้น";
                    } else {
                        var status = "ไม่สามารถระบุได้";
                    }

                    tr += '<tr>'
                            +'<th scope="row">'
                                +'<div >'
                                    +'<h5 class="text-truncate font-size-14">'+el.users_name+'</h5>'
                                +'</div>'
                            +'</th>'
                            +'<td>'
                                +'<div>' 
                                 +'<h5 class="text-truncate font-size-14">'+status+'</h5>'

                                    
                                +'</div>'
                            +'</td>'
                            +'<td>'
                                +'<div>' 
                                 +'<h5 class="text-truncate font-size-14">'+el.status_name+'</h5>'

                                    
                                +'</div>'
                            +'</td>'
                          
                        +'</tr>';
                       
                });
           
        $('#detaillog').modal('show');
        $('#trdetaillog').html(tr);
    }
    function modal_cancel(v){
        $('#mOrderNumber_cancel').html(v.order_number);
        $('#mOrderEmail_cancel').html(v.ship_email);
        $('#mOrderTel_cancel').html(v.ship_phone);
        $('#mCustomer_cancel').html(v.member_firstname+' '+v.member_lastname);
        $('#member_TaxID_cancel').text(v.member_TaxID);
        $('#remark_cancel').text(v.Comment);
        var imgPayPic = +'<p class="mb-2">Payment Notification :</p>'
        +'<div class="col-12 zoom-gallery" style="display: flex">'
            +'<a id="aPayPic" target="_blank" href="/upload/slip/'+v.transfer_image+'" class="float-left"><img id="imgPayPic" src="/upload/slip/'+v.transfer_image+'" width="150px" alt=""></a>'
        +'</div>'
        +'<hr>'
        $('#ChangStatus_Cancel_cancel').html('<button type="button" class="btn btn-danger" onclick="ChangStatusSuccess_cancel('+ v.id +', 7)">'
            +'<i class="mdi mdi-subdirectory-arrow-right font-size-14"></i>'
            +'ยกเลิกคำของร้อง'
            +' </button>');
        $('#ChangStatus_cancel').html('<button type="button" class="btn btn-warning" onclick="ChangStatuscan('+ v.id +', 5)">'
            +'<i class="mdi mdi-subdirectory-arrow-right font-size-14"></i>'
            +'ยืนยันการของร้องยกเลิกคำสั่งซื้อ'
            +' </button>');
        $('#imgPayPic').attr(imgPayPic);
        $('#ShippingAddress_cancel').html(v.ship_first_name+' '+v.ship_last_name+' | '+v.ship_address+' '+v.ship_district_name+' '+v.ship_amphure_name+' '+v.ship_province_name+' '+v.ship_zipcode);
        $('#ReceiptAddress_cancel').html(v.receipt_first_name+' '+v.receipt_last_name+' | '+v.receipt_address+' '+v.receipt_district_name+' '+v.receipt_amphure_name+' '+v.receipt_province_name+' '+v.receipt_zipcode);
        var order_total = 0;
        var tr = '';
        if(v.color == null){
            if(v.size == null){
                v.order_products.forEach(el => {
                    tr += '<tr>'
                            +'<th style="vertical-align: top !important;" scope="row">'
                                +'<div class="zoom-gallery">'
                                    +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                +'</div>'
                            +'</th>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>' 
                                 +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'</h5>'

                                    +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                +'</div>'
                            +'</td>'
                            +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }else{
                v.order_products.forEach(el => {
                    tr += '<tr>'
                            +'<th style="vertical-align: top !important;" scope="row">'
                                +'<div class="zoom-gallery">'
                                    +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                +'</div>'
                            +'</th>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>'
                                    +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                    +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                +'</div>'
                            +'</td>'
                            +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                            
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }
        }else{
            if(v.size == null){
                v.order_products.forEach(el => {
                            tr += '<tr>'
                                    +'<th style="vertical-align: top !important;" scope="row">'
                                        +'<div class="zoom-gallery">'
                                            +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                        +'</div>'
                                    +'</th>'
                                    +'<td style="vertical-align: top !important;">'
                                        +'<div>'
                                            +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                        +'</div>'
                                    +'</td>'
                                    +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                                +'</tr>';
                                order_total = parseInt(order_total)+parseInt(el.order_total);
                        });
            }else{
                v.order_products.forEach(el => {
                    tr += '<tr>'
                            +'<th style="vertical-align: top !important;" scope="row">'
                                +'<div class="zoom-gallery">'
                                    +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                +'</div>'
                            +'</th>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>'
                                +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                    +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                +'</div>'
                            +'</td>'
                            +'<td style="vertical-align: top !important;">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }
        }

        var sum = parseInt(v.shipping_cost)+parseInt(v.vat)+parseInt(order_total);
        var show_vat = parseFloat(v.vat);
        var tr_summary = '';
        tr_summary += '<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Sub Total :</h6>'
                    +'</td>'
                    +'<td>฿ '+order_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    +'</td>'
                +'</tr>'
                +'<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Shipping :</h6>'
                    +'</td>'
                    +'<td>฿ '+v.shipping_cost
                        
                    +'</td>'
                +'</tr>'
                  +'<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Vat :</h6>'
                    +'</td>'
                    +'<td>฿ '+show_vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                        
                    +'</td>'
                +'</tr>'
                +'<tr>'
                    +'<td>'
                        +'<h6 class="m-0 text-right">Total :</h6>'
                    +'</td>'
                    +'<td>฿ '+ sum.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    +'</td>'
                +'</tr>'
        $('#detailOrde_cancel').modal('show');
        $('#trProduct_cancel').html(tr);
        $('#trProduct_summary_cancel').html(tr_summary);
    }

    function modal_Payment(v){
       
        $('#mOrderNumber_detailPayment').html(v.order_number);
        $('#mCustomer_detailPayment').html(v.member_firstname+' '+v.member_lastname);
        $('#bank_detailPayment').html(v.bank_name);
        $('#transfer_amount_detailPayment').html(v.transfer_amount);
        $('#transfer_date_detailPayment').html(v.transfer_date);
        $('#transfer_time_detailPayment').html(v.transfer_time);
        var image_url = 'popup(\'/upload/slip/'+v.transfer_image+'\')';
        $('#img').html('<p onclick="'+image_url+'" style="cursor: pointer;"><i class="fas fa-file-image"></i> ตรวจสอบ</p>');
        $('#ShippingAddress').html(v.ship_first_name+' '+v.ship_last_name+' '+v.ship_address+' '+v.ship_district_name+' '+v.ship_amphure_name+' '+v.ship_province_name+' '+v.ship_zipcode);
        $('#ReceiptAddress').html(v.receipt_first_name+' '+v.receipt_last_name+' '+v.receipt_address+' '+v.receipt_district_name+' '+v.receipt_amphure_name+' '+v.receipt_province_name+' '+v.receipt_zipcode);
        $('#id').html('<input type="hidden" name="id" id="id" value="'+v.id+'"> ');
        $('#save_').html('<button class="btn btn-primary" id="submitBtn">อัปเดตข้อมูล</button>');
        if(v.ref_order_status_id == 3){
            $('#ChangStatus_Payment').html('<button type="button" class="btn btn-warning" onclick="ChangStatus_Payment('+ v.id +', 3)">'
            +'<i class="mdi mdi-subdirectory-arrow-right font-size-14"></i>'
            +'ยืนยันการการแนบใบเสร็จและจัดส่งสินค้า'
            +' </button>');
            $("#Comment").val(v.Comment);
            $("#Transport_type").val(v.Transport_type);
            $("#Tracking_Number").val(v.Tracking_Number);
            var file_url = 'popup(\'/upload/slip/'+v.receipt+'\')';
            $('#file_').html('<p onclick="'+file_url+'"> แนบใบเสร็จ :</p>');
        }
       
        $('#detailPayment').modal('show');
        $('#trProduct_detailPayment').html('tr');
      
       

    }

    function popup(url){
        console.log('show image url : '+url);
        $('.imagepreview').attr('src', url);
        $('.imagepreview').css('display', 'block');
        $('.filepreview').css('display', 'none');
        $('#imagemodal').modal('show');   
    }

    function popup_file(url){
        console.log('show image url : '+url);
        $('.filepreview').attr('src', url);
        $('.filepreview').css('display', 'block');
        $('.imagepreview').css('display', 'none');
        $('#imagemodal').modal('show');   
    }

    //คำนวณค่า อาร์เรยจากรายการสินค้า
    function myFunction(e) {
        const id =  e;
        const priceId = "price" + e;
        const qtyId = "Qty" + e;
        const sumPriceId = "sumprice" + e;
        const id_productId = "id_product" + e;
        const price = parseFloat(document.getElementById(priceId).value);
        const id_product = parseFloat(document.getElementById(id_productId).value);
        const qtyInput = document.getElementById(qtyId);
        const sumPriceInput = document.getElementById(sumPriceId);
        const resultText = document.getElementById("result" + e); // เลือก element สำหรับแสดงผลคูณ
        let orderTotal = 0; // สร้างตัวแปรเพื่อเก็บผลรวม
        qtyInput.addEventListener("change", function(event) {
            event.preventDefault();
            let qty = parseInt(qtyInput.value, 10);
            console.log('Price : '+parseFloat(price)+' x Qty : '+parseFloat(qty));
            var sum_inline = parseFloat(price) * parseFloat(qty);
            console.log('Sum : '+sum_inline);
            resultText.textContent = '฿ '+sum_inline.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            sumPriceInput.value = sum_inline;
            var sub_total = 0;
            $('.sum_inline').each(function(){
                sub_total = parseFloat(sub_total) + parseFloat($(this).val());
            });

            console.log('Sub Total : '+sub_total);

            $('#order_total').text('฿ '+sub_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));     
            var Shipping = $('#Shipping').val();

                    if ($('#checkvat').is(':checked')) {
                        var vat = parseFloat(sub_total) * 0.07;
                        $('#sum_vatl').text('฿ '+vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        var total = parseFloat(sub_total) + parseFloat(Shipping) + parseFloat(vat);
                        $('#sum_total').text('฿ '+total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                    } else {
                        var vat = 0.00;
                        $('#sum_vatl').text('฿ '+vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        var total = parseFloat(sub_total) + parseFloat(Shipping);
                        $('#sum_total').text('฿ '+total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                    }
        });
    }

    function calculateTotalPrice(qty, price) {
        return qty * price;
    }


    function modal_edit(v){
        $('#mOrderNumber_edit').text(v.order_number);
        $('#mOrderEmail_edit').text(v.ship_email);
        $('#mOrderTel_edit').text(v.ship_phone);
        $('#member_TaxID_edit').text(v.member_TaxID);
        $('#mCustomer_edit').text(v.member_firstname+' '+v.member_lastname);
        $('#ShippingAddress_edit').text(v.ship_first_name+' '+v.ship_last_name+' | '+v.ship_address+' '+v.ship_district_name+' '+v.ship_amphure_name+' '+v.ship_province_name+' '+v.ship_zipcode);
        $('#ReceiptAddress_edit').text(v.receipt_first_name+' '+v.receipt_last_name+' | '+v.receipt_address+' '+v.receipt_district_name+' '+v.receipt_amphure_name+' '+v.receipt_province_name+' '+v.receipt_zipcode);
        $('#ChangStatus_Cancel').html('<button type="button" class="btn btn-danger" onclick="ChangStatuscan('+ v.id +', 5)">'
            +'<i class="mdi mdi-subdirectory-arrow-right font-size-14"></i>'
            +'ยกเลิกการสั่งซื้อ'
            +' </button>');
        $('#ChangStatus').html('<button type="button" class="btn btn-warning" onclick="ChangStatus('+ v.id +', 7)">'
            +'<i class="mdi mdi-subdirectory-arrow-right font-size-14"></i>'
            +'ยืนยันการสั่งซื้อและส่งอีเมล์'
            +' </button>');
            
        var order_total = 0;
        var tr = '';
        if(v.color == null){
            if(v.size == null){
             v.order_products.forEach(el => {
                tr += '<tr>'
                           +'<td style="vertical-align: top !important;">'
                               +'<div>'
                               +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                               +'<p class="text-muted mb-0"> '+el.product.product_name+'</p>'
                                   +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' จำนวน <input type="text" name="Qty['+el.id+']" id="Qty'+el.id+'" value="'+el.qty+'" onkeyup="myFunction('+el.id +')" style="width: 7%; text-align: center;"> ชิ้น</p>'
                               +'</div>'
                           +'</td>'
                           +' <td style="vertical-align: top !important;" ><p id="result'+el.id+'">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</p></td>฿ <input type="hidden" name="price'+el.id+'" id="price'+el.id+'" value="'+el.price+'"><input class="sum_inline" type="hidden" name="sumprice['+el.id+']" id="sumprice'+el.id+'" value="'+parseFloat(el.price)*parseFloat(el.qty)+'"><input type="hidden" name="id_product'+el.id+'" id="id_product'+el.id+'" value="'+el.product.id+'"></td>'
                       +'</tr>';
                       const sumPriceId = "sumprice" +el.id;
                       var  sumPrice = $(sumPriceId).val();
                       order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }else{
                v.order_products.forEach(el => {
                    tr += '<tr>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>'
                                    +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                    '<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' จำนวน <input type="text" name="Qty['+el.id+']" id="Qty'+el.id+'" value="'+el.qty+'" onkeyup="myFunction('+el.id +')" style="width: 7%; text-align: center;"> ชิ้น</p>'                                        +'</div>'
                            +'</td>'
                            +' <td style="vertical-align: top !important;" ><p id="result'+el.id+'">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</p></td>฿ <input type="hidden" name="price'+el.id+'" id="price'+el.id+'" value="'+el.price+'"><input class="sum_inline" type="hidden" name="sumprice'+el.id+'" id="sumprice'+el.id+'" value="'+parseFloat(el.price)*parseFloat(el.qty)+'"><input type="hidden" name="id_product'+el.id+'" id="id_product'+el.id+'" value="'+el.product.id+'"></td>'
                        +'</tr>'; 
                        const sumPriceId = "sumprice" + e;
                        var  sumPrice = $(sumPriceId).val();
                        order_total = parseInt(order_total)+ sumPrice;
                });
            }
        }else{
            if(v.size == null){
                v.edit_detailOrder.forEach(el => {
                    tr += '<tr>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>'
                                '<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' จำนวน <input type="text" name="Qty['+el.id+']" id="Qty'+el.id+'" value="'+el.qty+'" onkeyup="myFunction('+el.id +')" style="width: 7%; text-align: center;"> ชิ้น</p>'                                        +'</div>'
                            +'</td>'
                            +' <td style="vertical-align: top !important;" ><p id="result'+el.id+'">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</p></td>฿ <input type="hidden" name="price'+el.id+'" id="price'+el.id+'" value="'+el.price+'"><input class="sum_inline" type="hidden" name="sumprice'+el.id+'" id="sumprice'+el.id+'" value="'+parseFloat(el.price)*parseFloat(el.qty)+'"><input type="hidden" name="id_product'+el.id+'" id="id_product'+el.id+'" value="'+el.product.id+'"></td>'
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }else{
                v.edit_detailOrder.forEach(el => {
                    tr += '<tr>'
                            +'<td style="vertical-align: top !important;">'
                                +'<div>'
                                +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                '<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' จำนวน <input type="text" name="Qty['+el.id+']" id="Qty'+el.id+'" value="'+el.qty+'" onkeyup="myFunction('+el.id +')" style="width: 7%; text-align: center;"> ชิ้น</p>'                                        +'</div>'
                            +'</td>'
                            +' <td style="vertical-align: top !important;" ><p id="result'+el.id+'">฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</p></td>฿ <input type="hidden" name="price'+el.id+'" id="price'+el.id+'" value="'+el.price+'"><input class="sum_inline" type="hidden" name="sumprice'+el.id+'" id="sumprice'+el.id+'" value="'+parseFloat(el.price)*parseFloat(el.qty)+'"><input type="hidden" name="id_product'+el.id+'" id="id_product'+el.id+'" value="'+el.product.id+'"></td>'
                        +'</tr>';
                        order_total = parseInt(order_total)+parseInt(el.order_total);
                });
            }
        } 
        var checkedvat = "";    
        var class1vat = "";   
        var show_vat = parseFloat(v.vat);
        var order_total1 =  parseInt(order_total);
        if(v.vat_check == 1){
            var checkedvat = "checked";   
            var class1vat = "hidden";   
            var order_total1 = parseInt(order_total)+parseFloat(v.vat);
        }

      

        var checked = "";    
        var class1 = "";   
       
        if (v.check_Shipping == 1) {
            var checked = "checked";   
            var class1 = "hidden";

        }

        var tr_summary = '';
        tr_summary += '<tr>'
                    +'<td colspan="">'
                        +'<h6 class="m-0 text-right">Sub Total :</h6>'
                    +'</td>'
                    +'<td><p id="order_total">฿ '+order_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</p>'
                    +'</td>'
                +'</tr>'
                +'<tr>'
                    +'<td colspan="">'
                        +'<h6 class="m-0 text-right">Shipping :</h6>'
                    +'</td>'
                    +'<td> <input type="checkbox" id="check_Shipping" name="check_Shipping" value="1" onchange="toggleInput()" '+checked+'> ฟรีค่าขนส่ง <div id="inputContainer" class="'+class1+'"><input type="text" class="right-aligned"  name="Shipping" id="Shipping"  value="'+ v.shipping_cost+'"  onkeyup="myFunction_Shipping('+v.id +')"></div> '
                    +'</td>'
                +'</tr>'
                +'<tr>'
                    +'<td colspan="">'
                        +'<h6 class="m-0 text-right">Vat :</h6><br>'
                    +'</td>'
                    +'<td><p id="sum_vatl">฿ '+show_vat.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'<input type="hidden" name="vat_check" id="vat_check" value="'+v.vat_check+'"></p>'
                    +'<h6 class="m-0 text-center"><input type="checkbox" id="checkvat" name="checkvat" value="1" onchange="changecheckvat()" '+checkedvat+'> รวมภาษี</h6>'
                    +'</td>'
                +'</tr>'
                +'<tr>'
                    +'<td colspan="">'
                        +'<h6 class="m-0 text-right">Total :<input type="hidden" name="id" id="id" value="'+v.id+'">:</h6>'
                    +'</td>'
                    +'<td><p id="sum_total">฿ '+order_total1.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</p>'
                    +'</td>'
                +'</tr>'
            
        $('#edit_detailOrder').modal('show');
        $('#trProduct_edit').html(tr);   
        $('#trProduct_summary_edit').html(tr_summary);   
    }

</script>
<!-- Magnific Popup-->
<script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<!-- lightbox init js-->
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection