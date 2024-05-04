@extends('layouts.master')

@section('title') Customer @endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div id="changeRoleSuccess" class="alert alert-success" style="display: none">
    The role has been changed.
</div>

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
                        <div class="col-sm-12">
                            <form method="GET" action="{{$page_url}}">
                                <div class="col-sm-2 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                    <input type="search" class="form-control" name="member_name" placeholder="name..." value="{{@$query['member_name']}}">
                                        {{-- <i class="fas fa-times search-icon"></i> --}}
                                    </div>
                                </div>
                                <div class="col-sm-2 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="search" class="form-control" name="company_name" placeholder="company..." value="{{@$query['company_name']}}">
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-2 mb-2 d-inline-block">
                                    <select name="category_id" class="form-control">
                                        <option value="">Category</option>
                                        @foreach($category as $cate)
                                            <option @empty(!@$query['category_id']) @if($cate->id == $query['category_id']) selected @endif @endempty value="{{$cate->id}}">{{$cate->category_name}}</option>
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
                                    <th width='1px' style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll"></label>
                                        </div>
                                    </th>
                                    <th width='1px'>#</th>
                                    {{-- <th>Quotation Number</th> --}}
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Category</th>
                                    <th>Role</th>
                                    {{-- <th>Payment Status</th>
                                    <th>Payment Method</th> --}}
                                    <th width="1px">View Details</th>
                                    <th width="1px">Action</th>
                                    <th width="1px">Date Register</th>
                                    <th width="1px">View order</th>
                                    <th width="1px">Edit</th>
                                    <th width="1px">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                                            <label class="custom-control-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    {{-- <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{$value->number}}</a> </td> --}}
                                    <td>{{$value->member_firstname}} {{$value->member_lastname}}</td>
                                    <td>
                                        {{$value->company_name}}
                                    </td>
                                    <td>
                                        {{$value->category_name}}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" id="changeRole{{ $value->id }}" onclick="changeRole({{ $value->id }}, {{ $value->ref_role_id }})">
                                            <span style="color: rgb(74, 74, 74)" id="member_role{{ $value->id }}">
                                                {{$value->role_name}}
                                            </span>
                                            <span class="text-warning">
                                                <i class="bx bx-edit-alt"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="modal({{$value}})">
                                          View Details
                                        </button>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch mb-2" dir="ltr">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$value->id}}" onchange="changeStatus({{$value->id}},this.checked,'{{$module}}')" @if ($value->member_active==1) checked @endif>
                                            <label class="custom-control-label" for="customSwitch{{$value->id}}"><a href="javascript: void(0);"></a></label>
                                        </div>
                                    </td>
                                    <td>
                                        {{date('d/m/Y', strtotime($value->created_at))}}
                                    </td>
                                    <td>
                                        <a href="https://www.bjbrothers.com/admin/order?order_number=&customer_name={{$value->member_firstname}} {{$value->member_lastname}}&status_id=" class="mr-3 text-primary" >Order</a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" onclick="modal_edit({{$value}})"><i class="fas fa-pencil-alt"></i>แก้ไข</a>
                                    </td>
                                    <td>
                                    <a href="javascript: void(0);" onclick="deleteFromTablebaner({{$value->id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a>
                                    
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
                    <div class="col-6">
                        <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                    </div>
                    <div class="col-6">
                        <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2">First Name : &nbsp;<span id="mFirstName" class="text-primary"></span></p>
                            <p class="mb-2">Email : &nbsp;<span id="mEmail" class="text-primary"></span></p>
                            <p class="mb-2">Phone : &nbsp;<span id="mPhone" class="text-primary"></span></p>
                            <p class="mb-2">Line : &nbsp;<span id="mLine" class="text-primary"></span></p>
                            <p class="mb-2">Category : &nbsp;<span id="mCategory" class="text-primary"></span></p>
                        </div>
                        <div class="col-6">
                            <p class="mb-2">Company : &nbsp;<span id="mComName" class="text-primary"></span></p>
                            <p class="mb-2">Email : &nbsp;<span id="mComEmail" class="text-primary"></span></p>
                            <p class="mb-2">Phone : &nbsp;<span id="mComPhone" class="text-primary"></span></p>
                            <p class="mb-2">Fax : &nbsp;<span id="mComFax" class="text-primary"></span></p>
                            <p class="mb-2">Address : &nbsp;<span id="mComAddress" class="text-primary"></span></p>
                        </div>
                    </div>
                    <p class="mb-2" id="mShipingAddress"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <form id="newsForm" action="{{url('admin/member/update')}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal fade exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="detailOrder_edit">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-6">
                            <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
                        </div>
                        <div class="col-6">
                            <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <p class="mb-2">First Name : &nbsp;<span id="mFirstName_edit" class="text-primary"></span></p>
                                <p class="mb-2">Last Name : &nbsp;<span id="mLastName_edit" class="text-primary"></span></p>
                                <p class="mb-2">Email : &nbsp;<span id="mEmail_edit" class="text-primary"></span></p>
                                <p class="mb-2">Phone : &nbsp;<span id="mPhone_edit" class="text-primary"></span></p>
                                <p class="mb-2">Line : &nbsp;<span id="mLine_edit" class="text-primary"></span></p>
                                <p class="mb-2">Category : &nbsp;<span id="mCategory_edit" class="text-primary"></span></p>
                            </div>
                            <div class="col-6">
                                <p class="mb-2">Company : &nbsp;<span id="mComName_edit" class="text-primary"></span></p>
                                <p class="mb-2">Email : &nbsp;<span id="mComEmail_edit" class="text-primary"></span></p>
                                <p class="mb-2">Phone : &nbsp;<span id="mComPhone_edit" class="text-primary"></span></p>
                                <p class="mb-2">Fax : &nbsp;<span id="mComFax_edit" class="text-primary"></span></p>
                                <p class="mb-2">Tax ID : &nbsp;<span id="mComTax_edit" class="text-primary"></span></p>
                                <!-- <p class="mb-2">Address : &nbsp;<span id="mComAddress_edit" class="text-primary"></span></p> -->
                            </div>
                        </div>
                        <p class="mb-2" id="mShipingAddress"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="formChange">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    Change Role
                </div>
                <div class="modal-body">
                    <select class="form-control" name="" id="role">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="saveChangeRole()">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

     <!--  Modal content for the above example -->
     <div class="modal fade bs-example-modal-xl" id="modalAddress" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">แก้ไขข้อมูล</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="account/address/insert" method="POST" id="formAddress">
                            @csrf
                        <div class="input-form">
                            <div class="row">
                                <div class="col">
                                    <!-- <p>เลือกประเภท</p>
                                        <input type="radio" id="address_type1" name="address_type" required value="1" checked><label for="address_type1"> &nbsp;ที่อยู่จัดส่งสินค้า</label><br>
                                        <input type="radio" id="address_type2" name="address_type" required value="2"><label for="address_type2"> &nbsp;ที่อยู่ออกใบเสร็จ</label> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>ชื่อ<span class="required">*</span></p>
                                    <input type="text" id="firstname" name="firstname" class="form-control shadow-none" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>นามสกุล<span class="required">*</span></p>
                                    <input type="text" id="lastname" name="lastname" class="form-control shadow-none" required>
                                </div>
                            </div>
                            {{-- <div class="row"> --}}
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>เบอร์โทรศัพท์<span class="required">*</span></p>
                                        <input type="text" id="phone" name="phone" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        แฟกซ์
                                        <input type="text" id="fax" name="fax" class="form-control shadow-none">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <p>ที่อยู่<span class="required">*</span></p>
                                        <textarea id="addr" name="addr" class="form-control shadow-none" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>ภาค<span class="required">*</span></p>
                                        <div class="select2-part">
                                            <select class="js-example-basic-single form-control shadow-none" onchange="getProvince(this.value)" id="ref_geographie_id" name="ref_geographie_id" required>
                                                <option value="">เลือก</option>
                                                @foreach($geographie as $geog)
                                                    <option value="{{$geog->id}}">{{$geog->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>จังหวัด<span class="required">*</span></p>
                                        <div class="select2-part">
                                            <select class="js-example-basic-single form-control shadow-none" onchange="getAmphures(this.value)" id="ref_province_id" name="ref_province_id" required>
                                                <option value="">เลือก</option>
                                                @foreach($province as $prov)
                                                    <option value="{{$prov->id}}">{{$prov->name_th}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>เขต/อำเภอ<span class="required">*</span></p>
                                        <div class="select2-part">
                                            <select class="js-example-basic-single form-control shadow-none" onchange="getDistrict(this.value)" id="ref_amphures_id" name="ref_amphures_id" required>
                                                <option value="">เลือก</option>
                                                @foreach($amphures as $amph)
                                                    <option value="{{$amph->id}}">{{$amph->name_th}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>แขวง/ตำบล<span class="required">*</span></p>
                                        <div class="select2-part">
                                            <select class="js-example-basic-single form-control shadow-none" id="ref_district_id" name="ref_district_id" onchange="getZipcode(this.value)" id="district" required>
                                                <option value="">เลือก</option>
                                                @foreach($district as $distr)
                                                    <option value="{{$distr->id}}">{{$distr->name_th}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        รหัสไปรษณีย์
                                        <input type="text" name="zipcode" id="zipcode" class="form-control shadow-none">
                                    </div>
                                </div>
                                <button type="submit" class="btn buttonBK big mt-4">บันทึก</button>
                            </div>
                        {{-- </div> --}}
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

@include('layouts/modal')
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
<script>
    var member_change_id = 0;
    var role_old_id = '';
    function changeRole(id, role_id){
        role_old_id = role_id;
        member_change_id = id;
        $('#role').val(role_id);
        // alert(545);
        $('#formChange').modal();
    }
    function saveChangeRole(){
        var role_id = $('#role').val();
        if(role_old_id == role_id){
            $('#formChange').modal('hide');
            return;
        }
                $.ajax({
                    type: "POST",
                    url: "/admin/member/change_role",
                    data: {_token: "{{ csrf_token() }}", id: member_change_id, role_id: role_id},
                    success: function( result ) {
                        $('#member_role'+member_change_id).html(result);
                        $('#changeRole'+member_change_id).attr('onclick','changeRole('+member_change_id+','+role_id+')');
                        $('#formChange').modal('hide');
                        // location.reload();
                        $('#changeRoleSuccess').show();
                    },error : function(e){
                        // location.reload();
                        console.log(e)
                    }
                });
    }
    function modal(v){
        var tr = '';
        tr += '<hr>';
        tr += 'Shipping Address : &nbsp;';
        v.address.forEach(el => {
            if(el.address_type == 1){
                tr += '<span class="text-primary">'+el.firstname+' '+el.lastname+' '+el.addr+' '+el.district.name_th+' '+el.amphures.name_th+' '+el.province.name_th+' '+el.zipcode+'</span> <mark>Default</mark><br>';
            }
        });
        tr += '<hr>';
        tr += 'Receipt Address : &nbsp;';
        v.address.forEach(el => {
            if(el.address_type == 2){
                tr += '<span class="text-primary">'+el.firstname+' '+el.lastname+' '+el.addr+' '+el.district.name_th+' '+el.amphures.name_th+' '+el.province.name_th+' '+el.zipcode+'</span> <mark>Default</mark><br>';
            }
        });
        $('#mFirstName').html(v.member_firstname+' '+v.member_lastname);
        $('#mEmail').html(v.member_email);
        $('#mPhone').html(v.member_phone);
        $('#mLine').html(v.member_line);
        $('#mCategory').html(v.category_name);
        $('#mComName').html(v.company_name);
        $('#mComEmail').html(v.company_email);
        $('#mComPhone').html(v.company_phone);
        $('#mComFax').html(v.company_fax);
        $('#mComAddress').html(v.company_addr+' '+v.districts_name+' '+v.amphure_name+' '+v.provinces_name+' '+v.zipcode);
        $('#mShipingAddress').html(tr);
        $('#detailOrder').modal('show');
     
    }
    function modal_edit(v){
        var tr = '';
        tr += '<hr>';
        tr += 'Shipping Address : &nbsp;';
        v.address.forEach(el => {
            if(el.address_type == 1){
                tr += '<span class="text-primary">'+el.firstname+' '+el.lastname+' '+el.addr+' '+el.district.name_th+' '+el.amphures.name_th+' '+el.province.name_th+' '+el.zipcode+'</span> <mark>Default</mark><br>';
            }
        });
        tr += '<hr>';
        tr += 'Receipt Address : &nbsp;';
        v.address.forEach(el => {
            if(el.address_type == 2){
                tr += '<span class="text-primary">'+el.firstname+' '+el.lastname+' '+el.addr+' '+el.district.name_th+' '+el.amphures.name_th+' '+el.province.name_th+' '+el.zipcode+'</span> <mark>Default</mark><br>';
            }
        });
        $('#mFirstName_edit').html('<input type="text" name="member_firstname" class="form-control shadow-none" value="'+v.member_firstname+'"><input type="hidden" name="id" class="form-control shadow-none" value="'+v.id+'"> ');
        $('#mLastName_edit').html('<input type="text" name="member_lastname" class="form-control shadow-none" value="'+v.member_lastname+'"> ');
        $('#mEmail_edit').html('<input type="text" name="member_email" class="form-control shadow-none" value="'+v.member_email+'">');
        $('#mPhone_edit').html('<input type="text" name="member_phone" class="form-control shadow-none" value="'+v.member_phone+'">');
        $('#mLine_edit').html('<input type="text" name="member_line" class="form-control shadow-none" value="'+v.member_line+'">');
        $('#mCategory_edit').html('<input type="text" name="category_name" class="form-control shadow-none" value="'+v.category_name+'">');
        $('#mComName_edit').html('<input type="text" name="company_name" class="form-control shadow-none" value="'+v.company_name+'">');
        $('#mComEmail_edit').html('<input type="text" name="company_email" class="form-control shadow-none" value="'+v.company_email+'">');
        $('#mComPhone_edit').html('<input type="text" name="company_phone" class="form-control shadow-none" value="'+v.company_phone+'">');
        $('#mComFax_edit').html('<input type="text" name="company_fax" class="form-control shadow-none" value="'+v.company_fax+'">');
        $('#mComTax_edit').html('<input type="text" name="member_TaxID" class="form-control shadow-none" value="'+v.member_TaxID+'">');
        // $('#mComAddress_edit').html('<input type="text" name="company_address" class="form-control shadow-none"  value="'+v.company_addr+' '+v.districts_name+' '+v.amphure_name+' '+v.provinces_name+' '+v.zipcode+'">');

        $('#mShipingAddress_edit').html(tr);
        $('#detailOrder_edit').modal('show');
     
    }
</script>
<script>
    
       
    function addAddress(){
        $('#formAddress').trigger("reset");
        $('#formAddress').attr("action", 'account/address/insert');
    }
    function editAddress(value){
        $('#formAddress').attr("action", 'account/address/update/'+value.id);
        $('#modalAddress').modal('show');
        $.ajax({
            type: "GET",
            url: "{{url('account/address/')}}/"+value.id,
            success: function($data) {
                if($data.address_type == 1){
                    $('#address_type1').prop('checked',true);
                    $('#address_type2').prop('checked',false);

                }else{
                    $('#address_type1').prop('checked',false);
                    $('#address_type2').prop('checked',true);

                }

                $('#firstname').val(value.member_firstname);
                $('#lastname').val(value.member_lastname);
                $('#phone').val(value.member_phone);
                $('#fax').val($data.fax);
                $('#addr').val($data.addr);
                $('#ref_geographie_id').val($data.ref_geographie_id);
                $('#ref_province_id').val($data.ref_province_id);
                $('#ref_amphures_id').val($data.ref_amphures_id);
                $('#ref_district_id').val($data.ref_district_id);
                $('#zipcode').val($data.zipcode);

                // location.reload();
            }
        });
        
    }
   
    
        function getProvince(id){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getProvince/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.name_th+'</option>';
                        });
                        $('#ref_province_id').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getAmphures(id){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getAmphures/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.name_th+'</option>';
                        });
                        $('#ref_amphures_id').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getDistrict(id){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getDistrict/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.name_th+'</option>';
                        });
                        $('#district').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getZipcode(id){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getZipcode/"+id,
                    success: function( result ) {
                        $('#zipcode').val(result);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
        <script >
        function deleteFromTablebaner(id){
            $('#exampleModalScrollable').modal('show');
            $('.confirmDelete').attr("id",id);
        }
        function deleteData(module) {
            var id = $('.confirmDelete').attr("id");
            var token = document.getElementById("token").value;
            $.ajax({
                type: "DELETE",
                url: "{!! url('admin/member/delete/"+id+"') !!}",
                data:{
                    '_token': token,
                },
                success: function( result ) {
                    if(result == 1){
                        $('#exampleModalScrollable').modal('hide');
                        $('#deleteSuccess').modal('show');
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }else{
                    }
                }   
            });
        }
    </script>
@endsection