<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- FANCYBOX -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{url('OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('OwlCarousel/owl.theme.default.min.css')}}">
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
                            <li><a href="/project#projectPage">โปรเจค</a></li>
                            <li>{{$project->project_name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- P R O J E C T :: D E T A I L ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h3 class="text-center">{{$project->project_name}}</h3>
                        <div class="dateBox mb-5">{{strtoupper(date("j M Y", strtotime($project->created_at)))}}</div>
                    </div>
                </div>
                <div class="row">
                    <!---------- P R O J E C T :: I M G - S L I D E ---------->
                    <div class="col-lg-7 col-12">
                        <div class="project-slide mb-4">
                            <div id="big" class="owl-carousel owl-theme">
                                @foreach ($gallery as $gall)
                                <a class="item" data-fancybox="gallery" href="{{url('upload/project/gallerys/'.$gall->image_name)}}"><img src="{{url('upload/project/gallerys/'.$gall->image_name)}}"></a>
                                @endforeach
                            </div>
                            <div id="thumbs" class="owl-carousel owl-theme">
                                @foreach ($gallery as $gall)
                                <div class="item"><img src="{{url('upload/project/gallerys/'.$gall->image_name)}}"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-12">
                        <div class="doubleBox-BD" id="project">
                            <div class="doubleBox">
                                <div class="project-info">
                                    <div class="row">
                                        <div class="col-12">โครงการ</div>
                                        <div class="col-12">{{$project->project_name}}</div>
                                    </div>
                                </div>
                                <div class="project-info">
                                    <div class="row">
                                        <div class="col-12">เจ้าของโครงการ</div>
                                        <div class="col-12">{{$project->project_owner}}</div>
                                    </div>
                                </div>
                                <div class="project-info">
                                    <div class="row">
                                        <div class="col-12">สถานที่</div>
                                        <div class="col-12">{{$project->project_address}}</div>
                                    </div>
                                </div>
                                <div class="project-info">
                                    <div class="row">
                                        <div class="col-lg-5 col-12">รายละเอียด</div>
                                        <div class="col-12">
                                            <div class="txt-content">
                                                <p>{{$project->project_detail}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="doubleBD">
                            <div class="content-center">
                                <a class="buttonBK" href="/project#projectPage">ย้อนกลับ</a>
                            </div> 
                        </div>
                    </div>
                </div>
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    
    <!-- FANCYBOX -->
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    
    <!-- OwlCarousel -->
    <script src="{{url('OwlCarousel/owl.carousel.min.js')}}"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            var bigimage = $("#big");
            var thumbs = $("#thumbs");
            //var totalslides = 10;
            var syncedSecondary = true;
            
            bigimage
                .owlCarousel({
                items: 1,
                slideSpeed: 3500,
                smartSpeed: 1500,
                nav: true,
                autoplay: false,
                dots: false,
                loop:false,
                rewind: true,
                responsiveRefreshRate: 200,
                navText: [
                    '<i class="fas fa-chevron-left"></i>',
                    '<i class="fas fa-chevron-right"></i>'
                ]
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
                items: 3,
                margin: 10,
                dots: false,
                nav: false,
                smartSpeed: 200,
                slideSpeed: 1500,
                slideBy: 1,
                responsiveRefreshRate: 100,
                responsive: {
                    0: {
                        items: 3,
                        margin: 6
                    },
                    640: {
                        items: 3,
                        margin: 6
                    },
                    1024: {
                        items: 3
                    },
                    1200:{
                        items: 3
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