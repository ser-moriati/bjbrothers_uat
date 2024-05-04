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

<link href="{{ URL::asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">


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
                            <form method="GET" action="">
                                <div class="row">
                                    <div class="row col-sm-10">

                                        <div class="col-sm-6 mb-2 ml-2">
                                            {{-- <div> --}}
                                                <div class="input-daterange input-group" data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true" >
                                                    <input name="date_start" type="text" class="form-control" @if (@$query['date_start']) value="{{@$query['date_start']}}" @endif autocomplete='off' required/> &nbsp; <span class='mt-2'>to</span> &nbsp;
                                                    <input name="date_end" type="text" class="form-control" @if (@$query['date_end']) value="{{@$query['date_end']}}" @endif autocomplete='off' required/>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-sm-2 mb-2 d-inline-block">
                                                <button style="background-color: #556ee6; color:white" class="btn btn-rounded waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; search</button>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                        {{-- clear/delete?date_start={{@$query['date_start']}}&date_end={{@$query['date_end']}} --}}
                        <div class="col-sm-2">
                            <div class="text-sm-right">
                                <a href="javascript:void(0);" class="btn btn-danger btn-rounded waves-effect waves-light mb-2 mr-2" @if ($total == 0) style="pointer-events: none; opacity: 0.4;" @endif onclick="cleared()"><i class="mdi mdi-database-remove mr-1"></i> clear</a>
                            </div>
                        </div><!-- end col-->
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
                                    <th>Picture</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th width='100px'>Created</th>
                                    <th width='1px'>#</th>
                                    <th width='1px'>Status</th>
                                    {{-- <th width='1px'>Action</th> --}}
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
                                    <td>{{$value->product_code}}</td>
                                    <td>{{$value->product_name}}</td>
                                    <td>
                                        <span class="badge badge-pill font-size-13"><b>#{{$value->category_name}}</b></span><br>
                                        #<span>{{$value->sub_category_name}}</span>
                                    </td>
                                    <td>{{$value->product_price}}</td>
                                    <td>
                                        {{date('d/m/Y H:i:s',strtotime($value->created_at))}}
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input disabled type="checkbox" class="custom-control-input" id="customCheck{{$value->id}}1" onchange="changeDescription({{$value->id}},this.checked,'{{$module}}','product_recommended')" @if(@$value->product_recommended=='Y') checked @endif value="1">
                                            <label class="custom-control-label" for="customCheck{{$value->id}}1">Recommended</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input disabled type="checkbox" class="custom-control-input" id="customCheck{{$value->id}}2" onchange="changeDescription({{$value->id}},this.checked,'{{$module}}','product_new')" @if(@$value->product_new=='Y') checked @endif value="1">
                                            <label class="custom-control-label" for="customCheck{{$value->id}}2">New</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input disabled type="checkbox" class="custom-control-input" id="customCheck{{$value->id}}3" onchange="changeDescription({{$value->id}},this.checked,'{{$module}}','product_hot')" @if(@$value->product_hot=='Y') checked @endif value="1">
                                            <label class="custom-control-label" for="customCheck{{$value->id}}3">Hot</label>                                      
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$value->id}}" onchange="changeStatus({{$value->id}},this.checked,'{{$module}}')" @if ($value->status==1) checked @endif  disabled>
                                            <label class="custom-control-label" for="customSwitch{{$value->id}}"><a href="javascript: void(0);"></a></label>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <a href="{{$page_url}}/edit/{{$value->id}}" class="mr-1 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                        <a href="{{$page_url}}/add/{{$value->id}}" class="mr-1 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Clone"><i class="mdi mdi-content-copy font-size-18"></i></a>
                                        <a href="javascript: void(0);" onclick="deleteFromTable({{$value->id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a>
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
@include('layouts/modal')

{{-- clear clear clear clear clear clear clear clear --}}
{{-- clear clear clear clear clear clear clear clear --}}
{{-- clear clear clear clear clear clear clear clear --}}
{{-- clear clear clear clear clear clear clear clear --}}

<div class="modal fade" id="modalClearAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">Are you sure?</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                <div class="swal2-content"><div id="swal2-content" style="display: block;">You won't be able to revert this!</div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                <div class="swal2-actions"><button type="button" class="swal2-confirm swal2-styled confirmClear" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="clearAll()">Yes, clear it!</button><button onclick="cancelClear()" type="button" class="swal2-cancel swal2-styled" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">Cancel</button></div>
                {{-- <p> Are you sure?
                    You won't be able to revert this!</p> --}}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="clearSuccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="swal2-header">
                <div class="swal2-icon swal2-question" style="display: none;"></div>
                <div class="swal2-icon swal2-warning" style="display: none;"></div>
                <div class="swal2-icon swal2-info" style="display: none;"></div>
                <div class="swal2-icon swal2-success swal2-animate-success-icon" style="display: flex;">
                    <div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div>
                    <span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span>
                    <div class="swal2-success-ring"></div> 
                    <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div>
                    <div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div>
                </div>
                <img class="swal2-image" style="display: none;">
                <h2 class="swal2-title" id="swal2-title" style="display: flex;">Clear Successfully!</h2>
                <button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button>
            </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
        <!-- Magnific Popup-->
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
        
<script>
    function cleared(){
        console.log(1254);
        $('#modalClearAll').modal('show');
    }
     function clearAll() {
        var token = document.getElementById("token").value;
        $.ajax({
            type: "POST",
            url: "clear/delete",
            data:{
                '_token': token,
                'date_start': "{{@$query['date_start']}}",
                'date_end': "{{@$query['date_end']}}",
            },
            success: function( result ) {
                if(result == 1){
                    $('#modalClearAll').modal('hide');
                    $('#clearSuccess').modal('show');
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                }
            }   
        });
    }
    function cancelClear(){
        $('#exampleModalScrollable').modal('hide');
        $('#modalClearAll').modal('hide');
    }
</script>
@endsection