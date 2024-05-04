<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Safety;
use App\SafetyCategory;
use App\SafetyGallery;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class SafetyController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(5);

        $data['category'] = SafetyCategory::orderBy('id','DESC')->paginate(16);

        return view('safety', $data);
    }
    public function cate($cate_id = null){
        $data['meta'] = Seo::find(5);
        $safety = Safety::orderBy('id','DESC')->where('ref_category_id',$cate_id);

        $data['cate'] = SafetyCategory::find($cate_id);

        $data['safety'] = $safety->paginate(16);
        // $data['category'] = SafetyCategory::orderBy('id','DESC')->get();
        $data['cate_id'] = $cate_id;
        return view('safety_sub_category', $data);
    }
    public function detail($cate_id, $id){
        $data['cate'] = SafetyCategory::find($cate_id);
        $data['safety'] = Safety::find($id);
        // $data['gallery'] = SafetyGallery::where('ref_safety_id',$id)->get();
        return view('safety_detail', $data);
    }
}
