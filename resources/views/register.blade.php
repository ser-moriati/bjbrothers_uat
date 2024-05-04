<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- SELECT2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
</head>
<style>
    .required{
        color: red;
        }
</style>
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
                            <li>สมัครสมาชิก</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- R E G I S T E R ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h1>สมัครสมาชิก</h1>
                    </div>
                </div>
                <form action="/register" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1">
                        <!---------- U S E R :: I N F O ---------->
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <div class="gray-header">
                                        <div class="gray-header-topic">ข้อมูลผู้ใช้งาน</div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="input-form mt-4">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <p>ชื่อ<span class="required">*</span></p>
                                    <input type="text" name="member_firstname" class="form-control shadow-none" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <p>นามสกุล<span class="required">*</span></p>
                                    <input type="text" name="member_lastname" class="form-control shadow-none" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>อีเมล<span class="required">*</span></p>
                                    <input type="member_email" name="member_email" class="form-control shadow-none set_email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <p>เบอร์โทรศัพท์<span class="required">*</span></p>
                                    <input type="text" name="member_phone" class="form-control shadow-none" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    LINE ID
                                    <input type="text" name="member_line" class="form-control shadow-none">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-1">
                                    <p>ประเภทบุคคลผู้ใช้งาน<span class="required">*</span></p>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-4 col-md-4 col-12 ">
                                    <div class="md-radio md-radio-inline radiocheck">
                                        <input id="type-1" type="radio" name="ref_member_category_id" value="1" required/>
                                        <label for="type-1">ผู้จัดซื้อ</label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="md-radio md-radio-inline radiocheck">
                                        <input id="type-2" type="radio" name="ref_member_category_id" value="2" required/>
                                        <label for="type-2">ผู้ใช้งาน</label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="md-radio md-radio-inline radiocheck">
                                        <input id="type-3" type="radio" name="ref_member_category_id" value="3" required/>
                                        <label for="type-3">เจ้าของธุรกิจ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- P A S S W O R D -->
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <div class="gray-header">
                                        <div class="gray-header-topic">ตั้งรหัสผ่าน</div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="input-form my-4">
                            <div class="row">
                                <div class="col">
                                    <p>อีเมล<span class="required">*</span></p>
                                    <input type="email" name="username" id="username" class="form-control shadow-none" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>รหัสผ่าน<span class="required">*</span></p>
                                    <input type="password" name="password" id="password" class="form-control shadow-none" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <p>ยืนยันรหัสผ่าน<span class="required">*</span></p>
                                    <input type="password" name="confirm_password" id="confirm_password"  class="form-control shadow-none" required>
                                </div>
                            </div>
                        </div>
                    
                    <!---------- C O M P A N Y :: I N F O ---------->
                                <div class="w-100">
                                    <!-- <div class="row">
                                        <div class="col">
                                            <div class="gray-header">
                                                <div class="gray-header-topic">ข้อมูลที่อยู่บริษัท</div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <div class="input-form my-4">
                                    <div class="row">
                                        <div class="col">
                                            <p>ชื่อบริษัท<span class="required">*</span></p>
                                            <input type="text" name="company_name" class="form-control shadow-none" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>เลขผู้เสียภาษี<span class="required"></span></p>
                                            <input type="text" name="member_TaxID" class="form-control shadow-none" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>อีเมล<span class="required">*</span></p>
                                            <input type="email" name="company_email"  id="company_email" class="form-control shadow-none" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <p>เบอร์โทรศัพท์<span class="required">*</span></p>
                                            <input type="text" name="company_phone" class="form-control shadow-none" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            แฟกซ์
                                            <input type="text" name="company_fax" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>ที่อยู่<span class="required">*</span></p>
                                            <textarea name="company_addr" class="form-control shadow-none" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <p>ภาค<span class="required">*</span></p>
                                            <div class="select2-part">
                                                <select class="js-example-basic-single form-control shadow-none" onchange="getProvince(this.value)" name="ref_geographie_id" required>
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
                                                <select class="js-example-basic-single form-control shadow-none" onchange="getAmphures(this.value)" name="ref_province_id" id="province" required>
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
                                                <select class="js-example-basic-single form-control shadow-none" onchange="getDistrict(this.value)" name="ref_amphures_id" id="amphures" required>
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
                                                <select class="js-example-basic-single form-control shadow-none" name="ref_district_id" onchange="getZipcode(this.value)" id="district" required>
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
                                </div> -->
                                
                                <div class="doubleBD pt-4">
                                    <div class="row">
                                        <div class="col">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1">ต้องการสมัครรับจดหมายข่าว</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="g-recaptcha" data-sitekey="6LcQAXEoAAAAAMNDgZCgBp_q2sYxEa1eMd6eAXuk"></div>
                                            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                            <button id="alert"   class="btn buttonBK big mt-4">ยืนยัน</button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                <form>
            </div>
                
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script>
        $(function() {
            $('#alert').click(function() {
                var $confirm_password = $("#confirm_password").val();    
                var $password = $("#password").val();    
                var $recaptcha = $("#g-recaptcha-response").val();    
                if ($confirm_password === $password) {
                   
                    if($recaptcha === ''){
                        alert("กรุณาเลือกฉันไม่ใช่โปรแกรมอัตโนมัติ"); // เพิ่มการแจ้งเตือน
                        return false; // ยกเลิกการ submit
                    }else{
                        $('#shippingForm').submit();
                    }
                } else {
                    alert("รหัสผ่านไม่ตรงกัน"); // เพิ่มการแจ้งเตือน
                    return false; // ยกเลิกการ submit
                }
            });
        });
    </script>
    @include('inc_topbutton')
    @include('inc_footer')
    
    <!-- SELECT2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>

        $(document).ready(function(){
            $('.set_email').change(function(){
                var email = $(this).val();
                $('#username').val(email);
                $('#company_email').val(email);
            });
        });

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
                        $('#province').html(u);
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
                        $('#amphures').html(u);
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
    
</body>
</html>