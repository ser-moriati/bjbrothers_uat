<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @php
        $newsName="promotion";
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
                            <li>ข่าวสารและโปรโมชั่น</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- P R O M O T I O N ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                @include('inc_news_submenu')
                
                <div id="promotionPage"></div>
                
                <div class="row">
                    <div class="col">
                        <h1 class="EngSM text-center mb-4">PROMOTION</h1>
                    </div>
                </div>
                
                <div class="news-bigBox mb-5">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="img-width">
                                <img src="{{URL::asset('upload/promotion/'.$promotion_pin->title_image)}}">
                                
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="row">
                                <div class="col">
                                    <div class="BK-topic">
                                        <p>{{$promotion_pin->title}} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="new-bigBox-caption">
                                        <div class="row">
                                            <div class="col">
                                                <div class="dateBox">{{strtoupper(date("j M Y", strtotime($promotion_pin->created_at)))}}</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="txt-content">
                                                    <p>{!! str_replace('<h6>','<div style="display: flex;">',iconv_substr($promotion_pin->detail, 0, 350, "UTF-8")) !!}...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                </div>
                            </div>
                            <a class="buttonBK" href="{{url('promotion/'.$promotion_pin->id)}}">อ่านต่อ</a>              
                        </div>
                    </div>
                </div>
                
                <div class="w-100 mb-5">
                    <div class="row">
                        <div class="col">
                            <div class="lineDecor-center"></div>
                        </div>
                    </div>
                </div>
                    
                
                <div class="box-padding my-3">
                    <div class="row">
                        @foreach ($promotion as $prom)                            
                        <div class="col-lg-4 col-md-4 col-12">
                            <div class="projectBox">
                                <a href="{{url('promotion/'.$prom->id)}}"><img src="{{URL::asset('upload/promotion/'.$prom->title_image)}}"></a>
                                <a class="project-topic" href="{{url('promotion/'.$prom->id)}}">
                                    <p>{{$prom->title}}</p>
                                </a>
                                <div class="dateBox">{{strtoupper(date("j M Y", strtotime($prom->created_at)))}}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!--------------- P A G E --------------->
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{  $promotion->links() }}
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