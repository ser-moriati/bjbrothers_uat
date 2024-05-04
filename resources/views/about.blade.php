<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{URL::asset('OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('OwlCarousel/owl.theme.default.min.css')}}">
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
                            <li>เกี่ยวกับเรา</li>
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
    @include('inc_about_submenu')
               
                <div id="aboutPage"></div>
                
                <!---------- M E N U - T A B ---------->
                <div class="row">
                    <div class="col">
                        <ul class="menu-tab mobile-s anchor">
                            <li><a href="#aboutus">ธุรกิจของเรา</a></li>
                            <li><a href="#timeline">ประวัติบริษัท</a></li>
                            <li><a href="#org">แผนผังองค์กร</a></li>
                            <li><a href="#factory">โรงงานของเรา</a></li>
                        </ul>
                    </div>
                </div>
                
                <!---------- ABOUT ---------->
                <div class="row" id="aboutus">
                    <div class="col">
                        <h2 class="text-center mt-5">ธุรกิจของเรา</h2>
                    </div>
                </div>
                {!! str_replace('<h6>','<div style="display: flex;">', $detail->business) !!}
                <div class="row">
                    <div class="col">
                        <div class="doubleBD"></div>
                    </div>
                </div>
                
                <!---------- HISTORY ---------->
                <div class="row" id="timeline">
                    <div class="col">
                        <h2 class="text-center mt-5">ประวัติบริษัท</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="history-slide mt-3">
                            <div id="thumbs" class="owl-carousel owl-theme mb-5">
                                @foreach ($about as $ab)
                                <div class="item">
                                    <div class="year">{{$ab->about_company_year}}</div>
                                    <div class="year-dot"></div>
                                </div>
                                @endforeach
                                
                            </div>
                            <div id="big" class="owl-carousel owl-theme">
                                <!-- 2524 -->
                                @foreach ($about as $ab)
                                <div class="item">
                                    <div class="row">
                                        <div class="col-lg-10 col-md-12 col-12 offset-lg-1">
                                            <div class="doubleBox-BD">
                                                <div class="doubleBox">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h3>พ.ศ. {{$ab->about_company_year}}</h3>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="txt-content">
                                                            <p>{{$ab->about_company_detail}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="doubleBD"></div>
                    </div>
                </div>
                
                <!---------- ORG CHART ---------->
                <div class="row" id="org">
                    <div class="col">
                        <h2 class="text-center mt-5">แผนผังองค์กร</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10 col-12 offset-lg-1">
                        <div class="img-width"><img src="upload/about/{{ $detail->chart }}"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="doubleBD"></div>
                    </div>
                </div>
                
                <!---------- FACTORY ---------->
                <div class="row" id="factory">
                    <div class="col">
                        <h2 class="text-center mt-5">โรงงานของเรา</h2>
                    </div>
                </div>
               <!-- NEW INFO -->
               <div class="factory-info">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-9 col-12">
                            <div class="img-width"><img src="images/about/factory.jpg"></div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-12">
                            <div class="row">
                                <div class="col">
                                    <h6>บริษัท บี.เจ.บราเดอร์ส แอนด์ ซัน จำกัด</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="txt-content">
                                        <p>เราคือผู้ผลิตรองเท้านิรภัย รองเท้าคอมแบต รองเท้าตำรวจ รองเท้าคัชชู โดยเริ่มก่อตั้งโรงงานผลิต ตั้งแต่ ปี 2524 จนถึงปัจจุบัน โรงงานของเราประกอบไปด้วยแผนกผลิตทั้ง 4 แผนก ได้แก่</p>
                                        <ul>
                                            <li>แผนกรองเท้าเซฟตี้ ของเราสามารถผลิตรองเท้าได้ปีละ ประมาณ 60000 คู่ รับผลิตรองเท้าตามรูปแบบ งานราชการและเอกชนทั่วไป ทางเรายังได้เข้าร่วมอบรมมาตรฐานการผลิต QSME เข้าอบรมร่วมกับสถานบัน ไทยเยอรมัน และได้รับ มอก.รองเท้าหนังนิรภัย 523-2564 อีกด้วย</li>
                                            <li>แผนกยูนิฟอร์ม รับผลิตเสื้อผ้า เสื้อยืด ชุดอปพร. ชุดดับเพลิง ชุดหมี ชุดเครื่องแบบราชการ ทุกชนิด เสื้อสะท้อนแสง เสื้อจราจร เสื้อชูชีพ ห่วงชูชีพ เข็มขัดพยุงหลัง สามารถออกแบบและผลิตงานเย็บทุกชนิด</li>
                                            <li>แผนกผลิตและประกอบงานเหล็กและสแตนแลส รับผลิตเหล็กแผงกั้นจราจรทุกชนิด ทั้งแบบมีล้อและไม่มีล้อ รับทำเสาเหล็กจราจร ขาไฟจราจร ขาไฟด่านตรวจต่างๆ</li>
                                            <li>แผนกป้ายสะท้อนแสงและป้ายงานโฆษณา รับผลิตป้ายจราจร ป้ายเตือน ป้ายห้ามต่างๆ ป้ายโฆษณา</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- FACTORY VDO :: PC -->
                            <div class="d-none d-xl-block">
                                <div class="row">
                                    <div class="col">
                                        <h6>วีดีโอแนะนำโรงงานของทางบริษัท บี.เจ.บราเดอร์ส แอนด์ ซัน จำกัด</h6>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col">
                                        <div class="container-vdo">
                                            <iframe class="responsive-vdo" src="https://www.dailymotion.com/embed/video/k72HNciRJsdn8nz0bBX"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FACTORY VDO :: IPAD & MOBILE -->
                    <div class="d-block d-xl-none">
                        <div class="row mb-0">
                            <div class="col">
                                <h6>วีดีโอแนะนำโรงงานของทางบริษัท บี.เจ.บราเดอร์ส แอนด์ ซัน จำกัด</h6>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col">
                                <div class="container-vdo">
                                    <iframe class="responsive-vdo" src="https://www.dailymotion.com/embed/video/k72HNciRJsdn8nz0bBX"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- END // NEW INFO -->
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    
    <!-- OwlCarousel -->
    <script src="OwlCarousel/owl.carousel.min.js"></script>
    
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
        
        
        $(document).ready(function() {
            var bigimage = $("#big");
            var thumbs = $("#thumbs");
            //var totalslides = 10;
            var syncedSecondary = true;
            
            bigimage
                .owlCarousel({
                items: 1,
                slideSpeed: 2500,
                smartSpeed: 1500,
                animateOut: 'fadeOut',
                nav: false,
                autoplay: false,
                dots: false,
                loop:false,
                rewind: true,
                responsiveRefreshRate: 200
            })
                .on("changed.owl.carousel", syncPosition);
            thumbs
                .on("initialized.owl.carousel", function() {
                thumbs
                    .find(".owl-item")
                    .eq(0)
                    .addClass("current");
            })
                .owlCarousel({
                items: 6,
                margin: 10,
                dots: false,
                nav: true,
                smartSpeed: 200,
                slideSpeed: 1500,
                slideBy: 3,
                responsiveRefreshRate: 100,
                navText: [
                    '<i class="fas fa-chevron-left"></i>',
                    '<i class="fas fa-chevron-right"></i>'
                ],
                responsive: {
                    0: {
                        items: 3
                    },
                    640: {
                        items: 3
                    },
                    1024: {
                        items: 6
                    }
                }
            })
                .on("changed.owl.carousel", syncPosition2);
            
            function syncPosition(el) {
                //if loop is set to false, then you have to uncomment the next line
                //var current = el.item.index;
                
                //to disable loop, comment this block
                var count = el.item.count - 1;
                var current = el.item.index;
                //var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
//                if (current < 0) {
//                    current = count;
//                }
//                if (current > count) {
//                    current = 0;
//                }
                //to this
                thumbs
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(current)
                    .addClass("current");
                var onscreen = thumbs.find(".owl-item.active").length - 1;
                var start = thumbs
                .find(".owl-item.active")
                .first()
                .index();
                var end = thumbs
                .find(".owl-item.active")
                .last()
                .index();
                
                if (current > end) {
                    thumbs.data("owl.carousel").to(current, 100, true);
                }
                if (current < start) {
                    thumbs.data("owl.carousel").to(current - onscreen, 100, true);
                }
            }
            function syncPosition2(el) {
                if (syncedSecondary) {
                    var number = el.item.index;
                    bigimage.data("owl.carousel").to(number, 100, true);
                }
            }
            thumbs.on("click", ".owl-item", function(e) {
                e.preventDefault();
                var number = $(this).index();
                bigimage.data("owl.carousel").to(number, 300, true); 
            });
        });
    </script>
    
</body>
</html>