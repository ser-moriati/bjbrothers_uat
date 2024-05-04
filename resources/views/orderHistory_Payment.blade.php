<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    @php
        $memberName = "orderHistory_Payment"
    @endphp
</head>
<body>
    <div class="thetop"></div>
    @include('inc_topmenu')
    
    <!--------------- N A V - B A R --------------->
    <div class="navBK mobile-none">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb">
                            <li><a href="/">หน้าแรก</a></li>
                            <li>บัญชีของฉัน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- M E M B E R :: O R D E R - H I S T O R Y ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    
                    @include('inc_membermenu')
                    
                    <div class="col-lg-9 col-12">
                        <div class="row">
                            <div class="col">
                                <div class="member-topic">
                                    <h3>ประวัติการสั่งซื้อ</h3>
                                </div> 
                            </div>
                        </div>
                        <!-- SEARCH BOX -->
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12 offset-lg-3 offset-md-3">
                                    <div class="input-form">
                                        <div class="searchBox">
                                            <input type="search shadow-none" name="search" placeholder="search" value="{{@$query['search']}}">
                                            <a type="submit"><i class="fas fa-search"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="orderHistory-TBheader mobile-none">
                            <div class="row">
                                <div class="col-2">หมายเลขรายการสั่งซื้อ</div>
                                <div class="col-2">วันที่</div>
                                <div class="col-2">สถานะ</div>
                                <div class="col-2">จำนวนรายการ</div>
                                <div class="col-2">ยอดรวม</div>
                                <div class="col-2"></div>
                            </div>
                        </div>
                        <div class="orderHistory-TBbody">
                            @foreach ($order as $item)
                            <div class="row">
                                <!-- ORDER ID -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">หมายเลขรายการสั่งซื้อ</div>
                                <div class="col-lg-2 col-7">{{$item->order_number}}</div>

                                <!-- ORDER DATE -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">วันที่</div>
                                <div class="col-lg-2 col-7">{{date('d/m/Y',strtotime($item->created_at))}}</div>

                                <div class="col-5 d-sm-block d-md-block d-lg-none">สถานะ</div>
                                <div class="col-lg-2 col-7"><center>{{$item->status_name}}</center></div>
                                <!-- AMOUNT -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">จำนวนรายการ</div>
                                <div class="col-lg-2 col-7">{{$item->order_products->sum->qty}}</div>

                                <!-- TOTAL -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">ยอดรวม</div>
                                <div class="col-lg-2 col-7">฿{{ number_format($item->order_products->sum('order_total') + $item->shipping_cost + $item->vat) }}</div>

                                <div class="col-lg-2 col-12">
                                    <a class="buttonBD" href="/order/confirmPayment/{{$item->order_number}}"><i class="far fa-file-alt"></i>จ่ายเงิน</a>
                                </div>
                            </div>
                            @endforeach
                            
                            {{-- <div class="row">
                                <!-- ORDER ID -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">หมายเลขรายการสั่งซื้อ</div>
                                <div class="col-lg-3 col-7">BJ0000065</div>

                                <!-- ORDER DATE -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">วันที่</div>
                                <div class="col-lg-2 col-7">2020-06-15</div>

                                <!-- AMOUNT -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">จำนวนรายการ</div>
                                <div class="col-lg-2 col-7">2</div>

                                <!-- TOTAL -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">ยอดรวม</div>
                                <div class="col-lg-2 col-7">฿ 17,500</div>

                                <div class="col-lg-3 col-12">
                                    <a class="buttonBD" href="member_orderhistory_detail.php"><i class="far fa-file-alt"></i>ดูรายละเอียด</a>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- ORDER ID -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">หมายเลขรายการสั่งซื้อ</div>
                                <div class="col-lg-3 col-7">BJ0000044</div>

                                <!-- ORDER DATE -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">วันที่</div>
                                <div class="col-lg-2 col-7">2020-06-15</div>

                                <!-- AMOUNT -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">จำนวนรายการ</div>
                                <div class="col-lg-2 col-7">2</div>

                                <!-- TOTAL -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">ยอดรวม</div>
                                <div class="col-lg-2 col-7">฿ 17,500</div>

                                <div class="col-lg-3 col-12">
                                    <a class="buttonBD" href="member_orderhistory_detail.php"><i class="far fa-file-alt"></i>ดูรายละเอียด</a>
                                </div>
                            </div>
                            
                            <div class="row">
                                <!-- ORDER ID -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">หมายเลขรายการสั่งซื้อ</div>
                                <div class="col-lg-3 col-7">BJ0000012</div>

                                <!-- ORDER DATE -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">วันที่</div>
                                <div class="col-lg-2 col-7">2020-06-15</div>

                                <!-- AMOUNT -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">จำนวนรายการ</div>
                                <div class="col-lg-2 col-7">2</div>

                                <!-- TOTAL -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">ยอดรวม</div>
                                <div class="col-lg-2 col-7">฿ 17,500</div>

                                <div class="col-lg-3 col-12">
                                    <a class="buttonBD" href="member_orderhistory_detail.php"><i class="far fa-file-alt"></i>ดูรายละเอียด</a>
                                </div>
                            </div> --}}

                            
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