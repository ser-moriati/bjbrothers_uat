<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Home;
use App\Project;
use App\Product;
use App\Category;
use App\HomeHasPromotion;
use App\News;
use App\Portfolio;
use App\ProductPrice;
use App\Promotion;
use App\Safety;
use App\Seo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

DB::beginTransaction();
// DB::beginTransaction();

class HomeController extends Controller
{
    public function index(){
        // $data = [];
        // Mail::send('mail.confirm_orders', $data, function ($message) {
        //     $message->from('worawe@ots.co.th', 'BJ');
        //     $message->to('wolverine.wek@gmail.com')
        //     ->subject("มี order");
        // });
        
        $data['meta'] = Seo::find(1);
        $data['home'] = Home::first();
        $product_recommended = Product::select('id','product_image','product_name','product_code','product_price','product_recommended','product_new','product_hot')->where('product_recommended','Y')->orderBy('id','DESC')->get();
        
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
    
        }
        $data['product_recommended'] = $product_recommended;
              
        $data['category'] = Category::select('id','category_name','image_home')->orderBy('sort',"ASC")->get();
        $data['project'] = Project::orderBy('id','DESC')->limit(3)->get();
        $data['banner'] =  DB::table('banner')->orderBy('banner_id','DESC')->get();
        $data['safetys'] =  DB::table('safetys')->orwhere('pin',1)->orderBy('id','DESC')->limit(1)->get();
        $data['promotions'] =  DB::table('promotions')->orwhere('pin',1)->orderBy('id','DESC')->limit(1)->get();
        $data['news'] =  DB::table('news')->orwhere('pin',1)->orderBy('id','DESC')->limit(1)->get();
        $home_has_promotion = HomeHasPromotion::orderBy('id','ASC')->limit(3)->get();
        foreach($home_has_promotion as $home_has){
            if($home_has->module == 'news'){
                $has = News::selectRaw('title,title_image as image,created_at')->find($home_has->ref_module_id);
                $home_has->url = 'news/'.$home_has->ref_module_id;
            }elseif($home_has->module == 'safety'){
                $has = Safety::selectRaw('safety_name as title,safety_image as image,created_at,ref_category_id')->find($home_has->ref_module_id);
                $home_has->url = 'safety/'.$has->ref_category_id.'/'.$home_has->ref_module_id;
            }elseif($home_has->module == 'portfolio'){
                $has = Portfolio::selectRaw('portfolio_image as image,created_at,ref_category_id')->find($home_has->ref_module_id);
                $home_has->url = 'portfolio/'.$has->ref_category_id;
            }
            $home_has->title = $has->title;
            $home_has->date  = $has->created_at;
            $home_has->image = $has->image;
        }
        $data['home_has_promotion'] = $home_has_promotion;
        return view('index', $data);

    }
}
