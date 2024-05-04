<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Portfolio;
use App\PortfolioFile;
use App\PortfolioGallery;
use App\PortfolioCategory;
use App\SubCategory;
use App\Brand;
use App\Color;
use App\Size;
DB::beginTransaction();

class PortfolioController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'portfolio';
        $data['asset'] = asset('/');
        $data['page'] = 'Portfolio';
        $data['page_url'] = 'portfolio';

        $results = Portfolio::selectRaw('portfolios.*,portfolio_categorys.portfolio_category_name');
            if(@$request->portfolio_name){
                $results = $results->Where('portfolio_name','LIKE','%'.$request->portfolio_name.'%');
            }
        $results = $results->leftJoin('portfolio_categorys','portfolio_categorys.id','=','portfolios.ref_category_id')
                ->orderBy('id','DESC')
                ->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/portfolios/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Portfolio';
        $data['page'] = 'Portfolio Add';
        $data['page_url'] = 'portfolio Add';
        $data['action'] = "insert";
        $data['portfolio_category'] = PortfolioCategory::orderBy('id','DESC')->get();
        return view('admin/portfolios/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Portfolio';
        $data['page'] = 'Portfolio Edit';
        $data['page_url'] = 'portfolio';
        $data['action'] = "../update/$id";
        $data['portfolio_category'] = PortfolioCategory::orderBy('id','DESC')->get();
        $data['portfolio'] = Portfolio::find($id);

        return view('admin/portfolios/add', $data);
    }
    public function insert(Request $request)
    {
        $path = "upload/portfolio/";
        if($request->file('portfolio_image')){
            $file = $request->file('portfolio_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $portfolio_image_name = $request->portfolio_image_name.'.'.$extension;

        }

        try{
            $portfolio = new Portfolio;
            $portfolio->portfolio_image = @$portfolio_image_name;
            $portfolio->ref_category_id = $request->category_id;
            $portfolio->save();
            
            DB::commit();
            if(@$file) $file->move($path, $portfolio_image_name);
            return redirect('admin/portfolio')->with('message', 'Insert portfolio "'.$request->portfolio_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;
        $portfolio = Portfolio::find($id);
        $lastTitleName = $portfolio->portfolio_image;

        $path = "upload/portfolio/";

        if(!is_null($request->file('portfolio_image'))){
            $file = $request->file('portfolio_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $portfolio_image_name = $request->portfolio_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastTitleName, PATHINFO_FILENAME)!=$request->portfolio_image_name){
                $portfolio_image_name = str_replace(' ','_',$request->portfolio_image_name).'.'.pathinfo($lastTitleName, PATHINFO_EXTENSION);
            }
        }
        try{
            $portfolio->ref_category_id = $request->category_id;
            if(isset($portfolio_image_name)){
                $portfolio->portfolio_image = $portfolio_image_name;
            }
            $portfolio->save();

            if(!is_null($request->file('portfolio_image'))){
                @unlink("$path/$lastTitleName");
                $file->move($path, $portfolio_image_name);
            }else{
                if(pathinfo($lastTitleName, PATHINFO_FILENAME)!=$request->portfolio_image_name){
                    @rename($path.$lastTitleName, $path.$portfolio_image_name);
                }
            }

            DB::commit();
            return redirect("admin/portfolio/edit/$id")->with('message', 'Update portfolio "'.$request->portfolio_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Portfolio::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
