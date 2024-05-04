@php
    $category_menu = DB::table('categorys')->orderBy('sort','ASC')->get();
@endphp
<div class="header mobile-none">
    <div class="container-fluid">
        <div class="wrap-pad">
            <div class="row">
                <div class="col-lg-2 col-2 flexboxmenu">
                    <!-- MAIN LOGO -->
                    <a class="mainlogo change" href="/">
                        <img src="{{url('images/LOGO-BJ.png')}}">
                    </a>
                </div>
                <div class="col-lg-10 col-10 posstatic">
                    <div class="row">
                        <div class="col">
                            <!-- LOGIN MENU :: MEMBER MENU -->
                            <!--<ul class="login-menu">
                                <li><a href="login"><i class="fas fa-user"></i>เข้าสู่ระบบ</a></li>
                                <li><a href="register">ลงทะเบียน</a></li>
                            </ul>-->
                            <!-- CART MENU -->
                            <ul class="top-menu" style="width: 100%; text-align: right;">
                                
                                @php
                                 $countCart = DB::table('carts')->where('ref_member_id',@Auth::guard('member')->user()->id)->count();   
                                @endphp
                                @php
                                $countQuotationCart = 0;
                                if(@Auth::guard('member')->user()->id){
                                    $countQuotationCartt = 0;
                                    if(Session::get('quotation_cart')){
                                        $countQuotationCartt = count(Session::get('quotation_cart'));
                                    }
                                      
                                    
                                   
                                    $countQuotationCarta = DB::table('quotation_carts')->where('ref_member_id',@Auth::guard('member')->user()->id)->count();
                                    $countQuotationCart = $countQuotationCartt + $countQuotationCarta;
                                }else{
                                    if(@Session::get('quotation_cart')){
                                        $countQuotationCart = count(Session::get('quotation_cart'));
                                    }
                                }
                                @endphp
                                @if(@Auth::guard('member')->user()->id)
                                <li style="float: right;">
                                    <a class="cart" href="{{url('/cart')}}">
                                        <img src="{{url('images/icon/icon-cart.svg')}}">
                                        <div class="cart-amount cartAll">{{@$countCart}}</div>
                                    </a>
                                </li>
                                    @else
                                    <li style="float: right;">
                                    <a class="cart" href="{{url('/cart')}}">
                                        <img src="{{url('images/icon/icon-cart.svg')}}">
                                        <div class="cart-amount cartAll">{{@$countQuotationCart}}</div>
                                    </a>
                                </li>
                                    @endif
                          
                                <!-- <li style="float: right;">
                                    @if(@Auth::guard('member')->user()->id)
                                        <a class="cart quotation" href="/quotation">
                                    @else
                                    <a class="cart quotation" href="/quotation_cus">
                                    @endif
                                        <i class="fas fa-file-alt"></i>
                                        <div class="cart-amount quotationCartAll">{{@$countQuotationCart}}</div>
                                    </a>
                                </li> -->
                                
                                <!-- LOGIN & MEMBER เข้าสู่ระบบแล้ว -->
                                @if(@Auth::guard('member')->user()->member_firstname)
                                    @php $user_name = Auth::guard('member')->user()->member_firstname; @endphp
                                    <li style="float: right;">
                                        <a class="icon-txt" href="/account"><i class="fas fa-user"></i>@php echo substr($user_name,0,20); @endphp</a>
                                    </li>
                                @else
                                
                                <li style="float: right;">
                                    {{-- <a class="icon-txt" href="/login"><i class="fas fa-sign-in-alt"></i>เข้าสู่ระบบ</a> --}}
                                    <a class="icon-txt" href="/login"><i class="fas fa-user"></i>เข้าสู่ระบบ</a>
                                </li>
                                @endif
                                
                                <!-- FOR LOGIN / REGISTER :: ก่อนเข้าสู่ระบบ -->
                                {{-- <li>
                                    <a class="icon-txt" href="/login"><i class="fas fa-user"></i>เข้าสู่ระบบ</a>
                                </li> --}}

                                <li style="width: 77%; float: right;">
                                    <form action="/search">
                                        <div class="search-section">
                                            <div class="input-group search" style="width: 100% !important;float: right;">
                                                    <input type="search" name="s" class="form-control shadow-none" placeholder="search" value="{{@$search}}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn"><i class="fas fa-search"></i></button>
                                                    </div>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col posstatic">
                            <!-- MAIN MENU -->
                            <ul class="mainmenu">
                                <li><a href="{{url('/home')}}">HOME</a></li>
                                <li><a href="{{url('/about')}}">ABOUT US</a></li>
                                {{-- <li><a href="{{url('/newarrival')}}">NEW ARRIVAL</a></li> --}}
                                <li><a href="javascript: void(0);">PRODUCT<i class="fas fa-chevron-down"></i></a>
                                    <div class="dropdown-container">
                                        <ul class="submenudrop">
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="product-submenu">
                                                        @foreach ($category_menu as $cate_me)
                                                        <li>
                                                            <a href="{{url('category/'.$cate_me->category_name)}}">
                                                                <img src="{{URL::asset('upload/category/'.$cate_me->category_image)}}">
                                                                <div>{{$cate_me->category_name}}</div>
                                                                <div>&nbsp;</div>
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="{{url('/newarrival')}}">NEWS & PROMOTION</a></li>
                                <li><a href="{{url('/portfolio')}}">PORTFOLIO</a></li>
                                <li><a href="{{url('/safety')}}">KNOWLEDGES</a></li>
                                <li><a href="{{url('/contact')}}">CONTACT US</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            
                        </div>
                    </div>
                </div>
            </div>
         </div>
    </div>
</div>

<!-------------------- M E N U :: M O B I L E -------------------->
<div class="header-mobile mobile">
    <div class="container-fluid">
        <div class="row">
            <!---------- M A I N - M E N U ---------->
            <div class="col-5">
                <button type="button" class="btn btn-demo nav-menu shadow-none" data-toggle="modal" data-target="#myModal">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Modal -->
                <div class="modal left fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        
                        <div class="modal-header">
                            <button type="button" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="modal-content">
                            <!-- MOBILE :: LOGIN / REGISTER -->
                             <div class="user-header mobile">
                                @if(@Auth::guard('member')->user()->member_firstname)
                                    <p>HELLO, {{Auth::guard('member')->user()->member_firstname}}</p>
                                        {{-- <li> --}}
                                            {{-- <a class="icon-txt" href="/account"><i class="fas fa-user"></i>{{Auth::guard('member')->user()->member_firstname}}</a> --}}
                                        {{-- </li> --}}
                                @else
                                    <ul class="edit-opption">
                                        <li>
                                            <a href="{{url('/login')}}"><i class="fas fa-lock"></i>LOGIN</a>
                                        </li>
                                        {{-- <li><a class="icon-txt"  href="/register"><i class="fas fa-pencil-alt"></i>REGISTER</a></li> --}}
                                    </ul>
                                @endif
                            </div>
                            
                            <!-- MAINMENU -->
                            <div class="modal-body">
                                <div id="menu">
                                    <div class="menu-box">
                                        <div class="menu-wrapper-inner">
                                            <div class="menu-wrapper">
                                                <div class="menu-slider">
                                                    <div class="menu">
                                                        <ul>
                                                            @if(@Auth::guard('member')->user()->member_firstname)
                                                                <li>
                                                                    <div class="menu-item gray">
                                                                        <a href="" class="menu-anchor" data-menu="1"><i class="fas fa-user"></i>MY ACCOUNT</a>
                                                                        <img class="detail" src="{{url('images/icon/icon-chevronR-s.svg')}}">
                                                                    </div>
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/home')}}">HOME</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item">
                                                            
                                                                    <a href="javascript: void(0);" class="menu-anchor" data-menu="22">ABOUT US</a>
                                                                    <img class="detail" src="{{url('images/icon/icon-chevronR-s.svg')}}">
                                                                </div>
                                                            </li>
                                                            {{-- <li>
                                                                <div class="menu-item"><a href="/newarrival">NEW ARRIVAL</a></div>
                                                            </li> --}}
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="javascript: void(0);" class="menu-anchor" data-menu="2">PRODUCT</a>
                                                                    <img class="detail" src="{{url('images/icon/icon-chevronR-s.svg')}}">
                                                                </div>
                                                            </li>
                                                            <li>
                                                         
                                                                <div class="menu-item">
                                                                    <a href="" class="menu-anchor" data-menu="4">NEWS & PROMOTION</a>
                                                                    <img class="detail" src="{{url('images/icon/icon-chevronR-s.svg')}}">
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="javascript: void(0);" class="menu-anchor" data-menu="5">PORTFOLIO</a>
                                                                    <img class="detail" src="/images/icon/icon-chevronR-s.svg">
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="" class="menu-anchor" data-menu="6">KNOWLEDGE</a>
                                                                    <img class="detail" src="/images/icon/icon-chevronR-s.svg">
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="" class="menu-anchor" data-menu="7">CONTACT US</a>
                                                                    <img class="detail" src="{{url('images/icon/icon-chevronR-s.svg')}}">
                                                                </div>
                                                            </li>
                                                            {{-- <li>
                                                                <div class="menu-item"><a href="/logout">LOGOUT</a></div>
                                                            </li> --}}
                                                            <!--<li>
                                                                <div class="menu-item"><a href="confirm_payment">CONFIRM PAYMENT</a></div>
                                                            </li>-->
                                                        </ul>
                                                        
                                                        <!-- SEARCH -->
                                                        <div class="search-mobile">
                                                            <div class="input-group">
                                                                <form action="/search">
                                                                <button type="button" class="input-group-prepend btn">
                                                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                                                </button>
                                                                <input name="s" class="form-control shadow-none" type="search" placeholder="search" value="{{@$search}}">
                                                                </form>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- FOLLOW - US -->
                                                        <ul class="social">
                                                            <li><a href="https://www.facebook.com/bjbrothersrOfficial/" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                            <li><a href="https://www.youtube.com/user/bjbrothersson" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                                            <li>
                                                                <a class="Line" href="https://line.me/R/ti/p/%40moz3566f" target="_blank">
                                                                    <img src="/images/icon/icon-lineBK.svg">
                                                                    <img src="/images/icon/icon-lineWH.svg">
                                                                </a>
                                                            </li>
                                                            <li><a href="mailto:salecenter@bjbrothers.com"><i class="fas fa-envelope"></i></a></li>
                                                        </ul>
                                                        
                                                    </div>
                                                    <!-- SUB MENU :: ABOUT -->
                                                    <div class="submenu menu" data-menu="1">
                                                        <div class="submenu-back">
                                                            <div class="menu-item">
                                                                <a href="#" class="menu-back">BACK</a>
                                                                <img class="detail" src="{{url('images/icon/icon-chevronL-s.svg')}}">
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="{{url('/account')}}"><i class="fas fa-user"></i>ข้อมูลสมาชิก & ที่อยู่จัดส่ง</a>
                                                                </div>
                                                            </li>
                                                            {{-- <li>
                                                                <div class="menu-item">
                                                                    <a href="/address"><i class="fas fa-map-marker-alt"></i>ที่อยู่จัดส่งและออกใบเสร็จรับเงิน</a>
                                                                </div>
                                                            </li> --}}
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="{{url('/password')}}"><i class="fas fa-unlock"></i>เปลี่ยนรหัสผ่าน</a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="{{url('/cart')}}"><img src="{{url('images/icon/icon-cart.svg')}}">ตะกร้าสินค้า</a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="{{url('/order/orderHistory')}}"><i class="fas fa-history"></i>ประวัติการสั่งซื้อ</a>
                                                                </div>
                                                            </li>
                                                            {{-- <li>
                                                                <div class="menu-item">
                                                                    <a href="/quotation"><i class="fas fa-file-alt"></i>ขอใบเสนอราคา</a>
                                                                </div>
                                                            </li> --}}
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="{{url('/quotation/quotationHistory')}}"><i class="fas fa-copy"></i>ประวัติการขอใบเสนอราคา</a>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item">
                                                                    <a href="{{url('/order/orderHistory_Payment')}}"><i class="fas fa-bullhorn"></i>ยืนยันการชำระเงิน</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="submenu menu" data-menu="22">
                                                        <div class="submenu-back">
                                                            <div class="menu-item">
                                                                <a href="#" class="menu-back">BACK</a>
                                                                <img class="detail" src="{{url('images/icon/icon-chevronL-s.svg')}}">
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/about')}}">เกี่ยวกับเรา</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/about/service#servicePage')}}">บริการของเรา</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/about/certificate#cerPage')}}">ใบรับรองคุณภาพบริษัท</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/about/holiday#holidayPage')}}">วันหยุดประจำปี</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/contact/map#mapPage')}}">แผนที่บริษัท</a></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <!-- SUB MENU :: PRODUCT -->
                                                    <div class="submenu menu" data-menu="2">
                                                        <div class="submenu-back">
                                                            <div class="menu-item">
                                                                <a href="#" class="menu-back">BACK</a>
                                                                <img class="detail" src="{{url('images/icon/icon-chevronL-s.svg')}}">
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            @php
                                                            $cateLeftMenu = DB::table('categorys')->orderBy('sort')->get();                                                                
                                                            @endphp
                                                        @foreach ($cateLeftMenu as $cate)
                                                            <li>
                                                                <div class="menu-item">
                                                                    {{-- <a href="{{url('category/'.$cate->category_name)}}"> --}}
                                                                    <a href="javascript:void(0);" onclick="get_sub_category({{ $cate->id }})">
                                                                        {{$cate->category_name}} 
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                        </ul>
                                                    </div>
                                                    <!-- SUB MENU :: CONTACT -->
                                                    
                                                    <!-- SUB MENU :: NEWS & PROMOTION -->
                                                    <div class="submenu menu" data-menu="4">
                                                        <div class="submenu-back">
                                                            <div class="menu-item">
                                                                <a href="#" class="menu-back">BACK</a>
                                                                <img class="detail" src="/images/icon/icon-chevronL-s.svg">
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/newarrival')}}">New Arrival</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/promotion')}}">Promotion</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/news')}}">News & Event</a></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    
                                                    <!-- SUB MENU :: PORTFOLIO -->
                                                    <div class="submenu menu" data-menu="5">
                                                        <div class="submenu-back">
                                                            <div class="menu-item">
                                                                <a href="#" class="menu-back">BACK</a>
                                                                <img class="detail" src="/images/icon/icon-chevronL-s.svg">
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/portfolio')}}">ผลงานของเรา</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/project')}}">โครงการต่างๆ</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/about/customer')}}">ลูกค้าของเรา</a></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    
                                                    <!-- SUB MENU :: KNOWLEDGE -->
                                                    <div class="submenu menu" data-menu="6">
                                                        <div class="submenu-back">
                                                            <div class="menu-item">
                                                                <a href="#" class="menu-back">BACK</a>
                                                                <img class="detail" src="/images/icon/icon-chevronL-s.svg">
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/safety')}}">Safety Tips</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/technical')}}">Technical Tips</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/maintenance')}}">Maintenance Tips</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="{{url('/install')}}">Installation Tips</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="https://www.bjbrothers.com/ecatalogue#cataloguePage">E-Catalogue</a></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    
                                                    <!-- SUB MENU :: CONTACT -->
                                                    <div class="submenu menu" data-menu="7">
                                                        <div class="submenu-back">
                                                            <div class="menu-item">
                                                                <a href="#" class="menu-back">BACK</a>
                                                                <img class="detail" src="/images/icon/icon-chevronL-s.svg">
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div class="menu-item"><a href="https://www.bjbrothers.com/contact#contactPage">ข้อมูลติดต่อเรา</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="https://www.bjbrothers.com/contact/map#mapPage">แผนที่บริษัท</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="https://www.bjbrothers.com/contact/career#careerPage">สมัครงาน</a></div>
                                                            </li>
                                                            <li>
                                                                <div class="menu-item"><a href="https://www.bjbrothers.com/contact/dealer#dealPage">สมัครเป็น Dealer</a></div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- modal-content -->
                    </div><!-- modal-dialog -->
                </div><!-- modal -->
                
            </div>
            <!---------- M A I N - L O G O ---------->
            <div class="col-2 px-0">
                <a class="mainlogo" href="/"><img src="{{url('images/LOGO-BJ.png')}}"></a>
            </div>
            
            <div class="col-5 pl-0">
                <ul class="top-menu">
                     <!-- <li>
                        <a class="cart quotation" href="/quotation">
                            <i class="fas fa-file-alt"></i>
                            <div class="cart-amount">{{@$countQuotationCart}}</div>
                        </a>
                    </li>  -->
                    <li>
                        <a class="cart" href="{{url('/cart')}}/cart">
                            <img src="{{url('images/icon/icon-cart.svg')}}">
                            <div class="cart-amount">{{@$countCart}}</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal modal_subcategory" style="z-index: 9999999;" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content get_sub_category">
      </div>
    </div>
  </div>
<script type="text/javascript">
    var menu_width;
    jQuery(document).ready(
        function() {
            initMenu();
        });
    function initMenu() {
        menu_width = $("#menu .menu").width();
        $(".menu-back").click(function() {
            var _pos = $(".menu-slider").position().left + menu_width;
            var _obj = $(this).closest(".submenu");
            $(".menu-slider").stop().animate({
                left: _pos
            }, 300, function() {
                _obj.hide();
            });
            return false;
        });
        
        $(".menu-anchor").click(function() {
            var _d = $(this).data('menu');
            $(".submenu").each(function() {
                var _d_check = $(this).data('menu');
                if (_d_check == _d) {
                    $(this).show();
                    var _pos = $(".menu-slider").position().left - menu_width;
                    
                    $(".menu-slider").stop(true, true).animate({
                        left: _pos
                    }, 300);
                    return false;
                }
            });
            return false;
        });
    }
    
    $(document).ready(function() {

        $('.searchbtn').click(function(event) {
            if ($(".searchBox-mobile").is(":hidden")) {
                $(this).addClass("active");
                $(".searchBox-mobile").fadeIn();
            } else {
                //if (Modernizr.mq('(max-width: 991px)')) {
                $('.searchbox').fadeOut();
                $(this).removeClass("active");
                //}
            }
            event.stopPropagation();
        });

        $('.close_search').click(function(event) {
            $('.searchBox-mobile').fadeOut();
            $('.searchbtn').removeClass("active");
        });

        $('.wrap_search_form').click(function(event) {
            event.stopPropagation();
        });

        $(".searchBox-mobile").css('top', $('.topbar_menu').outerHeight());
    });

</script>


<script type="text/javascript">
    // HEADER //
    $(function(){
        var shrinkHeader = 180;
        $(window).scroll(function() {
            var scroll = getCurrentScroll();
            if ( scroll >= shrinkHeader ) {
                $('.header').addClass('shrink');
            }
            else {
                $('.header').removeClass('shrink');
            }
        });
        function getCurrentScroll() {
            return window.pageYOffset || document.documentElement.scrollTop;
        }
    });
    
</script>

<script>
                                                        
    function get_sub_category(id) {
        $.ajax({
            type: "GET",
            url: "/subcategory/get_by_cate/"+id,
            success: function( result ) {
                $('.get_sub_category').html(result)
                $('.modal_subcategory').modal('show')
            },error : function(e){
                console.log(e)
            }
        });

    }
</script>
<script>
function onClick(e) {
  e.preventDefault();
  grecaptcha.enterprise.ready(async () => {
    const token = await grecaptcha.enterprise.execute('6LcZ7VsoAAAAAFg3m_Oo0RjW5AiWrr0CEW4Mf-ug', {action: 'LOGIN'});
    // IMPORTANT: The 'token' that results from execute is an encrypted response sent by
    // reCAPTCHA Enterprise to the end user's browser.
    // This token must be validated by creating an assessment.
    // See https://cloud.google.com/recaptcha-enterprise/docs/create-assessment
  });
}
</script>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5L33NLC9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->