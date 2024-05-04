<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class ShippingFeeController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(6);
        return view('shipping_fee', $data);
    }
}
