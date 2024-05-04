<?php

namespace App\Http\Controllers;

use App\ProjectCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class ProjectCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'projectcategory';
        $data['asset'] = asset('/');
        $data['page'] = 'Category';
        $data['page_url'] = 'projectcategory';
        $results = ProjectCategory::orderBy('id','DESC');
        
        if(@$request->project_category_name){
            $results = $results->Where('project_category_name','LIKE','%'.$request->project_category_name.'%');
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
        return view('admin/projectcategorys/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Add Category';
        $data['action'] = 'insert';

        return view('admin/projectcategorys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Category';
        $data['page'] = 'Edit Category';
        $data['action'] = "../update/$id";
        $data['category'] = ProjectCategory::find($id);

        return view('admin/projectcategorys/add', $data);
    }

    public function insert(Request $request){

        try{
            $category = new ProjectCategory;
            $category->project_category_name = $request->project_category_name;
            $category->save();

            DB::commit();
            return redirect('admin/projectcategory')->with('message', 'Insert category "'.$request->project_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
            return view('admin/projectcategorys/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        try{
            $category = ProjectCategory::find($id);
            $category->project_category_name = $request->project_category_name;
            $category->save();

            DB::commit();
            return redirect("admin/projectcategory")->with('message', 'Update category "'.$request->project_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);

        try{
            ProjectCategory::destroy($id);
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
     * @param  \App\ProjectCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectCategory  $category
     * @return \Illuminate\Http\Response
     */
    // public function edit(ProjectCategory $category)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectCategory  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectCategory  $category
     * @return \Illuminate\Http\Response
     */
}
