<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Member;
use App\MemberCategory;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;

DB::beginTransaction();
// DB::beginTransaction();

class PasswordController extends Controller
{
    public function module() {
        return 'account';
    } 
    public function index(Request $request){
        $data['member'] = Auth::guard('member')->user();
        // $data['member']->member_category_name = $member_category_name->category_name;

        return view('member_password', $data);

    }
    public function resetPassword(){
        $data['member'] = Auth::guard('member')->user();
        // $data['member']->member_category_name = $member_category_name->category_name;

        return view('reset_password', $data);
    }
    public function resetPasswordSendMail(Request $request){
        
        $Mail = Mail::to($request->email)->send(new ResetPasswordMail());
        if($Mail){
            return redirect('reset_password'); 
        }
    }
    public function changePassword(Request $request){

        try{
            $id = Auth::guard('member')->user()->id;
            $member = Member::find($id);
            $member->password = Hash::make($request->password);
            $member->save();
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function checkPassword($password){
        
        if(Hash::check($password, Auth::guard('member')->user()->password)){
            return response(true);
        }
        return response("รหัสผ่านปัจจุบันไม่ถูกต้อง");
    }
}
