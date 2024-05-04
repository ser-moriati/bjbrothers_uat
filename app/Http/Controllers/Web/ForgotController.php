<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Member;
use App\Seo;
use DateTime;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

DB::beginTransaction();
// DB::beginTransaction();

class ForgotController extends Controller
{
    public function index($id){
        $ex = explode('_',base64_decode($id));
        
        $datetime = date('Y-m-d H:i:s',$ex[1]);

        if($datetime < date('Y-m-d H:i:s')){
            return redirect('login')->with('message', 'คุณไม่ได้ทำรายการภายในเวลาที่กำหนด')->with('message_status', 'danger');
        }
        $member = Member::where('id',$ex[0])->Where('remember_token',$ex[2])->first();
        if(!$member){
            return redirect('login')->with('message', 'เกิดข้อผิดพลาด')->with('message_status', 'danger');
        }
        $data['id'] = $id;
        $data['meta'] = Seo::find(6);
        return view('reset_password', $data);
    }

    public function sendEmail(Request $request){
        try{
            $member = Member::where('member_email',$request->email)->first();
            if(!$member){
                return ['status'=>'F','massage'=>'ไม่พบชื่อผู้ใช้'];
            }

            $token = rand();
            
            $update = Member::find($member->id);
            $update->remember_token = $token;
            $update->save();
            
            $date10 = date( 'Y-m-d H:i:s', strtotime( '+600 seconds') );
            $data['member'] = $member;
            $data['memberfirstname'] = $member->member_firstname;
            $data['memberlastname'] = $member->member_lastname;
            $data['token'] = $token;
            $data['time'] = strtotime($date10);
        // $re = date('Y-m-d H:i:s',$date->getTimestamp());

            DB::commit();
            // return view('mail.forgot',$data);
            
            Mail::send('mail.forgot',$data, function ($message) use ($request) {
                $message->from('worawek@ots.co.th', 'bjbrothers');
                $message->to($request->email)
                ->subject("reset your password");
            });

            return ['status'=>'success','massage'=>'สำเร็จ!!! กรุณาตรวจสอบ email ของท่าน และทำรายการภายใน 10 นาที'];
        } catch (QueryException $err) {
            DB::rollBack();
            return $err;
        }
    }

    public function update(Request $request, $id){
        $ex = explode('_',base64_decode($id));

        $datetime = date('Y-m-d H:i:s',$ex[1]);
        
        if($datetime < date('Y-m-d H:i:s')){
            return redirect('login')->with('message', 'คุณไม่ได้ทำรายการภายในเวลาที่กำหนด')->with('message_status', 'danger');
        }
        $member = Member::where('id',$ex[0])->Where('remember_token',$ex[2])->first();
        if(!$member){
            return redirect('login')->with('message', 'เกิดข้อผิดพลาด')->with('message_status', 'danger');
        }
        try{
            $update = Member::find($ex[0]);
            $update->password = Hash::make($request->password);
            $update->save();
            DB::commit();
            return redirect('login')->with('message', 'เปลี่ยนรหัสผ่านเรียบร้อย')->with('message_status', 'success');
        } catch (QueryException $err) {
            DB::rollBack();
            return $err;
        }
    }
}
