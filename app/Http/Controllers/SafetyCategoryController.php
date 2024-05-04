<?php

namespace App\Http\Controllers;

use App\SafetyCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class SafetyCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'safetycategory';
        $data['asset'] = asset('/');
        $data['page'] = 'Category';
        $data['page_url'] = 'safetycategory';
        $results = SafetyCategory::orderBy('id','DESC');
        
        if(@$request->safety_category_name){
            $results = $results->Where('safety_category_name','LIKE','%'.$request->safety_category_name.'%');
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
        return view('admin/safetycategorys/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = 'insert';

        return view('admin/safetycategorys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Edit Category';
        $data['action'] = "../update/$id";
        $data['category'] = SafetyCategory::find($id);

        return view('admin/safetycategorys/add', $data);
    }

    public function insert(Request $request){

        try{
            $path = "upload/safetycategory/";
            if($request->file('safety_category_image')){
                $file = $request->file('safety_category_image');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $safety_category_image_name = $request->safety_category_image_name.'.'.$extension;

            }

            $category = new SafetyCategory;
            $category->safety_category_name = $request->safety_category_name;
            $category->safety_category_image = @$safety_category_image_name;
            $category->save();

            if(@$file) $file->move($path, $safety_category_image_name);

            DB::commit();
            return redirect('admin/safetycategory')->with('message', 'Insert category "'.$request->safety_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
            // return view('admin/safetycategorys/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        $category = SafetyCategory::find($id);
        $path = "upload/safetycategory/";
        $lastImage = $category->safety_category_image;

        if(!is_null($request->file('safety_category_image'))){
            $file = $request->file('safety_category_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $safety_category_image_name = $request->safety_category_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->safety_category_image_name){
                $safety_category_image_name = str_replace(' ','_',$request->safety_category_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }

        try{
            $category->safety_category_image = $safety_category_image_name;
            $category->safety_category_name = $request->safety_category_name;
            $category->save();

            if(!is_null($request->file('safety_category_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $safety_category_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->safety_category_image_name){
                    @rename($path.$lastImage, $path.$safety_category_image_name);
                }
            }

            DB::commit();
            return redirect("admin/safetycategory")->with('message', 'Update category "'.$request->safety_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);

        try{
            SafetyCategory::destroy($id);
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
     * @param  \App\SafetyCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(SafetyCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SafetyCategory  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(SafetyCategory $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SafetyCategory  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SafetyCategory  $category
     * @return \Illuminate\Http\Response
     */
}
