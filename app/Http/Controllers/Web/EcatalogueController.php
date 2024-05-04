<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ecatalogue;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class EcatalogueController extends Controller
{
    public function index(Request $request){

        $order_by = 'id';
        $sort = 'desc';
        $data['sort_default'] = 'Lastest';

        $data['sort_list'] = $this->sort();

        if($request->order_by){
            $order_by = $data['sort_list'][$request->order_by]['order_by'];
            $sort = $data['sort_list'][$request->order_by]['sort'];
            $data['sort_default'] = $data['sort_list'][$request->order_by]['name'];
        }

        $data['meta'] = Seo::find(5);
        $ecatalogue = Ecatalogue::orderBy($order_by, $sort);
        $data['ecatalogue'] = $ecatalogue->paginate(6);
        $data['order_by'] = $order_by;
        $data['sort'] = $sort;
        return view('ecatalogue', $data);
    }

    public function sort(){

        $sort_list = [
            [
                'name' => 'Lastest',
                'order_by' => 'id',
                'sort' => 'desc',
            ],
            [
                'name' => 'Oldest',
                'order_by' => 'id',
                'sort' => 'asc',
            ],
            [
                'name' => 'Title',
                'order_by' => 'ecatalogue_pdf_name',
                'sort' => 'asc',
            ],
        ];
        return $sort_list;
    }
}
