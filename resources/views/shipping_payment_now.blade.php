<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- SELECT2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.min.css">



</head>
<style>
    /* ปรับแต่งสีพื้นหลังของ modal */
    .modal-content {
        background-color: #f8f9fa; /* เปลี่ยนสีพื้นหลังตามต้องการ */
    }

    /* ปรับแต่งสีปุ่ม Confirm */
    .swal2-confirm {
        background-color: #34c38f; /* เปลี่ยนสีปุ่ม Confirm ตามต้องการ */
        border-color: #34c38f; /* เปลี่ยนสีเส้นขอบปุ่ม Confirm ตามต้องการ */
    }

    /* ปรับแต่งสีปุ่ม Cancel */
    .swal2-cancel {
        background-color: #f46a6a; /* เปลี่ยนสีปุ่ม Cancel ตามต้องการ */
    }

    /* ปรับแต่งขนาดและสีของหัวเรื่อง */
    .swal2-title {
        font-size: 24px; /* เปลี่ยนขนาดตามต้องการ */
        color: #333; /* เปลี่ยนสีตามต้องการ */
    }

    /* ปรับแต่งขนาดและสีของเนื้อหา */
    .swal2-content {
        font-size: 18px; /* เปลี่ยนขนาดตามต้องการ */
        color: #666; /* เปลี่ยนสีตามต้องการ */
    }
</style>

<body>
    <div class="thetop"></div>
    @include('inc_topmenu')
   <!-- Lightbox css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}">
    <!--------------- N A V - B A R --------------->
    <div class="navBK">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb">
                            <li><a href="/">หน้าแรก</a></li>
                            <li><a href="/cart">ตะกร้าสินค้า</a></li>
                            <li>ที่อยู่จัดส่งและวิธีการชำระเงิน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- S H I P P I N G & P A Y M E N T --------------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h1 class="EngSM">SHIPPING PAYMENT</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-12">
                        <!--------------- SHIPPING ADDRESS --------------->
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <div class="gray-header">
                                        <div class="gray-header-topic">ที่อยู่ในการจัดส่ง</div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <form id="shippingForm" action="{{url('/shipping_payment/insert_now')}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <div class="shippingBox">
                                        <div class="accordion">
                                            <!-- ADDRESS (Default) -->
                                            <div class="row">
                                                <div class="col">
                                                    <div class="md-radio md-radio-inline radiocheck">
                                                        <input id="add-1" type="radio" name="shipping" value="1" checked/>
                                                        <label for="add-1">
                                                            <p>ข้อมูลที่อยู่เดิม</p>
                                                        </label>
                                                        <section>
                                                            <div class="accBdbottom">
                                                                <div class="form-input">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <div class="address-default">{{$current_shipping}}</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ADD NEW ADDRESS -->
                                            <div class="row">
                                                <div class="col">
                                                    <div class="md-radio md-radio-inline radiocheck">
                                                        <input id="add-2" type="radio" name="shipping" value="2"/>
                                                        <label for="add-2">
                                                            <p>เพิ่มที่อยู่ใหม่</p> 
                                                        </label>
                                                        <section>
                                                            <div class="accBdbottom noneBD">
                                                                <div class="input-form">
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>ชื่อ</p>
                                                                            <input type="text" class="form-control shadow-none" name="new_shipping_firstname">
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>นามสกุล</p>
                                                                            <input type="text" class="form-control shadow-none" name="new_shipping_lastname">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>เบอร์โทรศัพท์</p>
                                                                            <input type="text" class="form-control shadow-none" name="new_shipping_phone">
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>อีเมล</p>
                                                                            <input type="text" class="form-control shadow-none" name="new_shipping_email">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <p>ที่อยู่</p>
                                                                            <input id="new_shipping_address" type="text" class="form-control shadow-none" name="new_shipping_address">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>จังหวัด</p>
                                                                            <div class="select2-part">
                                                                                <select onchange="getAmphures(this.value,'new_shipping_amphure')" class="js-example-basic-single form-control shadow-none" name="new_shipping_province">
                                                                                    <option value="">เลือก</option>
                                                                                    @foreach ($province as $prov)                                                                                        
                                                                                    <option value="{{$prov->id}}">{{$prov->name_th}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                                
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>รหัสไปรษณีย์</p>
                                                                            <input type="text" class="form-control shadow-none" name="new_shipping_zipcode">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>เขต / อำเภอ</p>
                                                                            <div class="select2-part">
                                                                                <select id="new_shipping_amphure" onchange="getDistrict(this.value,'new_shipping_district')" class="js-example-basic-single form-control shadow-none" name="new_shipping_amphure">
                                                                                    <option value="">เลือก</option>
                                                                                    @foreach ($amphures as $amph)                                                                                        
                                                                                    <option value="{{$amph->id}}">{{$amph->name_th}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6 col-md-6 col-12">
                                                                            <p>แขวง / ตำบล</p>
                                                                            <div class="select2-part">
                                                                                <select id="new_shipping_district" onchange="getZipcode(this.value,'receipt_zipcode')" class="js-example-basic-single form-control shadow-none" name="new_shipping_district">
                                                                                    <option value="">เลือก</option>
                                                                                    {{-- @foreach ($district as $dist)                                                                                        
                                                                                    <option value="{{$dist->id}}">{{$dist->name_th}}</option>
                                                                                    @endforeach --}}
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </section>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>

                                        <!-- BILLING -->
                                        <div class="shipping-subtopic">
                                            <div class="row">
                                                
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="receipt" class="custom-control-input checkboxsw" id="switch" checked value="1">
                                            <label class="custom-control-label" for="switch">รายละเอียดใบเสร็จรับเงิน ใช้ที่อยู่เดียวกับที่อยู่จัดส่ง ?</label>
                                        </div>
                                                {{-- <div class="col-10"></div> --}}
                                                <!-- SWITCH BUTTON -->
                                                {{-- <div class="col-2">
                                                    <div class="checkboxsw">
                                                        <input type="checkbox" id="switch" /><label for="switch"></label>
                                                    </div>
                                                </div> --}}
                                            </div>
                                            <div class="box01">
                                                <div class="accBdbottom noneBD">
                                                    <div class="input-form">
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>ชื่อ</p>
                                                                <input type="text" class="form-control shadow-none" name="receipt_firstname">
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>นามสกุล</p>
                                                                <input type="text" class="form-control shadow-none" name="receipt_lastname">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>เบอร์โทรศัพท์</p>
                                                                <input type="text" class="form-control shadow-none" name="receipt_phone">
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>อีเมล</p>
                                                                <input type="text" class="form-control shadow-none" name="receipt_email">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <p>ที่อยู่</p>
                                                                <input type="text" class="form-control shadow-none" name="receipt_address">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>จังหวัด</p>
                                                                <div class="select2-part">
                                                                    <select onchange="getAmphures(this.value,'receipt_amphure')" class="js-example-basic-single form-control shadow-none" name="receipt_province">
                                                                        <option value="">เลือก</option>
                                                                        @foreach ($province as $prov)                                                                                        
                                                                        <option value="{{$prov->id}}">{{$prov->name_th}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>รหัสไปรษณีย์</p>
                                                                <input type="text" id="receipt_zipcode" class="form-control shadow-none" name="receipt_zipcode">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>เขต / อำเภอ</p>
                                                                <div class="select2-part">
                                                                    <select id="receipt_amphure" onchange="getDistrict(this.value,'receipt_district')" class="js-example-basic-single form-control shadow-none" name="receipt_amphure">
                                                                        <option value="">เลือก</option>
                                                                        @foreach ($amphures as $amph)                                                                                        
                                                                        <option value="{{$amph->id}}">{{$amph->name_th}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-12">
                                                                <p>แขวง / ตำบล</p>
                                                                <div class="select2-part">
                                                                    <select id="receipt_district" onchange="getZipcode(this.value,'receipt_zipcode')" class="js-example-basic-single form-control shadow-none" name="receipt_district">
                                                                        <option value="">เลือก</option>
                                                                        {{-- @foreach ($district as $dist)                                                                                        
                                                                        <option value="{{$dist->id}}">{{$dist->name_th}}</option>
                                                                        @endforeach --}}
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="shipping-subtopic">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="accBdbottom pl-0 pt-0">
                                                        <div class="input-form">
                                                            <p class="mb-3">หมายเหตุ (ถ้ามี)</p>
                                                            <textarea class="form-control shadow-none mb-2" name="remark"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                            

                      
                    
                        
                      

                        <div class="button-line mobile-none" style="margin-bottom: 30px;">
                            <div class="row">
                                <div class="col">
                                    <!-- <a class="buttonBD" href="/cart">แก้ไขตะกร้าสินค้า</a> -->
                                </div>
                                <div class="col">
                              
                                    <button class="buttonBK gray" type="button" id="alert" style="border: unset;">ดำเนินการสั่งซื้อสินค้า</button>
                                </div>
                            </div>
                        </div>
                      
                   
                    </div>

                    <!--------------- ORDER SUMMARY --------------->
                    <div class="col-lg-4 col-12">
                        <div class="row">
                            <div class="col">
                                <div class="BK-topic">สรุปรายการสินค้า</div>
                            </div>
                        </div>
                        <div class="grayBox">   
                            <div class="cart-summary">
                                <!-- PRODUCT :: 01 -->
                                
                            @php
                            $price_total = 0;
                        
                        @endphp
                        @php $words = explode(" ",$product->namecolorandsize); @endphp      
                                <div class="cart-summary-product">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-2 col-2">
                                            <div class="img-width"><img src="{{URL::asset('upload/product/'.$product->product_image)}}"></div>
                                        </div>
                                        <div class="col-lg-8 col-md-9 col-9">
                                            <div class="row">
                                                <div class="col">
                                                        <p>{{$product->product_name}}</p>
                                                    
                                                <input type="hidden" id="product_id" name="product_id" value="{{$product->id}}">
                                                <input type="hidden" id="productsku_id" name="productsku_id" value="{{$product->product_sku_id}}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="summary-product-info">
                                                        <li><div class="price">
                                                       
                                                            @if ($product->product_sale==0.00||$product->product_sale==0)                                                        
                                                                @php
                                                                    $product_price = $product->product_price;
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $product_price = $product->product_sale; 
                                                                @endphp
                                                            @endif
                                                           
                                                            ฿ {{number_format($product_price*$qty,2)}}
                                                            <input type="hidden" id="product_price1" name="product_price1" value="{{$product_price}}">
                                                            <input type="hidden" id="product_price_sum" name="product_price_sum" value="{{$product_price*$qty}}">
                                                            <input type="hidden" id="qty" name="qty" value="{{$qty}}">
                                                        </div></li>
                                                    </ul>
                                                   
                                              
                                            </div>
                                            <div class="row">
                                                <div class="col" style="padding-right: 0px;">
                                                    <div class="content-center">
                                                        <div class="sp-quantity">
                                                            <div class="sp-minus btnquantity"><i class="fas fa-minus"></i></div>
                                                            <div class="sp-input">
                                                            <input type="text" id="Qty" name="Qty" ids="{{$product->product_sku_id}}" prices="{{@$product_price}}" oninput="updateCart({{$product->product_sku_id}},{{@$product_price}},this.value)" class="quntity-input" value="{{$qty}}" />
                                                            </div>
                                                            <div class="sp-plus btnquantity"><i class="fas fa-plus"></i></div>
                                                        </div>
                                                    </div>
                                                  
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                                   
                        @php    
                            $price_total = $price_total+($product_price*$qty);
                        @endphp
                     
                            </div>

                            <div class="w-100">
                                <div class="row">
                                    <div class="col">
                                        <div class="summary-order-total">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>ราคารวม</td>
                                                        <td id="PriceAll">{{number_format($price_total,2,'.',',')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ส่วนลด</td>
                                                        <td>0.00</td>
                                                    </tr>
                                                    <tr>

                                                    </tr>
                                                    <tr>
                                                @php
                                                    $vat = 0;
                                                    $checked = '';
                                                if($session_vat){
                                                    $vat = 0;
                                                    $checked = 'checked';
                                                }
                                                @endphp
                                                    <td colspan="2"><input type="checkbox" name="" id="vat" onchange="ChangeVat()" {{ $checked }}> <label for="vat">ขอใบกำกับภาษี</label></td>
                                                    <!-- <td id="allPricevat">{{ number_format(($price_total)*0.07,2) }}</td> -->
                                                </tr>
                                                <tr>
                                                    <td>ราคาสุทธิ</td>
                                                    <td id="tdPriceAllTotal">฿ {{@number_format($price_total+$vat,2)}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <script>
                                            function ChangeVat(){
                                                var check = 0;
                                                if($('#vat').is(":checked")){
                                                    // alert(4);
                                                    check = 1;
                                                }
                                                
                                                $.ajax({
                                                    type: "POST",
                                                    url: "{{url('/cart/ChangeVat')}}",
                                                    data: {_token: "{{ csrf_token() }}", check: check},
                                                    success: function( result ) {
                                                        var sum = $('#product_price_sum').val();
                                                        var Vat = sum * 0.07;
                                                        var allPricevat = Vat.toFixed(2);
                                                        $('#allPricevat').html(allPricevat.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));  
                                                        var allPrice = parseFloat($('#product_price_sum').val());
                                                        if($('#vat').is(":checked")){                                                                                             
                                                            // var total = allPrice* 0.07  ;
                                                            // var sumtotal = total + allPrice;
                                                            var alltotal = allPrice.toFixed(2);
                                                            $('#tdPriceAllTotal').html('฿ '+alltotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                                                        }else{          
                                                            var alltotalcheck = allPrice.toFixed(2);
                                                            $('#tdPriceAllTotal').html('฿ '+alltotalcheck.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                                                        }
                                                    },error : function(e){
                                                        console.log(e)
                                                    }
                                                });
                                            }
                                        </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        </div>

                    </div>
                </div>
                
                <div class="button-line mobile" style="margin-bottom: 25px;">
                    <div class="row">
                        <div class="col">
                            <a class="buttonBD" href="/">แก้ไขตะกร้าสินค้า</a>
                        </div>
                        <div class="col">
                            <button type="button" class="buttonBK gray"   style="border: unset;" id="alert">ดำเนินการชำระเงิน</button>
                            <!-- <button class="buttonBK gray" type="submit" style="border: unset;">ดำเนินการชำระเงิน</button> -->
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
     </form>

    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script>
        $(function() {
            $('#alert').click(function() {
                Swal.fire({
                icon: "warning",
                title: 'ยืนยันการดำเนินการ?',
                html: " ราคาที่ปรากฎเป็นราคาที่ยังไม่รวมค่าขนส่งและภาษี <br>กดยืนยันเพือดำเนินการต่อ!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยันออเดอร์',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#shippingForm').submit();
                }
                })
            });
        });
    </script>

<div class="modal fade" id="modalChangStatus" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        <div class="modal-body">
                    <div class="swal2-header"><ul class="swal2-progress-steps" style="display: none;"></ul><div class="swal2-icon swal2-error" style="display: none;"><span class="swal2-x-mark"><span class="swal2-x-mark-line-left"></span><span class="swal2-x-mark-line-right"></span></span></div><div class="swal2-icon swal2-question" style="display: none;"></div><div class="swal2-icon swal2-warning swal2-animate-warning-icon" style="display: flex;"></div><div class="swal2-icon swal2-info" style="display: none;"></div><div class="swal2-icon swal2-success" style="display: none;"><div class="swal2-success-circular-line-left" style="background-color: rgb(255, 255, 255);"></div><span class="swal2-success-line-tip"></span> <span class="swal2-success-line-long"></span><div class="swal2-success-ring"></div> <div class="swal2-success-fix" style="background-color: rgb(255, 255, 255);"></div><div class="swal2-success-circular-line-right" style="background-color: rgb(255, 255, 255);"></div></div><img class="swal2-image" style="display: none;"><h2 class="swal2-title" id="swal2-title" style="display: flex;">ยืนยันการดำเนินการ</h2><button type="button" class="swal2-close" aria-label="Close this dialog" style="display: none;">×</button></div>
                    <div class="swal2-content"><div id="swal2-content" style="display: block;"><h5>ราคาที่ปรากฎเป็นราคาที่ไม่รวมค่าขนส่งและภาษี กดยืนยันเพือดำเนินการต่อ</h5></div><input class="swal2-input" style="display: none;"><input type="file" class="swal2-file" style="display: none;"><div class="swal2-range" style="display: none;"><input type="range"><output></output></div><select class="swal2-select" style="display: none;"></select><div class="swal2-radio" style="display: none;"></div><label for="swal2-checkbox" class="swal2-checkbox" style="display: none;"><input type="checkbox"><span class="swal2-label"></span></label><textarea class="swal2-textarea" style="display: none;"></textarea><div class="swal2-validation-message" id="swal2-validation-message"></div></div>
                    <div class="swal2-actions"><button type="button" class="btn btn-success" aria-label="" style="display: inline-block; background-color: rgb(52, 195, 143); border-left-color: rgb(52, 195, 143); border-right-color: rgb(52, 195, 143);" onclick="confirmChangStatus()">ยืนยัน</button>&nbsp;<button onclick="cancelDelete()" type="button" class="btn btn-danger" aria-label="" style="display: inline-block; background-color: rgb(244, 106, 106);">ยกเลิก</button></div>
                </div>
        </div>
    </div>
</div>
    @include('inc_topbutton')
    @include('inc_footer')
    <script type="text/javascript">
    // คำนวณราคาจากจำนวนสินค้าที่เลือก//
    $(document).ready(function() {
        $(".btnquantity").on("click", function () {
            var $button = $(this);
            var oldValue = $button.closest('.sp-quantity').find("input.quntity-input").val();
            if ($button.hasClass("sp-plus")) {
                var newVal = parseFloat(oldValue) + 1;
            } else {
                if (oldValue > 1) {
                    var newVal = parseFloat(oldValue) - 1;
                } else {
                    newVal = 1;
                }
            }
            var id = $button.closest('.sp-quantity').find("input.quntity-input").attr('ids');
            var price = $button.closest('.sp-quantity').find("input.quntity-input").attr('prices');
            updateCart(id, price, newVal);
            $button.closest('.sp-quantity').find("input.quntity-input").val(newVal);
        });
    });

    function updateCart(id, price, newVal) {
        if (newVal === '' || newVal === 0) {
            // Handle the case where newVal is empty or zero
            return;
        }
        var allPrice = price * newVal;
        var Vat = allPrice * 0.07;
        var allPricevat = Vat.toFixed(2);
        $.ajax({
            type: "POST",
            url: "{{url("/shipping_payment/update_now")}}",
            data: {_token: "{{ csrf_token() }}", id: id, qty: newVal},
            success: function( message ) {
                $('#PriceAll').html(allPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
              
                $('#product_price_sum').val(allPrice);
                $('#qty').val(newVal);
                // $('#tdPriceAllTotal').html(allPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                $('#allPricevat').html(allPricevat.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));  
                if($('#vat').is(":checked")){
                  var sumtotal = allPrice * 0.07;
                        var total = sumtotal + allPrice ;
                        var alltotal = total.toFixed(2);
                    $('#tdPriceAllTotal').html(alltotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));

                }else{
                    $('#tdPriceAllTotal').html(allPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));  
                }
            },
            error: function(e) {
                console.log(e);
            }
        });
    }
</script>

    <script>
        $('#switch').on("change", function() {
            if ($('#switch').is(':checked')) {
                $('.box01').slideUp();
            } else {
                $('.box01').slideDown();
            }
        });
        
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>
        function getAmphures(id, e){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getAmphures/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.name_th+'</option>';
                        });
                        $('#'+e).html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getDistrict(id, e){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getDistrict/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.name_th+'</option>';
                        });
                        $('#'+e).html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getZipcode(id, e){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getZipcode/"+id,
                    success: function( result ) {
                        $('#'+e).val(result);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }

        var id = null;
    var status = null;
    function ChangStatus(i,s){
        id = i;
        status = s;
        $('#modalChangStatus').modal('show');
    }
    
    function confirmChangStatus(){
        $.ajax({
            type: "post",
            url: "/admin/order/confirmChangStatus/"+id,
            data:{
                '_token': '{{ csrf_token() }}',
                'status': status
            },
            success: function( result ) {
                if(result == 1){
                    $('#modalChangStatus').modal('hide');
                    // setTimeout(function(){
                        location.reload();
                    // }, 500);
                }else{
                }
            }   
        });
    }
    
    function cancelDelete(){
        $('#modalChangStatus').modal('hide');
    }
    </script>

</body>
</html>