<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- WOW -->
    <link rel="stylesheet" type="text/css" href="wow-master/css/animate.css">
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="OwlCarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="OwlCarousel/owl.theme.default.min.css">
</head>
<body>
    <div class="thetop"></div>
    @include('inc_topmenu')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col px-0">
                <div class="img-width">
                <div class="banner-slide owl-carousel owl-theme mb-4">
                                    @foreach ($banner as $banner)
                                    <a class="productBox-BD" href="{{$banner->banner_URL}}">  
                                        <div class="items ">
                                                <!-- TAG -->
                                                <img src="{{URL::asset('upload/home/'.$banner->banner_name)}}">
                                        </div>
                                    </a>
                                    @endforeach

                                </div>
                   
                    {{-- <div class="banner-video">
                    <iframe src="https://www.youtube.com/embed/{{$home->video}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- A B O U T - B J ---------->
                <section class="wow slideInUp">
                    <div class="row">
                        <div class="col">
                            <h1 class="big EngSM">BJ BROTHERS <span>& SON</span></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="txt-content text-center f-18 mb-4">
                                <p><span>บริษัท บี.เจ.บราเดอร์ส แอนด์ ซัน จำกัด</span> เป็นผู้นำเข้า จัดจำหน่ายอุปกรณ์จราจรและอุปกรณ์เซฟตี้โดยตรง <br>
                                    และเป็นตัวแทนจำหน่ายสินค้ายี่ห้อชั้นนำมากมายแบบครบวงจร โดยทางบริษัทจะคัดสรรสินค้าที่มีคุณภาพ และทันสมัย <br>
                                    เพื่อตอบสนองทุกความต้องการด้านความปลอดภัย</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-12 offset-lg-2">
                            <ul class="about-icon decor mb-5">
                                <li>
                                    <div><img src="images/about/icon-manufacture.png"></div>
                                    <p>ผลิต</p>
                                </li>
                                <li>
                                    <div><img src="images/about/icon-import.png"></div>
                                    <p>นำเข้า</p>
                                </li>
                                <li>
                                    <div><img src="images/about/icon-distribute.png"></div>
                                    <p>จัดจำหน่าย</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                    
                <!---------- P R O D U C T :: C A T A G O R I E S ---------->
                <section class="wow slideInUp">
                    <div class="row">
                        <div class="col">
                            <h1 class="EngSM mt-3">Product Categories</h1>
                        </div>
                    </div>
                    <div class="row d-none d-sm-block">
                        <div class="col">
                            <div class="slide-navButton">
                                <div class="category-slide owl-carousel owl-theme">
                                    @foreach ($category as $cate)
                                    <div class="items">
                                        <a class="doubleBox-BD gray" href="{{url('category/'.$cate->category_name)}}">
                                            <span></span><span></span><span></span><span></span>
                                            <div class="doubleBox">
                                            <div class="img-width"><img src="{{URL::asset('upload/category/'.$cate->image_home)}}"></div>
                                                <div class="box-topic">
                                                    <p class="longtxt">{{$cate->category_name}}</p>
                                                    <p class="longtxt"></p>
                                                    {{-- <p>SA</p> --}}
                                                </div>
                                                <!--<div class="img-center">
                                                    <img src="images/product/01-SA-G.png">
                                                    <img src="images/product/01-SA.png">
                                                </div>
                                                <div class="box-topic">
                                                    <p class="longtxt">อุปกรณ์ป้องกันร่างกาย</p>
                                                    <p>SA</p>
                                                </div>-->
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-sm-block d-md-none">
                        <div class="col">
                            <div class="slide-navButton">
                                <div class="category-slide owl-carousel owl-theme">
                                    @foreach ($category as $cate)
                                    <div class="items">
                                        <a class="doubleBox-BD gray" href="javascript:void(0);" onclick="get_sub_category({{ $cate->id }})">
                                            <span></span><span></span><span></span><span></span>
                                            <div class="doubleBox">
                                            <div class="img-width"><img src="{{URL::asset('upload/category/'.$cate->image_home)}}"></div>
                                                <div class="box-topic">
                                                    <p class="longtxt">{{$cate->category_name}}</p>
                                                    <p class="longtxt"></p>
                                                    {{-- <p>SA</p> --}}
                                                </div>
                                                <!--<div class="img-center">
                                                    <img src="images/product/01-SA-G.png">
                                                    <img src="images/product/01-SA.png">
                                                </div>
                                                <div class="box-topic">
                                                    <p class="longtxt">อุปกรณ์ป้องกันร่างกาย</p>
                                                    <p>SA</p>
                                                </div>-->
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!---------- P R O D U C T :: R E C O M M E N D E D ---------->
                <section class="wow slideInUp" data-wow-delay="1s">
                    <div class="row">
                        <div class="col">
                            <h1 class="EngSM mt-3">Product Recommended</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="slide-navButton">
                                <div class="product-slide owl-carousel owl-theme mb-4">
                                    @foreach ($product_recommended as $pro)
                                        
                                    <div class="items ">
                                    <a class="productBox-BD" href="{{url('product/'.$pro->product_name.'___'.$pro->id)}}">
                                           <!-- TAG -->
                                           @if ($pro->product_hot)
                                                <div class="tag"><img src="images/product/tag-hot.png"></div>
                                            @endif
                                            @if ($pro->product_new)
                                                <div class="tag"><img src="images/product/tag-new.png"></div>
                                            @endif
                                            <div class="productBox">
                                                <div class="product-img "><img src="{{URL::asset('upload/product/'.$pro->product_image)}}"></div>
                                                <ul class="productBox-name">
                                                    <li>
                                                        <p>{{$pro->product_name}}</p>
                                                    </li>
                                                    <li>{{$pro->product_code}}</li>
                                                    @if($pro->product_price == 0.00)
                                                    <li><p class="price sale" style="color:#f32836;font-size: 15px;"><i>สอบถามราคาเพิ่มเติม</i></p></li>
                                                    @else
                                                    <li>฿ {{number_format($pro->product_price, 2)}}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                    </a>
                                       
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="content-center mb-5">
                                <a class="buttonBK mt-0" href="PRODUCRECOMMENDED">ดูทั้งหมด</a>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!---------- P R O J E C T S ---------->
                <!-- <section class="wow slideInUp" data-wow-delay="1s">
                    <div class="row">
                        <div class="col">
                            <h1 class="EngSM">Projects</h1>
                        </div>
                    </div>
                    <div class="box-padding">
                        <div class="row">
                            @foreach ($home_has_promotion as $has)
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="projectBox">
                                        <a href="{{url($has->url)}}"><img src="{{URL::asset('upload/'.$has->module.'/'.$has->image)}}"></a>
                                        <a class="project-topic" href="{{url($has->url)}}">
                                            <p>{{$has->title}}</p>
                                        </a>
                                        <div class="dateBox">{{strtoupper(date("j M Y", strtotime($has->date)))}}</div>
                                    </div>
                                </div>
                            @endforeach                            
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <div class="content-center">
                                    <a class="buttonBK mt-0" href="/">ดูทั้งหมด</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> -->
                <section class="wow slideInUp" data-wow-delay="1s">
                    <div class="row">
                        <div class="col">
                            <h1 class="EngSM">BJ BROTHERS CHANNEL</h1>
                        </div>
                    </div>
                    <div class="box-padding">
                        <div class="row">
                            @foreach ($news as $news)
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="projectBox">
                                    <a class="project-topic" href="https://www.bjbrothers.com/news#newsPage">
                                            <p>NEWS &EVENTS</p>
                                    </a>
                                        <a href="https://www.bjbrothers.com/news#newsPage"><img src="{{URL::asset('upload/news/'.$news->title_image)}}"></a>
                                   
                                        <div class="content-center">
                                        <br>
                                            <a class="buttonBK mt-0" href="https://www.bjbrothers.com/news#newsPage">เพิ่มเติม</a>
                                       </div>
                                    </div>
                                </div>
                            @endforeach   
                            @foreach ($promotions as $promotions)
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="projectBox">
                                    <a class="project-topic" href="https://www.bjbrothers.com/promotion#promotionPage">
                                    <p>PROMOTIONS</p>
                                    </a>
                                        <a href="https://www.bjbrothers.com/promotion#promotionPage"><img src="{{URL::asset('upload/promotion/'.$promotions->title_image)}}"></a>
                                   
                                        <div class="content-center">
                                        <br>
                                            <a class="buttonBK mt-0" href="https://www.bjbrothers.com/promotion#promotionPage">เพิ่มเติม</a>
                                       </div>
                                    </div>
                                </div>
                            @endforeach    
                            @foreach ($safetys as $safetys)
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="projectBox">
                                    <a class="project-topic" href="https://www.bjbrothers.com/safety">
                                            <p>KNOWLEDGES</p>
                                    </a>
                                        <a href="https://www.bjbrothers.com/safety"><img src="https://www.bjbrothers.com/upload/safety/carfirer.jpg"></a>
                                   
                                        <div class="content-center">
                                        <br>
                                            <a class="buttonBK mt-0" href="https://www.bjbrothers.com/safety">เพิ่มเติม</a>
                                       </div>
                                    </div>
                                </div>
                            @endforeach                             
                        </div>
                    </div>
                    <!-- <div class="w-100">
                        <div class="row">
                            <div class="col">
                                <div class="content-center">
                                    <a class="buttonBK mt-0" href="/">ดูทั้งหมด</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </section>
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    
    <script src="wow-master/dist/wow.min.js"></script>
    <script src="OwlCarousel/owl.carousel.min.js"></script>
    <script type="text/javascript">
        //new WOW().init();
        
        $(document).ready(function() {
        $('.banner-slide').owlCarousel({
            loop: true,
            margin: 10,
            slideBy: 5,
            autoplay: true,
            autoplayHoverPause: false,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            dots: true,
            smartSpeed: 3000,
            autoplayTimeout: 15000,
            responsive: {
                0: {
                    items: 1,
                    margin: 0,
                    slideBy: 1
                },
                640: {
                    items: 1,
                    margin: 10,
                    slideBy: 3
                },
                1024: {
                    items: 1,
                    margin: 10,
                    slideBy: 5
                }
            }
        })
        });
        
        $(document).ready(function() {
        $('.product-slide').owlCarousel({
            loop: false,
            margin: 10,
            slideBy: 5,
            autoplay: false,
            autoplayHoverPause: false,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            dots: true,
            smartSpeed: 750,
            autoplayTimeout: 1500,
            responsive: {
                0: {
                    items: 1,
                    margin: 0,
                    slideBy: 1
                },
                640: {
                    items: 3,
                    margin: 10,
                    slideBy: 3
                },
                1024: {
                    items: 5,
                    margin: 10,
                    slideBy: 5
                }
            }
        })
        });
        
        $(document).ready(function() {
        $('.category-slide').owlCarousel({
            loop: false,
            margin: 10,
            autoplay: false,
            autoplayHoverPause: false,
            nav: true,
            navText: [
                '<i class="fas fa-chevron-left"></i>',
                '<i class="fas fa-chevron-right"></i>'
            ],
            dots: true,
            smartSpeed: 500,
            autoplayTimeout: 1000,
            responsive: {
                0: {
                    items: 1,
                    slideBy: 1,
                    margin: 5
                },
                640: {
                    items: 3,
                    slideBy: 3,
                    margin: 12
                },
                1024: {
                    items: 4,
                    slideBy: 4,
                    margin: 15
                }
            }
        })
        });

        
    </script>
    
</body>
</html>