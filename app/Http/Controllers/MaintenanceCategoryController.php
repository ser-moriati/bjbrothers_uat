<?php

namespace App\Http\Controllers;

use App\MaintenanceCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class MaintenanceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'maintenancecategory';
        $data['asset'] = asset('/');
        $data['page'] = 'Category';
        $data['page_url'] = 'maintenancecategory';
        $results = MaintenanceCategory::orderBy('id','DESC');
        
        if(@$request->maintenance_category_name){
            $results = $results->Where('maintenance_category_name','LIKE','%'.$request->maintenance_category_name.'%');
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
        return view('admin/maintenancecategorys/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = 'insert';

        return view('admin/maintenancecategorys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Edit Category';
        $data['action'] = "../update/$id";
        $data['category'] = MaintenanceCategory::find($id);

        return view('admin/maintenancecategorys/add', $data);
    }

    public function insert(Request $request){

        try{
            if($request->file('maintenance_category_image')){
                $file = $request->file('maintenance_category_image');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/maintenancecategory/";
                $maintenance_category_image_name = $request->maintenance_category_image_name.'.'.$extension;
                
            }

            $category = new MaintenanceCategory;
            $category->maintenance_category_name = $request->maintenance_category_name;
            $category->maintenance_category_image = @$maintenance_category_image_name;
            $category->save();

            if(@$file) $file->move($path, $maintenance_category_image_name);

            DB::commit();
            return redirect('admin/maintenancecategory')->with('message', 'Insert category "'.$request->maintenance_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
            // return view('admin/maintenancecategorys/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        $category = MaintenanceCategory::find($id);
        $path = "upload/maintenancecategory/";
        $lastImage = $category->maintenance_category_image;

        if(!is_null($request->file('maintenance_category_image'))){
            $file = $request->file('maintenance_category_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $maintenance_category_image_name = $request->maintenance_category_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->maintenance_category_image_name){
                $maintenance_category_image_name = str_replace(' ','_',$request->maintenance_category_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION);
            }
        }
        try{
            $category->maintenance_category_image = $maintenance_category_image_name;
            $category->maintenance_category_name = $request->maintenance_category_name;
            $category->save();

            if(!is_null($request->file('maintenance_category_image'))){
                @unlink("$path/$lastImage");
                $file->move($path, $maintenance_category_image_name);
            }else{
                if(pathinfo($lastImage, PATHINFO_FILENAME)!=$request->maintenance_category_image_name){
                    @rename($path.$lastImage, $path.$maintenance_category_image_name);
                }
            }

            DB::commit();
            return redirect("admin/maintenancecategory")->with('message', 'Update category "'.$request->maintenance_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);

        try{
            MaintenanceCategory::destroy($id);
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
     * @param  \App\MaintenanceCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaintenanceCategory  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(MaintenanceCategory $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenanceCategory  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenanceCategory  $category
     * @return \Illuminate\Http\Response
     */
}
