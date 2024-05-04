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
                            <li><a href="/">หน้าแรก</a></li>
                            <li>วิธีการสั่งซื้อ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- H O W - T O - O R D E R ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h1 class="EngSM">HOW TO ORDER</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="txt-content text-center mb-4">
                            <p>เลือกดูรหัสสินค้าที่ต้องการ และท่านสามารถสอบถามราคาสินค้าและสั่งซื้อสินค้าได้ 5 ช่องทางดังนี้</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-8 col-md-12 col-12 offset-lg-2">
                        <div class="img-width mb-5"><img src="images/howto/howtoorder.jpg"></div>
                    </div>
                </div>
                
                <div class="how-to-order">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="doubleBox-BD">
                                <div class="doubleBox">
                                    <div class="img-center"><img src="images/howto/icon-online.png"></div>
                                    <div class="txt-content text-center">
                                        <p>สอบถามราคาสินค้าทางหน้าเว็บไซต์ โดยเลือกสินค้าที่ต้องการ ใส่จำนวนสินค้าที่ต้องการ แล้วทางฝ่ายขายจะทำการติดต่อกลับไป ภายใน 24 ชม.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="doubleBox-BD">
                                <div class="doubleBox">
                                    <div class="img-center"><img src="images/howto/icon-phone.png"></div>
                                    <div class="txt-content text-center">
                                        <p>โทรศัพท์เบอร์ <span>02-4511824-7</span>, <span>02-4512811</span>, <span>02-4531186</span>, <span>02-4512369 ต่อฝ่ายขาย 17-20</span> เพื่อสอบถามราคาสินค้าและสั่งซื้อ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="doubleBox-BD">
                                <div class="doubleBox">
                                    <div class="img-center"><img src="images/howto/icon-email.png"></div>
                                    <div class="txt-content text-center">
                                        <p>Email : <a href="mailto:salecenter@bjbrothers.com">salecenter@bjbrothers.com</a> (ฝ่ายขาย) หรือ <a href="mailto:info@bjbrothers.com">info@bjbrothers.com</a> (ฝ่ายข้อมูลส่วนกลาง) เพื่อสอบถามราคาสินค้าและสั่งซื้อ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12 offset-lg-2">
                            <div class="doubleBox-BD">
                                <div class="doubleBox">
                                    <div class="img-center"><img src="images/howto/icon-fax.png"></div>
                                    <div class="txt-content text-center">
                                        <p>FAX ที่เบอร์ <span>02-451-1354</span> (AUTO) เพื่อสอบถามราคาสินค้าและสั่งซื้อ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="doubleBox-BD">
                                <div class="doubleBox">
                                    <div class="img-center"><img src="images/icon/icon-lineBK.svg"></div>
                                    <div class="txt-content text-center">
                                        <p>LINE ID : <span>@bjbrothers</span> เพื่อสอบถามราคาสินค้าและสั่งซื้อ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <div class="txt-content text-center mt-2">
                                <p>ทางบริษัทจะทำการติดต่อกลับเพื่อยืนยันราคาและสถานที่การจัดส่ง ตามข้อมูลที่ให้ไว้ภายในเวลาทำการของบริษัทฯ </p>
                            </div>
                        </div>
                    </div>
                </div>
                    
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    
</body>
</html>