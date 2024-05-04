<?php

namespace App\Http\Controllers;

use App\Color;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'color';
        $data['asset'] = asset('/');
        $data['page'] = 'Color';
        $data['page_url'] = 'color';
        $results = Color::orderBy('id','DESC');
        if(@$request->color_name){
            $results = $results->Where('color_name','LIKE','%'.$request->color_name.'%');
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
        return view('admin/colors/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Color';
        $data['page'] = 'Add Color';
        $data['action'] = 'insert';

        return view('admin/colors/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Color';
        $data['page'] = 'Edit Color';
        $data['action'] = "../update/$id";
        $data['color'] = Color::find($id);

        return view('admin/colors/add', $data);
    }

    public function insert(Request $request){

        // return $request;
        $data['asset'] = asset('/');
        $data['page_before'] = 'Color';
        $data['page'] = 'Add Color';
        $data['action'] = 'insert';
        try{
            $color = new Color;
            $color->color_code = $request->color_code;
            $color->color_name = $request->color_name;
            $color->save();

            DB::commit();
            return redirect('admin/color');
        } catch (QueryException $err) {
            DB::rollBack();
            return view('admin/colors/add', $data);
        }
    }
    public function update(Request $request, $id)
    {
        //
        $data['asset'] = asset('/');
        $data['page_before'] = 'Color';
        $data['page'] = 'Add Color';
        $data['action'] = "../update/$id";
        try{
            $color = Color::find($id);
            $color->color_code = $request->color_code;
            $color->color_name = $request->color_name;
            $color->save();

            DB::commit();
            return redirect("admin/color/edit/$id");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Color::destroy($id);
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
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    // public function edit(Color $color)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
}
