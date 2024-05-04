<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- DATE-PICKER -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
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
                <div class="row">
                    <div class="col">
                        <h1 class="EngSM">CONFIRM PAYMENT</h1>
                    </div>
                </div>
            <form action="{{url('order/updateConfirmPayment')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-lg-10 col-12 offset-lg-1">
                        <div class="doubleBox-BD BKbd">
                            <div class="doubleBox input-form" id="confirm-payment">
                                <div class="row">
                                    <div class="col">
                                        <p>หมายเลขคำสั่งซื้อ <span class="chackOrder"></span></p>
                                        <input oninput="checkOrder(this.value)" type="text" name="order_number" class="form-control shadow-none" placeholder="{{@$id}}" value="{{@$id}}" required @if ($id) readonly @endif>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <button class="btn btn-info show_detail" ref="2" type="button" style="width: 100%; margin-bottom: 10px;">แสดงรายละเอียดออเดอร์</button>
                                    </div>
                                </div>
                                <div class="row detail_order" style="display: none; margin-top: 15px; font-size: 12px;">
                                    <div class="col-lg-12 col-md-12 col-12 row">
                                        <p class="col-lg-12 col-md-12 col-sm-12"><b>รายละเอียดลูกค้า </b><span class="chackOrder"></span></p>
                                        <?php 
                                            $order = DB::table('orders')->where('order_number','LIKE',$id)->first(); 
                                            $provinces = DB::table('provinces')->where('id',$order->ship_ref_province_id)->first();
                                            $amphures = DB::table('amphures')->where('id',$order->ship_ref_amphure_id)->first();
                                            $districts = DB::table('districts')->where('id',$order->ship_ref_district_id)->first();
                                        ?>
                                        <div class="col-lg-1 col-md-1 col-sm-12">
                                            <p>ชื่อ : </p>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <p id="mCustomer">{{ (!empty($order) ? $order->ship_first_name.' '.$order->ship_last_name : '') }}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-1 col-sm-12">
                                            <p>ที่อยู่จัดส่ง : </p>
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-12">
                                            <p id="ShippingAddress">{{ (!empty($order) ? $order->ship_address.' '.$provinces->name_th.' '.$amphures->name_th.' '.$districts->name_th.' '.$order->ship_zipcode : '') }}
                                            </p>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-12">
                                            <p>อีเมล : </p>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12">
                                            <p id="mOrderEmail">{{ (!empty($order) ? $order->ship_email : '') }}
                                            </p>
                                        </div>
                                        <div class="col-lg-2 col-md-1 col-sm-12">
                                            <p>เบอร์ติดต่อ : </p>
                                        </div>
                                        <div class="col-lg-4 col-md-5 col-sm-12">
                                            <p id="mOrderTel">{{ (!empty($order) ? $order->ship_phone : '') }}
                                            </p>
                                        </div>

                                        <p class="col-lg-12 col-md-12 col-sm-12"><b>รายละเอียดออเดอร์ </b><span class="chackOrder"></span></p>
                                        <table class="table table-centered table-nowrap col-lg-8 col-md-8 col-sm-12">
                                            <thead>
                                                <tr style="text-align: center;">
                                                    <th>รายละเอียด</th>
                                                    <th>จำนวน</th>
                                                    <th>ราคา</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                $order_total = 0;
                                                $order_products = DB::table('order_has_product')
                                                                    ->leftjoin('products','products.id','=','order_has_product.ref_product_id')
                                                                    ->leftjoin('colors','colors.id','=','order_has_product.ref_color_id')
                                                                    ->leftjoin('sizes','sizes.id','=','order_has_product.ref_size_id')
                                                                    ->where('ref_order_id',$order->id)
                                                                    ->get(); 
                                            ?>
                                                @foreach ($order_products as $item)
                                                <tr>
                                                    <td style="vertical-align: top !important;">
                                                        <div>
                                                            <img class="float-left" width="100px;" style="margin-right: 10px;" src="{{URL::asset('upload/product/'.$item->product_image)}}" />
                                                            <p class="text-muted mb-0">{{$item->product_name}}</p>
                                                            <p class="text-muted mb-0">{{$item->product_code}} <br>Color :  {{@$item->color_name}} | Size :  {{@$item->size_name}}<br> Price : {{ $item->price }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $item->qty }}
                                                    </td>
                                                    <td class="text-center">
                                                        ฿ {{ number_format(($item->price * $item->qty),2,'.',',') }}
                                                    </td>
                                                </tr>
                                                <?php 
                                                    $order_total += ($item->price * $item->qty);
                                                ?>
                                                @endforeach                                         
                                            </tbody>
                                        </table>

                                        <table class="table table-centered table-nowrap offset-1 col-lg-3 col-md-3 col-sm-12">
                                            <thead>
                                                <tr style="text-align: center;">
                                                    <th colspan="2">Summary</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Sub Total :
                                                    </td>
                                                    <td>
                                                        ฿ {{ number_format($order_total,2,'.',',') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Shipping :
                                                    </td>
                                                    <td> 
                                                        ฿ {{ number_format($order->shipping_cost,2,'.',',') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Vat :
                                                    </td>
                                                    <td>
                                                        ฿ {{ number_format($order->vat,2,'.',',') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php 
                                                        $order_total += $order->vat + $order->shipping_cost;
                                                    ?>
                                                    <td>
                                                        Total :
                                                    </td>
                                                    <td>
                                                        ฿ {{ number_format($order_total,2,'.',',') }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                    <hr>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>บัญชีที่โอนเงิน</p>
                                        <div class="from-select">
                                            <select name="bank_id" class="form-control shadow-none" required>
                                                <option value="" selected>เลือก</option>
                                                @foreach ($bank as $item)
                                                    <option value="{{$item->id}}">{{$item->bank_name}} {{$item->bank_number}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>จำนวนเงินที่โอน</p>
                                        <input name="transfer_amount" type="text" class="form-control shadow-none" value="{{@$sum}}" required @if ($sum) readonly @endif>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>วันที่ชำระเงิน</p>
                                        <input name="transfer_date" type="text" class="form-control shadow-none" id="datepicker" placeholder="dd/mm/yyyy" autocomplete="off" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <p>เวลาที่ชำระเงิน</p>
                                        <input name="transfer_time" type="time" class="form-control shadow-none" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="file-input-wrapper mt-2">
                                            <label for="upload-file" class="file-input-button">BROWSE FILE</label>
                                            <input id="upload-file" type="file" name="file" onchange="imgChange(this)" accept="image/*" required>
                                        </div>
                                        <div class="f-14 Lgray w-100 view">
                                            กรุณาอัพโหลดภาพสลิปการโอนเงิน
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <br>
                                        <label style="color: red;">ขั้นตอนการชำระเงิน</label><br>
                                        <label>1. ตรวจสอบรายละเอียดรายการสั่งซื้อ ราคา และสินค้า โดยกดที่ปุ่ม <font color="red">"แสดงรายละเอียดออเดอร์"</font></label><br>
                                        <label>2. เลือกช่องทางการชำระเงิน โดยมีธนาคารที่รองรับดังนี้</label><br>
                                        @foreach ($bank as $item)
                                            <label>&nbsp;&nbsp;&nbsp;&nbsp;- {{$item->bank_name}} เลขบัญชี {{$item->bank_number}}</label><br>
                                        @endforeach
                                        <label>3. กรอกวันที่ชำระ และเวลาให้ตรงกับในสลิป</label><br>
                                        <label>4. อัพโหลดสลิปที่ทำการโอนชำระเข้ามา และกดที่ปุ่ม <font color="red">"ยืนยัน"</font> เพื่อให้เจ้าหน้าที่ตรวจสอบการชำระเงินของท่าน</label><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="content-center">
                                            <button type="submit" class="btn buttonBK" id="subForm">ยืนยัน</button>
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

        $(document).ready(function(){
            $('.show_detail').click(function(){
                var check = $(this).attr('ref');
                if(check == '2'){
                    $('.detail_order').css('display','block');
                    $(this).attr('ref','1');
                }
                if(check == '1'){
                    $('.detail_order').css('display','none');
                    $(this).attr('ref','2');
                }
            });
        });

    </script>
    <script>
        
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