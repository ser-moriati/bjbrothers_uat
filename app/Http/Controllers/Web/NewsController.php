<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\News;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class NewsController extends Controller
{
    public function index(){
        $data['meta'] = Seo::find(7);
        $data['news_pin'] = News::where('pin',1)->first();
        $news = News::orderBy('id','DESC');
        $data['news'] = $news->paginate(6);
        return view('news', $data);
    }
    public function detail($id){
        $data['news'] = News::find($id);
        $data['meta'] = (object)['meta_title' => $data['news']->meta_title , 'meta_keywords' => $data['news']->meta_keywords , 'meta_description' => $data['news']->meta_description];
        return view('news_detail', $data);
    }
}
