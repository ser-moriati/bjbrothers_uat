<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Seo;
use App\ShippingCost;
use Illuminate\Http\Request;
DB::beginTransaction();

class ShippingCostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('shippingcost');
    // }
    public static function calculate($total_weight){
        $shippingcost = ShippingCost::first();
        $persen = (100/$shippingcost->weight)*$shippingcost->shipping_cost;
        
        // $cart->product_weight*
        return $total_weight*$persen/100;
    }
    public function module() {
        return 'shippingcost';
    } 
    public function index()
    {
        $shippingcost = ShippingCost::first();
        $seo = Seo::where('module', $this->module())->first();
        $data['shippingcost'] = $shippingcost;
        
        $data['module'] = $this->module();
        $data['page'] = 'shipping cost';
        $data['action'] = $this->module().'/update/'.$shippingcost->id;
        $data['seo'] = $seo;
        return view('admin/shippingcost/index', $data);
    }
    public function update(Request $request, $id)
    {
        try{
            $shippingcost = ShippingCost::find($id);
            
            $shippingcost->weight = $request->weight;
            $shippingcost->shipping_cost = $request->shipping_cost;
            $shippingcost->save();
            
            DB::commit();
            return redirect("admin/shippingcost");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function select_product(Request $request){
        $results = Product::select('id','product_code','product_name','product_image','product_price')->whereIn('id',$request->id)->get();
        return response($results);

    }
}
