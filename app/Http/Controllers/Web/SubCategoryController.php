<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Category;
use App\SubCategory;
use App\Product;
use App\Brand;
use App\ProductPrice;
use App\Seo;
use App\Series;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class SubCategoryController extends Controller
{
    public function index(Request $request,$name)
    {
        $data['meta'] = Seo::find(4);
        $categorys = Category::orderBy('sort','ASC')->get();
        $sub_first = SubCategory::where('sub_category_name', $name)->first();
        $category = Category::find($sub_first->ref_category_id);
        $brand_first = Brand::find($request->brand);
        $brand = Brand::get();
        $sub_category = SubCategory::orderBy('sort','ASC')->get();
        $product = Product::where('ref_sub_category_id',$sub_first->id);
        if(!is_null($request->brand)){
            $product = $product->where('ref_brand_id',$request->brand);
        } 
        if(!is_null($request->series_id)){
            $product = $product->where('ref_series_id',$request->series_id);
        }        
        if(!is_null($request->sort)){
            if($request->sort == 'name'){
                $product = $product->orderBy('product_name','ASC');
            }elseif($request->sort == 'latest'){
                $product = $product->orderBy('id','DESC');
            }    
        }else{
            $product = $product->orderBy('id','DESC');
        }
        $product = $product->paginate(20);
        
        // $role_id = 1;
        // if(@Auth::guard('member')->user()->ref_role_id){
        //     $role_id = Auth::guard('member')->user()->ref_role_id;
        // }
    

        $role_id = 0;
        foreach($product as $pro){
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
          
            $sale = DB::table('productsku')
            ->select('ref_product_id',  DB::raw('MIN(price_0) as min_sale0'), DB::raw('MIN(price_1) as min_sale1')
            , DB::raw('MIN(price_2) as min_sale2') , DB::raw('MIN(price_3) as min_sale3'))
            ->where('ref_product_id',  $pro->id)
            ->groupBy('ref_product_id')
            ->get();
        
            if ($sale->count() > 0) {
                if($role_id == 1){
                    $pro->product_price = $sale[0]->min_sale1; // แก้ตรงนี้เป็น min_sale
                }elseif($role_id == 2){
                    $pro->product_price = $sale[0]->min_sale2;
                }elseif($role_id == 3){
                    $pro->product_price = $sale[0]->min_sale3;
                }else{
                    $pro->product_price = $sale[0]->min_sale0; // แก้ตรงนี้เป็น min_sale
                }
            
            
            } else {
                $pro->product_price = 0.00;
            }
            
        }else{
            $role_id == 0 ;
            $sale = DB::table('productsku')
            ->select('ref_product_id',  DB::raw('MIN(price_0) as min_sale0'), DB::raw('MIN(price_1) as min_sale1')
            , DB::raw('MIN(price_2) as min_sale2') , DB::raw('MIN(price_3) as min_sale3'))
            ->where('ref_product_id',  $pro->id)
            ->groupBy('ref_product_id')
            ->get();
        
            if ($sale->count() > 0) {
                if($role_id == 1){
                    $pro->product_price = $sale[0]->min_sale1; // แก้ตรงนี้เป็น min_sale
                }elseif($role_id == 2){
                    $pro->product_price = $sale[0]->min_sale2;
                }elseif($role_id == 3){
                    $pro->product_price = $sale[0]->min_sale3;
                }else{
                    $pro->product_price = $sale[0]->min_sale0; // แก้ตรงนี้เป็น min_sale
                }
            
            
            } else {
                
                $pro->product_price = 0.00;
        
            }
        }
        
    } 
        $data['series'] = Series::where('ref_sub_category_id', $sub_first->id)->get();

        $data['categorys'] = $categorys;
        $data['category'] = $category;
        $data['cate_id'] = $category->id;
        $data['sub_first'] = $sub_first;
        $data['sub_category'] = $sub_category;
        $data['product'] = $product;
        $data['brand'] = $brand;
        $data['brand_first'] = $brand_first;

        return view('product_sub_category', $data);
    }
    public function get_by_cate($id)
    {
        $result = SubCategory::where('ref_category_id', $id)->orderBy('sort','ASC')->get();
        $data['category_name'] = Category::find($id)->category_name;
        $data['result'] = $result;

        return view('inc_product_sub_category_menu', $data);
    }
}
