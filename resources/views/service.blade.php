<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @php
        $aboutName = "service";    
    @endphp
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
                            <li>เกี่ยวกับเรา</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- S E R V I C E ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                @include('inc_about_submenu')
                
                <div id="servicePage"></div>
                
                <!---------- M E N U - T A B ---------->
                <div class="row">
                    <div class="col">
                        <ul class="menu-tab mobile-s anchor mb-5">
                            <li><a href="#service">บริการของเรา</a></li>
                            <li><a href="#order">วิธีการสั่งซื้อ</a></li>
                            <li><a href="#pay">วิธีการชำระเงิน</a></li>
                            <li><a href="#ship">วิธีการจัดส่ง</a></li>
                        </ul>
                    </div>
                </div>
                
                <!---------- S E R V I C E ---------->
                <div class="row" id="service">
                    <div class="col">
                        <h2 class="text-center">บริการของเรา</h2>
                    </div>
                </div>
                
                {!! str_replace('<h6>','<div style="display: flex;">',$service->detail) !!}
                
                <div class="row">
                    <div class="col">
                        <div class="doubleBD"></div>
                    </div>
                </div>
                
                
                <!---------- H O W - T O - O R D E R ---------->
                <div class="row" id="order">
                    <div class="col">
                        <h2 class="text-center mt-5">วิธีการสั่งซื้อ</h2>
                    </div>
                </div>
                {!! str_replace('<h6>','<div style="display: flex;">',$service->detail_2) !!}

                <div class="row">
                    <div class="col">
                        <div class="doubleBD"></div>
                    </div>
                </div>
                
                
                <!---------- H O W - T O - P A Y M E N T ---------->
                <div class="row" id="pay">
                    <div class="col">
                        <h2 class="text-center mt-5">วิธีการชำระเงิน</h2>
                    </div>
                </div>
                {!! str_replace('<h6>','<div style="display: flex;">',$service->detail_3) !!}

                <div class="row">
                    <div class="col">
                        <div class="doubleBD mt-4"></div>
                    </div>
                </div>
                
                
                <!---------- S H I P P I N G ---------->
                <div class="row" id="ship">
                    <div class="col">
                        <h2 class="text-center mt-5">วิธีการจัดส่ง</h2>
                    </div>
                </div>
                {!! str_replace('<h6>','<div style="display: flex;">',$service->detail_4) !!}

            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    
    <script type="text/javascript">
        // ANCHOR SC //
        function scrollNav() {
            $('.menu-tab a').click(function(){  
                //Animate
                $('html, body').stop().animate({
                    scrollTop: $( $(this).attr('href') ).offset().top - 62
                }, 800);
                return false;
            });
        }
        scrollNav();
    </script>
    
</body>
</html>