@extends('layouts.master')

@section('title') Project @endsection

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
                                        <input type="search" class="form-control" name="project_name" placeholder="name..." value="{{@$query['project_name']}}">
                                    </div>
                                </div>
                                <div class="col-sm-3 mb-2 d-inline-block">
                                        <button style="background-color: #556ee6; color:white" class="btn btn-rounded waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; search</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3">
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

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Address</th>
                                    <th>Detail</th>
                                    <th>Category</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkbox-list" onchange="checkList()" id="customCheck{{$num}}" value="{{$value->id}}">
                                            <label class="custom-control-label" for="customCheck{{$num}}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    <td>
                                        <div class="zoom-gallery">
                                        {{-- <img src="{{URL::asset('upload/'.$page_url)}}/{{$value->project_image}}" alt=""> --}}
                                        <a class="float-left" href="{{URL::asset('upload/'.$page_url)}}/{{$value->project_image}}" title="{{$value->project_name}}"><img width="50px" src="{{URL::asset('upload/'.$page_url)}}/{{$value->project_image}}" alt="" width="275"></a>
                                        </div>
                                    </td>
                                    <td>{{$value->project_name}}</td>
                                    <td>{{$value->project_owner}}</td>
                                    <td>{{$value->project_address}}</td>
                                    <td>@empty(!$value->project_detail){{iconv_substr(str_replace("|i|"," | ",$value->project_detail), 0, 30, "UTF-8")}}...  @endempty</td>
                                    <td>{{$value->project_category_name}}</td>
                                    <td>
                                        {{$value->created_at}}
                                    </td>
                                    <td>
                                        {{$value->updated_at}}
                                    </td>
                                    <td>
                                        <a href="{{$page_url}}/edit/{{$value->id}}" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
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
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection