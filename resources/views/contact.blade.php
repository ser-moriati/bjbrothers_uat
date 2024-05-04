<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    <!-- FANCYBOX -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
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
                            <li>ติดต่อเรา</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                @include('inc_contact_submenu')
                
                <div id="contactPage"></div>
               
                <!---------- G O O G L E - M A P ---------->
                <div class="row">
                    <div class="col">
                        <div class="googlemap mb-5">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.6981266817183!2d100.40757671465333!3d13.676110990396488!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2bd6b07cb2d65%3A0x5e5f2322e9eb2ef5!2sCompany%20B.%20J.%20Brother%20%26%20SONS%20LTD.!5e0!3m2!1sen!2sth!4v1596272541445!5m2!1sen!2sth"frameborder="0" style="border:0;" allowfullscreen="" ></iframe>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!---------- C O N T A C T :: I N F O ---------->
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="row">
                            <div class="col">
                                <h2>ข้อมูลติดต่อ</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <ul class="contact-info">
                                    <li>
                                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                                        <div class="contact-detail two-line">
                                            <p>{{$contact->address}}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-icon"><i class="far fa-clock"></i></div>
                                        <div class="contact-detail">
                                            <p class="w-50">{{$contact->business_hours}}</p>
                                            <p class="w-50">&nbsp;</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                                        <div class="contact-detail two-line">
                                        <a href="tel:{{$contact->phone}}">
                                            <p>{{$contact->phone}}</p></a>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-icon"><i class="fas fa-mobile-alt"></i></div>
                                        <div class="contact-detail">
                                        <a href="tel:{{$contact->mobile_phone}}">{{$contact->mobile_phone}}</a>
                                       
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-icon"><i class="fas fa-fax"></i></div>
                                        <div class="contact-detail">
                                            <p>{{$contact->fax}}</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                                        <div class="contact-detail">
                                            <a href="mailto:{{$contact->email}}">{{$contact->email}}</a>
                                        </div>
                                    </li>
                                    @php
                                     $contact_social = DB::table('contact_social')->get();
                                     if($contact_social){
                                        foreach($contact_social as $contact_social){
                                    @endphp
                                    <li>
                                    <div class="contact-icon"><img src="{{URL::asset('upload/contact/'.$contact_social->contact_social_img)}}"></div>
                                        <div class="contact-detail">

                                            <p>{{$contact_social->contact_social_text}}</p>
                                            <a href="line:me/@bjbrothers">
                                            <div class="qr-code">
                                                <img src="{{URL::asset('upload/contact/'.$contact_social->contact_social_img1)}}">
                                            </div>
                                            </a>
                                        <div class="contact-detail">

                                    </div>
                                    </li>
                                    <br>
                                    
                                    @php
                                        }
                                                }    
                                                
                                     @endphp
                                  
                                    
                                    <li>
                                        <a data-fancybox="gallery" class="buttonBD" href="{{URL::asset('upload/contact/'.$contact->map_image)}}" ><i class="fas fa-map-marked-alt"></i>แผนที่</a>
                                    </li>
                                </ul>
                            </div>
                        </div>   
                    </div>
                    <!---------- C O N T A C T :: F R O M  ---------->
                    <div class="col-lg-6 col-md-12 col-12">
                    <form name="myform"  id="myForm" action="{{ url('contact/send-mail') }}" method="post" enctype="multipart/form-data"  onsubmit="return testDupes();">
                    <!-- <form name="myform"  id="myForm"  action="{{url('contact/send-mail')}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data" onsubmit="return testDupes();"> -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="doubleBox-BD">
                            <div class="doubleBox more-pad">
                                <div class="row">
                                    <div class="col">
                                        <h2 class="text-center">ฟอร์มติดต่อ</h2>
                                    </div>
                                </div>
                                <div class="input-form">
                                    <div class="row">
                                        <div class="col">
                                            <p>ชื่อ-นามสกุล</p>
                                            <input type="text" name="name" id="name"  class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>อีเมล</p>
                                            <input type="email" name="email" id="email" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>เบอร์โทรศัพท์</p>
                                            <input type="text" name="phone" id="phone" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>หัวข้อ</p>
                                            <input type="text" name="head_text" id="head_text" class="form-control shadow-none">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p>ข้อความ</p>
                                            <textarea  name = "details" id="details" class="form-control shadow-none"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                        <div class="g-recaptcha" data-sitekey="6LcQAXEoAAAAAMNDgZCgBp_q2sYxEa1eMd6eAXuk"></div>
                                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                        <br>

                                            <button type="button"  class="btn buttonBK" onclick="myFunction()">ยืนยัน</button>
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
    </div>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
   function onSubmit(token) {
            var name    = $('#name').val();
            var email   = $('#email').val();
            var phone   = $('#phone').val();
            var head_text    = $('#head_text').val();
            var details      = $('#details').val();
            var $recaptcha   =  $("#g-recaptcha-response").val();    
            if(name == ''){
                alert('กรุณากรอกส่วนชื่อ-นามสกุล')
            }else{
                if(email == ''){
                    alert('กรุณากรอกEmail')
                }else{
                    if(phone == ''){
                    alert('กรุณากรอกเบอร์โทรศัพท์')
                    }else{
                        if(head_text == ''){
                            alert('กรุณากรอกหัวข้อ')
                        }else{
                            if(details == ''){
                            alert('กรุณากรอกข้อความ')
                            }else{
                                
                            }
                        }
                    }
                }
            }
   }
 </script>
    @include('inc_topbutton')
    @include('inc_footer')
    <script language="javascript">
        function myFunction() {
            var name    = $('#name').val();
            var email   = $('#email').val();
            var phone   = $('#phone').val();
            var head_text    = $('#head_text').val();
            var details      = $('#details').val();
            var $recaptcha   =  $("#g-recaptcha-response").val();    
            if(name == ''){
                alert('กรุณากรอกส่วนชื่อ-นามสกุล')
            }else{
                if(email == ''){
                    alert('กรุณากรอกEmail')
                }else{
                    if(phone == ''){
                    alert('กรุณากรอกเบอร์โทรศัพท์')
                    }else{
                        if(head_text == ''){
                        alert('กรุณากรอกหัวข้อ')
                        }else{
                            if(details == ''){
                            alert('กรุณากรอกข้อความ')
                            }else{
                                if($recaptcha === ''){
                                    alert("กรุณาเลือกฉันไม่ใช่โปรแกรมอัตโนมัติ"); // เพิ่มการแจ้งเตือน
                                    return false; // ยกเลิกการ submit
                                }else{
                                    document.getElementById("myForm").submit(); 
                                }
                              
                            }
                        }
                    }
                }
            }
        }
    </script>
    <!-- FANCYBOX -->
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
   
    
</body>
</html>