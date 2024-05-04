@extends('layouts.master')

@section('title') Sub Category @endsection

@section('css') 

<!-- Lightbox css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}">

@endsection
@section('content')
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
                                    <input type="search" class="form-control" name="sub_category_name" placeholder="name..." value="{{@$query['sub_category_name']}}">
                                        {{-- <i class="fas fa-times search-icon"></i> --}}
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-2 d-inline-block">
                                    <select name="category_id" class="form-control">
                                        @foreach($category as $cate)
                                            <option @empty(!@$query['category_id']) @if($cate->id == $query['category_id']) selected @endif @endempty value="{{$cate->id}}">{{$cate->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3 mb-2 d-inline-block">
                                        <button style="background-color: #556ee6; color:white" class="btn btn-rounded waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; search</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <div class="text-sm-right">
                                <a href="{{$page_url}}/add" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> Add New {{$page}}</a>
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
                                                        if(result.size_not_found){
                                                        // if(result.emp_haved){
                                                            emp += '<a href="javascript:void(0);" class="text-warning" onclick="switch_div(\'div_size_not_found\')"><b>Size not found. <i class="fa fa-angle-down"></i></b><br></a>';
                                                            emp += '<div id="div_size_not_found" style="font-size: 14px;">';
                                                            // emp += '<table>';
                                                            emp += '<div class="row"><div class="col-sm-2"> <b>Row</b></div><div class="col-sm-10"> <b>Size</b></div>';
                                                            result.size_not_found.forEach(element =>{
                                                                emp += '<div class="col-sm-2"> '+element.row+'</div><div class="col-sm-10"> '+element.size+'</div>';
                                                            });
                                                            // emp += '</table>';
                                                            emp += '</div></div>';

                                                        }
                                                        if(result.color_not_found){
                                                        // if(result.emp_haved){
                                                            emp += '<a href="javascript:void(0);" class="text-warning" onclick="switch_div(\'div_color_not_found\')"><b>Color not found. <i class="fa fa-angle-down"></i></b><br></a>';
                                                            emp += '<div id="div_color_not_found" style="font-size: 14px;">';
                                                            // emp += '<table>';
                                                            emp += '<div class="row"><div class="col-sm-2"> <b>Row</b></div><div class="col-sm-10"> <b>Color</b></div>';
                                                            result.color_not_found.forEach(element =>{
                                                                emp += '<div class="col-sm-2"> '+element.row+'</div><div class="col-sm-10"> '+element.color+'</div>';
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
                        <div class="col">
                            <div class="text-sm-right">
                                <a href="{{$page_url}}/export_excel" class="btn btn-success waves-effect waves-light mb-2 mr-2" style="font-size: 15px;"><i class="far fa-file-excel mr-1"></i> </a>
                                <a href="javascript:void(0)" class="btn btn-success waves-effect waves-light mb-2 mr-2" style="font-size: 15px;" onclick="formImportExcel()"><i class="fas fa-file-import mr-1"></i> Import </a>
                            </div>
                        </div><!-- end col-->

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th width="80">Sort</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Series</th>
                                    <th>Date</th>
                                    <th>Action</th>
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
                                        <select onchange="changeSort({{$value->id}},{{$value->sort}},this.value,'{{$module}}')" class="form-control form-control-sm">
                                            @for($i=1;$i<=$sort_count[$value->ref_category_id];$i++)
                                                <option @if ($i == $value->sort) selected @endif value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td>
                                        <div class="zoom-gallery">
                                        {{-- <img src="{{URL::asset('upload/'.$page_url)}}/{{$value->product_image}}" alt=""> --}}
                                        <a class="float-left" href="{{URL::asset('upload/sub_category')}}/{{$value->sub_category_image}}" title="{{$value->sub_category}}"><img width="50px" src="{{URL::asset('upload/sub_category')}}/{{$value->sub_category_image}}" alt="" width="275"></a>
                                        </div>
                                    </td>
                                    <td>{{$value->sub_category_name}}</td>
                                    <td><span class="badge badge-pill font-size-13" style="
                                        border-radius: unset;
                                        background-color: {{$value->category_color}};">{{$value->category_name}}</span>
                                    </td>
                                    <td>
                                            @foreach($value->series as $key => $series)
                                                {{$series->series_name}}
                                                @php
                                                    if($key+1 != count($value->series)){
                                                        echo '<br />';
                                                    }
                                                @endphp
                                            @endforeach
                                    </td>
                                    <td>
                                        {{$value->created_at}}
                                    </td>
                                    <td>
                                        <a href="{{$page_url}}/edit/{{$value->id}}" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                        <a href="javascript: void(0);" onclick="deleteFromTable({{$value->id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                
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
    <!-- end row -->
</div>
@include('layouts/modal')
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

<!-- lightbox init js-->
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
        <script src="{{ URL::asset('admin/js/admin.js')}}"></script>

        <!-- plugin js -->
        <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

        <!-- Sweet alert init js-->
        <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
        <!-- Calendar init -->
        <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
@endsection