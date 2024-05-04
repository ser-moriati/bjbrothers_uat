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
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Details</th>
                                    <!-- <th>Update</th>
                                    <th>Payment</th>
                                    <th>Confirm</th> -->
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
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{$value->order_number}}</a> </td>
                                    <td>{{$value->member_firstname}} {{$value->member_lastname}}</td>
                                    <td>
                                        {{date('d/m/Y', strtotime($value->created_at))}}
                                    </td>
                                    <td>
                                        ฿{{number_format($value->order_products->sum->order_total,2)}}
                                    </td>
                                    <td>
                                    <span style="background-color: {{$value->color_background}};color: {{$value->color_code}}" class="badge badge-pill font-size-12">{{$value->status_name}}</span>
                                        
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
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="modal({{$value}})">
                                            <i class='bx bx-file'></i>
                                        </button>
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
                <div>
                    
                </div>
                    <p class="mb-2">Order number : <span class="text-primary" id="mOrderNumber"></span></p>
                    <p class="mb-4">Customer : <span class="text-primary" id="mCustomer"></span></p>
                    <p class="mb-2">Shipping Address : <span class="text-primary" id="ShippingAddress"></span></p>
                    <p class="mb-4">Receipt Address : <span class="text-primary" id="ReceiptAddress"></span></p>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
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
    var id = null;
    var status = null;
    function ChangStatus(i,s){
        id = i;
        status = s;
        $('#modalChangStatus').modal('show');
    }
    function shipping(id){
        $('#id').val(id);
        $('#detailshipping').modal('show');
    }
    function shipping_save(){
        var id                 = $('#id').val();
        var Transport_type     = $('#Transport_type').val();
        var Tracking_Number    = $('#Tracking_Number').val();
        $.ajax({
            type: "post",
            url: "/admin/order/Tracking_Number",
            data:{
                '_token': '{{ csrf_token() }}',
                'id': id,
                'Transport_type' : Transport_type,
                'Tracking_Number': Tracking_Number
            },
            success: function( result ) {
                if(result == 1){
                   
                    // setTimeout(function(){
                        location.reload();
                    // }, 500);
                }else{
                }
            }   
        });
    }
    function confirmChangStatus(){
        $.ajax({
            type: "post",
            url: "/admin/order/confirmChangStatus/"+id,
            data:{
                '_token': '{{ csrf_token() }}',
                'status': status
            },
            success: function( result ) {
                if(result == 1){
                    $('#modalChangStatus').modal('hide');
                    // setTimeout(function(){
                        location.reload();
                    // }, 500);
                }else{
                }
            }   
        });
    }
    function cancelDelete(){
        $('#modalChangStatus').modal('hide');
    }
    function modal(v){
        $('#mOrderNumber').html(v.order_number);
        $('#mCustomer').html(v.member_firstname+' '+v.member_lastname);
        $('#mCustomer').html(v.member_firstname+' '+v.member_lastname);
        
                    var imgPayPic = +'<p class="mb-2">Payment Notification :</p>'
                    +'<div class="col-12 zoom-gallery" style="display: flex">'
                        +'<a id="aPayPic" target="_blank" href="/upload/slip/'+v.transfer_image+'" class="float-left"><img id="imgPayPic" src="/upload/slip/'+v.transfer_image+'" width="150px" alt=""></a>'
                    +'</div>'
                    +'<hr>'

        $('#imgPayPic').attr(imgPayPic);
        $('#ShippingAddress').html(v.ship_first_name+' '+v.ship_last_name+' '+v.ship_address+' '+v.ship_district_name+' '+v.ship_amphure_name+' '+v.ship_province_name+' '+v.ship_zipcode);
        $('#ReceiptAddress').html(v.receipt_first_name+' '+v.receipt_last_name+' '+v.receipt_address+' '+v.receipt_district_name+' '+v.receipt_amphure_name+' '+v.receipt_province_name+' '+v.receipt_zipcode);
        var order_total = 0;
        var tr = '';
        if(v.color == null){
            if(v.size == null){
                v.order_products.forEach(el => {
                            tr += '<tr>'
                                    +'<th scope="row">'
                                        +'<div class="zoom-gallery">'
                                            +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                        +'</div>'
                                    +'</th>'
                                    +'<td>'
                                        +'<div>'
                                            +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                        +'</div>'
                                    +'</td>'
                                    +'<td>฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                                +'</tr>';
                                order_total = parseInt(order_total)+parseInt(el.order_total);
                        });
            }else{
                v.order_products.forEach(el => {
                            tr += '<tr>'
                                    +'<th scope="row">'
                                        +'<div class="zoom-gallery">'
                                            +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                        +'</div>'
                                    +'</th>'
                                    +'<td>'
                                        +'<div>'
                                            +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                            +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                        +'</div>'
                                    +'</td>'
                                    +'<td>฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                                    
                                +'</tr>';
                                order_total = parseInt(order_total)+parseInt(el.order_total);
                                
                        });
            }
        }else{
            if(v.size == null){
                v.order_products.forEach(el => {
                            tr += '<tr>'
                                    +'<th scope="row">'
                                        +'<div class="zoom-gallery">'
                                            +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                        +'</div>'
                                    +'</th>'
                                    +'<td>'
                                        +'<div>'
                                            +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                        +'</div>'
                                    +'</td>'
                                    +'<td>฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                                +'</tr>';
                                order_total = parseInt(order_total)+parseInt(el.order_total);
                        });
            }else{
                v.order_products.forEach(el => {
                            tr += '<tr>'
                                    +'<th scope="row">'
                                        +'<div class="zoom-gallery">'
                                            +'<a class="float-left" href="/upload/product/'+el.product.product_image+'"><img src="/upload/product/'+el.product.product_image+'" width="50px" alt=""></a>'
                                        +'</div>'
                                    +'</th>'
                                    +'<td>'
                                        +'<div>'
                                        +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.size.size_name+')</h5>'
                                            +'<p class="text-muted mb-0">฿ '+el.price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                        +'</div>'
                                    +'</td>'
                                    +'<td>฿ '+el.order_total.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                                +'</tr>';
                                order_total = parseInt(order_total)+parseInt(el.order_total);
                        });
            }
        }
                        //
                        var sum = parseInt(v.shipping_cost)+parseInt(v.vat)+parseInt(order_total);
                        tr += '<tr>'
                                    +'<td colspan="2">'
                                        +'<h6 class="m-0 text-right">Sub Total:</h6>'
                                    +'</td>'
                                    +'<td>฿' +order_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                                    +'</td>'
                                +'</tr>'
                                +'<tr>'
                                    +'<td colspan="2">'
                                        +'<h6 class="m-0 text-right">Shipping:</h6>'
                                    +'</td>'
                                    +'<td>฿ '+v.shipping_cost
                                        
                                    +'</td>'
                                +'</tr>'
                                  +'<tr>'
                                    +'<td colspan="2">'
                                        +'<h6 class="m-0 text-right">ภาษี:</h6>'
                                    +'</td>'
                                    +'<td>฿ '+v.vat
                                        
                                    +'</td>'
                                +'</tr>'
                                +'<tr>'
                                    +'<td colspan="2">'
                                        +'<h6 class="m-0 text-right">Total:</h6>'
                                    +'</td>'
                                    +'<td>฿ ' + sum.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                                    +'</td>'
                                +'</tr>'
                        $('#detailOrder').modal('show');
                        $('#trProduct').html(tr);
    }

</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection