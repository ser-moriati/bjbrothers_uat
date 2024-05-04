<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    <div class="thetop"></div>
    @include('inc_topmenu')
    
    <!--------------- N A V - B A R --------------->
    <div class="navBK mobile-none">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb">
                            <li><a href="/">หน้าแรก</a></li>
                            <li>เข้าสู่ระบบ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- L O G I N ---------->
    <div class="content-padding pad-foot pt-4">
        <div class="container-fluid">
            <div class="wrap-pad">
                {{-- <div class="row">
                    <div class="col">
                        <div class="img-width mb-5"><img src="{{URL::asset('images/member/banner-login.jpg')}}"></div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col">
                        <h1>เข้าสู่ระบบ</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1">
                        <form method="POST" action="{{url('/login')}}" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-form more-padR">
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-12 offset-lg-2">
                                    <div class="row">
                                        <div class="col">
                                            <p>อีเมล</p>
                                            <input name="email" type="email" class="form-control shadow-none" autofocus>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>รหัสผ่าน</p>
                                            <input name="password" type="password" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <!--<a class="button-txt" href="reset_password.php">ลืมรหัสผ่าน</a>-->
                                            
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn button-txt" data-toggle="modal" data-target="#staticBackdrop">ลืมรหัสผ่าน</button>

                                            <!-- Modal -->

                                        </div>
                                    </div>
                                    <div class="login-button-section mt-3">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <button type="submit" class="buttonBK btn big">เข้าสู่ระบบ</button>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <!--<div class="f-14">คุณยังไม่มีบัญชีของ BJ Brothers ใช่หรือไม่</div>-->
                                                <a class="buttonBD" href="/register">สมัครสมาชิก</a>
                                            </div>
                                        </div>
                                        <!--<div class="row">
                                            <div class="col">
                                                <div class="f-14">คุณยังไม่มีบัญชีของ BJ Brothers ใช่หรือไม่</div>
                                                <a class="buttonBD" href="register.php">สมัครสมาชิก</a>
                                            </div>
                                        </div>-->
                                    </div>
                                    
                                </div>
                            </div>
                                    
                        </div>
                        </form>
                    </div>
                </div>  
                
                <div class="modal fade form-modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 id="staticBackdropLabel">ขอรหัสผ่านใหม่</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="input-form">
                                    <div class="row">
                                        <div class="col">
                                            <p>กรุณาใส่อีเมลที่ใช้ในการเข้าสู่ระบบ และเราจะดำเนินการส่งรหัสผ่านไปยังอีเมลที่ระบุไว้</p>
                                            <input type="email" id="email_forgot" class="form-control shadow-none" placeholder="Email" name="email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn buttonBK" onclick="sendEmailForgot()" id="cormfirmForgot">ยืนยัน</button>
                                <button type="button" class="btn buttonBD" data-dismiss="modal">ยกเลิก</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')

    <!-- SELECT2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    
    <script>
        function sendEmailForgot(){
            // ().
            var email = $('#email_forgot').val();
            if(email == ''){
                return;
            }
            // return $.simplyToast("danger", "เกิดข้อผิดพลาด");
            $.ajax({
                type: "POST",
                url: "/forgot/sendEmail",
                data:{
                    '_token': '{{ csrf_token() }}',
                    'email': email,
                },
                success: function( result ) {
                    // if(result == 1){
                        // $('#modalDeleteAll').modal('hide');
                        $.simplyToast(result.status, result.massage);
                        $('#staticBackdrop').modal('hide');
                        // setTimeout(function(){
                        //     location.reload();
                        // }, 1000);
                    // }else{
                    // }
                }   
            });
        }
        
        $('#switch').on("change", function() {
            if ($('#switch').is(':checked')) {
                $('.box01').slideDown();
            } else {
                $('.box01').slideUp();
            }
        });
        
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    
</body>
</html>




                {{-- <div class="login-section">
                    <!---------- L O G I N ---------->
                    <div class="row">
                        <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1">
                            <div class="accordion">
                                <div class="row">
                                    <div class="col">
                                        <div class="md-radio md-radio-inline radiocheck">
                                            <input id="payment-1" type="radio" name="payment-group" checked />
                                            <label for="payment-1">
                                                <p><i class="fas fa-sign-in-alt"></i>เข้าสู่ระบบ</p>
                                            </label>
                                            <section>
                                            <form method="POST" action="/login" class="form-horizontal">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="accBDbottom">
                                                    <div class="input-form more-padR">
                                                        <div class="row">
                                                            <div class="col-lg-8 col-md-12 col-12 offset-lg-2">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <p>อีเมล</p>
                                                                        <input name="email" type="email" class="form-control shadow-none" autofocus>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <p>รหัสผ่าน</p>
                                                                        <input name="password" type="password" class="form-control shadow-none">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <!--<a class="button-txt" href="reset_password.php">ลืมรหัสผ่าน</a>-->
                                                                        
                                                                        <!-- Button trigger modal -->
                                                                        <button type="button" class="btn button-txt" data-toggle="modal" data-target="#staticBackdrop">ลืมรหัสผ่าน</button>
                                                                        
                                                                        
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <button type="submit" class="buttonBK btn big mt-4">เข้าสู่ระบบ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                                
                                                    </div>

                                                </div>
                                            </form>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal -->
                                <div class="modal fade form-modal" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 id="staticBackdropLabel">ขอรหัสผ่านใหม่</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-form">
                                                    <div class="row">
                                                        <div class="col">
                                                            <p>กรุณาใส่อีเมลที่ใช้ในการเข้าสู่ระบบ และเราจะดำเนินการส่งรหัสผ่านไปยังอีเมลที่ระบุไว้</p>
                                                            <input type="email" class="form-control shadow-none" placeholder="Email">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn buttonBK">ยืนยัน</button>
                                                <button type="button" class="btn buttonBD" data-dismiss="modal">ยกเลิก</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---------- R E G I S T E R ---------->
                                <div class="row">
                                    <div class="col">
                                        <div class="md-radio md-radio-inline radiocheck">
                                            <input id="payment-2" type="radio" name="payment-group" />
                                            <label for="payment-2">
                                                <p><i class="fas fa-pen"></i>สมัครสมาชิก</p>
                                            </label>
                                            <section>
                                                <div class="accBDbottom">
                                                    <!-- U S E R :: I N F O -->
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
                                                                <p>ชื่อ</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>นามสกุล</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>อีเมล</p>
                                                                <input type="email" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>เบอร์โทรศัพท์</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>LINE ID</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col mb-1">
                                                                <p>ประเภทบุคคลผู้ใช้งาน</p>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-lg-4 col-md-4 col-12 ">
                                                                <div class="md-radio md-radio-inline radiocheck">
                                                                    <input id="type-1" type="radio" name="person-group" />
                                                                    <label for="type-1">ผู้จัดซื้อ</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-12">
                                                                <div class="md-radio md-radio-inline radiocheck">
                                                                    <input id="type-2" type="radio" name="person-group" />
                                                                    <label for="type-2">ผู้ใช้งาน</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4 col-12">
                                                                <div class="md-radio md-radio-inline radiocheck">
                                                                    <input id="type-3" type="radio" name="person-group" />
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
                                                                <p>อีเมล</p>
                                                                <input type="email" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>รหัสผ่าน</p>
                                                                <input type="password" class="form-control shadow-none">
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>ยืนยันรหัสผ่าน</p>
                                                                <input type="password" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- C O M P A N Y - I N F O -->
                                                    <div class="w-100">
                                                        <div class="row">
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
                                                                <p>ชื่อบริษัท</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>อีเมล</p>
                                                                <input type="email" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>เบอร์โทรศัพท์</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>แฟกซ์</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>ที่อยู่</p>
                                                                <textarea class="form-control shadow-none"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>ภาค</p>
                                                                <div class="select2-part">
                                                                    <select class="js-example-basic-single form-control shadow-none" name="deliveryTo">
                                                                        <option>เลือก</option>
                                                                        <option>option 1</option>
                                                                        <option>option 2</option>
                                                                        <option>option 3</option>
                                                                        <option>option 4</option>
                                                                        <option>option 5</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>จังหวัด</p>
                                                                <div class="select2-part">
                                                                    <select class="js-example-basic-single form-control shadow-none" name="deliveryTo">
                                                                        <option>เลือก</option>
                                                                        <option>option 1</option>
                                                                        <option>option 2</option>
                                                                        <option>option 3</option>
                                                                        <option>option 4</option>
                                                                        <option>option 5</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>เขต</p>
                                                                <div class="select2-part">
                                                                    <select class="js-example-basic-single form-control shadow-none" name="deliveryTo">
                                                                        <option>เลือก</option>
                                                                        <option>option 1</option>
                                                                        <option>option 2</option>
                                                                        <option>option 3</option>
                                                                        <option>option 4</option>
                                                                        <option>option 5</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>แขวง</p>
                                                                <div class="select2-part">
                                                                    <select class="js-example-basic-single form-control shadow-none" name="deliveryTo">
                                                                        <option>เลือก</option>
                                                                        <option>option 1</option>
                                                                        <option>option 2</option>
                                                                        <option>option 3</option>
                                                                        <option>option 4</option>
                                                                        <option>option 5</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>รหัสไปรษณีย์</p>
                                                                <input type="text" class="form-control shadow-none">
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                                <button type="button" class="btn buttonBK big mt-4">สมัครสมาชิก</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                            
                </div> --}}