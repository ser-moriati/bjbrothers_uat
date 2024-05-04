<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- SELECT2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
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
                        <form id="shippingForm" action="{{url ('shipping_payment/insert')}}" method="POST">
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
                                            <label class="custom-control-label" for="switch">รายละเอียดออกใบกำกับภาษี ใช้ที่อยู่เดียวกับที่อยู่จัดส่ง ?</label>
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
                            

                  

                        <div class="button-line mobile-none">
                            <div class="row">
                                <div class="col">
                                    <a class="buttonBD" href="/cart">แก้ไขตะกร้าสินค้า</a>
                                </div>
                                <div class="col">
                                    <button class="buttonBK gray" type="button" id="alert" style="border: unset;">ดำเนินการชำระเงิน</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="shipping_cost" value="{{ $shipping_cost }}">
                    </form>

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
                            $totalPrice = 0;
                        @endphp

                        @if (Session::has('selected_products'))
                            @foreach (Session::get('selected_products') as $key => $selected_products)
                                @php
                                $sumselected_products = DB::table('carts')
                                ->selectRaw('carts.*, products.id as product_id, products.product_name, products.product_weight*carts.qty as weight, products.product_image, products.product_code, products.product_price, productsku.price_1,productsku.price_2,productsku.price_3,productsku.price_0, productsku.name_th, productsku.product_SKU, productsku.product_qty')
                                ->addSelect('productsoption1.name_th as name_th1')
                                ->addSelect('productsoption2.name_th as name_th2')
                                ->leftJoin('products', 'products.id', '=', 'carts.ref_product_id')
                                ->leftJoin('productsku', 'productsku.id', '=', 'carts.productskusizes_id')
                                ->leftJoin('productsoption1', 'productsoption1.id', '=', 'productsku.product_option_1_id')
                                ->leftJoin('productsoption2', 'productsoption2.id', '=', 'productsku.product_option_2_id')
                                ->where('carts.id', $selected_products)
                                ->first();

                                    $role_id = 01;
                                    if (@Auth::guard('member')->user()->ref_role_id) {
                                        $role_id = Auth::guard('member')->user()->ref_role_id;
                                    }
                                
                                    $role_name = DB::table('roles')->where('id', $role_id)->first();
                                    if($sumselected_products){
                                            
                                            if($role_id = 1){
                                                $price = $sumselected_products->price_1; 
                                            }elseif($role_id = 2){
                                                $price = $sumselected_products->price_2;
                                            }elseif($role_id =3){
                                                $price = $sumselected_products->price_3;
                                            }else{
                                                $price = $sumselected_products->price_0;
                                            }
                                            $discount = $price;
                                        
                                    }
                                @endphp 
                                @php $words = explode(" ",$sumselected_products->name_th); @endphp                     
                               <div class="cart-summary-product">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-3">
                                            <div class="img-width"><img src="{{URL::asset('upload/product/'.$sumselected_products->product_image)}}"></div>
                                        </div>
                                        <div class="col-lg-8 col-md-9 col-9">
                                            <div class="row">
                                                <div class="col">
                                                    <p>{{$sumselected_products->product_name}}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="summary-product-info">
                                                        <li>{{$sumselected_products->product_SKU}}</li>
                                                        <li>{{@$sumselected_products->name_th1}}</li>
                                                        <li>{{@$sumselected_products->name_th2}}</li>
                                                    </ul>
                                                </div>
                                                <div class="col">
                                                    <ul class="summary-product-info">
                                                       <li><div class="price">
                                                       
                                                            ฿ {{number_format($price*$sumselected_products->qty)}}
                                                        </div></li>
                                                        <li>Qty : {{number_format($sumselected_products->qty)}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $role_id = 01;
                                if (@Auth::guard('member')->user()->ref_role_id) {
                                    $role_id = Auth::guard('member')->user()->ref_role_id;
                                }
                                
                                $role_name = DB::table('roles')->where('id', $role_id)->first();
                                
                                if($sumselected_products){
                                        $productskusizes = DB::table('productsku')
                                        ->where('id', $sumselected_products->productskusizes_id)
                                        ->first();

                                        $discount = 0;
                                        if($productskusizes){
                                            
                                            if($role_id = 1){
                                                $price = $productskusizes->price_1; 
                                            }elseif($role_id = 2){
                                                $price = $productskusizes->price_2;
                                            }elseif($role_id =3){
                                                $price = $productskusizes->price_3;
                                            }else{
                                                $price = $productskusizes->price_0;
                                            }
                                            $discount = $price;
                                        
                                        }
                                       
                                }
                                
                                $price_total = $discount * $sumselected_products->qty;
                                $totalPrice += $price_total; // เพิ่มค่า $price_total เข้าสู่ผลรวม
                                @endphp

                            @endforeach
                        @endif

                      
                                <!-- PRODUCT :: 02 -->
                                {{-- <div class="cart-summary-product">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-3">
                                            <div class="img-width"><img src="images/product/product04.jpg"></div>
                                        </div>
                                        <div class="col-lg-8 col-md-9 col-9">
                                            <div class="row">
                                                <div class="col">
                                                    <p>Portable Safety Barrier</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <ul class="summary-product-info">
                                                        <li>XX00000</li>
                                                        <li>สีเหลือง</li>
                                                        <li>xxxxx</li>
                                                    </ul>
                                                </div>
                                                <div class="col">
                                                    <ul class="summary-product-info">
                                                        <li><div class="price">฿ 2,000</div></li>
                                                        <li>Qty :  1</li>
                                                    </ul>
                                                </div>

                                            </div>
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
                                                        <td>{{number_format($totalPrice)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ส่วนลด</td>
                                                        <td>0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ค่าจัดส่ง</td>
                                                        <td></td>
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
                                                        <td colspan="2"><input type="checkbox" name="" id="vat" onchange="ChangeVat()" {{ $checked }} disabled> <label for="vat">ขอใบกำกับภาษี</label></td>
                                                        <!-- <td>{{ number_format(($price_total+$shipping_cost)*0.07,2) }}</td> -->
                                                    </tr>
                                                    <tr>
                                                        <td>ราคาสุทธิ</td>
                                                        <td>฿ {{number_format($totalPrice,2)}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        </div>

                    </div>
                </div>
                
                <div class="button-line mobile">
                    <div class="row">
                        <div class="col">
                            <a class="buttonBD" href="/">แก้ไขตะกร้าสินค้า</a>
                        </div>
                        <div class="col">
                            <button class="buttonBK gray" type="button" id="alert" style="border: unset;">ดำเนินการชำระเงิน</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
     
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
                    Swal.fire({
                    title: 'ระบบกำลังทำราย!',
                    html: 'กรุณารอสักครู่ระบบจะเสร็จภายใน<b></b>',
                    timer: 4000,
                    timerProgressBar: true,
                    didOpen: async () => {
                        Swal.showLoading();
                        const b = Swal.getHtmlContainer().querySelector('b');
                        const timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft();
                        }, 10);
                        
                        // รอให้ $('#shippingForm').submit(); เสร็จสิ้น
                        await $('#shippingForm').submit();

                        // Handle the timer expiration
                        Swal.get().then((modal) => {
                        modal.timer.then((time) => {
                            console.log('I was closed by the timer');
                            // หลังจากนับถอยหลังเสร็จสิ้น
                            // คุณสามารถทำการ reload หน้าเว็บหลังจากที่ส่งข้อมูลเสร็จสิ้นแล้ว
                            location.reload();
                        });
                        });
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                    });
                }
                })
            });
        });
    </script>
    @include('inc_topbutton')
    @include('inc_footer')
    
    <!-- SELECT2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    
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
    </script>
    
</body>
</html>