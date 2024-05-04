<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Promotion;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class PromotionController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(7);
        $data['promotion_pin'] = Promotion::where('pin',1)->first();
        $promotion = Promotion::orderBy('id','DESC');
        $data['promotion'] = $promotion->paginate(6);
        return view('promotion', $data);
    }
    public function detail($id){
        $data['promotion'] = Promotion::find($id);
        $data['meta'] = (object)['meta_title' => $data['promotion']->meta_title , 'meta_keywords' => $data['promotion']->meta_keywords , 'meta_description' => $data['promotion']->meta_description];
        return view('promotion_detail', $data);
    }
}
