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
                            <li class="m-nav"><a href="/news#newsPage">ข่าวสารและโปรโมชั่น</a></li>
                            <li class="mobile-none">{{$news->title}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- N E W S & E V E N T :: D E T A I L ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h3 class="text-center">{{$news->title}}</h3>
                        <div class="dateBox mb-5">{{strtoupper(date("j M Y", strtotime($news->created_at)))}}</div>
                    </div>
                </div>
                {!!str_replace('<h6>','<div style="display: flex;">',$news->detail)!!}
                
                <div class="row">
                    <div class="col mt-5">
                        <div class="doubleBD">
                            <div class="content-center">
                                <a class="buttonBK" href="/news#newsPage">ย้อนกลับ</a>
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