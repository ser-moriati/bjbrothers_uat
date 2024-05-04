<?php

namespace App\Http\Controllers\Web;

use App\Contact;
use App\DefaultBank;
use App\Order;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

DB::beginTransaction();
// DB::beginTransaction();

class OrderController extends Controller
{
    public function index(){
        $data['page'] = 'Company';
        $member_id = Auth::guard('member')->user()->id;
        $data['order'] = Order::select('carts.*','products.product_name','products.product_image','products.product_code','products.product_price','products.product_sale','colors.color_name','sizes.size_name')
                            ->leftJoin('products','products.id','=','carts.ref_product_id')
                            ->leftJoin('colors','colors.id','=','carts.ref_color_id')
                            ->leftJoin('sizes','sizes.id','=','carts.ref_size_id')
                            ->where('carts.ref_member_id',$member_id)
                            ->orderBy('id','DESC')->get();

        return view('cart', $data);

    }


    public function checkOrder($order = null){
        
        
        $member_id = Auth::guard('member')->user()->id;
        
        $order = Order::where('order_number', $order)->where('ref_member_id', $member_id)->first();
        // return $order->ref_order_status_id;
        
        if(empty($order)){
            return ['disabled' => true,'status_color'=>'red','message'=>'ไม่พบ order ของท่าน'];
        }
        if($order->ref_order_status_id > 1){
            return ['disabled' => true,'status_color'=>'green','message'=>'order นี้ แจ้งชำระเงินแล้ว'];
        }
        if($order->ref_order_status_id == 1){
            return ['disabled' => false,'status_color'=>'green','message'=>'order ถูกต้อง <i class="fa fa-check" aria-hidden="true"></i>'];
        }
        if($order){
            return false;
        }

    }


    public function orderHistory(Request $request){
        $data['page'] = 'Company';
        $data['memberName'] = "history";
        $member_id = Auth::guard('member')->user()->id;
        $order = Order::select('orders.id','orders.order_number','orders.created_at','orders.vat','orders.shipping_cost','orders.ref_order_status_id','order_status.status_name')->leftJoin('order_status','order_status.id','=','orders.ref_order_status_id')->where('orders.ref_member_id',$member_id);
        if($request->search){
            $order = $order->where('order_number','like','%'.$request->search.'%');
        }
        $order = $order->with('order_products.product','order_products.color','order_products.size')->orderBy('id','DESC')->get();
        $data['order'] = $order;
        $data['query'] = request()->query();
        return view('member_orderhistory', $data);
    }
    public function orderHistory_Payment(Request $request){
        $data['page'] = 'Company';
        $data['memberName'] = "orderHistory_Payment";
        $member_id = Auth::guard('member')->user()->id;
        $order =  Order::select('orders.id','orders.order_number','orders.created_at','orders.vat','orders.shipping_cost','orders.ref_order_status_id','order_status.status_name')->leftJoin('order_status','order_status.id','=','orders.ref_order_status_id')->where('orders.ref_member_id',$member_id)->where('ref_order_status_id','=','1');
    
        $order = $order->with('order_products.product','order_products.color','order_products.size')->orderBy('id','DESC')->get();
        $data['order'] = $order;
        $data['query'] = request()->query();
       
        return view('orderHistory_Payment', $data);
    }

    public function orderHistoryDetail($id){
        $data['page'] = 'Company';
        $data['memberName'] = "history";
        $member_id = Auth::guard('member')->user()->id;
        $data['order'] = Order::select('orders.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
                                                'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
                                                'members.member_firstname','members.member_lastname','members.company_name','order_status.status_name','payment_method.payment_name','shipping_method.shipping_name')
                                ->leftJoin('provinces as ship_pro','ship_pro.id','=','orders.ship_ref_province_id')
                                ->leftJoin('amphures as ship_amph','ship_amph.id','=','orders.ship_ref_amphure_id')
                                ->leftJoin('districts as ship_dist','ship_dist.id','=','orders.ship_ref_district_id')
                                ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','orders.ship_ref_province_id')
                                ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','orders.ship_ref_amphure_id')
                                ->leftJoin('districts as receipt_dist','receipt_dist.id','=','orders.ship_ref_district_id')
                                ->leftJoin('shipping_method','shipping_method.id','=','orders.ref_shipping_method_id')
                                ->leftJoin('payment_method','payment_method.id','=','orders.ref_payment_method_id')
                                ->leftJoin('members','members.id','=','orders.ref_member_id')
                                ->leftJoin('order_status','order_status.id','=','orders.ref_order_status_id')
                                ->where('orders.id',$id)->where('orders.ref_member_id',$member_id)->with('order_products.product','order_products.color','order_products.size')->first();
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

        return view('member_orderhistory_detail', $data);
    }
    public function summary($id){

        try{
            $data['page'] = 'Company';
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
                                    ->where('orders.id',$id)->where('orders.ref_member_id',$member_id)->with('order_products.product','order_products.color','order_products.size')->first();
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
            DB::commit();
            return view('order_summary', $data);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function status($id){

        try{
            $data['page'] = 'Company';
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
                                    ->where('orders.id',$id)->where('orders.ref_member_id',$member_id)->with('order_products.product','order_products.color','order_products.size')->first();
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

            DB::commit();
            return view('order_status', $data);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function update(Request $request){
        try{
            $cart = Order::find($request->id);
            $cart->qty = $request->qty;
            $cart->save();
            DB::commit();
            return response($cart);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function confirmPayment($id = null){
        $member_id = Auth::guard('member')->user()->id;
        // $data['order'] = Order::select('order_number')
        // ->where('ref_member_id',$member_id)
        // ->where('id',$id)
        // ->first();

        $data['order'] = Order::select('orders.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
                                        'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
                                        'members.member_firstname','members.member_lastname','members.company_name','order_status.status_name','payment_method.payment_name','shipping_method.shipping_name')
                        ->leftJoin('provinces as ship_pro','ship_pro.id','=','orders.ship_ref_province_id')
                        ->leftJoin('amphures as ship_amph','ship_amph.id','=','orders.ship_ref_amphure_id')
                        ->leftJoin('districts as ship_dist','ship_dist.id','=','orders.ship_ref_district_id')
                        ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','orders.ship_ref_province_id')
                        ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','orders.ship_ref_amphure_id')
                        ->leftJoin('districts as receipt_dist','receipt_dist.id','=','orders.ship_ref_district_id')
                        ->leftJoin('shipping_method','shipping_method.id','=','orders.ref_shipping_method_id')
                        ->leftJoin('payment_method','payment_method.id','=','orders.ref_payment_method_id')
                        ->leftJoin('members','members.id','=','orders.ref_member_id')
                        ->leftJoin('order_status','order_status.id','=','orders.ref_order_status_id')
                        ->where('orders.id',$id)->where('orders.ref_member_id',$member_id)->with('order_products.product','order_products.color','order_products.size')->first();
                        
        $Order = Order::where('ref_member_id',$member_id)
                            ->where('order_number',$id)
                            ->first();
        $data['action'] = '/order/updateConfirmPayment/';
        $data['bank'] = DefaultBank::orderBy('bank_name')->get();
      
      
        $data['id'] = $id;
        $shipping = 0 ;
        $shipping = $Order->shipping_cost;
        if($Order->vat_check == 1){
            $total_Order=   DB::table('order_has_product')->where('ref_order_id',$Order->id)->sum('order_total');
            $vat = $total_Order *0.07 ;
            $sum_total = $total_Order + $Order->shipping_cost+ $vat;
            $data['sum'] =  number_format($sum_total, 2);
           
           
        }else{
            $total_Order=   DB::table('order_has_product')->where('ref_order_id',$Order->id)->sum('order_total');
            $vat = 0 ;
            $sum_total = $total_Order + $Order->shipping_cost + $vat;
            $data['sum'] =  number_format($sum_total, 2);
        }
        $total_order =   DB::table('order_has_product')->where('ref_order_id',$Order->id)->sum('order_total');
       
        return view('confirm_payment', $data);
    }

    public function cancelPayment($id = null){
        $member_id = Auth::guard('member')->user()->id;
        $data['order'] = Order::select('order_number')
        ->where('ref_member_id',$member_id)
        ->where('id',$id)
        ->first();
        $Order = Order::where('ref_member_id',$member_id)
                            ->where('order_number',$id)
                            ->first();
        $data['id'] = $id;
        return view('Cancelorder', $data);
    } 

    public function updateConfirmPayment(Request $request,$id = null){
        // return $request;
        $date = date('dmy-His');
        if($request->file('file')){
            $file = $request->file('file');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/slip/";
            $nameExtension = $img_name.$date.'.'.$extension;
            $file->move($path, $nameExtension);
        }
        
        try{
            if(!$id){
                $id = Order::where('order_number', $request->order_number)->first()->id;
            }
            
            $tdate = explode('/',$request->transfer_date);
            $tdate = $tdate[2].'-'.$tdate[0].'-'.$tdate[1];


            $order = Order::find($id);
            // if($order->ref_order_status_id = 8){
            //     return redirect("order/confirmPayment/$id")->with('message', 'order นี้ แจ้งยกเลิก')->with('message_status', 'danger');
            // }
            // if($order->ref_order_status_id != 1){
            //     return redirect("order/confirmPayment/$id")->with('message', 'order นี้ แจ้งชำระเงินแล้ว')->with('message_status', 'danger');
            // }
            $originalValue = $request->transfer_amount;
            $newValue = str_replace(",", "", $originalValue);
            
         
            $order->ref_transfer_bank_id = $request->bank_id;
            $order->transfer_amount =$newValue;
            $order->transfer_date = $tdate;
            $order->transfer_time = $request->transfer_time;
            $order->transfer_image = $nameExtension;
            $order->ref_order_status_id = 2;
            $order->save();
          
            $bank_name = DefaultBank::find($request->bank_id)->bank_name;
            // $data['order_number'] = $request->order_number;
            $data['bank_name'] = $bank_name;
            $data['order'] = $order;
            $data['request'] = $request;
            $data['id'] = $id;
            // return view('mail/confirm_payment', $data);
            $contact = Contact::first();

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
            ->where('orders.id',$id)->with('order_products.product','order_products.color','order_products.size')->first();
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
            $data['sum'] =   DB::table('order_has_product')->where('ref_order_id',$id)->sum('order_total');
            $contact = Contact::first();
            $member_id = Auth::guard('member')->user()->id;
            $member_email =  DB::table('members')->where('id',$member_id)->first();
            
            $email = $member_email->company_email;
            //แจ้งเตือนฝั่งลูกค้า
           if($member_email->member_email == $member_email->company_email ){
            Mail::send('mail.confirm_payment_customer', $data, function ($message) use ($member_email) {
                $message->from('worawe@ots.co.th', 'BJBROTHERS');
                $message->to($member_email->member_email)
                    ->subject("แจ้งเตือน");
            });
           }else{
                Mail::send('mail.confirm_payment_customer', $data, function ($message) use ($member_email) {
                    $message->from('worawe@ots.co.th', 'BJBROTHERS');
                    $message->to($member_email->member_email)
                        ->subject("แจ้งเตือน");
                });
                
                Mail::send('mail.confirm_payment_customer', $data, function ($message) use ($member_email) {
                    $message->from('worawe@ots.co.th', 'BJBROTHERS');
                    $message->to($member_email->company_email)
                        ->subject("แจ้งเตือน");
                });
                //

           }
           
            Mail::send('mail.confirm_payment', $data, function ($message) use ($contact) {
                $message->from('worawe@ots.co.th', 'BJBROTHERS');
                $message->to('salecenter@bjbrothers.com')
                ->subject("รอยืนยันการชำระเงิน");
            });
            // $message->to($contact->email)
            
            DB::commit();

            // $img->move($path, $nameExtension);

            return redirect("order/status/$id")->with('message', 'Update success')->with('message_status', 'success');
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function updatecancelConfirmPayment(Request $request,$id = null){
        // return $request;
       
        try{
            if(!$id){
                $id = Order::where('order_number', $request->order_number)->first()->id;
            }



            $order = Order::find($id);
            if($order->ref_order_status_id = 8){
                return redirect("order/cancelPayment/$id")->with('message', 'order นี้ แจ้งยกเลิกแล้ว')->with('message_status', 'danger');
            }
            if($order->ref_order_status_id != 1){
                return redirect("order/cancelPayment/$id")->with('message', 'order นี้ แจ้งชำระเงินแล้ว')->with('message_status', 'danger');
            }
            $order->ref_order_status_id = 8;
            $order->Comment = $request->Comment;
            $order->save();
          
          
       
            $data['request'] = $request;
            $data['id'] = $id;
            // return view('mail/confirm_payment', $data);
            $contact = Contact::first();

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
            ->where('orders.id',$id)->with('order_products.product','order_products.color','order_products.size')->first();
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
            $data['sum'] =   DB::table('order_has_product')->where('ref_order_id',$id)->sum('order_total');
            $contact = Contact::first();
            $member_id = Auth::guard('member')->user()->id;
            $member_email =  DB::table('members')->where('id',$member_id)->first();
            
            $email = $member_email->company_email;
            //แจ้งเตือนฝั่งลูกค้า
          
            // Mail::send('mail.confirm_payment_customer', $data, function ($message) use ($member_email) {
            //     $message->from('worawe@ots.co.th', 'BJBROTHERS');
            //     $message->to($member_email->member_email)
            //         ->subject("แจ้งเตือน");
            // });
            
            // Mail::send('mail.confirm_payment_customer', $data, function ($message) use ($member_email) {
            //     $message->from('worawe@ots.co.th', 'BJBROTHERS');
            //     $message->to($member_email->company_email)
            //         ->subject("แจ้งเตือน");
            // });
            // //

            Mail::send('mail.Cancel', $data, function ($message) use ($contact) {
                $message->from('worawe@ots.co.th', 'BJBROTHERS');
                $message->to('salecenter@bjbrothers.com')
                ->subject("แจ้งเตือน  ขอยกเลิกการสั่งซื้อ");
            });
            // $message->to($contact->email)
            
            DB::commit();

            // $img->move($path, $nameExtension);

            return redirect("order/cancelPayment/$request->order_number")->with('message', 'Update success')->with('message_status', 'success');
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function remove(Request $request){

        try{
            Order::destroy($request->id);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
}
