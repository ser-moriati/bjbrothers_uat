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
                            <li><a href="/">หน้าแรก </a></li>
                            <li>ตะกร้าสินค้า</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--------------- C A R T --------------->
    <div class="content-padding">
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
                                    <div class="col-3" style="text-align: left; padding-left: 33px;">
                                        <input type="checkbox" id="checkAll">&nbsp;เลือกทั้งหมด
                                    </div>
                                    <div class="col-3">รายการสินค้า</div>
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
                            @endphp
                            @foreach ($cart as $item)         
                            @php $words = explode(" ",$item->name_th); @endphp                        
                            <div class="cartPage-product" id="cart{{$item->id}}">
                                <div class="row">
                                    <!-- PC :: REMOVE BUTTON -->
                                   
                                    <div class="col-lg-1 col-md-1 d-none d-sm-block">
                                    <input type="checkbox" name="selected_products[]" value="{{$item->id}}" @if(Session::has('selected_products')) <?php echo (in_array($item->id , Session::get('selected_products')) ? 'checked' : '' ); ?> @endif class="product-checkbox-pc">

                                    </div>
                                    <!-- IMAGE -->
                                    <div class="col-lg-2 col-md-3 col-4">
                                    <div class="img-width w-BD"><img src="{{URL::asset('upload/product/'.$item->product_image)}}"></div>
                                    </div>

                                    <!-- PRODUCT INFO -->
                                    <div class="col-lg-3 col-md-8 col-7">
                                        <div class="productCart-info">
                                            <ul>
                                            @php $head1 = DB::table("productsoptionhead")->where("product_id",$item->product_id)->where('option_type',1)->first(); @endphp
                                            @php $head2 = DB::table("productsoptionhead")->where("product_id",$item->product_id)->where('option_type',2)->first(); @endphp
                                                    <li>{{$item->product_name}}</li>
                                                    <li>{{ @$head1->name_th }} : {{ @$item->name_th1 }}</li>
                                                @if($head2)
                                                    <li>{{ @$head2->name_th  }} :  {{ @$item->name_th2 }} </li>
                                                @endif
                                                
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
                                                    <input type="text" ids="{{$item->id}}" prices="{{@$product_price}}" oninput="updateCart({{$item->id}},{{@$product_price}},this.value)" class="quntity-input" value="{{$item->qty}}" />
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
                                                <input type="text" ids="{{$item->id}}" prices="{{@$product_price}}" oninput="updateCart({{$item->id}},{{@$product_price}},this.value)" class="quntity-input" value="{{$item->qty}}" />
                                                </div>
                                                <div class="sp-plus btnquantity"><i class="fas fa-plus"></i></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TOTAL -->
                                    <div class="col-lg-2 col-md-9 d-none d-md-none d-lg-block">
                                        <div class="price" id="priceAll{{$item->id}}">{{number_format($product_price*$item->qty)}}</div>
                                        <i class="fa fa-trash" style="margin-top: 40px; cursor: pointer;" onclick="removeCart({{$item->id}})"></i>
                                    </div>

                                    <!-- MOBILE :: REMOVE BUTTON -->
                                    <div class="d-block d-sm-none">
                                    <input type="checkbox" name="selected_products[]" value="{{$item->id}}" @if(Session::has('selected_products'))  <?php echo (in_array($item->id , Session::get('selected_products')) ? 'checked' : '' ); ?> @endif class="product-checkbox-mb">
                                        <br><br>
                                        <i class="fa fa-trash" style="margin-top: 40px; cursor: pointer;" onclick="removeCart({{$item->id}})"></i>

                                    </div>
                                </div>
                            </div>
                            @php
                                
                            @endphp
                            @endforeach

                        </div>

                        <div class="button-line mobile-none">
                            <div class="row">
                                <div class="col">
                                    <a class="buttonBD" href="{{url('/newarrival')}}">เลือกดูสินค้าเพิ่มเติม</a>
                                </div>
                                {{-- <div class="col">
                                    <a class="buttonBK gray" href="/shipping_payment" @if (count($cart)==0) style="pointer-events: none;opacity: 0.4;" @endif>ดำเนินการสั่งซื้อสินค้า</a>
                                </div> --}}
                                <div class="col">
                                    <div class="row">
                                        <div class="col mb-2">
                                        <a id="cart" class="buttonBK gray" href="#">
                                            <div class="content-center">
                                                <div class="w-img">
                                                    <img src="/images/icon/icon-cart.svg" alt="Cart Icon">
                                                    <img src="/images/icon/icon-cartWH.svg" alt="Cart Icon White">
                                                </div>
                                                ดำเนินการสั่งซื้อสินค้า
                                            </div>
                                        </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a class="buttonBK gray" href="{{url('/quotation/conclude')}}"><i class="fas fa-file-alt"></i>ดำเนินการขอใบเสนอราคา</a>
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
                        @php
                        if (Session::has('selected_products')) {
                            foreach (Session::get('selected_products') as $key => $selected_products) {
                                $role_id = 0;
                                if (@Auth::guard('member')->user()->ref_role_id) {
                                    $role_id = Auth::guard('member')->user()->ref_role_id;
                                }
                                
                                $role_name = DB::table('roles')->where('id', $role_id)->first();
                                $price_total = 0;
                                $sumselected_products = DB::table('carts')->where('id', $selected_products)->first();
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
                                        $price_total += $discount * $sumselected_products->qty;
                                }
                               
                            }
                            
                        }
                        @endphp
                        <div class="grayBox">   
                            <div class="row">
                                <div class="col">
                                    <div class="summary-order-total">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td>ราคารวม</td>
                                                    <td id="tdPriceAll"><span  id="tdPriceAll"></span>{{@number_format($price_total)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>ค่าจัดส่ง</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>ส่วนลด</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                @php
                                                    $vat = 0;
                                                    $checked = '';
                                                if($session_vat){
                                                    $vat = ($price_total)*0.07;
                                                    $checked = 'checked';
                                                }
                                                @endphp
                                                    <td colspan="2"><input type="checkbox" name="" id="vat" onchange="ChangeVat()" {{ $checked }}> <label for="vat">ขอใบกำกับภาษี</label></td>
                                                    <!-- <td id="allPricevat">{{ number_format(($price_total)*0.07,2) }}</td> -->
                                                </tr>
                                                <tr>
                                                    <td>ราคา</td>
                                                    <td id="tdPriceAllTotal">฿ {{@number_format($price_total)}}</td>
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
                                                        var message = result.message;
                                                        var check = result.check;
                                                        if (check == 0) {
                                                            $('#tdPriceAllTotal').html('฿ ' + message.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                                                            
                                                        } else {
                                                            if(message != 0){     
                                                                var Vat = 0;
                                                                // var Vat = message * 0.07;
                                                                // var allPricevat = Vat.toFixed(2);
                                                                // $('#allPricevat').html(allPricevat.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));  
                                                                // var sumtotal = message  + parseFloat(allPricevat.replace(/,/g, '')) ;
                                                                // var alltotal = sumtotal.toFixed(2);
                                                                // $('#tdPriceAllTotal').html(alltotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                                                            }else{
                                                                var Vat = 0;
                                                            } 
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
                
                <div class="button-line mobile">
                    <div class="row">
                        <div class="col" style="margin-bottom: 15px;">
                            <a class="buttonBD" href="/newarrival">เลือกดูสินค้าเพิ่มเติม</a>
                        </div>
                        {{-- <div class="col">
                            <button id="myButton">คลิกฉัน</button>
                            <a class="buttonBK gray" href="/shipping_payment">ดำเนินการสั่งซื้อสินค้า</a>
                        </div> --}}
                        <div class="col-md-6 col-12">
                            <div class="row">
                                <div class="col mb-3">
                                    <a id="cart" class="buttonBK gray" href="#" @if (count($cart)==0) style="pointer-events: none;opacity: 0.4;" @endif>
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
                                    <a class="buttonBK gray" href="{{url('/quotation/conclude')}}"><i class="fas fa-file-alt"></i>ดำเนินการขอใบเสนอราคา</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

    </div>
    <form id="shippingForm" action="{{url('shipping_payment')}}" method="GET">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script>
    // หากมีการคลิกที่ช่อง "Check All"
    document.getElementById("checkAll").addEventListener("click", function() {
        // หากช่อง "Check All" ถูกเลือก
        if (this.checked) {
            // เลือกทุกช่องเลือกสินค้าในรายการ
            var productCheckboxes = document.querySelectorAll('.product-checkbox-pc');
            productCheckboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
        } else {
            // ยกเลิกการเลือกทุกช่องเลือกสินค้าในรายการ
            var productCheckboxes = document.querySelectorAll('.product-checkbox-pc');
            productCheckboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }
    });
</script>
    <script>
      $(document).ready(function() {
    $('#cart').click(function(event) {
        event.preventDefault(); // ป้องกันการเปลี่ยนหน้าเว็บเมื่อคลิกลิงก์

        var check = '1'; // กำหนดค่าของตัวแปร check ตรงนี้

        // ส่งคำขอ Ajax ไปยัง "/cart/checkprice"
        $.ajax({
            type: "POST",
            url: "{{url('/cart/checkprice')}}",
            data: {
                _token: "{{ csrf_token() }}",
                check: check
            },
            success: function(result) {
                if (result.message == 0) {
                    // แสดง SweetAlert2 หากมีข้อผิดพลาด
                    Swal.fire({
                        title: 'รายการสินค้าที่ไม่มีราคา ไม่สามารถทำรายการได้!!',
                        html: " รายการสินค้าของท่านไม่สามารถทำรายการสั่งซื้อได้ <br>กดยืนยันเพื่อกลับไปเลือกรายการสินค้าอีกครั้ง!",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ยืนยัน',
                        cancelButtonText: 'ยกเลิก',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // จะใส่โค้ดที่คุณต้องการในกรณีที่ผู้ใช้กดยืนยันที่นี่
                        }
                    });
                } else {
                    // ส่งคำขอ Ajax ไปยัง "/shipping_payment" หากไม่มีข้อผิดพลาด
                    $('#shippingForm').submit();
                }
            },
            error: function() {
                // ดำเนินการเมื่อเกิดข้อผิดพลาดในการส่งคำขอ
                console.log('เกิดข้อผิดพลาดในการส่งคำขอ');
            }
        });
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
<script>
    const selectedProductIds = [];

    function updateSelectedProducts(productId) {
        const index = selectedProductIds.indexOf(productId);
        if (index === -1) {
            selectedProductIds.push(productId);
        }
    }

    function removeSelectedProduct(productId) {
        const index = selectedProductIds.indexOf(productId);
        if (index !== -1) {
            selectedProductIds.splice(index, 1);
        }
    }

    function updateSession() {
        console.log(selectedProductIds);
        fetch('{{url('/update-session')}}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ selectedProductIds })
        })
        .then(response => response.json())
        .then(data => {
            $('#tdPriceAll').html(data.message);
            var check = 0;
            if($('#vat').is(":checked")){
                check = 1;
            }
            if(data.message != 0){     
                var Vat = 0;
            }else{
                var Vat = 0;
            }     
            var allPricevat = Vat.toFixed(2);
            $('#allPricevat').html(allPricevat.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));  
           
            if($('#vat').is(":checked")){                                                                                             
                var sumtotal =  parseFloat(data.message.replace(/,/g, ''))  + parseFloat(allPricevat.replace(/,/g, '')) ;
                $('#tdPriceAllTotal').html('฿ ' + sumtotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
            }else{          
            
                $('#tdPriceAllTotal').html('฿ ' + data.message);
            }
        })
        .catch(error => {
            console.error('ผิดพลาด:', error);
        });
    }

    // const checkboxes = document.querySelectorAll('.product-checkbox');

    $('#checkAll').click(function(){
        $('.product-checkbox-pc').each(function(){
            $(this).attr('checked');
            console.log('ID '+$(this).val()+' Checked : '+$(this).is(':checked'));
            const productId = parseInt($(this).val());
            if($(this).is(':checked')){
                updateSelectedProducts(productId);
            }else{
                removeSelectedProduct(productId);
            }
        });
        updateSession();
    });

    $('.product-checkbox-pc').click(function(){
        $('.product-checkbox-pc').each(function(){
            console.log('ID '+$(this).val()+' Checked : '+$(this).is(':checked'));
            const productId = parseInt($(this).val());
            if($(this).is(':checked')){
                updateSelectedProducts(productId);
            }else{
                removeSelectedProduct(productId);
            }
        });
        updateSession();
    });

    $('.product-checkbox-mb').click(function(){
        $('.product-checkbox-mb').each(function(){
            console.log('ID '+$(this).val()+' Checked : '+$(this).is(':checked'));
            const productId = parseInt($(this).val());
            if($(this).is(':checked')){
                updateSelectedProducts(productId);
            }else{
                removeSelectedProduct(productId);
            }
            updateSession();
        });
    });
    
    // checkboxes.forEach(checkbox => {
    //     checkbox.addEventListener('change', function() {
            
    //     });
    // });
    
   


</script>
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
                url: "{{url('/cart/remove')}}",
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
                    url: "{{url('/cart/update')}}",
                    data: {_token: "{{ csrf_token() }}", id: id, qty: newVal},
                    success: function( result ) {
                        // location.reload();
                        $('#priceAll'+id).html(allPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        $('#tdPriceAll').html(result.message); // ใช้ค่าที่ได้จาก response
                        $('#tdPriceAllTotal').html('฿ ' + result.message);
                        var check = 0;
                        if($('#vat').is(":checked")){
                            check = 1;
                        }
                        if(result.message != 0){     
                            var Vat = parseFloat(result.message.replace(/,/g, '')) * 0.07;
                        }else{
                            var Vat = 0;
                        }     
                            var allPricevat = Vat.toFixed(2);
                            $('#allPricevat').html(allPricevat.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));  
                            if($('#vat').is(":checked")){                                                                                             
                            var sumtotal =  parseFloat(result.message.replace(/,/g, ''))  + parseFloat(allPricevat.replace(/,/g, '')) ;
                            var alltotal = sumtotal.toFixed(2);
                            $('#tdPriceAllTotal').html(alltotal.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'));
                        }else{          
                            $('#tdPriceAllTotal').html('฿ ' + result.message);
                        }
                    },error : function(e){
                        // location.reload();
                        console.log(e)
                    }
                });
        }

    </script>
    
</body>
</html>