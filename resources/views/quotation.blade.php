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
                            <li>ขอใบเสนอราคา</li>
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
                <div class="row">
                    <div class="col-lg-10 col-12 offset-lg-1">
                        <div class="quotation-header">
                            <div class="row">
                                <div class="col">
                                    <h1 class="EngSM">QUOTATION</h1>
                                </div>
                                <div class="col">
                                <h5> @php 
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
                                    <div class="col-5">รายการสินค้า</div>
                                    <div class="col-2">จำนวน</div>
                                    <div class="col-4">หมายเหตุ</div>
                                </div>
                            </div>
                            <div class="mobile">
                                <div class="row">
                                    <div class="col-5 col-md-5">PRODUCT</div>
                                    <div class="col-7 col-md-7">DETAIL</div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-body quotation">
                            <!----- PRODUCT 01 ----->
                            
                            @php
                                $price_total = 0;
                            @endphp
                            @if (@$quotation_cartt)
                                @foreach ($quotation_cartt as $key => $quotation)  
                                    @php
                                    $sumselected_products = DB::table('carts')->selectRaw('carts.*, products.id as product_id, products.product_name, products.product_weight*carts.qty as weight, products.product_image, products.product_code, products.product_price, productsku.price_1,productsku.price_2,productsku.price_3,productsku.price_0, productsku.name_th, productsku.product_SKU, productsku.product_qty')
                                    ->leftJoin('products','products.id','=','carts.ref_product_id')
                                    ->leftJoin('productsku','productsku.id','=','carts.productskusizes_id')
                                    ->where('carts.id', $quotation)->first();

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
                                    
                                
                                        <div class="cartPage-product">
                                            <div class="row">
                                                <!-- ORDER -->
                                                <div class="col-lg-1 col-md-1 col-1 list">{{$key+1}}</div>

                                                <!-- IMAGE -->
                                                <div class="col-lg-2 col-md-3 col-4">
                                                    <div class="img-width w-BD"><img src="{{URL::asset('upload/product/'.$itemm->product_image)}}"></div>
                                                </div>

                                                <!-- PRODUCT INFO -->
                                                <div class="col-lg-3 col-md-8 col-6">
                                                    <div class="productCart-info">
                                                        <ul>
                                                        <li>SKU : {{$sumselected_products->product_SKU}}</li>
                                                        <li>Color :{{$words[0]}}</li>
                                                        <li>Size :{{$words[1]}}</li>
                                                            <li>{{$sumselected_products->product_name}}</li>
                                          
                                                            
                                                            <li>$sumselected_products->qty</li>
                                                        </ul>

                                                        <!-- QUANTITY :: MOBILE -->
                                                        <div class="sp-quantity mobile">
                                                            <div class="sp-minus btnquantity" id="bb"><i class="fas fa-minus"></i></div>
                                                            <div class="sp-input">
                                                                <input type="text" class="quntity-input " ids="{{$quotation['id']}}" oninput="updateQuotationCart({{$quotation['id']}},this.value)" value="{{$quotation['qty']}}" />
                                                            </div>
                                                            <div class="sp-plus btnquantity" id="bb"><i class="fas fa-plus"></i></div>
                                                        </div>

                                                        <!-- REMOVE BUTTON -->
                                                        <button class="remove btn" onclick="removeQuotationCartt({{$itemm->id}})">Remove Item</button>
                                                    </div>
                                                </div>

                                                <!-- AMOUNT -->
                                                <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block qty">
                                                    <div class="content-center">
                                                        <div class="sp-quantity">
                                                            <div class="sp-minus btnquantity" id="bb"><i class="fas fa-minus"></i></div>
                                                            <div class="sp-input">
                                                                <input type="text" ids="{{$quotation['id']}}" oninput="updateQuotationCart({{$quotation['id']}},this.value)" class="quntity-input" value="{{$quotation['qty']}}" />
                                                            </div>
                                                            <div class="sp-plus btnquantity" id="bb"><i class="fas fa-plus"></i></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- NOTE -->
                                                <div class="col-lg-4 col-md-9 d-none d-md-none d-lg-block">
                                                    <div class="input-form">
                                                        <p class="mobile">หมายเหตุ</p>
                                                        <textarea class="form-control shadow-none"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                @endforeach
                            @endif    
                            @if (@$quotation_cart)
                                
                            @foreach ($quotation_cart as $k => $item)  
                            <div class="cartPage-product">
                                <div class="row">
                                    <!-- ORDER -->
                                    <div class="col-lg-1 col-md-1 col-1 list">{{$two+$k+1}}</div>

                                    <!-- IMAGE -->
                                    <div class="col-lg-2 col-md-3 col-4">
                                        <div class="img-width w-BD"><img src="{{URL::asset('upload/product/'.$item->product_image)}}"></div>
                                    </div>

                                    <!-- PRODUCT INFO -->
                                    <div class="col-lg-3 col-md-8 col-6">
                                        <div class="productCart-info">
                                            <ul>
                                                <li>{{$item->product_code}}</li>
                                                <li>{{$item->product_name}}</li>
                                                <li>Color : {{$item->color_name}}</li>
                                                <li>Size : {{$item->size_name}}</li>
                                                
                                                <li>Size : {{$item->qty}}</li>
                                            </ul>

                                            <!-- QUANTITY :: MOBILE -->
                                            <div class="sp-quantity mobile">
                                                <div class="sp-minus btnquantity"><i class="fas fa-minus"></i></div>
                                                <div class="sp-input">
                                                    <input type="text" class="quntity-input" ids="{{$item->id}}" oninput="updateQuotationCart({{$item->id}},this.value)" value="{{$item->qty}}" />
                                                </div>
                                                <div class="sp-plus btnquantity "><i class="fas fa-plus"></i></div>
                                            </div>

                                            <!-- REMOVE BUTTON -->
                                            <button class="remove btn" onclick="removeQuotationCart({{$item->id}})">Remove Item</button>
                                        </div>
                                    </div>

                                    <!-- AMOUNT -->
                                    <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block qty">
                                        <div class="content-center">
                                            <div class="sp-quantity">
                                                <div class="sp-minus btnquantity"><i class="fas fa-minus"></i></div>
                                                <div class="sp-input">
                                                    <input type="text" ids="{{$item->id}}" oninput="updateQuotationCart({{$item->id}},this.value)" class="quntity-input" value="{{$item->qty}}" />
                                                </div>
                                                <div class="sp-plus btnquantity"><i class="fas fa-plus"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- NOTE -->
                                    <div class="col-lg-4 col-md-9 d-none d-md-none d-lg-block">
                                        <div class="input-form">
                                            <p class="mobile">หมายเหตุ</p>
                                            <textarea class="form-control shadow-none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            <!-- <div class="input-form mt-4">
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <p>ชื่อ<span class="required">*</span></p>
                                        <input type="text" name="member_firstname" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <p>นามสกุล<span class="required">*</span></p>
                                        <input type="text" name="member_lastname" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <p>อีเมล<span class="required">*</span></p>
                                        <input type="member_email" name="member_email" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <p>เบอร์โทรศัพท์<span class="required">*</span></p>
                                        <input type="text" name="member_phone" class="form-control shadow-none" required>
                                    </div>
                                    
                                </div> -->
                                <!-- <div class="input-form my-4">
                                    
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p>ที่อยู่<span class="required">*</span></p>
                                            <textarea name="company_addr" class="form-control shadow-none" required></textarea>
                                        </div>
                                        <div class="col-lg-6 row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                            <p>ภาค<span class="required">*</span></p>
                                            <div class="select2-part">
                                                <select class="js-example-basic-single form-control shadow-none" onchange="getProvince(this.value)" name="ref_geographie_id" required>
                                                    <option value="">เลือก</option>
                                                    @foreach($geographie as $geog)
                                                        <option value="{{$geog->id}}">{{$geog->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <p>จังหวัด<span class="required">*</span></p>
                                            <div class="select2-part">
                                                <select class="js-example-basic-single form-control shadow-none" onchange="getAmphures(this.value)" name="ref_province_id" id="province" required>
                                                    <option value="">เลือก</option>
                                                    @foreach($province as $prov)
                                                        <option value="{{$prov->id}}">{{$prov->name_th}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <p>เขต/อำเภอ<span class="required">*</span></p>
                                            <div class="select2-part">
                                                <select class="js-example-basic-single form-control shadow-none" onchange="getDistrict(this.value)" name="ref_amphures_id" id="amphures" required>
                                                    <option value="">เลือก</option>
                                                    @foreach($amphures as $amph)
                                                        <option value="{{$amph->id}}">{{$amph->name_th}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <p>แขวง/ตำบล<span class="required">*</span></p>
                                            <div class="select2-part">
                                                <select class="js-example-basic-single form-control shadow-none" name="ref_district_id" onchange="getZipcode(this.value)" id="district" required>
                                                    <option value="">เลือก</option>
                                                    @foreach($district as $distr)
                                                        <option value="{{$distr->id}}">{{$distr->name_th}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            รหัสไปรษณีย์
                                            <input type="text" name="zipcode" id="zipcode" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div> -->
                            @endif



                        </div>

                        <div class="button-line">
                            <div class="row">
                                <div class="col">
                                    <a class="buttonBD" href="/newarrival">เลือกดูสินค้าเพิ่มเติม</a>
                                </div>
                                <div class="col">
                                @if(@Auth::guard('member')->user()->id)
                                    <a class="buttonBK gray" href="/quotation_cus/conclude">ดำเนินการต่อ</a>
                                @else
                                    <a class="buttonBK gray" href="/login">ดำเนินการต่อ</a>
                                @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton');
    @include('inc_footer');
    
    <script>
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
                updateQuotationCart(id, newVal)
                $button.closest('.sp-quantity').find("input.quntity-input").val(newVal);
            });
        });

        $(document).ready(function() {
            $("#bb").on("click", function () {
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
                updateQuotationCart(id, newVal)
                $button.closest('.sp-quantity').find("input.quntity-input").val(newVal);
            });
        });

        function removeQuotationCartt(id){
            $.ajax({
                type: "POST",
                url: "/quotation_cus/remove",
                data: {_token: "{{ csrf_token() }}", id: id},
                success: function( result ) {
                    location.reload();

                },error : function(e){
                    console.log(e)
                }
            });
        }
        function removeQuotationCart(id){
            $.ajax({
                type: "POST",
                url: "/quotation/remove",
                data: {_token: "{{ csrf_token() }}", id: id},
                success: function( result ) {
                    location.reload();

                },error : function(e){
                    console.log(e)
                }
            });
        }
        function updateQuotationCart(id, newVal){
            if(newVal == '' && newVal == 0){
                
            }
                $.ajax({
                    type: "POST",
                    url: "/quotation_cus/update",
                    data: {_token: "{{ csrf_token() }}", id: id, qty: newVal},
                    success: function( result ) {
                        // location.reload();

                    },error : function(e){
                        // location.reload();
                        console.log(e)
                    }
                });
        }
        
    </script>
    <script>
        function getProvince(id){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getProvince/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.name_th+'</option>';
                        });
                        $('#province').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getAmphures(id){
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
                        $('#amphures').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getDistrict(id){
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
                        $('#district').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
        function getZipcode(id){
            var u = '<option value="">เลือก</option>';
                $.ajax({
                    type: "GET",
                    url: "province/getZipcode/"+id,
                    success: function( result ) {
                        $('#zipcode').val(result);
                    },error : function(e){
                        console.log(e)
                    }
                });
        }
    </script>
    
</body>
</html>