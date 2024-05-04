<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Maintenance;
use App\MaintenanceFile;
use App\MaintenanceGallery;
use App\MaintenanceCategory;
use App\SubCategory;
use App\Brand;
use App\Color;
use App\Size;
DB::beginTransaction();

class MaintenanceController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'maintenance';
        $data['asset'] = asset('/');
        $data['page'] = 'Maintenance';
        $data['page_url'] = 'maintenance';

        $results = Maintenance::selectRaw('maintenances.*,maintenance_categorys.maintenance_category_name');
            if(@$request->maintenance_name){
                $results = $results->Where('maintenance_name','LIKE','%'.$request->maintenance_name.'%');
            }
        $results = $results->leftJoin('maintenance_categorys','maintenance_categorys.id','=','maintenances.ref_category_id')
                ->orderBy('id','DESC')
                ->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/maintenances/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Maintenance';
        $data['page'] = 'Maintenance Add';
        $data['page_url'] = 'maintenance Add';
        $data['action'] = "insert";
        $data['maintenance_category'] = MaintenanceCategory::orderBy('id','DESC')->get();
        return view('admin/maintenances/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Maintenance';
        $data['page'] = 'Maintenance Edit';
        $data['page_url'] = 'maintenance';
        $data['action'] = "../update/$id";
        $data['maintenance_category'] = MaintenanceCategory::orderBy('id','DESC')->get();
        $data['maintenance'] = Maintenance::find($id);

        return view('admin/maintenances/add', $data);
    }
    public function insert(Request $request)
    {
        if($request->file('maintenance_image')){
            $file = $request->file('maintenance_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/maintenance/";
            $maintenance_image_name = $request->maintenance_image_name.'.'.$extension;
            
        }

        try{
            $maintenance = new Maintenance;
            $maintenance->maintenance_name = $request->maintenance_name;
            $maintenance->maintenance_detail = $request->maintenance_detail;
            $maintenance->maintenance_image = @$maintenance_image_name;
            $maintenance->meta_title = $request->meta_title;
            $maintenance->meta_keywords = $request->meta_keywords;
            $maintenance->meta_description = $request->meta_description;
            $maintenance->ref_category_id = $request->category_id;
            $maintenance->save();

            DB::commit();
            if(@$file) $file->move($path, $maintenance_image_name);
            return redirect('admin/maintenance')->with('message', 'Insert maintenance "'.$request->maintenance_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;
        $maintenance = Maintenance::find($id);
        $lastImage = $maintenance->maintenance_image;

        $path = "upload/maintenance/";

        if(!is_null($request->file('maintenance_image'))){
            $file = $request->file('maintenance_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $maintenance_image_name = $request->maintenance_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->maintenance_image_name){
                $maintenance_image_name = str_replace(' ','_',$request->maintenance_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }
        try{
            $maintenance->maintenance_name = $request->maintenance_name;
            $maintenance->maintenance_detail = $request->maintenance_detail;
            $maintenance->meta_title = $request->meta_title;
            $maintenance->meta_keywords = $request->meta_keywords;
            $maintenance->meta_description = $request->meta_description;
            $maintenance->ref_category_id = $request->category_id;
            if(isset($maintenance_image_name)){
                $maintenance->maintenance_image = $maintenance_image_name;
            }
            $maintenance->save();

            if(!is_null($request->file('maintenance_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $maintenance_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->maintenance_image_name){
                    @rename($path.$lastImage, $path.$maintenance_image_name);
                }
            }

            DB::commit();
            return redirect("admin/maintenance/edit/$id")->with('message', 'Update maintenance "'.$request->maintenance_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Maintenance::destroy($id);
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
