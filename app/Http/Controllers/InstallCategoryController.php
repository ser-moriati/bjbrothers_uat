<?php

namespace App\Http\Controllers;

use App\InstallCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class InstallCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'installcategory';
        $data['asset'] = asset('/');
        $data['page'] = 'Category';
        $data['page_url'] = 'installcategory';
        $results = InstallCategory::orderBy('id','DESC');
        
        if(@$request->install_category_name){
            $results = $results->Where('install_category_name','LIKE','%'.$request->install_category_name.'%');
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
        return view('admin/installcategorys/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = 'insert';

        return view('admin/installcategorys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Edit Category';
        $data['action'] = "../update/$id";
        $data['category'] = InstallCategory::find($id);

        return view('admin/installcategorys/add', $data);
    }

    public function insert(Request $request){

        try{
            if($request->file('install_category_image')){
                $file = $request->file('install_category_image');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/installcategory/";
                $install_category_image_name = $request->install_category_image_name.'.'.$extension;
            }

            $category = new InstallCategory;
            $category->install_category_name = $request->install_category_name;
            $category->install_category_image = @$install_category_image_name;
            $category->save();

            if(@$file) $file->move($path, $install_category_image_name);

            DB::commit();
            return redirect('admin/installcategory')->with('message', 'Insert category "'.$request->install_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
            // return view('admin/installcategorys/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        $category = InstallCategory::find($id);
        $lastImage = $category->install_category_image;
        $path = "upload/installcategory/";

        if(!is_null($request->file('install_category_image'))){
            $file = $request->file('install_category_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $install_category_image_name = $request->install_category_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->install_category_image_name){
                $install_category_image_name = str_replace(' ','_',$request->install_category_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }
        try{
            $category->install_category_image = $install_category_image_name;
            $category->install_category_name = $request->install_category_name;
            $category->save();

            if(!is_null($request->file('install_category_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $install_category_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->install_category_image_name){
                    @rename($path.$lastImage, $path.$install_category_image_name);
                }
            }

            DB::commit();
            return redirect("admin/installcategory")->with('message', 'Update category "'.$request->install_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);

        try{
            InstallCategory::destroy($id);
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
     * @param  \App\InstallCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(InstallCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InstallCategory  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(InstallCategory $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InstallCategory  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InstallCategory  $category
     * @return \Illuminate\Http\Response
     */
}
