<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Home;
use App\HomeHasPromotion;
use App\News;
use App\Portfolio;
use App\Project;
use App\Promotion;
use App\Safety;
use App\Seo;
use Auth;

use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Illuminate\Http\Request;
DB::beginTransaction();

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }
    public function module() {
        return 'home';
    } 
    public function index()
    {
        $home = Home::first();
        $seo = Seo::where('module', $this->module())->first();
        $news = News::select('id','title','title_image')->get();
        $safety = Safety::select('id','safety_name','safety_image')->get();
        $portfolio = Portfolio::select('id','portfolio_image')->get();
        
        $news_array = HomeHasPromotion::where('module','news')->select('ref_module_id')->get()->toArray();
        $safety_array = HomeHasPromotion::where('module','safety')->select('ref_module_id')->get()->toArray();
        $portfolio_array = HomeHasPromotion::where('module','portfolio')->select('ref_module_id')->get()->toArray();
        // $pro_recom_array = explode(',',$home->product_recommended);
        // $product_recommended = Product::select('id','product_code','product_name','product_image','product_price')->whereIn('id',$pro_recom_array)->get();
        
        $data['module'] = $this->module();
        $data['page'] = 'home';
        $data['action'] = $this->module().'/update/'.$home->id;
        $data['row'] = $home;
        $data['news'] = $news;
        $data['safety'] = $safety;
        $data['portfolio'] = $portfolio;
        
        $data['news_array'] = array_column($news_array,'ref_module_id');
        $data['safety_array'] = array_column($safety_array,'ref_module_id');
        $data['portfolio_array'] = array_column($portfolio_array,'ref_module_id');
        // $data['product_recommended'] = $product_recommended;
        // $data['pro_recom_array'] = $pro_recom_array;
        $data['seo'] = $seo;
        return view('admin/home/index', $data);
    }
    
    public function update(Request $request, $id)
    {
        
        try{
            $home = Home::find($id);
            $lastName = $home->banner_name;

            if(!is_null($request->file('banner_name'))){
                $img = $request->file('banner_name');
                $img_name = $img->getClientOriginalName();
                $extension = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_name = pathinfo($img_name, PATHINFO_FILENAME);
                $banner_name_name = $request->banner_name_name.'.'.$extension;
            }else{
                if(pathinfo($lastName, PATHINFO_FILENAME)!=$request->banner_name_name){
                    $banner_name_name = $request->banner_name_name.'.'.pathinfo($lastName, PATHINFO_EXTENSION);
                }
            }
            
            if(!is_null($request->product)) $request->product = implode(",",$request->product);
            
            $home->video = $request->video;
            $home->product_recommended = '';
            if(isset($banner_name_name)){
                $home->banner_name = $banner_name_name;
            }
            $home->save();
            HomeHasPromotion::truncate();
            foreach($request->promotion as $pro){
                $ex = explode('|',$pro);
                // if($ex[0] == 'promotion'){
                    $promotion = new HomeHasPromotion;
                    $promotion->module = $ex[0];
                    $promotion->ref_module_id = $ex[1];
                    $promotion->save();
                // };
            }
            Seo::where('module',$this->module())->update([
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
            ]);
            if(!is_null($request->file('banner_name'))){
                // return $banner_name_name;
                @unlink("upload/home/$lastName");
                $img->move('upload/home', $banner_name_name);
            }else{
                if(isset($banner_name_name)){
                    @rename("upload/home/".$lastName, "upload/home/".str_replace(' ','_',$request->banner_name_name).'.'.pathinfo($lastName, PATHINFO_EXTENSION));
                }
            }
            DB::commit();
            return redirect("admin/home");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function select_product(Request $request){
        $results = Product::select('id','product_code','product_name','product_image','product_price')->whereIn('id',$request->id)->get();
        return response($results);

    }

    public function banner()
    {
        $data['module'] = "admin/home/delete";
        $data['asset'] = asset('/');
        $data['page'] = 'Home';
        $data['page_url'] = $this->module();

        $results =DB::table('banner')->orderBy('banner_id','DESC');
            if(@$request->title){
                $results = $results->Where('banner_id','LIKE','%'.$request->title.'%');
            }
            if(@$request->detail){
                $results = $results->Where('banner_name','LIKE','%'.$request->detail.'%');
            }
        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        
        
        return view('admin/home/banner/index', $data);
    }
    public function add_banner(){

        $asset = asset('/');
        $data['page_before'] = 'Banner';
        $data['page'] = 'Banner Add';
        $data['page_url'] = $this->module();
        $data['action'] = "insert";

        return view('admin/home/banner/add', $data);
    }
    public function insert_banner(Request $request)
    {
            $path = "upload/home/";
        // return $request;
        if($request->file('title_image')){
            $file = $request->file('title_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $title_image_name = $request->title_image_name.'.'.$extension;
        }

        try{
            $data3 = [
                'banner_name'		                =>  $title_image_name,
                'banner_URL'		                =>  $request->input('url'),
                'banner_created_at'	                =>  date("Y/m/d"),
                'banner_updated_at'	                =>  new DateTime(),
            ];
            DB::table('banner')->insert($data3);
            DB::commit();
            if(@$file) $file->move($path, $title_image_name);
            return redirect('admin/home/banner')->with('message', 'Insert banner "'.$request->title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

        public function edit_banner($id){
            $asset = asset('/');
            $data['page_before'] = 'Banner';
            $data['page'] = 'Banner Edit';
            $data['page_url'] = $this->module();
            $data['action'] = "Edit";    
            $banner = DB::table('banner')->where('banner_id',$id)->get();
            $data['row']= $banner;

        return view('admin/home/banner/edit', $data);
    }

    public function updatet_banner(Request $request)
    {
        
        try{
            $home = DB::table('banner')->where('banner_id',$request->input('id'))->get();
           
            foreach($home as $home){
            $lastName = $home->banner_name;
            }
            if(!is_null($request->file('banner_name'))){
                $img = $request->file('banner_name');
                $img_name = $img->getClientOriginalName();
                $extension = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_name = pathinfo($img_name, PATHINFO_FILENAME);
                $banner_name_name = $request->banner_name_name.'.'.$extension;
            }else{
                if(pathinfo($lastName, PATHINFO_FILENAME)!=$request->banner_name_name){
                    $banner_name_name = $request->banner_name_name.'.'.pathinfo($lastName, PATHINFO_EXTENSION);
                }
            }
            
       
            if(isset($banner_name_name)){
               
            $data3 = [
                'banner_name'		                =>  $banner_name_name,
                'banner_URL'		                =>  $request->input('url'), 
                'banner_updated_at'	                =>  new DateTime(),
            ];
            }else{
                $data3 = [
                  
                    'banner_URL'		                =>  $request->input('url'), 
                    'banner_updated_at'	                =>  new DateTime(),
                ];  
            }
           
            DB::table('banner')->where('banner_id',$request->input('id'))->update($data3);
            if(!is_null($request->file('banner_name'))){
                // return $banner_name_name;
                @unlink("upload/home/$lastName");
                $img->move('upload/home', $banner_name_name);
            }else{
                if(isset($banner_name_name)){
                    @rename("upload/home/".$lastName, "upload/home/".str_replace(' ','_',$request->banner_name_name).'.'.pathinfo($lastName, PATHINFO_EXTENSION));
                }
            }
            DB::commit();
            return redirect("admin/home/banner");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function destroy($id)
    {
       
        try{
            $data = DB::table('banner')->where('banner_id',$id)->delete();
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
