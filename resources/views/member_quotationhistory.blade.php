<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    @php
        $memberName = "q-history"
    @endphp
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
                                    <h3>ประวัติการขอใบเสนอราคา</h3>
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
                                        <a type="button"><i class="fas fa-search"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="orderHistory-TBheader mobile-none">
                            <div class="row">
                                <div class="col-3">เลขที่ใบเสนอราคา</div>
                                <div class="col-2">วันที่</div>
                                <div class="col-2">จำนวนรายการ</div>
                                <div class="col-2">ยอดรวม</div>
                                <div class="col-3"></div>
                            </div>
                        </div>
                        <div class="orderHistory-TBbody">
                            @foreach ($quotation as $item)
                            <div class="row">
                                <!-- ORDER ID -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">เลขที่ใบเสนอราคา</div>
                                <div class="col-lg-3 col-7">{{$item->number}}</div>

                                <!-- ORDER DATE -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">วันที่</div>
                                <div class="col-lg-2 col-7">{{date('d/m/Y',strtotime($item->created_at))}}</div>

                                <!-- AMOUNT -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">จำนวนรายการ</div>
                                <div class="col-lg-2 col-7">{{$item->quotation_details->sum->qty}}</div>

                                <!-- TOTAL -->
                                <div class="col-5 d-sm-block d-md-block d-lg-none">ยอดรวม</div>
                                <div class="col-lg-2 col-7">฿ {{number_format($item->quotation_details->sum->product_curent_total_price)}}</div>

                                <div class="col-lg-3 col-12">
                                    <a class="buttonBD" href="/quotation/quotationHistory/{{$item->id}}"><i class="far fa-file-alt"></i>ดูรายละเอียด</a>
                                </div>
                            </div>
                            @endforeach
                            
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