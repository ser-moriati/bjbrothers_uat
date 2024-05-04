<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
use App\Product;
use App\Brand;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class BrandController extends Controller
{
    public function index(Request $request, $id){
        $categorys = Category::orderBy('sort','ASC')->get();
        $sub_first = SubCategory::find($request->subcate);
        $category = Category::find(@$sub_first->ref_category_id);
        $brand = Brand::get();
        $sub_category = SubCategory::whereRaw('1=1');
        if(!is_null($request->subcate)){
            $sub_category = $sub_category->where('ref_category_id',$sub_first->ref_category_id);
        }
        $sub_category = $sub_category->orderBy('id','DESC')->get();
        $product = Product::where('ref_sub_category_id',$id)->orderBy('id','DESC')->paginate(20);

        $data['categorys'] = $categorys;
        $data['category'] = $category;
        $data['sub_first'] = $sub_first;
        $data['sub_category'] = $sub_category;
        $data['product'] = $product;
        $data['brand'] = $brand;

        return view('product_sub_category', $data);
    }
}
