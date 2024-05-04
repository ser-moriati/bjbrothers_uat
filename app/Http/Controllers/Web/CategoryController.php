<?php

namespace App\Http\Controllers\Web;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class CategoryController extends Controller
{
    public function index($name){
        $data['categorys'] = Category::orderBy('sort','ASC')->get();
        $data['brand'] = Brand::get();
        $data['category'] = Category::where('category_name',$name)->first();
        $data['cate_id'] = $data['category']->id;

        $data['sub_category'] = SubCategory::orderBy('sort','ASC')->get();

        $data['sub_category_by_cate'] = SubCategory::orderBy('sort','ASC')->where('ref_category_id',$data['category']->id)->get();
        return view('product_category', $data);
    }
}
