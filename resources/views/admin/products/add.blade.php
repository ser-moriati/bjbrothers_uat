@extends('layouts.master')

@section('title') Product @endsection

@section('css') 

<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/summernote/summernote-bs4.min.css')}}">
<link rel="stylesheet" href="{{ URL::asset('admin/dropzone/5.5.1/dropzone.css')}}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/css/select2.min.css')}}">
<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
                                    <label class="custom-control-label" for="customCheck1" style="padding-right: 35px;">Product Recommended</label>

                                    <input type="checkbox" class="custom-control-input" id="customCheck2" name="product_new" @if(@$product->product_new=='Y') checked @endif value="0" >
                                    <label class="custom-control-label" for="customCheck2" style="padding-right: 35px;">Product New</label>

                                    <input type="checkbox" class="custom-control-input" id="customCheck3" name="product_hot" @if(@$product->product_hot=='Y') checked @endif value="1">
                                    <label class="custom-control-label" for="customCheck3" style="padding-right: 35px;">Product Hot</label>                                      
                                </div>
                            </div>
                            <div align='right' class="col-sm-6 custom-control custom-switch mb-2" dir="ltr">
                                <input type="checkbox" id="switch2" switch="none" name="status" @if (@$product->status==1||!@$product) checked @endif>
                                <label data-on-label=""data-off-label="" for="switch2"><a href="javascript: void(0);"></a></label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="productCode">Product Code </label>
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
                                </div>
                            </div>
                                
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                    <div class="custom-file">
                                        <input name="product_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$product->product_image}}" @empty($product->product_image) required @endempty >
                                        <label class="custom-file-label" for="customFile">@isset($product->product_image) {{$product->product_image}} @else Choose Picture @endisset</label>
                                    </div>
                                    <span class="required"> &nbsp; The appropriate scale should be the same 800 x 800.</span>
                                </div>
                                <div class="form-group">
                                    <img class="img-thumbnail imagePreview"@if(!isset($product->product_image)) style="display: none;" @endif alt="200x200" width="148" src="{{ URL::asset('upload/product/'.@$product->product_image) }}" data-holder-rendered="true">
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">Name image <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{str_replace('.'.pathinfo(@$product->product_image, PATHINFO_EXTENSION),'',@$product->product_image)}}" id="nameImg" name="product_image_name" required>
                                    {{-- @if (@$product->product_image) readonly @endif  --}}
                                </div>
                                <div class="form-group">
                                    <label for="product_version">MODEL</label>
                                    <input type="text" name="product_version" class="form-control" id="product_version" placeholder="Version" value="{{@$product->product_version}}">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="elm1">Detail</label>
                                <textarea name="product_detail" class="form-control" rows="4">{{@$product->product_detail}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h3 style="margin: 0px;">
                                <label for="staticEmail" class="col-sm-12 col-form-label">ข้อมูลการขาย</label>
                            </h3>
                        </div>
                        
                    <?php ?>
                        <div class="mb-3 row" style="font-size: .65rem;">
                            <div class="col-sm-6">
                                <label for="staticEmail" class="col-form-label">ตัวเลือก</label>                         
                                <div class="col-sm-12 mb-2" style="padding: 0px;">
                                    @if(@$products_option_head)
                                    <label>หัวข้อ เช่น สี, ไซส์</label>
                                    <input type="text" class="form-control generate_table" placeholder="" name="option_title[0] " value="{{ ($products_option_head->isNotEmpty() && array_key_exists(0, $products_option_head->toArray()) ? $products_option_head[0]->name_th : '' ) }}" required>
                                    @else
                                    <label>หัวข้อ เช่น สี, ไซส์</label>
                                    <input type="text" class="form-control generate_table" placeholder="" name="option_title[]" value="" required>
                                    @endif
                                </div>
                                <div class="col-sm-12 mb-2">
                                    @if(!empty($products_option_1) && count($products_option_1) > 0)
                                        @foreach($products_option_1 as $_products_option_1)       
                                        <input type="hidden" name="option_detail_file_1_img[]" value="{{ @$_products_option_1->img }}">
                                        <div class="row option_detail" ref="000{{ $_products_option_1->id }}">
                                             <div class="col-sm-6" style="padding: 0px;">
                                                <label> แนบไฟล์ภาพ กว้าง 800 ยาว 800 Pixel</label>
                                                <input  type="file" name="option_detail_file[]" class="form-control" accept="image/*" value="{{@$_products_option_1->img}}" >
                                            </div>
                                            <div class="col-sm-5">
                                                <label>ตัวเลือก เช่น สีแดง, สีเขียว </label>
                                                <input type="text" class="form-control generate_table" name="option_detail[]"  value="{{ $_products_option_1->name_th }}">
                                            </div>
                                            <button type="button" class="btn btn-danger col-sm-1 remove_option_detail"  ref="000{{ $_products_option_1->id }}" style="margin-top: 15px; height: 36px;"><i class="fa fa-trash"></i></button>
                                            <label style="padding: 0px;">@isset($_products_option_1->img) {{$_products_option_1->img}} @endisset</label>
                                        </div>   
                                        @endforeach  
                                    @else
                                        <div class="row option_detail" >
                                            <div class="col-sm-6" style="padding: 0px;">
                                                <label> แนบไฟล์ภาพ กว้าง 800 ยาว 800 Pixel</label>
                                                <input type="file" class="form-control" id="option_detail_file" name="option_detail_file[]" accept="image/*"  >
                                            </div>
                                            <div class="col-sm-5">
                                                <label>ตัวเลือก เช่น สีแดง, สีเขียว </label>
                                                <input type="text" class="form-control generate_table" name="option_detail[]"  required>
                                            </div>
                                                <button type="button" class="btn btn-danger col-sm-1 remove_option_detail" style="margin-top: 15px; height: 36px;"><i class="fa fa-trash"></i></button>
                                        </div>   
                                    @endif
                                </div>
                                <button type="button" class="form-control btn btn-outline-primary add_option_detail_1 col-sm-12"> เพิ่มตัวเลือกใหม่</button>
                            </div>

                            <div class="col-sm-6">
                                <label for="staticEmail" class="col-form-label">ตัวเลือก</label>                         
                                <div class="col-sm-12 mb-2" style="padding: 0px;">
                                    @if(@$products_option_head)
                                    <label>หัวข้อ เช่น สี, ไซส์</label>
                                    <input type="text" class="form-control generate_table" placeholder=""
                                        name="option_title[1]"
                                        value="{{ ($products_option_head->isNotEmpty() && isset($products_option_head[1]) ? $products_option_head[1]->name_th : '' ) }}">
                                    @else
                                    <label>หัวข้อ เช่น สี, ไซส์</label>
                                    <input type="text" class="form-control generate_table" placeholder=""
                                        name="option_title[]"
                                        value="">
                                    @endif
                                </div>
                                <div class="col-sm-12 mb-2">
                                @if(!empty($products_option_2) && count($products_option_2) > 0)
                                    @foreach($products_option_2 as $_products_option_2)        
                                    <input type="hidden" name="option_detail_file_2_img[]" value="{{ @$_products_option_2->img }}">
                                    <div class="row option_detail_2">
                                        <div class="col-sm-6" style="padding: 0px;">
                                            <label> แนบไฟล์ภาพ กว้าง 800 ยาว 800 Pixel</label>
                                            <input type="file" class=" form-control" id="option_detail_file_2" name="option_detail_file_2[]" accept="image/*"  >
                                        </div>
                                        <div class="col-sm-5">
                                        <label>หัวข้อ เช่น สี, ไซส์</label>
                                            <input type="text" class="form-control generate_table" name="option_detail_2[]" value="{{ $_products_option_2->name_th }}">
                                        </div>
                                        <button type="button" class="btn btn-danger col-sm-1 remove_option_detail_2" ref="000{{ $_products_option_2->id }}" style="margin-top: 15px; height: 36px;"><i class="fa fa-trash"></i></button>
                                        <label style="padding: 0px;">@isset($_products_option_2->img) {{$_products_option_2->img}} @endisset</label>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="row option_detail_2">
                                        <div class="col-sm-6" style="padding: 0px;">
                                            <label> แนบไฟล์ภาพ กว้าง 800 ยาว 800 Pixel</label>
                                            <input type="file" class="form-control" name="option_detail_file_2[]" id="option_detail_file_2" accept="image/*"  >
                                        </div>
                                     
                                        <div class="col-sm-5">
                                            <label>ตัวเลือก (30ซม., 40ซม.) </label>
                                            <input type="text" class="form-control generate_table" name="option_detail_2[]">
                                        </div>
                                            <button type="button" class="btn btn-danger col-sm-1 remove_option_detail_2" style="margin-top: 15px; height: 36px;"><i class="fa fa-trash"></i></button>
                                    </div>
                                @endif
                                </div>
                                <button type="button" class="form-control btn btn-outline-primary add_option_detail_2 col-sm-12"> เพิ่มตัวเลือกใหม่</button>
                            </div>
                        </div>    

                        @if(!empty($products_option_2_items))

                        <label>ข้อมูลเดิม สามารถแก้ไขราคา จำนวนสต๊อก และเลข SKU ได้ในตารางนี้ กรณีที่ไม่ได้แก้ไขข้อมูลตัวเลือก</label>
                        <table class="table table-sm">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 7%;">ตัวเลือก 1</th>
                                <th style="text-align: center; width: 7%;">ตัวเลือก 2</th>
                                <th style="text-align: center;">ราคาทั่วไป</th>
                                <th style="text-align: center;">ราคาสมาชิก</th>
                                <th style="text-align: center;">ราคาสมาชิก VIP</th>
                                <th style="text-align: center;">ราคาโครงการ</th>

                                <th style="text-align: center;">คลัง</th>
                                <th style="text-align: center;">เลข SKU</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products_option_2_items as $_products_option_2_items)
                                <?php $name_show1 = DB::table("productsoption1")->where("id",$_products_option_2_items->product_option_1_id)->first(); ?>
                                <?php $name_show2= DB::table("productsoption2")->where("id",$_products_option_2_items->product_option_2_id)->first();  ?>
                                <tr>
                                    <td>{{ @$name_show1->name_th }}</td>
                                    <td>{{ @$name_show2->name_th}}</td>
                                    <td class="row !px-2">
                                        <div class="input-group "><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาทั่วไป"  name="old_price[{{ @$name_show1->name_th }}][{{ @$name_show2->name_th}}][0]" value="{{ (!empty($_products_option_2_items->price_0) ? $_products_option_2_items->price_0 : 0) }}" required></div>
                                    </td>
                                    <td class="!px-2">
                                    <div class="input-group "><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาทั่วไป"  name="old_price1[{{ @$name_show1->name_th }}][{{ @$name_show2->name_th}}][0]" value="{{ (!empty($_products_option_2_items->price_1) ? $_products_option_2_items->price_1 : 0) }}" required></div>
                                    </td>
                                    <td class="!px-2">
                                    <div class="input-group "><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาทั่วไป"  name="old_price3[{{ @$name_show1->name_th }}][{{ @$name_show2->name_th}}][0]" value="{{ (!empty($_products_option_2_items->price_3) ? $_products_option_2_items->price_3 : 0) }}" required></div>
                                    </td>
                                    <td class="!px-2">
                                    <div class="input-group "><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาทั่วไป"  name="old_price2[{{ @$name_show1->name_th }}][{{ @$name_show2->name_th}}][0]" value="{{ (!empty($_products_option_2_items->price_2) ? $_products_option_2_items->price_2 : 0) }}" required></div>
                                    </td>
                                    <td class="!px-2">
                                        <input type="text" class="form-control min-w-[6rem]" name="old_stock[{{ @$name_show1->name_th }}][{{ @$name_show2->name_th}}][]" placeholder="สต็อค" value="{{ (!empty($_products_option_2_items->product_qty) ? $_products_option_2_items->product_qty : 0) }}" required>
                                    </td>
                                    <td class="!px-2">
                                        <input type="text" class="form-control min-w-[6rem]" name="old_sku[{{ @$name_show1->name_th }}][{{ @$name_show2->name_th}}][]" placeholder="สต็อค" value="{{ (!empty($_products_option_2_items->product_SKU) ? $_products_option_2_items->product_SKU : 0) }}" required>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                        @endif

                        <label>ข้อมูลใหม่ (กรณีที่เพิ่มตัวเลือกใหม่ หรือมีการเปลี่ยนแปลงข้อมูลตัวเลือกจากของเดิมที่มีอยู่ รวมถึงการเปลี่ยนชื่อตัวเลือก)</label>
                        <table id="optionTable" class="table table-sm">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 7%;">ตัวเลือก 1</th>
                                    <th style="text-align: center; width: 7%;">ตัวเลือก 2</th>
                                    <th style="text-align: center;">ราคาทั่วไป</th>
                                    <th style="text-align: center;">ราคาสมาชิก</th>
                                    <th style="text-align: center;">ราคาสมาชิก VIP</th>
                                    <th style="text-align: center;">ราคาโครงการ</th>

                                    <th style="text-align: center;">คลัง</th>
                                    <th style="text-align: center;">เลข SKU</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                    </div>
                </div> 
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="productVideo">หัวข้อ Video</label><br><span class="card-title-desc">วางข้อมูลจาก Youtube ตามตัวอย่างดังนี้ : https://www.youtube.com/watch?v=</span><span style="color: red">ET9SHYzMz_4</span>
                                    <input type="text" name="product_video" onkeyup="changeVDO(this.value)" class="form-control" id="productVideo" placeholder="ET9SHYzMz_4" value="{{@$product->product_video}}">
                                </div>
                            </div>
                            <div class="col-md-12"></div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe id="videoYoutube" class="embed-responsive-item" src="https://www.youtube.com/embed/{{@$product->product_video}}?autoplay=1" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                <label for="elm1">หัวข้อ Detailed Description</label>
                                <textarea id="product_description" name="product_description" class="summernote">{{@$product->product_description}}</textarea>
                                </div>
                            </div>
                            
                            <script>
                                function editbus(sd){
                                    alert(1);
                                    console.log(1231);
                                }
                            </script>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">

                                    <label>หัวข้อ File ใน Techinical Information</label><label>สามารถแนบไฟล์อะไรก็ได้ เพื่อให้ผู้เข้าชมเว็บสามารถ Download ออกไปใช้งานได้</label>
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
                                                        <button data-repeater-delete type="button" class="btn btn-danger btn-block inner" onclick="DeleteFilePdf({{ $item->id }})"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @endforeach
                                    @endisset
                                    <div data-repeater-list="outer-group" class="outer">
                                        <div data-repeater-item class="outer">
                                            <div class="inner-repeater">
                                                <div data-repeater-list="inner-group" class="inner form-group">
                                                    <div data-repeater-item class="inner mb-3 row">
                                                    <div class="col-md-10">
                                                        <div class="custom-file">
                                                            <input type="file" name="product_file" class="form-control" accept=".pdf">
                                                        </div>
                                                    </div>
                                                        <div class="col-md-2 col-2">
                                                            <button data-repeater-delete type="button" class="btn btn-danger btn-block inner"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input data-repeater-create type="button" class="btn btn-success inner" value="Add Row"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>หัวข้อ Link ใน Techinical Information</label><label>สามารกรอกชื่อไฟล์ และลิงก์ภายนอกเพื่อแสดงในหน้าสินค้า</label>
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
                                                            <input type="text" name="product_file_video_name_id[]" class="form-control" value="{{$item->file_name}}" placeholder="ชื่อไฟล์">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="custom-file">
                                                            <input type="text" name="file_url[]" class="form-control" value="{{$item->url}}" placeholder="Url สำหรับลิงก์ภายนอก">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <button data-repeater-delete type="button" class="btn btn-danger btn-block inner" onclick="DeleteFilePdf({{ $item->id }})"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforeach
                                    @endisset
                                        <div class="product_file_url">
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
                                                        <button data-repeater-delete type="button" class="btn btn-danger btn-block inner" onclick="DeleteFilePdf('in')"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        <input type="button" class="btn btn-success" value="Add Row" onclick="AddFileUrl({{ $item->id }})"/>
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metatitle">Meta Title : ชื่อของสินค้า </label>
                                    <input id="metatitle" name="meta_title" type="text" placeholder="Detailed Title" class="form-control" value="{{@$product->meta_title}}">
                                </div>
                                <div class="form-group">
                                    <label for="metakeywords">Meta Keywords : คำที่เกี่ยวข้องกับสินค้าชิ้นนั้นๆ เช่น อ่างล้างตา, บันได, ไฟฉุกเฉิน</label>
                                    <input id="metakeywords" name="meta_keywords" type="text" placeholder="Detailed Keywords" class="form-control" value="{{@$product->meta_keywords}}">
                                </div>
                            </div>
        
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="metadescription">Meta Description : รายละเอียดของสินค้าชิ้นนั้นๆ ไม่เกิน 500 ตัวอักษร</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" placeholder="Meta Description" rows="5">{{@$product->meta_description}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>       
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Gallery : ภาพสินค้าเพิ่มเติม</h4>
                        <div class="dropzone" id="my-dropzone">
                            <div class="dz-message needsclick">
                                <div class="mb-3">
                                    <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                </div>
                                
                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </div>
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
                
                 
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h3>
                                <label for="staticEmail" class="col-sm-2 col-form-label">การจัดส่ง</label>
                            </h3>
                        </div>
                        
                        <div class="row">
                            <label for="" class="col-sm-2 col-form-label">น้ำหนัก <br></label>
                            <div class="col-sm-3">
                                <div class="input-group "><input type="text" class="form-control min-w-[6rem]" placeholder="kg"  name="product_weight" value="{{@$product->product_weight}}"><div class="input-group-text">kg</div></div>
                            </div>
                        </div>
                        <br>
                  
                        <div class="row" >
                            <label for="" class="col-sm-2 col-form-label">ขนาดพัสดุ  <br>
                                กว้าง x ยาว x สูง
                            </label>
                            <div class="col-sm-3">
                                <div class="input-group "><input type="text" class="form-control min-w-[6rem]" placeholder="กว้าง cm"  name="wide" value="{{@$product->product_wide}}"><div class="input-group-text">cm</div></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group "><input type="text" class="form-control min-w-[6rem]" placeholder="ยาว cm"  name="long" value="{{@$product->product_long}}"><div class="input-group-text">cm</div></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group "><input type="text" class="form-control min-w-[6rem]" placeholder="สูง cm"  name="high" value="{{@$product->product_high}}"><div class="input-group-text">cm</div></div>
                            </div>
                        </div>  
                        <div class="row" >
                            <label for="" class="col-sm-2 col-form-label">วิธ๊การจัดส่ง  <br></label>
                            <div class="col-sm-3">
                                <center>
                                    <input class="form-check-input" type="radio" name="transport" id="gridRadios1" value="1" @if(@$product->product_transport==1) checked @endif>
                                    <label class="form-check-label" for="gridRadios1">
                                       Self Delivery <br> จัดส่งเองโดยบริษัท BJ BROTHERS  
                                    </label> 
                                <center>
                            </div>
                            <div class="col-sm-3">
                                <center>
                                    <input class="form-check-input" type="radio" name="transport" id="gridRadios2" value="2" @if(@$product->product_transport==2) checked @endif>
                                    <label class="form-check-label" for="gridRadios2">
                                    Standard Delivery <br> ขนส่งขนาดเล็ก
                                    </label> 
                                <center>
                            </div>
                            <div class="col-sm-3">
                                <center>
                                    <input class="form-check-input" type="radio" name="transport" id="gridRadios3" value="3" @if(@$product->product_transport==3) checked @endif>
                                    <label class="form-check-label" for="gridRadios3">
                                    Standard Delivery Bulky <br> ส่งสินค้าขนาดใหญ่
                                    </label> 
                                <center>
                            </div>
                        </div>   
                        <div class="row" >
                            <label for="" class="col-sm-2 col-form-label">ค่าขนส่ง  <br></label>
                            <div class="col-sm-3">
                            <div class="input-group "><input type="text" class="form-control min-w-[6rem]" placeholder=""  name="transportprice" value="{{@$product->product_transportprice}}"><div class="input-group-text">฿</div></div>
                            </div>
                           
                        </div>   
                    </div>
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

 







 
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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
        </script><script>
    
    let optionCounter = 1;
    let optionCounter_2 = 1;

    // Function to add a new option_detail div for option 1
    function addOptionDetail_1() {
        optionCounter++;
        const optionDetailClone = $('.option_detail:first').clone(true);
            // ตรวจสอบว่า optionDetailClonefile ถูกประกาศหรือไม่

        optionDetailClone.find('input[type="file"]').attr('name', 'option_detail_file[]');
        optionDetailClone.find('input:not([type="file"])').attr('name', 'option_detail[]');

        optionDetailClone.find('.add_option_detail_1').removeClass('add_option_detail_1').addClass('remove_option_detail').html('<i data-lucide="trash-2" class="w-4 h-4"></i> ลบตัวเลือก');
        optionDetailClone.find('.remove_option_detail').on('click', removeOptionDetail(optionCounter));
        $('.option_detail:last').after(optionDetailClone);
        $('.option_detail:last').attr('ref', optionCounter);
        $('.remove_option_detail:last').attr('ref', optionCounter);

    }

    // Function to add a new option_detail div for option 2
    function addOptionDetail_2() {
        optionCounter_2++;
        const optionDetailClone_2 = $('.option_detail_2:first').clone(true);
        optionDetailClone_2.find('input[type="file"]').attr('name', 'option_detail_file_2[]');
        optionDetailClone_2.find('input:not([type="file"])').attr('name', 'option_detail_2[]');
        optionDetailClone_2.find('.add_option_detail_2').removeClass('add_option_detail_2').addClass('remove_option_detail_2').html('<i data-lucide="trash-2" class="w-4 h-4"></i> ลบตัวเลือก');
        optionDetailClone_2.find('.remove_option_detail_2').on('click', removeOptionDetail_2(optionCounter_2));
        $('.option_detail_2:last').after(optionDetailClone_2);
        $('.option_detail_2:last').attr('ref', optionCounter_2);
        $('.remove_option_detail_2:last').attr('ref', optionCounter_2);
    }

    // Function to remove the last option_detail div for option 1
    function removeOptionDetail(optionCounter) {
        $('.option_detail').each(function () {
            if ($(this).attr('ref') != null) {
                if ($(this).attr('ref') == optionCounter) {
                    $(this).remove();
                    
                }
            }
        });
    }

    // Function to remove the last option_detail div for option 2
    function removeOptionDetail_2(optionCounter_2) {
        $('.option_detail_2').each(function () {
            if ($(this).attr('ref') != null) {
                if ($(this).attr('ref') == optionCounter_2) {
                    $(this).remove();
                }
            }
        });
    }

    // Attach click event to add_option_detail_1 button
    $('.add_option_detail_1').on('click', addOptionDetail_1);

    // Attach click event to add_option_detail_2 button
    $('.add_option_detail_2').on('click', addOptionDetail_2);

    // Attach click event to remove_option_detail button (for existing options 1)
    $('.remove_option_detail').click(function () {
        removeOptionDetail($(this).attr('ref'));
        generateTable();
    });

    // Attach click event to remove_option_detail_2 button (for existing options 2)
    $('.remove_option_detail_2').click(function () {
        removeOptionDetail_2($(this).attr('ref'));
        generateTable();
    });

    $('.generate_table').change(function(){
        generateTable();
    });

    function generateTable() {
        const optionTitles = $('input[name="option_title[]"]');
        const optionDetails = $('input[name="option_detail[]"]');
        const optionDetails_2 = $('input[name="option_detail_2[]"]');

        $('#optionTable tbody').empty();
        
        optionDetails.each(function (index) {
            const option_1 = [];
            const option_2 = [];

            optionDetails.each(function () {
                option_1.push($(this).val());
            });

            optionDetails_2.each(function () {
                option_2.push($(this).val());
            });

            const rowCount = Math.max(option_2.length);

            for (let i = 0; i < rowCount; i++) {
                const row = $('<tr>');

                if (i == 0) {
                    row.append($('<td rowspan="' + rowCount + '" class="border-r">' + $(this).val() + '</td>'));
                }

                if (option_2[i]) {
                    row.append($('<td>' + option_2[i] + '</td>'));
                } else {
                    row.append($('<td></td>'));
                }

                row.append($('<td class="!px-2"><div class="input-group "><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาทั่วไป" value="0" name="price['+$(this).val()+']['+option_2[i]+'][0]" required></div></td>'));
                row.append($('<td class="!px-2"><div class="input-group "><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาสมาชิก" value="0" name="price1['+$(this).val()+']['+option_2[i]+'][0]" required></div></td>'));
                row.append($('<td class="!px-2"><div class="input-group"><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาสมาชิกVIP" value="0" name="price3['+$(this).val()+']['+option_2[i]+'][0]" required></div></td>'));
                row.append($('<td class="!px-2"><div class="input-group "><div class="input-group-text">฿</div><input type="text" class="form-control min-w-[6rem]" placeholder="ราคาโครงการ" value="0" name="price2['+$(this).val()+']['+option_2[i]+'][0]" required></div></td>'));
                row.append($('<td class="!px-2"><input type="text" class="form-control min-w-[6rem]" value="0" name="stock['+$(this).val()+']['+option_2[i]+'][0]" placeholder="สต็อค" required></td>'));
                row.append($('<td class="!px-2"><input type="text" class="form-control min-w-[6rem]" value="0" name="sku['+$(this).val()+']['+option_2[i]+'][0]" placeholder="sku" required></td>'));
                $('#optionTable tbody').append(row);
            }
        });
    }

</script>

@endsection