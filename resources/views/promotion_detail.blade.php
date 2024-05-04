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
                
                <h4 style="margin-top: 10px;">สินค้าที่เกี่ยวข้อง</h4>
                <div class="content-padding pad-foot">
                    <div class="container-fluid">
                        <div class="wrap-pad">
                            <section class="wow slideInUp" data-wow-delay="1s">
                                <div class="row">
                                    <div class="col">
                                        <div class="slide-navButton">
                                            <div class="product-slide owl-carousel owl-theme mb-4">
                                                @foreach ($recommand_product as $pro)
                                                    
                                                <div class="items ">
                                                <a class="productBox-BD" href="{{url('product/'.$pro->product_name.'___'.$pro->id)}}">
                                                       <!-- TAG -->
                                                       @if ($pro->product_hot)
                                                            <div class="tag"><img src="{{ asset('images/product/tag-hot.png') }}"></div>
                                                        @endif
                                                        @if ($pro->product_new)
                                                            <div class="tag"><img src="{{ asset('images/product/tag-new.png') }}"></div>
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
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col mt-5">
                        <div class="doubleBD">
                            <div class="content-center">
                                <a class="buttonBK" href="{{ url('promotion') }}#promotionPage">ย้อนกลับ</a>
                            </div> 
                        </div>
                    </div>
                </div>
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')

    <script src="{{ asset('wow-master/dist/wow.min.js') }}"></script>
    <script src="{{ asset('OwlCarousel/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">
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
    </script>
    
</body>
</html>