<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>    
    @include('inc_header')
    <!-- FANCYBOX -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
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
                            <li>เกี่ยวกับเรา</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                @include('inc_about_submenu')
                
                <div id="cerPage"></div>
               
                <!---------- C E R T I F I C A T E ---------->
                <div class="row" id="aboutus">
                    <div class="col">
                        <h2 class="text-center mt-3 mb-5">ใบรับรองคุณภาพบริษัท</h2>
                    </div>
                </div>
                
                <div class="certificate-section">
                    <div class="row">
                        <div class="col">
                            <div class="box-Mpadding">
                            
                      
                              
                                <div class="row">
                                @foreach ($certificate as $item)   
                               
                            
                                       
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <a class="clientBox" data-fancybox="gallery" href="{{URL::asset('upload/about/certificate/'.$item->about_certificate_image)}}">
                                                <div class="img-width"><img src="{{URL::asset('upload/about/certificate/'.$item->about_certificate_image)}}"></div>
                                                <p>{{$item->about_certificate_name}}</p>
                                            </a>
                                        </div>
                                      
                                   
                                @endforeach
                                </div>
                               
                            </div>
                                
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
    
</body>
</html>