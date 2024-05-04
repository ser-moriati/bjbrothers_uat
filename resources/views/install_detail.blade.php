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
                            <li><a href="/install#installPage">เกร็ดความรู้ : Installation Tips</a></li>
                            <li><a href="/install/cate/{{$cate->id}}">{{$cate->install_category_name}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- I N S T A L L A T I O N :: D E T A I L ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h3 class="text-center mb-5">{{$install->install_name}}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="txt-content mb-5">
                            {!! str_replace('<h6>','<div style="display: flex;">',$install->install_detail) !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="doubleBD">
                            <div class="content-center">
                                <a class="buttonBK" href="/install/cate/{{$cate->id}}">ย้อนกลับ</a>
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