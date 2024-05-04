<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Install;
use App\InstallFile;
use App\InstallGallery;
use App\InstallCategory;
use App\SubCategory;
use App\Brand;
use App\Color;
use App\Size;
use Auth;
use Illuminate\Database\QueryException;

DB::beginTransaction();

class InstallController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'install';
        $data['asset'] = asset('/');
        $data['page'] = 'Install';
        $data['page_url'] = 'install';

        $results = Install::selectRaw('installs.*,install_categorys.install_category_name');
            if(@$request->install_name){
                $results = $results->Where('install_name','LIKE','%'.$request->install_name.'%');
            }
        $results = $results->leftJoin('install_categorys','install_categorys.id','=','installs.ref_category_id')
                ->orderBy('id','DESC')
                ->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/installs/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Install';
        $data['page'] = 'Install Add';
        $data['page_url'] = 'install Add';
        $data['action'] = "insert";
        $data['install_category'] = InstallCategory::orderBy('id','DESC')->get();
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_name')->orderBy('product_code','DESC')->get();
        return view('admin/installs/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Install';
        $data['page'] = 'Install Edit';
        $data['page_url'] = 'install';
        $data['action'] = "../update/$id";
        $data['install_category'] = InstallCategory::orderBy('id','DESC')->get();
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_name')->orderBy('product_code','DESC')->get();
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->where('recommend_ref_article',$id)->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }
        $data['recommend_product'] = $recommend_product;
        $data['install'] = Install::find($id);

        return view('admin/installs/add', $data);
    }
    public function insert(Request $request)
    {
        if($request->file('install_image')){
            $file = $request->file('install_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/install/";
            $install_image_name = $request->install_image_name.'.'.$extension;
            
        }

        try{
            $install = new Install;
            $install->install_name = $request->install_name;
            $install->install_detail = $request->install_detail;
            $install->install_image = @$install_image_name;
            $install->meta_title = $request->meta_title;
            $install->meta_keywords = $request->meta_keywords;
            $install->meta_description = $request->meta_description;
            $install->ref_category_id = $request->category_id;
            $install->save();

            $lasted = DB::table('installs')->orderBy('id','DESC')->first();
            if(!empty($request->recommend_ref_product)){
                foreach ($request->recommend_ref_product as $key => $_recommend_ref_product) {
                    $data['recommend_ref_article'] = $lasted->id;
                    $data['recommend_ref_product'] = $_recommend_ref_product;
                    $data['recommend_sort'] = $key;
                    $data['recommend_createby'] = Auth::user()->name;
                    $data['recommend_created'] = date('Y-m-d H:i:s');
                    DB::table('recommend_product')->insert($data);
                }
            }

            DB::commit();
            if(@$file) $file->move($path, $install_image_name);
            return redirect('admin/install')->with('message', 'Insert install "'.$request->install_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;
        $install = Install::find($id);
        $lastImage = $install->install_image;

        $path = "upload/install/";

        if(!is_null($request->file('install_image'))){
            $file = $request->file('install_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $install_image_name = $request->install_image_name.'.'.$extension;

        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->install_image_name){
                $install_image_name = str_replace(' ','_',$request->install_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }
        try{
            $install->install_name = $request->install_name;
            $install->install_detail = $request->install_detail;
            $install->meta_title = $request->meta_title;
            $install->meta_keywords = $request->meta_keywords;
            $install->meta_description = $request->meta_description;
            $install->ref_category_id = $request->category_id;
            if(isset($install_image_name)){
                $install->install_image = $install_image_name;
            }
            $install->save();

            DB::table('recommend_product')->where('recommend_ref_article',$id)->delete();
            if(!empty($request->recommend_ref_product)){
                foreach ($request->recommend_ref_product as $key => $_recommend_ref_product) {
                    $data['recommend_ref_article'] = $id;
                    $data['recommend_ref_product'] = $_recommend_ref_product;
                    $data['recommend_sort'] = $key;
                    $data['recommend_createby'] = Auth::user()->name;
                    $data['recommend_created'] = date('Y-m-d H:i:s');
                    DB::table('recommend_product')->insert($data);
                }
            }

            if(!is_null($request->file('install_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $install_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->install_image_name){
                    @rename($path.$lastImage, $path.$install_image_name);
                }
            }

            DB::commit();
            return redirect("admin/install/edit/$id")->with('message', 'Update install "'.$request->install_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Install::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
