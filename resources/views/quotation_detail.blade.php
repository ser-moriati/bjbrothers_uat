<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
</head>
<style>
  .order-product {
	height: 700px;
	overflow: scroll; /* showing scrollbars */

  }
</style>

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
                            <li><a href="/quotation">ขอใบเสนอราคา</a></li>
                            <li>สรุปรายการ</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- Q U O T A T I O N --------------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="quotation-header">
                    <div class="row">
                        <div class="col">
                            <h1 class="EngSM">QUOTATION</h1>
                        </div>
                        <div class="col">
                            <h5>
                                @php 
                               
                                if(@$quotation_cart){
                                    $one =count($quotation_cart);
                                }else{
                                    $one ='0';
                                }
                                $quotation['qty'] = 0;

                              
                                if(@$quotation_cartt){
                                    $two =count($quotation_cartt);
                                }else{
                                    $two ='0';
                                }
                                
                                
                                $countnum =  $one+$two;
                                echo  $countnum ;
                                @endphp รายการ</h5>
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
                        </div>
                    </div>
                    <div class="mobile">
                        <div class="row">
                            <div class="col-5 col-md-5">PRODUCT</div>
                            <div class="col-7 col-md-7">DETAIL</div>
                        </div>
                    </div>
                </div>
                <div class="cart-body quotation q-detail">
                    <form action="{{url ('/quotation/insert')}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="order-product" >
                            <div class="product-list">
                                @php
                                    $price_total = 0;
                                    $quotation['qty'] = 0;
                                @endphp
                                @if (Session::has('selected_products'))
                                    @foreach (Session::get('selected_products') as $key => $selected_products)
                                        @php
                                            $itemm = DB::table('carts')
                                            ->leftJoin('products','products.id','=','carts.ref_product_id')
                                            ->leftJoin('productsku','productsku.id','=','carts.productskusizes_id')
                                            ->where('carts.id', $selected_products)->first();
                                            $role_id = 01;
                                    if (@Auth::guard('member')->user()->ref_role_id) {
                                        $role_id = Auth::guard('member')->user()->ref_role_id;
                                    }
                                
                                    $role_name = DB::table('roles')->where('id', $role_id)->first();
                                    if($itemm){
                                            
                                            if($role_id = 1){
                                                $price = $itemm->price_1; 
                                            }elseif($role_id = 2){
                                                $price = $itemm->price_2;
                                            }elseif($role_id =3){
                                                $price = $itemm->price_3;
                                            }else{
                                                $price = $itemm->price_0;
                                            }
                                            $discount = $price;
                                      
                                    }
                                        @endphp           

                                        <!----- PRODUCT 02 ----->
                                        <div class="cartPage-product">
                                            <div class="row" >
                                                <!-- ORDER -->
                                                <div class="col-lg-1 col-md-1 col-1 list">{{ $key+1}}</div>

                                                <!-- IMAGE -->
                                                <div class="col-lg-1 col-md-3 col-3 img">
                                                    <div class="img-width"style="width: 70%;"><img src="{{URL::asset('upload/product/'.$itemm->product_image)}}"></div>
                                                </div>

                                                <!-- PRODUCT INFO -->
                                                <div class="col-lg-2 col-md-3 col-6">
                                                    <div class="productCart-info">
                                                        <ul>
                                                        <li>SKU : @php $productcode = DB::table('productsku')->where('id',$itemm->productskusizes_id)->first(); @endphp {{@$productcode->product_SKU}}</li>
                                                            <li>{{$itemm->product_name}}</li>
                                                         
                                                        <li>Color :@php $color = DB::table('productsoption1')->where('id',$itemm->ref_color_id)->first(); @endphp {{@$color->name_th}}</li>
                                                        <li>Size :@php $size = DB::table('productsoption2')->where('id',$itemm->ref_color_id)->first(); @endphp {{@$size->name_th}}</li>
                                                        </ul>item
                                                    </div>
                                                </div>
                                                <div class="col-md-5 col-12 mobile">
                                                    <div class="quotationCart-detail">
                                                        <div class="row">
                                                            <div class="col-4">จำนวน</div>
                                                            <div class="col-8">{{$itemm->qty}}</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4">ราคา</div>
                                                            <div class="col-8">
                                                                <div class="float-right">
                                                                   
                                                                        <div class="float-right">{{number_format($discount)}}</div>
                                                                       

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-4">ราคารวม</div>
                                                            <div class="col-8">{{number_format($discount*$itemm->qty)}}</div>
                                                        </div>
                                                    
                                                    </div>
                                                </div>

                                                <!-- AMOUNT -->
                                                <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">{{$itemm->qty}}</div>

                                                <!-- PRICE -->
                                              

                                                <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">{{number_format($discount)}}</div>
                                                
                                           
                                                
                                                <!-- TOTAL PRICE -->
                                                <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">{{number_format($discount*$itemm->qty)}}</div>
                                            </div>
                                        </div>
                                            @php
                                                $price_total = $price_total+($discount*$itemm->qty);
                                            @endphp
                        
                            
                                    @endforeach
                                @endif
                            </div>
                        </div>            
                        <div class="input-form">
                            <div class="row">
                                <div class="col">
                                    <p>หมายเหตุ (ถ้ามี)</p>
                                    <textarea name="remark" class="form-control shadow-none"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="accordion" align="left">
                            <!-- ADDRESS (Default) -->
                            <div class="row">
                                <div class="col">
                                    <div class="md-radio md-radio-inline radiocheck">
                                        <input id="add-1" type="radio" name="shipping" value="1" checked/>
                                        <label for="add-1">
                                            <p>ข้อมูลที่อยู่บริษัทเดิม</p>
                                        </label>
                                        <section>
                                            <div class="accBdbottom">
                                                <div class="form-input">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="address-default pl-4 ml-4 mt-1"> {{$current_shipping}}</div>
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
                                            <p>เพิ่มที่อยู่บริษัทใหม่</p> 
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
                            
                            <!-- BILLING -->
                            <div class="shipping-subtopic">
                                <div class="row">
                                                    
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="receipt" class="custom-control-input checkboxsw" id="switch" checked value="1">
                                                <label class="custom-control-label" for="switch">รายละเอียดการจัดส่งใบเสนอราคา  ใช้ที่อยู่เดียวกับที่อยู่บริษัท ?</label>
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

                                 </div>
                                    <div class="w-100">
                                        <div class="row">
                                            <div class="col">
                                                <div class="summary-order-total">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>ราคารวม</td>
                                                                <td>฿ {{number_format($price_total)}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>

                                </div>

                                <div class="button-line">
                                    <div class="row">
                                        <div class="col">
                                            <a class="buttonBD" href="/quotation">แก้ไขรายการ</a>
                                        </div>
                                        <div class="col">
                                            <button class="buttonBK gray" style="border: unset;">ยืนยันรายการ</button>
                                        </div>
                                    </div>
                                </div>
                  </form>

                </div>
        </div>
    </div>
    
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
    <script type="text/javascript">
        function getAmphures(id, e){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "/province/getAmphures/"+id,
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
                    url: "/province/getDistrict/"+id,
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
                    url: "/province/getZipcode/"+id,
                    success: function( result ) {
                        $('#'+e).val(result);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }

        function increaseValue() {
            var value = parseInt(document.getElementById('product1').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('product1').value = value;
        }

        function decreaseValue() {
            var value = parseInt(document.getElementById('product1').value, 10);
            value = isNaN(value) ? 0 : value;
            value < 2 ? value = 2 : '';
            value--;
            document.getElementById('product1').value = value;
        }

        function increaseValue2() {
            var value = parseInt(document.getElementById('product2').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('product2').value = value;
        }

        function decreaseValue2() {
            var value = parseInt(document.getElementById('product2').value, 10);
            value = isNaN(value) ? 0 : value;
            value < 2 ? value = 2 : '';
            value--;
            document.getElementById('product2').value = value;
        }
    </script>
    
</body>
</html>