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
                            <li>ยืนยันรายการ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- Q U O T A T I O N - C O N F I R M --------------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col-lg-10 col-12 offset-lg-1">
                        <div class="doubleBox-BD BKbd mb-4">
                            <div class="doubleBox input-form" id="confirm">
                                <div class="row">
                                    <div class="col">
                                        <div class="summary-header" id="quotation">
                                            <h2 class="pb-0 mb-1">ยืนยันรายการ</h2>
                                            <h3><span>หมายเลขใบเสนอราคา</span>{{$quotation->number}}</h3>
                                        </div> 
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="txt-content text-center">
                                            <p>กรุณารอติดต่อกลับจากทางเรา ขอบคุณที่ใช้บริการ</p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="button-line center mt-3">
                    <div class="row">
                        <div class="col">
                            <a class="buttonBD" href="/">กลับหน้าแรก</a>
                        </div>
                        <div class="col">
                        <a class="buttonBK" href="/quotation/quotationHistory/{{$id}}">ดูรายการใบเสนอราคา</a>
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