@extends('layouts.master')

@section('title') Product @endsection

@section('css') 

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css')}}">
<link rel="stylesheet" href="{{ URL::asset('admin/dropzone/5.5.1/dropzone.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}">
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">

<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection

@section('content')
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">{{$page}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <?php if(!is_null($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <form id="productForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                            <a href="/admin/{{$page_url}}" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                            </div>
                        </div>
                {{-- <h4 class="card-title">Basic Information</h4> --}}
                <div class="card">
                    <div class="card-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="file_gallery_name" id="file_name">
                            <div class="row">
                                
                                <div align='left' class="col-sm-6 form-group">
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="product_recommended" @if(@$product->product_recommended=='Y') checked @endif value="1">
                                        <label class="custom-control-label" for="customCheck1">Product Recommended</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="customCheck2" name="product_new" @if(@$product->product_new=='Y') checked @endif value="0" >
                                        <label class="custom-control-label" for="customCheck2">Product New</label>
                                    </div>
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" class="custom-control-input" id="customCheck3" name="product_hot" @if(@$product->product_hot=='Y') checked @endif value="1">
                                        <label class="custom-control-label" for="customCheck3">Product Hot</label>                                      
                                    </div>
                                </div>
                                <div align='right' class="col-sm-6 custom-control custom-switch mb-2" dir="ltr">
                                    <input type="checkbox" id="switch2" switch="none" name="status" @if (@$product->status==1||!@$product) checked @endif>
                                    <label data-on-label=""data-off-label="" for="switch2"><a href="javascript: void(0);"></a></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="productCode">Product Code <span class="required">*</span></label>
                                        <input type="text" name="product_code" class="form-control" id="productCode" placeholder="Product code" value="{{@$product->product_code}}" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="productName">Product name <span class="required">*</span></label>
                                        <input type="text" name="product_name" class="form-control" id="productName" placeholder="Product name" value="{{@$product->product_name}}" required="">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                                <div class="form-group">
                                                    <label for="category">Category <span class="required">*</span></label>
                                                    <select onchange="subCateByCate(this.value)" required name="category_id" id="category" class="form-control">
                                                        <option value="" selected hidden>Category</option>
                                                        @foreach ($category as $item)
                                                            <option @if (isset($product->ref_category_id)) @if ($product->ref_category_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                <div class="invalid-feedback">
                                                    Please provide a valid Category.
                                                </div>
                                                <div class="form-group">
                                                    <label for="subCategory">Sub category <span class="required">*</span></label>
                                                    <select onchange="getSeries(this.value)" required name="sub_category_id" id="subCategory" class="form-control">
                                                        <option value="" selected hidden>Sub category</option>
                                                        @foreach ($sub_category as $item)
                                                            <option @if (isset($product->ref_sub_category_id)) @if ($product->ref_sub_category_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->sub_category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid Sub category.
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="Series">Series </label>
                                                    <select name="series_id" id="Series" class="form-control">
                                                        <option value="" selected hidden>Series</option>
                                                        @foreach ($series as $item)
                                                            <option @if (isset($product->ref_series_id)) @if ($product->ref_series_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->series_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid Series.
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="brand">Brand <span class="required">*</span></label>
                                                    <select required name="brand_id" id="brand" class="form-control">
                                                        <option value="" selected hidden>Brand</option>
                                                        @foreach ($brand as $item)
                                                            <option @if (isset($product->ref_brand_id)) @if ($product->ref_brand_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->brand_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Please provide a valid Brand.
                                                    </div>
                                                </div>
                                            <div class="col-md-12"></div>
                                       
                                        <div class="col-md-12 mb-12"><hr /></div>
                                       
                                    </div>
                                </div>
                                    
                                {{-- <div class="row"> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                            <div class="custom-file">
                                                <input name="product_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$product->product_image}}" @empty($product->product_image) required @endempty >
                                                <label class="custom-file-label" for="customFile">@isset($product->product_image) {{$product->product_image}} @else Choose Picture @endisset</label>
                                            </div>
                                            <span class="required"> &nbsp; The appropriate scale should be the same 800 x 800.</span>
                                        </div>
                                        {{-- <div class="col-md-12"> --}}
                                            <div class="form-group">
                                                <img class="img-thumbnail imagePreview"@if(!isset($product->product_image)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/product/'.@$product->product_image) }}" data-holder-rendered="true">
                                            </div>
                                        {{-- </div> --}}
                                            <div class="form-group">
                                                <label for="nameImg">Name image <span class="required">*</span></label>
                                                <input type="text" class="form-control" value="{{str_replace('.'.pathinfo(@$product->product_image, PATHINFO_EXTENSION),'',@$product->product_image)}}" id="nameImg" name="product_image_name" required>
                                                {{-- @if (@$product->product_image) readonly @endif  --}}
                                            </div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                    <label for="elm1">Detail</label>
                                    <textarea name="product_detail" class="form-control" rows="4">{{@$product->product_detail}}</textarea>
                                    </div>
                                </div>
                            </div>
                            @if(@$ProductskUModel)
                                    <div class="row">
                                        <div class="col-md-12 mb-12"><hr /></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_version">แก้ไขข้อมูล SKU</label>
                                              
                                               
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($ProductskUModel as $item)
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_version">SKU</label>
                                                    <input type="hidden" name="product_model_id[{{$item->id}}]" class = "form-control"  placeholder="Version" value="{{@$item->id}}">
                                                    <input type="text" name="product_model_edit[{{$item->id}}]" class = "form-control"  placeholder="Version" value="{{@$item->product_model}}">
                                                
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_weight">Weight</label>
                                                    <input type="number" name="product_weight_edit[{{$item->id}}]" class="form-control" placeholder="Weight" value="{{@$item->product_weight}}" >
                                                
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="product_sizes">Product Size</label>
                                                    <select name="product_sizes_edit[{{$item->id}}]"  class="select2 form-control "  data-placeholder="Choose ...">
                                                    @php $Size_ = DB::Table('sizes')->where('id',$item->product_sizes)->first();@endphp
                                                    @if($Size_)
                                                        <option value="{{$Size_->id}}" selected>{{$Size_->size_name}}</option>
                                                   @endif
                                                   
                                                    @foreach ($size as $value)
                                                        <option value="{{$value->id}}" >{{$value->size_name}}</option>
                                                    @endforeach    
                                                    
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="product_colors">Product Color</label>
                                                    <select name="product_colors_edit[{{$item->id}}]" class="select2 form-control "  data-placeholder="Choose ...">
                                                    @php $Colors = DB::Table('colors')->where('id',$item->product_colors)->first();@endphp
                                                    <option value="{{$Colors->id}}" selected>{{$Colors->color_name}}</option>
                                                    @foreach ($color as $value)
                                                        <option value="{{$value->id}}" >{{$value->color_name}}</option>
                                                    @endforeach    
                                                    
                                                    </select>

                                                </div>
                                            </div>  
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_weight">Qty</label>
                                                    <input type="number" name="product_qty_edit[{{$item->id}}]" class="form-control"  placeholder="Qty" value="{{@$item->product_qty}}" >
                                                
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_weight">ราคาสมาชิก</label>
                                                    @php $Product_prices = DB::Table('product_prices')->where('productsku_id',$item->id)->where('ref_role_id','=','1')->first();@endphp
                                                    <input type="number" name="product_sale_edit1[{{$item->id}}]" class="form-control"  placeholder="1000.00" value="{{$Product_prices->product_sale}}" >
                                                
                                                </div>
                                            </div> 
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_weight">ราคาสมาชิกVIP</label>
                                                    @php $Product_prices = DB::Table('product_prices')->where('productsku_id',$item->id)->where('ref_role_id','=','3')->first();@endphp
                                                    <input type="number" name="product_sale_edit3[{{$item->id}}]" class="form-control"  placeholder="1000.00" value="{{$Product_prices->product_sale}}" >

                                                
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="product_weight">ราคาโครงการ</label>
                                                    @php $Product_prices = DB::Table('product_prices')->where('productsku_id',$item->id)->where('ref_role_id','=','2')->first();@endphp
                                                    <input type="number" name="product_sale_edit2[{{$item->id}}]" class="form-control"  placeholder="1000.00" value="{{$Product_prices->product_sale}}" >
                                                
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-danger" onclick="destroy({{$item->id}})">ลบ</button>
                                            </div>

                                            <div class="col-md-12 mb-12"><hr /></div>
                                        </div>
                                    @endforeach   
                                @endif
                                
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_version">เพิ่มข้อมูล SKU</label>
                                              
                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-12"><hr /></div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_version">SKU</label>
                                                <input type="text" name="product_model" class = "form-control" id="product_model" placeholder="Version" value="{{@$product->product_version}}">
                                               
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_weight">Weight</label>
                                                <input type="number" name="product_weight" class="form-control" id="product_weight" placeholder="Weight" value="{{@$product->product_weight}}" >
                                              
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="product_sizes">Product Size</label>
                                                <select name="product_sizes[]" id="product_sizes" class="select2 form-control "  data-placeholder="Choose ...">
                                                @foreach ($size as $value)
                                                    <option value="{{$value->id}},{{$value->size_name}}" @if(isset($product)) @if (in_array($value->id,$product->product_sizes)) selected @endif @endif >{{$value->size_name}}</option>
                                                @endforeach    
                                                
                                                </select>

                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="product_colors">Product Color</label>
                                                <select name="product_colors[]" id="product_colors" class="select2 form-control "  data-placeholder="Choose ...">
                                                @foreach ($color as $value)
                                                    <option value="{{$value->id}},{{$value->color_name}}" @if(isset($product)) @if (in_array($value->id,$product->product_colors)) selected @endif @endif >{{$value->color_name}}</option>
                                                @endforeach    
                                                
                                                </select>

                                            </div>
                                        </div>  
                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_weight">Qty</label>
                                                <input type="number" name="product_qty" class="form-control" id="product_qty" placeholder="Qty" value="{{@$product->product_qty}}" >
                                               
                                            </div>
                                        </div>
                                        @foreach ($role as $item)
                                        @php
                                            $price_sale = 0;

                                            if(@$product_prices[$item->id]['sale']){
                                                $price_sale = @$product_prices[$item->id]['sale'];
                                            };
                                        @endphp
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="product_weight">{{ $item->role_name }}</label>
                                                <input type="number" name="product_sale{{ $item->id }}" class="form-control" id="product_sale{{ $item->id }}" placeholder="1000.00" value="{{@$product->product_qty}}" >
                                               
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary"  onclick="addRange()">Add</button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">      
                                        
                                        <table id="dataTable" class="table table-centered table-nowrap">
                                        </table>   
                                    </div>    
                                </div>
                                <br>
                                <br>
                    </div>
                </div>
                        {{-- <h4 class="card-title">Description</h4> --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="productVideo">Video</label><br><span class="card-title-desc">https://www.youtube.com/watch?v=</span><span style="color: red">ET9SHYzMz_4</span>
                                    <input type="text" name="product_video" onkeyup="changeVDO(this.value)" class="form-control" id="productVideo" placeholder="ET9SHYzMz_4" value="{{@$product->product_video}}">
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4">
                                <div class="form-group">
                                        {{-- <label for="productVideo">&nbsp;</label> --}}
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="videoYoutube" class="embed-responsive-item" src="https://www.youtube.com/embed/{{@$product->product_video}}?autoplay=1" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                <label for="elm1">Detailed Description</label>
                                {{-- <textarea name="product_description" class="summernote" id="productDescription" placeholder="Detailed Description">{{@$product->product_description}}</textarea> --}}
                                <textarea id="product_description" name="product_description" class="summernote">{{@$product->product_description}}</textarea>
                                {{-- <input type="hidden" id="product_description" name="product_description" value="{{@$product->product_description}}"> --}}
                                </div>
                            </div>
                            
                            <script>
                                function editbus(sd){
                                    alert(1);
                                    console.log(1231);
                                }
                            </script>
                            <div class="col-md-10">
                                <div class="form-group">

                                    <label>File</label>
                                    @isset($product->product_files)
                                        @foreach ($product->product_files as $item)
                                        @if($item->url == null && $item->file_name != null)
                                            <div class="row product_files_{{$item->id}}">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="hidden" name="product_file_id[]" class="btn btn-default" value="{{$item->id}}"/>
                                                        <mark>{{$item->file_name}}</mark>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="button" class="btn btn-primary btn-block inner" value="Delete" onclick="DeleteFilePdf({{ $item->id }})" />
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                    @endisset
                                    {{-- <div class="col-md-10">
                                        <div class="form-group"> --}}
                                            <div data-repeater-list="outer-group" class="outer">
                                                <div data-repeater-item class="outer">
                                                    <div class="inner-repeater">
                                                        <div data-repeater-list="inner-group" class="inner form-group">
                                                            {{-- <label>File</label> --}}
                                                            <div data-repeater-item class="inner mb-3 row">
                                                            <div class="col-md-6">
                                                                <div class="custom-file">
                                                                    <input type="file" name="product_file" class="form-control" accept=".pdf">
                                                                    {{-- <label class="custom-file-label" for="customFile">Choose file</label> --}}
                                                                </div>
                                                            </div>
                                                                <div class="col-md-2 col-4">
                                                                    <input data-repeater-delete type="button" class="btn btn-primary btn-block inner" value="Delete"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input data-repeater-create type="button" class="btn btn-success inner" value="Add Row"/>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">

                                    <label>URL Videos</label>
                                    @isset($product->product_files)
                                        @foreach ($product->product_files as $item)
                                        @php
                                            if($item->url == ''){
                                                continue;
                                            }
                                        @endphp
                                                <div class="row product_files_{{$item->id}}">
                                                    <div class="col-md-3">
                                                        <div class="custom-file">
                                                            <input type="hidden" name="file_url_id[]" class="form-control" value="{{$item->id}}">
                                                            <input type="text" name="product_file_video_name_id[]" class="form-control" value="{{$item->file_name}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="custom-file">
                                                            <input type="text" name="file_url[]" class="form-control" value="{{$item->url}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input type="button" class="btn btn-primary btn-block inner" value="Delete" onclick="DeleteFilePdf({{ $item->id }})" />
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endisset
                                    {{-- <div class="col-md-10">
                                        <div class="form-group"> --}}
                                                            {{-- <label>File</label> --}}
                                                        <div class="mb-3 product_file_url">
                                                            <div class="row product_files_in">
                                                                <div class="col-md-3 file_url">
                                                                    <div class="custom-file">
                                                                        <input type="text" name="product_file_video_name[]" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-7 file_url">
                                                                    <div class="custom-file">
                                                                        <input type="text" name="product_file_url[]" class="form-control">
                                                                    </div>
                                                                </div>
                                                                    <div class="mb-3 col-md-2 col-4">
                                                                        <input type="button" class="btn btn-primary btn-block" value="Delete" onclick="DeleteFilePdf('in')"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <input type="button" class="btn btn-success" value="Add Row" onclick="AddFileUrl({{ $item->id }})"/>
                                        {{-- </div>
                                    </div> --}}
                                    <script>
                                        var product_file_url_id = 0;
                                        function AddFileUrl(){
                                            var file_url = '<div class="file_url'+product_file_url_id+' row mb-3">'
                                                                +'<div class="col-md-3">'
                                                                    +'<div class="custom-file">'
                                                                        +'<input type="text" name="product_file_video_name[]" class="form-control">'
                                                                    +'</div>'
                                                                +'</div>'
                                                                +'<div class="col-md-7">'
                                                                    +'<div class="custom-file">'
                                                                        +'<input type="text" name="product_file_url[]" class="form-control">'
                                                                    +'</div>'
                                                                +'</div>'
                                                                    +'<div class="col-md-2 col-4">'
                                                                        +'<input type="button" class="btn btn-primary btn-block" value="Delete"/>'
                                                                +'</div>'
                                                            +'</div>';
                                            $('.product_file_url').append(file_url);
                                            // alert(file_url);
                                            product_file_url_id++
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        {{-- <h4 class="card-title">Meta Data</h4> --}}
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metatitle">Meta Title</label>
                                    <input id="metatitle" name="meta_title" type="text" placeholder="Detailed Title" class="form-control" value="{{@$product->meta_title}}">
                                </div>
                                <div class="form-group">
                                    <label for="metakeywords">Meta Keywords</label>
                                    <input id="metakeywords" name="meta_keywords" type="text" placeholder="Detailed Keywords" class="form-control" value="{{@$product->meta_keywords}}">
                                </div>
                            </div>
        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metadescription">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Meta Description" rows="5">{{@$product->meta_description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>       
                <div class="card">
                    <div class="card-body">
        
                        <h4 class="card-title">Gallerys</h4>
        
                        {{-- <div> --}}
                            <div class="dropzone" id="my-dropzone">
                            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                    </div>
                                    
                                    <h4>Drop files here or click to upload.</h4>
                                </div>
                            </div>
                        {{-- </div> --}}
        
                    </div>
                </div>
                <div class="card" 
                {{-- @if (!@$product)
                style="pointer-events: none;opacity: 0.4;"
                @endif --}}
                >
                @if (@$product->gallerys)
                    <div class="card-body row">
                        @foreach ($product->gallerys as $gall)
                            <div class="col-sm-2 col-xl-1" id="gall{{$gall->id}}">
                                <div class="img-wrap">
                                    <span class="close"><a href="javascript: void(0);" onclick="deleteGallery('gall{{$gall->id}}')">&times;</a></span>
                                    <input type="hidden" name='last_gallery[]' value="{{$gall->id}}">
                                    <img class="img-thumbnail" src="{{ URL::asset('upload/product/gallerys/'.$gall->image_name) }}" data-holder-rendered="true">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                            <a href="./" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                            </div>
                        </div>
        </form>
        
            {{-- <div class="row"@if (!isset($product))
                style="
                pointer-events: none;
                opacity: 0.4;"
            @endif>
                <div class="col-12"> --}}
                {{-- </div> <!-- end col -->
            </div> <!-- end row --> --}}
            {{-- <button class="btn btn-primary" id="submitBtn" onclick="submit()">Save</button> --}}

            </div>
        </div><br>
        </div>
    </div>
    <!-- end row -->
</div>   

 

<script>
    function destroy(id) {
        Swal.fire({
            title: "ลบข้อมูล",
            text: "คุณต้องการลบข้อมูลใช่หรือไม่?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch("{!! url('admin/product/delete_sku/') !!}" + '/' + id)
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire("ลบข้อมูลเรียบร้อยแล้ว", "", "success");
                        location.reload();
                    })
                    .catch(error => {
                        Swal.fire("เกิดข้อผิดพลาด", `Request failed: ${error}`, "error");
                    });
            }
        });
    }
</script>





  <script>
    let data = [];

    function addRange() {
        const product_model  = document.getElementById('product_model');
        const product_weight = document.getElementById('product_weight');
        const product_qty    = document.getElementById('product_qty');
        const product_sizes  = document.getElementById('product_sizes');
        const product_sale1  = document.getElementById('product_sale1');
        const product_sale2  = document.getElementById('product_sale2');
        const product_sale3  = document.getElementById('product_sale3');
      
        const inputProductModel     = product_model.value.trim();
        const inputProductWeight    = product_weight.value.trim();
        const inputProductQty       = product_qty.value.trim();
        const inputProductColor     = product_colors.value.trim();
        const inputProductSize      = product_sizes.value.trim();
        const inputProductSale1     = product_sale1.value.trim();
        const inputProductSale2     = product_sale2.value.trim();
        const inputProductSale3     = product_sale3.value.trim();

        const [product_sizes_id, product_sizes_Name] = inputProductSize.split(',');
        const [product_color_id, product_color_Name] = inputProductColor.split(',');


        if (inputProductModel !== '' && inputProductWeight !== '' && inputProductQty !== '') {
            if (!data[0]) data.push([]);  // Initialize the array if not exists
          
            data[0].push([inputProductModel, inputProductWeight,inputProductWeight,product_sizes_Name,product_color_id,product_color_Name,inputProductQty,inputProductSale1,inputProductSale2,inputProductSale3]);

            // Clear input fields
            product_model.value = '';
            product_weight.value = '';
            product_qty.value = '';
            product_sizes.value = '';
            product_colors.value = '';
            displayData();
        }
    }

    function deleteColumn(index) {
      data.forEach(row => row.splice(index, 1));
      displayData();
    }
    function displayData() {
        const dataTable = document.getElementById('dataTable');
        dataTable.innerHTML = '<tr><th>SKU</th><th>Weight</th><th>Size</th><th>Color</th><th>Quantity</th><th>ราคาสมาชิก</th><th>ราคาสมาชิก VIP</th><th>ราคาโครงการ</th></tr>';

        if (data.length > 0) {
            const numColumns = data.length;
            const numRows = data[0].length;

            for (let i = 0; i < numRows; i++) {
            const tr = document.createElement('tr');
            let htmlContent = '';

            for (let j = 0; j < numColumns; j++) {
                if (Array.isArray(data[j][i])) {
                    // Assuming data[j][i] is an array of length 3
                    htmlContent += `
                        <td>
                        <input type="hidden" name="product_model_input[]" id="product_model_input[]" value="${data[j][i][0]}">
                        ${data[j][i][0]}
                        </td>
                        <td>
                        <input type="hidden" name="product_weight_input[]" id="product_weight_input[]" value="${data[j][i][1]}">
                        ${data[j][i][1]}
                        </td>
                        <td>
                        <input type="hidden" name="product_sizes_input[]" id="product_sizes_input[]" value="${data[j][i][2]}">
                        ${data[j][i][3]}
                        </td>
                        <td>
                        <input type="hidden" name="product_colors_input[]" id="product_colors_input[]" value="${data[j][i][4]}">
                        ${data[j][i][5]}
                        </td>
                        <td>
                        <input type="hidden" name="product_qty_input[]" id="product_qty_input[]" value="${data[j][i][6]}">
                        ${data[j][i][6]}
                        </td>
                        <td>
                        <input type="hidden" name="product_sale1_input[]" id="product_sale1_input[]" value="${data[j][i][7]}">
                        ${data[j][i][7]}
                        </td>
                        <td>
                        <input type="hidden" name="product_sale2_input[]" id="product_sale2_input[]" value="${data[j][i][8]}">
                        ${data[j][i][8]}
                        </td>
                        <td>
                        <input type="hidden" name="product_sale3_input[]" id="product_sale3_input[]"  value="${data[j][i][9]}">
                        ${data[j][i][9]}
                        </td>
                        `
                        ;
                } else {
                        
                    htmlContent += `<td>${data[j][i]}</td>`;
                }
            }

            const actionTd = document.createElement('td');
            const deleteButton = document.createElement('button');

            deleteButton.textContent = 'Delete';
            deleteButton.onclick = () => deleteColumn(i);

            // เพิ่ม class เข้าไปในปุ่ม
            deleteButton.classList.add('btn', 'btn-danger');

            actionTd.appendChild(deleteButton);

            tr.innerHTML = htmlContent;
            tr.appendChild(actionTd);
            dataTable.appendChild(tr);
            }
        }
    }


  </script>
@endsection

@section('script')
<script>
    function DeleteFilePdf(id){
        $('.product_files_'+id).remove();
    }
</script>
        {{-- <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script> --}}
        <script src="{{ URL::asset('admin/dropzone/5.5.1/dropzone.js')}}"></script>
        {{-- <script>
            $(document).ready(function(){
                $("#submitBtn").click(function(e){
                        $("#productForm").submit();
                    // $(this).hide();
                });
            });
            $("input").on('keyup', function (e) {
                if (e.keyCode === 13) {
                        $("#productForm").submit();
                }
            });
        </script> --}}
        <script>
            function subCateByCate(id) {
                // return console.log(id);
                var u = '';
                $.ajax({
                    type: "GET",
                    url: "{{url('/admin/'.$module)}}/subCateByCate/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.sub_category_name+'</option>';
                        });
                        $('#subCategory').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });

            }
            function getSeries(id) {
                // return console.log(id);
                var u = '';
                $.ajax({
                    type: "GET",
                    url: "{{url('/admin/'.$module)}}/getSeries/"+id,
                    success: function( result ) {
                        console.log(result)
                        if(result.length == 0){
                            u += '<option selected value="" hidden>not found...</option>';
                        }
                        result.forEach(element =>{
                            u += '<option value="'+element.id+'">'+element.series_name+'</option>';
                        });
                        $('#Series').html(u);
                    },error : function(e){
                        console.log(e)
                    }
                });

            }
            function deleteGallery(id){
                $('#'+id).remove();
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
                    var nameImg = $('#nameImg').val();
                    if(nameImg == ''){
                        var productCode = $('#productCode').val();
                        var productName = $('#productName').val();
                        
                        $('#nameImg').val(productCode+'_'+productName);
                    }
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
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            Dropzone.autoDiscover = false;
            var acceptedFileTypes = "image/*"; //dropzone requires this param be a comma separated list
            // imageDataArray variable to set value in crud form
            var imageDataArray = new Array;
            // fileList variable to store current files index and name
            var fileList = new Array;
            var i = 0;
            $(function(){
                uploader = new Dropzone(".dropzone",{
                    url: "{{url('admin/product/uploadGallery')}}",
                    paramName : "file",
                    params: function params(files, xhr, chunk) { return { '_token' : "{{csrf_token()}}",'name':$('#productName').val() }; },
                    uploadMultiple :false,
                    acceptedFiles : "image/*,video/*,audio/*",
                    addRemoveLinks: true,
                    forceFallback: false,
                    maxFilesize: 256, // Set the maximum file size to 256 MB
                    parallelUploads: 100,
                });
                
              ;
                uploader.on("success", function(file,response) {
                    // console.log(fileList);
                    imageDataArray.push(response)
                    fileList[i] = {
                        "serverFileName": response,
                        "fileName": file.name,
                        "fileId": i
                    };
                    // console.log(response);
                    i += 1;
                    $('#file_name').val(imageDataArray);
                });
                uploader.on("removedfile", function(file) {
                    var rmvFile = "";
                    for (var f = 0; f < fileList.length; f++) {
                        if (fileList[f].fileName == file.name) {
                            // remove file from original array by database image name
                            imageDataArray.splice(imageDataArray.indexOf(fileList[f].serverFileName), 1);
                            $('#product_gallerys').val(imageDataArray);
                            // get removed database file name
                            rmvFile = fileList[f].serverFileName;
                            // get request to remove the uploaded file from server
                            $.get( "{{url('admin/product/deleteGallery')}}", { file: rmvFile } )
                            .done(function( data ) {
                                //console.log(data)
                            console.log(imageDataArray)

                            });
                            // reset imageDataArray variable to set value in crud form
                            $('#file_name').val(imageDataArray);
                            
                            // console.log(imageDataArray)
                        }
                    }
                    
                });
            });
        </script>
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        {{-- <script src="{{ URL::asset('admin/dropzone-5.7.0/dist/dropzone.js')}}"></script> --}}
        {{-- <script src="{{ URL::asset('assets/libs/dropzone/min/dropzone.min.js')}}"></script> --}}
        <script src="{{ URL::asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/ecommerce-select2.init.js')}}"></script>

        <script src="{{ URL::asset('assets/libs/tinymce/tinymce.min.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.js')}}"></script>
        {{-- <script src="{{ URL::asset('assets/js/pages/form-editor.init.js')}}"></script> --}}
        {{-- <script type="text/javascript" src="{{ URL::asset('ckeditor/ckeditor.js')}}"></script> --}}
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
        <!-- form repeater js -->
        <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>

        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>

        <script type="text/javascript" src="{{ URL::asset('ckeditor/ckeditor.js')}}"></script>
        <script type="text/javascript" src="{{ URL::asset('ckfinder/ckfinder.js')}}"></script>

        <script>
    
        var editor = CKEDITOR.replace('product_description');
        CKFinder.setupCKEditor( editor );
        // function CKupdate() {
        //     for (instance in CKEDITOR.instances)
        //         CKEDITOR.instances[instance].updateElement();
        // }
        </script>
@endsection