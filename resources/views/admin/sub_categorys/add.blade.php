@extends('layouts.master')

@section('title') Sub Category @endsection

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
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
                        <?php if(!isset($page_before)){echo "<li class='breadcrumb-item active'>$page_before</li>";}?>
                        <li class="breadcrumb-item active">{{$page}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <form action="{{$action}}" method="post" class="needs-validation" novalidate="" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sub_categoryCode">Sub category code <span class="required">*</span></label>
                                    <input type="text" name="sub_category_code" class="form-control" id="sub_categoryCode" value="{{@$sub_category->sub_category_code}}" placeholder="Sub category code" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid Sub category name.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sub_categoryName">Sub category name <span class="required">*</span></label>
                                    <input type="text" name="sub_category_name" class="form-control" id="sub_categoryName" value="{{@$sub_category->sub_category_name}}" placeholder="Sub category name" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid Sub category name.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category">Category <span class="required">*</span></label>
                                        <select required name="category_id" id="category" class="form-control" required>
                                            <option value="" selected hidden>Category</option>
                                            @foreach ($category as $item)
                                                <option @if (isset($sub_category->ref_category_id)) @if ($sub_category->ref_category_id == $item->id) selected @endif @endif value="{{$item->id}}">{{$item->category_name}}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid Category.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banner <span class="required">* The image size must not exceed 2 MB.</span></label>
                                        <div class="custom-file">
                                            <input name="sub_category_banner" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange2(this)" value="{{@$sub_category->sub_category_banner}}" @empty($sub_category->sub_category_banner) required @endempty>
                                            <label class="custom-file-label" for="customFile">@isset($sub_category->sub_category_banner) {{$sub_category->sub_category_banner}} @else Choose Picture @endisset</label>
                                        </div>
                                        <span class="required"> &nbsp; Suitable scale 1200 x 600 pixels.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="nameImg">Name image <span class="required">*</span></label>
                                        <input type="text" class="form-control" value="{{pathinfo(@$sub_category->sub_category_banner, PATHINFO_FILENAME)}}" id="nameImg" name="sub_category_banner_name" required>
                                    </div>
                                    {{-- <div class="col-md-12"> --}}
                                        <div class="form-group">
                                            <img class="img-thumbnail bannerPreview"@if(!isset($sub_category->sub_category_banner)) style="display: none;" @endif width="100%" src="{{ URL::asset('upload/sub_category/banner/'.@$sub_category->sub_category_banner) }}" data-holder-rendered="true">
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                        <div class="custom-file">
                                            <input name="sub_category_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$sub_category->sub_category_image}}" @empty($sub_category->sub_category_image) required @endempty>
                                            <label class="custom-file-label" for="customFile">@isset($sub_category->sub_category_image) {{$sub_category->sub_category_image}} @else Choose Picture @endisset</label>
                                        </div>
                                        <span class="required"> &nbsp;  Suitable scale 600 x 544 pixels.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="nameImg">Name image <span class="required">*</span></label>
                                        <input type="text" class="form-control" value="{{pathinfo(@$sub_category->sub_category_image, PATHINFO_FILENAME)}}" id="nameImg" name="sub_category_image_name" required>
                                    </div>
                                    {{-- <div class="col-md-12"> --}}
                                        <div class="form-group">
                                            <img class="img-thumbnail imagePreview"@if(!isset($sub_category->sub_category_image)) style="display: none;" @endif alt="200x200" width="200" src="{{ URL::asset('upload/sub_category/'.@$sub_category->sub_category_image) }}" data-holder-rendered="true">
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Detail</label>
                                        <textarea name="sub_category_detail" class="form-control" rows="6" placeholder="Detail">{{@$sub_category->sub_category_detail}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                            <div class="col-md-6">
                                    <label>Series <span class="required">*</span></label>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-sm table-nowrap">
                                            <tbody id="tbody">
                                            @if(@$sub_category->series) 
                                                @foreach ($sub_category->series as $key => $item)

                                                <tr id="tr{{$item->id}}" ids="{{$item->id}}" class="trbody" align="center">
                                                    <td><input type="text" name="series_name[{{$item->id}}]" class="form-control form-control-sm" placeholder="Holiday" style="text-align:center;" value="{{$item->series_name}}"></td>
                                                    <td><a href="javascript: void(0);" onclick="deleteDataSeries({{$item->id}})" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></td>
                                                </tr>

                                                @endforeach
                                            @endif
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                                
                                    <a type="button" class="btn btn-success" id="add" style="color:white;">add</a>
                                </div>
                            </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <button class="btn btn-primary" id="submitBtn">Save</button> &nbsp; &nbsp; 
                <a href="/admin/{{$page_url}}" type="button" class="btn btn-danger" id="submitBtn">cancel</a>
                        </div>
                    </div>
        </form>
        </div>
    </div>
    <!-- end row -->
</div>
                        <!-- end row -->
                <!-- end modal -->
@endsection

@section('script')
        <script>
            var max_id = '{{$max_series_id}}'|1;
            document.getElementById("add").addEventListener("click", function(event){
                var id = max_id++;
                $('#tbody').append('<tr id="tr'+id+'" ids='+id+' class="trbody" align="center"><td><input type="text" name="insert_series_name[]" class="form-control form-control-sm" placeholder="series" style="text-align:center;"></td><td><a href="javascript: void(0);" onclick="deleteSeries('+id+')" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></td></tr>');
                    // var u = $('#trFirst').html();
                    // $('#fr').html(u+u);
                // console.log(1543);
                    event.preventDefault()
            });
            function imgChange(input) {
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
                // readURL(input);
            }
            function imgChange2(input) {
                const size =  
                    (input.files[0].size / 1024 / 1024).toFixed(2); 

                if (size > 2) { 
                    $('.custom-file-input').val(null);
                    alert("The image size must not exceed 2 MB."); 
                    return false;
                }
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    $('.bannerPreview').show();
                    reader.onload = function(e) {
                    $('.bannerPreview').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
                // readURL(input);
            }
            function deleteSeries(id) {
                $('#tr'+id).remove();
            }
            function deleteDataSeries(id) {
                if(confirm('The data will be permanently deleted.!') != true){
                    return
                }
                $.ajax({
                    type: "delete",
                    url: "/admin/subcategory/delete_series/"+id,
                    data:{_token:'{{ csrf_token() }}'},
                    success: function( result ) {
                        // console.log(result)
                        if(result == true){
                            $('#tr'+id).remove();
                        }else{
                            alert("Can't delete data");
                        }
                    },error : function(e){
                            alert("Can't delete data");
                        console.log(e)
                    }
                });
            }
        </script>
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
@endsection