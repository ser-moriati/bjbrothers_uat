<?php

namespace App\Http\Controllers\Web;

use App\Amphures;
use App\District;
use App\Geographie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Member;
use App\MemberAddress;
use App\MemberCategory;
use App\Province;
use Auth;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class AccountController extends Controller
{
    public function module() {
        return 'account';
    } 
    public function index(){
        $data['module'] = $this->module();
        $data['page'] = 'Company';
        $data['page_url'] = $this->module();
        $data['member'] = Auth::guard('member')->user();
        $member_category_name = MemberCategory::select('category_name')->where('id',$data['member']->ref_member_category_id)->first();
        $data['member']->member_category_name = $member_category_name->category_name;
        // return $data['member'] = Member::leftJoin('')->where('id',$user_id)->fisrt();
        $data['shipping_address'] = MemberAddress::select('member_address.*','provinces.name_th as province_name','amphures.name_th as amphure_name','districts.name_th as district_name')
                                                    ->leftJoin('provinces', 'provinces.id', 'member_address.ref_province_id')
                                                    ->leftJoin('amphures', 'amphures.id', 'member_address.ref_amphures_id')
                                                    ->leftJoin('districts', 'districts.id', 'member_address.ref_district_id')
                                                    ->where('member_address.address_type',1)
                                                    ->where('member_address.ref_member_id',$data['member']->id)
                                                    ->get();
        $data['receipt_address'] = MemberAddress::select('member_address.*','provinces.name_th as province_name','amphures.name_th as amphure_name','districts.name_th as district_name')
                                                    ->leftJoin('provinces', 'provinces.id', 'member_address.ref_province_id')
                                                    ->leftJoin('amphures', 'amphures.id', 'member_address.ref_amphures_id')
                                                    ->leftJoin('districts', 'districts.id', 'member_address.ref_district_id')
                                                    ->where('member_address.address_type',2)
                                                    ->where('member_address.ref_member_id',$data['member']->id)
                                                    ->get();

        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['amphures'] = Amphures::get();
        $data['geographie'] = Geographie::get();
        
        return view('member_myaccount', $data);

    }
    public function update(Request $request,$id){

        try{
            $name = explode(' ',$request->member_name);
            $member = Member::find($id);
            $member->member_firstname = $name[0];
            $member->member_lastname = $name[1];
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
            // return $data['member'] = Member::leftJoin('')->where('id',$user_id)->fisrt();
            $category = MemberCategory::select('category_name')->where('id',$member->ref_member_category_id)->first();
            $data = [
                    'member_name'=>$member->member_firstname.' '.$member->member_lastname,
                    'member_email'=>$member->member_email,
                    'member_phone'=>$member->member_phone,
                    'member_line'=>$member->member_line,
                    'member_category_name'=>$category->category_name,
                    'company_name'=>$member->company_name,
                    'company_email'=>$member->company_email,
                    'member_TaxID'=>$member->member_TaxID,
                    'company_phone'=>$member->company_phone,
                    'company_fax'=>$member->company_fax,
            ];
            DB::commit();
            return response($data);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function address_insert(Request $request){
        try{
            $member = new MemberAddress();
            $member->ref_member_id = Auth::guard('member')->user()->id;
            $member->address_type = $request->address_type;
            $member->firstname = $request->firstname;
            $member->lastname = $request->lastname;
            $member->phone = $request->phone;
            $member->fax = $request->fax;
            $member->addr = $request->addr;
            $member->ref_geographie_id = $request->ref_geographie_id;
            $member->ref_province_id = $request->ref_province_id;
            $member->ref_amphures_id = $request->ref_amphures_id;
            $member->ref_district_id = $request->ref_district_id;
            $member->zipcode = $request->zipcode;
            $member->save();

            DB::commit();
            return redirect('account')->with('message', 'Insert Address Success')->with('message_status', 'success');
        } catch (QueryException $err) {
            DB::rollBack();
            return $err;
        }
    }
    public function address_update(Request $request, $id){
        try{
            $member = MemberAddress::find($id);
            $member->address_type = $request->address_type;
            $member->firstname = $request->firstname;
            $member->lastname = $request->lastname;
            $member->phone = $request->phone;
            $member->fax = $request->fax;
            $member->addr = $request->addr;
            $member->ref_geographie_id = $request->ref_geographie_id;
            $member->ref_province_id = $request->ref_province_id;
            $member->ref_amphures_id = $request->ref_amphures_id;
            $member->ref_district_id = $request->ref_district_id;
            $member->zipcode = $request->zipcode;
            $member->save();

            DB::commit();
            return redirect('account')->with('message', 'Update Address Success')->with('message_status', 'success');
        } catch (QueryException $err) {
            DB::rollBack();
            return $err;
        }
    }
    public function address_delete($id){
        try{
            MemberAddress::destroy($id);

            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function address_find($id){
            $data = MemberAddress::find($id);
        return response($data);
    }
}
