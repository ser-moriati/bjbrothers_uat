<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Promotion;
use Auth;
DB::beginTransaction();

class PromotionController extends Controller
{
    //
    public function module() {
        return 'promotion';
    } 

    public function index(Request $request){
        $data['module'] = $this->module();
        $data['asset'] = asset('/');
        $data['page'] = 'Promotion';
        $data['page_url'] = $this->module();

        $results = Promotion::orderBy('id','DESC');
            if(@$request->title){
                $results = $results->Where('title','LIKE','%'.$request->title.'%');
            }
            if(@$request->detail){
                $results = $results->Where('detail','LIKE','%'.$request->detail.'%');
            }
        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/promotions/index', $data);

    }
    public function add(){

        $asset = asset('/');
        $data['page_before'] = 'Promotion';
        $data['page'] = 'Promotion Add';
        $data['page_url'] = $this->module();
        $data['action'] = "insert";
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_name')->orderBy('product_code','DESC')->get();
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }
        $data['recommend_product'] = $recommend_product;
        return view('admin/promotions/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Promotion';
        $data['page'] = 'Promotion Edit';
        $data['page_url'] = $this->module();
        $data['action'] = "../update/$id";

        $data['promotion'] = Promotion::find($id);

        $data['promotion']->workplace = explode('|i|',$data['promotion']->workplace);
        $data['promotion']->description = explode('|i|',$data['promotion']->description);
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_code')->orderBy('product_code','DESC')->get();
        
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->where('recommend_ref_article',$id)->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }
        $data['recommend_product'] = $recommend_product;
        
        return view('admin/promotions/add', $data);
    }
    public function insert(Request $request)
    {
        // return $request;
        $path = "upload/promotion/";

        if($request->file('title_image')){
            $file = $request->file('title_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $title_image_name = $request->title_image_name.'.'.$extension;

        }

        try{
            $promotion = new Promotion;
            $promotion->title = $request->title;
            $promotion->detail = $request->detail;
            $promotion->title_image = $title_image_name;
            $promotion->meta_title = $request->meta_title;
            $promotion->meta_keywords = $request->meta_keywords;
            $promotion->meta_description = $request->meta_description;
            $promotion->save();
            $lasted = DB::table('promotions')->orderBy('id','DESC')->first();
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
            if(@$file) $file->move($path, $title_image_name);
            return redirect('admin/promotion')->with('message', 'Insert promotion "'.$request->title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        $path = "upload/promotion/";
        // return 555;
            $promotion = Promotion::find($id);
            $lastTitleName = $promotion->title_image;

        if(!is_null($request->file('title_image'))){
            $file = $request->file('title_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $title_image_name = $request->title_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastTitleName, PATHINFO_FILENAME)!=$request->title_image_name){
                $title_image_name = str_replace(' ','_',$request->title_image_name).'.'.pathinfo($lastTitleName, PATHINFO_EXTENSION);
            }
        }
        
        try{
            $promotion->title = $request->title;
            $promotion->detail = $request->detail;
            if(isset($title_image_name)){
                $promotion->title_image = $title_image_name;
            }
            $promotion->meta_title = $request->meta_title;
            $promotion->meta_keywords = $request->meta_keywords;
            $promotion->meta_description = $request->meta_description;
            $promotion->save();

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

            DB::commit();
            
            if(!is_null($request->file('title_image'))){
                @unlink("$path/$lastTitleName");
                $file->move($path, $title_image_name);
            }else{
                if(pathinfo($lastTitleName, PATHINFO_FILENAME)!=$request->title_image_name){
                    @rename($path.$lastTitleName, $path.$title_image_name);
                }
            }
            return redirect("admin/promotion/edit/$id")->with('message', 'Update promotion "'.$request->title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Promotion::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function checkPin($id){
        $promotion = DB::table('promotions')->get();
        foreach ($promotion as $_promotion) {
            $update_all['pin'] = 0;
            DB::table('promotions')->where('id',$_promotion->id)->update($update_all);
        }
        $update['pin'] = 1;
        DB::table('promotions')->where('id',$id)->update($update);
        DB::commit();
    }

    public function removePin($id){
        $update['pin'] = 0;
        DB::table('promotions')->where('id',$id)->update($update);
        DB::commit();
    }
}
