<div class="col-lg-3 col-12">
    <div class="row">
        <div class="col-lg-12 col-md-10 col-9">
            <div class="member-name mb-4">
                <h4>{{Auth::guard('member')->user()->member_firstname}}</h4>
                @php
                 $category_name = DB::table('member_categorys')->select('category_name')->where('id',Auth::guard('member')->user()->ref_member_category_id)->first()->category_name;  
                @endphp
                <div class="member-class">{{$category_name}}</div>
            </div>
        </div>
        
        <div class="col-md-2 col-3 mobile">
            <button type="button" class="btn btn-demo member-menu-s shadow-none" data-toggle="modal" data-target="#memberMenu">
                <span>MENU</span>
                <i class="fas fa-ellipsis-v"></i>
            </button>
            
            <!-- Modal -->
            <div class="modal left fade" id="memberMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">

                    <div class="modal-header">
                        <button type="button" class="close shadow-none" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <div class="modal-content">

                        <!-- MAINMENU -->
                        <div class="modal-body">
                            <div id="menu">
                                <div class="menu-box">
                                    <div class="menu-wrapper-inner">
                                        <div class="menu-wrapper">
                                            <div class="menu-slider">
                                                <div class="menu">
                                                    <ul>
                                                        <li>
                                                            <div class="menu-item">
                                                                <a href="/account">
                                                                    <i class="fas fa-user"></i>ข้อมูลสมาชิก & ที่อยู่จัดส่ง
                                                                </a>
                                                            </div>
                                                        </li>
                                                        {{-- <li>
                                                            <div class="menu-item">
                                                                <a href="/address">
                                                                    <i class="fas fa-map-marker-alt"></i>ที่อยู่จัดส่งและออกใบเสร็จรับเงิน
                                                                </a>
                                                            </div>
                                                        </li> --}}
                                                        <li>
                                                            <div class="menu-item">
                                                                <a href="/password">
                                                                    <i class="fas fa-unlock"></i>เปลี่ยนรหัสผ่าน
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="menu-item">
                                                                <a href="/cart">
                                                                    <img src="/images/icon/icon-cart.svg">ตะกร้าสินค้า
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="menu-item">
                                                                <a href="/order/orderHistory_Payment">
                                                                    <i class="fas fa-bullhorn"></i>ยืนยันการชำระเงิน
                                                                </a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="menu-item">
                                                                <a href="/order/orderHistory">
                                                                    <i class="fas fa-history"></i>ประวัติการสั่งซื้อ
                                                                </a>
                                                            </div>
                                                        </li>
                                                        {{-- <li>
                                                            <div class="menu-item">
                                                                <a href="/quotation">
                                                                    <i class="fas fa-file-alt"></i>ขอใบเสนอราคา
                                                                </a>
                                                            </div>
                                                        </li> --}}
                                                        <li>
                                                            <div class="menu-item">
                                                                <a href="/quotation/quotationHistory">
                                                                    <i class="fas fa-copy"></i>ประวัติการขอใบเสนอราคา
                                                                </a>
                                                            </div>
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

    </div>
    
    <!-- MEMBER - MENU :: PC -->
    <div class="row mobile-none">
        <div class="col">
            <ul class="member-menu mobile-none">
                <li data-page="profile">
                    <a href="/account"><i class="fas fa-user"></i>ข้อมูลสมาชิก & ที่อยู่จัดส่ง</a>
                </li>
                {{-- <li data-page="address">
                    <a href="/address"><i class="fas fa-map-marker-alt"></i>ที่อยู่จัดส่ง<span>และออกใบเสร็จรับเงิน</span></a>
                </li> --}}
                <li data-page="password">
                    <a href="/password"><i class="fas fa-unlock"></i>เปลี่ยนรหัสผ่าน</a>
                </li>
                <li>
                    <a href="/cart"><img src="/images/icon/icon-cart.svg">ตะกร้าสินค้า</a>
                </li>
                <li  data-page="orderHistory_Payment">
                    <a href="/order/orderHistory_Payment"><i class="fas fa-bullhorn"></i>ยืนยันการชำระเงิน</a>
                </li>
                <li data-page="history">
                    <a href="/order/orderHistory"><i class="fas fa-history"></i>ประวัติการสั่งซื้อ</a>
                </li>
                {{-- <li>
                    <a href="/quotation"><i class="fas fa-file-alt"></i>ขอใบเสนอราคา</a>
                </li> --}}
                <li data-page="q-history">
                    <a href="/quotation/quotationHistory"><i class="fas fa-copy"></i>ประวัติการขอใบเสนอราคา</a>
                </li>
               
                <li>
                    <a href="/logout"><i class="fas fa-sign-out-alt"></i>ออกจากระบบ</a>
                </li>
            </ul>
            
        </div>
    </div>
    
</div>

<script type="text/javascript">
    // ACTIVE MENU //
    $(function () {
		var getPage = '{{$memberName}}';
		$(".member-menu li").each(function () {
			var getMenu = $(this).attr("data-page");
			if (getPage == getMenu) {
				$(this).addClass('active');
			}
		});
	});
</script>