<!-- mCustomScrollbar -->
<link rel="stylesheet" href="/mCustomScrollbar/jquery.mCustomScrollbar.css">
<script src="/mCustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>

    {{-- ///////////////////////////////////////////////////////////////////////// --}}
    <style>
        .accordion {
            background-color: #747474;
            color: #fff;
            cursor: pointer;
            padding: 7px 25px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
          }
          
          .accordion:hover {
            background-color: #ccc; 
          }
          
          .panel {
            padding: 0 0;
            display: none;
            background-color: white;
            overflow: hidden;
          }
          .sub_cate{
            color: inherit;
            padding: 4px 0px 5px 29px;
            border: 1px solid #efefef;
            font-size: 15px;
          }
          .active_subcate, .sub_cate:hover{
            color: inherit;
            background-color: #ccc; 
          }
          </style>
        {{-- <div class="col-sm-3"> --}}
            @foreach ($categorys as $cate)
            @if(@$sub_category)
                <button class="accordion">{{$cate->category_name}} <i class="fa fa-caret-down"></i></button>
                <div class="panel" @if(@$category->category_name == $cate->category_name) style="display: block;" @endif>
                    @foreach ($sub_category as $sub1)
                    @if ($sub1->ref_category_id != $cate->id)
                        @php
                            continue;
                        @endphp
                    @endif
                    <a class="sub_cate  @if($sub1->sub_category_name == @$sub_first->sub_category_name)
                    active_subcate  
                    @endif
                    " href="{{url('subcategory/'.$sub1->sub_category_name)}}" style="font-size: small !important;">
                        {{iconv_substr($sub1->sub_category_code.' : '.$sub1->sub_category_name, 0, 60, "UTF-8")}}
                    </a>
                    @endforeach
                </div>
            @endif
            @endforeach

        {{-- </div> --}}
          
          
          <script>
          var acc = document.getElementsByClassName("accordion");
          var i;
          
          for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
              this.classList.toggle("active");
              var panel = this.nextElementSibling;
              if (panel.style.display === "block") {
                panel.style.display = "none";
              } else {
                panel.style.display = "block";
              }
            });
          }
          </script>
    
    
        {{-- ///////////////////////////////////////////////////////////////////////// --}}
<!---------- SEARCH FOR PC ---------->
{{-- <div class="mobile-none">
    <div class="row">
        <!-- CATEGORY -->
        <div class="col-lg-3 col-md-6 col-12">
            <div class="dropdown productDropdown">
                <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if(@$category->category_name){{$category->category_name}} @else category @endif</button>
                <div class="dropdown-menu content mCustomScrollbar" data-mcs-theme="dark-thin" aria-labelledby="category">
                    @foreach ($categorys as $cate)
                    <a class="dropdown-item" href="{{url('category/'.$cate->category_name)}}">{{$cate->category_name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- SUB CATEGORY -->
        <div class="col-lg-5 col-md-6 col-12" @if(!@$sub_category) style="pointer-events:none;opacity: 0.4;" data-toggle="tooltip" data-placement="top" data-original-title="กรุณาเลือก Category ก่อน" @endif>
            <div class="dropdown productDropdown">
                @if(@$sub_category) 
                    <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="sub-category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if(@$sub_first->sub_category_name) {{iconv_substr($sub_first->sub_category_code.' : '.$sub_first->sub_category_name, 0, 50, "UTF-8")}} @else sub category @endif</button>
                    <div class="dropdown-menu content mCustomScrollbar" data-mcs-theme="dark-thin" aria-labelledby="sub-category">
                            @foreach ($sub_category as $sub1)
                                <a class="dropdown-item" href="{{url('subcategory/'.$sub1->sub_category_name)}}">{{iconv_substr($sub1->sub_category_code.' : '.$sub1->sub_category_name, 0, 60, "UTF-8")}}</a>
                            @endforeach
                    </div>
                @else
                    <button class="btn btn-secondary dropdown-toggle shadow-none" type="button">กรุณาเลือก Category ก่อน</button>
                @endif
            </div>
        </div>
        <!-- BRAND -->
        <div class="col-lg-2 col-md-6 col-12" @if(!@$sub_first->id) style="pointer-events:none;opacity: 0.4;" @endif>
            <div class="dropdown productDropdown">
                <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="brand" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if(@$_GET['brand']){{$brand_first->brand_name}} @else brand @endif</button>
                <div class="dropdown-menu content mCustomScrollbar" data-mcs-theme="dark-thin" aria-labelledby="brand">
                    @foreach ($brand as $br)
                    <a class="dropdown-item" href="/subcategory/{{@$sub_first->sub_category_name}}?brand={{$br->id}}&sort={{@$_GET['sort']}}">{{$br->brand_name}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- SORT BY -->
        <div class="col-lg-2 col-md-6 col-12" @if(!@$sub_first->id) style="pointer-events:none;opacity: 0.4;" @endif>
            <div class="dropdown productDropdown">
                <button class="btn btn-secondary dropdown-toggle shadow-none" type="button" id="sort-by" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@if(@$_GET['sort']){{$_GET['sort']}} @else sort-by @endif</button>
                <div class="dropdown-menu content mCustomScrollbar" data-mcs-theme="dark-thin" aria-labelledby="sort-by">
                    <a class="dropdown-item" href="/subcategory/{{@$sub_first->sub_category_name}}?brand={{@$_GET['brand']}}&series_id=+{{@$_GET['series_id']}}&sort=name">Name</a>
                    <a class="dropdown-item" href="/subcategory/{{@$sub_first->sub_category_name}}?brand={{@$_GET['brand']}}&series_id=+{{@$_GET['series_id']}}&sort=latest">Latest</a>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!---------- SEARCH FOR MOBILE ---------->
{{-- <div class="mobile">
    <div class="row">
        <div class="col">
            <div class="product-acc">
                <ul>
                    <li>
                        <a><i class="fas fa-search"></i>ค้นหาสินค้าตามหมวด</a>
                        @foreach ($categorys as $cate2)
                            <ul class="sub-category">
                                <li class="cate-name">{{$cate2->category_name}}</li>
                                @foreach ($cate2->sub_category as $sub2)
                                    <li><a href="{{url('subcategory/'.$sub2->sub_category_name)}}">{{$sub2->sub_category_code}} : {{$sub2->sub_category_name}}</a></li>
                                @endforeach
                            </ul>
                        @endforeach

                        <ul>
                             <li>
                                <a>Brand</a>
                                <ul>
                                @foreach ($brand as $br)
                                    <li><a href="/subcategory/{{@$sub_first->sub_category_name}}?brand={{$br->id}}&sort={{@$_GET['sort']}}">{{$br->brand_name}}</a></li>
                                @endforeach
                                </ul>
                            </li>
                        </ul>
                        <ul>
                             <li>
                                <a>Sort-by</a>
                                <ul>
                                    <li><a href="/subcategory/{{@$sub_first->sub_category_name}}?brand={{@$_GET['brand']}}&series_id={{@$_GET['series_id']}}&sort=name">Name</a></li>
                                    <li><a href="/subcategory/{{@$sub_first->sub_category_name}}?brand={{@$_GET['brand']}}&series_id={{@$_GET['series_id']}}&sort=latest">Latest</a></li>
                                </ul>
                            </li>
                        </ul>
                            
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> --}}

<script>
    function findSeries(id){  
        // alert(5);
        window.location.href = "/subcategory/{{@$sub_first->sub_category_name}}?brand={{@$_GET['brand']}}&sort={{ @$_GET['sort'] }}&series_id="+id;
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".product-acc a").click(function() {
            var link = $(this);
            var closest_ul = link.closest("ul");
            var parallel_active_links = closest_ul.find(".active")
            var closest_li = link.closest("li");
            var link_status = closest_li.hasClass("active");
            var count = 0;

            closest_ul.find("ul").slideUp(function() {
                if (++count == closest_ul.find("ul").length)
                    parallel_active_links.removeClass("active");
            });

            if (!link_status) {
                closest_li.children("ul").slideDown();
                closest_li.addClass("active");
            }
        })
    })
</script>
    