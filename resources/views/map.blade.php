<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    @php $contactName="map" @endphp
    <!-- FANCYBOX -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
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
                
                <div id="mapPage"></div>
                
                <div class="row">
                    <div class="col">
                        <h2 class="text-center mb-4">แผนที่</h2>
                    </div>
                </div>
               
                <!---------- G O O G L E - M A P ---------->
                <div class="row">
                    <div class="col">
                        <div class="googlemap w-BD mb-5">
                            <iframe src="{{ $detail->detail }}" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                        </div>
                    </div>
                </div>
                
                <!---------- H O W - T O - T R A V E L ---------->
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <a data-fancybox="gallery" class="img-width mb-5" href="upload/about/{{ $detail->image }}"><img src="{{URL::asset('upload/about/'.$detail->image)}}"></a>
                    </div>
                </div>
                
                <!---------- H O W - T O - T R A V E L ---------->
                <div class="row">
                    <div class="col">
                        <div class="text-center">
                            <h2>วิธีการเดินทางมาบริษัท</h2>
                            <div class="txt-content">
                                <p>วิธีการเข้ามาติดต่อที่บริษัท สามารถเข้ามาได้สองเส้นทางคือทางถนน <span>กาญจนาภิเษก</span> และ <span>เส้นถนนเอกชัย</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="route-acc">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <!-- ROUTE :: 01 -->
                                    @foreach ($map as $m)
                                        
                                        <div class="panel-heading" role="tab">
                                            <div class="row">
                                                <div class="col">
                                                    <a id="route01" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$m->id}}" aria-expanded="true" aria-controls="collapse{{$m->id}}">{{ $m->name }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapse{{$m->id}}" class="panel-collapse collapse" role="tabpanel">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-lg-10 col-md-10 col-12 offset-lg-1 offset-md-1">
                                                        {!! str_replace('<h6>','<div style="display: flex;">',$m->detail) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <!-- ROUTE :: 02 -->
                                    {{-- <div class="panel-heading" role="tab">
                                        <div class="row">
                                            <div class="col">
                                                <a id="route02" data-toggle="collapse" data-parent="#accordion" href="#collapse02" aria-expanded="true" aria-controls="collapse02">ทางถนนเอกชัย</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="collapse02" class="panel-collapse collapse" role="tabpanel">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-10 col-md-10 col-12 offset-lg-1 offset-md-1">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="txt-content">
                                                                <p>1. หน้าปากซอยจะมี 7-ELEVEN และวินมอเตอร์ไซค์ ตรงเข้ามา</p>
                                                            </div>
                                                            <div class="img-width mb-5"><img src="{{URL::asset('images/contact/map-R201.jpg')}}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="txt-content">
                                                                <p>2. ระหว่างทางจะพบโลตัส เอ็กเพรส ตรงมา เกือบสุดซอยจะพบป้าย เลี้ยวซ้าย</p>
                                                            </div>
                                                            <div class="img-width mb-2"><img src="{{URL::asset('images/contact/map-R202-1.jpg')}}"></div>
                                                            <div class="img-width mb-5"><img src="{{URL::asset('images/contact/map-R202-2.jpg')}}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="txt-content">
                                                                <p>3. ตรงมาสุดทางเจอแยก เลี้ยวขวา จะพบศาลพระภูมิ เลี้ยวซ้าย</p>
                                                            </div>
                                                            <div class="img-width mb-2"><img src="{{URL::asset('images/contact/map-R203-1.jpg')}}"></div>
                                                            <div class="img-width mb-5"><img src="{{URL::asset('images/contact/map-R203-2.jpg')}}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="txt-content">
                                                                <p>4. เลยมานิดเดียวจะเจอซอยเอกชัย 76 แยก 1-3-2 (ซอย 7) เลี้ยวขวา 50 เมตร บริษัทอยู่ซ้ายมือ</p>
                                                            </div>
                                                            <div class="img-width mb-2"><img src="{{URL::asset('images/contact/map-R204-1.jpg')}}"></div>
                                                            <div class="img-width"><img src="{{URL::asset('images/contact/map-R204-2.jpg')}}"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                     </div>
                                    </div> --}}



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
    
    <!-- FANCYBOX -->
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    
    <script type="text/javascript">
        // collapse //
        $(document).ready(function() {
            $('.collapse.in').prev('.panel-heading').addClass('active');
            $('#accordion')
                .on('show.bs.collapse', function(a) {
                $(a.target).prev('.panel-heading').addClass('active');
                $('#route01').attr('class');
                $('#route02').attr('class');
            })
                .on('hide.bs.collapse', function(a) {
                $(a.target).prev('.panel-heading').removeClass('active');
                $('#route01').attr('class');
                $('#route02').attr('class');
            });
        });
    </script>
    
</body>
</html>