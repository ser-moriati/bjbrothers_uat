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
                <div class="row">
                    <div class="col">
                        <h1 class="EngSM">ยกเลิกคำสั่งซื้อ</h1>
                    </div>
                </div>
            <form action="{{url('order/updatecancelConfirmPayment')}}" method="POST" enctype="multipart/form-data">
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
                                    <div class="col">
                                        <div class="file-input-wrapper mt-2">
                                        <p>สาเหตุ <span class="chackOrder"></span></p>
                                            <textarea id="Comment" name="Comment" rows="4"  class="form-control shadow-none"  required></textarea>
                                        </div>
                                    
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