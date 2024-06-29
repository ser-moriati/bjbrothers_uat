<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\News;
use Auth;
DB::beginTransaction();

class NewsController extends Controller
{
    //
    public function module() {
        return 'news';
    } 

    public function index(Request $request){
        $data['module'] = $this->module();
        $data['asset'] = asset('/');
        $data['page'] = 'News';
        $data['page_url'] = $this->module();

        $results = News::orderBy('id','DESC');
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
        return view('admin/news/index', $data);

    }
    public function add(){

        $asset = asset('/');
        $data['page_before'] = 'News';
        $data['page'] = 'News Add';
        $data['page_url'] = $this->module();
        $data['action'] = "insert";
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_name')->orderBy('product_code','DESC')->get();
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->get();
        $data['recommend_product'] = $recommend_product;

        return view('admin/news/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'News';
        $data['page'] = 'News Edit';
        $data['page_url'] = $this->module();
        $data['action'] = "../update/$id";

        $data['news'] = News::find($id);

        $data['news']->workplace = explode('|i|',$data['news']->workplace);
        $data['news']->description = explode('|i|',$data['news']->description);
        $data['product'] = DB::table('products')->select('id','product_code','product_name')->whereNotNull('product_code')->orderBy('product_code','DESC')->get();
        
        $recommend_product = array();
        $recommend = DB::table('recommend_product')->where('recommend_ref_article',$id)->get();
        if(!empty($recommend)){
            foreach ($recommend as $key => $_recommend) {
                array_push($recommend_product, $_recommend->recommend_ref_product);
            }
        }
        $data['recommend_product'] = $recommend_product;

        return view('admin/news/add', $data);
    }
    public function insert(Request $request)
    {
            $path = "upload/news/";
        // return $request;
        if($request->file('title_image')){
            $file = $request->file('title_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $title_image_name = $request->title_image_name.'.'.$extension;
        }

        try{
            $news = new News;
            $news->title = $request->title;
            $news->detail = $request->detail;
            $news->title_image = $title_image_name;
            $news->meta_title = $request->meta_title;
            $news->meta_keywords = $request->meta_keywords;
            $news->meta_description = $request->meta_description;
            $news->save();

            $lasted = DB::table('news')->orderBy('id','DESC')->first();
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
            return redirect('admin/news')->with('message', 'Insert news "'.$request->title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
// return 555;
            $news = News::find($id);
            $lastTitleName = $news->title_image;

            $path = "upload/news/";

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
            $news->title = $request->title;
            $news->detail = $request->detail;
            if(isset($title_image_name)){
                $news->title_image = $title_image_name;
            }
            $news->meta_title = $request->meta_title;
            $news->meta_keywords = $request->meta_keywords;
            $news->meta_description = $request->meta_description;
            $news->save();

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
                $file->move($path, $title_image_name);
                @unlink("$path/$lastTitleName");
            }else{
                if(pathinfo($lastTitleName, PATHINFO_FILENAME)!=$request->title_image_name){
                    @rename($path.$lastTitleName, $path.$title_image_name);
                }
            }
            return redirect("admin/news/edit/$id")->with('message', 'Update news "'.$request->title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            News::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function checkPin($id){
        $promotion = DB::table('news')->get();
        foreach ($promotion as $_promotion) {
            $update_all['pin'] = 0;
            DB::table('news')->where('id',$_promotion->id)->update($update_all);
        }
        $update['pin'] = 1;
        DB::table('news')->where('id',$id)->update($update);
        DB::commit();
    }

    public function removePin($id){
        $update['pin'] = 0;
        DB::table('news')->where('id',$id)->update($update);
        DB::commit();
    }
}
