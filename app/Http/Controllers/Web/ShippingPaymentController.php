<?php

namespace App\Http\Controllers\Web;

use App\Shipping;
use App\Province;
use App\District;
use App\Amphures;
use App\Payment;
use App\Order;
use App\OrderHasProduct;
use App\Cart;
use App\Bank;
use App\Contact;
use App\Color;
use App\Size;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ShippingCostController;
use App\MemberAddress;
use App\Product;
use App\ProductPrice;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use App\DefaultBank;
use App\ProductskUModel;
use App\ProductsOptionHead;
use App\ProductsOption1;
use App\ProductsOption2;

DB::beginTransaction();
// DB::beginTransaction();

class ShippingPaymentController extends Controller
{
    public function index(){

        $session_vat = Session::get('vat');
            // $vat = 0;
        // if($session_vat){
        //     $vat = 
        // }
        $data['session_vat'] = $session_vat;
        
        $data['page'] = 'Company';
        $member = Auth::guard('member')->user();
        $member_id = $member->id;


        $data['shipping'] = Shipping::orderBy('id','ASC')->get();
        $data['payment'] = Payment::orderBy('id','ASC')->get();
        $data['bank'] = Bank::orderBy('id','ASC')->get();
        $address = MemberAddress::where('ref_member_id', $member_id)
        ->where('address_type', 1)
        ->first();
    
    if ($address) {
        $data['province'] = Province::orderBy('name_th', 'ASC')->get();
        $data['district'] = District::orderBy('name_th', 'ASC')->get();
        $data['amphures'] = Amphures::orderBy('name_th', 'ASC')->get();
        $addr = $address->addr;
        $province = Province::find($address->ref_province_id)->name_th;
        $district = District::find($address->ref_district_id)->name_th;
        $amphures = Amphures::find($address->ref_amphures_id)->name_th;
        $zipcode = $address->zipcode;
    } else {
        return back()
            ->with('message', 'กรุณาไปเพิ่มที่อยู่ของท่านในหน้าข้อมูลสมาชิก ก่อนทำรายการ')
            ->with('message_status', 'danger');
    }


        
        $data['current_shipping'] = $addr.' '.$province.' '.$amphures.' '.$district.' '.$zipcode;


        $cart = Cart::selectRaw('carts.*, products.id as product_id, products.product_name, products.product_weight*carts.qty as weight, products.product_image, products.product_code, products.product_price, products.product_sale, colors.color_name, sizes.size_name')
                            ->leftJoin('products','products.id','=','carts.ref_product_id')
                            ->leftJoin('colors','colors.id','=','carts.ref_color_id')
                            ->leftJoin('sizes','sizes.id','=','carts.ref_size_id')
                            ->where('carts.ref_member_id',$member_id)
                            ->orderBy('id','DESC')->get();

        $role_id = 0;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
        foreach($cart as $pro){
            $productskusizes = DB::table('productsku')
            ->where('id', $pro->productskusizes_id)
            ->first();
    
            // $pro->product_price = $product_price == null? 0:$product_price->product_price;
            // $pro->product_sale = $product_price == null? 0:$product_price->product_sale;
            if($role_id == 1){
                $price = $productskusizes->price_1; // แก้ตรงนี้เป็น min_sale
             }elseif($role_id == 2){
                $price = $productskusizes->price_2;
             }elseif($role_id == 3){
                $price = $productskusizes->price_3;
             }else{
                $price = $productskusizes->price_0;
             }
            $discount = $price;
    
            $pro->product_sale = $discount;
        }
        
        $data['cart'] = $cart;
        $data['shipping_cost'] = 0;
        return view('shipping_payment', $data);

    }
    public function index_ordernow(Request $request){

     
     
      
        $session_vat = Session::get('vat');
        $data['session_vat'] = $session_vat;
        $data['page'] = 'Company';
        $member = Auth::guard('member')->user();
        $member_id = $member->id;

        $address = MemberAddress::where('ref_member_id', $member_id)
        ->where('address_type', 1)
        ->first();
       
        $product_id = $request->product_id;
        $color_id = $request->color;
        $sizes_id = $request->size;
        $productsku_id = $request->productsku_id;
        $qty = $request->qty;
         if($color_id){

         }else{
            return back()
            ->with('message1', '*กรุณาเลือกตัวเลือกของสินค้า')
            ->with('message_status1', 'danger')
            ->with('message2', '*กรุณาเลือกตัวเลือกของสินค้า')
            ->with('message_status2', 'danger');
         }
         if($sizes_id){
           
         }else{
            $ProductsOption2 = ProductsOption2::where('product_id',$product_id)->get();
            if($ProductsOption2){

            }else{
                return back()
                ->with('message1', '*กรุณาเลือกตัวเลือกของสินค้า')
                ->with('message_status1', 'danger')
                ->with('message2', '*กรุณาเลือกไซกรุณาเลือกตัวเลือกของสินค้าต์ของสินค้า')
                ->with('message_status2', 'danger');
            }

          
         }


        $data['shipping'] = Shipping::orderBy('id','ASC')->get();
        $data['payment'] = Payment::orderBy('id','ASC')->get();
        $data['bank'] = Bank::orderBy('id','ASC')->get();


        if ($address) {
            $data['province'] = Province::orderBy('name_th', 'ASC')->get();
            $data['district'] = District::orderBy('name_th', 'ASC')->get();
            $data['amphures'] = Amphures::orderBy('name_th', 'ASC')->get();
            $addr = $address->addr;
            $province = Province::find($address->ref_province_id)->name_th;
            $district = District::find($address->ref_district_id)->name_th;
            $amphures = Amphures::find($address->ref_amphures_id)->name_th;
            $zipcode = $address->zipcode;
        } else {
            return back()
                ->with('message', 'กรุณาไปเพิ่มที่อยู่ของท่านในหน้าข้อมูลสมาชิก ก่อนทำรายการ')
                ->with('message_status', 'danger');
        }
        
        $data['current_shipping'] = $addr.' '.$province.' '.$amphures.' '.$district.' '.$zipcode;
        $product = Product::where('id',$product_id)->first();
       
        $role_id = 1;
        if(@Auth::guard('member')->user()->ref_role_id){
            $role_id = Auth::guard('member')->user()->ref_role_id;
        }
            $productskusizes = DB::table('productsku')
            ->where('id', $request->productsku_id)
            ->first();
    
            // $pro->product_price = $product_price == null? 0:$product_price->product_price;
            // $pro->product_sale = $product_price == null? 0:$product_price->product_sale;
            if($productskusizes){
                if($role_id == 1){
                    $price = $productskusizes->price_1; // แก้ตรงนี้เป็น min_sale
                }elseif($role_id == 2){
                    $price = $productskusizes->price_2;
                }elseif($role_id == 3){
                    $price = $productskusizes->price_3;
                }else{
                    $price = $productskusizes->price_0;
                }
                $product->namecolorandsize =  $productskusizes->name_th;
                $product->product_name = $productskusizes->product_SKU;
                $product->product_sku_id = $productskusizes->id;
            }
            $discount = $price;
    
            $product->product_sale  = $discount;
         
        $data['product'] = $product;

        $data['qty'] = $qty;
        return view('shipping_payment_now', $data);

    }
    public function update_now(Request $request){

     
        try {
           
       
            $role_id = 0;
            if(@Auth::guard('member')->user()->ref_role_id){
                $role_id = Auth::guard('member')->user()->ref_role_id;
            }
          
            $productskusizes = DB::table('productsku')
            ->where('id',$request->id)
            ->first();

            // $pro->product_price = $product_price == null? 0:$product_price->product_price;
            // $pro->product_sale = $product_price == null? 0:$product_price->product_sale;
            if($productskusizes){
                if($role_id == 1){
                    $price = $productskusizes->price_1; // แก้ตรงนี้เป็น min_sale
                }elseif($role_id == 2){
                    $price = $productskusizes->price_2;
                }elseif($role_id == 3){
                    $price = $productskusizes->price_3;
                }else{
                    $price = $productskusizes->price_0;
                }
                $discount =  number_format($price);

             

            }
          
           
            $data['price'] = $request->qty*$discount;

            $data['qty'] = $request->qty;
         
            return response()->json(['message' => $data]);
        } catch (NotFoundHttpException $e) {
            // Handle the exception
            return response()->json(['error' => 'Route not found'], 404);
        }
       
        
      
       


    }
    public function insert(Request $request){
        // return $request->receipt_firstname;
        // $contact->
            $member = Auth::guard('member')->user();
            $member_id = $member->id;

            $cart = Cart::selectRaw('carts.*, products.id as product_id')
                            ->leftJoin('products','products.id','=','carts.ref_product_id')
                            ->where('ref_member_id',$member_id)->get();
            if(count($cart)==0){
                return redirect("newarrival")->with('message', 'Please select a product.')->with('message_status', 'danger');

            }

            $lastOrder = Order::latest()->first();

            $order_number = 'OR'.date("my").'00001';
            if($lastOrder){
                $num = substr($lastOrder->order_number, 2);
                $order_number = $this->getNumber('OR',$num);
            }

            $row = MemberAddress::where('ref_member_id',$member_id)->where('member_address.address_type',1)->first();
            if($request->shipping == 2){
                $shipping_firstname = $request->new_shipping_firstname;
                $shipping_lastname = $request->new_shipping_lastname;
                $shipping_phone = $request->new_shipping_phone;
                $shipping_email = $request->new_shipping_email;
                $shipping_address = $request->new_shipping_address;
                $shipping_province = $request->new_shipping_province;
                $shipping_zipcode = $request->new_shipping_zipcode;
                $shipping_amphure = $request->new_shipping_amphure;
                $shipping_district = $request->new_shipping_district;
            }else{
                
                $shipping_firstname = $member->member_firstname;
                $shipping_lastname = $member->member_lastname;
                $shipping_phone = $member->member_phone;
                $shipping_email = $member->member_email;
                $shipping_address = $row->addr;
                $shipping_province = $row->ref_province_id;
                $shipping_zipcode = $row->zipcode;
                $shipping_amphure = $row->ref_amphures_id;
                $shipping_district = $row->ref_district_id;

            }

            if(@$request->receipt){
                $receipt_firstname = $shipping_firstname;
                $receipt_lastname = $shipping_lastname;
                $receipt_phone = $shipping_phone;
                $receipt_email = $shipping_email;
                $receipt_address = $shipping_address;
                $receipt_province = $shipping_province;
                $receipt_zipcode = $shipping_zipcode;
                $receipt_amphure = $shipping_amphure;
                $receipt_district = $shipping_district;
            }else{
                
                $receipt_firstname = $request->receipt_firstname;
                $receipt_lastname = $request->receipt_lastname;
                $receipt_phone = $request->receipt_phone;
                $receipt_email = $request->receipt_email;
                $receipt_address = $request->receipt_address;
                $receipt_province = $request->receipt_province;
                $receipt_zipcode = $request->receipt_zipcode;
                $receipt_amphure = $request->receipt_amphure;
                $receipt_district = $request->receipt_district;
            }

            if($member->member_TaxID){
                $member_TaxID = $member->member_TaxID;
            }else{
                $member_TaxID ="0";
            }

        try{
            $order = new Order;
            $order->order_number = $order_number;
            $order->ship_first_name = $shipping_firstname;
            $order->ship_last_name = $shipping_lastname;
            $order->ship_phone = $shipping_phone;
            $order->ship_email = $shipping_email;
            $order->ship_address = $shipping_address;
            $order->ship_ref_province_id = $shipping_province;
            $order->ship_zipcode = $shipping_zipcode;
            $order->ship_ref_amphure_id = $shipping_amphure;
            $order->ship_ref_district_id = $shipping_district;
            $order->receipt_first_name = $receipt_firstname;
            $order->receipt_last_name = $receipt_lastname;
            $order->receipt_phone = $receipt_phone;
            $order->receipt_email = $receipt_email;
            $order->receipt_address = $receipt_address;
            $order->receipt_ref_province_id = $receipt_province;
            $order->receipt_ref_amphure_id = $receipt_amphure;
            $order->receipt_ref_district_id = $receipt_district;
            $order->receipt_zipcode = $receipt_zipcode;
            $order->shipping_cost = 0;
            $order->member_TaxID = $member_TaxID;
            // $order->vat = $request->vat;
            $order->remark = $request->remark;
            $order->ref_shipping_method_id = 0;
            $order->ref_payment_method_id = 0;
            $order->ref_member_id = $member_id;
            $order->ref_order_status_id = 7;
            $order->save();
            $order_id = $order->id;

            ///////////////// cart to order detail
            $role_id = 1;
            if(@Auth::guard('member')->user()->ref_role_id){
                $role_id = Auth::guard('member')->user()->ref_role_id;
            }
            $all_order_total = 0;
                if (Session::has('selected_products')){
                    foreach (Session::get('selected_products') as $key => $selected_products){
                            $row = DB::table('carts')->selectRaw('carts.*, products.id as product_id')
                            ->leftJoin('products','products.id','=','carts.ref_product_id')
                            ->where('carts.id', $selected_products)->first();

                           
                             $role_id = 0;
                             if (@Auth::guard('member')->user()->ref_role_id) {
                                 $role_id = Auth::guard('member')->user()->ref_role_id;
                             }
                             
                             $role_name = DB::table('roles')->where('id', $role_id)->first();
                            
                             if($row){
                                     $productskusizes = DB::table('productsku')
                                     ->where('id', $row->productskusizes_id)
                                     ->first();

                                  
                                     if($productskusizes){
                                        $price = 0;
                                         if($role_id = 1){
                                             $price = $productskusizes->price_1; 
                                         }elseif($role_id = 2){
                                             $price = $productskusizes->price_2;
                                         }elseif($role_id =3){
                                             $price = $productskusizes->price_3;
                                         }else{
                                             $price = $productskusizes->price_0;
                                         }
                                    
                                     }
                            }       
                            $productskuqty =    $row->qty - $productskusizes->product_qty;
                             $data6 = [
                                 'product_qty'		                        =>  $productskuqty,
                             ];

                             DB::table('productsku')->where('id',$row->productskusizes_id)->update($data6);
                             $check_product = Product::where('id',$row->product_id)->first();
                            
                             $order_total = $price*$row->qty;
                             $all_order_total = $all_order_total+$order_total;
             
                             $order_product = new OrderHasProduct();
                             $order_product->ref_order_id = $order_id;
                             $order_product->ref_product_id = $row->ref_product_id;
                             $order_product->productsku_id = $row->productskusizes_id;
                             $order_product->ref_color_id = $row->ref_color_id;
                             $order_product->ref_size_id = $row->ref_size_id;
                             $order_product->price = $price;
                             $order_product->qty = $row->qty;
                             $order_product->order_total = $order_total;
                             $order_product->save();

                            Cart::where('id',$selected_products)->delete(); 
                            Session::forget('selected_products');
                    }
             
                        $session_vat = Session::get('vat');
                         $vat = 0;
                         if($session_vat){
                             $vat = ($all_order_total+$request->shipping_cost)*0.07;
                             $order = Order::find($order_id);
                           
                             $order->vat_check = 1;
                             $order->save();
                 
                         }
                } 
                             
        
                // return $row->product_price;
              

         

            
        $data['page'] = 'Company';
        $data['memberName'] = "history";
        $member_id = Auth::guard('member')->user()->id;
        $data['order'] = Order::select('orders.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
                                                'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
                                                'members.member_firstname','members.member_lastname','members.company_name','payment_method.payment_name','shipping_method.shipping_name')
                                ->leftJoin('provinces as ship_pro','ship_pro.id','=','orders.ship_ref_province_id')
                                ->leftJoin('amphures as ship_amph','ship_amph.id','=','orders.ship_ref_amphure_id')
                                ->leftJoin('districts as ship_dist','ship_dist.id','=','orders.ship_ref_district_id')
                                ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','orders.ship_ref_province_id')
                                ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','orders.ship_ref_amphure_id')
                                ->leftJoin('districts as receipt_dist','receipt_dist.id','=','orders.ship_ref_district_id')
                                ->leftJoin('shipping_method','shipping_method.id','=','orders.ref_shipping_method_id')
                                ->leftJoin('payment_method','payment_method.id','=','orders.ref_payment_method_id')
                                ->leftJoin('members','members.id','=','orders.ref_member_id')
                                ->where('orders.id',$order_id)->where('orders.ref_member_id',$member_id)->with('order_products.product','order_products.color','order_products.size')->first();
            $order_date = strtotime($data['order']['created_at']);
            $d = date('d',$order_date);
            $m = date('m',$order_date);
            $Y = date('Y',$order_date);
            $month = [
                '01'=>'ม.ค.',
                '02'=>'ก.พ.',
                '03'=>'มี.ค.',
                '04'=>'ม.ย.',
                '05'=>'พ.ค.',
                '06'=>'มิ.ย.',
                '07'=>'ก.ค.',
                '08'=>'ส.ค.',
                '09'=>'ก.ย.',
                '10'=>'ต.ค.',
                '11'=>'พ.ย.',
                '12'=>'ธ.ค.'
            ];
            $data['order']->date = $d.' '.$month[$m].' '.$Y;
            $contact = Contact::first();

            $member = Auth::guard('member')->user();

            $email = $member->member_email;
            // Mail::send('mail.confirm_order', $data, function ($message) use ($email) {
            //     $message->from('worawe@ots.co.th', 'BJBROTHERS');
            //     $message->to($email)
            //             ->subject("แจ้งเตือน รายการสั่งซื้อ"); // Updated subject in Thai
            // });
        // admin
            Mail::send('mail.confirm_order', $data, function ($message) use ($contact) {
                $message->from('worawe@ots.co.th', 'BJBROTHERS');
                $message->to('salecenter@bjbrothers.com')
                ->subject("รอยืนยันคำสั่งซื้อ");
            });

          
            
            DB::commit();
            
            return redirect("order/status/$order_id")->with('message', 'Checkout order "'.$order_number.'" success')->with('message_status', 'success');
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }

    public function insert_now(Request $request){
        // return $request->receipt_firstname;
        // $contact->
            $member = Auth::guard('member')->user();
            $member_id = $member->id;

         
            $lastOrder = Order::latest()->first();

            $order_number = 'OR'.date("my").'00001';
            if($lastOrder){
                $num = substr($lastOrder->order_number, 2);
                $order_number = $this->getNumber('OR',$num);
            }

            $row = MemberAddress::where('ref_member_id',$member_id)->where('member_address.address_type',1)->first();
            if($request->shipping == 2){
                $shipping_firstname = $request->new_shipping_firstname;
                $shipping_lastname = $request->new_shipping_lastname;
                $shipping_phone = $request->new_shipping_phone;
                $shipping_email = $request->new_shipping_email;
                $shipping_address = $request->new_shipping_address;
                $shipping_province = $request->new_shipping_province;
                $shipping_zipcode = $request->new_shipping_zipcode;
                $shipping_amphure = $request->new_shipping_amphure;
                $shipping_district = $request->new_shipping_district;
            }else{
                
                $shipping_firstname = $member->member_firstname;
                $shipping_lastname = $member->member_lastname;
                $shipping_phone = $member->member_phone;
                $shipping_email = $member->member_email;
                $shipping_address = $row->addr;
                $shipping_province = $row->ref_province_id;
                $shipping_zipcode = $row->zipcode;
                $shipping_amphure = $row->ref_amphures_id;
                $shipping_district = $row->ref_district_id;

            }

            if(@$request->receipt){
                $receipt_firstname = $shipping_firstname;
                $receipt_lastname = $shipping_lastname;
                $receipt_phone = $shipping_phone;
                $receipt_email = $shipping_email;
                $receipt_address = $shipping_address;
                $receipt_province = $shipping_province;
                $receipt_zipcode = $shipping_zipcode;
                $receipt_amphure = $shipping_amphure;
                $receipt_district = $shipping_district;
            }else{
                
                $receipt_firstname = $request->receipt_firstname;
                $receipt_lastname = $request->receipt_lastname;
                $receipt_phone = $request->receipt_phone;
                $receipt_email = $request->receipt_email;
                $receipt_address = $request->receipt_address;
                $receipt_province = $request->receipt_province;
                $receipt_zipcode = $request->receipt_zipcode;
                $receipt_amphure = $request->receipt_amphure;
                $receipt_district = $request->receipt_district;
            }

        try{
            $order = new Order;
            $order->order_number = $order_number;
            $order->ship_first_name = $shipping_firstname;
            $order->ship_last_name = $shipping_lastname;
            $order->ship_phone = $shipping_phone;
            $order->ship_email = $shipping_email;
            $order->ship_address = $shipping_address;
            $order->ship_ref_province_id = $shipping_province;
            $order->ship_zipcode = $shipping_zipcode;
            $order->ship_ref_amphure_id = $shipping_amphure;
            $order->ship_ref_district_id = $shipping_district;
            $order->receipt_first_name = $receipt_firstname;
            $order->receipt_last_name = $receipt_lastname;
            $order->receipt_phone = $receipt_phone;
            $order->receipt_email = $receipt_email;
            $order->receipt_address = $receipt_address;
            $order->receipt_ref_province_id = $receipt_province;
            $order->receipt_ref_amphure_id = $receipt_amphure;
            $order->receipt_ref_district_id = $receipt_district;
            $order->receipt_zipcode = $receipt_zipcode;
            $order->shipping_cost = 0;
            // $order->vat = $request->vat;
            $order->remark = $request->remark;
            $order->ref_shipping_method_id = 0;
            $order->ref_payment_method_id = 0;
            $order->ref_member_id = $member_id;
            $order->ref_order_status_id = 7;
            $order->save();
            $order_id = $order->id;

            ///////////////// cart to order detail
                $role_id = 1;
                if(@Auth::guard('member')->user()->ref_role_id){
                    $role_id = Auth::guard('member')->user()->ref_role_id;
                }
            $all_order_total = 0;
            
                // return $row->product_price;
                $sale = ProductPrice::where('ref_role_id', $role_id)->where('ref_product_id', $request->product_id)->first();
                $product_price = Product::where('id', $request->product_id)->first();
                    // $row->product_price = $product_price == null? 0:$product_price->product_price;
                    // $row->product_sale = $product_price == null? 0:$product_price->product_sale;
                    
                    $productskusizes = DB::table('productsku')
                    ->where('id', $request->productsku_id)
                    ->first();
            
                    // $pro->product_price = $product_price == null? 0:$product_price->product_price;
                    // $pro->product_sale = $product_price == null? 0:$product_price->product_sale;
                    if($productskusizes){
                        if($role_id == 1){
                            $price = $productskusizes->price_1; // แก้ตรงนี้เป็น min_sale
                        }elseif($role_id == 2){
                            $price = $productskusizes->price_2;
                        }elseif($role_id == 3){
                            $price = $productskusizes->price_3;
                        }else{
                            $price = $productskusizes->price_0;
                        } 
                    }   
                $discount = $price;
                $price = $discount;
                $qty = $request->qty;

                $data6 = [
                    'product_qty'		                        =>  $qty,
                ];
                
                DB::table('products')->where('id',$request->product_id)->update($data6);
                
                $order_total = $price*$request->qty;
                $all_order_total = 00; 
         
    
              
               
                $order_product = new OrderHasProduct();
                $order_product->ref_order_id = $order_id;
                $order_product->ref_product_id = $request->product_id ;
                $order_product->ref_color_id = 0;
                $order_product->ref_size_id = 0;
                $order_product->price = $price;
                $order_product->productsku_id = $request->productsku_id;
                $order_product->qty = $request->qty;
                $order_product->order_total =  $order_total;
                $order_product->save();
            

        

            Cart::where('ref_member_id',$member_id)->delete();

            
        $data['page'] = 'Company';
        $data['memberName'] = "history";
        $member_id = Auth::guard('member')->user()->id;
        $data['order'] = Order::select('orders.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
                                                'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
                                                'members.member_firstname','members.member_lastname','members.company_name','payment_method.payment_name','shipping_method.shipping_name')
                                ->leftJoin('provinces as ship_pro','ship_pro.id','=','orders.ship_ref_province_id')
                                ->leftJoin('amphures as ship_amph','ship_amph.id','=','orders.ship_ref_amphure_id')
                                ->leftJoin('districts as ship_dist','ship_dist.id','=','orders.ship_ref_district_id')
                                ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','orders.ship_ref_province_id')
                                ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','orders.ship_ref_amphure_id')
                                ->leftJoin('districts as receipt_dist','receipt_dist.id','=','orders.ship_ref_district_id')
                                ->leftJoin('shipping_method','shipping_method.id','=','orders.ref_shipping_method_id')
                                ->leftJoin('payment_method','payment_method.id','=','orders.ref_payment_method_id')
                                ->leftJoin('members','members.id','=','orders.ref_member_id')
                                ->where('orders.id',$order_id)->where('orders.ref_member_id',$member_id)->with('order_products.product','order_products.color','order_products.size')->first();
            $order_date = strtotime($data['order']['created_at']);
            $d = date('d',$order_date);
            $m = date('m',$order_date);
            $Y = date('Y',$order_date);
            $month = [
                '01'=>'ม.ค.',
                '02'=>'ก.พ.',
                '03'=>'มี.ค.',
                '04'=>'ม.ย.',
                '05'=>'พ.ค.',
                '06'=>'มิ.ย.',
                '07'=>'ก.ค.',
                '08'=>'ส.ค.',
                '09'=>'ก.ย.',
                '10'=>'ต.ค.',
                '11'=>'พ.ย.',
                '12'=>'ธ.ค.'
            ];
            $data['order']->date = $d.' '.$month[$m].' '.$Y;
            $contact = Contact::first();
            $member = Auth::guard('member')->user();

            $email = $member->member_email;
            // Mail::send('mail.confirm_order', $data, function ($message) use ($email) {
            //     $message->from('worawe@ots.co.th', 'BJBROTHERS');
            //     $message->to($email)
            //             ->subject("แจ้งเตือน รายการสั่งซื้อ"); // Updated subject in Thai
            // });

           // admin
           Mail::send('mail.confirm_order', $data, function ($message) use ($contact) {
            $message->from('worawe@ots.co.th', 'BJBROTHERS');
            $message->to('salecenter@bjbrothers.com')
            ->subject("รอยืนยันคำสั่งซื้อ");
            });

            //salecenter@bjbrothers.com

            // return view('mail.confirm_order', $data);

            // Mail::send('mail.confirm_order',['code' => 'test'], function ($message) {
            //     $message->from('worawe@ots.co.th', 'BJ');
            //     $message->to('wolverine.wek@gmail.com')
            //     ->subject("มี order");
            // });
            
            DB::commit();
            return redirect("order/status/$order_id")->with('message', 'Checkout order "'.$order_number.'" success')->with('message_status', 'success');
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
}
