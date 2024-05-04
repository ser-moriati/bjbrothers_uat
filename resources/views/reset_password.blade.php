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
                            <li>เปลี่ยนรหัสผ่าน</li>
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
                        <h1>เปลี่ยนรหัสผ่าน</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-10 col-12 offset-lg-2 offset-md-1">
                        <form method="POST" action="/forgot/update/{{$id}}" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-form more-padR">
                            <div class="row">
                                <div class="col-lg-8 col-md-12 col-12 offset-lg-2">
                                    <div class="row">
                                        <div class="col">
                                            <p>รหัสผ่าน<span class="required">*</span></p>
                                            <input type="password" name="password" class="form-control shadow-none" id="password" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>ยืนยันรหัสผ่าน<span class="required">*</span></p>
                                            <input type="password" name="confirm_password" class="form-control shadow-none" id="confirm_password" oninput="checkPasswordMatch()" required>
                                        </div>
                                    </div>
                                    <div id="divCheckPasswordMatch" style="color: red"></div>
                                    <div class="login-button-section mt-3">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <button type="submit" class="buttonBK btn big">ยืนยัน</button>
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
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')

    <!-- SELECT2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    
    <script>
        function checkPasswordMatch() {
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();

            if (password != confirm_password)
                $("#divCheckPasswordMatch").html("Passwords do not match!");
            else
                $("#divCheckPasswordMatch").html("");
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