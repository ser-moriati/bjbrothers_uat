<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Member;
use App\MemberCategory;
use App\Product;
use App\Roles;
use App\Order;
use App\OrderHasProduct;
use App\OrderStatus;
use App\Geographie;
use App\Shipping;
use App\Province;
use App\District;
use App\Amphures;
use App\Payment;
use App\Cart;
use App\Bank;
use App\Contact;
use App\Color;
use App\Size;
use Carbon\Carbon;
DB::beginTransaction();

class MemberController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'member';
        $data['page'] = 'Customer';
        $data['page_url'] = 'member';
        $data['category'] = MemberCategory::get();
        $results = Member::select('members.*','member_categorys.category_name','provinces.name_th as provinces_name','amphures.name_th as amphure_name','districts.name_th as districts_name','roles.role_name')
                        ->leftJoin('provinces','provinces.id','=','members.ref_province_id')
                        ->leftJoin('amphures','amphures.id','=','members.ref_amphures_id')
                        ->leftJoin('districts','districts.id','=','members.ref_district_id')
                        ->leftJoin('member_categorys','member_categorys.id','members.ref_member_category_id')
                        ->leftJoin('roles','roles.id','members.ref_role_id');
                  
            if(@$request->member_name){
                $results = $results->Where(DB::raw("CONCAT(members.member_firstname, ' ', members.member_lastname)"),'LIKE','%'.$request->member_name.'%');
            }      
            if(@$request->company_name){
                $results = $results->Where('members.company_name','LIKE','%'.$request->company_name.'%');
            }
            if(@$request->category_id){
                $results = $results->Where('ref_member_category_id',$request->category_id);
            }
                        
        $results = $results->with('address.province','address.amphures','address.district')->orderBy('id','DESC')->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();
        $role = Roles::orderBy('id_','DESC')->get();
        $data['roles'] = $role;
        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['amphures'] = Amphures::get();
        $data['geographie'] = Geographie::get();
        return view('admin/members/index', $data);

    }
    public function index_membernew(Request $request){
        $data['module'] = 'member';
        $data['page'] = 'Customer';
        $data['page_url'] = 'member';
        $data['category'] = MemberCategory::get();
        $results = Member::select('members.*','member_categorys.category_name','provinces.name_th as provinces_name','amphures.name_th as amphure_name','districts.name_th as districts_name','roles.role_name')
                        ->leftJoin('provinces','provinces.id','=','members.ref_province_id')
                        ->leftJoin('amphures','amphures.id','=','members.ref_amphures_id')
                        ->leftJoin('districts','districts.id','=','members.ref_district_id')
                        ->leftJoin('member_categorys','member_categorys.id','members.ref_member_category_id')
                        ->leftJoin('roles','roles.id','members.ref_role_id');
                  
            if(@$request->member_name){
                $results = $results->Where(DB::raw("CONCAT(members.member_firstname, ' ', members.member_lastname)"),'LIKE','%'.$request->member_name.'%');
            }      
            if(@$request->company_name){
                $results = $results->Where('members.company_name','LIKE','%'.$request->company_name.'%');
            }
            if(@$request->category_id){
                $results = $results->Where('ref_member_category_id',$request->category_id);
            }
           // รับวันที่ปัจจุบันเป็น Carbon
           $currentDate = date('Y-m-d');
           // ค้นหาข้อมูลที่มีวันที่ตรงกับวันที่ปัจจุบัน
           $results = $results->whereDate('members.created_at', '=',$currentDate );     
        $results = $results->with('address.province','address.amphures','address.district')->orderBy('id','DESC')->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();
        $role = Roles::orderBy('id_','DESC')->get();
        $data['roles'] = $role;
        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['amphures'] = Amphures::get();
        $data['geographie'] = Geographie::get();
        return view('admin/members/index', $data);

    }
    public function change_role(Request $request){
        try{
            $member = Member::find($request->id);
            $member->ref_role_id = $request->role_id;
            $member->save();

            $role = Roles::find($request->role_id)->role_name;
            DB::commit();
            return response($role);
        } catch (QueryException $err) {
            return response($err);
        }
    }
    public function changeStatus(Request $request){
        try{
            Member::where('id',$request->id)->update(['member_active' => $request->status]);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Member::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request){

        try{
           
            $member = Member::find($request->id);
            $member->member_firstname = $request->member_firstname;
            $member->member_lastname =  $request->member_lastname;
            $member->member_email = $request->member_email;
            $member->member_phone = $request->member_phone;
            $member->member_line = $request->member_line;
            $member->ref_member_category_id = $request->category_id;
            $member->company_name = $request->company_name;
            $member->company_email = $request->company_email;
             $member->member_TaxID = $request->member_TaxID;
            $member->company_phone = $request->company_phone;
            $member->company_fax = $request->company_fax;
            $member->save();
           
       
            DB::commit();
            return redirect("admin/member")->with('message', 'Update member success');
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function Order($id){
        $data['module'] = 'member';
        $data['page'] = 'Customer';
        $data['page_url'] = 'member';
        $data['status'] = OrderStatus::get();
        $data['changStatus'] = [
                                2 => 'paid',
                                3 => 'shipping',
                                4 => 'success'
                            ];

        $results = Order::selectRaw('orders.*,members.member_firstname,members.member_lastname,default_bank.bank_name,shipping_method.shipping_name,order_status.status_name,order_status.color_background,order_status.color_code,ship_pro.name_th as ship_province_name,ship_amph.name_th as ship_amphure_name,ship_dist.name_th as ship_district_name,
        receipt_pro.name_th as receipt_province_name,receipt_amph.name_th as receipt_amphure_name,receipt_dist.name_th as receipt_district_name');
        $results = $results->Where('orders.ref_member_id',$id);
        $results = $results->leftJoin('members','members.id','=','orders.ref_member_id')
                    ->leftJoin('provinces as ship_pro','ship_pro.id','=','orders.ship_ref_province_id')
                    ->leftJoin('amphures as ship_amph','ship_amph.id','=','orders.ship_ref_amphure_id')
                    ->leftJoin('districts as ship_dist','ship_dist.id','=','orders.ship_ref_district_id')
                    ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','orders.ship_ref_province_id')
                    ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','orders.ship_ref_amphure_id')
                    ->leftJoin('districts as receipt_dist','receipt_dist.id','=','orders.ship_ref_district_id')
                ->leftJoin('shipping_method','shipping_method.id','=','orders.ref_shipping_method_id')
                ->leftJoin('default_bank','default_bank.id','=','orders.ref_transfer_bank_id')
                ->leftJoin('order_status','order_status.id','=','orders.ref_order_status_id')
                ->with('order_products.product','order_products.color','order_products.size')
                ->orderBy('id','DESC')
                ->paginate(10);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $transport = DB::Table('orders')->select('Transport_type')->groupBy('Transport_type')->get();

        $data['transport'] = $transport;
        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/members/order', $data);

    }
}
