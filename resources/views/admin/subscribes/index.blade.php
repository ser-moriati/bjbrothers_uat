@extends('layouts.master')

@section('title') Subscribe @endsection

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
                                    <input type="search" class="form-control" name="email" placeholder="email..." value="{{@$query['email']}}">
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
                                    <th align="center" width='50%'>Email</th>
                                    <th>Date Subscribe</th>
                                    {{-- <th>Action</th> --}}
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
                                    <td>
                                        <!-- Button trigger modal -->
                                          {{$value->email}}
                                    </td>
                                    <td>
                                        {{date('d/m/Y', strtotime($value->created_at))}}
                                    </td>
                                    {{-- <td>
                                        <a href="javascript:void(0);" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                        <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                    </td> --}}
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
        var quotation_total = 0;
        var tr = '';
        console.log(v.quotation_details);
                    v.quotation_details.forEach(el => {
                            tr += '<tr>'
                                    +'<th scope="row">'
                                        +'<div>'
                                            +'<img src="/upload/product/'+el.product.product_image+'" alt="" class="avatar-sm">'
                                        +'</div>'
                                    +'</th>'
                                    +'<td>'
                                        +'<div>'
                                            +'<h5 class="text-truncate font-size-14">'+el.product.product_name+'('+el.color.color_name+')'+'('+el.size.size_name+')</h5>'
                                            +'<p class="text-muted mb-0">฿ '+el.product.product_price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+' x '+el.qty+'</p>'
                                        +'</div>'
                                    +'</td>'
                                    +'<td>฿ '+(el.product.product_price*el.qty).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')+'</td>'
                                +'</tr>';
                                quotation_total = parseInt(quotation_total)+parseInt(el.product.product_price*el.qty);
                        });
                        tr += '<tr>'
                                    +'<td colspan="2">'
                                        +'<h6 class="m-0 text-right">Sub Total:</h6>'
                                    +'</td>'
                                    +'<td>฿' +quotation_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                                    +'</td>'
                                +'</tr>'
                                +'<tr>'
                                    +'<td colspan="2">'
                                        +'<h6 class="m-0 text-right">Shipping:</h6>'
                                    +'</td>'
                                    +'<td>'
                                        
                                    +'</td>'
                                +'</tr>'
                                +'<tr>'
                                    +'<td colspan="2">'
                                        +'<h6 class="m-0 text-right">Total:</h6>'
                                    +'</td>'
                                    +'<td>฿' +quotation_total.toFixed(2).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
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