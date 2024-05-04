<?php

namespace App\Http\Controllers;

use App\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'size';
        $data['asset'] = asset('/');
        $data['page'] = 'Size';
        $data['page_url'] = 'size';
        $results = Size::orderBy('id','DESC');
        if(@$request->size_name){
            $results = $results->Where('size_name','LIKE','%'.$request->size_name.'%');
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
        // $cate = $cate->toArray();
// return $cate;
        return view('admin/sizes/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Size';
        $data['page'] = 'Add Size';
        $data['action'] = 'insert';

        return view('admin/sizes/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Size';
        $data['page'] = 'Edit Size';
        $data['action'] = "../update/$id";
        $data['size'] = Size::find($id);

        return view('admin/sizes/add', $data);
    }

    public function insert(Request $request){

        // return $request;
        $data['asset'] = asset('/');
        $data['page_before'] = 'Size';
        $data['page'] = 'Add Size';
        $data['action'] = 'insert';
        try{
            $size = new Size;
            $size->size_name = $request->size_name;
            $size->save();

            DB::commit();
            return redirect('admin/size');
        } catch (QueryException $err) {
            DB::rollBack();
            return view('admin/sizes/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        //
        $data['asset'] = asset('/');
        $data['page_before'] = 'Size';
        $data['page'] = 'Add Size';
        $data['action'] = "../update/$id";
        try{
            $size = Size::find($id);
            $size->size_name = $request->size_name;
            $size->save();

            DB::commit();
            return redirect("admin/size/edit/$id");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Size::destroy($id);
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
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
    // public function edit(Size $size)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Size  $size
     * @return \Illuminate\Http\Response
     */
}
