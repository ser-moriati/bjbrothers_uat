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
                            <li><a href="/category/{{$category->category_name}}">{{$category->category_name}}</a></li>
                            @isset($sub_first->id)<li>{{$sub_first->sub_category_code}} : {{$sub_first->sub_category_name}}</li>@endisset
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- PRODUCT :: BANNER --------------->
    <div class="banner-GrayBG">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4 offset-1 mobile-none">
                    <div class="banner-txt">
                        <div class="banner-topic">{{$sub_first->sub_category_name}}</div>
                        <div class="txt-content">
                            <p>{{$sub_first->sub_category_detail}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-12">
                    <div class="img-width">
                        <img src="{{URL::asset('upload/sub_category/banner/'.$sub_first->sub_category_banner)}}">
                        <!-- FOR MOBILE -->
                        <div class="gradient-banner mobile">
                            <div class="banner-topic">{{$sub_first->sub_category_name}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                
                <div class="row">
                    <div class="col-sm-3 d-none d-lg-block">
                        @include('inc_product_search')
                    </div>
                <!---------- PRODUCT - PART ---------->
                    <div class="col-sm-9">
                        <div class="mb-2">
                            <input type="radio" name="series" id="seriesAll" onchange="findSeries('')" @if (@$_GET['series_id'] == '') checked @endif> <label class="mr-4" for="seriesAll">All</label>
                            @foreach ($series as $item)
                                @php
                                    $check = '';
                                    if($item->id == @$_GET['series_id']){
                                        $check = 'checked';
                                    }
                                @endphp
                                <label class="mr-4" for="series{{ $item->id }}"><input type="radio" name="series" id="series{{ $item->id }}" onchange="findSeries({{ $item->id }})" {{ $check }}> {{ $item->series_name }}({{ count($item->products) }})</label>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul class="product-page">
                                    @foreach ($product as $k => $pro)
                                    <li>
                                    <a class="productBox-BD" href="{{url('product/'.str_replace(['#','/'],'',$pro->product_name).'___'.$pro->id)}}">
                                    <div class="productBox">
                                        <div class="product-img category"><img src="{{URL::asset('upload/product/'.$pro->product_image)}}"></div>
                                        <ul class="productBox-name">
                                            <li>
                                                <p>{{$pro->product_name}}</p>
                                            </li>
                                            <li>{{$pro->product_code}}</li>
                                            @if($pro->product_price == 0.00 )
                                            <li><p class="price sale" style="color:#f32836;font-size: 13px;"><i>สอบถามราคาเพิ่มเติม</i></p></li>

                                             
                                            @else
                                            <li>฿ {{number_format($pro->product_price,2)}}</li>
                                            @endif

                                        </ul>
                                    </div>
                                </a>
                                       
                                    </li>
                                    @if(($k+1)%5 == 0)
                                        <div class="d-none d-lg-block clearfix">
                                            
                                        </div>
                                    @endif
                                    @if(($k+1)%2 == 0)
                                        <div class="d-sm-none d-block clearfix">
                                            
                                        </div>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--------------- P A G E --------------->
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
    
    @include('inc_topbutton')
    @include('inc_footer')
    
</body>
</html>