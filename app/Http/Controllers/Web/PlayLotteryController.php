<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\AgentDiscount;
use App\Models\Deposit;
use App\Models\LimitLock;
use App\Models\Lotto;
use App\Models\LottoDetail;
use App\Models\LottoOrder;
use App\Models\LottoOrderDetail;
use App\Models\LottoRound;
use App\Models\PlayLottery;
use App\Models\TakeOutNumber;
use App\Models\TakeOutNumberHead;
use App\Models\TextRunBanner;
use App\Models\Comission;
use App\Models\User;
use App\Models\Withdraw;
use App\Events\BackupTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Str;
use DB;
use DateTime;
use Illuminate\Support\Facades\Log;

class PlayLotteryController extends Controller
{

    public function index()
    {

        $lotto = Lotto::get()

            ->map(function ($item) {
                $item->round = LottoRound::where('lotto_id', $item->lotto_id)
                    ->OrderBy('round_date', 'desc')
                    ->first();

                return $item;
            });



        // return $lotto;

        // รอบหวยรัฐบาล
        $lottoRound_government = LottoRound::where('lotto_id', 1)->orderBy('id', 'desc')->first();


        return view('FrontEnd.PlayLottery.index')
            ->with('lotto', $lotto)


            // รอบหวยรัฐบาล
            ->with('lottoRound_government', $lottoRound_government);
    }
    
    public function checkdatetmie(Request $request )
    {

       
        $formattedDate = new DateTime();
        $date_now = $formattedDate->format('Y-m-d H:i:s');
        $lottoRound_government = LottoRound::where('lotto_id', 1)->orderBy('id', 'desc')->first();
        if ($lottoRound_government->status_on_off == 2 ){

            $data = 2;
        }else{    
                if ($lottoRound_government->status_on_off = 1 ){
                    $data = 0;
                      if($date_now > $lottoRound_government->date_end){ 
                        $data = 1;
                      } 
                }else{

                    $data = 0;
                }
        }
        
        return response()->json($data);
        
    }
    public function PlayLotteryDetail($lotto_id, $round_date)
    {


        $group_agent = Auth::user()->group_agent;

        //ข้อมูลหวยที่จะเอาไปเช็ค กับของ admin เอา val ไปใส่ใน lotto_id_check
        $lotto_detail_head = LottoDetail::where('lotto_id', $lotto_id)->where('group_agent', 0)->get();


        $lotto_detail = LottoDetail::where('lotto_id', $lotto_id)->where('group_agent', $group_agent)->get();

        $discount_rate = AgentDiscount::where('user_id', Auth::user()->id)
            ->with('get_detail_lotto')
            ->get();




        $LottoRound = LottoRound::select(
            'max_price'
        )
            ->where('lotto_rounds.lotto_id', 1)
            ->OrderBy('lotto_rounds.round_date', 'desc')->first();

        // ยอดเติมเงิน deposits
        $user_id = Auth::user()->id;

        $deposits = Deposit::where('user_id', $user_id)
            ->where('status', 2)
            ->sum('amount');

        $withdraw = Withdraw::where('user_id', $user_id)
            ->where('status', 2)
            ->sum('amount');

        // ยอดการเล่น
        $price_play = LottoOrder::where('id_user', $user_id)
            ->where('date', $round_date)
            ->sum('price');

        // ยอดเสีย
        $bad_balance = LottoOrder::select('id')
            ->where('id_user', $user_id)
            ->where('date', $round_date)

            ->get()
            ->map(function ($item) use ($round_date) {
                $item->bad_balance = LottoOrderDetail::where('lotto_order_details.id_order', $item->id)
                    ->where('lotto_order_details.status', 0)
                    ->sum('price_old');
                return $item;
            });
        $sum_bad_balance = 0;
        foreach ($bad_balance as $key =>  $balance) {
            $sum_bad_balance += $balance->bad_balance;
        }

        // ยอดได้
        $good_balance = LottoOrder::select('id')
            ->where('id_user', $user_id)
            ->where('date', $round_date)
            ->get()
            ->map(function ($item) {
                $item->good_balance = LottoOrderDetail::where('lotto_order_details.id_order', $item->id)
                    ->where('lotto_order_details.status', 1)
                    ->sum('price_old');
                return $item;
            });
        $sum_good_balance = 0;
        foreach ($good_balance as $key =>  $balance) {
            $sum_good_balance += $balance->good_balance;
        }

        // ส่วนลด
        $discount = LottoOrder::select('id')
            ->where('id_user', $user_id)
            ->where('date', $round_date)
            ->get()
            ->map(function ($item) {
                $item->discount = LottoOrderDetail::where('lotto_order_details.id_order', $item->id)
                    ->sum('cal_discount');
                return $item;
            });

        $sum_discount = 0;
        foreach ($discount as $key =>  $val) {
            $sum_discount += $val->discount;
        }


        $order_his = LottoOrder::where('id_user', $user_id)
            ->OrderBy('created_at', 'DESC')
            ->where('date', $round_date)

            ->limit(3)
            ->get()
            ->map(function ($item) {
                $item->detail = LottoOrderDetail::where('lotto_order_details.id_order', $item->id)
                    ->select('lotto_id_check', 'number', 'price_old', 'cal_discount', 'lotto_order_details.multiplier', 'lotto_order_details.multiplier_admin', 'lotto_detail_type')
                    ->join('lotto_details', 'lotto_details.lotto_detail_id', 'lotto_order_details.lotto_id_check')
                    ->get();
                return $item;
            });




        $group_agent = auth()->user()->group_agent;
        $role =  auth()->user()->role;


        if ($role == 2) {
            $group_agent = 0;
        } else {
            $group_agent = auth()->user()->group_agent;
        }


        $text_run = TextRunBanner::where('group_agent', $group_agent)
            ->where('position', 2)
            ->first();
        // return $order_his;


        return view('FrontEnd.PlayLottery.PlayLotteryDetail')
            ->with('lotto_detail', $lotto_detail)
            ->with('round_date', $round_date)
            ->with('LottoRound', $LottoRound)
            ->with('discount_rate', $discount_rate)
            // ยอดเติมเงิน deposits
            ->with('deposits', $deposits)
            // ยอดเติมเงิน  $withdraw 
            ->with('withdraw', $withdraw)
            // ยอดการเล่น
            ->with('price_play', $price_play)
            // ส่วนลด
            ->with('sum_discount', $sum_discount)
            // ยอดเสีย
            ->with('sum_bad_balance', $sum_bad_balance)
            // ยอดได้
            ->with('sum_good_balance', $sum_good_balance)

            // โพย
            ->with('order_his', $order_his)

            // ตัวหนังสือวิ่ง
            ->with('text_run', $text_run)

            ->with('lotto_id', $lotto_id)
            ->with('lotto_detail_head', $lotto_detail_head);
    }

    // user สั่งซื้อหวย
    public function saveDataLotto(Request $request)
    {




        $role = Auth::user()->role;
        if ($role == 3) {
            $this->cal_comission($request->comission, $request->round_date, $request->lotto_id);
        }



        $data_result = $request->data;






        $group_agent = Auth::user()->group_agent;
        date_default_timezone_set('Asia/Bangkok');
        // $idCheck = Auth::user()->id;
        $user = User::find(Auth::user()->id);
        $order_name = $user->name;
        // total
        $total = 0;
        $cal_discount = 0;



        foreach ($data_result as $value) {
            $total += $value['price'];
        }
        foreach ($data_result as $value) {
            $cal_discount += $value['cal_discount'];
        }

        $total_price =  $total - $cal_discount;


        if (($user->credit + $user->credit_cash) > $total) {

            $code_id =  IdGenerator::generate([
                'table' => 'lotto_orders',
                'field' => 'code_id',
                'length' => 20,
                'prefix' => 'FS44-LOTTO-' . date("Y-d-"),
                'reset_on_prefix_change' => true
            ]);



              // lottoOrder
              $lottoOrder = new LottoOrder();
              $lottoOrder->id_user = $user->id;
              $lottoOrder->code_id = $code_id;
              $lottoOrder->order_name = $order_name;
              $lottoOrder->lotto_id = $request->lotto_id;
              $lottoOrder->date = $request->round_date;
              $lottoOrder->price = $total - $cal_discount;
              $lottoOrder->group_agent = $group_agent;
              $lottoOrder->status  = 0;
              $lottoOrder->save();
              $orderId = $lottoOrder;
  
              $lottoOrder_backup = new LottoOrder();
              $lottoOrder_backup->setConnection('mysql_backup'); // กำหนดการใช้งานฐานข้อมู
              $lottoOrder_backup->id_user = $user->id;
              $lottoOrder_backup->code_id = $code_id;
              $lottoOrder_backup->order_name = $order_name;
              $lottoOrder_backup->lotto_id = $request->lotto_id;
              $lottoOrder_backup->date = $request->round_date;
              $lottoOrder_backup->price = $total - $cal_discount;
              $lottoOrder_backup->group_agent = $group_agent;
              $lottoOrder_backup->status  = 0;
              $lottoOrder_backup->save();
              $orderId_backup = $lottoOrder_backup;
  
  
              // lottoDetail
              $lottoDetail = [];
  
  
  
  
              foreach ($data_result as $value) {
  
  
          
                  $lottoDetail  = new LottoOrderDetail();
                  $lottoDetail->id_order = $orderId->id;
                  $lottoDetail->id_user = $user->id;
                  $lottoDetail->lotto_id = $request->lotto_id;
                  $lottoDetail->lotto_id_check = $value['lotto_id_check'];
                  $lottoDetail->number = $value['number'];
                  $lottoDetail->price_old = $value['price'];
                  $lottoDetail->price_agent = $value['price_agent'];
                  $lottoDetail->price_over = $value['price'];
                  $lottoDetail->cal_discount = $value['cal_discount'];
                  $lottoDetail->multiplier = $value['rate_pay'];
                  $lottoDetail->multiplier_admin = $value['multiplier_admin'];
                  $lottoDetail->status_take_out = $value['status_take_out'] ?? 0;
                  $lottoDetail->group_agent = $group_agent;
                  $lottoDetail->round_date = $request->round_date;
                  $lottoDetail->save();

                  $lottoDetail_backup  = new LottoOrderDetail();
                  $lottoDetail_backup->setConnection('mysql_backup'); // กำหนดการใช้งานฐานข้อมูล mysql_backup
                  $lottoDetail_backup->id_order = $orderId_backup->id;
                  $lottoDetail_backup->id_user = $user->id;
                  $lottoDetail_backup->lotto_id = $request->lotto_id;
                  $lottoDetail_backup->lotto_id_check = $value['lotto_id_check'];
                  $lottoDetail_backup->number = $value['number'];
                  $lottoDetail_backup->price_old = $value['price'];
                  $lottoDetail_backup->price_agent = $value['price_agent'];
                  $lottoDetail_backup->price_over = $value['price'];
                  $lottoDetail_backup->cal_discount = $value['cal_discount'];
                  $lottoDetail_backup->multiplier = $value['rate_pay'];
                  $lottoDetail_backup->multiplier_admin = $value['multiplier_admin'];
                  $lottoDetail_backup->status_take_out = $value['status_take_out'] ?? 0;
                  $lottoDetail_backup->group_agent = $group_agent;
                  $lottoDetail_backup->round_date = $request->round_date;
                  $lottoDetail_backup->save();
  
  
              
            }
            // update credit
            $res_balance = $user->credit - $total_price;

            if ($res_balance < 0) {
                $user->credit = 0;
                $user->credit_cash = $user->credit_cash - (abs($res_balance));
            } else {
                $user->credit = $user->credit - $total_price;
            }

            $user->save();

            // event(new BackupTable('lotto_orders'));
            // event(new BackupTable('lotto_order_details'));
            // success
            return response()->json(['status' => true, 'message' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
        } else {
            return response()->json(['status' => false, 'message' => 'เงินไม่พอ']);
        }
    }
    
    public function test_backup(){
        Log::info('test_backup function called'); // Add this line for debugging
        event(new BackupTable('lotto_orders'));
        event(new BackupTable('lotto_order_details'));
    }


    public function checkNumber(Request $request)
    {


        $lotto_id = $request->lotto_id;

        $group_agent = Auth::user()->group_agent;
        $dataresult = [];
        $data = [];
        $data = $request->data;

        foreach ($data as $item) {

            $price = str_replace(',', '', $item['price']);

            $lotto_type = [];
            if ($item['lotto_type'] != 'reverse_3' || $item['lotto_type'] != 'reverse_2') {
                $lotto_type[] =  $item['lotto_type'];
            }


            if ($item['lotto_type'] == 'reverse_3') {
                $lotto_type = [];
                foreach ($data as $item_type) {

                    if ($item_type['lotto_type'] == 'reverse_3') {
                        array_push($lotto_type, 'สามตัวตรง');
                    }
                    if ($item_type['lotto_type'] == 'สามตัวล่าง') {
                        array_push($lotto_type, 'สามตัวล่าง');
                    }
                }
            }
            if ($item['lotto_type'] == 'reverse_2') {
                $lotto_type = [];
                foreach ($data as $item_type) {

                    if ($item_type['lotto_type'] == 'reverse_2') {
                        array_push($lotto_type, 'สองตัวบน');
                    }
                    if ($item_type['lotto_type'] == 'สองตัวล่าง') {
                        array_push($lotto_type, 'สองตัวล่าง');
                    }
                }
            }
            if ($item['reverse'] != null) {
                $number_reverse = $this->permutation(str_split($item['number']));

                if (count($data) > 1) {
                    $number_reverse =  array_filter($number_reverse, fn ($key) =>  $key != $data[0]['number']);
                }
            } else {
                $number_reverse[] = $item['number'];
            }

            $LottoRound = LottoRound::where('lotto_id', 1)
            ->orderBy('id', 'desc')
            ->first();
    

            foreach ($lotto_type as $val_type) {
                foreach (array_unique($number_reverse) as $key => $val) {

                    $lotto_details = LottoDetail::select('lotto_detail_id', 'lotto_detail_type')
                        ->where('lotto_detail_type', $val_type)
                        ->where('group_agent', 0)
                        ->first();

                    $check = LimitLock::where('number', $val)
                        ->where('lotto_id_check', $lotto_details['lotto_detail_id'])
                        ->where('lotto_id', $lotto_id)
                        ->where('group_agent', $group_agent)
                        ->where('round_date', $LottoRound->round_date)
                        ->select(
                            'status',
                            'number',
                            'rate_pay',
                        )
                        ->first();


                    if ($check != null) {

                        $dataresult[] = [
                            'number' => $val,
                            'lotto_type' => $lotto_details['lotto_detail_type'],
                            'price' =>  $price,
                            'rate_pay' => $check['status'] == 2 ?  $item['rate_pay'] : $check['rate_pay'],
                            'status' => $check['status'],
                            'lotto_detail_id' => $lotto_details->lotto_detail_id,
                            'status_take_out' => 0,

                        ];
                    } else {
                        $dataresult[] = [
                            'number' => $val,
                            'lotto_type' => $lotto_details['lotto_detail_type'],
                            'price' =>  $price,
                            'rate_pay' => $item['rate_pay'],
                            'status' => 0,
                            'lotto_detail_id' => $lotto_details->lotto_detail_id,
                            'status_take_out' => 0,

                        ];
                    }
                }
            }
        }

        $re_number_admin = [];


        foreach ($dataresult as $val) {
            if ($val['status'] == 2) {

                array_push($re_number_admin, $val);
            }
        }

        if (!empty($re_number_admin)) {

            return   $this->checknumber_admin($re_number_admin, $lotto_id);
        } else {
            return response()->json($dataresult);
        }
    }



    public function checknumber_admin($data, $lotto_id)
    {

        $LottoRound = LottoRound::where('lotto_id', 1)
        ->orderBy('id', 'desc')
        ->first();

        foreach ($data as $val) {
            $lotto_details = LottoDetail::select('lotto_detail_id', 'lotto_detail_type')
                ->where('lotto_detail_type', $val['lotto_type'])
                ->where('group_agent', 0)
                ->first();


            $check = LimitLock::where('number', $val['number'])
                ->where('lotto_id_check', $lotto_details['lotto_detail_id'])
                ->where('lotto_id', $lotto_id)
                ->where('group_agent', 0)
                ->where('round_date', $LottoRound->round_date)
                ->select(
                    'status',
                    'number',
                    'rate_pay',
                )
                ->first();
            if ($check != null) {


                $dataresult[] = [
                    'number' => $val['number'],
                    'lotto_type' => $lotto_details['lotto_detail_type'],
                    'price' =>  $val['price'],
                    'price_over' =>  $val['price'],
                    'rate_pay' => $check['rate_pay'],
                    'status' => $check['status'],
                    'lotto_detail_id' => $lotto_details->lotto_detail_id,
                    'lotto_id_check' => $lotto_details['lotto_detail_type'],
                    'status_take_out' => 1,
                    'price_over_admin' => $val['price_over'] ?? 0,
                ];
            } else {
                $dataresult[] = [
                    'number' => $val['number'],
                    'lotto_type' => $lotto_details['lotto_detail_type'],
                    'price' =>  $val['price'],
                    'rate_pay' => $val['rate_pay'],
                    'status' => 0,
                    'lotto_detail_id' => $lotto_details->lotto_detail_id,
                    'lotto_id_check' => $lotto_details['lotto_detail_type'],
                    'status_take_out' => 1,
                    'price_over_admin' =>  0,

                ];
            }
        }



        return  $dataresult;
    }

    // Function การกลับเลข
    public function permutation($_a, $buffer = '', $delimiter = '')
    {
        $output = array();

        $num = count($_a);
        if ($num > 1) {
            foreach ($_a as $key => $val) {
                $temp = $_a;
                unset($temp[$key]);
                sort($temp);

                $return = $this->permutation($temp, trim($buffer . $delimiter . $val, $delimiter), $delimiter);

                if (is_array($return)) {
                    $output = array_merge($output, $return);
                    $output = array_unique($output);
                } else {
                    $output[] = $return;
                }
            }
            return $output;
        } else {
            return $buffer . $delimiter . $_a[0];
        }
    }


    public function check_take_out_number(Request $request)
    {

        $lotto_id = $request->lotto_id;


        //Start รวม key array แบ่งเป็นประเภทหวยนั้น ๆ 
        $data = $request->data;




        if ($data != null && $lotto_id  == 1) {
            $res_lotto_oder['old'] = [];
            $res_lotto_oder['over'] = [];
            $res_lotto_oder['admin'] = [];
            $res_cal_lotto['old'] = [];
            $res_cal_lotto['over'] = [];
            // array หมายเลข กับราคาตามหมายเลขลที่ซื้อเข้ามา key เป็นหมายเลขนั้นๆ และมี val เป็นราคาที่ซื้อเข้ามา
            $res_number_lotto = [];



            $data_lotto_sum_price = [];
            foreach ($data as $item) {
                $key = 'type_' . $item['lotto_id_check'] . '_' . $item['number'];
                if (!array_key_exists($key, $data_lotto_sum_price)) {
                    $price = str_replace(',', '', $item['price']);


                    $data_lotto_sum_price[$key] = [
                        "lotto_type" => $item['lotto_type'],
                        "number" => $item['number'],
                        "price" =>  $price,
                        "rate_pay" => $item['rate_pay'],
                        "lotto_detail_id" => $item['lotto_detail_id'],
                        "status" => $item['status'],
                        "lotto_id_check" => $item['lotto_id_check'],
                        "status_take_out" => $item['status_take_out'],
                        "val_discount_rate" => $item['val_discount_rate'],
                    ];
                } else {
                    $data_lotto_sum_price[$key]['price'] = $data_lotto_sum_price[$key]['price'] + $item['price'];
                }
            }




            $lotto_order = [];
            foreach ($data_lotto_sum_price as $res) {

                $res['multiplier_admin'] = 0;
                $res['price_agent'] = 0;
                $res['price_over'] = 0;
                $res['price_admin'] = 0;
                $lotto_order[] = $res;
            }




            $res_limit_number = [];
            foreach ($lotto_order as $key => $item) {
                $LottoRound = LottoRound::where('lotto_id', 1)
                ->orderBy('id', 'desc')
                ->first();
        
                if ($item['status_take_out'] == 0) {
                    // array ราคารวมของหมายเลขที่เคยซื้อไปแล้วใน order 
                    $price_agent = LottoOrderDetail::select('number', 'price', 'lotto_id_check')
                        ->where('group_agent', Auth::user()->group_agent)
                        ->where('number', $item['number'])
                        ->where('lotto_id', $lotto_id)
                        ->where('lotto_id_check', $item['lotto_id_check'])
                        ->where('round_date',$LottoRound->round_date)
                        ->sum('price_agent');

                    // จำนวนเงินที่ตั้งรับ ว่าไม่ให้เกินกี่บาท
                    $limit_take_out = TakeOutNumber::select(
                        'number',
                        'limit_price',
                        'lotto_detail_id',
                    )
                        ->where('group_agent', Auth::user()->group_agent)
                        ->where('lotto_detail_id', $item['lotto_id_check'])
                        ->where('lotto_id', $lotto_id)
                        ->where('number', $item['number'])
                        ->where('round_date',$LottoRound->round_date)
                        ->first();
                     
                    if($limit_take_out){
                        $dataPrepare = [
                            'lotto_detail_id' => $limit_take_out->lotto_detail_id,
                            'number' => $limit_take_out->number,
                            'limit_price' => $limit_take_out->limit_price,
                            'sum_price_order' => $price_agent,
                        ];
                  
                    }else{
                        $TakeOutNumberHead = TakeOutNumberHead::where('group_agent', Auth::user()->group_agent)
                        ->where('lotto_detail_id',$item['lotto_id_check'])->first();

                        $LottoRound = LottoRound::where('lotto_id', 1)
                        ->orderBy('id', 'desc')
                        ->first();

                        
                        // array ราคารวมของหมายเลขที่เคยซื้อไปแล้วใน order 
                        $price_old = LottoOrderDetail::where('number', $item['number'])
                            ->where('lotto_id', $lotto_id)
                            ->Where('group_agent',Auth::user()->group_agent)
                            ->where('lotto_id_check', $item['lotto_id_check'])
                            ->where('round_date',$LottoRound->round_date)
                            ->where('status_take_out',0)
                            ->sum('price_old');

                            $dataPrepare = [
                                'lotto_detail_id' => $item['lotto_id_check'],
                                'number' => $item['number'],
                                'limit_price' => $TakeOutNumberHead->limit_price,
                                'sum_price_order' => $price_old,
                            ];

                            
                    }
                       
                 
                    array_push($res_limit_number, $dataPrepare);
                } else {
                    $dataPrepare =  $item;
                    $dataPrepare['price_over'] =  $item['price'];
                    array_push($res_lotto_oder['over'], $dataPrepare);
                }
            }

            foreach ($res_limit_number as $limit) {
                $limit_price = $limit['limit_price'];
                foreach ($lotto_order as $lotto) {
                    if ($lotto['lotto_detail_id'] == $limit['lotto_detail_id'] && $lotto['number'] == $limit['number']) {
                        $price_limit = $lotto['price'] + $limit['sum_price_order'];
                       
                        if ($price_limit <= $limit_price) {
                            $dataPrepare = $lotto;
                            $dataPrepare['price_agent'] = $lotto['price'];
                            $dataPrepare['cal_discount'] = $lotto['price'] * $lotto['val_discount_rate'] / 100;
                            $dataPrepare['price'] = $lotto['price'];

                            // $check = LimitLock::where('number', $lotto['number'])
                            // ->where('lotto_id_check', $limit['lotto_detail_id'])
                            // ->where('lotto_id', 1)
                            // ->where('group_agent', $group_agent)
                            // ->where('round_date', $LottoRound->round_date)
                            // ->select(
                            //     'status',
                            //     'number',
                            //     'rate_pay',
                            // )
                            // ->first();

                          
                            array_push($res_lotto_oder['old'], $dataPrepare);
                           

                        } else {
                            $price = ($limit['limit_price'] - $limit['sum_price_order']);
                     
                           
                           
                            if ($price != 0) {
                                if($price <= 0){
                                    $price = 0;
                                }
                                
                                if($price <= 0){
                                     $price = 0;
                                    $price_over = $lotto['price'];
                                
                                }else{

                                $price_over = $lotto['price'] - $price;
                            
                                }
                            
                                $dataPrepare = $lotto;
                                $dataPrepare['price'] = $price;
                                $dataPrepare['price_agent'] = $price;
                                $dataPrepare['cal_discount'] = $price * $lotto['val_discount_rate'] / 100;
                              
                                array_push($res_lotto_oder['old'], $dataPrepare);
                               
                                $dataPrepare['price_over'] =  $price_over;

                                array_push($res_lotto_oder['over'], $dataPrepare);
                            }else{
                                if($price <= 0){
                                    $price = 0;
                                }
                                
                                if($price <= 0){
                                     $price = 0;
                                    $price_over = $lotto['price'];
                                
                                }else{

                                $price_over = $lotto['price'] - $price;
                            
                                }
                            
                                $dataPrepare = $lotto;
                                $dataPrepare['price'] = $price;
                                $dataPrepare['price_agent'] = $price;
                                $dataPrepare['cal_discount'] = $price * $lotto['val_discount_rate'] / 100;
                              
                                array_push($res_lotto_oder['old'], $dataPrepare);
                               
                                $dataPrepare['price_over'] =  $price_over;

                                array_push($res_lotto_oder['over'], $dataPrepare);
                            }
                        }
                    }
                }
            }




            $res_cal_lotto['old'] = $res_lotto_oder['old'];
            if (!empty($res_lotto_oder['over'])) {
                $res_lotto_oder_over = $this->check_take_out_number_admin($res_lotto_oder['over'], $lotto_id);
                
                if (!empty($res_lotto_oder_over['old'])) {
               
                    foreach ($res_lotto_oder_over['old'] as $data) {
                        $res_cal_lotto['old'][] = $data;
                    }
                }else{
                    $res_cal_lotto['over'] = $res_lotto_oder_over['over'];
                }
                
            }


         
            return $res_cal_lotto;

        } else {
            return response()->json(['status' => 'error']);
        }




        // End หาประเภทหวยที่ ตรงกันมาเช็ค จำนวนเงินว่าเกินหรือไม่
    }


    public function check_take_out_number_admin($data, $lotto_id)
    {

        $LottoRound = LottoRound::where('lotto_id', 1)
        ->orderBy('id', 'desc')
        ->first();

        $res_lotto_oder['old'] = [];
        $res_lotto_oder['over'] = [];


        $arr_res = [];
      
        foreach ($data as $val) {
            $dataPrepare = $val;
            $check = LimitLock::where('number', $val['number'])
                ->where('lotto_id_check', $val['lotto_id_check'])
                ->where('lotto_id', $lotto_id)
                ->where('group_agent', 0)
                ->where('round_date',$LottoRound->round_date)
                ->select(
                    'status',
                    'number',
                    'rate_pay',
                )
                ->first();

            if ($check != null) {

                if ($check['status'] == 1) {
                    $dataPrepare['multiplier_admin'] =  $check['rate_pay'];
                    $dataPrepare['status'] =  $check['status'];
                    $dataPrepare['rate_pay'] =   $check['rate_pay'];
                    $arr_res[] = $dataPrepare;
                  
                }
                if ($check['status'] == 2) {
                    $dataPrepare['price'] = $val['price_agent'];
                    $dataPrepare['multiplier_admin'] = $val['rate_pay'];
                    $dataPrepare['status'] = 2;
                    $dataPrepare['status_take_out'] = 1;
                    $res_lotto_oder['over'][] =  $dataPrepare;
                   
                }
                

            } else {
             
                $arr_res[] = $val;
               
            }
        }







        $res_limit_number = [];
        foreach ($arr_res as $key => $item) {
            $LottoRound = LottoRound::where('lotto_id', 1)
            ->orderBy('id', 'desc')
            ->first();

            
            // array ราคารวมของหมายเลขที่เคยซื้อไปแล้วใน order 
            $price_old = LottoOrderDetail::where('number', $item['number'])
                ->where('lotto_id', $lotto_id)
                ->Where('group_agent',Auth::user()->group_agent)
                ->where('lotto_id_check', $item['lotto_id_check'])
                ->where('round_date',$LottoRound->round_date)
                ->where('status_take_out',1)
                ->sum('price_old');




            $price_over = LottoOrderDetail::where('number', $item['number'])
                ->where('lotto_id', $lotto_id)
                ->where('lotto_id_check', $item['lotto_id_check'])
                ->where('round_date',$LottoRound->round_date)
                ->sum('price_over');
            // จำนวนเงินที่ตั้งรับ ว่าไม่ให้เกินกี่บาท
            $limit_take_out = TakeOutNumber::select(
                'number',
                'limit_price',
                'lotto_detail_id',
            )
                ->where('group_agent', 0)
                ->where('lotto_detail_id', $item['lotto_id_check'])
                ->where('lotto_id', $lotto_id)
                ->where('number', $item['number'])
                ->where('round_date',$LottoRound->round_date)
                ->first();
                if($limit_take_out){
                    $dataPrepare = [
                        'lotto_detail_id' => $limit_take_out->lotto_detail_id,
                        'number' => $limit_take_out->number,
                        'limit_price' => $limit_take_out->limit_price,
                        'sum_price_order' => $price_old,
                    ];
                    
                }else{


                    $TakeOutNumberHead = TakeOutNumberHead::where('group_agent',0)
                    ->where('lotto_detail_id',$item['lotto_id_check'])->first();

                    $LottoRound = LottoRound::where('lotto_id', 1)
                    ->orderBy('id', 'desc')
                    ->first();

                    
                    // array ราคารวมของหมายเลขที่เคยซื้อไปแล้วใน order 
                    $price_old = LottoOrderDetail::where('number', $item['number'])
                        ->where('lotto_id', $lotto_id)
                        ->where('lotto_id_check', $item['lotto_id_check'])
                        ->where('round_date',$LottoRound->round_date)
                        ->where('status_take_out',1)
                        ->sum('price_old');

                    
                        $dataPrepare = [
                            'lotto_detail_id' => $item['lotto_id_check'],
                            'number' => $item['number'],
                            'limit_price' => $TakeOutNumberHead->limit_price,
                            'sum_price_order' => $price_old,
                        ]; 
                       

                }
                   
               

            array_push($res_limit_number, $dataPrepare);
        }





      

        foreach ($res_limit_number as $limit) {
           
            $group_agent = Auth::user()->group_agent;
                  $Useropen = User::where('group_agent',$group_agent)
                  ->where('role',2)
                  ->orderBy('id','desc')
                  ->first();
            if($Useropen->role == 1){
                $limit_price = 0 - $limit['sum_price_order'];
                $price_limit_over = 0 - $limit['sum_price_order'];
            }else{
                $limit_price = $limit['limit_price'] - $limit['sum_price_order'];
                $price_limit_over = $limit['limit_price'] - $limit['sum_price_order'];
              
            }
                foreach ($arr_res as $lotto) {
                  
                    $dataPrepare = $lotto;
                
                    if ($lotto['lotto_detail_id'] == $limit['lotto_detail_id'] && $lotto['number'] == $limit['number']) {
                       
                        $price_limit = $limit['limit_price'] - $limit['sum_price_order'];
                     
                        $price_over = $lotto['price_over'];
                        // dd($price_over);
                        $cal_price = $price_limit - $price_over;

                        $data_test = [
                            'price_limit' => $price_limit,
                            'price_over' => $price_over,
                            'cal_price' =>  $cal_price,
                        ];
                       
                        if ($price_over <= $price_limit) {
                      
                            $dataPrepare['price'] = $price_over;
                            $dataPrepare['price_admin'] = $price_over;
                            $dataPrepare['status_take_out'] = 1;
                            $dataPrepare['cal_discount'] = $price_over * $lotto['val_discount_rate'] / 100;
                            array_push($res_lotto_oder['old'], $dataPrepare);
                            
                        
                        } else {
                           
                            $dataPrepare['price_admin'] = $price_limit;
                            $dataPrepare['price'] = $price_limit;
                            $dataPrepare['status_take_out'] = 1;
                            $dataPrepare['cal_discount'] = $price_limit * $lotto['val_discount_rate'] / 100;
                      
                            array_push($res_lotto_oder['old'], $dataPrepare);

                            $dataPrepare['price'] = $dataPrepare['price_agent'] + $dataPrepare['price_admin'];
                            array_push($res_lotto_oder['over'], $dataPrepare);
                        }
                    }
                }
            
        }



        if (!empty($res_lotto_oder['old'])) {
          
            return  $this->check_rate_pay_compare($res_lotto_oder);
        } else {
            
            return $res_lotto_oder;
        }
    }


    public function check_rate_pay_compare($data)
    {


        $res = [];
        $data_old = $data['old'];

        $lotto_detail = LottoDetail::where('group_agent', 0)->where('lotto_id', 1)->get();


        foreach ($data_old as $old) {

            foreach ($lotto_detail as $rate) {
                if ($old['lotto_id_check'] == $rate['lotto_detail_id']) {

                    $old['multiplier_admin'] = $rate['multiplier'];
                    $res['old'][] = $old;
                }
            }
        }

        $res['over'] = $data['over'];
        return $res;
    }






    public function price_out_limit($data)
    {


        foreach ($data as $val) {
            $sTable[] = TakeOutNumber::select(
                'take_out_numbers.id',
                'take_out_numbers.lotto_detail_id',
                'lotto_detail_type',
                'limit_price',
                'take_out_numbers.updated_at'
            )

                ->where('take_out_numbers.group_agent', 0)
                ->where('take_out_numbers.lotto_detail_id', $val)
                ->join('lotto_details', 'lotto_details.lotto_detail_id', 'take_out_numbers.lotto_detail_id')
                ->get()

                ->map(function ($item) {
                    $item->sum_total = LottoOrderDetail::orWhere('group_agent', 0)
                        ->orWhere('status_take_out', 1)
                        ->where('lotto_id_check', $item->lotto_detail_id)
                        ->where('status', 99)
                        ->sum('price');
                    return $item;
                });
        }
        $res = [];


        foreach ($sTable as $data) {
            foreach ($data as $val) {

                $res[] = [
                    'lotto_detail_type' => $val['lotto_detail_type'],
                    'price_out' => $val['limit_price'] - $val['sum_total']
                ];
            }
        }

        return  $res;
    }





    public function cal_comission($data, $round_date, $lotto_id)
    {

        $group_agent = Auth::user()->group_agent;
        $user_id = Auth::user()->id;


        $res_user_agent  = User::where('group_agent', $group_agent)->where('role', 2)->first();



        if ($user_id != $res_user_agent->id) {
            $res_discount = AgentDiscount::where('user_id', $res_user_agent->id)->get();

            foreach ($data as $val) {
                foreach ($res_discount  as $discount) {
                    if ($val['lotto_id_check'] == $discount->lotto_detail_id) {

                        $price = $val['price'];
                        $rate_count = $discount->rate -  $val['rate'];
                        $cal_discount = $price * $rate_count / 100;

                        $dataPrepare = [
                            'user_id' => $res_user_agent->id,
                            'lotto_id' => $lotto_id,
                            'lotto_round' => $round_date,
                            'amt' => $cal_discount,
                            'group_agent' => $res_user_agent->group_agent
                        ];


                        $query = Comission::create($dataPrepare);
                    }
                }
            }
        }
    }


    public function myDate()
    {
        // check Date
        date_default_timezone_set('Asia/Bangkok');
        $dateNow = date("Y-m-d");
        $dateNowCal = strtotime(date("Y-m-d"));
        $dayNow = date("d", $dateNowCal);
        $myDate = '';

        if ($dayNow > 1) {
            $calDay =  16 - $dayNow;
            return $myDate  = date("Y-m-d", strtotime("+" . $calDay . " day " . $dateNow));
        }
        if ($dayNow > 16) {
            return  $myDate  = date("Y-m-d", strtotime("first day of +1 month " . $dateNow));
        }
    }
}
