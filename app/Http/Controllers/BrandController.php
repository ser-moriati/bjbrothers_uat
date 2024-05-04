<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'brand';
        $data['asset'] = asset('/');
        $data['page'] = 'Brand';
        $data['page_url'] = 'brand';
        $results = Brand::orderBy('id','DESC');
        if(@$request->brand_name){
            $results = $results->Where('brand_name','LIKE','%'.$request->brand_name.'%');
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
        
        return view('admin/brands/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Brand';
        $data['page'] = 'Add Brand';
        $data['action'] = 'insert';

        return view('admin/brands/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Brand';
        $data['page'] = 'Edit Brand';
        $data['action'] = "../update/$id";
        $data['brand'] = Brand::find($id);

        return view('admin/brands/add', $data);
    }

    public function insert(Request $request){

        // return $request;
        $data['asset'] = asset('/');
        $data['page_before'] = 'Brand';
        $data['page'] = 'Add Brand';
        $data['action'] = 'insert';
        try{
            $brand = new Brand;
            $brand->brand_name = $request->brand_name;
            $brand->save();

            DB::commit();
            return redirect('admin/brand');
        } catch (QueryException $err) {
            DB::rollBack();
            return view('admin/brands/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        //
        $data['asset'] = asset('/');
        $data['page_before'] = 'Brand';
        $data['page'] = 'Add Brand';
        $data['action'] = "../update/$id";
        try{
            $brand = Brand::find($id);
            $brand->brand_name = $request->brand_name;
            $brand->save();

            DB::commit();
            return redirect("admin/brand/edit/$id");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Brand::destroy($id);
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
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    // public function edit(Brand $brand)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
}
