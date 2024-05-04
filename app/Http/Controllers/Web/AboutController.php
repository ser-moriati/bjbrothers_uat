<?php

namespace App\Http\Controllers\Web;

use App\About;
use App\Http\Controllers\Controller;
use App\AboutCompany;
use App\AboutCustomer;
use App\AboutCategoryCustomer;
use App\AboutCertificate;
use App\AboutHoliday;
use App\AboutService;
use App\Seo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class AboutController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(6);
        $about = AboutCompany::orderBy('about_company_year','ASC')->get();
        $data['detail'] = About::first();
        $data['aboutName'] = 'about';
        $data['about'] = $about;
        return view('about', $data);
    }
    public function customer(){
        $category = AboutCategoryCustomer::orderBy('id','DESC')->get();
        $about = AboutCustomer::orderBy('id','DESC')->get();
        $result = array();
        foreach ($about as $ab) {
            $result[$ab['ref_category_id']][] = $ab;
        }
        $data['aboutName'] = 'client';
        $data['about_category_customer'] = $category;
        $data['about_customer'] = $result;
        return view('client', $data);
    }
    public function service(){
        // $category = AboutCategoryCustomer::orderBy('id','DESC')->get();
        $service = AboutService::first();
        $data['service'] = $service;
        return view('service', $data);
    }
    public function certificate(){

        if(@Auth::guard('member')->user()){
            $data['member_role'] = Auth::guard('member')->user()->ref_role_id;
        }

        $about = AboutCertificate::orderBy('id','DESC')->get();
        $data['aboutName'] = 'certificate';
        $data['certificate'] = $about;
        return view('certificate', $data);
    }
    public function holiday(){
        $about = AboutHoliday::first();
        $data['table_date'] = explode('?|?',$about->about_holiday_date);
        $data['table_holiday'] = explode('?|?',$about->about_holiday_name);
        $data['aboutName'] = 'vacation';
        $data['holiday'] = $about;
        return view('vacation', $data);
    }
    // public function service(){
    //     return view('service');
    // }
}
