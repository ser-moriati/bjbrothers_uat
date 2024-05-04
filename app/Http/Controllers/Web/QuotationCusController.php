<?php

namespace App\Http\Controllers\Web;

use App\Amphures;
use App\Cart;
use App\District;
use App\Geographie;
use App\QuotationCus;
use App\QuotationCart;
use App\QuotationCusCart;
use App\QuotationCusDetail;
use App\Http\Controllers\Controller;
use App\MemberAddress;
use App\Product;
use App\Province;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

DB::beginTransaction();
// DB::beginTransaction();

class QuotationCusController extends Controller
{
    public function index(){
        $data['page'] = 'Company';
        $data['quotation_cartt'] = [];
        // $member_id = Auth::guard('member')->user()->id;
        if(Session::get('quotation_cart')){
            $data['quotation_cartt'] = Session::get('quotation_cart');

          
        }
        $data['quotation_cart'] = [];
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['amphures'] = Amphures::get();
        $data['geographie'] = Geographie::get();
        
        return view('quotation', $data);

    }
    public function quotationHistory(Request $request){
        $data['page'] = 'Company';
        $data['memberName'] = "history";
        $member_id = Auth::guard('member')->user()->id;
        $quotation = QuotationCus::where('ref_member_id',$member_id);
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
        $data['quotation'] = QuotationCus::select('quotations.*','provinces.name_th as ship_province_name','amphures.name_th as ship_amphure_name','districts.name_th as ship_district_name')
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
        $address = MemberAddress::where('ref_member_id', $member_id)
        ->where('address_type', 1)
        ->first();
        if ($address) {
            $data['province'] = Province::orderBy('name_th','ASC')->get();
            $data['district'] = District::orderBy('name_th','ASC')->get();
            $data['amphures'] = Amphures::orderBy('name_th','ASC')->get();
            $data['geographie'] = $address->zipcode;
            $addr = $address->addr;
            $provinc = Province::find($address->ref_province_id)->name_th;
            $distric = District::find($address->ref_district_id)->name_th;
            $amphure = Amphures::find($address->ref_amphures_id)->name_th;
            $zipcod = $address->zipcode;
        } else {
            return back()
                ->with('message', 'กรุณาไปเพิ่มที่อยู่ของท่านในหน้าข้อมูลสมาชิก ก่อนทำรายการ')
                ->with('message_status', 'danger');
        }
        
        $data['current_shipping'] = $addr.' '.$provinc.' '.$amphure.' '.$distric.' '.$zipcod;
        $data['quotation_cartt'] = [];
        // $member_id = Auth::guard('member')->user()->id;
        if(Session::get('quotation_cart')){
            $data['quotation_cartt'] =Session::get('quotation_cart');
        }
        $data['quotation_cart'] = QuotationCart::select('quotation_carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale','colors.color_name','sizes.size_name')
                            ->leftJoin('products','products.id','=','quotation_carts.ref_product_id')
                            ->leftJoin('colors','colors.id','=','quotation_carts.ref_color_id')
                            ->leftJoin('sizes','sizes.id','=','quotation_carts.ref_size_id')
                            ->where('quotation_carts.ref_member_id',$member_id)
                            ->orderBy('id','DESC')->get();

        return view('quotation_detail', $data);

    }
    public function addQuotationCusCart(Request $request){

        try{
            // $member_id = Auth::guard('member')->user()->id;
            // $quotationCount = QuotationCusCart::where('ref_member_id',$member_id)->where('ref_product_id',$request->product_id)->count();
            // if($quotationCount > 0){
            //     return response(['status'=>'403','message'=>'This product is already in the quotation.']);
            // }

            // return $quotation_cart = Session::get('quotation_cart');
            // dd($quotation_cart);

                $quotation = $request->product_id;
                $qty = $request->qty;

                // $quotation->save();
                Session::push('quotation_cart', ['id' => $quotation,'qty' => $qty]);
               
                $quotation_cart = Session::get('quotation_cart');
                // dd($quotation_cart);
            // $quotationAll = QuotationCusCart::where('ref_member_id',$member_id)->count();

            DB::commit();
            return response(['status'=>'201','message'=>count($quotation_cart)]);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function update(Request $request){
        try{
            $q = Session::pull('quotation_cart');
            foreach($q as $k => $v){
                if($v['id'] == $request->id){
                    $q[$k]['qty'] = $request->qty; // อัปเดตค่า qty ด้วยค่าใหม่ที่คุณต้องการ
                    break;
                }
            }
            Session::put('quotation_cart',$q);
            // return $q;
            // QuotationCusCart::destroy($request->id);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function insert(Request $request){
        try{
            // return $request;
            $member = Auth::guard('member')->user();
            $member_id = Auth::guard('member')->user()->id;
            
            // $quota_cart = QuotationCusCart::select('quotation_carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale','colors.color_name','sizes.size_name')
            //                                     ->leftJoin('products','products.id','=','quotation_carts.ref_product_id')
            //                                     ->leftJoin('colors','colors.id','=','quotation_carts.ref_color_id')
            //                                     ->leftJoin('sizes','sizes.id','=','quotation_carts.ref_size_id')
            //                                     ->where('quotation_carts.ref_member_id',$member_id)
            //                                     ->orderBy('id','DESC')->get(); 
            
            $quota_cart = Cart::leftJoin('products','products.id','=','carts.ref_product_id')
                            ->where('ref_member_id',$member_id)->get();

            $total_price = 0;
            foreach($quota_cart as $row){
                $total_price = $total_price+($row->product_price*$row->qty);
            }
            
            $lastQuotationCus = QuotationCus::latest()->first();

            $quotation_number = 'QT'.date("my").'00001';
            if($lastQuotationCus){
                $num = substr($lastQuotationCus->number, 2);
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
            // return $quota_cart;
            if(count($quota_cart) > 0){
                // return 454;
                $quotation = new QuotationCus;
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
                $quotation->price_total = $total_price;
                $quotation->qty_total = $quota_cart->sum->qty;
                $quotation->save();
            }


            foreach($quota_cart as $quot){
                $detail = new QuotationCusDetail;
                $detail->ref_member_id = $member_id;
                $detail->ref_product_id = $quot->ref_product_id;
                $detail->ref_color_id = $quot->ref_color_id;
                $detail->ref_size_id = $quot->ref_size_id;
                $detail->qty = $quot->qty;
                $detail->product_curent_price = $quot->product_price;
                $detail->product_curent_total_price = $quot->product_price*$quot->qty;
                $detail->ref_quotation_id = $quotation->id;
                $detail->save();

                QuotationCusCart::destroy($quot->id);

            }
            

            DB::commit();
            return redirect("quotation/confirm/$quotation->id");
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function confirm($id){

        $data['id'] = $id;
        $data['quotation'] = QuotationCus::find($id);

        return view('quotation_confirm',$data);
    }
    public function remove(Request $request){

        try{
            $q = Session::pull('quotation_cart');
            foreach($q as $k => $v){
                if($v['id'] == $request->id){
                    unset($q[$k]);
                    break;
                }
            }
            Session::put('quotation_cart',$q);
            // return $q;
            // QuotationCusCart::destroy($request->id);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
}
