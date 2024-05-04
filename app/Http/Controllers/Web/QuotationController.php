<?php

namespace App\Http\Controllers\Web;

use App\Amphures;
use App\Cart;
use App\District;
use App\Quotation;
use App\QuotationCart;
use App\QuotationDetail;
use App\Http\Controllers\Controller;
use App\MemberAddress;
use App\Geographie;
use App\Province;
use Illuminate\Http\Request;
use Auth;
use App\Contact;
use Illuminate\Support\Facades\Mail;
use App\Product;
use App\ProductPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

DB::beginTransaction();
// DB::beginTransaction();

class QuotationController extends Controller
{
    public function index(){
        $data['page'] = 'Company';
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['amphures'] = Amphures::get();
        $data['geographie'] = Geographie::get();
        $member_id = Auth::guard('member')->user()->id;

        $data['quotation_cartt'] = [];
        // $member_id = Auth::guard('member')->user()->id;
        if(Session::get('quotation_cart')){
            $data['quotation_cartt'] = Session::get('quotation_cart');
        }
        
        $data['quotation_cart'] = QuotationCart::select('quotation_carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale','colors.color_name','sizes.size_name')
                            ->leftJoin('products','products.id','=','quotation_carts.ref_product_id')
                            ->leftJoin('colors','colors.id','=','quotation_carts.ref_color_id')
                            ->leftJoin('sizes','sizes.id','=','quotation_carts.ref_size_id')
                            ->where('quotation_carts.ref_member_id',$member_id)
                            ->orderBy('id','DESC')->get();

        return view('quotation', $data);

    }
    public function quotationHistory(Request $request){
        $data['page'] = 'Company';
        $data['memberName'] = "history";
        $member_id = Auth::guard('member')->user()->id;
        $quotation = Quotation::where('ref_member_id',$member_id);
        if($request->search){
            $quotation = $quotation->where('number','like','%'.$request->search.'%');
        }
        $quotation = $quotation->with('quotation_details.product','quotation_details.color','quotation_details.size')->get();
        $data['query'] = request()->query();
        $data['quotation'] = $quotation;

        return view('member_quotationhistory', $data);
    }
    public function quotationHistoryDetail($id){
        $data['page'] = 'Company';
        $data['memberName'] = "q-history";
        $member_id = Auth::guard('member')->user()->id;
        $data['quotation'] = Quotation::select('quotations.*','provinces.name_th as ship_province_name','amphures.name_th as ship_amphure_name','districts.name_th as ship_district_name')
                                        ->leftJoin('provinces','provinces.id','=','quotations.ship_ref_province_id')
                                        ->leftJoin('amphures','amphures.id','=','quotations.ship_ref_amphure_id')
                                        ->leftJoin('districts','districts.id','=','quotations.ship_ref_district_id')
                                        ->where('quotations.id',$id)->where('quotations.ref_member_id',$member_id)->with('quotation_details.product','quotation_details.color','quotation_details.size')->first();

        return view('member_quotationhistory_detail', $data);
    }
    public function conclude(){
        $data['page'] = 'Company';
        $member = Auth::guard('member')->user();
        $member_id = Auth::guard('member')->user()->id;
        
        $data['province'] = Province::orderBy('name_th','ASC')->get();
        $data['district'] = District::orderBy('name_th','ASC')->get();
        $data['amphures'] = Amphures::orderBy('name_th','ASC')->get();
        // $data['quotation_cart'] = QuotationCart::select('quotation_carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale','colors.color_name','sizes.size_name')
        //                     ->leftJoin('products','products.id','=','quotation_carts.ref_product_id')
        //                     ->leftJoin('colors','colors.id','=','quotation_carts.ref_color_id')
        //                     ->leftJoin('sizes','sizes.id','=','quotation_carts.ref_size_id')
        //                     ->where('quotation_carts.ref_member_id',$member_id)
        //                     ->orderBy('id','DESC')->get();

        $addr = $member->company_addr;
        $province = Province::where('id',$member->ref_province_id)->first()->name_th;
        $district = District::where('id',$member->ref_district_id)->first()->name_th;
        $amphures = Amphures::where('id',$member->ref_amphures_id)->first()->name_th;
        $zipcode = $member->zipcode;
        
        $data['current_shipping'] = $addr.' '.$province.' '.$amphures.' '.$district.' '.$zipcode;
        $data['quotation_cart'] = [];
        // $member_id = Auth::guard('member')->user()->id;
        if(Session::get('cart')){
            $data['quotation_cartt'] = Product::whereIn('id', Session::get('quotation_cart'))->get();
        }
        $data['cart'] = Cart::select('carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale','colors.color_name','sizes.size_name')
                            ->leftJoin('products','products.id','=','carts.ref_product_id')
                            ->leftJoin('colors','colors.id','=','carts.ref_color_id')
                            ->leftJoin('sizes','sizes.id','=','carts.ref_size_id')
                            ->where('carts.ref_member_id',$member_id)
                            ->orderBy('id','DESC')->get();

        return view('quotation_detail', $data);

    }
    public function addQuotationCart(Request $request){

        try{
            $member_id = Auth::guard('member')->user()->id;
           
            $data['quotation_cartt'] = Session::get('quotation_cart');
            $quotationCount = QuotationCart::where('ref_member_id',$member_id)->where('ref_product_id',$request->product_id)->count();
            if($quotationCount > 0){
                return response(['status'=>'403','message'=>'This product is already in the quotation.']);
            }

                $quotation = new QuotationCart;
                $quotation->ref_member_id = $member_id;
                $quotation->ref_product_id = $request->product_id;
                if ($request->color_id == '') {
                  
                   
                } else {
                    $quotation->ref_color_id = $request->color_id;
                }
                
                if ($request->size_id =='') {
                  
                } else {
                    $quotation->ref_size_id = $request->size_id;
                }
                $quotation->qty = $request->qty;
                $quotation->save();

            $quotationAll = QuotationCart::where('ref_member_id',$member_id)->count();

            DB::commit();
            return response(['status'=>'201','message'=>$quotationAll]);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function update(Request $request){
        try{
            $cart = QuotationCart::find($request->id);
            $cart->qty = $request->qty;
            $cart->save();
            DB::commit();
            return response($cart);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function insert(Request $request){
        try{
            // return $request;

            $member_id = Auth::guard('member')->user()->id;
            if(Session::get('quotation_cart')){
               
                foreach(Session::get('quotation_cart') as  $quotation_cartt ){
          
                    $product = DB::table('carts')
                    ->where('carts.id', $selected_products)->first();
                    
                        $quotation = new QuotationCart;
                        $quotation->ref_member_id = $member_id;
                        $quotation->ref_product_id = $product->ref_product_id ;
                        $quotation->productskusizes_id = $product->productskusizes_id ;
                        if ($product->ref_color_id == '') {
                        } else {
                            $quotation->ref_color_id = $product->ref_color_id;
                        }
                        if ($product->ref_size_id =='') {
                        } else {
                            $quotation->ref_size_id = $product->ref_size_id;
                        }
                        $quotation->qty = $quotation_cartt['qty'];
                        $quotation->save();
                } 
            }

            $member = Auth::guard('member')->user();
         
            
            $quota_cart = QuotationCart::select('quotation_carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale')
                                                ->leftJoin('products','products.id','=','quotation_carts.ref_product_id')
                                                
                                                ->where('quotation_carts.ref_member_id',$member_id)
                                                ->orderBy('id','DESC')->get(); 
            
            // $quota_cart = QuotationCart::select('quotation_carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale','colors.color_name','sizes.size_name')
            // ->leftJoin('products','products.id','=','quotation_carts.ref_product_id')
            // ->where('quotation_carts.ref_member_id',$member_id)
            // ->orderBy('id','DESC')->get();

            $total_price = 0;
            foreach($quota_cart as $row){
                $total_price = $total_price+($row->product_price*$row->qty);
            }
            
            $lastQuotation = Quotation::latest()->first();

            $quotation_number = 'QT'.date("my").'00001';
            if($lastQuotation){
                $num = substr($lastQuotation->number, 2);
                $quotation_number = $this->getNumber('QT',$num);
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

            // return $quota_cart;
            
                // return 454;
                $quotation = new Quotation;
                $quotation->number = $quotation_number;
                $quotation->ref_member_id = $member_id;
                $quotation->remark = $request->remark;
                $quotation->ship_first_name = $shipping_firstname;
                $quotation->ship_last_name = $shipping_lastname;
                $quotation->ship_phone = $shipping_phone;
                $quotation->ship_email = $shipping_email;
                $quotation->ship_address = $shipping_address;
                $quotation->ship_ref_province_id = $shipping_province;
                $quotation->ship_zipcode = $shipping_zipcode;
                $quotation->ship_ref_amphure_id = $shipping_amphure;
                $quotation->ship_ref_district_id = $shipping_district;
                $quotation->receipt_address = $receipt_address;
                $quotation->receipt_ref_province_id = $receipt_province;
                $quotation->receipt_ref_amphure_id = $receipt_amphure;
                $quotation->receipt_ref_district_id = $receipt_district;
                $quotation->receipt_zipcode = $receipt_zipcode;
                $quotation->price_total = $total_price;
                $quotation->qty_total = $quota_cart->sum->qty;
                $quotation->save();
            


            // foreach($quota_cart as $quot){
            //     $detail = new QuotationDetail;
            //     $detail->ref_member_id = $member_id;
            //     $detail->ref_product_id = $quot->ref_product_id;
            //     if($quot->ref_color_id == ''){
            //     }else{
            //         $detail->ref_color_id = $quot->ref_color_id;
            //     }
            //     if($quot->ref_size_id == ''){
            //     }else{
            //         $detail->ref_size_id = $quot->ref_size_id;
            //     }
            //     $detail->qty = $quot->qty;
            //     $detail->product_curent_price = $quot->product_price;
            //     $detail->product_curent_total_price = $quot->product_price*$quot->qty;
            //     $detail->ref_quotation_id = $quotation->id;
            //     $detail->save();

            //     QuotationCart::destroy($quot->id);

            // }
            $role_id = 0;
            if(@Auth::guard('member')->user()->ref_role_id){
                $role_id = Auth::guard('member')->user()->ref_role_id;
            }
            if (Session::has('selected_products')){
                foreach (Session::get('selected_products') as $key => $selected_products){
                
                        $row = DB::table('carts')
                        ->leftJoin('products','products.id','=','carts.ref_product_id')
                        ->leftJoin('productsku','productsku.id','=','carts.productskusizes_id')
                        ->where('carts.id', $selected_products)->first();

                        if($role_id = 1){
                            $price = $row->price_1; 
                        }elseif($role_id = 2){
                            $price = $row->price_2;
                        }elseif($role_id =3){
                            $price = $row->price_3;
                        }else{
                            $price = $row->price_0;
                        }
         
                       
                         $detail = new QuotationDetail;
                         $detail->ref_member_id = $member_id;
                         $detail->ref_product_id = $row->ref_product_id;
                         if($row->ref_color_id == ''){
                         }else{
                             $detail->ref_color_id = $row->ref_color_id;
                         }
                         if($row->ref_size_id == ''){
                         }else{
                             $detail->ref_size_id = $row->ref_size_id;
                         }
                         $detail->qty = $row->qty;
                         $detail->product_curent_price = $price;
                         $detail->product_curent_total_price = $price*$row->qty;
                         $detail->ref_quotation_id = $quotation->id;
                         $detail->product_SKU_id = $row->productskusizes_id;
                         $detail->save();

                         //ลบข้อมูลในตะกร้าสินค้าและ session
                         Cart::where('id',$selected_products)->delete(); 
                         Session::forget('selected_products');
                      

                }
         
                   
                   

            } 
            $member_id = Auth::guard('member')->user()->id;
            $data['order'] = Quotation::select('quotations.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
                                                    'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
                                                    'members.member_firstname','members.member_lastname','members.company_name')
                                    ->leftJoin('provinces as ship_pro','ship_pro.id','=','quotations.ship_ref_province_id')
                                    ->leftJoin('amphures as ship_amph','ship_amph.id','=','quotations.ship_ref_amphure_id')
                                    ->leftJoin('districts as ship_dist','ship_dist.id','=','quotations.ship_ref_district_id')
                                    ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','quotations.ship_ref_province_id')
                                    ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','quotations.ship_ref_amphure_id')
                                    ->leftJoin('districts as receipt_dist','receipt_dist.id','=','quotations.ship_ref_district_id')
                                    ->leftJoin('members','members.id','=','quotations.ref_member_id')
                                    ->where('quotations.id',$quotation->id)->where('quotations.ref_member_id',$member_id)->with('quotation_details.product','quotation_details.color','quotation_details.size')->first();
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

                // dd($data['order']->quotation_details);
                $contact = Contact::first();
                $email = Auth::guard('member')->user()->member_email;
                  
                //แจ้งเตือนadmin
                // Mail::send('mail.quotations_admin', $data, function ($message) use ($contact) {
                //     $message->from('worawe@ots.co.th', 'BJBROTHERS');
                //     $message->to('salecenter@bjbrothers.com')
                //     ->subject("แจ้งเตือน มีขอใบเสนอราคาเข้ามาใหม่");
                // });
                  
            
        // Session::forget('quotation_cart');
            DB::commit();
            return redirect("quotation/confirm/$quotation->id");
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function confirm($id){

        $data['id'] = $id;
        $data['quotation'] = Quotation::find($id);

        return view('quotation_confirm',$data);
    }
    public function remove(Request $request){

        try{
            QuotationCart::destroy($request->id);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
}
