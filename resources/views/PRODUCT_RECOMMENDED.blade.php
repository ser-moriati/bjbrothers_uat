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
                        <li><a href="/">หน้าแรก</a></li>
                            <li>PRODUCT RECOMMENDED</li> 
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
  
    
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                
               
               
                <div id="arrivalPage"></div>
                
                <div class="row">
                    <div class="col">
                        <h2 class="EngSM text-center mb-5">PRODUCT RECOMMENDED</h2>
                    </div>
                </div>

                

                <!---------- PRODUCT - PART ---------->
                <div class="row">
                    <div class="col">
                        <ul class="product-page">
                        @foreach ($product_recommended as $k => $pro)
                            <li>
                                <a class="productBox-BD" href="{{url('product/'.str_replace(['#','/'],'',$pro->product_name).'-'.$pro->product_code.'___'.$pro->id)}}">
                                            @if ($pro->product_hot)
                                                <div class="tag"><img src="/images/product/tag-hot.png"></div>
                                            @endif
                                            @if ($pro->product_new)
                                                <div class="tag"><img src="/images/product/tag-new.png"></div>
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
                                            @if($pro->product_price == 0.00)
                                            <li><p class="price sale" style="color:#f32836;font-size: 15px;"><i>สอบถามราคาเพิ่มเติม</i></p></li>
                            
                                            @else
                                            <li>฿ {{number_format($pro->product_price,2)}}</li>
                                            @endif
                                        </ul>
                                    </div>
                                </a>   
                            </li>
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