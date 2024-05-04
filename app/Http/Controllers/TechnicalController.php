<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Technical;
use App\TechnicalFile;
use App\TechnicalGallery;
use App\TechnicalCategory;
use App\SubCategory;
use App\Brand;
use App\Color;
use App\Size;
use Auth;
DB::beginTransaction();

class TechnicalController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'technical';
        $data['asset'] = asset('/');
        $data['page'] = 'Technical';
        $data['page_url'] = 'technical';

        $results = Technical::selectRaw('technicals.*,technical_categorys.technical_category_name');
            if(@$request->technical_name){
                $results = $results->Where('technical_name','LIKE','%'.$request->technical_name.'%');
            }
        $results = $results->leftJoin('technical_categorys','technical_categorys.id','=','technicals.ref_category_id')
                ->orderBy('id','DESC')
                ->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/technicals/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Technical';
        $data['page'] = 'Technical Add';
        $data['page_url'] = 'technical Add';
        $data['action'] = "insert";
        $data['technical_category'] = TechnicalCategory::orderBy('id','DESC')->get();
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_name')->orderBy('product_code','DESC')->get();
        return view('admin/technicals/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Technical';
        $data['page'] = 'Technical Edit';
        $data['page_url'] = 'technical';
        $data['action'] = "../update/$id";
        $data['technical_category'] = TechnicalCategory::orderBy('id','DESC')->get();
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_name')->orderBy('product_code','DESC')->get();
        $data['technical'] = Technical::find($id);

        $recommend_product = array();
        $recommend = DB::table('recommend_product')->where('recommend_ref_article',$id)->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }
        $data['recommend_product'] = $recommend_product;

        return view('admin/technicals/add', $data);
    }
    public function insert(Request $request)
    {
        if($request->file('technical_image')){
            $file = $request->file('technical_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/technical/";
            $technical_image_name = $request->technical_image_name.'.'.$extension;
        }

        try{
            $technical = new Technical;
            $technical->technical_name = $request->technical_name;
            $technical->technical_detail = $request->technical_detail;
            $technical->technical_image = @$technical_image_name;
            $technical->meta_title = $request->meta_title;
            $technical->meta_keywords = $request->meta_keywords;
            $technical->meta_description = $request->meta_description;
            $technical->ref_category_id = $request->category_id;
            $technical->save();

            $lasted = DB::table('technicals')->orderBy('id','DESC')->first();
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
            if(@$file) $file->move($path, $technical_image_name);
            return redirect('admin/technical')->with('message', 'Insert technical "'.$request->technical_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;
        $technical = Technical::find($id);
        $lastImage = $technical->technical_image;

        $path = "upload/technical/";

        if(!is_null($request->file('technical_image'))){
            $file = $request->file('technical_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);

            $technical_image_name = $request->technical_image_name.'.'.$extension;

        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->technical_image_name){
                $technical_image_name = str_replace(' ','_',$request->technical_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }
        try{
            $technical->technical_name = $request->technical_name;
            $technical->technical_detail = $request->technical_detail;
            $technical->meta_title = $request->meta_title;
            $technical->meta_keywords = $request->meta_keywords;
            $technical->meta_description = $request->meta_description;
            $technical->ref_category_id = $request->category_id;
            if(isset($technical_image_name)){
                $technical->technical_image = $technical_image_name;
            }
            $technical->save();

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

            if(!is_null($request->file('technical_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $technical_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->technical_image_name){
                    @rename($path.$lastImage, $path.$technical_image_name);
                }
            }

            DB::commit();
            return redirect("admin/technical/edit/$id")->with('message', 'Update technical "'.$request->technical_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Technical::destroy($id);
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
