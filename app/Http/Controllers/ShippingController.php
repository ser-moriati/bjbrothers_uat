<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Shipping;
use Illuminate\Database\QueryException;

DB::beginTransaction();

class ShippingController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'shipping';
        $data['asset'] = asset('/');
        $data['page'] = 'Shipping';
        $data['page_url'] = 'shipping';

        $results = Shipping::orderBy('id','DESC');
            if(@$request->shipping_name){
                $results = $results->Where('shipping_name','LIKE','%'.$request->shipping_name.'%');
            }
        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/shippings/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Shipping';
        $data['page'] = 'Shipping Add';
        $data['page_url'] = 'shipping Add';
        $data['action'] = "insert";
        return view('admin/shippings/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Shipping';
        $data['page'] = 'Shipping Edit';
        $data['page_url'] = 'shipping';
        $data['action'] = "../update/$id";
        $data['shipping'] = Shipping::find($id);

        return view('admin/shippings/add', $data);
    }
    public function insert(Request $request)
    {

        try{
            $shipping = new Shipping;
            $shipping->shipping_name = $request->shipping_name;
            $shipping->shipping_detail = $request->shipping_detail;
            $shipping->shipping_sale = $request->shipping_sale;
            $shipping->save();
            DB::commit();
            return redirect('admin/shipping')->with('message', 'Insert shipping "'.$request->shipping_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;

        try{
            $shipping = Shipping::find($id);
            $shipping->shipping_name = $request->shipping_name;
            $shipping->shipping_detail = $request->shipping_detail;
            $shipping->shipping_sale = $request->shipping_sale;
            $shipping->save();

            DB::commit();
            return redirect("admin/shipping/edit/$id")->with('message', 'Update shipping "'.$request->shipping_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Shipping::destroy($id);
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
