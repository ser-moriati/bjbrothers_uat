<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Maintenance;
use App\MaintenanceCategory;
use App\MaintenanceGallery;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class MaintenanceController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(5);

        $data['category'] = MaintenanceCategory::orderBy('id','DESC')->paginate(16);

        return view('maintenance', $data);
    }
    public function cate($cate_id = null){
        $data['meta'] = Seo::find(5);
        $maintenance = Maintenance::orderBy('id','DESC')->where('ref_category_id',$cate_id);

        $data['cate'] = MaintenanceCategory::find($cate_id);

        $data['maintenance'] = $maintenance->paginate(16);
        // $data['category'] = MaintenanceCategory::orderBy('id','DESC')->get();
        $data['cate_id'] = $cate_id;
        return view('maintenance_sub_category', $data);
    }
    public function detail($cate_id, $id){
        $data['cate'] = MaintenanceCategory::find($cate_id);
        $data['maintenance'] = Maintenance::find($id);
        $data['meta'] = (object)['meta_title' => $data['maintenance']->meta_title , 'meta_keywords' => $data['maintenance']->meta_keywords , 'meta_description' => $data['maintenance']->meta_description];
        // $data['gallery'] = MaintenanceGallery::where('ref_maintenance_id',$id)->get();
        return view('maintenance_detail', $data);
    }
}
