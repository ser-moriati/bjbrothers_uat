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
                            <li>{{$category->category_name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- P R O D U C T - C A T E G O R Y :: B A N N E R --------------->
    <div class="banner-GrayBG">
        <div class="container-fluid">
            <!-- FOR PC -->
            <div class="banner-pc">
                <div class="row">
                    <div class="col-4 offset-1 mobile-none">
                        <div class="banner-txt">
                        <div class="banner-topic">{{$category->category_name}}</div>
                            <div class="txt-content">
                                <p>{{$category->category_detail}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="img-width">
                            <img src="{{URL::asset('upload/category/'.$category->banner_image)}}">
                            <!-- FOR MOBILE -->
                            <div class="gradient-banner mobile">
                                <div class="banner-topic">{{$category->category_name}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FOR MOBILE -->
            <div class="banner-mobile">
                <div class="row">
                    <div class="col-5 mobile-none">
                        <div class="banner-txt">
                            <div class="banner-topic">{{$category->category_name}}</div>
                            <div class="txt-content">
                                <p>{{$category->category_detail}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="img-width" id="banner">
                            <img src="{{URL::asset('upload/category/'.$category->banner_image)}}">
                            <!-- FOR MOBILE -->
                            <div class="gradient-banner mobile">
                                <div class="banner-topic">{{$category->category_name}}</div>
                            </div>
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
                    <div class="col-sm-3 d-md-block">
                        @include('inc_product_search')
                    </div>
                    
                    <div class="col-sm-9">
                        <!---------- PRODUCT - PART ---------->
                        
                        {{-- @if (@$series) --}}
                        {{-- @endif --}}
                        <div class="row">
                            <div class="col">
                                <ul class="product-page sub-category">
                                    @foreach ($sub_category_by_cate as $k => $sub)
                                    @php
                                        if($sub->ref_category_id != $cate_id){
                                            continue;
                                        }
                                    @endphp
                                    <li>
                                    <a class="productBox-BD" href="{{url('subcategory/'.$sub->sub_category_name)}}">
                                        <div class="productBox">
                                            <div class="product-img category"><img src="{{URL::asset('upload/sub_category/'.$sub->sub_category_image)}}"></div>
                                            <ul class="productBox-name">
                                                <li>
                                                    <p>{{$sub->sub_category_name}}</p>
                                                </li>
                                                <li>{{$sub->sub_category_code}}</li>
                                            </ul>
                                        </div>
                                    </a>
                                       
                                    </li>
                                    @if(($k+1)%5 == 0)
                                        <div class="clearfix">
                                        </div>
                                    @endif
                                    @endforeach
                                    
                                </ul>
                            </div>
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