<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Default_bank;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index(Request $request){
        $data['module'] = 'bank';
        $data['asset'] = asset('/');
        $data['page'] = 'Bank';
        $data['page_url'] = 'bank';

        $results = default_bank::orderBy('id','DESC');
            if(@$request->bank_name){
                $results = $results->Where('bank_name','LIKE','%'.$request->bank_name.'%');
            }
        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/bank/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Bank';
        $data['page'] = 'Bank Add';
        $data['page_url'] = 'bank Add';
        $data['action'] = "insert";
        return view('admin/bank/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'bank';
        $data['page'] = 'bank Edit';
        $data['page_url'] = 'bank';
        $data['action'] = "../update/$id";
        $data['bank'] = default_bank::find($id);

        return view('admin/bank/add', $data);
    }
    public function insert(Request $request)
    {

        try{
            $bank = new default_bank;
            $bank->bank_name = $request->bank_name;
            $bank->bank_number = $request->bank_number;
           
            $bank->save();
            DB::commit();
            return redirect('admin/bank')->with('message', 'Insert shipping "'.$request->shipping_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;

        try{
            $bank = default_bank::find($id);
            $bank->bank_name = $request->bank_name;
            $bank->bank_number = $request->bank_number;
            $bank->save();

            DB::commit();
            return redirect("admin/bank/edit/$id")->with('message', 'Update shipping "'.$request->shipping_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            default_bank::destroy($id);
            
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
