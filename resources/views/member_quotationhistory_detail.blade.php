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
    
    <!---------- M E M B E R :: Q U O T A T I O N - H I S T O R Y - D E T A I L ---------->
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
                        <!--------------- QUOTATION INFO --------------->
                        <div class="grayBD mb-5">
                            <div class="row">
                                <div class="col">
                                    <div class="summary-header" id="history">
                                        <h3><span>เลขที่ใบเสนอราคา</span>{{$quotation->number}}</h3>
                                        <h6>{{count($quotation->quotation_details)}} รายการ</h6>
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="cartPage-header" id="quotation">
                                <div class="mobile-none">
                                    <div class="row">
                                        <div class="col-1 list">ลำดับ</div>
                                        <div class="col-3">รายการสินค้า</div>
                                        <div class="col-2">จำนวน</div>
                                        <div class="col-2">ราคา</div>
                                        <div class="col-2">ราคารวม</div>
                                        <div class="col-2">หมายเหตุ</div>
                                    </div>
                                </div>
                                <div class="mobile">
                                    <div class="row">
                                        <div class="col-4 col-md-3">PRODUCT</div>
                                        <div class="col-8 col-md-9">DETAIL</div>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-body quotation q-detail">
                                <div class="order-product">
                                    <!----- PRODUCT 01 ----->
                                    @foreach ($quotation->quotation_details as $k => $item)
                                    <div class="cartPage-product">
                                        <div class="row">
                                            <!-- ORDER -->
                                            <div class="col-lg-1 col-md-1 col-1 list">{{$k+1}}</div>

                                            <!-- IMAGE -->
                                            <div class="col-lg-1 col-md-3 col-4 img">
                                                <div class="img-width"><img src="{{URL::asset('upload/product/'.$item->product->product_image)}}"></div>
                                            </div>

                                            <!-- PRODUCT INFO -->
                                            <div class="col-lg-2 col-md-3 col-6">
                                                <div class="productCart-info">
                                                    <ul>
                                                        <li>SKU : @php $productcode = DB::table('productsku')->where('id',$item->product_SKU_id)->first(); @endphp {{@$productcode->product_SKU}}</li>
                                                        <li>{{$item->product->product_name}}</li>
                                                        <li>Color :@php $color = DB::table('productsoption1')->where('id',$item->ref_color_id)->first(); @endphp {{@$color->name_th}}</li>
                                                        <li>Size :@php $size = DB::table('productsoption2')->where('id',$item->ref_color_id)->first(); @endphp {{@$size->name_th}}</li>

                                                        
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-5 col-12 mobile">
                                                <div class="quotationCart-detail">
                                                    <div class="row">
                                                        <div class="col-4">จำนวน</div>
                                                        <div class="col-8">{{$item->qty}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">ราคา</div>
                                                        <div class="col-8">
                                                            <div class="float-right">{{number_format($item->product_curent_price)}}</div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">ราคารวม</div>
                                                        <div class="col-8">{{number_format($item->product_curent_total_price)}}</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">หมายเหตุ</div>
                                                        <div class="col-12">-</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- AMOUNT -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">{{$item->qty}}</div>

                                            <!-- PRICE -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">{{number_format($item->product_curent_price)}}</div>

                                            <!-- TOTAL PRICE -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">{{number_format($item->product_curent_total_price)}}</div>

                                            <!-- NOTE -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">-</div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <!----- PRODUCT 02 ----->
                                    {{-- <div class="cartPage-product">
                                        <div class="row">
                                            <!-- ORDER -->
                                            <div class="col-lg-1 col-md-1 col-1 list">2</div>

                                            <!-- IMAGE -->
                                            <div class="col-lg-1 col-md-3 col-4 img">
                                                <div class="img-width"><img src="images/product/product04.jpg"></div>
                                            </div>

                                            <!-- PRODUCT INFO -->
                                            <div class="col-lg-2 col-md-3 col-6">
                                                <div class="productCart-info">
                                                    <ul>
                                                        <li>XX00000</li>
                                                        <li>Safety Bollards</li>
                                                        <li>Color : สีเหลือง</li>
                                                        <li>Size : xxxxx</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-12 mobile">
                                                <div class="quotationCart-detail">
                                                    <div class="row">
                                                        <div class="col-4">จำนวน</div>
                                                        <div class="col-8">5</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">ราคา</div>
                                                        <div class="col-8">
                                                            <div class="float-right">
                                                                <div class="price full-price">2,000</div>
                                                                <div class="price sale">1,500</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">ราคารวม</div>
                                                        <div class="col-8">7,500</div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-4">หมายเหตุ</div>
                                                        <div class="col-12">สเกตช์มั้ง เฉิ่มโยเกิร์ตแอพพริคอทคาแร็คเตอร์ สามแยกออร์แกนิคซาร์แชเชือนเนิร์สเซอรี แทกติค เลดี้กุมภาพันธ์ บูติก ดีเจแฮนด์</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- AMOUNT -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">5</div>

                                            <!-- PRICE -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">
                                                <div class="price full-price">2,000</div>
                                                <div class="price sale">1,500</div>
                                            </div>

                                            <!-- TOTAL PRICE -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">7,500</div>

                                            <!-- NOTE -->
                                            <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">-</div>
                                        </div>
                                    </div>
                                     --}}
                                </div>

                                <div class="quotation-note">
                                    <div class="row mb-4">
                                        <div class="col-12"><b>หมายเหตุ</b></div>
                                        <div class="col-12" style="padding-left: 40px;">
                                            <p>{{ $quotation->remark }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12"><b>ที่อยู่ในการจัดส่งสินค้า</b></div>
                                        <div class="col-lg-12" style="padding-left: 40px;">
                                            <p>{{$quotation->ship_first_name}} {{$quotation->ship_last_name}}</p>
                                            <p>(Tel. {{$quotation->ship_phone}}) {{$quotation->ship_address}} {{$quotation->ship_district_name}} {{$quotation->ship_amphure_name}} {{$quotation->ship_province_name}}  {{$quotation->ship_zipcode}}</p>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="w-100">
                                    <div class="row">
                                        <div class="col">
                                            <div class="summary-order-total">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <!-- <td>ราคารวม</td>
                                                            <td>฿ {{number_format($quotation->price_total)}}</td> -->
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>  
                                </div>

                            </div>
                        </div>
                        
                        <div class="doubleBD">
                            <div class="row">
                                <div class="col">
                                    <div class="content-center">
                                        <a class="buttonBK" href="/quotation/quotationHistory">ย้อนกลับ</a>
                                    </div>
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