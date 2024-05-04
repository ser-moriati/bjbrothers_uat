<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Product;
use App\ProductFile;
use App\ProductGallery;
use App\Category;
use App\SubCategory;
use App\Series;
use App\Brand;
use App\Color;
use App\ProductCode;
use App\ProductskUModel;
use App\ProductsOptionHead;
use App\ProductsOption1;
use App\ProductsOption2;
use App\ProductPrice;
use App\Roles;
use App\Size;
use Illuminate\Database\QueryException;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;

DB::beginTransaction();

class ProductController extends Controller
{
    //
    public function index(Request $request){
        // $pro = product::select('id','product_description')->where('product_description','LIKE','%ckfinder/userfiles%')->get();
        // // return $pro;
        // foreach($pro as $pr){
        //     $upd = product::find($pr->id);
        //     $upd->product_description = str_replace('ckfinder/userfiles/','ckfinder/userfiles/images/',$pr->product_description);
        //     $upd->save();
        //     // return str_replace('backoffice/assets/ckfinder/userfiles/source/','ckfinder/userfiles/',$pr->product_description);
        // }
        // DB::commit();
        // $prok = product::select('id','product_description')->where('product_description','LIKE','%ckfinder/userfiles%')->get();

        // return count($prok);
        $data['module'] = 'product';
        $data['page'] = 'Product';
        $data['page_url'] = 'product';
        
        //////////////// category
        $data['category'] = Category::orderBy('sort','ASC')->get();

        //////////////// sub_category
        $sub_category = SubCategory::orderBy('sort','ASC');
        if(@$request->category_id){
            $sub_category = $sub_category->Where('ref_category_id',$request->category_id);
        }
        $sub_category = $sub_category->get();
        $data['sub_category'] = $sub_category;

        //////////////// product
        $results = Product::selectRaw('products.*,categorys.category_name,categorys.category_color,sub_categorys.sub_category_name')->orderBy('products.product_image','ASC');
            if(@$request->product_code){
                $results = $results->Where('product_code','LIKE','%'.$request->product_code.'%');
            }
            if(@$request->product_name){
                $results = $results->Where('product_name','LIKE','%'.$request->product_name.'%');
            }
            if(@$request->category_id){
                $results = $results->Where('products.ref_category_id',$request->category_id);
            }
            if(@$request->sub_category_id){
                $results = $results->Where('products.ref_sub_category_id',$request->sub_category_id);
            }
            if(@$request->product_recommended){
                $results = $results->Where('product_recommended',$request->product_recommended);
            }
            if(@$request->product_new){
                $results = $results->Where('product_new',$request->product_new);
            }
            if(@$request->product_hot){
                $results = $results->Where('product_hot',$request->product_hot);
            }
            $results = $results->leftJoin('categorys','categorys.id','=','products.ref_category_id')
                            ->leftJoin('sub_categorys','sub_categorys.id','=','products.ref_sub_category_id')
                            ->with('product_codes')->paginate(10);
                            foreach($results as $pro){
                                $sale = DB::table('productsku')
                                ->select('ref_product_id',  DB::raw('MIN(price_0) as min_sale0'), DB::raw('MIN(price_1) as min_sale1')
                                , DB::raw('MIN(price_2) as min_sale2') , DB::raw('MIN(price_3) as min_sale3'),DB::raw('MIN(price_3) as min_sale3'),
                                DB::raw('MAX(price_0) as max_sale0'), DB::raw('MAX(price_1) as max_sale1'), DB::raw('MAX(price_2) as max_sale2'),
                                DB::raw('MAX(price_3) as max_sale3'))
                                ->where('ref_product_id',  $pro->id)
                                ->groupBy('ref_product_id')
                                ->get();
                            
                                if ($sale->count() > 0) {
                            
                                        $pro->min_sale = $sale[0]->min_sale0; 
                                        $pro->max_sale = $sale[0]->max_sale0; 
                                
                                
                                } else {
                                    $pro->min_sale =" 0.00"; 
                                    $pro->max_sale = "0.00"; 
        
                                }
                            }    
        $data['list_data'] = $results->appends(request()->query());
        // dd($data);
        $data['query'] = request()->query();
        
        $dataPaginate = $results->toArray();
        

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/products/index', $data);

    }
    public function clear(Request $request){
        $data['module'] = 'product';
        $data['page'] = 'Clear Product';
        $data['page_url'] = 'product';
        
        //////////////// category
        //////////////// product
        $results = Product::selectRaw('products.*,categorys.category_name,categorys.category_color,sub_categorys.sub_category_name');
            
        if(@$request->date_start){
            $date_start = explode('/',$request->date_start);
            $date_end = explode('/',$request->date_end);
            $results = $results->WhereBetween('products.created_at', [$date_start[2].'-'.$date_start[1].'-'.$date_start[0], $date_end[2].'-'.$date_end[1].'-'.$date_end[0].' 23:59:59']);
        }else{
            $results = $results->WhereBetween('products.created_at', ['0', '0']);
        }

        $results = $results->leftJoin('categorys','categorys.id','=','products.ref_category_id')
                            ->leftJoin('sub_categorys','sub_categorys.id','=','products.ref_sub_category_id')
                            ->orderBy('id','DESC')
                            ->paginate(50);
        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        
        $dataPaginate = $results->toArray();
        

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/products/clear', $data);

    }
    public function cleardelete(Request $request){
        try{
        
            $date_start = explode('/',$request->date_start);
            $date_end = explode('/',$request->date_end);

            Product::whereBetween('products.created_at', [$date_start[2].'-'.$date_start[1].'-'.$date_start[0], $date_end[2].'-'.$date_end[1].'-'.$date_end[0].' 23:59:59'])->delete();
            
            DB::commit();
            return true;
            // return redirect('admin/product/clear?date_start='.$request->date_start.'&date_end='.$request->date_end)->with('message', 'deleted product success');
        } catch (QueryException $err) {
            DB::rollBack();
        }

    }
    public function add(){

        $data['module'] = 'product';
        $data['page_before'] = 'Product';
        $data['page'] = 'Product Add';
        $data['page_url'] = 'product Add';
        $data['action'] = "insert";
        $data['category'] = Category::orderBy('id','DESC')->get();
        $data['sub_category'] = SubCategory::orderBy('id','DESC')->get();
        $data['series'] = Series::orderBy('id','DESC')->get();
        $data['brand'] = Brand::orderBy('id','DESC')->get();
        $data['color'] = Color::orderBy('id','DESC')->get();
        $data['role'] = Roles::orderBy('id_','DESC')->get();
        // $data['product'] = Product::find(9);
        // $data['product']->product_sizes = explode(',',$data['product']->product_sizes);
        // $data['product']->product_colors = explode(',',$data['product']->product_colors);
        $data['size'] = Size::orderBy('id','DESC')->get();
        return view('admin/products/add', $data);
    }
    public function clone($id)
    {
        $data['module'] = 'product';
        $data['page_before'] = 'Product';
        $data['page'] = 'Product Add';
        $data['page_url'] = 'product';
        $data['action'] = "../insert";
        $data['category'] = Category::orderBy('id','DESC')->get();
        $data['sub_category'] = SubCategory::orderBy('id','DESC')->get();
        $data['series'] = Series::orderBy('id','DESC')->get();
        $data['brand'] = Brand::orderBy('id','DESC')->get();
        $data['color'] = Color::orderBy('id','DESC')->get();
        $data['size'] = Size::orderBy('id','DESC')->get();

        $data['product'] = Product::find($id);
        $data['product']['product_image'] = null;

        $data['product']->product_sizes = explode(',',$data['product']->product_sizes);
        $data['product']->product_colors = explode(',',$data['product']->product_colors);

        return view('admin/products/add', $data);
    }
    public function edit($id)
    {
        $data['module'] = 'product';
        $data['page_before'] = 'Product';
        $data['page'] = 'Product Edit';
        $data['page_url'] = 'product';
        $data['action'] = "../update/$id";
        $data['category'] = Category::orderBy('id','DESC')->get();
        $data['sub_category'] = SubCategory::orderBy('id','DESC')->get();
        $data['series'] = Series::orderBy('id','DESC')->get();
        $data['brand'] = Brand::orderBy('id','DESC')->get();
        $data['color'] = Color::orderBy('id','DESC')->get();
        $data['size'] = Size::orderBy('id','DESC')->get();
        $data['role'] = Roles::orderBy('id_','DESC')->get();
        $data['products_option_head'] = DB::table('productsoptionhead')->where('product_id',$id)->get();
        $data['products_option_1'] = DB::table('productsoption1')->where('product_id',$id)->get();
        $data['products_option_2'] = DB::table('productsoption2')->where('product_id',$id)->get();
        $data['products_option_2_items']  = ProductskUModel::where('ref_product_id',$id)->get();
        $product_prices = ProductPrice::where('ref_product_id', $id)->orderBy('id','DESC')->get();
        $array_prices = [];
        foreach($product_prices as $prices){
            $array_prices[$prices->ref_role_id]['price'] = $prices->product_price;
            $array_prices[$prices->ref_role_id]['sale'] = $prices->product_sale;
        }
        $data['product_prices'] = $array_prices;
        $data['product'] = Product::find($id);
        $data['product']->product_files = ProductFile::where('ref_product_id', $id)->get();
        $data['product']['gallerys'] = ProductGallery::where('ref_product_id',$id)->get();

        $data['product']->product_sizes = explode(',',$data['product']->product_sizes);
        $data['product']->product_colors = explode(',',$data['product']->product_colors);

        return view('admin/products/add', $data);
    }
    public function insert(Request $request)
    {
        if($request->file('product_image')){
            $file = $request->file('product_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/product/";
            $product_image_name = $request->product_image_name.'.'.$extension;
                // if( file_exists($path.$product_image_name) )
                // {
                //     $product_image_name = $img_name.$request->product_code.'.'.$extension;
                // }
        }
        // return $product_image_name;
        if($request->product_sizes){ $sizes = implode(",",$request->product_sizes);} else {$sizes = '';}
        if($request->product_colors){ $colors = implode(",",$request->product_colors);} else {$colors = '';}

        try{
            $product = new Product;
            $product->product_recommended = $request->product_recommended == null? 'N' : 'Y' ;
            $product->product_new = $request->product_new == null? 'N' : 'Y' ;
            $product->product_hot = $request->product_hot == null? 'N' : 'Y' ;
            $product->product_code = $request->product_code;
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
            $product->product_sale = 0;
            $product->product_qty = $request->product_qty;
            $product->product_version = $request->product_version;
            $product->ref_category_id = $request->category_id;
            $product->ref_sub_category_id = $request->sub_category_id;
            $product->ref_series_id = $request->series_id;
            $product->ref_brand_id = $request->brand_id;
            $product->product_sizes = $sizes;
            $product->product_colors = $colors;
            $product->product_video = $request->product_video;
            $product->product_detail = $request->product_detail;
            $product->product_weight = $request->product_weight;
            $product->product_wide = $request->wide;
            $product->product_long = $request->long;
            $product->product_high = $request->high;
            $product->product_transport = $request->transport;
            $product->product_transportprice = $request->transportprice;
            $product->product_description = $request->product_description;
            $product->product_image = @$product_image_name;
            $product->status = $request->status==null?0:1;
            $product->meta_title = $request->meta_title;
            $product->meta_keywords = $request->meta_keywords;
            $product->meta_description = $request->meta_description;
            $product->save();
            // return 454;
            
            // if(@$request->product_sale){
            //     foreach($request->product_sale as $key => $product_sale){
            //             $insert_price = new ProductPrice();
            //             $insert_price->ref_product_id = $product->id;
            //             $insert_price->ref_role_id = $key;
            //             $insert_price->product_sale = $product_sale;
            //             // $insert_price->product_sale = $request->product_sale[$key];
            //             $insert_price->save();
            //     }
            // }
            if(!is_null($request->file('outer-group'))){
                $galleryFile = $request->file('outer-group');
                foreach($galleryFile[0]['inner-group'] as $gf){
                    $file_name = $gf['product_file']->getClientOriginalName();
                    $fff = $gf['product_file']->move('upload/product/files', $file_name);
                    $proFile = new ProductFile;
                    $proFile->file_name = $file_name;
                    $proFile->ref_product_id = $product->id;
                    $proFile->save();
                }
            }
            if(!is_null($request->product_file_url)){
            // return $request->product_file_url;
            // return $galleryFile;
                foreach($request->product_file_url as $key => $url){
                    if($url == null){
                        continue;
                    }
                    $proFile = new ProductFile;
                    $proFile->file_name = $request->product_file_video_name[$key];
                    $proFile->url = $url;
                    $proFile->ref_product_id = $product->id;
                    $proFile->save();
                }
            }
            if (!empty($request->input('option_title'))) {
                foreach ($request->input('option_title') as $key => $_option_title) {
                 
                    $products_option_head1 = new ProductsOptionHead();
                    $products_option_head1->product_id = $product->id;
                    $products_option_head1->option_type = $key + 1;
                    $products_option_head1->name_th = $_option_title;
                    $products_option_head1->name_en = $_option_title;
                    $products_option_head1->save();
                }
            }
            $array_max_min = array();
            $id_option_1 = array();
            $id_option_2 = array();
            if (!empty($request->input('option_detail'))) {
                foreach ($request->input('option_detail') as $key => $_option_detail) {
                    $products_option_1 = new ProductsOption1();
                    $products_option_1->product_id = $product->id;
                    $products_option_1->name_th = $_option_detail;
                    $products_option_1->name_en = $_option_detail;
                    if ($request->hasFile('option_detail_file')) {
                        $file1 = $request->file('option_detail_file')[$key];
                        $nameExtension1 = $file1->getClientOriginalName();
                        $extension1 = $file1->getClientOriginalExtension();
                        $img_name1 = pathinfo($nameExtension1, PATHINFO_FILENAME);
                        $timestamp1 = now()->timestamp;
                        $img_name1 = $img_name1 . '_' . $timestamp1;
                        $path = "upload/product/";
                        $option_detail_file1 = $img_name1 . '.' . $extension1;
                        $counter1 = 1;
                        while (file_exists($path . $option_detail_file1)) {
                            $option_detail_file1 = $img_name1 . '_' . $counter1 . '.' . $extension1;
                            $counter1++;
                        }
                        $file1->move($path, $option_detail_file1);
                        $products_option_1->img = $option_detail_file1;
                    }
                    $products_option_1->save();
                    array_push($id_option_1, $products_option_1->id);
                }
            }
            
    
            if (!empty($request->input('option_detail_2'))) {
                foreach ($request->input('option_detail_2') as $key => $_option_detail_2) {
                       
                        $products_option_2 = new ProductsOption2();
                        $products_option_2->product_id = $product->id;
                        $products_option_2->name_th = $_option_detail_2;
                        $products_option_2->name_en = $_option_detail_2;
                    if ($request->hasFile('option_detail_file_2')) {
                        $file2 = $request->file('option_detail_file_2')[$key];
                        $nameExtension2 = $file2->getClientOriginalName();
                        $extension2 = $file2->getClientOriginalExtension();
                        $img_name2 = pathinfo($nameExtension2, PATHINFO_FILENAME);
                        $timestamp2 = now()->timestamp;
                        $img_name2 = $img_name2 . '_' . $timestamp2;
                        $path = "upload/product/";
                        $option_detail_file2 = $img_name2 . '.' . $extension2;
                        $counter2 = 1;
                        while (file_exists($path . $option_detail_file2)) {
                            $option_detail_file2 = $img_name2 . '_' . $counter2 . '.' . $extension2;
                            $counter2++;
                        }
                        $file2->move($path, $option_detail_file2);
                        $products_option_2->img = $option_detail_file2;
                    }
                    $products_option_2->save();
                    array_push($id_option_2, $products_option_2->id);
                }
            }
            
            
            if(!empty($request->input('option_detail')[0])){
             
                foreach ($request->input('option_detail') as $key_1 => $_option_detail) {
                    if(!empty($_option_detail) && !empty($request->input('option_detail_2')[0])){
                        foreach ($request->input('option_detail_2') as $key_2 => $_option_detail_2) {
                         
                            if(!empty($_option_detail_2)){
                                $products_option_2_items = new ProductskUModel();
                                $products_option_2_items->ref_product_id = $product->id;
                                $products_option_2_items->product_option_1_id = $id_option_1[$key_1];
                                $products_option_2_items->product_option_2_id = $id_option_2[$key_2];
                                $products_option_2_items->price_0 = @$request->input('price')[$_option_detail][$_option_detail_2][0];
                                $products_option_2_items->price_1 = @$request->input('price1')[$_option_detail][$_option_detail_2][0];
                                $products_option_2_items->price_2 = @$request->input('price2')[$_option_detail][$_option_detail_2][0];
                                $products_option_2_items->price_3 = @$request->input('price3')[$_option_detail][$_option_detail_2][0];
                                $products_option_2_items->product_qty = @$request->input('stock')[$_option_detail][$_option_detail_2][0];
                                $products_option_2_items->product_SKU = @$request->input('sku')[$_option_detail][$_option_detail_2][0];
                                $products_option_2_items->name_th = $_option_detail . ' ' . $_option_detail_2;
                                $products_option_2_items->name_en = $_option_detail . ' ' . $_option_detail_2;
                                $products_option_2_items->save();
                            }
                        }
                    }elseif(!empty($_option_detail)){
                      
                        $key_2 = 0;
                        
                        $products_option_2_items = new ProductskUModel();
                        $products_option_2_items->ref_product_id = $product->id;
                        $products_option_2_items->product_option_1_id = $id_option_1[$key_1];
                        $products_option_2_items->price_0 = @$request->input('price')[$_option_detail][$key_2][0];
                        $products_option_2_items->price_1 = @$request->input('price1')[$_option_detail][$key_2][0];
                        $products_option_2_items->price_2 = @$request->input('price2')[$_option_detail][$key_2][0];
                        $products_option_2_items->price_3 = @$request->input('price3')[$_option_detail][$key_2][0];
                        $products_option_2_items->product_qty = @$request->input('stock')[$_option_detail][$key_2][0];
                        $products_option_2_items->product_SKU = @$request->input('sku')[$_option_detail][$key_2][0];
                        $products_option_2_items->name_th = $_option_detail . ' ' . $key_2;
                        $products_option_2_items->name_en = $_option_detail . ' ' . $key_2;
                        $products_option_2_items->save();
                    }
                }
            }
            if(@$request->file_gallery_name){
                $gallery = explode(',',$request->file_gallery_name);
                foreach($gallery as $gall){
                    $Pgallery = new ProductGallery;
                    $Pgallery->image_name = $gall;
                    $Pgallery->ref_product_id = $product->id;
                    $Pgallery->save();
                }
            }
            DB::commit();
            if(@$file) $file->move($path, $product_image_name);
            return redirect('admin/product')->with('message', 'Insert product "'.$request->product_code.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        ini_set('max_execution_time', 600);
        ini_set('memory_limit', '-1');

        $product = Product::find($id);

        $lastImage = $product->product_image;

        if(!is_null($request->file('product_image'))){
            $img = $request->file('product_image');
            $nameExtension = $img->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/product/";
            $product_image_name = $request->product_image_name.'.'.$extension;
        }else{
            if(pathinfo($product->product_image, PATHINFO_FILENAME)!=$request->product_image_name){
                $product_image_name = $request->product_image_name.'.'.pathinfo($product->product_image, PATHINFO_EXTENSION);
            }
        }
        
        if($request->product_sizes){ $sizes = implode(",",$request->product_sizes);} else {$sizes = '';}
        if($request->product_colors){ $colors = implode(",",$request->product_colors);} else {$colors = '';}
            $product->product_recommended = $request->product_recommended == null? 'N' : 'Y' ;
            $product->product_new = $request->product_new == null? 'N' : 'Y' ;
            $product->product_hot = $request->product_hot == null? 'N' : 'Y' ;
            $product->product_code = $request->product_code;
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
         
            $product->product_version = $request->product_version;
            $product->ref_category_id = $request->category_id;
            $product->product_qty = $request->product_qty;
            $product->ref_sub_category_id = $request->sub_category_id;
            $product->ref_series_id = $request->series_id;
            $product->ref_brand_id = $request->brand_id;
            $product->product_sizes = $sizes;
            $product->product_colors = $colors;
            $product->product_video = $request->product_video;
            $product->product_detail = $request->product_detail;
            $product->product_weight = $request->product_weight;
            $product->product_wide = $request->wide;
            $product->product_long = $request->long;
            $product->product_high = $request->high;
            $product->product_transport = $request->transport;
            $product->product_transportprice = $request->transportprice;
            $product->product_description = $request->product_description;
            if(isset($product_image_name)){
                $product->product_image = $product_image_name;
            }
            $product->status = $request->status==null?0:1;
            $product->meta_title = $request->meta_title;
            $product->meta_keywords = $request->meta_keywords;
            $product->meta_description = $request->meta_description;
            $product->save();

            if(!$request->product_file_id){
                $request->product_file_id = [];
            }
            $pro_file = ProductFile::where('ref_product_id',$id)->where('url',null)->WhereNotIn('id',$request->product_file_id)->get();
            ProductFile::whereNotIn('id', $request->product_file_id)->where('url',null)->where('ref_product_id', $id)->delete();
            
            if(@$pro_file){
                foreach($pro_file as $unlink){
                    @unlink("upload/product/files/$unlink->file_name");
                }
            }


            if(!is_null($request->file('outer-group'))){
                $galleryFile = $request->file('outer-group');
                foreach($galleryFile[0]['inner-group'] as $gf){
                    $file_name = $gf['product_file']->getClientOriginalName();
                    $fff = $gf['product_file']->move('upload/product/files', $file_name);
                    $proFile = new ProductFile;
                    $proFile->file_name = $file_name;
                    $proFile->ref_product_id = $id;
                    $proFile->save();
                }
            }
            
            if(!$request->file_url_id){
                $request->file_url_id = [];
            }
            $pro_file = ProductFile::where('ref_product_id',$id)->where('url','!=','')->WhereNotIn('id',$request->file_url_id)->get();
            ProductFile::whereNotIn('id', $request->file_url_id)->where('url','!=','')->where('ref_product_id', $id)->delete();

            if(!is_null($request->product_file_url)){
                foreach($request->product_file_url as $key => $url){
                    if($url == null){
                        continue;
                    }
                    $proFile = new ProductFile;
                    $proFile->file_name = $request->product_file_video_name[$key];
                    $proFile->url = $url;
                    $proFile->ref_product_id = $id;
                    $proFile->save();
                }
            }
            if(!is_null($request->file_url_id)){
                foreach($request->file_url_id as $key => $url_id){
                    if($url_id == null){
                        continue;
                    }
                    $proFile = ProductFile::find($url_id);
                    $proFile->file_name = $request->product_file_video_name_id[$key];
                    $proFile->url = $request->file_url[$key];
                    $proFile->ref_product_id = $id;
                    $proFile->save();
                }
            }
            
            if(!@$request->last_gallery){
                $request->last_gallery = [];
            }

            $gallery = ProductGallery::where('ref_product_id',$id)->WhereNotIn('id',$request->last_gallery)->get();
            ProductGallery::where('ref_product_id',$id)->WhereNotIn('id',$request->last_gallery)->delete();

            if(@$request->file_gallery_name){
                // return $request->file_gallery_name;
                $gallery = explode(',',$request->file_gallery_name);
                // return $gallery;
                foreach($gallery as $gall){
                    $Pgallery = new ProductGallery;
                    $Pgallery->image_name = $gall;
                    $Pgallery->ref_product_id = $product->id;
                    $Pgallery->save();
                }
            }
            ProductFile::where('file_name',null)->where('url',null)->delete();

            if(@$gallery){
                foreach($gallery as $unlink){
                    @unlink("$path/gallerys/$unlink->image_name");
                }
            }

            ProductsOptionHead::where('product_id',$product->id)->delete();
            ProductsOption1::where('product_id',$product->id)->delete();
            ProductsOption2::where('product_id',$product->id)->delete();
            ProductskUModel::where('ref_product_id',$product->id)->delete();

            if (!empty($request->input('option_title'))) {
                foreach ($request->input('option_title') as $key => $_option_title) {
                
                    $products_option_head1 = new ProductsOptionHead();
                    $products_option_head1->product_id = $product->id;
                    $products_option_head1->option_type = $key + 1;
                    $products_option_head1->name_th = $_option_title;
                    $products_option_head1->name_en = $_option_title;
                    $products_option_head1->save();
                }
            }
            $array_max_min = array();
            $id_option_1 = array();
            $id_option_2 = array();
    
            if (!empty($request->input('option_detail'))) {
                foreach ($request->input('option_detail') as $key => $_option_detail) {
                    $products_option_1 = new ProductsOption1();
                    $products_option_1->product_id = $product->id;
                    $products_option_1->name_th = $_option_detail;
                    $products_option_1->name_en = $_option_detail;

                    if ($request->hasFile('option_detail_file')) {
                        $file1 = $request->file('option_detail_file')[$key];
                        $nameExtension1 = $file1->getClientOriginalName();
                        $extension1 = $file1->getClientOriginalExtension();
                        $img_name1 = pathinfo($nameExtension1, PATHINFO_FILENAME);
                        $timestamp1 = now()->timestamp;
                        $img_name1 = $img_name1 . '_' . $timestamp1;
                        
                        $path = "upload/product/";
                        $option_detail_file1 = $img_name1 . '.' . $extension1;
                        $counter1 = 1;
                        while (file_exists($path . $option_detail_file1)) {
                            $option_detail_file1 = $img_name1 . '_' . $counter1 . '.' . $extension1;
                            $counter1++;
                        }
                        $file1->move($path, $option_detail_file1);
                        $products_option_1->img = $option_detail_file1;
                    }else{
                        if (!is_null($request->input('option_detail_file_1_img')) && isset($request->input('option_detail_file_1_img')[$key])) {
                            $option_detail_file1 = $request->input('option_detail_file_1_img')[$key];
                            $products_option_1->img = $option_detail_file1;
                        }
                    }
                    
                    $products_option_1->save();
                    array_push($id_option_1, $products_option_1->id);
                }
            }
    
            if (!empty($request->input('option_detail_2'))) {
                foreach ($request->input('option_detail_2') as $key => $_option_detail_2) {
                    $products_option_2 = new ProductsOption2();
                    $products_option_2->product_id = $product->id;
                    $products_option_2->name_th = $_option_detail_2;
                    $products_option_2->name_en = $_option_detail_2;
                    if ($request->hasFile('option_detail_file_2') && $request->hasFile('option_detail_file_2')[$key]) {
                        $file2 = $request->file('option_detail_file_2')[$key];
                  
                        $nameExtension2 = $file2->getClientOriginalName();
                        $extension2 = $file2->getClientOriginalExtension();
                        $img_name2 = pathinfo($nameExtension2, PATHINFO_FILENAME);
                        $timestamp2 = now()->timestamp;
                        $img_name2 = $img_name2 . '_' . $timestamp2;
                        
                        $path = "upload/product/";
                        $option_detail_file2 = $img_name2 . '.' . $extension2;
                        $counter2 = 1;
                        while (file_exists($path . $option_detail_file2)) {
                            $option_detail_file2 = $img_name2 . '_' . $counter2 . '.' . $extension2;
                            $counter2++;
                        }
                        $file2->move($path, $option_detail_file2);
                    }else{
                        if (!is_null($request->input('option_detail_file_2_img')) && isset($request->input('option_detail_file_2_img')[$key])) {
                            $option_detail_file2 = $request->input('option_detail_file_2_img')[$key];
                            $products_option_2->img = $option_detail_file2;
                        }
                       
                    }
                    $products_option_2->save();
                    array_push($id_option_2, $products_option_2->id);
            }
        }
            if(!empty($request->input('option_detail')[0])){
             
                foreach ($request->input('option_detail') as $key_1 => $_option_detail) {
                    if(!empty($_option_detail) && !empty($request->input('option_detail_2')[0])){
                        foreach ($request->input('option_detail_2') as $key_2 => $_option_detail_2) {
                         
                            if(!empty($_option_detail_2)){
                                $products_option_2_items = new ProductskUModel();
                                $products_option_2_items->ref_product_id = $product->id;
                                $products_option_2_items->product_option_1_id = $id_option_1[$key_1];
                                $products_option_2_items->product_option_2_id = $id_option_2[$key_2];
                                $products_option_2_items->price_0 = (!empty(@$request->input('price')[$_option_detail][$_option_detail_2][0]) ? @$request->input('price')[$_option_detail][$_option_detail_2][0] : @$request->input('old_price')[$_option_detail][$_option_detail_2][0]);
                                $products_option_2_items->price_1 = (!empty(@$request->input('price1')[$_option_detail][$_option_detail_2][0]) ? @$request->input('price1')[$_option_detail][$_option_detail_2][0] : @$request->input('old_price1')[$_option_detail][$_option_detail_2][0]);
                                $products_option_2_items->price_2 = (!empty(@$request->input('price2')[$_option_detail][$_option_detail_2][0]) ? @$request->input('price2')[$_option_detail][$_option_detail_2][0] : @$request->input('old_price2')[$_option_detail][$_option_detail_2][0]);
                                $products_option_2_items->price_3 = (!empty(@$request->input('price3')[$_option_detail][$_option_detail_2][0]) ? @$request->input('price3')[$_option_detail][$_option_detail_2][0] : @$request->input('old_price3')[$_option_detail][$_option_detail_2][0]);
                                $products_option_2_items->product_qty = (!empty(@$request->input('stock')[$_option_detail][$_option_detail_2][0]) ? @$request->input('stock')[$_option_detail][$_option_detail_2][0] : @$request->input('old_stock')[$_option_detail][$_option_detail_2][0]);
                                $products_option_2_items->product_SKU = (!empty(@$request->input('sku')[$_option_detail][$_option_detail_2][0]) ? @$request->input('sku')[$_option_detail][$_option_detail_2][0] : @$request->input('old_sku')[$_option_detail][$_option_detail_2][0]);
                                $products_option_2_items->name_th = $_option_detail . ' ' . $_option_detail_2;
                                $products_option_2_items->name_en = $_option_detail . ' ' . $_option_detail_2;
                                $products_option_2_items->save();
                            }
                        }
                    }elseif(!empty($_option_detail)){
                        $key_2 = 0;
                        $products_option_2_items = new ProductskUModel();
                        $products_option_2_items->ref_product_id = $product->id;
                        $products_option_2_items->product_option_1_id = $id_option_1[$key_1];
                        $products_option_2_items->price_0 = (!empty(@$request->input('price')[$_option_detail][$key_2][0]) ? @$request->input('price')[$_option_detail][$key_2][0] : @$request->input('old_price')[$_option_detail][$key_2][0]);
                        $products_option_2_items->price_1 = (!empty(@$request->input('price1')[$_option_detail][$key_2][0]) ? @$request->input('price1')[$_option_detail][$key_2][0] : @$request->input('old_price1')[$_option_detail][$key_2][0]);
                        $products_option_2_items->price_2 = (!empty(@$request->input('price2')[$_option_detail][$key_2][0]) ? @$request->input('price2')[$_option_detail][$key_2][0] : @$request->input('old_price2')[$_option_detail][$key_2][0]);
                        $products_option_2_items->price_3 = (!empty(@$request->input('price3')[$_option_detail][$key_2][0]) ? @$request->input('price3')[$_option_detail][$key_2][0] : @$request->input('old_price3')[$_option_detail][$key_2][0]);
                        $products_option_2_items->product_qty = (!empty(@$request->input('stock')[$_option_detail][$key_2][0]) ? @$request->input('stock')[$_option_detail][$key_2][0] : @$request->input('old_stock')[$_option_detail][$key_2][0]);
                        $products_option_2_items->product_SKU = (!empty(@$request->input('sku')[$_option_detail][$key_2][0]) ? @$request->input('sku')[$_option_detail][$key_2][0] : @$request->input('old_sku')[$_option_detail][$key_2][0]);
                        $products_option_2_items->name_th = $_option_detail . ' ' . $key_2;
                        $products_option_2_items->name_en = $_option_detail . ' ' . $key_2;
                        $products_option_2_items->save();
                    }
                }
            }
            if(!is_null($request->file('product_image'))){
                @unlink("$path/$lastImage");
                $img->move($path, $product_image_name);
            }else{
                if(isset($product_image_name)){
                    @rename("upload/product/".$lastImage, "upload/product/".str_replace(' ','_',$request->product_image_name).'.'.pathinfo($lastImage, PATHINFO_EXTENSION));
                }
            }

            DB::commit();
            return redirect("admin/product/edit/$id")->with('message', 'Update product "'.$request->product_code.'" success');
        // } catch (QueryException $err) {
        //     DB::rollBack();
        // }
    }
    public function uploadGallery(Request $request)
    {
        if($request->file('file')){
    
            try{
                $img = $request->file('file');
                $nameExtension = $img->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/product/gallerys/";
                    if( file_exists($path.$nameExtension) )
                    {
                        $nameExtension = $img_name.$request->name.'.'.$extension;
                    }
                $img->move($path, $nameExtension);
    
                DB::commit();
            } catch (QueryException $err) {
                DB::rollBack();
            }
            finally{
    
                $message = "success";
    
            }

            return $nameExtension; 
        }
    }
    public function deleteGallery(Request $request){
        try{
                @unlink('upload/product/gallerys/'.$request->file);
            DB::commit();
        } catch (QueryException $err) {
            DB::rollBack();
        }
        return $request->file; 
    }
    public function gallery(Request $request,$id){
        
            try{
                $gallery = ProductGallery::where('ref_product_id',$id)->get();
                return $gallery;
                DB::commit();
            } catch (QueryException $err) {
                DB::rollBack();
            }
    }
    public function changeStatus(Request $request){
        try{
            Product::where('id',$request->id)->update(['status' => $request->status]);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function changeDescription(Request $request){
        try{
            Product::where('id',$request->id)->update([$request->field => $request->description]);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function subCateByCate($id){
        try{
            $result = SubCategory::where('ref_category_id',$id)->orderBy('sub_category_name','ASC')->get();
            return response($result);
        } catch (QueryException $err) {
            return response($err);
        }
    }
    public function getSeries($id){
        try{
            $result = Series::where('ref_sub_category_id',$id)->orderBy('series_name','ASC')->get();
            return response($result);
        } catch (QueryException $err) {
            return response($err);
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
    public function delete_sku($id)
    {
        $id = explode(',',$id);
        try{
            ProductskUModel::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function export_excel(Request $request)
    {
        ini_set('memory_limit', '1024M');
        
        $results = Product::selectRaw('products.*,categorys.category_name,categorys.category_color,sub_categorys.sub_category_name,series.series_name,brands.brand_name,products.product_qty');
            if(@$request->product_code){
                $results = $results->Where('product_code','LIKE','%'.$request->product_code.'%');
            }
            if(@$request->product_name){
                $results = $results->Where('product_name','LIKE','%'.$request->product_name.'%');
            }
            if(@$request->category_id){
                $results = $results->Where('products.ref_category_id',$request->category_id);
            }
            if(@$request->sub_category_id){
                $results = $results->Where('products.ref_sub_category_id',$request->sub_category_id);
            }
            if(@$request->product_recommended){
                $results = $results->Where('product_recommended',$request->product_recommended);
            }
            if(@$request->product_new){
                $results = $results->Where('product_new',$request->product_new);
            }
            if(@$request->product_hot){
                $results = $results->Where('product_hot',$request->product_hot);
            }
        $results = $results->leftJoin('categorys','categorys.id','=','products.ref_category_id')
                            ->leftJoin('sub_categorys','sub_categorys.id','=','products.ref_sub_category_id')
                            ->leftJoin('series','series.id','=','products.ref_series_id')
                            ->leftJoin('brands','brands.id','=','products.ref_brand_id')
                            // ->where('products.id',4660)
                            ->orderBy('id','DESC')
                            ->get();
        
        $data[] = [
                "Product Code"
                ,"Product name"
                ,"Product Recommended"
                ,"Product New"
                ,"Product Hot"
                ,"Price"
                ,"Discount Price (ไม่ต้องกรอกข้อมูล)"
                ,"Name image"
                ,"Version"
                ,"Weight"
                ,"Category"
                ,"Sub category"
                ,"Series"
                ,"Brand"
                ,"Product Size"
                ,"Product Color"
                ,"Detail"
                ,"Video"
                ,"Detailed Description"
                ,"Meta Title"
                ,"Meta Keywords"
                ,"Meta Description"
                ,"ID(ห้ามแก้ไข)"
               
              
            ];          
            $role_make = [];
            $role = Roles::get();
            foreach($role as $ro){
                $role_make[$ro->id] = $ro->role_name;
            }

            $size_make = [];
            $size = Size::get();
            foreach($size as $si){
                $size_make[$si->id] = $si->size_name;
            }

            $color_make = [];
            $color = Color::get();
            foreach($color as $col){
                $color_make[$col->id] = $col->color_name;
            }


            $product_code_make = [];
            $product_code = ProductCode::get();
            foreach($product_code as $pcm){
                $product_code_make[$pcm->ref_product_id][] = $size_make[$pcm->ref_size_id].'+'.$color_make[$pcm->ref_color_id].'='.$pcm->product_code;
            }
            // return $product_code_make;
            // return $product_code_make;

        foreach($results as $row){

            
            
            $product_recommended = $row->product_recommended;
            $product_new = $row->product_new;
            $product_hot = $row->product_hot;
            
            $product_sizes = explode(',', $row->product_sizes);

           
            $size_text = '';
            $commar = '';
            foreach($product_sizes as $k => $ps){
                if(!$ps){
                    continue;
                }
                if($k != 0){
                    $commar = ',';
                }
                if(array_key_exists($ps,$size_make)){
                    $size_text .= $commar.$size_make[$ps]; 
                }else{
                    $color_text .= 'null';
                }
              
              
            }
            $product_colors = explode(',', $row->product_colors);

            $color_text = '';
            $commar = '';
            foreach($product_colors as $k => $pc){
                if(!$pc){
                    continue;
                }
                if($k != 0){
                    $commar = ',';
                }
                
                if(array_key_exists($pc,$color_make)){
                    $color_text .= $commar.$color_make[$pc];
                }else{
                    $color_text .= 'null';
                }
              
            }
            // return $color_text;
            $product_code_text = $row->product_code.'||';
            if(@$product_code_make[$row->id]){
                $product_code_text .= implode(', ',$product_code_make[$row->id]);
            }
            // $product_code_text = '';
            // $commar = '';
            // foreach($product_code_make[$row->id] as $k => $pro_cm){
            //     if(!$pro_cm){
            //         continue;
            //     }
            //     if($k != 0){
            //         $commar = ',';
            //     }
            //     $commar.$pro_cm;
            // }

            $data[] = [
                $product_code_text
                ,$row->product_name
                ,$product_recommended
                ,$product_new
                ,$product_hot
                ,$row->product_price
                ,""
                ,$row->product_image
                ,$row->product_version
                ,$row->product_weight
                ,$row->category_name
                ,$row->sub_category_name
                ,$row->series_name
                ,$row->brand_name
                ,$size_text
                ,$color_text
                ,$row->product_detail
                ,$row->product_video
                ,""
                ,$row->meta_title
                ,$row->meta_keywords
                ,$row->meta_description
                ,$row->id
              
     
            ];
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new WriterXlsx($spreadsheet);
        $writer->save('excel_template/product_data_'.date('d-m-Y').'.xlsx');
        return redirect('excel_template/product_data_'.date('d-m-Y').'.xlsx');
    }

    public function export_excel_sku(Request $request)
    {
        ini_set('memory_limit', '1024M');
        
        $results = Product::selectRaw('products.*,productsku.id as productsku_id,productsku.product_SKU,productsku.product_qty,productsku.price_0,productsku.price_1,productsku.price_2,productsku.price_3,products.id,productsoption1.name_en as nameproductsoption1,productsoption2.name_en as nameproductsoption2');
        $results = $results->leftJoin('productsku','productsku.ref_product_id','=','products.id')
                            ->leftJoin('productsoption1','productsoption1.id','=','productsku.product_option_1_id')
                            ->leftJoin('productsoption2','productsoption2.id','=','productsku.product_option_2_id')
                            ->orderBy('id','DESC')
                            ->get();
        
        $data[] = [
                "Product name"
                ,"หัวข้อ(1)"
                ,"ตัวเลือก 1"
                ,"หัวข้อ(2)"
                ,"ตัวเลือก 2"
                ,"ราคาทั่วไป"
                ,"ราคาสมาชิก"
                ,"ราคาสมาชิก VIP"
                ,"ราคาโครงการ"
                ,"คลัง"
                ,"เลข SKU"
                ,"ID(ห้ามแก้ไข)"
                ,"ID SKU(ห้ามแก้ไข)"
            ];          
       

            foreach ($results as $row) {
                $productsoptionhead1 = DB::table('productsoptionhead')->where('product_id', $row->id)->where('option_type', 1)->first();
                $productsoptionhead2 = DB::table('productsoptionhead')->where('product_id', $row->id)->where('option_type', 2)->first();
            
                // Check if $productsoptionhead1 is not null before accessing its properties
                $nameproductsoption1 = $productsoptionhead1 ? $productsoptionhead1->name_th : '';
            
                // Check if $productsoptionhead2 is not null before accessing its properties
                $nameproductsoption2 = $productsoptionhead2 ? $productsoptionhead2->name_th : '';
            
                $data[] = [
                    $row->product_name,
                    $nameproductsoption1,
                    $row->nameproductsoption1,
                    $nameproductsoption2,
                    $row->nameproductsoption2,
                    $row->price_0,
                    $row->price_1,
                    $row->price_2,
                    $row->price_3,
                    $row->product_qty,
                    $row->product_SKU,
                    $row->id,
                    $row->productsku_id
                ];
            }
            
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data);

        $writer = new WriterXlsx($spreadsheet);
        $writer->save('excel_template/product_data_sku'.date('d-m-Y').'.xlsx');
        return redirect('excel_template/product_data_sku'.date('d-m-Y').'.xlsx');
    }
    public function importExcel_sku(Request $request){
        // return 5;
        try {

            $targetPath = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('upload/', $targetPath);

            $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadSheet = $Reader->load('upload/'.$targetPath);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();
           
            foreach($spreadSheetAry as $key => $value){
                if($key==0){ continue; }
                if($value[12]){
                    // continue;
                    $productsku = ProductskUModel::find($value[12]);
                    $productsku->price_0 = $value[5];
                    $productsku->price_1 = $value[6];
                    $productsku->price_2 = $value[7];
                    $productsku->price_3 = $value[8];
                    $productsku->product_qty = $value[9];
                    $productsku->product_SKU = $value[10];
                    $productsku->save();           
                }
              
            }
          
            DB::commit();

            return response(true);
       
    
    } catch (QueryException $err) {
        DB::rollBack();
    }
}
    public function importExcel(Request $request){
        // return 5;
        try {

            $targetPath = $request->file('file')->getClientOriginalName();
            $request->file('file')->move('upload/', $targetPath);

            $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            $spreadSheet = $Reader->load('upload/'.$targetPath);
            $excelSheet = $spreadSheet->getActiveSheet();
            $spreadSheetAry = $excelSheet->toArray();

            foreach($spreadSheetAry as $key => $value){
                if($key==0){ continue; }
                if($value[22]==''){ continue; }
                if($value[5]==''){ $value[5] = 0; }
                    // return $value[22].' 45';
                
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // if(@$value[10]){
                    $category = Category::where('category_name', $value[10])->first();

                    if(!$category){
                            $category_id = 0;
                        // continue;
                        $validate['category_not_found'][] = ['row' => $key+1 , 'name' => $value[10]];
                    }else{
                        $category_id = $category->id;
                    }
                // }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $sub_category_id = 0;
                // if(@$value[11]){
                    $sub_category = SubCategory::where('sub_category_name', $value[11])->first();

                    if(!$sub_category){
                        // continue;

                        $validate['sub_category_not_found'][] = ['row' => $key+1 , 'name' => $value[11]];
                    }else{
                        $sub_category_id = $sub_category->id;
                    }
                // }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $series_id = null;
                if(@$value[12]){
                    $series = Series::where('series_name', $value[12])->first();

                    if(!$series){

                            $series_id = 0;

                        $validate['series_not_found'][] = ['row' => $key+1 , 'name' => $value[12]];
                    }
                }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // if(@$value[13]){
                    $brand = Brand::where('brand_name', $value[13])->first();

                    if(!$brand){

                            $brand_id = 0;
                            // continue;

                        $validate['brand_not_found'][] = ['row' => $key+1 , 'name' => $value[13]];
                    }else{
                        $brand_id = $brand->id;
                    }
                // }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


                $product_code = explode(',', explode('||', str_replace(' ','',$value[0]))[1]);
                $product = array();
                if($value[22]){
                    if($value[2]){
                        $product['product_recommended'] = $value[2];
                    }else{
                        $product['product_recommended'] = 'N';
                    }

                    if($value[3]){
                        $product['product_new'] = $value[3];
                    }else{
                        $product['product_new'] = 'N';
                    }

                    if($value[4]){
                        $product['product_hot'] = $value[4];
                    }else{
                        $product['product_hot'] = 'N';
                    }

                    if(@$value[1]){
                        $product['product_name'] = $value[1];
                        
                    }
                    $product['product_code'] = trim(explode('||', $value[0])[0]);
                    $product['product_price'] = str_replace(',', '', $value[5]);
                    $product['product_version'] = $value[8];
                    $product['ref_category_id'] = $category_id;
                    $product['ref_sub_category_id'] = $sub_category_id;
                    $product['ref_series_id'] = $series_id;
                    $product['ref_brand_id'] = $brand_id;
                    $product['product_detail'] = $value[16];
                    $product['product_video'] = $value[17];
                    $product['meta_title'] = $value[19];
                    $product['meta_keywords'] = $value[20];
                    $product['meta_description'] = $value[21];
                    $check_product = DB::table('products')->where('id',$value[22])->first();

                    if(!empty($check_product)){
                        DB::table('products')->where('id',$value[22])->update($product);
                    }else{
                        $product['id'] = $value[22];
                        DB::table('products')->insert($product);
                    }
                }
               
            }
          
            DB::commit();
            return response(true);
    } catch (QueryException $err) {
        dd($err);
        DB::rollBack();
    }
}
}
