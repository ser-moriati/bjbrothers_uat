@extends('layouts.master')

@section('title') FAQ @endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

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
                                    <input type="search" class="form-control" name="faq_question" placeholder="question..." value="{{@$query['faq_question']}}">
                                    </div>
                                </div>
                                <div class="col-sm-3 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                    <input type="search" class="form-control" name="faq_answer" placeholder="answer..." value="{{@$query['faq_answer']}}">
                                    </div>
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
                                    <th width='1px'>#</th>
                                    <th width='80px'>Sort</th>
                                    <th width='1px'>Question</th>
                                    <th>Answer</th>
                                    <th width='1px'>Created</th>
                                    <th width='1px'>Updated</th>
                                    <th width='1px'>Action</th>
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
                                        <select onchange="changeSort({{$value->id}},{{$num}},this.value,'{{$module}}')" name="faq_id" id="faq" class="form-control form-control-sm">
                                            @for($i=1;$i<=$lastSort;$i++)
                                                <option @if ($i == $value->sort) selected @endif value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </td>
                                    <td>@empty(!$value->faq_question){{iconv_substr($value->faq_question, 0, 40, "UTF-8")}}...  @endempty</td>
                                    <td>@empty(!$value->faq_answer){{iconv_substr($value->faq_answer, 0, 40, "UTF-8")}}...  @endempty</td>
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
        <!-- Sweet Alerts js -->
        <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

        <!-- Calendar init -->
        <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
@endsection