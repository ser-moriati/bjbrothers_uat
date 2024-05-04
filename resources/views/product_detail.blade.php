<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- FANCYBOX -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <!-- OwlCarousel -->
    <link rel="stylesheet" href="{{URL::asset('OwlCarousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('OwlCarousel/owl.theme.default.min.css')}}">

    <meta property="og:url"           content="{{url()->current()}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="{{$product->product_name.' '.$product->product_code}}" />
    <meta property="og:description"   content="{{$product->product_name.' '.$product->product_code.' '.$product->meta_description}}" />
    <meta property="og:image"         content="{{URL::asset('upload/product/'.$product->product_image)}}" />
    {{-- <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> --}}
    <style>
        #Size .btn {
            margin-right: 5px; /* ระยะห่างระหว่างปุ่ม */
        }
    </style>
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
                            <li><a href="/">หน้าแรก </a></li>
                            <li>สินค้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="navGray mobile-none">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb big">
                            <li><a href="/category/{{$product->category_name}}">{{$product->category_name}}</a></li>
                            <li><a href="/subcategory/{{$product->sub_category_name}}">{{$product->sub_category_name}}</a></li>
                            <li>{{$product->product_name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- P R O D U C T :: D E T A I L ---------->
    <div class="content-padding pad-foot" id="product">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <!-- PRODUCT :: IMAGE -->
                    <div class="col-lg-6 col-md-12 col-12 mb-5">
                        <div class="product-slide">
                            <div id="big" class="owl-carousel owl-theme">
                                <a class="item" data-fancybox="gallery" href="{{URL::asset('upload/product/'.$product->product_image)}}"><img src="{{URL::asset('upload/product/'.$product->product_image)}}"></a>
                                @foreach ($ProductsOption1 as $_image)
                                    @if(!empty($_image->img))
                                        <a class="item" data-fancybox="gallery" href="{{URL::asset('upload/product/'.$_image->img)}}"><img src="{{URL::asset('upload/product/'.$_image->img)}}"></a>
                                    @endif
                                @endforeach
                                @foreach ($ProductsOption2 as $_image2)
                                    @if(!empty($_image2->img))
                                        <a class="item" data-fancybox="gallery" href="{{URL::asset('upload/product/'.$_image2->img)}}"><img src="{{URL::asset('upload/product/'.$_image2->img)}}"></a>
                                    @endif
                                @endforeach
                                @foreach ($gallery as $gall)
                                <a class="item" data-fancybox="gallery" href="{{URL::asset('upload/product/gallerys/'.$gall->image_name)}}"><img src="{{URL::asset('upload/product/gallerys/'.$gall->image_name)}}"></a>
                                @endforeach
                            </div>
                            <div id="thumbs" class="owl-carousel owl-theme">
                                <div class="item"><img src="{{URL::asset('upload/product/'.$product->product_image)}}"></div>
                                @foreach ($ProductsOption1 as $_image)
                                    @if(!empty($_image->img))
                                        <a class="item" data-fancybox="gallery" href="{{URL::asset('upload/product/'.$_image->img)}}"><img src="{{URL::asset('upload/product/'.$_image->img)}}"></a>
                                    @endif
                                @endforeach
                                @foreach ($ProductsOption2 as $_image2)
                                    @if(!empty($_image2->img))
                                        <a class="item" data-fancybox="gallery" href="{{URL::asset('upload/product/'.$_image2->img)}}"><img src="{{URL::asset('upload/product/'.$_image2->img)}}"></a>
                                    @endif
                                @endforeach
                                @foreach ($gallery as $gall)
                                <div class="item"><img src="{{URL::asset('upload/product/gallerys/'.$gall->image_name)}}"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- PRODUCT :: INFO -->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="row">
                            <div class="col">
                                <div class="product-info product-topic">
                                    <p>{{$product->product_code}}</p>
                                    <h2>{{$product->product_name}}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <ul class="brand">
                                        <li>BRAND :</li>
                                        <li>{{$product->brand_name}}</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <ul class="brand">
                                        <li>MODEL :</li>
                                        <li>{{$product->product_version}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="txt-content product-caption">
                                        <p>{{$product->product_detail}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="w-100">
                            <!-- PRICE -->
                            <div class="row">
                                <div class="col">
                                    <!-- PRICE -->
                                    <!--<div class="price">฿ 2,000</div>-->
                                    <!-- FULL PRICE -->
                                    <!-- SALE PRICE -->
                                    @if ($max_sale > 0)
                                        @if ($max_sale > 0)
                                        @if( $role_name == '')
                                        <div id= "price" class="price sale">฿ {{number_format($min_sale,2)}} - {{number_format($max_sale,2)}}</div>
                                        @else
                                            @if($min_sale == $max_sale)
                                                <div id= "price"  class="price">฿ {{number_format($min_sale,2)}}</div>
                                            @else
                                                <div class="price full">฿ {{number_format($max_sale,2)}}</div>
                                                <div id= "price"  class="price sale">฿ {{number_format($min_sale,2)}} - {{number_format($max_sale,2)}}</div>
                                            @endif
                                        @endif
                                         
                                        @else
                                            <div  id= "price" class="price sale">฿  {{number_format($min_sale,2)}} - {{number_format($max_sale,2)}}</div>
                                        @endif
                                    @else
                                    
                                    <div class="price sale" ><a href="https://line.me/R/ti/p/%40moz3566f"  style="color:#f32836;font-size: 15px;"><i>สอบถามราคาเพิ่มเติม</i></a></div>
                                  
                                    @endif
                                        
                                    <!-- MEMBER LEVEL  -->
                                    @if( $role_name == '')
                                    <div class="price sale" ><a href="https://line.me/R/ti/p/%40moz3566f"  style="color:#0099FF; font-size: 15px;">&nbsp; ขอราคาส่ง/ราคาโครงการคลิ้กที่นี</a></div>
                                    @else
                                    <div class="member-level">{{ $role_name }}</div>  
                                  
                         
                                     <div class="price sale" ><a href="https://line.me/R/ti/p/%40moz3566f"  style="color:#0099FF; font-size: 15px;">&nbsp; ขอราคาส่ง/ราคาโครงการคลิ้กที่นี</a></div>
                                   
                                    @endif
                                </div>
                            </div>
                            <form action="{{ url('shipping_payment/now') }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="product-option">
                                    <!-- COLOR -->
                                   
                                  

                               
                                    <div class="row">
                                        <div class="col">
                                            <input type="hidden" name="color" id="color">
                                            <input type="hidden" name="productsku_id" id="productsku_id">
                                            @php
                                                $headname1 =  DB::Table('productsoptionhead')->where('option_type',1)->where('product_id',$product_id)->first();
                                            @endphp
                                            <div class="option-topic">{{@$headname1->name_th}}<strong id="invColor" style="color: red;font-size: 15px"></strong>@if(session('message1'))<strong  style="color: red;font-size: 15px">   {{ session('message1') }}</strong>@endif</div>
                                            @foreach($ProductsOption1 as $ProductsOption1)
                                                <button id="myButton" type="button" class="btn btn-outline product-button" data-product-name="{{$ProductsOption1->product_id}},{{$ProductsOption1->id}}">
                                                    @if(@$ProductsOption1->img)
                                                        <img class="product-button" style="max-width: 40px;" src="{{URL::asset('upload/product/'.$ProductsOption1->img)}}">
                                                    @endif
                                                    {{$ProductsOption1->name_th}}
                                                </button>

                                            @endforeach
                                        </div>
                                    </div>
                                   
                                    <div class="productDetail-select">
                                        <div class="row">
                                            <!-- SIZE -->
                                            @php
                                                $headname2 =  DB::Table('productsoptionhead')->where('option_type',2)->where('product_id',$product_id)->first();
                                            @endphp
                                            @if(@$headname2->name_th == NULL)

                                            @else
                                                <div class="col-lg-6 col-md-6 col-8">
                                                    <div class="option-topic">{{@$headname2->name_th}} <strong id="invSize" style="color: red;font-size: 15px">  </strong>@if(session('message2'))<strong  style="color: red;font-size: 15px">   {{ session('message2') }}</strong>@endif</div>
                                                    <input type="hidden" name="size" id="size">
                                                    <input type="hidden" name="check" id="check">
                                                    <div class="form-select" id="Size">
                                                        @foreach($ProductsOption2 as $productOption)
                                                            <button type="button" class="btn btn-outline  product-button1" data-product-name="{{$productOption->name_th}}">{{$productOption->name_th}}</button>  
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            
                                           
                                            </div>  
                                        </div>
                                        <div class="row">
                                          <!-- QUANTITY -->
                                          <div class="col-lg-6 col-md-6 col-8">
                                                <div class="option-topic">Qty <strong id="invQty" style="color: red;font-size: 15px"></strong></div>
                                                <div class="sp-quantity big mb-4">
                                                    <div class="sp-minus btnquantity"><i class="fas fa-minus"></i></div>
                                                    <div class="sp-input">
                                                        <input type="text" id="qty" name="qty" class="quntity-input" value="1" />
                                                        <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}" />

                                                    </div>
                                                    <div class="sp-plus btnquantity"><i class="fas fa-plus"></i></div>
                                            </div>     
                                        </div>         
                                    </div>
                                 @if($headname1)
                                    <div class="cart-button-part  ">
                                            <div class="row" style="margin-top: 5%;">
                                                <div class="col-lg-6 col-md-6 col-12" >
                                                   
                                                        <button type="submit" class="btn buttonBK large">
                                                            <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}" onclick="addCartnow()" >สั่งซื้อสินค้า</span>
                                                        </button>
                                                   
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12" id="cartBTN">
                                                        <button  type="button" class="btn buttonBK large"  onclick="addCart()">
                                                            <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">หยิบใส่ตะกร้า</span>
                                                        </button>
                                                </div>
                                            
                                              
                                            </div>
                                    </div>
                                 @else
                                   <div class="cart-button-part  ">
                                            <div class="row" style="margin-top: 5%;">
                                                <div class="col-lg-6 col-md-6 col-12" >
                                                   
                                                        <button type="submit" class="btn buttonBK large" disabled>
                                                            <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}" onclick="addCartnow()" >สั่งซื้อสินค้า</span>
                                                        </button>
                                                   
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12" id="cartBTN">
                                                        <button  type="button" class="btn buttonBK large"  onclick="addCart()" disabled>
                                                            <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">หยิบใส่ตะกร้า</span>
                                                        </button>
                                                </div>
                                            
                                              
                                            </div>
                                    </div>
                                 @endif   
                                
                                    @if ($max_sale >= 0)
                                  
                                        @else
                                        <!-- <div class="cart-button-part 
                                                @if(count($size) == 0)
                                                        mt-4
                                                @endif   ">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12" id="cartBTN">
                                                @if (@$quotation > 0)
                                                        <button type="button" class="btn buttonBD large" style="pointer-events:none;">
                                                            <span><i class="fas fa-file-alt"></i>เพิ่ม สอบถามราคา &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span>
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn buttonBD large" onclick="addQuotation()">
                                                            <span><i class="fas fa-file-alt"></i>เพิ่ม สอบถามราคา</span>
                                                        </button>
                                                    @endif
                                                </div>
                                            
                                                <div class="col-lg-6 col-md-6 col-12" id="quotationBTN">
                                                
                                                </div>
                                            </div>
                                        </div> -->
                                        @if($headname1)
                                            <div class="cart-button-part  
                                                    @if(count($size) == 0)
                                                            mt-4
                                                    @endif   " >
                                                <div class="row"   style="margin-top: 5%;">
                                                    <div class="col-lg-6 col-md-6 col-12" id="cartBTN">
                                                    
                                                            <button type="button" class="btn buttonBK large" onclick="addCartnow()" >
                                                                <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">สั่งซื้อสินค้า</span>
                                                            </button>
                                                
                                                    </div>
                                                
                                                    <div class="col-lg-6 col-md-6 col-12" id="cartBTN">
                                                        @if (@$cart > 0)
                                                            <button type="button" class="btn buttonBD large" style="pointer-events:none;">
                                                                <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">หยิบใส่ตะกร้า &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn buttonBD large" onclick="addCart()">
                                                                <span><i class="fas fa-file-alt"></i>หยิบใส่ตะกร้า</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                        <div class="cart-button-part  
                                                    @if(count($size) == 0)
                                                            mt-4
                                                    @endif   " >
                                                <div class="row"   style="margin-top: 5%;">
                                                    <div class="col-lg-6 col-md-6 col-12" id="cartBTN">
                                                    
                                                            <button type="button" class="btn buttonBK large" onclick="addCartnow()"  disabled>
                                                                <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">สั่งซื้อสินค้า</span>
                                                            </button>
                                                
                                                    </div>
                                                
                                                    <div class="col-lg-6 col-md-6 col-12" id="cartBTN">
                                                        @if (@$cart > 0)
                                                            <button type="button" class="btn buttonBD large" style="pointer-events:none;" >
                                                                <span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">หยิบใส่ตะกร้า &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn buttonBD large" onclick="addCart()" disabled>
                                                                <span><i class="fas fa-file-alt"></i>หยิบใส่ตะกร้า</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                
                                    @endif
                                </form>
                                {{-- เริ่ม แชร์ faceboock เก่า --}}
                                {{-- <div class="row">
                                    <div class="col-12 mt-4">
                                        <!-- Load Facebook SDK for JavaScript -->
                                        <div id="fb-root"></div>
                                        <script>(function(d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) return;
                                        js = d.createElement(s); js.id = id;
                                        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                                        fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));</script>

                                        <!-- Your share button code -->
                                        <div class="fb-share-button" 
                                        data-href="{{url()->current()}}" 
                                        data-layout="button_count">
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- จบ แชร์ faceboock เก่า --}}

                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                
                            <div class="addthis_inline_share_toolbox" style="margin-top: 70px;"></div>
            
                            </div>
                            
                        </div> 
                    </div>
                </div>
                
                <!---------- P R O D U C T S :: I N F O M A T I O N ---------->
                <div class="product-section">
                    <div class="product-tab">
                        <div class="row">
                            <div class="col">
                                <ul class="menu-product-tab anchor">
                                    @if ($product->product_video != '')
                                        <li><a href="#vdo">VIDEO</a></li>
                                    @endif
                                    <li><a href="#detail">DETAILED DESCRIPTION</a></li>
                                    <li><a href="#technic">TECHNICAL INFORMATION</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                        
                    @if ($product->product_video != '')
                        <div class="productInfo-padding" id="vdo">
                            <div class="row">
                                <div class="col">
                                    <h4 class="EngSM mobile-s">VIDEO</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="video">
                                        <iframe src="https://www.youtube.com/embed/{{$product->product_video}}" frameborder="0" allow="autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="productInfo-padding" id="detail">
                        <div class="row">
                            <div class="col">
                                <h4 class="EngSM">DETAILED DESCRIPTION</h4>
                            </div>
                        </div>
                        {!!str_replace('<h6>','<div style="display: flex;">',$product->product_description)!!}
                    </div>
                    <div class="productInfo-padding" id="technic">
                        <div class="row">
                            <div class="col">
                                <h4 class="EngSM">TECHNICAL INFORMATION</h4>
                            </div>
                        </div>
                        <div class="technic-info">
                            @foreach ($files as $file)
                            
                            <div class="row">
                                <div class="col-lg-3">
                                    <p style="overflow-wrap: break-word;">{{$file->file_name}}</p>
                                </div>
                                <div class="col-lg-9">
                                    @if($file->url == null && $file->file_name != null)
                                        <a href="{{URL::asset('upload/product/files/'.$file->file_name)}}"><i class="fas fa-arrow-circle-down"></i>Download file PDF</a>
                                    @else
                                        <a href="{{$file->url}}"><i class="fas fa-arrow-circle-down"></i>Video</a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                        
                    </div>
                        
                </div>
                
                <!---------- R E L A T E D - P R O D U C T S ---------->
                <div class="mobile-none w-100">
                    <div class="row">
                        <div class="col">
                            <h1 class="EngSM">RELATED PRODUCTS</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <ul class="product-page bottom-none">
                                @foreach ($related_product as $related)
                                <li>
                                    <a class="productBox-BD" href="{{url('product/'.$related->product_name.'___'.$related->id)}}">
                                        <div class="productBox">
                                            <div class="product-img"><img src="{{URL::asset('upload/product/'.$related->product_image)}}"></div>
                                            <ul class="productBox-name">
                                                <li>
                                                    <p>{{$related->product_name}}</p>
                                                </li>
                                                <li>{{$related->product_code}}</li>
                                                @if($related->product_price > 0)
                                                <li>฿ {{number_format($related->product_price,2)}}</li>
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
                    
            </div>
                
        </div>
    </div>
   
    @include('inc_topbutton')
    @include('inc_footer')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    console.log('X1 : '+x1);
    console.log('X2 : '+x2);
    return '฿ '+x1 + x2;
}

$(document).ready(function() {
    // เพิ่มการที่จะตอบสนองเมื่อคลิกปุ่มสินค้า
    $('.product-button').on('click', function() {
        // ดึงข้อมูลจากแอตทริบิวต์ data-product-name
        var productName = $(this).data('product-name');
        var result_productName  = productName.split(",");
        
        var product_id = result_productName[0];
        var id_color = result_productName[1];

        // ลบคลาส 'btn-outline' และเพิ่มคลาส 'btn-secondary' สำหรับปุ่มที่ถูกคลิก
        $(this).removeClass('btn-outline').addClass('btn-secondary');    
        
        // ลบคลาส 'btn-secondary' และเพิ่มคลาส 'btn-outline' สำหรับปุ่มที่ไม่ได้ถูกคลิก
        $('.product-button').not(this).removeClass('btn-secondary').addClass('btn-outline');

        $.ajax({
            url: '{{url('product/color')}}',
            type: 'POST',
            data: {_token: "{{ csrf_token() }}", id_color: id_color, product_id: product_id },
            success: function (response) {
                var buttonsHtml = '';

                if (response.result) {
                    console.log(response.result.product_check);
                    if (response.result.product_check == 0) {
                        $('#price').text(addCommas(response.result.price));
                        $('#color').val(response.result.color);
                        $('#check').val(response.result.product_check);
                        $('#productsku_id').val(response.result.productskusizes_id);
                    } else {
                        response.result.forEach(function(item) {
                            $('#check').val(item.product_check);
                            $('#color').val(item.color);
                            buttonsHtml += '<button type="button" class="btn btn-outline product-button1" data-product-name="' + item.productskusizes_id  + '">' + item.product_size_name + '</button>';
                        });

                        // แสดง HTML ทั้งหมดใน element ที่มี id="Size"
                    }
                }

                $('#Size').html(buttonsHtml);
            },
            error: function (error) {
                console.error(error);
            }
        });

    });


});
$(document).on('click', '.product-button1', function() {
    var productName = $(this).data('product-name');

    // ลบคลาส 'btn-outline' และเพิ่มคลาส 'btn-secondary' สำหรับปุ่มที่ถูกคลิก
    $(this).removeClass('btn-outline').addClass('btn-secondary');

    // ลบคลาส 'btn-secondary' และเพิ่มคลาส 'btn-outline' สำหรับปุ่มที่ไม่ได้ถูกคลิก
    $('.product-button1').not(this).removeClass('btn-secondary').addClass('btn-outline');

    $.ajax({
        url: '{{url('product/size')}}',
        type: 'POST',
        data: {_token: "{{ csrf_token() }}", productsku_id: productName },
        success: function (response) {
            console.log(response);
            response.result.forEach(function(item) {
                $('#price').text(item.price);
                $('#color').val(item.color);
                $('#size').val(item.size);
                $('#productsku_id').val(item.productskusizes_id);
            });
        },
        error: function (error) {
            console.error(error);
        }
    });
});





</script>
 
    <!-- FANCYBOX -->
    {{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> --}}
<script>
    // $.simplyToast('success', 'This is a success message!');
// $.simplyToast('warning', 'This is a warning message!');
// $.simplyToast('info', 'This is a info message!');
// $.simplyToast('danger', 'This is a danger message!');

// $.simplyToast.clear(); // To clear current messages<br type="_moz">
</script>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6144489aac111d3e"></script>

    <script>
      
        // console.log(color_check);
        function addCart(){
            $.ajax({
                    type: "GET",
                    url: "{{url('/checkAuth')}}",
                    success: function( result) {
                        // console.log(result);
                        if(result == false){
                            
                            var qty = $('#qty').val();
                            if(qty < 1){
                                validate = 1;
                                return $('#invQty').html('*Please enter a valid quntity.');
                            }else{
                                $('#invQty').html('');
                            }


                            if(validate == 1) return
                            $.ajax({
                                type: "POST",
                                url: "{{url ('quotation_cus')}}",
                                data: {_token: "{{ csrf_token() }}", product_id: "{{$product->id}}", qty: qty, color_id: color, size_id: size},
                                success: function( result) {
                                    if(result.status != 201){
                                        return alert(result.message);
                                    }
                                    $('.quotationCartAll').html(result.message);
                                    $('#quotationBTN').html('<button type="button" class="btn buttonBD large" style="pointer-events:none;"><span><i class="fas fa-file-alt"></i>ADDED TO QUOTATION &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span></button>');
                                    $.simplyToast('success', 'ADDED TO QUOTATION');

                                },error : function(e){
                                    console.log(e)
                                }
                            });
                            return;
                        }
                        
                        var validate = 0;
                        var color = $("#color").val();
                        // return console.log(color);
                        // return console.log(color);
                            if(color == '' ){
                                $('#invColor').html('*กรุณาเลือกตัวเลือกของสินค้า');
                                validate = 1;
                            }else{
                                $('#invColor').html('');
                                var check = $('#check').val();
                                if(check == 0){
                                    if(qty < 1){
                                        validate = 1;
                                        return $('#invQty').html('*Please enter a valid quntity.');
                                    }else{
                                        $('#invQty').html('');
                                        if(validate == 1) return
                                        $.ajax({
                                                type: "POST",
                                                url: "{{url ('/cart')}}",
                                                data: {_token: "{{ csrf_token() }}", product_id: "{{$product->id}}", qty: qty, color_id: color, size_id: size, productsku_id: productsku_id},
                                                success: function( result ) {
                                                    if(result.status != 201){
                                                        return alert(result.message);
                                                    }
                                                    // var url = 'images/icon/icon-cartWH.svg';
                                                    $('.cartAll').html(result.message);
                                                    $('#cartBTN').html('<button type="button" class="btn buttonBK large" style="pointer-events:none;"><span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">ADDED TO CART &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span></button>');
                                                    $.simplyToast('success', 'ADDED TO CART');

                                                },error : function(e){
                                                    console.log(e)
                                                }
                                        });
                                    }
                                }else{
                                    var size = $('#size').val();
                                    if(size ==  ''){
                                        $('#invSize').html('*กรุณาเลือกตัวเลือกของสินค้า');
                                        validate = 1;
                                    }else{
                                        $('#invSize').html('');
                                        var qty = $('#qty').val();
                                        var productsku_id = $('#productsku_id').val();
                                        if(qty < 1){
                                            validate = 1;
                                            return $('#invQty').html('*Please enter a valid quntity.');
                                        }else{
                                            $('#invQty').html('');
                                            if(validate == 1) return
                                            $.ajax({
                                                    type: "POST",
                                                    url: "{{url ('/cart')}}",
                                                    data: {_token: "{{ csrf_token() }}", product_id: "{{$product->id}}", qty: qty, color_id: color, size_id: size, productsku_id: productsku_id},
                                                    success: function( result ) {
                                                        if(result.status != 201){
                                                            return alert(result.message);
                                                        }
                                                        // var url = 'images/icon/icon-cartWH.svg';
                                                        $('.cartAll').html(result.message);
                                                        $('#cartBTN').html('<button type="button" class="btn buttonBK large" style="pointer-events:none;"><span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">ADDED TO CART &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span></button>');
                                                        $.simplyToast('success', 'ADDED TO CART');

                                                    },error : function(e){
                                                        console.log(e)
                                                    }
                                            });
                                        }
                                    }
                                }
                              

                            }
                            
                       
                      

                       

                    },error : function(e){
                        console.log(e)
                    }
                });

            // alert(1);
        }

        function addCartnow(){
            $.ajax({
                    type: "GET",
                    url: "{{url('/checkAuth')}}",
                    success: function( result) {
                        // console.log(result);
                        if(result == false){
                            
                            var qty = $('#qty').val();
                            if(qty < 1){
                                validate = 1;
                                return $('#invQty').html('*Please enter a valid quntity.');
                            }else{
                                $('#invQty').html('');
                            }


                            if(validate == 1) return
                            $.ajax({
                                type: "POST",
                                url: "{{url ('quotation_cus')}}",
                                data: {_token: "{{ csrf_token() }}", product_id: "{{$product->id}}", qty: qty, color_id: color, size_id: size},
                                success: function( result) {
                                    if(result.status != 201){
                                        return alert(result.message);
                                    }
                                    $('.quotationCartAll').html(result.message);
                                    $('#quotationBTN').html('<button type="button" class="btn buttonBD large" style="pointer-events:none;"><span><i class="fas fa-file-alt"></i>ADDED TO QUOTATION &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span></button>');
                                    $.simplyToast('success', 'ADDED TO QUOTATION');

                                },error : function(e){
                                    console.log(e)
                                }
                            });
                            return;
                        }
                        
              
                        if(validate == 1) return
                        var validate = 0;
                        var color = $("#color").val();
                        // return console.log(color);
                        // return console.log(color);
                            if(color == '' ){
                                $('#invColor').html('*Please select color');
                                validate = 1;
                            }else{
                                $('#invColor').html('');
                                var size = $('#size').val();
                                if(size == "" ){
                                    $('#invSize').html('*Please select size');
                                    validate = 1;
                                }else{
                                    $('#invSize').html('');
                                    var qty = $('#qty').val();
                                    var productsku_id = $('#productsku_id').val();
                                    if(qty < 1){
                                        validate = 1;
                                        return $('#invQty').html('*Please enter a valid quntity.');
                                    }else{
                                        $('#invQty').html('');
                                        $.ajax({
                                        type: "POST",
                                        url: "{{url ('/insert_now')}}",
                                        data: {_token: "{{ csrf_token() }}", product_id: "{{$product->id}}", qty: qty, color_id: color, size_id: size, productsku_id: productsku_id},
                                        success: function( result ) {
                                            if(result.status != 201){
                                                return alert(result.message);
                                            }
                                            // var url = 'images/icon/icon-cartWH.svg';
                                            $('.cartAll').html(result.message);
                                            $('#cartBTN').html('<button type="button" class="btn buttonBK large" style="pointer-events:none;"><span><img src="{{URL::asset('images/icon/icon-cartWH.svg')}}">ADDED TO CART &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span></button>');
                                            $.simplyToast('success', 'ADDED TO CART');

                                        },error : function(e){
                                            console.log(e)
                                        }
                                    });

                                    }
                                }

                            }
                    },error : function(e){
                        console.log(e)
                    }
                });

            // alert(1);
        }
        function addQuotation(){
            $.ajax({
                    type: "GET",
                    url: "/checkAuth",
                    success: function( result) {
                        // console.log(result);
                        if(result == false){
                            var qty = $('#qty').val();
                            if(qty < 1){
                                validate = 1;
                                return $('#invQty').html('*Please enter a valid quntity.');
                            }else{
                                $('#invQty').html('');
                            }

                            if(validate == 1) return
                            $.ajax({
                                type: "POST",
                                url: "/quotation_cus",
                                data: {_token: "{{ csrf_token() }}", product_id: "{{$product->id}}", qty: qty, color_id: color, size_id: size},
                                success: function( result) {
                                    if(result.status != 201){
                                        return alert(result.message);
                                    }
                                    $('.quotationCartAll').html(result.message);
                                    $('#quotationBTN').html('<button type="button" class="btn buttonBD large" style="pointer-events:none;"><span><i class="fas fa-file-alt"></i>ADDED TO QUOTATION &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span></button>');
                                    $.simplyToast('success', 'ADDED TO QUOTATION');

                                },error : function(e){
                                    console.log(e)
                                }
                            });
                            return;
                            return window.location.href = "/login";
                        }
                        
                        var validate = 0;
                        var color = $(".color").val();
                        // return console.log(color);
                        
                            if(color == undefined){
                                $('#invColor').html('*Please select color');
                                validate = 1;
                            }else{
                                $('#invColor').html('');
                            }
                            
                            var size = $('#size').val();
                            if(size == "" && size_check == 1){
                                $('#invSize').html('*Please select size');
                                validate = 1;
                            }else{
                                $('#invSize').html('');
                            }
                          

                       
                            var qty = $('#qty').val();
                            if(qty < 1){
                                validate = 1;
                                return $('#invQty').html('*Please enter a valid quntity.');
                            }else{
                                $('#invQty').html('');
                            }

                            if(validate == 1) return

                        $.ajax({
                                type: "POST",
                                url: "/quotation",
                                data: {_token: "{{ csrf_token() }}", product_id: "{{$product->id}}", qty: qty, color_id: color, size_id: size},
                                success: function( result) {
                                    if(result.status != 201){
                                        return alert(result.message);
                                    }
                                    $('.quotationCartAll').html(result.message);
                                    $('#quotationBTN').html('<button type="button" class="btn buttonBD large" style="pointer-events:none;"><span><i class="fas fa-file-alt"></i>ADDED TO QUOTATION &nbsp;<i class="fas fa-check" style="color: greenyellow"></i></span></button>');
                                    $.simplyToast('success', 'ADDED TO QUOTATION');

                                },error : function(e){
                                    console.log(e)
                                }
                            });

                    },error : function(e){
                        console.log(e)
                    }
                });

            // alert(1);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    
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
                items: 5,
                margin: 15,
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
                        items: 5,
                        margin: 10
                    },
                    1024: {
                        items: 5
                    },
                    1200:{
                        items: 5
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

        // ANCHOR SC //
        function scrollNav() {
            $('.menu-product-tab a').click(function(){  
                //Animate
                $('html, body').stop().animate({
                    scrollTop: $( $(this).attr('href') ).offset().top - 70
                }, 800);
                return false;
            });
        }
        scrollNav();
        
        // QTY //
        $(document).ready(function() {
            $(".btnquantity").on("click", function () {
                var $button = $(this);
                var oldValue = $button.closest('.sp-quantity').find("input.quntity-input").val();
                if ($button.hasClass("sp-plus")) {
                    var newVal = parseFloat(oldValue) + 1;
                } else {
                    if (oldValue > 1) {
                        var newVal = parseFloat(oldValue) - 1;
                    } else {
                        newVal = 1;
                    }
                }
                $button.closest('.sp-quantity').find("input.quntity-input").val(newVal);
            });
        });
        
        // COLOR //
            (function($) {
            "use strict";

            var ColorSelector = function(select, options) {
                this.options = options;
                this.$select = $(select);
                this._init();
            };

            ColorSelector.prototype = {

                constructor : ColorSelector,

                _init : function() {

                    var callback = this.options.callback;

                    var selectValue = this.$select.val();
                    var selectColor = this.$select.find("option:selected").data("color");
                    var title = this.$select.find("option:selected").text();

                    var $markupUl = $("<ul>").addClass("dropdown-menu").addClass("dropdown-caret");
                    var $markupDiv = $("<div>").addClass("dropdown").addClass("dropdown-colorselector");
                    var $markupSpan = $("<span>").addClass("btn-colorselector").css("background-color", selectColor).text(title);
                    var $markupA = $("<a>").attr("data-toggle", "dropdown").addClass("dropdown-toggle").attr("href", "#").append($markupSpan);

                    // create an li-tag for every option of the select
                    $("option", this.$select).each(function() {

                        var option = $(this);
                        var value = option.attr("value");
                        var color = option.data("color");
                        var title = option.text();

                        // create a-tag
                        var $markupA = $("<a>").addClass("color-btn");
                        if (option.prop("selected") === true || selectValue === color) {
                            $markupA.addClass("selected");
                        }
                        //$markupA.css("background-color", color);
                        $markupA.attr("href", "#").attr("data-color", color).attr("data-value", value).text(title);
                        $markupA.prepend("<div>");
                        $markupA.find('div').css("background-color", color);

                        // create li-tag
                        $markupUl.append($("<li>").append($markupA));
                    });

                    // append the colorselector
                    $markupDiv.append($markupA);
                    // append the colorselector-dropdown
                    $markupDiv.append($markupUl);

                    // hide the select
                    this.$select.hide();

                    // insert the colorselector
                    this.$selector = $($markupDiv).insertAfter(this.$select);

                    // register change handler
                    this.$select.on("change", function() {

                        var value = $(this).val();
                        var color = $(this).find("option[value='" + value + "']").data("color");
                        var title = $(this).find("option[value='" + value + "']").text();

                        // remove old and set new selected color
                        $(this).next().find("ul").find("li").find(".selected").removeClass("selected");
                        $(this).next().find("ul").find("li").find("a[data-color='" + color + "']").addClass("selected");
                        $(this).next().find(".btn-colorselector").css("background-color", color).text(title);

                        callback(value, color, title);
                    });

                    // register click handler
                    $markupUl.on('click.colorselector', $.proxy(this._clickColor, this));
                },

                _clickColor : function(e) {

                    var a = $(e.target);

                    if (!a.is(".color-btn")) {
                        return false;
                    }

                    this.$select.val(a.data("value")).change();

                    e.preventDefault();
                    return true;
                },

                setColor : function(color) {
                    // find value for color
                    var value = $(this.$selector).find("li").find("a[data-color='" + color + "']").data("value");
                    this.setValue(value);
                },

                setValue : function(value) {
                    this.$select.val(value).change();
                },

            };

            $.fn.colorselector = function(option) {
                var args = Array.apply(null, arguments);
                args.shift();

                return this.each(function() {

                    var $this = $(this), data = $this.data("colorselector"), options = $.extend({}, $.fn.colorselector.defaults, $this.data(), typeof option == "object" && option);

                    if (!data) {
                        $this.data("colorselector", (data = new ColorSelector(this, options)));
                    }
                    if (typeof option == "string") {
                        data[option].apply(data, args);
                    }
                });
            };

            $.fn.colorselector.defaults = {
                callback : function(value, color, title) {
                },
                colorsPerRow : 8
            };

            $.fn.colorselector.Constructor = ColorSelector;

        })(jQuery, window, document);


        $(document).on('ready', function() {
            $('.colorselector').colorselector();    
        });
    </script>

</body>
</html>