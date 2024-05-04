<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <style>
  .checkbox-large {
    transform: scale(1.5); /* กำหนดขนาดของติ๊กเลือก */
  }
</style>
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
                            <li>ตะกร้าสินค้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- C A R T --------------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <h1 class="EngSM">CART</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-9 col-12">
                        <!--------------- SHIPPING --------------->
                        <div class="cartPage-header">
                            <div class="mobile-none">
                                <div class="row">
                                    <div class="col-6">รายการสินค้า</div>
                                    <div class="col-2">ราคา</div>
                                    <div class="col-2">จำนวน</div>
                                    <div class="col-2">ราคารวม</div>
                                </div>
                            </div>

                            <div class="mobile">
                                <div class="row">
                                    <div class="col-4 col-md-3">PRODUCT</div>
                                    <div class="col-8 col-md-9">DETAIL</div>
                                </div>
                            </div> 
                        </div>
                        <div class="cart-body">
                            <!----- PRODUCT 01 ----->
                            
                            @php
                                $price_total = 0;
                                if (Session::has('quotation_cart')) {
                                foreach (Session::get('quotation_cart') as $key => $quotation) {
                                    
                                    $cart = DB::table('products')->selectRaw('products.*, products.id as product_id, products.product_name, products.product_weight * 0 as weight, products.product_image, products.product_code, products.product_price, products.product_sale, colors.color_name, sizes.size_name')
                                    ->leftJoin('carts', 'products.id', '=', 'carts.ref_product_id')
                                    ->leftJoin('colors', 'colors.id', '=', 'carts.ref_color_id')
                                    ->leftJoin('sizes', 'sizes.id', '=', 'carts.ref_size_id')
                                    ->where('products.id', $quotation['id'])
                                    ->orderBy('id', 'DESC')
                                    ->get();

                                  
                            @endphp
                            @foreach ($cart as $item)                                
                            <div class="cartPage-product" id="cart{{$item->id}}">
                                <div class="row">
                                    <!-- PC :: REMOVE BUTTON -->
                                    @php
                                                    
                                                $checked_list = '';
                                                if(Session::get('list_cart') == $quotation['id']){
                                                   
                                                    $checked_list = 'checked';
                                                }
                                                @endphp
                                    <div class="col-lg-1 col-md-1 d-none d-sm-block">
                                          
                                    <input type="checkbox" name="list" id="list" class="remove btn checkbox-large" value="{{$item->product_code}}" onchange="Changesession()"  {{$checked_list}}>
                                    </div>
                                    <!-- IMAGE -->
                                    <div class="col-lg-2 col-md-3 col-4">
                                    <div class="img-width w-BD"><img src="{{URL::asset('upload/product/'.$item->product_image)}}"></div>
                                    </div>

                                    <!-- PRODUCT INFO -->
                                    <div class="col-lg-3 col-md-8 col-7">
                                        <div class="productCart-info">
                                            <ul>
                                                <li>{{$item->product_code}}</li>
                                                <li>{{$item->product_name}}</li>
                                                <li>Color : {{$item->color_name}}</li>
                                                <li>Size : {{$item->size_name}}</li>
                                                <li> <button class="remove btn" onclick="removeCart({{$item->id}})">Remove Item</button></li>
                                                <li class="mobile">
                                                    @if ($item->product_sale==0.00||$item->product_sale==0)                                                        
                                                        <div class="price">฿{{number_format($item->product_price)}}</div>
                                                        @php
                                                            $product_price = $item->product_price;
                                                        @endphp
                                                    @else
                                                        <div class="price full-price">฿{{number_format($item->product_price)}}</div>
                                                        <div class="price sale">฿{{number_format($item->product_sale)}}</div>
                                                        @php
                                                            $product_price = $item->product_sale; 
                                                        @endphp
                                                    @endif
                                                </li>
                                            </ul>

                                            <!-- QUANTITY :: MOBILE -->
                                            <div class="sp-quantity mobile">
                                                <div class="sp-minus btnquantity"><i class="fas fa-minus"></i></div>
                                                <div class="sp-input">
                                                    <input type="text" ids="{{$item->id}}" prices="{{@$product_price}}" oninput="updateCart({{$item->id}},{{@$product_price}},this.value)" class="quntity-input" value="{{$quotation['qty']}}" />
                                                </div>
                                                <div class="sp-plus btnquantity"><i class="fas fa-plus"></i></div>
                                            </div>

                                            {{-- <!-- REMOVE BUTTON -->
                                                
                                            <button class="remove btn" onclick="removeCart({{$item->id}})">Remove Item</button> --}}
                                        </div>
                                    </div>

                                    <!-- PRICE -->
                                    <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">
                                        @if ($item->product_sale==0.00||$item->product_sale==0)                                                        
                                            <div class="price">฿{{number_format($item->product_price)}}</div>
                                            @php
                                                $product_price = $item->product_price;
                                            @endphp
                                        @else
                                            <div class="price full-price">฿{{number_format($item->product_price)}}</div>
                                            <div class="price sale">฿{{number_format($item->product_sale)}}</div>
                                            @php
                                                $product_price = $item->product_sale; 
                                            @endphp
                                        @endif
                                    </div>

                                    <!-- AMOUNT -->
                                    <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block qty">
                                        <div class="content-center">
                                            <div class="sp-quantity">
                                                <div class="sp-minus btnquantity"><i class="fas fa-minus"></i></div>
                                                <div class="sp-input">
                                                <input type="text" ids="{{$item->id}}" prices="{{@$product_price}}" oninput="updateCart({{$item->id}},{{@$product_price}},this.value)" class="quntity-input" value="{{$quotation['qty']}}" />
                                                </div>
                                                <div class="sp-plus btnquantity"><i class="fas fa-plus"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TOTAL -->
                                    <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">
                                        <div class="price" id="priceAll{{$item->id}}">{{number_format($product_price*$quotation['qty'])}}</div>
                                    </div>

                                    <!-- MOBILE :: REMOVE BUTTON -->
                                    <div class="d-block d-sm-none">
                                    <input type="checkbox" name="example-checkbox" class="remove btn checkbox-large">
                                    </div>
                                </div>
                            </div>
                            @php
                                $price_total = $price_total+($product_price*$quotation['qty']);
                            @endphp
                            @endforeach
                            @php
                        }
                    }
                    @endphp

                        </div>
                   
                        <div class="button-line mobile-none">
                            <div class="row">
                                <div class="col">
                                    <a class="buttonBD" href="/newarrival">เลือกดูสินค้าเพิ่มเติม</a>
                                </div>
                              
                                <div class="col">
                                    <div class="row">
                                        <div class="col mb-2">
                                            <a class="buttonBK gray" href="/shipping_payment">
                                                <div class="content-center">
                                                    <div class="w-img">
                                                        <img src="/images/icon/icon-cart.svg">
                                                        <img src="/images/icon/icon-cartWH.svg">
                                                    </div>
                                                    ดำเนินการสั่งซื้อสินค้า
                                                </div>  
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="buttonBK gray" href="/quotation/conclude"><i class="fas fa-file-alt"></i>ดำเนินการขอใบเสนอราคา</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!--------------- ORDER SUMMARY --------------->
                    <div class="col-lg-3 col-12">
                        <div class="row">
                            <div class="col">
                                <div class="BK-topic">สรุปรายการสินค้า</div>
                            </div>
                        </div>
                        <div class="grayBox">   
                            <div class="row">
                                <div class="col">
                                    <div class="summary-order-total">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>ราคารวม</td>
                                                    <td id="tdPriceAll">{{@number_format($price_total)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>ค่าจัดส่ง</td>
                                                    <td>{{ $shipping_cost }}</td>
                                                </tr>
                                                <tr>
                                                    <td>ส่วนลด</td>
                                                    <td>0</td>
                                                </tr>
                                                <tr>
                                                @php
                                                    $vat = 0;
                                                    $checked = '';
                                                if($session_vat){
                                                    $vat = ($price_total+$shipping_cost)*0.07;
                                                    $checked = 'checked';
                                                }
                                                @endphp
                                                    <td><input type="checkbox" name="" id="vat" onchange="ChangeVat()" {{ $checked }}> <label for="vat">รวมราคาภาษี</label></td>
                                                    <td>{{ number_format(($price_total+$shipping_cost)*0.07,2) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>ราคาสุทธิ</td>
                                                    <td id="tdPriceAllTotal">฿ {{@number_format($price_total+$shipping_cost+$vat,2)}}</td>
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
                                                    url: "/cart/ChangeVat",
                                                    data: {_token: "{{ csrf_token() }}", check: check},
                                                    success: function( result ) {
                                                        location.reload();

                                                    },error : function(e){
                                                        console.log(e)
                                                    }
                                                });
                                            }
                                        </script>
                                               <script>
                                            function Changesession(){
                                                var check = 0;
                                                if($('#list').is(":checked")){
                                                    
                                                    var list = $('#list').val();
                                                    check = 1;
                                                }
                                                
                                                $.ajax({
                                                    type: "POST",
                                                    url: "cart_session/Changelist",
                                                    data: {_token: "{{ csrf_token() }}", check: check, list: list},
                                                    success: function( result ) {
                                                        location.reload();

                                                    },error : function(e){
                                                        alert(4);
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
                
                <div class="button-line mobile">
                    <div class="row">
                        <div class="col">
                            <a class="buttonBD" href="/newarrival">เลือกดูสินค้าเพิ่มเติม</a>
                        </div>
                        {{-- <div class="col">
                            <a class="buttonBK gray" href="/shipping_payment">ดำเนินการสั่งซื้อสินค้า</a>
                        </div> --}}
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col mb-3">
                                    <a class="buttonBK gray" href="shipping_payment" @if (count($cart)==0) style="pointer-events: none;opacity: 0.4;" @endif>
                                        <div class="content-center">
                                            <div class="w-img">
                                                <img src="/images/icon/icon-cart.svg">
                                                <img src="/images/icon/icon-cartWH.svg">
                                            </div>
                                            ดำเนินการสั่งซื้อสินค้า
                                        </div>  
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a class="buttonBK gray" href="/quotation/conclude"><i class="fas fa-file-alt"></i>ดำเนินการขอใบเสนอราคา</a>
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
                var price = $button.closest('.sp-quantity').find("input.quntity-input").attr('prices');
                // var oldPrice = price*oldValue;
                updateCart(id, price, newVal)
                $button.closest('.sp-quantity').find("input.quntity-input").val(newVal);
            });
        });
        function removeCart(id){
            
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
        function updateCart(id, price, newVal){
            if(newVal == '' && newVal == 0){
                
            }
                var tdPriceAll = $('#tdPriceAll').html();
                var oldPrice = $('#priceAll'+id).html();
                var allPrice = price*newVal;
                    tdPriceAll = tdPriceAll.replace(',','');
                    oldPrice = oldPrice.replace(',','');
                var newTdPriceAll = (tdPriceAll-oldPrice)+allPrice;
                $.ajax({
                    type: "POST",
                    url: "/cart/update",
                    data: {_token: "{{ csrf_token() }}", id: id, qty: newVal},
                    success: function( result ) {
                        // location.reload();
                        $('#priceAll'+id).html(allPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        $('#tdPriceAll').html(newTdPriceAll.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        $('#tdPriceAllTotal').html('฿ '+newTdPriceAll.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));

                    },error : function(e){
                        // location.reload();
                        console.log(e)
                    }
                });
        }
        // function updateCart(id,value){
        //     update(id, price, value)
            // $.ajax({
            //     type: "POST",
            //     url: "/cart/update",
            //     data: {_token: "{{ csrf_token() }}", id: id, qty: value},
            //     success: function( result ) {
            //         location.reload();

            //     },error : function(e){
            //         console.log(e)
            //     }
            // });
        // }
    </script>
    
</body>
</html>