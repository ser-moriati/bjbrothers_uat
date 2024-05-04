@extends('layouts.master')

@section('title') Product @endsection

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
                        <div class="col-sm-10">
                            <form method="GET" action="{{$page_url}}">
                                <div class="row">
                                    <div class="row col-sm-10">

                                        <div class="col-sm-3 mb-2 ml-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="product_recommended" id="customCheckS1" @if(@$query['product_recommended']=='Y') checked @endif value="1">
                                                <label class="custom-control-label" for="customCheckS1">Recommended</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 mb-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="product_new" id="customCheckS2" @if(@$query['product_new']=='Y') checked @endif value="1">
                                                <label class="custom-control-label" for="customCheckS2">New</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 mb-2">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="product_hot" id="customCheckS3" @if(@$query['product_hot']=='Y') checked @endif value="1">
                                                <label class="custom-control-label" for="customCheckS3">Hot</label>                                      
                                            </div>
                                        </div>
                                        <div class="col-sm-12"></div>
                                        <div class="col-sm-3 mt-2 search-box mb-2 d-inline-block">
                                            <div class="position-relative">
                                            <input type="search" class="form-control" name="product_code" placeholder="code..." value="{{@$query['product_code']}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3 mt-2 search-box mb-2 d-inline-block">
                                            <div class="position-relative">
                                                <input type="search" class="form-control" name="product_name" placeholder="name..." value="{{@$query['product_name']}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3 mt-2 mb-2 d-inline-block">
                                            <select onchange="subCateByCate(this.value)" name="category_id" class="form-control">
                                                <option value="">Category</option>
                                                @foreach($category as $cate)
                                                    <option @empty(!@$query['category_id']) @if($cate->id == $query['category_id']) selected @endif @endempty value="{{$cate->id}}">{{$cate->category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-3 mt-2 mb-2 d-inline-block">
                                            <select name="sub_category_id" name="sub_category" class="form-control">
                                                <option value="">Sub Category</option>
                                                @foreach($sub_category as $sub_cate)
                                                    <option @empty(!@$query['sub_category_id']) @if($sub_cate->id == $query['sub_category_id']) selected @endif @endempty value="{{$sub_cate->id}}">{{$sub_cate->sub_category_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                <div class="col-sm-2 mb-2 d-inline-block">
                                        <button style="background-color: #556ee6; color:white" class="btn btn-rounded waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; search</button>
                                </div>
                                </div>

                            </form>
                        </div>
                        <div class="col-sm-2">
                            <div class="text-sm-right">
                                <a href="{{$page_url}}/add" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> New {{$page}}</a>
                            </div>
                        </div><!-- end col-->
                        <div class="col-sm-12 btnDeleteAll" style="display: none">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="btnDeleteAll()"><i class="mdi mdi-delete mr-1"></i> Delete all</button>
                            </div>
                        </div><!-- end col-->
                    </div>

                    <script>
                        function formImportExcel(){
                            $('#modalImport').modal('show');
                        }
                        function formImportExcelsku(){
                            $('#modalImportsku').modal('show');
                        }
                    </script>
                        <div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Import Excel
                                    </div>
                                    <div class="modal-body">
                                        
                                    <form action="salesreport/importExcel" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="file" id="file" name="file" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group debug">
                                                
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="checkExcel()" id="sub" class="btn btn-primary">Upload</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    <script>
                                        function checkExcel(){
                                            var input = $('#file').val();
                                                // return console.log(input);
                                                if(input == ''){
                                                    return ;
                                                }
                                                var fd = new FormData();    
                                                // var check_employee = $('').checked();    
                                                fd.append( 'file', $('#file')[0].files[0]);
                                                fd.append( 'check', 1 );
                                                fd.append( '_token', '{{csrf_token()}}' );
                                                if($('#employee_check').is(':checked')){
                                                    fd.append( 'employee_check', 1 );
                                                }
                                                // return console.log(fd);
                                                $('#sub').html('<i class="fa fa-spinner" aria-hidden="true"></i> Upload');
       
                                            $.ajax({
                                                    url: "{{url('/admin/'.$module)}}/importExcel",
                                                    data: fd,
                                                    processData: false,
                                                    contentType: false,
                                                    type: "POST",
                                                    success: function( result ) {
                                                        if(result == true){
                                                            location.reload();
                                                        }
                                                        var emp = '';

                                                        if(result.category_not_found){
                                                        // if(result.emp_haved){
                                                            emp += '<a href="javascript:void(0);" class="text-warning" onclick="switch_div(\'div_category_not_found\')"><b>Category not found. <i class="fa fa-angle-down"></i></b><br></a>';
                                                            emp += '<div id="div_category_not_found" style="font-size: 14px;">';
                                                            // emp += '<table>';
                                                            emp += '<div class="row"><div class="col-sm-2"> <b>Row</b></div><div class="col-sm-10"> <b>Category</b></div>';
                                                            result.category_not_found.forEach(element =>{
                                                                emp += '<div class="col-sm-2"> '+element.row+'</div><div class="col-sm-10"> '+element.name+'</div>';
                                                            });
                                                            // emp += '</table>';
                                                            emp += '</div></div>';
                                                        }
                                                        if(result.sub_category_not_found){
                                                        // if(result.emp_haved){
                                                            emp += '<a href="javascript:void(0);" class="text-warning" onclick="switch_div(\'div_sub_category_not_found\')"><b>Sub Category not found. <i class="fa fa-angle-down"></i></b><br></a>';
                                                            emp += '<div id="div_sub_category_not_found" style="font-size: 14px;">';
                                                            // emp += '<table>';
                                                            emp += '<div class="row"><div class="col-sm-2"> <b>Row</b></div><div class="col-sm-10"> <b>Sub Category</b></div>';
                                                            result.sub_category_not_found.forEach(element =>{
                                                                emp += '<div class="col-sm-2"> '+element.row+'</div><div class="col-sm-10"> '+element.name+'</div>';
                                                            });
                                                            // emp += '</table>';
                                                            emp += '</div></div>';
                                                        }
                                                        if(result.brand_not_found){
                                                        // if(result.emp_haved){
                                                            emp += '<a href="javascript:void(0);" class="text-warning" onclick="switch_div(\'div_brand_not_found\')"><b>Brand not found. <i class="fa fa-angle-down"></i></b><br></a>';
                                                            emp += '<div id="div_brand_not_found" style="font-size: 14px;">';
                                                            // emp += '<table>';
                                                            emp += '<div class="row"><div class="col-sm-2"> <b>Row</b></div><div class="col-sm-10"> <b>Brand</b></div>';
                                                            result.brand_not_found.forEach(element =>{
                                                                emp += '<div class="col-sm-2"> '+element.row+'</div><div class="col-sm-10"> '+element.name+'</div>';
                                                            });
                                                            // emp += '</table>';
                                                            emp += '</div></div>';
                                                        }
                                                       
                                                        $('.debug').html(emp)
                                                        $('#sub').html('Upload');
                                                    },error : function(e){
                                                        // alert(888);
                                                        $('#sub').html('Upload');
                                                        console.log(e)
                                                    }
                                                });
                                        }
                                 function switch_div(div) {
                                     var x = document.getElementById(div);
                                     if (x.style.display === "none") {
                                         x.style.display = "block";
                                     } else {
                                         x.style.display = "none";
                                     }
                                 }
                                    </script>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <div class="modal fade" id="modalImportsku" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        Import Excel
                                    </div>
                                    <div class="modal-body">
                                        
                                    <form action="salesreport/importExcel" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="file" id="file" name="file" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group debug">
                                                
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" onclick="checkExcelsku()" id="sub" class="btn btn-primary">Upload</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                    <script>
                                        function checkExcelsku(){
                                            var input = $('#file').val();
                                                // return console.log(input);
                                                if(input == ''){
                                                    return ;
                                                }
                                                var fd = new FormData();    
                                                // var check_employee = $('').checked();    
                                                fd.append( 'file', $('#file')[0].files[0]);
                                                fd.append( 'check', 1 );
                                                fd.append( '_token', '{{csrf_token()}}' );
                                                if($('#employee_check').is(':checked')){
                                                    fd.append( 'employee_check', 1 );
                                                }
                                                // return console.log(fd);
                                                $('#sub').html('<i class="fa fa-spinner" aria-hidden="true"></i> Upload');
       
                                            $.ajax({
                                                    url: "{{url('/admin/'.$module)}}/importExcelsku",
                                                    data: fd,
                                                    processData: false,
                                                    contentType: false,
                                                    type: "POST",
                                                    success: function( result ) {
                                                        if(result == true){
                                                            location.reload();
                                                        }
                                                        var emp = '';

                                                        $('.debug').html(emp)
                                                        $('#sub').html('Upload');
                                                    },error : function(e){
                                                        // alert(888);
                                                        $('#sub').html('Upload');
                                                        console.log(e)
                                                    }
                                                });
                                        }
                                 function switch_div(div) {
                                     var x = document.getElementById(div);
                                     if (x.style.display === "none") {
                                         x.style.display = "block";
                                     } else {
                                         x.style.display = "none";
                                     }
                                 }
                                    </script>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <div class="col">
                            <div class="text-sm-right">                                
                                <a href="{{$page_url}}/export_excel_sku" class="btn btn-success waves-effect waves-light mb-2 mr-2" style="font-size: 15px;"><i class="far fa-file-excel mr-1"></i> SKU </a>
                                <a href="javascript:void(0)" class="btn btn-success waves-effect waves-light mb-2 mr-2" style="font-size: 15px;" onclick="formImportExcelsku()"><i class="fas fa-file-import mr-1"></i> Import SKU </a>

                                <a href="{{$page_url}}/export_excel" class="btn btn-success waves-effect waves-light mb-2 mr-2" style="font-size: 15px;"><i class="far fa-file-excel mr-1"> Product</i> </a>
                                <a href="javascript:void(0)" class="btn btn-success waves-effect waves-light mb-2 mr-2" style="font-size: 15px;" onclick="formImportExcel()"><i class="fas fa-file-import mr-1"></i> Import Product </a>
                            </div>
                        </div><!-- end col-->
                    <div class="table-responsive">
                        <table class="table table-centered">
                            <thead class="thead-light">
                                <tr>
                                    <th width='1px' style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll"></label>
                                        </div>
                                    </th>
                                    <th width='1px'>#</th>
                                    <th>Picture</th>
                                    <th>Code</th>
                                    <th width="250px">Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th width='100px'>Created</th>
                                    <th width='1px'>#</th>
                                    <th width='1px'>Status</th>
                                    <th width='100px'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkbox-list" onchange="checkList()" id="customCheck{{$num}}" value="{{$value->id}}">
                                            <label class="custom-control-label" for="customCheck{{$num}}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    <td>
                                        <div class="zoom-gallery">
                                        {{-- <img src="{{URL::asset('upload/'.$page_url)}}/{{$value->product_image}}" alt=""> --}}
                                        <a class="float-left" href="{{URL::asset('upload/'.$page_url)}}/{{$value->product_image}}" title="{{$value->product_name}}"><img width="50px" src="{{URL::asset('upload/'.$page_url)}}/{{$value->product_image}}" alt="" width="275"></a>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="color: #e43936">{{$value->product_code}}</span>
                                    @foreach ($value->product_codes as $item)
                                        {{ $item->product_code }}<br />
                                    @endforeach
                                    </td>
                                    <td>{{$value->product_name}}</td>
                                    <td>
                                        <span class="badge badge-pill font-size-13"><b>#{{$value->category_name}}</b></span><br>
                                        #<span>{{$value->sub_category_name}}</span>
                                    </td>
                                    <td>{{$value->min_sale}} - {{$value->max_sale}} </td>
                                    <td>
                                        {{date('d/m/Y H:i:s',strtotime($value->created_at))}}
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck{{$value->id}}1" onchange="changeDescription({{$value->id}},this.checked,'{{$module}}','product_recommended')" @if(@$value->product_recommended=='Y') checked @endif value="1">
                                            <label class="custom-control-label" for="customCheck{{$value->id}}1">Recommended</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck{{$value->id}}2" onchange="changeDescription({{$value->id}},this.checked,'{{$module}}','product_new')" @if(@$value->product_new=='Y') checked @endif value="1">
                                            <label class="custom-control-label" for="customCheck{{$value->id}}2">New</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck{{$value->id}}3" onchange="changeDescription({{$value->id}},this.checked,'{{$module}}','product_hot')" @if(@$value->product_hot=='Y') checked @endif value="1">
                                            <label class="custom-control-label" for="customCheck{{$value->id}}3">Hot</label>                                      
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$value->id}}" onchange="changeStatus({{$value->id}},this.checked,'{{$module}}')" @if ($value->status==1) checked @endif>
                                            <label class="custom-control-label" for="customSwitch{{$value->id}}"><a href="javascript: void(0);"></a></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{$page_url}}/edit/{{$value->id}}" class="text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                        <a href="{{$page_url}}/add/{{$value->id}}" class="text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Clone"><i class="mdi mdi-content-copy font-size-18"></i></a>
                                        <a href="javascript: void(0);" onclick="deleteFromTable({{$value->id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a>
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
@include('layouts/modal')
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')

<script>
    function subCateByCate(id) {
        // return console.log(id);
        var u = '';
        $.ajax({
            type: "GET",
            url: "{{url('/admin/'.$module)}}/subCateByCate/"+id,
            success: function( result ) {
                console.log(result)
                if(result.length == 0){
                    u += '<option selected value="" hidden>not found...</option>';
                }
                result.forEach(element =>{
                    u += '<option value="'+element.id+'">'+element.sub_category_name+'</option>';
                });
                $('#sub_category').html(u);
            },error : function(e){
                console.log(e)
            }
        });

    }
    function changeDescription(id,value,module,field) {
        if(value == true){
            value = 1;
        }else{
            value = 0;
        }
        var token = document.getElementById("token").value;
        $.ajax({
            type: "POST",
            url: module+"/changeDescription",
            data:{
                '_token': token,
                'id': id,
                'field': field,
                'description': value,
            },
            success: function( result ) {
            }
        });
   }
</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection