<?php

namespace App\Http\Controllers;

use App\Category;
use App\Faq;
use App\Member;
use App\MemberCategory;
use App\Order;
use App\OrderStatus;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Project;
use App\Promotion;
use App\Subscribe;
// use App\Dashboard;
use App\Seo;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

DB::beginTransaction();

class DashboardController extends Controller
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
    //     return view('dashboard');
    // }
    public function module() {
        return 'dashboard';
    } 
    public function index()
    {
        $category = Category::selectRaw('categorys.id,categorys.category_name,COUNT(products.id) as product_total,categorys.category_image')->leftJoin('products','categorys.id','products.ref_category_id')->groupBy('categorys.id','categorys.category_name','categorys.category_image')->get();
        $member_category = MemberCategory::selectRaw('member_categorys.id,member_categorys.category_name,COUNT(members.id) as member_total')->leftJoin('members','member_categorys.id','members.ref_member_category_id')->groupBy('member_categorys.id','member_categorys.category_name')->get();
        $order_status = OrderStatus::selectRaw('order_status.id,order_status.status_name,order_status.color_code,order_status.color_background,order_status.icon,COUNT(orders.id) as order_total')->leftJoin('orders','order_status.id','orders.ref_order_status_id')->groupBy('order_status.id','order_status.status_name','order_status.color_code','order_status.color_background','order_status.icon')->get();
        $product_not_cate = Product::whereNotIn('ref_category_id',array_column($category->toArray(),'id'))->count();

        $data['module'] = $this->module();
        $data['page'] = 'dashboard';
        $data['order_status'] = $order_status;
        $data['member_category'] = $member_category;
        $data['category'] = $category;
        $data['product_not_cate'] = $product_not_cate;
        $data['total_product'] = Product::count();
        $data['total_order'] = Order::count();
        $data['total_member'] = Member::count();
        $currentDate = date('Y-m-d');
        $data['total_member_new'] = Member::whereDate('created_at','=',$currentDate)->count();
        
        $data['total_Subscribe_new'] = DB::Table("contact_emai")->WhereDate('contact_email_created_at','=',$currentDate)->count();
        $data['promotion_total'] = Promotion::count();
        $data['project_total'] = Project::count();
        $data['faq_total'] = Faq::count();
        return view('admin/dashboard/index', $data);
    }
}
