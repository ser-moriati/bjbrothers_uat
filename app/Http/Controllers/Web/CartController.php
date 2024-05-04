<?php

namespace App\Http\Controllers\Web;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ShippingCostController;
use App\ProductPrice;
use App\ShippingCost;
use Illuminate\Http\Request;
use Auth;
use App\Roles;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Product;

DB::beginTransaction();
// DB::beginTransaction();

class CartController extends Controller
{
    public function index(){
        // Session::put('vat',1);
        // Session::forget('vat');
    //กรณีที่ล็อกอิน
    if(@Auth::guard('member')->user()->id){
        $session_vat = Session::get('vat');
            // $vat = 0;
        // if($session_vat){
        //     $vat = 
        // }
        $data['session_vat'] = $session_vat;
        // Session::put('vat', 1);

        $data['page'] = 'Company';
        $member_id = FacadesAuth::guard('member')->user()->id;
        $cart = Cart::selectRaw('carts.*, products.id as product_id, products.product_name, products.product_weight*carts.qty as weight, products.product_image, products.product_code, products.product_price, productsku.price_1,productsku.price_2,productsku.price_3,productsku.price_0, productsku.name_th, productsku.product_qty, productsoption1.name_th as name_th1, productsoption2.name_th as name_th2')
                            ->leftJoin('products','products.id','=','carts.ref_product_id')
                            ->leftJoin('productsku','productsku.id','=','carts.productskusizes_id')
                            ->leftJoin('productsoption1','productsoption1.id','=','productsku.product_option_1_id')
                            ->leftJoin('productsoption2','productsoption2.id','=','productsku.product_option_2_id')
                            ->where('carts.ref_member_id',$member_id)
                            ->orderBy('id','DESC')->get();

        // $cart->product_weight*
        
        $role_id = 1;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
        foreach($cart as $pro){
          
            // $pro->product_price = $product_price == null? 0:$product_price->product_price;
            // $pro->product_sale = $product_price == null? 0:$product_price->product_sale;
        
            $role_id = 0;
            if(@Auth::guard('member')->user()->ref_role_id){
                $role_id = Auth::guard('member')->user()->ref_role_id;
            }
            $role_name = Roles::find($role_id)->role_name;
        
            if($pro){
                if($role_id == 1){
                    $price = $pro->price_1; // แก้ตรงนี้เป็น min_sale
                 }elseif($role_id == 2){
                    $price = $pro->price_2;
                 }elseif($role_id == 3){
                    $price = $pro->price_3;
                 }else{
                    $price = $pro->price_0;
                 }
                $pro->product_price = $price;
              
            }
        }
        $data['cart'] = $cart;

    //ไม่ล็อกอิน
    }else{
          // $vat = 0;
        // if($session_vat){
        //     $vat = 
        // }

        $session_vat = Session::get('vat');
        $data['session_vat'] = $session_vat;
        // Session::put('vat', 1);

        $data['page'] = 'Company';
        if (Session::has('quotation_cart')) {
            foreach (Session::get('quotation_cart') as $key => $quotation) {
                $qty = $quotation['qty'];
                $cart = Product::selectRaw('products.*, products.id as product_id, products.product_name, products.product_weight * 0 as weight, products.product_image, products.product_code, products.product_price, products.product_sale, colors.color_name, sizes.size_name')
                ->leftJoin('carts', 'products.id', '=', 'carts.ref_product_id')
                ->leftJoin('colors', 'colors.id', '=', 'carts.ref_color_id')
                ->leftJoin('sizes', 'sizes.id', '=', 'carts.ref_size_id')
                ->where('products.id', $quotation['id'])
                ->orderBy('id', 'DESC')
                ->get();

            
            
        
                // รายละเอียดโค้ดที่ต้องการให้ทำงานภายในลูป foreach
            }
        }
        
        $role_id = 1;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
        foreach($cart as $pro){
          
            // $pro->product_price = $product_price == null? 0:$product_price->product_price;
            // $pro->product_sale = $product_price == null? 0:$product_price->product_sale;
        
            $role_id = 0;
            if(@Auth::guard('member')->user()->ref_role_id){
                $role_id = Auth::guard('member')->user()->ref_role_id;
            }
            $role_name = Roles::find($role_id)->role_name;
        
            if($pro){
                if($role_id == 1){
                    $price = $pro->price_1; // แก้ตรงนี้เป็น min_sale
                 }elseif($role_id == 2){
                    $price = $pro->price_2;
                 }elseif($role_id == 3){
                    $price = $pro->price_3;
                 }else{
                    $price = $pro->price_0;
                 }
                $pro->product_price = $price;
              
            }
        }
        $data['cart'] = $cart;
        
        $data['shipping_cost'] = ShippingCostController::calculate($cart->sum->weight);  
    }
 


       
  
        return view('cart', $data);

    }
    public function indexcart_session(){
        $session_vat = Session::get('vat');
        $data['session_vat'] = $session_vat;
        $data['shipping_cost'] = 40;  
        return view('cart_session', $data);

    }
    public function addCart(Request $request){
// return 12;
        try{
           
            $member_id = Auth::guard('member')->user()->id;
            $productskusizes = Cart::where('productskusizes_id',$request->productsku_id)
                ->where('ref_member_id', $member_id)
                ->first();

            if ($productskusizes) {
                $qty = $productskusizes->qty + $request->qty;
                $cart = Cart::where('productskusizes_id',$request->productsku_id)
                ->where('ref_member_id', $member_id)
                ->first();

                if ($cart) {
                    $cart->qty = $qty;
                    $cart->save();
                } else {
                    // Handle the case where the cart entry doesn't exist (optional).
                }
            } else {
                $cart = new Cart;
                $cart->ref_member_id = $member_id;
                $cart->ref_product_id = $request->product_id;
                $cart->ref_color_id = $request->color_id;
                $cart->ref_size_id = $request->size_id;
                $cart->productskusizes_id = $request->productsku_id;
                $cart->qty = $request->qty;
                $cart->save();
            }
            // $cart = new Cart;
            // $cart->ref_member_id = '$member_id';
            // $cart->ref_product_id = $request->product_id;
            // $cart->ref_color_id = $request->color_id;
            // $cart->ref_size_id = $request->size_id;
            // $cart->qty = $request->qty;
            // $cart->save();

            $cartAll = Cart::where('ref_member_id',$member_id)->count();
            DB::commit();
            return response(['status'=>'201','message'=>$cartAll]);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    
    public function update(Request $request){
        try{
            $cart = Cart::find($request->id);
            $cart->qty = $request->qty;
            $cart->save();
            DB::commit();
            $totalPrice = 0; // กำหนดค่าเริ่มต้นของผลรวมเป็น 0
        
            if (Session::has('selected_products')) {
                foreach (Session::get('selected_products') as $key => $selected_products) {
                    $role_id = 1;
                    if (@Auth::guard('member')->user()->ref_role_id) {
                        $role_id = Auth::guard('member')->user()->ref_role_id;
                    }
                    
                    $role_name = DB::table('roles')->where('id', $role_id)->first();
                    
                    $sumselected_products = DB::table('carts')->where('id', $selected_products)->first();
                
                    $productskusizes = DB::table('productsku')
                    ->where('id', $sumselected_products->productskusizes_id)
                    ->first();
    
                    $discount = 0;
                    if($productskusizes){
                        
                        if($role_id = 1){
                            $price = $productskusizes->price_1; 
                        }elseif($role_id = 2){
                            $price = $productskusizes->price_2;
                        }elseif($role_id =3){
                            $price = $productskusizes->price_3;
                        }else{
                            $price = $productskusizes->price_0;
                        }
                        $discount = $price;
                    
                    }
                    
                    $price_total = $discount * $request->qty;
                    $totalPrice += $price_total; // เพิ่มค่า $price_total เข้าสู่ผลรวม
                }
            }
            
            $totalFormatted = number_format($totalPrice); // จัดรูปแบบผลรวมให้อยู่ในรูปแบบที่ต้องการ
          return response()->json(['message' => $totalFormatted]);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function remove(Request $request){

        try{

            Cart::destroy($request->id);
            Session::forget('selected_products');
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function ChangeVat(Request $request){
        $totalPrice = 0; // กำหนดค่าเริ่มต้นของผลรวมเป็น 0
        if($request->check == 1){
            Session::put('vat',1);
            if (Session::has('selected_products')) {
                foreach (Session::get('selected_products') as $key => $selected_products) {
                    $role_id = 1;
                    if (@Auth::guard('member')->user()->ref_role_id) {
                        $role_id = Auth::guard('member')->user()->ref_role_id;
                    }
                    
                    $role_name = DB::table('roles')->where('id', $role_id)->first();
                    
                    $sumselected_products = DB::table('carts')->where('id', $selected_products)->first();
                
                    $productskusizes = DB::table('productsku')
                    ->where('id', $sumselected_products->productskusizes_id)
                    ->first();
    
                    $discount = 0;
                    if($productskusizes){
                        
                        if($role_id = 1){
                            $price = $productskusizes->price_1; 
                        }elseif($role_id = 2){
                            $price = $productskusizes->price_2;
                        }elseif($role_id =3){
                            $price = $productskusizes->price_3;
                        }else{
                            $price = $productskusizes->price_0;
                        }
                        $discount = $price;
                    
                    }
                    $price_total = $discount * $sumselected_products->qty;
                    $totalPrice += $price_total; // เพิ่มค่า $price_total เข้าสู่ผลรวม
                }
            }
        }else{
            Session::forget('vat');
            if (Session::has('selected_products')) {
                foreach (Session::get('selected_products') as $key => $selected_products) {
                    $role_id = 1;
                    if (@Auth::guard('member')->user()->ref_role_id) {
                        $role_id = Auth::guard('member')->user()->ref_role_id;
                    }
                    
                    $role_name = DB::table('roles')->where('id', $role_id)->first();
                    
                    $sumselected_products = DB::table('carts')->where('id', $selected_products)->first();
                
                    $productskusizes = DB::table('productsku')
                    ->where('id', $sumselected_products->productskusizes_id)
                    ->first();
    
                    $discount = 0;
                    if($productskusizes){
                        
                        if($role_id = 1){
                            $price = $productskusizes->price_1; 
                        }elseif($role_id = 2){
                            $price = $productskusizes->price_2;
                        }elseif($role_id =3){
                            $price = $productskusizes->price_3;
                        }else{
                            $price = $productskusizes->price_0;
                        }
                        $discount = $price;
                    
                    }
                    
                    $price_total = $discount * $sumselected_products->qty;
                    $totalPrice += $price_total; // เพิ่มค่า $price_total เข้าสู่ผลรวม
                }
            }
        }
         return response()->json([
            'message' => $totalPrice,
            'check' => $request->check
        ]);
    }
    public function Changelist(Request $request){
        if($request->check == 1){
        $product_code = $request->list;
        Session::push('list_cart', ['id' => $product_code]);
        $list_cart = Session::get('list_cart');
        }else{
            $q = Session::pull('list_cart');
            foreach($q as $k => $v){
                if($v['id'] == $product_code){
                    unset($q[$k]);
                    break;
                }
            }
            Session::put('list_cart',$q);
        }
        return 1;
    }
    public function updateSession(Request $request)
    {
        $selectedProductIds = $request->input('selectedProductIds');
        Session::put('selected_products', $selectedProductIds);
        
        $totalPrice = 0; // กำหนดค่าเริ่มต้นของผลรวมเป็น 0
        
        if (Session::has('selected_products')) {
            foreach (Session::get('selected_products') as $key => $selected_products) {
                $role_id = 1;
                if (@Auth::guard('member')->user()->ref_role_id) {
                    $role_id = Auth::guard('member')->user()->ref_role_id;
                }
                
                $role_name = DB::table('roles')->where('id', $role_id)->first();
                
                $sumselected_products = DB::table('carts')->where('id', $selected_products)->first();
                
                $productskusizes = DB::table('productsku')
                ->where('id', $sumselected_products->productskusizes_id)
                ->first();

                $discount = 0;
                if($productskusizes){
                    
                    if($role_id = 1){
                        $price = $productskusizes->price_1; 
                    }elseif($role_id = 2){
                        $price = $productskusizes->price_2;
                    }elseif($role_id =3){
                        $price = $productskusizes->price_3;
                    }else{
                        $price = $productskusizes->price_0;
                    }
                    $discount = $price;
                
                }
                
                $price_total = $discount * $sumselected_products->qty;
                $totalPrice += $price_total; // เพิ่มค่า $price_total เข้าสู่ผลรวม
            }
        }
        
        $totalFormatted = number_format($totalPrice); // จัดรูปแบบผลรวมให้อยู่ในรูปแบบที่ต้องการ
        
        return response()->json(['message' => $totalFormatted]);
    }

 
    public function clearSessionAndRefresh(Request $request)
    {
        $keyToDelete = $request->input('key');
        Session::forget($keyToDelete);
        
        return response()->json(['message' => 'Session value deleted successfully']);
    }
    public function Check_price(Request $request){
        try{

            if (Session::has('selected_products')) {
                foreach (Session::get('selected_products') as $key => $selected_products) {
                    $role_id = 1;
                    if (Auth::guard('member')->user() && Auth::guard('member')->user()->ref_role_id) {
                        $role_id = Auth::guard('member')->user()->ref_role_id;
                    }
                    
                    $role_name = DB::table('roles')->where('id', $role_id)->first();
                    
                    $sumselected_products = DB::table('carts')->where('id', $selected_products)->first();
                
                    $productskusizes = DB::table('productsku')
                    ->where('id', $sumselected_products->productskusizes_id)
                    ->first();

                    $discount = 0;
                    if($productskusizes){
                        
                        if($role_id = 1){
                            $price = $productskusizes->price_1; 
                        }elseif($role_id = 2){
                            $price = $productskusizes->price_2;
                        }elseif($role_id =3){
                            $price = $productskusizes->price_3;
                        }else{
                            $price = $productskusizes->price_0;
                        }
                        $discount = $price;
                    
                    }
                  
                    if( $discount == 0){
                        return response()->json(['message' => '0']);
                    }
                       
                   
                    
                }
                return response()->json(['message' => '1']);
            }
            
            
            
            
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
}
