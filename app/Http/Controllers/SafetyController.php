<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Safety;
use App\SafetyFile;
use App\SafetyGallery;
use App\SafetyCategory;
use App\SubCategory;
use App\Brand;
use App\Color;
use App\Size;
use Auth;
DB::beginTransaction();

class SafetyController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'safety';
        $data['asset'] = asset('/');
        $data['page'] = 'Safety';
        $data['page_url'] = 'safety';

        $results = Safety::selectRaw('safetys.*,safety_categorys.safety_category_name');
            if(@$request->safety_name){
                $results = $results->Where('safety_name','LIKE','%'.$request->safety_name.'%');
            }
        $results = $results->leftJoin('safety_categorys','safety_categorys.id','=','safetys.ref_category_id')
                ->orderBy('id','DESC')
                ->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/safetys/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Safety';
        $data['page'] = 'Safety Add';
        $data['page_url'] = 'safety Add';
        $data['action'] = "insert";
        $data['safety_category'] = SafetyCategory::orderBy('id','DESC')->get();
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_name')->orderBy('product_code','DESC')->get();
        return view('admin/safetys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Safety';
        $data['page'] = 'Safety Edit';
        $data['page_url'] = 'safety';
        $data['action'] = "../update/$id";
        $data['safety_category'] = SafetyCategory::orderBy('id','DESC')->get();
        $data['safety'] = Safety::find($id);
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_code')->orderBy('product_code','DESC')->get();
        
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->where('recommend_ref_article',$id)->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }
        $data['recommend_product'] = $recommend_product;

        return view('admin/safetys/add', $data);
    }
    public function insert(Request $request)
    {
        if($request->file('safety_image')){
            $file = $request->file('safety_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/safety/";
                $safety_image_name = $request->safety_image_name.'.'.$extension;
        }

        try{
            $safety = new Safety;
            $safety->safety_name = $request->safety_name;
            $safety->safety_detail = $request->safety_detail;
            $safety->safety_image = @$safety_image_name;
            $safety->meta_title = $request->meta_title;
            $safety->meta_keywords = $request->meta_keywords;
            $safety->meta_description = $request->meta_description;
            $safety->ref_category_id = $request->category_id;
            $safety->save();

            $lasted = DB::table('safetys')->orderBy('id','DESC')->first();
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

            if(@$file) $file->move($path, $safety_image_name);
            DB::commit();
            return redirect('admin/safety')->with('message', 'Insert safety "'.$request->safety_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;
        $safety = Safety::find($id);
        $lastImage = $safety->safety_image;
        $path = "upload/safety/";

        if(!is_null($request->file('safety_image'))){
            $file = $request->file('safety_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);

            $safety_image_name = $request->safety_image_name.'.'.$extension;

        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->safety_image_name){
                $safety_image_name = str_replace(' ','_',$request->safety_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }
        try{
            $safety->safety_name = $request->safety_name;
            $safety->safety_detail = $request->safety_detail;
            $safety->meta_title = $request->meta_title;
            $safety->meta_keywords = $request->meta_keywords;
            $safety->meta_description = $request->meta_description;
            $safety->ref_category_id = $request->category_id;
            if(isset($safety_image_name)){
                $safety->safety_image = $safety_image_name;
            }
            $safety->save();

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

            if(!is_null($request->file('safety_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $safety_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->safety_image_name){
                    @rename($path.$lastImage, $path.$safety_image_name);
                }
            }


            DB::commit();
            return redirect("admin/safety/edit/$id")->with('message', 'Update safety "'.$request->safety_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            // $galleryGet = SafetyGallery::whereIn('ref_safety_id',$id)->get();
            // SafetyGallery::whereIn('ref_safety_id',$id)->delete();
            Safety::destroy($id);
            
            // foreach($galleryGet as $unlink){
            //     @unlink('upload/safety/gallerys/'.$unlink->image_name);
            // }
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function checkPin($id){
        $promotion = DB::table('safetys')->get();
        foreach ($promotion as $_promotion) {
            $update_all['pin'] = 0;
            DB::table('safetys')->where('id',$_promotion->id)->update($update_all);
        }
        $update['pin'] = 1;
        DB::table('safetys')->where('id',$id)->update($update);
        DB::commit();
    }

    public function removePin($id){
        $update['pin'] = 0;
        DB::table('safetys')->where('id',$id)->update($update);
        DB::commit();
    }
}
