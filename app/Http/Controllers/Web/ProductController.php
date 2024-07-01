<?php

namespace App\Http\Controllers\Web;

use App\Brand;
use App\Cart;
use App\Http\Controllers\Controller;
use App\ProductGallery;
use App\ProductFile;
use App\Product;
use App\Color;
use App\Size;
use App\Category;
use App\ProductPrice;
use App\QuotationCart;
use App\Roles;
use App\ProductskUModel;
use App\ProductsOptionHead;
use App\ProductsOption1;
use App\ProductsOption2;

// use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

DB::beginTransaction();
// DB::beginTransaction();

class ProductController extends Controller
{
    public function index($name_code){
        // Session::forget('quotation_cart');
        $ex = explode('___', $name_code);
        $name = $ex[0];
        $code = $ex[1];
        $member_id = @Auth::guard('member')->user()->id;
        
        $product = Product::select('products.*','categorys.category_name','sub_categorys.sub_category_name','brands.brand_name')
                            ->leftJoin('categorys','categorys.id','=','products.ref_category_id')
                            ->leftJoin('sub_categorys','sub_categorys.id','=','products.ref_sub_category_id')
                            ->leftJoin('brands','brands.id','=','products.ref_brand_id')
                            // ->where('products.product_name',$name)
                            ->Where('products.id',$code)
                            ->first();
        if($member_id){
            $data['quotation'] = QuotationCart::where('ref_member_id',$member_id)->where('ref_product_id',$product->id)->count();
            $data['cart'] = Cart::where('ref_member_id',$member_id)->where('ref_product_id',$product->id)->count();
        }else{
            if(@Session::get('quotation_cart')){
                    if(in_array($product->id,Session::get('quotation_cart'))){
                        $data['quotation'] = 1;
                    }
                // }
            }
        }
        $data['related_product'] = Product::where('ref_sub_category_id',$product->ref_sub_category_id)->inRandomOrder()->limit(5)->get();
        $data['gallery'] = ProductGallery::where('ref_product_id',$product->id)->orderBy('id','DESC')->get();
        $data['files'] = ProductFile::where('ref_product_id',$product->id)->orderBy('id','DESC')->get();
        
    
      
        $role_id = 0;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
        
        if(@$role_id == 0){
            $role_name = "ราคาทั่วไป";
        }else{
            $role_name = Roles::find($role_id)->role_name;
        }
        $data['ProductsOptionHead'] = ProductsOptionHead::where('product_id',$code)->get();
        $data['ProductsOption1'] = ProductsOption1::where('product_id',$code)->get();
        $data['ProductsOption2'] = ProductsOption2::where('product_id',$code)->get();
        $product_prices = DB::table('productsku')
        ->select('ref_product_id', DB::raw('SUM(price_0) as total_sale'), DB::raw('MIN(price_0) as min_sale0'), DB::raw('MIN(price_1) as min_sale1'), DB::raw('MIN(price_2) as min_sale2')
        , DB::raw('MIN(price_3) as min_sale3'), DB::raw('MAX(price_0) as max_sale0'), DB::raw('MAX(price_1) as max_sale1'), DB::raw('MAX(price_2) as max_sale2'), DB::raw('MAX(price_3) as max_sale3'))
        ->where('ref_product_id', $code)
        ->groupBy('ref_product_id')
        ->get();
    
    if ($product_prices->count() > 0) {
        if($role_id == 1){
            $data['min_sale'] = $product_prices[0]->min_sale1; // แก้ตรงนี้เป็น min_sale
            $data['max_sale'] = $product_prices[0]->max_sale1; 
          
        }elseif($role_id == 2){
            $data['min_sale'] = $product_prices[0]->min_sale2;
            $data['max_sale'] = $product_prices[0]->max_sale2; 
        }elseif($role_id == 3){
            $data['min_sale'] = $product_prices[0]->min_sale3;
            $data['max_sale'] = $product_prices[0]->max_sale3; 
        }else{
            $data['min_sale'] = $product_prices[0]->min_sale0; 
            $data['max_sale'] = $product_prices[0]->max_sale0; 
        }
    } else {
        $role_name = '';
        $data['min_sale'] = null;
        $data['max_sale'] = null;
    }

        $data['role_name'] = $role_name;
        $data['product'] = $product;
        $data['meta'] = $product;
        $data['product_id'] = $code;
        return view('product_detail', $data);
    }
    public function getidcolor(Request $request)
    {
        $colorId = $request->input('id_color');
        $productId = $request->input('product_id');

        $productskusizescheck = DB::table('productsku')
            ->where('ref_product_id', $productId)
            ->where('product_option_1_id', $colorId)
            ->first();

        if ($productskusizescheck) {
            $wordscheck = explode(" ", $productskusizescheck->name_th);

            if ($wordscheck[1] == 0) {
                $role_id = Auth::guard('member')->user()->ref_role_id ?? 0;

                switch ($role_id) {
                    case 1:
                        $price = $productskusizescheck->price_1;
                        break;
                    case 2:
                        $price = $productskusizescheck->price_2;
                        break;
                    case 3:
                        $price = $productskusizescheck->price_3;
                        break;
                    default:
                        $price = $productskusizescheck->price_0;
                        break;
                }

                $result = [
                    'productskusizes_id' => $productskusizescheck->id,
                    'color' => $productskusizescheck->product_option_1_id,
                    'size' => $productskusizescheck->product_option_2_id,
                    'ref_product_id' => $productskusizescheck->ref_product_id,
                    'qty' => $productskusizescheck->product_qty,
                    'price' => $price,
                    'product_check' => 0,
                ];

                return response()->json(['result' => $result]);
            } else {
                $productskusizes = DB::table('productsku')
                    ->where('ref_product_id', $productId)
                    ->where('product_option_1_id',$colorId)
                    ->get();

                $result = [];

                $ProductsOption2 = ProductsOption2::where('product_id',$productId)->get();

                if($ProductsOption2){
                    if (count($productskusizes) > 0) {
                      
                        foreach ($productskusizes as $productsku) {
                            if($productsku->product_option_2_id != null){
                                $words = explode(" ", $productsku->name_th);
                                $name_show2= DB::table("productsoption2")->where("id",$productsku->product_option_2_id)->first();
                                $result[] = [
                                    'productskusizes_id' => $productsku->id,
                                    'product_size_name' => $name_show2->name_th,
                                    'product_check' => 1,
                                    'color' => $productsku->product_option_1_id,
                                ];
                            }else{
                                $role_id = Auth::guard('member')->user()->ref_role_id ?? 0;

                                switch ($role_id) {
                                    case 1:
                                        $price = $productskusizescheck->price_1;
                                        break;
                                    case 2:
                                        $price = $productskusizescheck->price_2;
                                        break;
                                    case 3:
                                        $price = $productskusizescheck->price_3;
                                        break;
                                    default:
                                        $price = $productskusizescheck->price_0;
                                        break;
                                }
                
                                $result = [
                                    'productskusizes_id' => $productskusizescheck->id,
                                    'color' => $productskusizescheck->product_option_1_id,
                                    'size' => $productskusizescheck->product_option_2_id,
                                    'ref_product_id' => $productskusizescheck->ref_product_id,
                                    'qty' => $productskusizescheck->product_qty,
                                    'price' => $price,
                                    'product_check' => 0,
                                ];
                
                             
                                return response()->json(['result' => $result]);
                            }
                           
                        }
                    } else {
                        return response()->json(['error' => $colorId]);
                    }
                    
                }else{
                    $role_id = Auth::guard('member')->user()->ref_role_id ?? 0;

                    switch ($role_id) {
                        case 1:
                            $price = $productskusizescheck->price_1;
                            break;
                        case 2:
                            $price = $productskusizescheck->price_2;
                            break;
                        case 3:
                            $price = $productskusizescheck->price_3;
                            break;
                        default:
                            $price = $productskusizescheck->price_0;
                            break;
                    }
    
                    $result = [
                        'productskusizes_id' => $productskusizescheck->id,
                        'color' => $productskusizescheck->product_option_1_id,
                        'size' => $productskusizescheck->product_option_2_id,
                        'ref_product_id' => $productskusizescheck->ref_product_id,
                        'qty' => $productskusizescheck->product_qty,
                        'price' => $price,
                        'product_check' => 0,
                    ];
    
                 
                    return response()->json(['result' => $result]);
                }
              
            }

            return response()->json(['result' => $result]);
        } else {
            return response()->json(['error' => 'Product not found']);
        }
    }

    public function getidsize(Request $request)
    {
        $productsku_id = $request->input('productsku_id');

        // ต่อไปคือโค้ดเพิ่มเติมของคุณ
        $productskusizes = DB::table('productsku')
        ->where('id', $productsku_id)
        ->get();

        $role_id = 0;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
        
        if(@$role_id == 0){
            $role_name = "ราคาทั่วไป";
        }else{
            $role_name = Roles::find($role_id)->role_name;
        }
      
        $result = [];

        // ตรวจสอบว่า $productskusizes มีข้อมูลหรือไม่
        if (count($productskusizes) > 0) {
            foreach ($productskusizes as $productskusizes) {
                if($role_id == 1){
                    $price = $productskusizes->price_1; // แก้ตรงนี้เป็น min_sale
                   
                   
                 }elseif($role_id == 2){
                    $price = $productskusizes->price_2;
                 }elseif($role_id == 3){
                    $price = $productskusizes->price_3;
                 }else{
                    $price = $productskusizes->price_0;
                 }
                
                // เพิ่มข้อมูลลงใน $result
                $result[] = [
                    'productskusizes_id' => $productskusizes->id, 
                    'color'              => $productskusizes->product_option_1_id,
                    'size'               => $productskusizes->product_option_2_id,
                    'ref_product_id'     => $productskusizes->ref_product_id,
                    'qty'               => $productskusizes->product_qty,
                    'price'               => $price,
                    // สามารถเพิ่มข้อมูลอื่น ๆ ตามต้องการ
                ];
            }
            
        } else {
            // กรณีไม่พบข้อมูล
            return response()->json(['error' => $colorId ]);
        }

        // ส่ง JSON response กลับไปยังหน้า HTML
        return response()->json(['result' => $result]);
    }

    public function newarrival(Request $request){
        $data['categorys'] = Category::orderBy('sort','ASC')->get();
        $product = Product::where('product_new','1')->orderBy('id','DESC');
        if(@$request->s){
            $product = $product->where('product_name','LIKE','%'.$request->s.'%')->orWhere('product_code','LIKE','%'.$request->s.'%');    
        }
        $product = $product->paginate(20);
        
        $role_id = 1;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }

        dd($product);
        
        foreach($product as $pro){
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
        $brand = Brand::get();
        $data['search'] = @$request->s;
        $data['product'] = $product;
        $data['brand'] = $brand;

        return view('newarrival', $data);
    }
    public function product_recommended(Request $request){
        $product_recommended = Product::select('id','product_image','product_name','product_code','product_price','product_recommended','product_new','product_hot')->where('product_recommended','Y')->get();
        
        $role_id = 0;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
    

        foreach($product_recommended as $pro){
            $sale = DB::table('productsku')
            ->select('ref_product_id',  DB::raw('MIN(price_0) as min_sale0'), DB::raw('MIN(price_1) as min_sale1')
            , DB::raw('MIN(price_2) as min_sale2') , DB::raw('MIN(price_3) as min_sale3'))
            ->where('ref_product_id',  $pro->id)
            ->groupBy('ref_product_id')
            ->get();
        
        if ($sale->count() > 0) {
            if($role_id == 1){
                $pro->product_price =$sale[0]->min_sale1; // แก้ตรงนี้เป็น min_sale
            }elseif($role_id == 2){
                $pro->product_price =$sale[0]->min_sale2;
            }elseif($role_id == 3){
                $pro->product_price =$sale[0]->min_sale3;
            }else{
                $pro->product_price =$sale[0]->min_sale0; // แก้ตรงนี้เป็น min_sale
            }
           
           
        } else {
            $pro->product_price  = 0.00;
        }
        $data['product_recommended'] = $product_recommended;

    }

        return view('PRODUCT_RECOMMENDED',$data);
    }

    public function search(Request $request){
        $data['categorys'] = Category::orderBy('sort','ASC')->get();
        $product = Product::whereRaw('1=1');
        if(@$request->s){
            $product = $product->where('product_name','LIKE','%'.$request->s.'%')->orWhere('product_code','LIKE','%'.$request->s.'%');    
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
        $product = $product->paginate(20)->appends(request()->query());
        $role_id = 0;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
        foreach($product as $pro){
            $sale = DB::table('productsku')
            ->select('ref_product_id',  DB::raw('MIN(price_0) as min_sale0'), DB::raw('MIN(price_1) as min_sale1')
            , DB::raw('MIN(price_2) as min_sale2') , DB::raw('MIN(price_3) as min_sale3'))
            ->where('ref_product_id',  $pro->id)
            ->groupBy('ref_product_id')
            ->get();
        
            if ($sale->count() > 0) {
                if($role_id == 1){
                    $pro->product_sale = $sale[0]->min_sale1; // แก้ตรงนี้เป็น min_sale
                }elseif($role_id == 2){
                    $pro->product_sale = $sale[0]->min_sale2;
                }elseif($role_id == 3){
                    $pro->product_sale = $sale[0]->min_sale3;
                }else{
                    $pro->product_sale = $sale[0]->min_sale0; // แก้ตรงนี้เป็น min_sale
                }
            
            
            } else {
                
                $pro->product_sale = 0.00;
        
            }
           
    
        }
        $brand = Brand::get();
        $data['search'] = @$request->s;
        $data['product'] = $product;
        $data['brand'] = $brand;

        return view('search_product', $data);
    }
}
