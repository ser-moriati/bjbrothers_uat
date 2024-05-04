<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Install;
use App\InstallCategory;
use App\InstallGallery;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class InstallController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(5);

        $data['category'] = InstallCategory::orderBy('id','DESC')->paginate(16);

        return view('install', $data);
    }
    public function cate($cate_id = null){
        $data['meta'] = Seo::find(5);
        $install = Install::orderBy('id','DESC')->where('ref_category_id',$cate_id);

        $data['cate'] = InstallCategory::find($cate_id);

        $data['install'] = $install->paginate(16);
        // $data['category'] = InstallCategory::orderBy('id','DESC')->get();
        $data['cate_id'] = $cate_id;
        return view('install_sub_category', $data);
    }
    public function detail($cate_id, $id){
        $data['cate'] = InstallCategory::find($cate_id);
        $data['install'] = Install::find($id);
        $data['meta'] = (object)['meta_title' => $data['install']->meta_title , 'meta_keywords' => $data['install']->meta_keywords , 'meta_description' => $data['install']->meta_description];
        // $data['gallery'] = InstallGallery::where('ref_install_id',$id)->get();
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->where('recommend_ref_article',$id)->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }

        $data['recommand_product'] = DB::table('products')->whereIn('id',$recommend_product)->get();
        return view('install_detail', $data);
    }
}
