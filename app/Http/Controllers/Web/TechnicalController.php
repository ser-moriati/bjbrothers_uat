<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Technical;
use App\TechnicalCategory;
use App\TechnicalGallery;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class TechnicalController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(5);

        $data['category'] = TechnicalCategory::orderBy('id','DESC')->paginate(16);

        return view('technical', $data);
    }
    public function cate($cate_id = null){
        $data['meta'] = Seo::find(5);
        $technical = Technical::orderBy('id','DESC')->where('ref_category_id',$cate_id);

        $data['cate'] = TechnicalCategory::find($cate_id);

        $data['technical'] = $technical->paginate(16);
        // $data['category'] = TechnicalCategory::orderBy('id','DESC')->get();
        $data['cate_id'] = $cate_id;
        return view('technical_sub_category', $data);
    }
    public function detail($cate_id, $id){
        $data['cate'] = TechnicalCategory::find($cate_id);
        $data['technical'] = Technical::find($id);
        // $data['gallery'] = TechnicalGallery::where('ref_technical_id',$id)->get();
        $data['meta'] = (object)['meta_title' => $data['technical']->meta_title , 'meta_keywords' => $data['technical']->meta_keywords , 'meta_description' => $data['technical']->meta_description];
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->where('recommend_ref_article',$id)->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }

        $data['recommand_product'] = DB::table('products')->whereIn('id',$recommend_product)->get();
        return view('technical_detail', $data);
    }
}
