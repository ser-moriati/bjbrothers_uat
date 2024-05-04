@extends('layouts.master')

@section('title') Home @endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<style>
    .search-box .form-control{
        padding-left:15px;
    }
    .search-box .search-icon {
        right: 13px;
        left: unset;
    }
</style>

@section('css') 

<!-- Lightbox css -->
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/magnific-popup/magnific-popup.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}">

@endsection

<div class="container-fluid">
<input type="hidden" id='token' value="{{ csrf_token() }}">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li> --}}
                        <?php if(isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <form id="promotionForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
            <div class="col-sm-12">
                <div class="form-group">
            <button class="btn btn-primary" id="submitBtn">Save</button>
                </div>
            </div>
            <div class="col-12">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                    <div class="custom-file">
                                        <input name="banner_name" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" @empty($row->banner_name) required @endempty >
                                        <label class="custom-file-label" for="customFile">@isset($row->banner_name) {{$row->banner_name}} @else Choose Picture @endisset</label>
                                    </div>
                                    <span class="required"> &nbsp; Suitable scale 1600 x 650 pixels</span>
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">Name image <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{pathinfo(@$row->banner_name, PATHINFO_FILENAME)}}" id="nameImg" name="banner_name_name" required>
                                    {{-- @if (@$row->product_image) readonly @endif  --}}
                                </div>
                                <div class="form-group">
                                    <img class="img-thumbnail imagePreview"@if(!isset($row->banner_name)) style="display: none;" @endif src="{{ URL::asset('upload/home/'.@$row->banner_name) }}" data-holder-rendered="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="homeVideo">Video <span class="required">*</span></label><span class="card-title-desc"> https://www.youtube.com/watch?v=</span><span style="color: red">QEB7wE-YFXg</span>
                                    <input type="text" name="video" onkeyup="changeVDO(this.value)" class="form-control" id="homeVideo" placeholder="QEB7wE-YFXg" value="{{@$row->video}}" required>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        {{-- <label for="homeVideo">&nbsp;</label> --}}
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="videoYoutube" class="embed-responsive-item" src="https://www.youtube.com/embed/{{@$row->video}}"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>
                                 
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label>Project</label>
                                            <select required name="promotion[]" id="promotion" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="search ...">
                                            @foreach ($news as $value)
                                                <option value="news|{{$value->id}}" @if (in_array($value->id,$news_array)) selected @endif>{{$value->title}}</option>
                                            @endforeach
                                            @foreach ($safety as $value)
                                                <option value="safety|{{$value->id}}" @if (in_array($value->id,$safety_array)) selected @endif>{{$value->safety_name}}</option>
                                            @endforeach 
                                            @foreach ($portfolio as $value)
                                                <option value="portfolio|{{$value->id}}" @if (in_array($value->id,$portfolio_array)) selected @endif><img src="/assets/images/flags/select2/tri.png" class="img-flag">{{$value->portfolio_image}}</option>
                                            @endforeach    
                                            </select>
                                        </div>
                                        {{-- @if (in_array($value->id,$pro_recom_array)) selected @endif --}}
                                    </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metatitle">Meta Title</label>
                                    <input id="metatitle" name="meta_title" type="text" placeholder="Detailed Title" class="form-control" value="{{@$seo->meta_title}}">
                                </div>
                                <div class="form-group">
                                    <label for="metakeywords">Meta Keywords</label>
                                    <input id="metakeywords" name="meta_keywords" type="text" placeholder="Detailed Keywords" class="form-control" value="{{@$seo->meta_keywords}}">
                                </div>
                            </div>
        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metadescription">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Meta Description" rows="5">{{@$seo->meta_description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>       
            </div>
            <div class="col-sm-12">
                <div class="form-group">
            <button class="btn btn-primary" id="submitBtn">Save</button>
                </div>
            </div>
        </form>
    </div>
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
        <script>
            function promotionSelect(){
                var id = $('#promotion').val();
                console.log(id);
                $.ajax({
                    type: "POST",
                    url: "{{$module}}/select_promotion",
                    data:{
                        id:id,
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function( result ) {
                        var tr = '';
                        result.forEach(element => {
                            tr += '<tr><td><img width="50" src="{{ URL::asset("upload/promotion")}}/'+element.promotion_image+'"></td><td>'+element.promotion_code+'</td><td>'+element.promotion_name+'</td><td>'+element.promotion_price+'</td></tr>';
                        });
                        $('#listProduct').html(tr);
                            // total();
                        }   
                    });
            }
            function changeVDO(t) {
                $("#videoYoutube").attr("src", "https://www.youtube.com/embed/"+t);
            }
            
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    $('.imagePreview').show();
                    reader.onload = function(e) {
                    $('.imagePreview').attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            function imgChange(t) {
                const size =  
                        (t.files[0].size / 1024 / 1024).toFixed(2); 

                    if (size > 2) { 
                        $('#customFile').val(null);
                         alert("The image size must not exceed 2 MB."); 
                         return false;
                    }
                readURL(t);
            }
        </script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection