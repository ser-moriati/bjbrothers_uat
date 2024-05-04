<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @php
        $portName="portfolio";
    @endphp
    @include('inc_header')
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{url('OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{url('OwlCarousel/owl.theme.default.min.css')}}">
    <!-- FANCYBOX -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
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
    <!---------- P O R T F O L I O ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                @include('inc_port_submenu')
                
                <div id="portPage"></div>
               
                <div class="row">
                    <div class="col">
                        <h2 class="text-center">ผลงานของเรา</h2>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="slide-navButton mt-3">
                            <div class="port-slide owl-carousel owl-theme">
                        @foreach ($category as $cate)                            
                                <a class="items @if ($cate->id == $cate_id) active @endif" href="{{url('portfolio/'.$cate->id)}}">
                                    <div class="c-position">
                                        <p>{{$cate->portfolio_category_name}}</p>
                                    </div>
                                </a>
                        @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="port-section mt-5">
                    <div class="row">
                        @foreach ($portfolio as $port)                            
                        <div class="col-lg-3 col-md-4 col-6">
                            <a class="galBox" data-fancybox="gallery" data-caption="กรวยจราจร" href="/upload/portfolio/{{$port->portfolio_image}}"><img src="/upload/portfolio/{{$port->portfolio_image}}"></a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-100 mt-3">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{  $portfolio->links() }}
                                </ul>
                            </nav>
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
                    items: 5,
                    slideBy: 1,
                    margin: 15
                }
            }
        })
        });
    </script>
    
</body>
</html>