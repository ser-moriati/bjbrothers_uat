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
                            <li>เกี่ยวกับเรา</li>
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
                @include('inc_about_submenu')
                
                <div id="holidayPage"></div>
               
                <!---------- V A C A T I O N ---------->
                <div class="row" id="aboutus">
                    <div class="col">

                        <h2 class="text-center mt-3 mb-5">วันหยุดประจำปี <?php 
$date = (date("Y")+543);
 echo $date; ?></h2>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6 col-md-10 col-12 offset-lg-0 offset-md-1">
                        <div class="img-width mb-4"><img src="{{URL::asset('upload/about/holiday/'.$holiday->about_holiday_image)}}"></div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="vacationTB">
                            <table style="width:100%">
                                <tr>
                                    <th>วันหยุด</th>
                                    <th>วันที่</th>
                                </tr>
                                @php 
                                $count = DB::table('about_holidaysdate')->count();
                                    if($count == '0'){
                                    }else{
                                    $about_holidaysdate = DB::table('about_holidaysdate')->orderBy('about_holidaysdate_id')->get();
                                        if($about_holidaysdate){
                                @endphp
                                        @foreach ($about_holidaysdate as  $item)
                                        <tr>
                                            <td>{{$item->about_holidaysdate_name}}</td>
                                            <td>{{$item->about_holidaysdate_date}}</td>
                                        </tr>
                                        @endforeach
                                @php
                                        }
                                    }
                                @endphp 
                            </table>
                        </div>
                    </div>
                </div>    
                                
            </div>
                
        </div>
    </div>
    @include('inc_topbutton')
    @include('inc_footer')
    
</body>
</html>