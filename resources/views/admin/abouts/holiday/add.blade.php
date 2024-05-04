@extends('layouts.master')

@section('title') About @endsection

@section('css') 

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
                        {{-- <li class="breadcrumb-item"><a href="javascript: void(0);">Year/li> --}}
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
            <form id="about_holidayForm" action="{{$action}}" method="post" class="needs-validation outer-repeater" novalidate="" enctype="multipart/form-data">
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                                {{-- <div class="row"> --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Picture <span class="required">* The image size must not exceed 2 MB.</span></label>
                                            <div class="custom-file">
                                                <input name="about_holiday_image" type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="imgChange(this)" value="{{@$holiday->about_holiday_image}}" @empty($holiday->about_holiday_image) required @endempty >
                                                <label class="custom-file-label" for="customFile">@isset($holiday->about_holiday_image) {{$holiday->about_holiday_image}} @else Choose Picture @endisset</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="nameImg">Name image <span class="required">*</span></label>
                                            <input type="text" class="form-control" value="{{pathinfo(@$holiday->about_holiday_image, PATHINFO_FILENAME)}}" id="nameImg" name="about_holiday_image_name" required>
                                        </div>
                                        {{-- <div class="col-md-12"> --}}
                                            <div class="form-group">
                                                <img class="img-thumbnail imagePreview"@if(!isset($holiday->about_holiday_image)) style="display: none;" @endif alt="{{@$holiday->about_holiday_image}}" width="100%" src="{{ URL::asset('upload/about/holiday/'.@$holiday->about_holiday_image) }}" data-holder-rendered="true">
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                {{-- </div> --}}
                                
                                <div class="col-md-6">
                                    <label>Annual holiday <span class="required">*</span></label>
                                    <div class="table-responsive">
                                        <table class="table table-centered table-sm table-nowrap">
                                            <thead class="thead-light">
                                                <tr align="center">
                                                    <th>Holiday</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody">

                                                @php 
                                                $count = DB::table('about_holidaysdate')->count();
                                               
                                                if($count == '0'){

                                                }else{

                                                $about_holidaysdate = DB::table('about_holidaysdate')->orderBy('about_holidaysdate_id')->get();
                                                if($about_holidaysdate){
                                                @endphp
                                                @foreach ($about_holidaysdate as  $item)

                                                <tr  class="trbody" align="center">
                                                    <td>{{$item->about_holidaysdate_name}}</td>
                                                    <td>{{$item->about_holidaysdate_date}}</td>
                                                    <td><a href="javascript: void(0);" onclick="deleteFromTableholiday({{$item->about_holidaysdate_id}})" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-delete font-size-18"></i></a></td>
                                                </tr>


                                                @endforeach

                                                @php
                                                }
                                            }
                                                @endphp 
                                                @foreach ($holiday->about_holiday_name as $key => $item)

                                                <tr id="tr{{$key}}" ids="{{$key}}" class="trbody" align="center">
                                                    <td><input type="text" name="about_holiday_name[]" class="form-control form-control-sm" placeholder="Holiday" style="text-align:center;" value="{{$item}}"></td>
                                                    <td><input type="text" name="about_holiday_date[]" class="form-control form-control-sm" placeholder="Date" style="text-align:center;"value="{{$holiday->about_holiday_date[$key]}}"></td>
                                                    <td><a href="javascript: void(0);" onclick="deleteHoliday({{$key}})" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                            
                                        </table>
                                    </div>
                                                
                                    <button class="btn btn-success" id="add">add</button>
                                </div>
                            {{-- </div> --}}
                    </div>
                </div>                            
                <div class="col-sm-12">
                    <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
        </form>

            </div>
        </div><br>
        </div>
    </div>
    <!-- end row -->
</div>
@include('layouts/modal')                      <!-- end row -->
                <!-- end modal -->
@endsection
@section('script')

<script>
    document.getElementById("add").addEventListener("click", function(event){
        var trbody = $('.trbody:last-child').attr('ids');
        var id = trbody+1;
        $('#tbody').append('<tr id="tr'+id+'" ids='+id+' class="trbody" align="center"><td><input type="text" name="about_holiday_name[]" class="form-control form-control-sm" placeholder="Holiday" style="text-align:center;"></td><td><input type="text" name="about_holiday_date[]" class="form-control form-control-sm" placeholder="Date" style="text-align:center;"></td><td><a href="javascript: void(0);" onclick="deleteHoliday('+id+')" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></td></tr>');
            // var u = $('#trFirst').html();
            // $('#fr').html(u+u);
        // console.log(1543);
            event.preventDefault()
    });
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
    
    function deleteHoliday(id) {
        $('#tr'+id).remove();
    }
</script>
        <!-- Magnific Popup-->
        <script src="{{ URL::asset('assets/libs/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

        <!-- lightbox init js-->
        <script src="{{ URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
<script >
        function deleteFromTableholiday(id){
            $('#exampleModalScrollable').modal('show');
            $('.confirmDelete').attr("id",id);
        }
        function deleteData(module) {
            var id = $('.confirmDelete').attr("id");
            var token = document.getElementById("token").value;
            $.ajax({
                type: "DELETE",
                url: "{!! url('admin/about/holiday/delete/"+id+"') !!}",
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
        <!-- plugin js -->
        <script src="{{ URL::asset('assets/js/pages/form-repeater.int.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/jquery.repeater/jquery.repeater.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script>
        <script src="{{ URL::asset('assets/libs/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
        <script src="{{ URL::asset('assets/js/pages/form-element.init.js')}}"></script>
@endsection