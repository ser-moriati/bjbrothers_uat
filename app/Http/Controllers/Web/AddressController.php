<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Member;
use App\MemberAddress;
use App\MemberCategory;
use Auth;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class AddressController extends Controller
{
    public function module() {
        return 'account';
    } 
    public function index(){
        $data['module'] = $this->module();
        $data['page'] = 'Company';
        $data['memberName'] = "address";
        $data['page_url'] = $this->module();
        $data['member'] = Auth::guard('member')->user();
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
        // $data['member']->member_category_name = $member_category_name->category_name;
        // return $data['member'] = Member::leftJoin('')->where('id',$user_id)->fisrt();

        return view('member_address', $data);

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
}
