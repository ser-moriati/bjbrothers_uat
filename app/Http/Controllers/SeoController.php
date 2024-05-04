<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Seo;
use App\Product;
DB::beginTransaction();

class SeoController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'seo';
        $data['page'] = 'Seo';
        $data['page_url'] = 'seo';
        $data['action'] = '';

        $results = Seo::orderBy('sort','ASC')->where('module','!=','')->get();
        $data['list_data'] = $results;
        // $data['query'] = request()->query();
        // $dataPaginate = $results->toArray();

        // $data['num'] = $dataPaginate['from'];
        // $data['from'] = $dataPaginate['from'];
        // $data['to'] = $dataPaginate['to'];
        // $data['total'] = $dataPaginate['total'];
        return view('admin/seos/index', $data);

    }
    public function insert(Request $request)
    {
        try{
            foreach($request->meta as $k => $meta){
                $product = Seo::find($k);
                $product->meta_title = $meta['meta_title'];
                $product->meta_keywords = $meta['meta_keywords'];
                $product->meta_description = $meta['meta_description'];
                $product->save();
            }

            DB::commit();
            return redirect('admin/seo')->with('message', 'Update SEO success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
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
