<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    @php $contactName="dealer" @endphp
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
                            <li>ติดต่อเรา</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                @include('inc_contact_submenu')
                
                <div id="dealPage"></div>
                
                <!---------- D E A L E R :: F R O M  ---------->
                <div class="row">
                    <div class="col">
                        <div class="doubleBox-BD">
                            <div class="doubleBox more-pad">
                                <div class="row">
                                    <div class="col">
                                        <h2 class="text-center EngSM mb-4">DEALER FORM</h2>
                                    </div>
                                </div>
                                <div class="input-form">
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
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <p>อีเมล</p>
                                            <input type="email" class="form-control shadow-none">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <p>เบอร์โทรศัพท์</p>
                                            <input type="text" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>ชื่อบริษัท</p>
                                            <input type="text" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>ที่อยู่บริษัท</p>
                                            <textarea class="form-control shadow-none"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-12 mb-2">
                                            <p>หนังสือรับรองบริษัท<span>*แนบไฟล์อย่างน้อย 1 ไฟล์</span></p>
                                            <div class="file-input-wrapper">
                                                <label for="certificate" class="file-input-button">BROWSE FILE</label>
                                                <input id="certificate" type="file" name="image">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <p>รูปหน้าร้าน / หน้าเว็บไซต์<span>*แนบไฟล์อย่างน้อย 1 ไฟล์</span></p>
                                            <div class="file-input-wrapper">
                                                <label for="store" class="file-input-button">BROWSE FILE</label>
                                                <input id="store" type="file" name="image">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="content-center mt-4">
                                                <button type="button" class="btn buttonBK mt-0">ยืนยัน</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
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