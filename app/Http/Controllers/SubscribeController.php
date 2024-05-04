<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Subscribe;
use App\Product;
DB::beginTransaction();

class SubscribeController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'subscribe';
        $data['page'] = 'Subscribe';
        $data['page_url'] = 'subscribe';

        $results = Subscribe::orderBy('id','DESC')->paginate(10);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/subscribes/index', $data);

    }
    public function index_new(Request $request){
        $data['module'] = 'subscribe';
        $data['page'] = 'Subscribe';
        $data['page_url'] = 'subscribe';
        $currentDate = date('Y-m-d');
        $results = Subscribe::WhereDate('contact_email_created_at','=',$currentDate)->orderBy('id','DESC')->paginate(10);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/subscribes/index', $data);

    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Product::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
