<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
@php
    $knowName="catalogue"; 
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
                            <li><a href="index.php">หน้าแรก</a></li>
                            <li>เกร็ดความรู้</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---------- E - C A T A L O U G E ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <!---------- S U B - M E N U ---------->
                @include('inc_knowledge_submenu')
                <div id="cataloguePage"></div>
               
                <!--<div class="row">
                    <div class="col">
                        <h2 class="text-center mb-4">E-Catalogue</h2>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-lg-9 col-md-8 col-12">
                        <h4 class="big">E-Catalogue</h4>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="dropdown productDropdown mb-5">
                            <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="sort-by" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$sort_default}}</button>
                            <div class="dropdown-menu" aria-labelledby="sort-by">
                                @foreach ($sort_list as $key => $sort_item)
                                    <a class="dropdown-item" href="?order_by={{$key}}">{{$sort_item['name']}}</a>
                                @endforeach
                                {{-- <a class="dropdown-item" href="?order_by=id&sort=asc">Oldest</a>
                                <a class="dropdown-item" href="?order_by=ecatalogue_image&sort=asc">Title</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="box-padding">
                    <div class="row">
                        @foreach ($ecatalogue as $item)
                        <div class="col-lg-4 col-md-4 col-6">
                            <a class="downloadBox" href="{{URL::asset('upload/ecatalogue/pdf/'.$item->ecatalogue_pdf_name)}}" target="_blank">
                                <div class="download-img" style="
                                background-image: url(<?php echo asset('upload/ecatalogue').'/'.$item->ecatalogue_image; ?>);
                                background-position: center;
                                background-size: cover;">
                                    <div class="hover-icon">
                                        <i class="fas fa-download"></i>
                                        <p>DOWNLOAD</p>
                                    </div>
                                </div>
                                <div class="download-topic">
                                    <p>{{$item->ecatalogue_title}} </p>
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
                                    {{  $ecatalogue->links() }}
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