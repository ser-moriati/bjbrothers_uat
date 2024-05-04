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
                            <li><a href="/promotion#promotionPage">โปรโมชั่น</a></li>
                            <li class="mobile-none">{{$promotion->title}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- P R O M O T I O N :: D E T A I L ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h3 class="text-center">{{$promotion->title}}</h3>
                        <div class="dateBox mb-5">{{strtoupper(date("j M Y", strtotime($promotion->created_at)))}}</div>
                    </div>
                </div>
                {!!str_replace('<h6>','<div style="display: flex;">',$promotion->detail)!!}
                
                <div class="row">
                    <div class="col mt-5">
                        <div class="doubleBD">
                            <div class="content-center">
                                <a class="buttonBK" href="/promotion#promotionPage">ย้อนกลับ</a>
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