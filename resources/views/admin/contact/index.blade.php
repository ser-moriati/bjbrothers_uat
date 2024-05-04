@extends('layouts.master')

@section('title') Contact @endsection

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
        <div class="col-sm-12">

        <form id="productForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
            <div class="col-sm-12">
                <div class="form-group">
            <button class="btn btn-primary" id="submitBtn">Save</button>
                </div>
            </div>
            {{-- <div class="col-12"> --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                {{-- <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">i</span>
                                    </div>
                                    <input id="iframe" name="iframe" type="text" placeholder="iframe" class="form-control" value="{{@$contact->iframe}}">
                                </div> --}}
                                <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input id="address" name="address" type="text" placeholder="address" class="form-control" value="{{@$contact->address}}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input id="business_hours" name="business_hours" type="text" placeholder="business_hours" class="form-control" value="{{@$contact->business_hours}}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                    </div>
                                    <input id="phone" name="phone" type="text" placeholder="phone" class="form-control" value="{{@$contact->phone}}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                    </div>
                                    <input id="mobile_phone" name="mobile_phone" type="text" placeholder="mobile_phone" class="form-control" value="{{@$contact->mobile_phone}}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-fax"></i></span>
                                    </div>
                                    <input id="fax" name="fax" type="text" placeholder="fax" class="form-control" value="{{@$contact->fax}}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input id="email" name="email" type="text" placeholder="email" class="form-control" value="{{@$contact->email}}">
                                </div>
                                <div class="form-group input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input id="line_id" name="line_id" type="text" placeholder="line_id" class="form-control" value="{{@$contact->line_id}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- <div class="form-group">
                                    <label>Line QR Code <span class="required">* The image size must not exceed 2 MB.</span></label>
                                    <div class="custom-file">
                                        <input name="line_qr" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" @empty($contact->line_qr) required @endempty >
                                        <label class="custom-file-label" for="customFile">@isset($contact->line_qr) {{$contact->line_qr}} @else Choose QR Code @endisset</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">Name image <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{pathinfo(@$contact->line_qr, PATHINFO_FILENAME)}}" id="nameImg" name="line_qr_name" required>
                                </div>
                                <div class="form-group">
                                    <img class="img-thumbnail imagePreview" width="100" @if(!isset($contact->line_qr)) style="display: none;" @endif src="{{ URL::asset('upload/contact/'.@$contact->line_qr) }}" data-holder-rendered="true">
                                </div>
                                 -->
                                <div class="form-group">
                                    <label>Map <span class="required">* The image size must not exceed 2 MB.</span></label>
                                    <div class="custom-file">
                                        <input name="map_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange2(this)" @empty($contact->map_image) required @endempty >
                                        <label class="custom-file-label" for="customFile">@isset($contact->map_image) {{$contact->map_image}} @else Choose Map @endisset</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nameImg">Name image <span class="required">*</span></label>
                                    <input type="text" class="form-control" value="{{pathinfo(@$contact->map_image, PATHINFO_FILENAME)}}" id="nameImg" name="map_image_name" required>
                                </div>
                                <div class="form-group">
                                    <img class="img-thumbnail imagePreview2" width="200" @if(!isset($contact->map_image)) style="display: none;" @endif src="{{ URL::asset('upload/contact/'.@$contact->map_image) }}" data-holder-rendered="true">
                                </div>
                            {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5132.083678498738!2d100.40977846183429!3d13.675812333620003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5e5f2322e9eb2ef5!2z4Lia4Lij4Li04Lip4Lix4LiXIOC4muC4tS7guYDguIgu4Lia4Lij4Liy4LmA4LiU4Lit4Lij4LmM4LiqIOC5geC4reC4meC4lOC5jCDguIvguLHguJkg4LiI4Liz4LiB4Lix4LiU!5e0!3m2!1sth!2sth!4v1597915301558!5m2!1sth!2sth" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>  --}}
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-9">
                            <form method="GET" action="{{$page_url}}">
                                <!-- <div class="col-sm-3 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                    <input type="search" class="form-control" name="title" placeholder="title..." value="{{@$query['title']}}">
                                        {{-- <i class="fas fa-times search-icon"></i> --}}
                                    </div>
                                </div>
                                <div class="col-sm-3 search-box mb-2 d-inline-block">
                                    <div class="position-relative">
                                        <input type="search" class="form-control" name="detail" placeholder="detail..." value="{{@$query['detail']}}">
                                    </div>
                                </div> -->
                                <!-- <div class="col-sm-3 mb-2 d-inline-block">
                                        <button style="background-color: #556ee6; color:white" class="btn btn-rounded waves-effect waves-light" type="submit"><i class='bx bx-search-alt'></i>&nbsp; search</button>
                                </div> -->
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <div class="text-sm-right">
                                <a href="{{url('admin/contact/add')}}" class="btn btn-success btn-rounded waves-effect waves-light mb-2 mr-2"><i class="mdi mdi-plus mr-1"></i> New Social icon</a>
                            </div>
                        </div><!-- end col-->
                        <!-- <div class="col-sm-12 btnDeleteAll" style="display: none">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="btnDeleteAll()"><i class="mdi mdi-delete mr-1"></i> Delete all</button>
                            </div>
                        </div>end col -->
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap">
                            <thead class="thead-light">
                                <tr align="center">
                                    <th style="width: 20px;">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" onchange="checkAll(this)" class="custom-control-input" id="customCheckAll">
                                            <label class="custom-control-label" for="customCheckAll">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>#</th>
                                    <th>Picture</th>
                                    <th width="40%">title</th>
                                  
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_data as $value)
                                
                                <tr align="center">
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkbox-list" onchange="checkList()" id="customCheck{{$num}}" value="{{$value->contact_social_id}}">
                                            <label class="custom-control-label" for="customCheck{{$num}}">&nbsp;</label>
                                        </div>
                                    </td>
                                    <td>{{$num++}}</td>
                                    <td>
                                        <div class="zoom-gallery">
                                        
                                        <a class="float-left" href="{{URL::asset('upload/contact/')}}/{{$value->contact_social_img}}" title="{{$value->contact_social_img}}"><img width="50px" src="{{URL::asset('upload/contact/')}}/{{$value->contact_social_img}}" alt="" width="275"></a>
                                        </div>
                                    </td>
                                    <td>{{$value->contact_social_text}}</td>
                                    <td>{{$value->contact_social_created_at}}</td>
                                    <td>{{$value->contact_social_updated_at}}</td>
                                    
                                    <td>
                                        <a href="{{$page_url}}/edit/{{$value->contact_social_id}}" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                        <a href="javascript: void(0);" onclick="deleteFromTablecontact({{$value->contact_social_id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                @include('layouts/data-notfound')
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">Showing &nbsp;<b>{{$from}}</b>&nbsp; to &nbsp;<b>{{$to}}</b>&nbsp; of &nbsp;<b>{{$total}}</b>&nbsp; entries</div>
                        <ul class="pagination pagination-rounded justify-content-end col-sm-6 mb-2">
                        {{  $list_data->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('layouts/modal')
<!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

<!-- lightbox init js-->
<script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
<script >
        function deleteFromTablecontact(id){
            $('#exampleModalScrollable').modal('show');
            $('.confirmDelete').attr("id",id);
        }
        function deleteData(module) {
            var id = $('.confirmDelete').attr("id");
            var token = document.getElementById("token").value;
            $.ajax({
                type: "DELETE",
                url: "{!! url('admin/contact/delete/"+id+"') !!}",
                data:{
                    '_token': token,
                },
                success: function( result ) {
                    if(result == 1){
                        $('#exampleModalScrollable').modal('hide');
                        $('#deleteSuccess').modal('show');
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                    }else{
                    }
                }   
            });
        }
    </script>
        <script>
            function productSelect(){
                var id = $('#product').val();
                $.ajax({
                    type: "POST",
                    url: "{{$module}}/select_product",
                    data:{
                        id:id,
                        '_token': "{{ csrf_token() }}",
                    },
                    success: function( result ) {
                        var tr = '';
                        result.forEach(element => {
                            tr += '<tr><td><img width="50" src="{{ URL::asset("upload/product")}}/'+element.product_image+'"></td><td>'+element.product_code+'</td><td>'+element.product_name+'</td><td>'+element.product_price+'</td></tr>';
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
                const size =  
                    (input.files[0].size / 1024 / 1024).toFixed(2); 

                if (size > 2) { 
                    $('.custom-file-input').val(null);
                    alert("The image size must not exceed 2 MB."); 
                    return false;
                }
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
                readURL(t);
            }
            function readURL2(input) {
                const size =  
                    (input.files[0].size / 1024 / 1024).toFixed(2); 

                if (size > 2) { 
                    $('.custom-file-input').val(null);
                    alert("The image size must not exceed 2 MB."); 
                    return false;
                }
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    $('.imagePreview2').show();
                    reader.onload = function(e) {
                    $('.imagePreview2').attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }
            function imgChange2(t) {
                readURL2(t);
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