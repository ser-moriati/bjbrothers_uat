<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{URL::asset('OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('OwlCarousel/owl.theme.default.min.css')}}">
</head>
<style>
    .career-contact li .i {
    color: #363636;
    position: absolute;
    top: 4px;
    left: 0;
    }
</style>
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
                
                <div id="careerPage"></div>
               
                <!---------- C A R E E R ---------->
                <div class="row">
                    <div class="col">
                        <h2 class="text-center">ตำแหน่งงาน</h2>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <!---------- C A R E E R :: P O S I T I O N ---------->
                        <div class="career-slide mt-3">
                            <div id="thumbs" class="owl-carousel owl-theme">
                                @foreach($career as $car)
                                    <div class="item">
                                        <div class="c-position">{{$car->position}}</div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!---------- C A R E E R :: D E T A I L ---------->
                            <div id="big" class="owl-carousel owl-theme">
                            @foreach($career as $car)
                                <div class="item">
                                    <div class="row">
                                        <div class="col-lg-7 col-12">
                                            <div class="career-info">
                                                <div class="row">
                                                    <div class="col">
                                                        <h3>{{$car->position}}</h3>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h6><i class="fas fa-building"></i>สถานที่ทำงาน :</h6>
                                                        <ul class="list-content">
                                                            @foreach ($car->workplace as $item)
                                                                <li>{{$item}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <h6><i class="fas fa-user"></i>คุณสมบัติ :</h6>
                                                        <ul class="list-content">
                                                            @foreach ($car->description as $item)
                                                                <li>{{$item}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                <div class="row">
                                                    <div class="col">
                                                        {!! str_replace('<h6>','<div style="display: flex;">',$car->detail) !!}
                                                    </div>
                                                </div>
                                            </div>
                                                
                                        </div>
                                        <div class="col-lg-4 offset-lg-1 mobile-none">
                                            <div class="img-width"><img src="{{URL::asset('upload/career/'.$car->banner)}}"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <!-- พนักงานขาย -->
                                
                            </div>
                        </div>
                    </div>
                </div>
                                    
                
            </div>
                
        </div>
    </div>
    @include('inc_topbutton')
    @include('inc_footer')
    
    <!-- OwlCarousel -->
    <script src="{{URL::asset('OwlCarousel/owl.carousel.min.js')}}"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            var bigimage = $("#big");
            var thumbs = $("#thumbs");
            //var totalslides = 10;
            var syncedSecondary = true;
            
            bigimage
                .owlCarousel({
                items: 1,
                slideSpeed: 3000,
                smartSpeed: 2000,
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
                items: 5,
                margin: 12,
                dots: false,
                nav: true,
                smartSpeed: 200,
                slideSpeed: 1500,
                slideBy: 2,
                responsiveRefreshRate: 100,
                navText: [
                    '<i class="fas fa-chevron-left"></i>',
                    '<i class="fas fa-chevron-right"></i>'
                ],
                responsive: {
                    0: {
                        items: 2,
                        slideBy: 2,
                        margin: 5,
                    },
                    640: {
                        items: 3,
                        slideBy: 3,
                        margin: 10
                    },
                    1024: {
                        items: 5,
                        slideBy: 2,
                        margin: 12
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