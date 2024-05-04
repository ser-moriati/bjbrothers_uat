<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @php
        $portName="client";
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
                            <li>ผลงานของเรา</li>
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
                @include('inc_port_submenu')
               
                <div id="clientPage"></div>
                
                <!---------- M E N U - T A B ---------->
                <div class="row">
                    <div class="col">
                        <h2 class="text-center mt-3 mb-4">ลูกค้าของเรา</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <ul class="menu-tab mt-2 mb-5" id="client">
                            @foreach ($about_category_customer as $k => $acc)
                            <li class="@if ($k==0) active @endif"><a>{{$acc->about_category_customer_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <ul class="tab-detail">
                            <!-- Department Store -->
                            @foreach ($about_category_customer as $acc)
                                <li>
                                    <div class="box-Mpadding">
                                        <div class="row">
                                            @if (@$about_customer[$acc['id']])                                                
                                            @foreach ($about_customer[$acc['id']] as $customer)
                                                <div class="col-lg-3 col-md-4 col-6">
                                                    <div class="clientBox">
                                                        <div class="img-width"><img src="{{URL::asset('upload/about/aboutcustomer/'.$customer->about_customer_image)}}"></div>
                                                        <p>{{$customer->about_customer_name}}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                            
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    
    <script type="text/javascript">
        // MENU-TAB //
        $(function(){  
            $("ul.menu-tab > li").click(function(event){ 
                var getActive = $(this);
                var menuIndex=$(this).index();  
                if($(this).hasClass("active") == false){
                    $("ul.menu-tab").find("li.active").removeClass("active");
                    $("ul.tab-detail > li:visible").hide();             
                    $("ul.tab-detail > li").eq(menuIndex).show();  
                    $(this).addClass("active");
                }
            }); 
        }); 
    </script>
    
</body>
</html>