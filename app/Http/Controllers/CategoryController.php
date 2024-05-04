<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'category';
        $data['asset'] = asset('/');
        $data['page'] = 'Category';
        $data['page_url'] = 'category';
        $results = Category::orderBy('sort','ASC');
        
        if(@$request->category_name){
            $results = $results->Where('category_name','LIKE','%'.$request->category_name.'%');
        }
        $results = $results->paginate(15);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        
        $data['list_data'] = $results;
        $dataPaginate = $results->toArray();
        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        // $results = $results->toArray();
// return $results;
        return view('admin/categorys/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = 'insert';

        return view('admin/categorys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Edit Category';
        $data['action'] = "../update/$id";
        $data['category'] = Category::find($id);

        return view('admin/categorys/add', $data);
    }

    public function insert(Request $request){

        $file = $request->file('banner_image');
        $file_name = $file->getClientOriginalName();
        $fff = $file->move('upload/category', $file_name);

        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = 'insert';
        try{
            $category = new Category;
            $category->category_name = $request->category_name;
            $category->category_detail = $request->category_detail;
            $category->banner_image = $file_name;
            $category->save();

            DB::commit();
            return redirect('admin/category');
        } catch (QueryException $err) {
            DB::rollBack();
            return view('admin/categorys/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $lastBannerName = $category->banner_image;
        $lastHomeName = $category->image_home;
        //
        if(!is_null($request->file('banner_image'))){
            $file = $request->file('banner_image');
            $file_name = $file->getClientOriginalName();
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $img_name = pathinfo($file_name, PATHINFO_FILENAME);
            $banner_image_name = $request->banner_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastBannerName, PATHINFO_FILENAME)!=$request->banner_image_name){
                $banner_image_name = str_replace(' ','_',$request->banner_image_name).'.'.pathinfo($lastBannerName, PATHINFO_EXTENSION);
            }
        }

        if(!is_null($request->file('image_home'))){
            $img_home = $request->file('image_home');
            $img_name_home = $img_home->getClientOriginalName();
            $extension = pathinfo($img_name_home, PATHINFO_EXTENSION);
            $img_name = pathinfo($img_name_home, PATHINFO_FILENAME);
            $image_home_name = $request->image_home_name.'.'.$extension;
        }else{
            if(pathinfo($lastHomeName, PATHINFO_FILENAME)!=$request->image_home_name){
                $image_home_name = str_replace(' ','_',$request->image_home_name).'.'.pathinfo($lastHomeName, PATHINFO_EXTENSION);
            }
        }

        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = "../update/$id";
        try{

            $category->category_name = $request->category_name;
            $category->category_detail = $request->category_detail;
            if(isset($banner_image_name)){
                $category->banner_image =  $banner_image_name;
            }
            if(isset($image_home_name)){
                $category->image_home = $image_home_name;
            }
            $category->save();

            if(!is_null($request->file('banner_image'))){
                @unlink("upload/category/$lastBannerName");
                $file->move('upload/category', $banner_image_name);
            }else{
                if(pathinfo($lastBannerName, PATHINFO_FILENAME)!=$request->banner_image_name){
                    if(@$file) $file->move('upload/category', $banner_image_name);
                }
            }
            
            if(!is_null($request->file('home_image'))){
                @unlink("upload/category/$lastHomeName");
                $file->move('upload/category', $image_home_name);
            }else{
                if(pathinfo($lastHomeName, PATHINFO_FILENAME)!=$request->image_home_name){
                  
                    if(@$img_home) $img_home->move('upload/category', $image_home_name);
                }
            }
            DB::commit();
            return redirect("admin/category");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function changeSort(Request $request)
    {
        try{
            if($request->sort_more > $request->sort){
                Category::whereBetween('sort',[$request->sort, $request->sort_more])->decrement('sort');
            }else{
                Category::whereBetween('sort',[$request->sort_more,$request->sort])->increment('sort');
            }
            Category::where('id',$request->id)->update(['sort'=>$request->sort_more]);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Category::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(Category $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
}
