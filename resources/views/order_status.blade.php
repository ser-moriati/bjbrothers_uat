<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- DATE-PICKER -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
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
                            <li>ยืนยันการชำระเงิน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------------- C O N F I R M - P A Y M E N T --------------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
            <div class="col-lg-10 col-12 offset-lg-1">
                <div class="row">
                    @php if($order->ref_order_status_id == "7"){       @endphp
                    <div class="col">
                        <h3><center>รอการยืนยันสถานะการสั่งสินค้า</center></h3>
                        <h5 style="margin-bottom: 0px;" ><center><p style="color:red">สามารถตรวจสอบสถานะรายการสั่งซื้อได้ที่ <a href="{{ url('order/orderHistory') }}">"ประวัติการสั่งซื้อ"</a></p></center></h5>
                        <h6 ><center><p style="color:red">โดยราคาตามรายละเอียดด้านล่างจะยังไม่รวมภาษีและค่าจัดส่ง</p></center></h6>
                    </div>
                    @php }else{    @endphp
                        
                        <div class="col">
                        <h3 ><center>รอการยืนยันสถานะการชำระเงิน</center></h3>
                        <h4 ><center><p style="color:red">กรุณาตรวจสอบอีเมลของท่านเพื่อรอยืนยันการชำระเงินและแจ้งการจัดส่ง</p></center></h4>
                    </div>   
                    @php }        @endphp
                </div>
                </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-lg-10 col-12 offset-lg-1">
                        <div class="doubleBox-BD BKbd">
                        <div class="order-summaryBox">
                            <div class="row">
                                <div class="col">
                                <center> <h5>รายการสั่งซื้อ </h5></center>
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
                                                        <li>SKU : @php $productcode = DB::table('productsku')->where('id',$item->productsku_id)->first(); @endphp {{@$productcode->product_SKU}}</li>
                                                        <li>Color :@php $color = DB::table('productsoption1')->where('id',$item->ref_color_id)->first(); @endphp {{@$color->name_th}}</li>
                                                        <li>Size :@php $size = DB::table('productsoption2')->where('id',$item->ref_color_id)->first(); @endphp {{@$size->name_th}}</li>
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
                                                    @php if($order->ref_order_status_id == "7"){       @endphp
                                                    <tr>
                                                        <td>ค่าจัดส่ง</td>
                                                        <td>ระบุตามจำนวนสินค้าในเมล์คอนเฟิร์มรับออเดอร์</td>
                                                    </tr>
                                                    @php }else{    @endphp
                                                    <tr>
                                                        <td>ค่าจัดส่ง</td>
                                                        <td>{{$order->shipping_cost}}</td>
                                                    </tr>
                                                    @php }        @endphp
                                                    @php if($order->ref_order_status_id == "7"){       @endphp
                                                    <tr>
                                                        <td>ภาษีมูลค่าเพิ่ม</td>
                                                        <td>ระบุตามจำนวนสินค้าในเมล์คอนเฟิร์มรับออเดอร์</td>
                                                    </tr>
                                                    @php }else{    @endphp
                                                    <tr>
                                                        <td>ภาษีมูลค่าเพิ่ม</td>
                                                        <td>{{$order->vat}}</td>
                                                    </tr>
                                                    @php }        @endphp
                                                    @php if($order->ref_order_status_id == "7"){       @endphp
                                                  
                                                    @php }else{    @endphp
                                                        <tr>
                                                        <td>ราคาสุทธิ</td>
                                                        <td>฿ {{number_format($order->order_products->sum->order_total+$order->shipping_cost+$order->vat,2)}}</td>
                                                    </tr>
                                                    @php }        @endphp
                                                   
                                                    <!-- <tr>
                                                        <td>ราคาสุทธิ</td>
                                                        <td>฿ {{number_format($order->order_products->sum->order_total+$order->shipping_cost+$order->vat,2)}}</td>
                                                    </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                                
                        </div>
                            
                        </div>
                    </div>
                </div>
            </form>
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker();
        } );
    </script>
    <script>
        checkOrder("{{@$order->order_number}}");
        function checkOrder(v){
            $.ajax({
                type: "GET",
                url: "/order/checkOrder/"+v,
                success: function( result ) {
                    // var url = 'images/icon/icon-cartWH.svg';
                    // if(result.status == true){
                        $('#subForm').attr('disabled', result.disabled);
                    // }
                    $('.chackOrder').attr('style','color:'+result.status_color);
                    $('.chackOrder').html(result.message);

                },error : function(e){
                    console.log(e)
                }
            });
        }
        function imgChange(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    // $('.view').html();
                    reader.onload = function(e) {
                    $('.view').html('<img class="img-thumbnail imagePreview" alt="200x200" width="200" data-holder-rendered="true" src="'+e.target.result+'">');
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
    </script>
    
</body>
</html>