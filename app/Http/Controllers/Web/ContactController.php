<?php

namespace App\Http\Controllers\Web;

use App\AboutMap;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Career;

use DateTime;
use Session;
use Response;
use Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();
// DB::beginTransaction();

class ContactController extends Controller
{
    public function index(){
        $contact = Contact::first();
        $data['contactName'] = 'contactinfo';
        $data['contact'] = $contact;
        return view('contact', $data);
    }
    public function career(){
        $career = Career::orderBy('id','DESC')->get();
        foreach($career as $car){
            $car->workplace = explode('|i|',$car->workplace);
            $car->description = explode('|i|',$car->description);
        }

        $data['contactName'] = 'career';
        $data['career'] = $career;
        return view('career', $data);
    }
    public function map(){
        $map = AboutMap::orderBy('id','DESC')->where('id','!=',1)->get();
        $detail = AboutMap::first();

        $data['map'] = $map;
        $data['detail'] = $detail;
        return view('map', $data);
    }
    // public function send(Request $request)
    // {
    //     $data1 = array(
    //         'contact_email_name'      => $request->input('name'),
    //         'contact_email_email'     => $request->input('email'),
    //         'contact_email_phone'     => $request->input('phone'),
    //         'contact_email_head_text' => $request->input('head_text'),
    //         'contact_email_details'   => $request->input('details'),
    //         'contact_email_created_at'		                => new DateTime(),
    //         'contact_email_updated_at'		                => new DateTime(),
    //        );
           
      
    //        DB::table('contact_emai')->insert($data1); 
          
          
    //         $details = [
    //             'name'      => $request->input('name'),
    //             'email'     => $request->input('email'),
    //             'phone'     => $request->input('phone'),
    //             'head_text' => $request->input('head_text'),
    //             'details'   => $request->input('details'),
    //         ];



    //         \Mail::to('chontichayou@gmail.com')->send(new \App\Mail\MyTestMail($details));
          
       
    //         return redirect('contact')->with('message', 'Insert contact "'.$request->title.'" success');
        
          
            
      
    // }
    public function send(Request $request)
    {
           

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
                $data3 = [
               
                    'contact_email_name'                            => $request->input('name'),
                    'contact_email_email'                           => $request->input('email'),
                    'contact_email_phone'                           => $request->input('phone'),
                    'contact_email_head_text'                       => $request->input('head_text'),
                    'contact_email_details'                         => $request->input('details'),
                    'contact_email_created_at'		                => new DateTime(),
                    'contact_email_updated_at'		                => new DateTime(),
                ];
                DB::table('contact_emai')->insert($data3);
                DB::commit();
                         $details = [
                                'name'      => $request->input('name'),
                                'email'     => $request->input('email'),
                                'phone'     => $request->input('phone'),
                                'head_text' => $request->input('head_text'),
                                'details'   => $request->input('details'),
                        ];
    
                \Mail::to('info@bjbrothers.com')->send(new \App\Mail\MyTestMail($details));
    
                return redirect('contact')->with('message', 'Insert contact "'.$request->title.'" success');
            }else{
                return back()->with('message', 'กรุณาเลือกฉันไม่ใช่โปรแกรมอัตโนมัติ error');

            }
          
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
