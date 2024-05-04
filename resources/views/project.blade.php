<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @php
        $portName="project";
    @endphp
    @include('inc_header')
    <link rel="stylesheet" href="/OwlCarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/OwlCarousel/owl.theme.default.min.css">
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
                            <li>ผลงานของเรา</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- P R O J E C T ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                @include('inc_port_submenu')
                
                <div id="projectPage"></div>
                
                <div class="row">
                    <div class="col">
                        <h1 class="text-center">โครงการต่างๆ</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="slide-navButton mt-3">
                            <div class="port-slide owl-carousel owl-theme">
                                    <a class="items @if(!@$_GET['cate_id']) active @endif" href="{{url('project')}}">
                                        <div class="c-position">
                                            <p>ALL</p>
                                        </div>
                                    </a>
                                    @foreach ($category as $cate)
                                    <a class="items @if($cate->id == @$_GET['cate_id']) active @endif" href="{{url('project?cate_id='.$cate->id)}}">
                                        <div class="c-position">
                                            <p>{{$cate->project_category_name}}</p>
                                        </div>
                                    </a>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-padding mt-5">
                    <div class="row">
                        @foreach ($project as $proj)

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="projectBox">
                                    <a href="{{url('project/'.$proj->id)}}"><img src="{{URL::asset('upload/project/'.$proj->project_image)}}"></a>
                                    <a class="project-topic" href="{{url('project/'.$proj->id)}}">
                                        <p>{{$proj->project_name}}</p>
                                    </a>
                                    <div class="dateBox">{{strtoupper(date("j M Y", strtotime($proj->created_at)))}}</div>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
                                <!--------------- P A G E --------------->
                    <div class="w-100 mt-3">
                        <div class="row">
                            <div class="col">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        {{  $project->links() }}
                                    </ul>
                                </nav>
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
    
    <script src="/OwlCarousel/owl.carousel.min.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
        $('.port-slide').owlCarousel({
            loop: false,
            margin: 15,
            autoplay: false,
            autoplayTimeout: 1500,
            autoplayHoverPause: false,
            smartSpeed: 1000,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            dots: false,
            responsive: {
                0: {
                    items: 1,
                    slideBy: 1,
                    margin: 10
                },
                640: {
                    items: 3,
                    slideBy: 1,
                    margin: 20
                },
                1024: {
                    items: 4,
                    slideBy: 1,
                    margin: 25
                }
            }
        })
        });
    </script>
    
    <script type="text/javascript">
        // MENU-TAB //
        $(function(){  
            $("ul.menu-tab > li").click(function(event){ 
                var getActive = $(this);
                var menuIndex=$(this).index();  
                if($(this).hasClass("active") == false){
                    $("ul.menu-tab").find("li.active").removeClass("active");
                    $("ul.tab-detail > li:visible").hide();             
                    $("ul.tab-detail > li").eq(menuIndex).show();  
                    $(this).addClass("active");
                }
            }); 
        }); 
    </script>
</body>
</html>