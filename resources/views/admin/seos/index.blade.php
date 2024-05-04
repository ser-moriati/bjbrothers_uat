@extends('layouts.master')

@section('title') SEO @endsection

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
    <form id="productForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <div class="row">
                        <div class="col-md-2">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach ($list_data as $k => $value)
                                <a class="nav-link mb-2 @if($k==0) active @endif" id="v-pills-{{$value->id}}-tab" data-toggle="pill" href="#v-pills-{{$value->id}}" role="tab" aria-controls="v-pills-{{$value->id}}" aria-selected="true">{{$value->module}}</a>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                @foreach ($list_data as $k1 => $value1)
                                    <div class="tab-pane fade show @if($k1==0) active @endif" id="v-pills-{{$value1->id}}" role="tabpanel" aria-labelledby="v-pills-{{$value1->id}}-tab">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                <label for="metatitle{{$k1}}">Meta Title</label>
                                                    <textarea class="form-control" id="meta_title{{$k1}}" name="meta[{{$value1->id}}][meta_title]" placeholder="Meta Title" rows="2">{{$value1->meta_title}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="metakeywords{{$k1}}">Meta Keywords</label>
                                                    <textarea class="form-control" id="meta_keywords{{$k1}}" name="meta[{{$value1->id}}][meta_keywords]" placeholder="Meta Keywords" rows="2">{{$value1->meta_keywords}}</textarea>
                                                </div>
                                            </div>
                        
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="metadescription{{$k1}}">Meta Description</label>
                                                    <textarea class="form-control" id="meta_description{{$k1}}" name="meta[{{$value1->id}}][meta_description]" placeholder="Meta Description" rows="3">{{$value1->meta_description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-sm-12">
        <div class="form-group">
            <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                {{-- <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a> --}}
                </div>
            </div>
</form>



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