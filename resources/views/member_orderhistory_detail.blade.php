<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    @php
        $memberName = "history"
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
    
    <!---------- M E M B E R :: O R D E R - H I S T O R Y - D E T A I L ---------->
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
                        <!--------------- ORDER INFO --------------->
                        <div class="row">
                            <div class="col">
                                <div class="summary-header" id="history">
                                    <h3><span>หมายเลขคำสั่งซื้อ</span>{{$order->order_number}}</h3>
                                </div> 
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <div class="infoBox">
                                    <div class="row">
                                        <div class="col">
                                            <h6>ข้อมูลการสั่งซื้อ</h6>
                                        </div>
                                    </div>
                                    <div class="order-info">
                                        <div class="row">
                                            <div class="col-lg-6 col-4">วันที่สั่งซื้อ</div>
                                            <div class="col-lg-6 col-8">{{$order->date}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">ผู้สั่งซื้อ</div>
                                            <div class="col-lg-6 col-8">{{$order->member_firstname}} {{$order->member_lastname}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">ชื่อบริษัท</div>
                                            <div class="col-lg-6 col-8">{{$order->company_name}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">วิธีการชำระเงิน</div>
                                            <div class="col-lg-6 col-8">โอนผ่านธนาคาร</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">ขนส่ง</div>
                                            <div class="col-lg-6 col-8">{{$order->Transport_type}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">เลขพัสดุ</div>
                                            <div class="col-lg-6 col-8">{{$order->Tracking_Number}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">เอกสารแนบไฟล์ขนส่ง</div>
                                            <div class="col-lg-6 col-8"> <a href="{{URL::asset('upload/slip/'.$order->receipt)}}">ดู</a></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">ใบเสร็จ</div>
                                            <div class="col-lg-6 col-8"><a href="{{URL::asset('upload/slip/'.$order->receipt)}}">ดู</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                
                        <!--------------- SHIPPING & BILLING ADDRESS --------------->
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="infoBox">
                                    <div class="row">
                                        <div class="col">
                                            <h6>ที่อยู่ในการจัดส่งสินค้า</h6>
                                        </div>
                                    </div>
                                    <div class="order-info">
                                        <div class="row">
                                            <div class="col">
                                                <ul class="add-info">
                                                    <li>{{$order->ship_first_name}} {{$order->pay_last_name}}</li>
                                                    <li>(Tel. {{$order->ship_phone}})</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">{{$order->ship_address}} {{$order->ship_district_name}} {{$order->ship_amphure_name}} {{$order->ship_province_name}}  {{$order->ship_zipcode}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-12">
                                <div class="infoBox">
                                    <div class="row">
                                        <div class="col">
                                            <h6>ที่อยู่ในการออกใบเสร็จรับเงิน</h6>
                                        </div>
                                    </div>
                                    <div class="order-info">
                                        <div class="row">
                                            <div class="col">
                                                <ul class="add-info">
                                                    <li>{{$order->receipt_first_name}} {{$order->receipt_last_name}}</li>
                                                    <li>(Tel. {{$order->receipt_phone}})</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">{{$order->receipt_address}} {{$order->receipt_district_name}} {{$order->receipt_amphure_name}} {{$order->receipt_province_name}}  {{$order->receipt_zipcode}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!--------------- ORDER SUMMARY --------------->
                        <div class="order-summaryBox">
                            <div class="row">
                                <div class="col">
                                    <h4>รายการสั่งซื้อ (2)</h4>
                                </div>
                            </div>
                            <div class="order-product">
                                @foreach ($order->order_products as $item)
                                <div class="order-summary-product">
                                    <div class="row">
                                        <div class="col-lg-2 col-3">
                                            <div class="img-width"><img src="{{URL::asset('upload/product/'.$item->product->product_image)}}"></div>
                                        </div>
                                        <div class="col-lg-6 col-9">
                                            <p>{{$item->product->product_name}}</p>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="summary-product-info">
                                                        <li>SKU : @php $productcode = DB::table('productsku')->where('id',$item->productsku_id)->first(); @endphp {{@$productcode->product_SKU}}</li>
                                                        <li>Color :@php $color = DB::table('productsoption1')->where('id',$item->ref_color_id)->first(); @endphp {{@$color->name_th}}</li>
                                                        <li>Size :@php $size = DB::table('productsoption2')->where('id',$item->ref_color_id)->first(); @endphp {{@$size->name_th}}</li>
                                                    </ul>
                                                </div>
                                                <div class="col mobile">
                                                    <ul class="summary-product-info p-sum">
                                                        <li><div class="price">฿ {{number_format($item->order_total)}}</div></li>
                                                        <li>Qty :  1</li>
                                                    </ul>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-lg-4 mobile-none">
                                            <div class="price">฿ {{number_format($item->order_total)}}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="w-100">
                                <div class="row">
                                    <div class="col">
                                        <div class="summary-order-total">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>ราคารวม</td>
                                                        <td>{{number_format($order->order_products->sum->order_total)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ส่วนลด</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ค่าจัดส่ง</td>
                                                        <td>{{ number_format($order->shipping_cost) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ภาษี</td>
                                                        <td>{{ number_format($order->vat) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ราคาสุทธิ</td>
                                                        <td>฿ {{ number_format($order->order_products->sum('order_total') + $order->shipping_cost + $order->vat) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <div class="doubleBD">
                                        <div class="content-center">
                                            <a class="buttonBK" href="/order/orderHistory">ย้อนกลับ</a>
                                        </div>
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