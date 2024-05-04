<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\AboutCompany;
use App\AboutCustomer;
use App\AboutCategoryCustomer;
use App\AboutCertificate;
use App\AboutHoliday;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class CustomerController extends Controller
{
    public function index(){
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
}
