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
                            <li>สรุปคำสั่งซื้อ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- O R D E R - S U M M A R Y --------------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <div class="summary-header">
                            <h1 class="EngSM">ORDER SUMMARY</h1>
                            <h3><span>หมายเลขคำสั่งซื้อ</span>{{$order->order_number}}</h3>
                        </div> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-10 col-12 offset-lg-1">
                        <div class="row">
                            <div class="col">
                                <div class="borderTop"></div>
                            </div>
                        </div>
                        <!--------------- ORDER INFO --------------->
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
                                            <div class="col-lg-6 col-4">วิธีการจัดส่ง</div>
                                            <div class="col-lg-6 col-8">{{$order->shipping_name}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-4">วิธีการชำระเงิน</div>
                                            <div class="col-lg-6 col-8">{{$order->payment_name}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>   

                        <!--------------- SHIPPING & BILLING ADDRESS --------------->
                        <div class="row">
                            <div class="col-lg-6 col-12">
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
                                                    <li>{{$order->ship_first_name}} {{$order->ship_last_name}}</li>
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
                            <div class="col-lg-6 col-12">
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
                                    <h4>รายการสั่งซื้อ ({{ $order->order_products->sum->qty }})</h4>
                                </div>
                            </div>
                            <div class="order-product">
                                <!-- PRODUCT :: 01 -->
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
                                                        <li>{{$item->product->product_code}}</li>
                                                        <li>Color :  {{@$item->color->color_name}}</li>
                                                        <li>Size :  {{@$item->size->size_name}}</li>
                                                        <li>Qty :  {{$item->qty}}</li>
                                                    </ul>
                                                </div>
                                                <div class="col mobile">
                                                    <ul class="summary-product-info p-sum">
                                                        <li><div class="price">฿ {{number_format($item->order_total)}}</div></li>
                                                        <li>Qty :  {{$item->qty}}</li>
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
                                <!-- PRODUCT :: 02 -->
                                {{-- <div class="order-summary-product">
                                    <div class="row">
                                        <div class="col-lg-2 col-3">
                                            <div class="img-width"><img src="images/product/product04.jpg"></div>
                                        </div>
                                        <div class="col-lg-6 col-9">
                                            <p>Portable Safety Barrier</p>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="summary-product-info">
                                                        <li>XX00000</li>
                                                        <li>Color :  สีเหลือง</li>
                                                        <li>Size :  xxxxx</li>
                                                        <li>Size :  xxxxx</li>
                                                    </ul>
                                                </div>
                                                <div class="col mobile">
                                                    <ul class="summary-product-info p-sum">
                                                        <li><div class="price">฿ 1,500</div></li>
                                                        <li>Qty :  1</li>
                                                    </ul>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-lg-4 mobile-none">
                                            <div class="price">฿ 1,500</div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="w-100">
                                <div class="row">
                                    <div class="col">
                                        <div class="summary-order-total">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>ราคารวม</td>
                                                        <td>฿ {{number_format($order->order_products->sum->order_total,2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ส่วนลด</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ค่าจัดส่ง</td>
                                                        <td>{{ number_format($order->shipping_cost,2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ภาษีมูลค่าเพิ่ม</td>
                                                        <td>{{ number_format($order->vat,2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ราคาสุทธิ</td>
                                                        <td>฿ {{number_format($order->order_products->sum->order_total+$order->shipping_cost+$order->vat,2)}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                                
                        </div>

                        <div class="button-line center">
                            <div class="row">
                                <div class="col">
                                    <a class="buttonBD" href="/">กลับหน้าแรก</a>
                                </div>
                                <div class="col">
                                    <a class="buttonBK gray" href="/order/confirmPayment/{{$order->id}}">แจ้งการชำระเงิน</a>
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