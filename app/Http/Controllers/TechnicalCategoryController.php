<?php

namespace App\Http\Controllers;

use App\TechnicalCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class TechnicalCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'technicalcategory';
        $data['asset'] = asset('/');
        $data['page'] = 'Category';
        $data['page_url'] = 'technicalcategory';
        $results = TechnicalCategory::orderBy('id','DESC');
        
        if(@$request->technical_category_name){
            $results = $results->Where('technical_category_name','LIKE','%'.$request->technical_category_name.'%');
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
        return view('admin/technicalcategorys/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = 'insert';

        return view('admin/technicalcategorys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Edit Category';
        $data['action'] = "../update/$id";
        $data['category'] = TechnicalCategory::find($id);

        return view('admin/technicalcategorys/add', $data);
    }

    public function insert(Request $request){

        try{
            if($request->file('technical_category_image')){
                $file = $request->file('technical_category_image');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/technicalcategory/";
                $technical_category_image_name = $request->technical_category_image_name.'.'.$extension;
            }

            $category = new TechnicalCategory;
            $category->technical_category_name = $request->technical_category_name;
            $category->technical_category_image = @$technical_category_image_name;
            $category->save();

            if(@$file) $file->move($path, $technical_category_image_name);

            DB::commit();
            return redirect('admin/technicalcategory')->with('message', 'Insert category "'.$request->technical_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
            // return view('admin/technicalcategorys/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        $category = TechnicalCategory::find($id);
        $path = "upload/technicalcategory/";
        $lastImage = $category->technical_category_image;

        if(!is_null($request->file('technical_category_image'))){
            $file = $request->file('technical_category_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $technical_category_image_name = $request->technical_category_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->technical_category_image_name){
                $technical_category_image_name = str_replace(' ','_',$request->technical_category_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }
        try{
            $category->technical_category_image = $technical_category_image_name;
            $category->technical_category_name = $request->technical_category_name;
            $category->save();

            if(!is_null($request->file('technical_category_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $technical_category_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->technical_category_image_name){
                    @rename($path.$lastImage, $path.$technical_category_image_name);
                }
            }

            DB::commit();
            return redirect("admin/technicalcategory")->with('message', 'Update category "'.$request->technical_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);

        try{
            TechnicalCategory::destroy($id);
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
     * @param  \App\TechnicalCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(TechnicalCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TechnicalCategory  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(TechnicalCategory $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TechnicalCategory  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TechnicalCategory  $category
     * @return \Illuminate\Http\Response
     */
}
