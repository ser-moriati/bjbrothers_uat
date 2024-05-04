<?php

namespace App\Http\Controllers;

use App\SubCategory;
use App\Series;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
DB::beginTransaction();

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['module'] = 'subcategory';
        $data['asset'] = asset('/');
        $data['page'] = 'Sub category';
        $data['page_url'] = 'subcategory';
        $data['category'] = Category::orderBy('sort','ASC')->get();


        ////// count จำนวน sub_category ในแต่ละ category
        $categoryCount = SubCategory::selectRaw('ref_category_id,count(id) as count')->groupBy('ref_category_id')->get();
        $data['sort_count'] = [];
        foreach($categoryCount as $cate){
            $data['sort_count'][$cate->ref_category_id] = $cate->count;
        }
        ////// count จำนวน sub_category ในแต่ละ category



        $results = SubCategory::select('sub_categorys.*','categorys.category_name','categorys.category_color')
                                ->leftJoin('categorys','categorys.id','sub_categorys.ref_category_id')
                                ->orderBy('categorys.sort','ASC')->orderBy('sub_categorys.sort','ASC');
        if(@$request->sub_category_name){
            $results = $results->Where('sub_categorys.sub_category_name','LIKE','%'.$request->sub_category_name.'%');
        }
        if(@$request->category_id){
            $results = $results->Where('sub_categorys.ref_category_id', $request->category_id);
        }
        $results = $results->paginate(15);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $data['list_data'] = $results;
        $dataPaginate = $results->toArray();
        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/sub_categorys/index', $data);
    }
    public function add()
    {
        $data['asset'] = asset('/');
        $data['page_url'] = 'subcategory';
        $data['page_before'] = 'Sub category';
        $data['page'] = 'Add Sub category';
        $data['action'] = 'insert';
        $data['category'] = Category::orderBy('id','DESC')->get();
        $data['max_series_id'] = Series::max('id');

        return view('admin/sub_categorys/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_url'] = 'subcategory';
        $data['page_before'] = 'Sub category';
        $data['page'] = 'Edit Sub category';
        $data['action'] = "../update/$id";
        $data['category'] = Category::orderBy('id','DESC')->get();
        $data['sub_category'] = SubCategory::find($id);
        $data['max_series_id'] = Series::max('id');

        return view('admin/sub_categorys/add', $data);
    }

    public function insert(Request $request)
    {

        $file = $request->file('sub_category_image');
        $file_name = $file->getClientOriginalName();
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $sub_category_image_name = $request->sub_category_image_name.'.'.$extension;
        $file->move('upload/sub_category', $sub_category_image_name);

        $file2 = $request->file('sub_category_banner');
        $file2_name = $file2->getClientOriginalName();
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $sub_category_banner_name = $request->sub_category_banner_name.'.'.$extension;
        $file2->move('upload/sub_category/banner', $sub_category_banner_name);

        SubCategory::where('ref_category_id',$request->category_id)->increment('sort');

        try{
            $sub_category = new SubCategory;
            $sub_category->sub_category_code = $request->sub_category_code;
            $sub_category->sub_category_name = $request->sub_category_name;
            $sub_category->ref_category_id = $request->category_id;
            $sub_category->sub_category_image = $sub_category_image_name;
            $sub_category->sub_category_banner = $sub_category_banner_name;
            $sub_category->sub_category_detail = $request->sub_category_detail;
            $sub_category->sort = 1;
            $sub_category->old_sort = '';
            $sub_category->save();

            if(@$request->insert_series_name){
                foreach($request->insert_series_name as $insert_series_name){
                if($insert_series_name == null){
                    continue;
                }
                $series = new Series();
                $series->ref_sub_category_id = $sub_category->id;
                $series->series_name = $insert_series_name;
                $series->save();
                }
            }

            DB::commit();
            return redirect('admin/subcategory'.'?category_id='.$request->category_id)->with('message', 'Update product "'.$request->sub_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
            return $err;
        }
    }
    public function update(Request $request, $id)
    {
        // return $request;
        $sub_category = SubCategory::find($id);
        $last_sub_category_image = $sub_category->sub_category_image;
        $last_sub_category_banner = $sub_category->sub_category_banner;

        if(!is_null($request->file('sub_category_image'))){
            $file = $request->file('sub_category_image');
            $file_name = $file->getClientOriginalName();
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            // $img_name = pathinfo($file_name, PATHINFO_FILENAME);
            $sub_category_image_name = $request->sub_category_image_name.'.'.$extension;
        }else{
            if(pathinfo($last_sub_category_image, PATHINFO_FILENAME)!=$request->sub_category_image_name){
                $sub_category_image_name = str_replace(' ','_',$request->sub_category_image_name).'.'.pathinfo($last_sub_category_image, PATHINFO_EXTENSION);
            }
        }

        if(!is_null($request->file('sub_category_banner'))){
            $file2 = $request->file('sub_category_banner');
            $file2_name = $file2->getClientOriginalName();
            $extension = pathinfo($file2_name, PATHINFO_EXTENSION);
            // $img_name = pathinfo($file_name, PATHINFO_FILENAME);
            $sub_category_banner_name = $request->sub_category_banner_name.'.'.$extension;
        }else{
            if(pathinfo($last_sub_category_banner, PATHINFO_FILENAME)!=$request->sub_category_banner_name){
                $sub_category_banner_name = str_replace(' ','_',$request->sub_category_banner_name).'.'.pathinfo($last_sub_category_banner, PATHINFO_EXTENSION);
            }
        }
        try{

            $sub_category->sub_category_code = $request->sub_category_code;
            $sub_category->sub_category_name = $request->sub_category_name;
            $sub_category->ref_category_id = $request->category_id;
            $sub_category->sub_category_detail = $request->sub_category_detail;
            
            if(isset($sub_category_image_name)){
                $sub_category->sub_category_image = $sub_category_image_name;
            }
            if(isset($sub_category_banner_name)){
                $sub_category->sub_category_banner = $sub_category_banner_name;
            }
            $sub_category->save();
            if(@$request->insert_series_name){
                foreach($request->insert_series_name as $insert_series_name){
                    if($insert_series_name == null){
                        continue;
                    }
                    $series = new Series();
                    $series->ref_sub_category_id = $id;
                    $series->series_name = $insert_series_name;
                    $series->save();
                }
            }

            if(@$request->series_name){
                foreach($request->series_name as $key => $series_name){
                    $series = Series::find($key);
                    $series->ref_sub_category_id = $id;
                    $series->series_name = $series_name;
                    $series->save();
                }
            }



            if(!is_null($request->file('sub_category_image'))){
                @unlink("upload/category/$last_sub_category_image");
                $file->move('upload/sub_category', $sub_category_image_name);
            }else{
                if(pathinfo($last_sub_category_image, PATHINFO_FILENAME)!=$request->sub_category_image_name){
                    @rename("upload/sub_category/".$last_sub_category_image, "upload/category/".$sub_category_image_name);
                }
            }
            
            if(!is_null($request->file('sub_category_banner'))){
                @unlink("upload/category/$last_sub_category_banner");
                $file2->move('upload/sub_category/banner', $sub_category_banner_name);
            }else{
                if(pathinfo($last_sub_category_banner, PATHINFO_FILENAME)!=$request->sub_category_banner_name){
                    @rename("upload/sub_category/banner/".$last_sub_category_banner, "upload/sub_category/banner/".$sub_category_banner_name);
                }
            }
            DB::commit();
            return redirect("admin/subcategory/edit/$id")->with('message', 'Update product "'.$request->sub_category_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function changeSort(Request $request)
    {
        try{
            $sub_category = SubCategory::select('ref_category_id')->where('id',$request->id)->first();

            if($request->sort_more > $request->sort){
                SubCategory::whereBetween('sort',[$request->sort, $request->sort_more])->where('ref_category_id',$sub_category->ref_category_id)->decrement('sort');
            }else{
                SubCategory::whereBetween('sort',[$request->sort_more,$request->sort])->where('ref_category_id',$sub_category->ref_category_id)->increment('sort');
            }
            SubCategory::where('id',$request->id)->update(['sort'=>$request->sort_more]);
            DB::commit();
            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            $sub = SubCategory::wherein('id',$id)->get();
            $series = Series::wherein('ref_sub_category_id',$id)->get()->toArray();
            foreach($sub as $su){
                SubCategory::where('ref_category_id',$su->ref_category_id)->where('sort','>',$su->sort)->decrement('sort');
            }
            SubCategory::destroy($id);
            Series::destroy(array_column($series,'id'));
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy_series($id)
    {
        $id = explode(',',$id);
        try{
            Series::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function export_excel(Request $request)
    {
        
        $results = SubCategory::select('sub_categorys.*','categorys.category_name','categorys.category_color')
                                ->leftJoin('categorys','categorys.id','sub_categorys.ref_category_id')
                                ->orderBy('categorys.sort','ASC')->orderBy('sub_categorys.sort','ASC');
        if(@$request->sub_category_name){
            $results = $results->Where('sub_categorys.sub_category_name','LIKE','%'.$request->sub_category_name.'%');
        }
        if(@$request->category_id){
            $results = $results->Where('sub_categorys.ref_category_id', $request->category_id);
        }
        $results = $results->get();
        
        $data[] = [
                "Sort"
                ,"Name"
                ,"Category"
                ,"Series"
                ,"ID(ห้ามแก้ไข)"
            ];			
            $role_make = [];
            $role = Series::get();
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

            $price = ProductPrice::where('ref_product_id',$row->id)->get();
            $Discount = '';
            $commar = '';
            foreach($price as $k => $pr){
                if($k != 0){
                    $commar = ',';
                }
                $Discount .= $commar.$role_make[$pr->ref_role_id].'='.$pr->product_sale;
            }
            

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
                $size_text .= $commar.$size_make[$ps];
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
                $color_text .= $commar.$color_make[$pc];
            }
            // return $color_text;
            $product_code_text = '';
            if(@$product_code_make[$row->id]){
                $product_code_text = implode(', ',$product_code_make[$row->id]);
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
                ,$Discount
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
                ,$row->product_description
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
}
