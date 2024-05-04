<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @php
         $newsName="newarrival";
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
                            <li>ข่าวสารและโปรโมชั่น</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="navGray mobile-none">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb big">
                            <li><a href="product_category.php">อุปกรณ์จราจร</a></li>
                            <li>TA00 : แผงจราจรและแนวกั้นจราจร</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    
    <!--------------- PRODUCT :: BANNER --------------->
    {{-- <div class="banner-GrayBG">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 offset-lg-1 mobile-none">
                    <div class="banner-txt">
                        <div class="banner-topic">สินค้าใหม่</div>
                        <div class="txt-content">
                            <p>พีเรียดกัมมันตะ ทอมซูชิแช่แข็ง รีสอร์ท กัมมันตะแบรนด์ชาร์จ รูบิกอึ้มเวิร์กช็อปสตีลเดชานุภาพ ซื่อบื้อแคร์เพลย์บอยแทงกั๊ก ยูโรดยุก ต่อยอดซาร์ดีน บุ๋น แบนเนอร์ซัมเมอร์ไฮเทค วืดบิ๊กพฤหัสคำสาปโอเพ่น มั้งบ๋อยกรีนรองรับ ช็อปปิ้งซูฮก ราเม็งเพลย์บอยดยุกชาร์ป เลกเชอร์ไทเฮามหาอุปราชา งั้นไวกิ้งวิปรูบิกพาร์ทเนอร์ แยมโรลโปรเจ็คชาร์จเปปเปอร์มินต์</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="img-width" id="banner">
                        <img src="{{ asset('images/product/banner-newarrival.jpg') }}">
                        <!-- FOR MOBILE -->
                        <div class="gradient-banner mobile">
                            <div class="banner-topic">สินค้าใหม่</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                
                @include('inc_news_submenu')
               
                <div id="arrivalPage"></div>
                
                <div class="row">
                    <div class="col">
                        <h2 class="EngSM text-center mb-5">NEW ARRIVAL</h2>
                    </div>
                </div>

                @include('inc_product_search')

                <!---------- PRODUCT - PART ---------->
                <div class="row">
                    <div class="col">
                        <ul class="product-page">
                            @foreach ($product as $k => $pro)
                            <li>
                                <a class="productBox-BD" href="{{url('product/'.str_replace(['#','/'],'',$pro->product_name).'-'.$pro->product_code.'___'.$pro->id)}}">
                                            @if ($pro->product_hot)
                                                <div class="tag"><img src="{{ asset('images/product/tag-hot.png') }}"></div>
                                            @endif
                                            @if ($pro->product_new)
                                                <div class="tag"><img src="{{ asset('images/product/tag-new.png') }}"></div>
                                            @endif
                                    <div class="productBox">
                                        <div class="product-img">
                                            <img src="{{URL::asset('upload/product/'.$pro->product_image)}}" onerror="this.onerror=null; this.src='{{asset('images/LOGO-BJ.png')}}'">
                                        </div>
                                        <ul class="productBox-name">
                                            <li>
                                                <p>{{$pro->product_name}}</p>
                                            </li>
                                            <li>{{$pro->product_code}}</li>
                                            @if ($pro->product_price > 0)
                                                @if ($pro->product_sale > 0)
                                                    <li>฿ {{number_format($pro->product_sale,2)}}</li>
                                                @else
                                                    <li>฿ {{number_format($pro->product_price,2)}}</li>
                                            
                                                @endif
                                            @else
                                            <li><p class="price sale" style="color:#f32836;font-size: 15px;"><i>สอบถามราคาเพิ่มเติม</i></p></li>
                                            @endif
                                        </ul>
                                    </div>
                                </a>  
                            </li>

                            {{-- @if (($k+1)%5==0)
                                <div class="clearfix"></div>
                            @endif --}}
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <!--------------- P A G E --------------->
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{  $product->links() }}
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
    
</body>
</html>