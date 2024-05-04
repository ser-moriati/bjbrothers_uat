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
                            <li>บัญชีของฉัน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- M E M B E R :: A D D R E S S ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    
                    @include('inc_membermenu')
                    
                    <div class="col-lg-9 col-12">
                        <div class="row">
                            <div class="col">
                                <div class="member-topic">
                                    <h3>ที่อยู่จัดส่งและออกใบเสร็จรับเงิน</h3>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="row">
                            <!---------- M E M B E R :: A D D R E S S ---------->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="gray-header decor-none">
                                            <div class="gray-header-topic">ที่อยู่จัดส่งสินค้า</div>
                                        </div> 
                                    </div>
                                    <div class="col">
                                        <a class="button-txt w-header" href="#"><i class="fas fa-plus-circle"></i>เพิ่มที่อยู่ใหม่</a>
                                    </div>
                                </div>
                                
                                <div class="member-address">
                                    <!-- ADDRESS :: 01 -->
                                    @foreach ($shipping_address as $k => $item)
                                        <div class="infoBox @if($k==0) default @endif ">
                                            <div class="order-info">
                                                <div class="add-head">
                                                    <div class="row">
                                                        <div class="col">@if($k==0) ที่อยู่เริ่มต้น @else ที่อยู่ {{$k+2}} @endif</div>
                                                        @if($k>0)
                                                        <div class="col">
                                                            <button type="button" class="button-txt btn">ตั้งเป็นที่อยู่เริ่มต้น</button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <ul class="add-info">
                                                            <li>อารีย์ จรัสสกุล</li>
                                                            {{-- <li>(Tel. 081-234-5678)</li> --}}
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">{{ $item->addr.' '.$item->district_name.' '.$item->amphure_name.' '.$item->province_name.' '.$item->zipcode }}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <ul class="edit-opption">
                                                            <li><a href="#"><i class="fas fa-pencil-alt"></i>แก้ไข</a></li>
                                                            <!--<li><a href="#"><i class="fas fa-trash-alt"></i>ลบ</a></li>-->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <!-- ADDRESS :: 02 -->
                                    {{-- <div class="infoBox">
                                        <div class="order-info">
                                            <div class="add-head">
                                                <div class="row">
                                                    <div class="col">ที่อยู่ 1</div>
                                                    <div class="col">
                                                        <button type="button" class="button-txt btn">ตั้งเป็นที่อยู่เริ่มต้น</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="add-info">
                                                        <li>อารีย์ จรัสสกุล</li>
                                                        <li>(Tel. 081-234-5678)</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">90/16 ถ.ศรีอยุธยา แขวงวชิรพยาบาล เขตดุสิต กรุงเทพมหานคร 10300</div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="edit-opption">
                                                        <li><a href="#"><i class="fas fa-pencil-alt"></i>แก้ไข</a></li>
                                                        <li><a href="#"><i class="fas fa-trash-alt"></i>ลบ</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                    
                            </div>
                            <!---------- M E M B E R :: B I L L I N G ---------->
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="row">
                                    <div class="col">
                                        <div class="gray-header decor-none">
                                            <div class="gray-header-topic">ที่อยู่ออกใบเสร็จ</div>
                                        </div> 
                                    </div>
                                </div>
                                
                                <div class="member-address">
                                    <!-- ADDRESS :: 01 -->
                                    @foreach ($shipping_address as $k => $item)
                                    <div class="infoBox default">
                                        <div class="order-info">
                                            <div class="add-head">
                                                <div class="row">
                                                    <div class="col">@if($k==0) ที่อยู่เริ่มต้น @else ที่อยู่ {{$k+2}} @endif</div>
                                                    @if($k>0)
                                                    <div class="col">
                                                        <button type="button" class="button-txt btn">ตั้งเป็นที่อยู่เริ่มต้น</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="add-info">
                                                        <li>บริษัท ออเร้นจ์ เทคโนโลยี โซลูชั่น จำกัด</li>
                                                        {{-- <li>(Tel. 081-234-5678)</li> --}}
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">{{ $item->addr.' '.$item->district_name.' '.$item->amphure_name.' '.$item->province_name.' '.$item->zipcode }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="edit-opption">
                                                        <li><a href="#"><i class="fas fa-pencil-alt"></i>แก้ไข</a></li>
                                                        <!--<li><a href="#"><i class="fas fa-trash-alt"></i>ลบ</a></li>-->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
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
    
</body>
</html>