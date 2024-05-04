<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
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
                            <li><a href="index.php">หน้าแรก</a></li>
                            <li>ลืมรหัสผ่าน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- R E S E T - P A S S W O R D ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h1 class="EngSM mb-4">RESET PASSWORD</h1>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="txt-content text-center f-18 mb-3">
                            <p>กรุณาใส่อีเมลที่ใช้ในการเข้าสู่ระบบ <br>และเราจะดำเนินการส่งรหัสผ่านไปยังอีเมลที่ระบุไว้</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="icon-mail"><i class="fas fa-envelope"></i></div>
                    </div>
                </div>
                <form action="/reset_password/send">
                    <div class="input-form big">
                        <div class="row">
                            <div class="col-lg-6 col-md-8 col-12 offset-lg-3 offset-md-2">
                                <input type="email" name="email" class="form-control shadow-none text-center" placeholder="type your email">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="content-center">
                                    <button type="submit" class="btn buttonBK big mt-2 mb-5">ยืนยัน</button>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </form>
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    
</body>
</html>