<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Portfolio;
use App\PortfolioCategory;
use App\PortfolioGallery;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class PortfolioController extends Controller
{
    public function index($cate_id = null){
        $data['meta'] = Seo::find(5);
        $portfolio = Portfolio::orderBy('id','DESC')->where('ref_category_id',$cate_id);
        if(is_null($cate_id)){
            $last_cate = PortfolioCategory::max('id');
            return redirect('portfolio/'.$last_cate);
        }
        $data['portfolio'] = $portfolio->paginate(16);
        $data['category'] = PortfolioCategory::orderBy('id','DESC')->get();
        $data['cate_id'] = $cate_id;
        return view('portfolio', $data);
    }
    // public function detail($id){
    //     $data['portfolio'] = Portfolio::find($id);
    //     $data['gallery'] = PortfolioGallery::where('ref_portfolio_id',$id)->get();
    //     return view('portfolio_detail', $data);
    // }
}
