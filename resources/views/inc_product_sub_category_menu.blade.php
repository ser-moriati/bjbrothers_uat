
        <div class="modal-footer">
            <span style="font-size: large;">
            <b>{{ $category_name }}</b>
            </span>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <div class="modal-body">
            <div class="row">
                        @foreach ($result as $cate_me)
                        <div class="col-4">
                            <a href="{{url('subcategory/'.$cate_me->sub_category_name)}}">
                                <img width="100%" src="{{URL::asset('upload/sub_category/'.$cate_me->sub_category_image)}}">
                                <div style="color: #555;">{{$cate_me->sub_category_name}}</div>
                                <div>&nbsp;</div>
                            </a>
                        </div>
                        @endforeach
            </div>
        </div>
{{-- <div class="dropdown-container"> --}}
    {{-- <ul class="submenudrop">
    </ul> --}}
{{-- </div> --}}