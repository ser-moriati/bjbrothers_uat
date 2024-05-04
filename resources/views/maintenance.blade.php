<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @php
        $knowName="maintenance"; 
    @endphp
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
                            <li>เกร็ดความรู้ : Maintenance Tips</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---------- M A I N T E N A N C E - T I P S ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                @include('inc_knowledge_submenu')
                
                <div id="maintenancePage"></div>
               
                <div class="row">
                    <div class="col">
                        <h2 class="text-center mb-4">Maintenance Tips</h2>
                    </div>
                </div>
                
                <div class="box-padding">
                    <div class="row">
                        @foreach ($category as $cate)                            
                        <div class="col-lg-4 col-md-4 col-6">
                            <a class="knowBox" href="{{url('maintenance/cate/'.$cate->id)}}">
                                <div class="know-img"><img src="{{ asset('upload/maintenancecategory').'/'.$cate->maintenance_category_image }}"></div>
                                <div class="download-topic decor">
                                    <p>{{$cate->maintenance_category_name}}</p>
                                </div>
                            </a> 
                        </div>
                        @endforeach
                    </div>
                </div>
                <!--------------- P A G E --------------->
                <div class="w-100 mt-3">
                    <div class="row">
                        <div class="col">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    {{  $category->links() }}
                                </ul>
                            </nav>
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