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
                
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <h3 class="text-center mb-5">สินค้าแนะนำ</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <ul class="product-page bottom-none">
                                @foreach ($recommand_product as $recommand)
                                <li>
                                    <a class="productBox-BD" href="{{url('product/'.$recommand->product_name.'___'.$recommand->id)}}">
                                        <div class="productBox">
                                            <div class="product-img"><img src="{{URL::asset('upload/product/'.$recommand->product_image)}}"></div>
                                            <ul class="productBox-name">
                                                <li>
                                                    <p>{{$recommand->product_name}}</p>
                                                </li>
                                                <li>{{$recommand->product_code}}</li>
                                                @if($recommand->product_price > 0)
                                                <li>฿ {{number_format($recommand->product_price,2)}}</li>
                                                @else
                                                <li><p class="price sale" style="color:#f32836;font-size: 15px;"><i>สอบถามราคาเพิ่มเติม</i></p></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </a> 
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col mt-5">
                        <div class="doubleBD">
                            <div class="content-center">
                                <a style="display: block !important;" class="buttonBK" href="{{ url('promotion') }}#promotionPage">ย้อนกลับ</a>
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