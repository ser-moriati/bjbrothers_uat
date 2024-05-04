<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    @php
        $memberName = "profile"
    @endphp
</head>
<body>
    <div class="thetop"></div>
    @include('inc_topmenu')
    
    <!--------------- N A V - B A R --------------->
    <div class="navBK">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb">
                            <li><a href="/">หน้าแรก</a></li>
                            <li>บัญชีของฉัน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- M E M B E R :: M Y - A C C O U N T ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    
                    @include('inc_membermenu')
                    
                    <div class="col-lg-9 col-12">
                        <div class="row">
                            <div class="col">
                                <div class="member-topic">
                                    <h3>ข้อมูลสมาชิก</h3>
                                </div> 
                            </div>
                        </div>
                        <!---------- M E M B E R :: U S E R ---------->
                    <form id="accountForm">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="profile-part">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="gray-header decor-none">
                                                <div class="gray-header-topic">ข้อมูลผู้ใช้งาน</div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-3 col-12">
                                            <div class="img-center"><img src="/images/member/icon-user.png"></div>
                                        </div>
                                        <div class="col-lg-12 col-md-3 col-12">
                                            <div class="order-info profile">
                                                <div class="row">
                                                <div class="col-lg-12 col-md-3 col-12">ชื่อ-นามสกุล</div>
                                                    <div id="member_name" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->member_firstname}} {{$member->member_lastname}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">อีเมล</div>
                                                    <div id="member_email" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->member_email}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">เลขผู้เสียภาษี</div>
                                                    <div id="member_TaxID" class="col-lg-12 col-md-3 col-12 inputEdit"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">เบอร์โทรศัพท์</div>
                                                    <div id="member_phone" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->member_phone}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">LINE ID</div>
                                                    <div id="member_line" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->member_line}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">ประเภทผู้ใช้งาน</div>
                                                    <div id="member_category_name" class="col-lg-12 col-md-3 col-12">{{$member->member_category_name}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---------- M E M B E R :: C O M P A N Y ---------->
                                <div class="col-lg-6 col-md-12 col-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="gray-header decor-none">
                                                <div class="gray-header-topic">ข้อมูลบริษัท</div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-3 col-12">
                                            <div class="img-center"><img src="/images/member/icon-building.png"></div>
                                        </div>
                                        <div class="col-lg-12 col-md-3 col-12">
                                            <div class="order-info profile">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">บริษัท</div>
                                                    <div id="company_name" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->company_name}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12"></div>
                                                    <div id="" class="col-lg-12 col-md-3 col-12 inputEdit"></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">อีเมล</div>
                                                    <div id="company_email" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->company_email}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">เบอร์โทรศัพท์</div>
                                                    <div id="company_phone" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->company_phone}}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-3 col-12">แฟกซ์</div>
                                                    <div id="company_fax" class="col-lg-12 col-md-3 col-12 inputEdit">{{$member->company_fax}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <div class="content-center btnSave">
                                        <a class="buttonBK mt-2" href="javascript:void(0);" onclick="EditAccount()"><i class="fas fa-edit"></i>แก้ไขข้อมูล</a>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </form>
                        
                        <div class="row">
                            <div class="col">
                                <div class="member-topic mt-5">
                                    <h3>ที่อยู่จัดส่ง</h3>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="row">
                            <!---------- M E M B E R :: A D D R E S S ---------->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="gray-header decor-none">
                                            <div class="gray-header-topic">ที่อยู่จัดส่งสินค้า</div>
                                        </div> 
                                    </div>
                                    <div class="col">
                                        <a class="button-txt w-header" href="#" data-toggle="modal" data-target=".bs-example-modal-xl" onclick="addAddress()"><i class="fas fa-plus-circle"></i>เพิ่มที่อยู่ใหม่</a>
                                    </div>
                                </div>
                                
                                <div class="member-address">
                                    <!-- ADDRESS :: 01 -->
                                    @foreach ($shipping_address as $k => $item)
                                    <div class="infoBox @if($k==0) default @endif ">
                                        <div class="order-info">
                                            <div class="add-head">
                                                <div class="row">
                                                    <div class="col">@if($k==0) ที่อยู่เริ่มต้น @else ที่อยู่ {{$k+1}} @endif</div>
                                                    @if($k>0)
                                                    <div class="col">
                                                        <button type="button" class="button-txt btn">ตั้งเป็นที่อยู่เริ่มต้น</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="add-info">
                                                        <li>{{$item->firstname.' '.$item->lastname}}</li>
                                                        <li>(Tel. {{$item->phone}})</li>
                                                        <li>(Fax. {{$item->fax}})</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">{{ $item->addr.' '.$item->district_name.' '.$item->amphure_name.' '.$item->province_name.' '.$item->zipcode }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="edit-opption">
                                                        <li><a href="javascript:void(0);" onclick="editAddress({{$item->id}})"><i class="fas fa-pencil-alt"></i>แก้ไข</a></li>
                                                        @if($k!=0)
                                                        <li><a href="javascript:void(0);" onclick="deleteAddress({{$item->id}})"><i class="fas fa-trash-alt"></i>ลบ</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    
                                </div>
                                    
                            </div>
                            <!---------- M E M B E R :: B I L L I N G ---------->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="gray-header decor-none">
                                            <div class="gray-header-topic">ที่อยู่ออกใบกำกับภาษี</div>
                                        </div> 
                                    </div>
                                </div>
                                
                                <div class="member-address">
                                    <!-- ADDRESS :: 01 -->
                                    @foreach ($receipt_address as $k => $item)
                                    <div class="infoBox @if($k==0) default @endif ">
                                        <div class="order-info">
                                            <div class="add-head">
                                                <div class="row">
                                                    <div class="col">@if($k==0) ที่อยู่เริ่มต้น @else ที่อยู่ {{$k+1}} @endif</div>
                                                    @if($k>0)
                                                    <div class="col">
                                                        <button type="button" class="button-txt btn">ตั้งเป็นที่อยู่เริ่มต้น</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="add-info">
                                                        <li>{{$item->firstname.' '.$item->lastname}}</li>
                                                        <li>(Tel. {{$item->phone}})</li>
                                                        <li>(Fax. {{$item->fax}})</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">{{ $item->addr.' '.$item->district_name.' '.$item->amphure_name.' '.$item->province_name.' '.$item->zipcode }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="edit-opption">
                                                        <li><a href="javascript:void(0);" onclick="editAddress({{$item->id}})"><i class="fas fa-pencil-alt"></i>แก้ไข</a></li>
                                                        @if($k!=0)
                                                        <li><a href="javascript:void(0);" onclick="deleteAddress({{$item->id}})"><i class="fas fa-trash-alt"></i>ลบ</a></li>
                                                        @endif
                                                    </ul>
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
    </div>


        <!--  Modal content for the above example -->
        <div class="modal fade bs-example-modal-xl" id="modalAddress" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myExtraLargeModalLabel">เพิ่มที่อยู่ใหม่</h5>
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
                                    <p>เลือกประเภท</p>
                                        <input type="radio" id="address_type1" name="address_type" required value="1" checked><label for="address_type1"> &nbsp;ที่อยู่จัดส่งสินค้า</label><br>
                                        <input type="radio" id="address_type2" name="address_type" required value="2"><label for="address_type2"> &nbsp;ที่อยู่ออกใบเสร็จ</label>
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

    @include('inc_topbutton')
    @include('inc_footer')
    
</body>
</html>
<script>
    function EditAccount(){
        $('.inputEdit').each(function() { 
        var id = $(this).attr('id'); 
        var html = $(this).html(); 
            $('#'+id).html('<div class="form-group"><input name="'+id+'" class="form-control" value="'+html+'"></div>');
        });

        /// category
        var check1 = '';
        var check2 = '';
        var check3 = '';

        if('{{$member->ref_member_category_id}}' == 1) { check1 = 'checked' };
        if('{{$member->ref_member_category_id}}' == 2) { check2 = 'checked' };
        if('{{$member->ref_member_category_id}}' == 3) { check3 = 'checked' };
// alert('{{$member->ref_category_id}}');
        var htnlCategory = '<input id="category_id1" type="radio" name="category_id" '+check1+' value="1" /><label for="category_id1">&nbsp;ผู้จัดซื้อ&nbsp;</label><input '+check2+' id="category_id2" type="radio" name="category_id" value="2" /><label for="category_id2">&nbsp;ผู้ใช้งาน&nbsp;</label><input '+check3+' id="category_id3" type="radio" name="category_id" value="3" /><label for="category_id3">&nbsp;เจ้าของธุรกิจ</label>';
        $('#member_category_name').html(htnlCategory);
        /// and category

        $('.btnSave').html('<a class="buttonBK mt-2" onclick="editForm()" href="javascript:void(0);">บันทึก</a>');
    }
    function addAddress(){
        $('#formAddress').trigger("reset");
        $('#formAddress').attr("action", 'account/address/insert');
    }
    function editAddress(id){
        $('#formAddress').attr("action", 'account/address/update/'+id);
        $('#modalAddress').modal('show');
        $.ajax({
            type: "GET",
            url: "{{url('account/address/')}}/"+id,
            success: function($data) {
                if($data.address_type == 1){
                    $('#address_type1').prop('checked',true);
                    $('#address_type2').prop('checked',false);

                }else{
                    $('#address_type1').prop('checked',false);
                    $('#address_type2').prop('checked',true);

                }

                $('#firstname').val($data.firstname);
                $('#lastname').val($data.lastname);
                $('#phone').val($data.phone);
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
    function deleteAddress(id){
        $.ajax({
            type: "POST",
            url: "{{url('account/address/delete')}}/"+id,
            data: {_token:'{{csrf_token()}}'},
            success: function($data) {
                location.reload();
            }
        });
        
    }
    function editForm(){
        $.ajax({
            type: "POST",
            url: "{{url('account/update')}}/"+'{{$member->id}}',
            data: $("#accountForm").serialize(),
            success: function($data,textStatus,xhr) {
                console.log(xhr.status);
                $.each($data, function(k,v) { 
                    $('#'+k).html(v);
                });
                $('.btnSave').html('<a class="buttonBK mt-2" href="javascript:void(0);" onclick="EditAccount()"><i class="fas fa-edit"></i>แก้ไขข้อมูล</a>');
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