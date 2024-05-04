<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Order;
use App\OrderHasProduct;
use App\OrderStatus;
use App\Product;
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
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\DefaultBank;
DB::beginTransaction();

class OrderController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'order';
        $data['page'] = 'Order';
        $data['page_url'] = 'order';
        $data['status'] = OrderStatus::orderBy('id_','asc')->get();
        $data['changStatus'] = [
                                2 => 'paid',
                                3 => 'shipping',
                                4 => 'success'
                            ];

        $results = Order::selectRaw('orders.*,members.member_firstname,members.member_lastname,default_bank.bank_name,shipping_method.shipping_name,order_status.status_name,order_status.color_background,order_status.color_code,ship_pro.name_th as ship_province_name,ship_amph.name_th as ship_amphure_name,ship_dist.name_th as ship_district_name,
        receipt_pro.name_th as receipt_province_name,receipt_amph.name_th as receipt_amphure_name,receipt_dist.name_th as receipt_district_name');
            if(@$request->order_number){
                $results = $results->Where('orders.order_number','LIKE','%'.$request->order_number.'%');
            }
            if(@$request->customer_name){
                $results = $results->Where(DB::raw("CONCAT(members.member_firstname, ' ', members.member_lastname)"),'LIKE','%'.$request->customer_name.'%');
            }
            if(@$request->status_id){
                $results = $results->Where('orders.ref_order_status_id',$request->status_id);
            }
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
        return view('admin/orders/index', $data);

    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Product::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function confirmChangStatus(Request $request, $id)

    {

        try{
            if($request->status == 7){
                $order = Order::find($id);
                $order->ref_order_status_id = 1;
                $order->save();

                $date4 = [
                    'id_order'		    => $id,
                    'status'		    => 1,
                    'user_id'		    => Auth::user()->id,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
                DB::table('log')->insert($date4);
            }else{
                $order = Order::find($id);
                $order->ref_order_status_id = $request->status+1;
                $order->save();

                $date4 = [
                    'id_order'		    => $id,
                    'status'		    => $request->status+1,
                    'user_id'		    => Auth::user()->id,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ];
                DB::table('log')->insert($date4);
            }
           
          
         
            $data['order'] = Order::select('orders.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
            'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
            'members.member_firstname','members.member_lastname','members.company_name','default_bank.bank_name','shipping_method.shipping_name')
            ->leftJoin('provinces as ship_pro','ship_pro.id','=','orders.ship_ref_province_id')
            ->leftJoin('amphures as ship_amph','ship_amph.id','=','orders.ship_ref_amphure_id')
            ->leftJoin('districts as ship_dist','ship_dist.id','=','orders.ship_ref_district_id')
            ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','orders.ship_ref_province_id')
            ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','orders.ship_ref_amphure_id')
            ->leftJoin('districts as receipt_dist','receipt_dist.id','=','orders.ship_ref_district_id')
            ->leftJoin('shipping_method','shipping_method.id','=','orders.ref_shipping_method_id')
            ->leftJoin('default_bank','default_bank.id','=','orders.ref_transfer_bank_id')
            ->leftJoin('members','members.id','=','orders.ref_member_id')
            ->where('orders.id',$id)->with('order_products.product','order_products.productsoption1','order_products.productsoption2')->first();
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
            //
            $member_email =  DB::table('members')->where('id',$order->ref_member_id)->first();
            
            $email = $member_email->company_email;
            //แจ้งเตือนฝั่งลูกค้า
          
            $data['bank'] = DefaultBank::orderBy('bank_name')->get();
            if($request->status == 7){
                if($member_email->member_email== $member_email->company_email){
                    Mail::send('mail.confirm', $data, function ($message) use ($member_email) {
                        $message->from('worawe@ots.co.th', 'BJBROTHERS');
                        $message->to($member_email->member_email)
                            ->subject("แจ้งเตือน");
                    });
                }else{
                    Mail::send('mail.confirm', $data, function ($message) use ($member_email) {
                        $message->from('worawe@ots.co.th', 'BJBROTHERS');
                        $message->to($member_email->member_email)
                            ->subject("แจ้งเตือน");
                    });
                    
                    Mail::send('mail.confirm', $data, function ($message) use ($member_email) {
                        $message->from('worawe@ots.co.th', 'BJBROTHERS');
                        $message->to($member_email->company_email)
                            ->subject("แจ้งเตือน");
                    });
                    //
              }
               
            }
                  
            if($request->status == 5){
                if($member_email->member_email== $member_email->company_email){
                    Mail::send('mail.Cancel_confirmed', $data, function ($message) use ($member_email) {
                        $message->from('worawe@ots.co.th', 'BJBROTHERS');
                        $message->to("$member_email->member_email")
                            ->subject("แจ้งเตือน");
                    });
                }else{
                    Mail::send('mail.Cancel_confirmed', $data, function ($message) use ($member_email) {
                        $message->from('worawe@ots.co.th', 'BJBROTHERS');
                        $message->to("$member_email->member_email")
                            ->subject("แจ้งเตือน");
                    });
                    
                    Mail::send('mail.Cancel_confirmed', $data, function ($message) use ($member_email) {
                        $message->from('worawe@ots.co.th', 'BJBROTHERS');
                        $message->to($member_email->company_email)
                            ->subject("แจ้งเตือน");
                    });
                //
              }
            }
            if($request->status == 2){
              
                Mail::send('mail.confirm_paid', $data, function ($message) use ($member_email) {
                    $message->from('worawe@ots.co.th', 'BJBROTHERS');
                    $message->to($member_email->member_email)
                        ->subject("แจ้งเตือน");
                });
                
                Mail::send('mail.confirm_paid', $data, function ($message) use ($member_email) {
                    $message->from('worawe@ots.co.th', 'BJBROTHERS');
                    $message->to($member_email->company_email)
                        ->subject("แจ้งเตือน");
                });
                //
                }
            if($request->status == 3){
            //แจ้งเตือนฝั่งลูกค้า
                Mail::send('mail.confirm_paid', $data, function ($message) use ($member_email) {
                    $message->from('worawe@ots.co.th', 'BJBROTHERS');
                    $message->to($member_email->member_email)
                        ->subject("แจ้งเตือน");
                });
                
                Mail::send('mail.confirm_paid', $data, function ($message) use ($member_email) {
                    $message->from('worawe@ots.co.th', 'BJBROTHERS');
                    $message->to($member_email->company_email)
                        ->subject("แจ้งเตือน");
                });
            }
            DB::commit();

            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function Tracking_Number(Request $request)

    {

        try{
        
            $order = Order::find($request->id);
            $order->ref_order_status_id = 4;
            $order->Transport_type =  $request->Transport_type;
            $order->Tracking_Number = $request->Tracking_Number;
            $order->save();
            
            $data['order'] = Order::select('orders.*','ship_pro.name_th as ship_province_name','ship_amph.name_th as ship_amphure_name','ship_dist.name_th as ship_district_name',
            'receipt_pro.name_th as receipt_province_name','receipt_amph.name_th as receipt_amphure_name','receipt_dist.name_th as receipt_district_name',
            'members.member_firstname','members.member_lastname','members.company_name','default_bank.bank_name','shipping_method.shipping_name')
            ->leftJoin('provinces as ship_pro','ship_pro.id','=','orders.ship_ref_province_id')
            ->leftJoin('amphures as ship_amph','ship_amph.id','=','orders.ship_ref_amphure_id')
            ->leftJoin('districts as ship_dist','ship_dist.id','=','orders.ship_ref_district_id')
            ->leftJoin('provinces as receipt_pro','receipt_pro.id','=','orders.ship_ref_province_id')
            ->leftJoin('amphures as receipt_amph','receipt_amph.id','=','orders.ship_ref_amphure_id')
            ->leftJoin('districts as receipt_dist','receipt_dist.id','=','orders.ship_ref_district_id')
            ->leftJoin('shipping_method','shipping_method.id','=','orders.ref_shipping_method_id')
            ->leftJoin('default_bank','default_bank.id','=','orders.ref_transfer_bank_id')
            ->leftJoin('members','members.id','=','orders.ref_member_id')
            ->where('orders.id',$request->id)->with('order_products.product','order_products.color','order_products.size')->first();
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
            $data['sum'] =   DB::table('order_has_product')->where('ref_order_id',$request->id)->sum('order_total');
            $contact = Contact::first();
            $member_email =  DB::table('members')->where('id',$order->ref_member_id)->first();
            $email = $member_email->company_email;
            Mail::send('mail.confirm_shipping', $data, function ($message) use ($member_email) {
                $message->from('worawe@ots.co.th', 'BJBROTHERS');
                $message->to($member_email->member_email)
                    ->subject("แจ้งเตือน");
            });
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function updateConfirmPayment(Request $request){
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
        if($request->file('Tracking_file')){
            $file1 = $request->file('Tracking_file');
            $nameExtension1 = $file1->getClientOriginalName();
            $extension1 = pathinfo($nameExtension1, PATHINFO_EXTENSION);
            $img_name1 = pathinfo($nameExtension1, PATHINFO_FILENAME);
            $path1 = "upload/slip/";
            $nameExtension1 = $img_name1.$date.'.'.$extension1;
            $file1->move($path1, $nameExtension1);
        }
      
        try{

            $order = Order::find($request->id);
            if($request->file('file')){
                $order->receipt = $nameExtension;
            }
            if($request->file('Tracking_file')){
                $order->Tracking_file = $nameExtension1;
            }
            $order->Comment = $request->Comment;
            $order->ref_order_status_id = 3;
            $order->Transport_type =  $request->Transport_type;
            $order->Tracking_Number = $request->Tracking_Number;
            $order->save();
            
            $date4 = [
               'id_order'		    => $request->id,
                'status'		    => 3,
                'user_id'		    => Auth::user()->id,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
            DB::table('log')->insert($date4);
 
          
            DB::commit();
            return redirect("admin/order")->with('message', 'อัตเดตยืนยันการชำระเงินและข้อมูลจัดส่งสินค้า สำเร็จ');
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function update(Request $request){
        try{

            $list_order = DB::table('order_has_product')->where('ref_order_id',$request->id)->get();
            foreach( $list_order as $list_order){
                $data3 = [
                    'qty'		    => $request->Qty[$list_order->id],
                    'order_total'	=> $request->sumprice[$list_order->id],
                ];
                DB::table('order_has_product')->where('id',$list_order->id)->update($data3);
            }

            $sum =   DB::table('order_has_product')->where('ref_order_id',$request->id)->sum('order_total');
            $check_vat = DB::table('orders')->where('id',$request->id)->first();
            // if($check_vat->vat_check == '1'){
            //     $vat = $sum *0.07 ;
            //     $sum_total = $sum + $request->Shipping + $vat;
            //     $vat = number_format($sum *0.07, 2);

            // }else{
            //     $vat = 0 ;
            //     $sum_total = $sum + $request->Shipping;
            // }
            $Shipping = $request->Shipping;
            if($request->check_Shipping == 1){
                $Shipping = 0.00;   
            }
            $order = Order::find($request->id);
            if($request->checkvat == 1){
                $vat = $sum *0.07 ;
                $sum_total = $sum + $request->Shipping + $vat;
                $vat = number_format($sum *0.07, 2);
                $order->vat_check = 1;
            }else{
                $vat = 0 ;
                $sum_total = $sum + $request->Shipping;
                $order->vat_check = 0;
            }
          
            $order->shipping_cost = $Shipping;
            $order->check_Shipping = $request->check_Shipping;
            $order->vat = str_replace(',', '',$vat);
            $order->save();

            $date4 = [
                'id_order'		    => $request->id,
                'status'		    => 7,
                'user_id'		    => Auth::user()->id,
                'created_at'        => now(),
                'updated_at'        => now(),
            ];
            DB::table('log')->insert($date4);
            DB::commit();
            return redirect("admin/order")->with('message', 'Update order success');
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
  
   
}
