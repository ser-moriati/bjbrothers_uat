<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Member;
use App\Province;
use App\District;
use App\Amphures;
use App\Geographie;
use App\MemberAddress;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class RegisterController extends Controller
{
    public function showMemberRegisterForm()
    {
        $data['province'] = Province::get();
        $data['district'] = District::get();
        $data['amphures'] = Amphures::get();
        $data['geographie'] = Geographie::get();
        return view('register',$data);
    }
    protected function createMember(Request $request)
    {
        // return $request;
        try{
            $secretKey = '6LcQAXEoAAAAAAlieydXDaFnAxEou8qE_PN0afgY';
            $userResponse = $_POST['g-recaptcha-response'];
            $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, [
                        'secret' => $secretKey,
                        'response' => $userResponse,
            ]);

            $response = curl_exec($ch);
            curl_close($ch);

            if ($response === false) {
            die('cURL request failed: ' . curl_error($ch));
            }

            $data = json_decode($response);

            if ($data->success) {
                $member = new Member;
                $member->member_firstname = $request->member_firstname;
                $member->member_lastname = $request->member_lastname;
                $member->member_phone = $request->member_phone;
                $member->member_line = $request->member_line;
                $member->member_email = $request->member_email;
                $member->ref_member_category_id = $request->ref_member_category_id;
                $member->company_name = $request->company_name;
                $member->member_TaxID = $request->member_TaxID;
                $member->company_email = $request->company_email;
                $member->company_phone = $request->company_phone;
                $member->company_fax = $request->company_fax;
                // $member->company_addr = $request->company_addr;
                $member->ref_role_id = 1;
                // $member->ref_geographie_id = $request->ref_geographie_id;
                // $member->ref_province_id = $request->ref_province_id;
                // $member->ref_amphures_id = $request->ref_amphures_id;
                // $member->ref_district_id = $request->ref_district_id;
                $member->zipcode = $request->zipcode;
                $member->username = $request->username;
                $member->password = Hash::make($request->password);
                $member->save();

                // $address = new MemberAddress;
                // $address->ref_member_id = $member->id;
                // $address->address_type = 1;
                // $address->addr = $request->company_addr;
                // $address->ref_geographie_id = $request->ref_geographie_id;
                // $address->ref_province_id = $request->ref_province_id;
                // $address->ref_amphures_id = $request->ref_amphures_id;
                // $address->ref_district_id = $request->ref_district_id;
                // $address->zipcode = $request->zipcode;
                // $address->save();

                // $address = new MemberAddress;
                // $address->ref_member_id = $member->id;
                // $address->address_type = 2;
                // $address->addr = $request->company_addr;
                // $address->ref_geographie_id = $request->ref_geographie_id;
                // $address->ref_province_id = $request->ref_province_id;
                // $address->ref_amphures_id = $request->ref_amphures_id;
                // $address->ref_district_id = $request->ref_district_id;
                // $address->zipcode = $request->zipcode;
                // $address->save();

                DB::commit();
                return redirect()->intended('login')->with('message', 'Register success please login')->with('message_status', 'success');

            }else{
                return back()
                ->with('message', 'Error กรุณาเลือกฉันไม่ใช่โปรแกรมอัตโนมัติ')
                ->with('message_status', 'error');
            }
        } catch (QueryException $err) {
            DB::rollBack();
            return $err;
        }
    }
}
