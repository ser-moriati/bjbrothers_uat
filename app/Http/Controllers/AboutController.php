<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\About;
use App\AboutCompany;
use App\AboutCategoryCustomer;
use App\AboutFile;
use App\AboutGallery;
use App\AboutCustomer;
use App\AboutCertificate;
use App\AboutHoliday;
use App\AboutMap;
use App\AboutService;
use DateTime;
use Session;
use Response;
use Datatables;
DB::beginTransaction();

class AboutController extends Controller
{
    //
    
    public function moduleCompany() {
        return 'company';
    } 
    public function moduleService() {
        return 'service';
    } 
    public function moduleCateaboutcustomer() {
        return 'aboutcatecustomer';
    } 
    public function moduleAboutCustomer(){
        return 'aboutcustomer';
    }
    public function moduleAboutCertificate(){
        return 'certificate';
    }
    public function moduleAboutHoliday(){
        return 'holiday';
    }
    public function moduleMap() {
        return 'map';
    } 
    // public function module() {
    //     return 'home';
    // } 
    public function companyIndex(Request $request){
        $data['module'] = $this->moduleCompany();
        $data['page'] = 'Company';
        $data['page_url'] = $this->moduleCompany();
        $data['action'] = "company_detail/1";

        $results = AboutCompany::orderBy('about_company_year','ASC')->paginate(10);
        $data['about'] = About::first();

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/abouts/company/index', $data);

    }
    public function serviceIndex(Request $request){
        $data['module'] = $this->moduleService();
        $data['page'] = 'Service';
        $data['page_url'] = $this->moduleService();
        $data['action'] = "service/update/1";

        $data['about_service'] = AboutService::first();


        return view('admin/abouts/service/index', $data);

    }
    public function companyAdd(){

        $data['page_before'] = 'Company';
        $data['page'] = 'Add';
        $data['page_url'] = 'Add';
        $data['action'] = "insert";
        // $data['about'] = About::find(9);
        return view('admin/abouts/company/add', $data);
    }
    public function companyInsert(Request $request)
    {
        try{
            $about_company = new AboutCompany;
            $about_company->about_company_year = (!empty($request->about_company_year) ? $request->about_company_year : '');
            $about_company->about_company_detail = (!empty($request->about_company_detail) ? $request->about_company_detail : '');
            $about_company->save();

            DB::commit();
            return redirect('admin/about/company')->with('message', 'Insert company "'.$request->about_company_year.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function companyEdit($id)
    {
        $data['page_before'] = 'Company';
        $data['page'] = 'Edit';
        $data['page_url'] = 'about';
        $data['action'] = "../update/$id";

        $data['about_company'] = AboutCompany::find($id);

        return view('admin/abouts/company/add', $data);
    }
    public function companyUpdate(Request $request, $id)
    {
        try{

            $about_company = AboutCompany::find($id);
            $about_company->about_company_year = (!empty($request->about_company_year) ? $request->about_company_year : '');
            $about_company->about_company_detail = (!empty($request->about_company_detail) ? $request->about_company_detail : '');
            $about_company->save();

            DB::commit();
            return redirect("admin/about/company/edit/$id")->with('message', 'Update company "'.$request->about_company_year.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function serviceUpdate(Request $request, $id)
    {
        try{
            // return 45;
            $detail = AboutService::find($id);
            $detail->detail = (!empty($request->detail) ? $request->detail : '');
            $detail->detail_2 = (!empty($request->detail_2) ? $request->detail_2 : '');
            $detail->detail_3 = (!empty($request->detail_3) ? $request->detail_3 : '');
            $detail->detail_4 = (!empty($request->detail_4) ? $request->detail_4 : '');
            $detail->save();

            DB::commit();
            return redirect("admin/about/service")->with('message', 'Update service success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function company_detail(Request $request, $id)
    {
        try{
            // return $request;
            $update = About::find($id);
            if(!is_null($request->file('chart'))){
                $img = $request->file('chart');
                $nameExtension = $img->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                // SA04074_หน้ากากกรองฝุ่น_1
                $path = "upload/about/";
                $chart_name = $nameExtension;
                // if( file_exists($path.$nameExtension) )
                //     {
                //         $nameExtension = $img_name.$request->position.'.'.$extension;
                //     }
            }

            // return $request;
            $update = About::find($id);
            $update->business = $request->business;
            $update->factory = $request->factory;
            if($request->file('chart')){
                @unlink("$path/$chart_name");
                $img->move($path, $chart_name);
                $update->chart = $chart_name;
            }
            $update->save();

            DB::commit();
            return redirect('admin/about/company')->with('message', 'Update About success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function companyDestroy($id)
    {
        $id = explode(',',$id);
        try{
            AboutCompany::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function catecustomerIndex(Request $request){
        $data['module'] = $this->moduleCateaboutcustomer();
        $data['page'] = 'Category customer us';
        $data['page_url'] = $this->moduleCateaboutcustomer();

        $results = AboutCategoryCustomer::orderBy('id','DESC')->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/abouts/catecustomer/index', $data);

    }
    public function catecustomerAdd(){

        $data['page_before'] = 'Category customer us';
        $data['page'] = 'Add';
        $data['page_url'] = 'Add';
        $data['action'] = "insert";
        // $data['about'] = About::find(9);
        return view('admin/abouts/catecustomer/add', $data);
    }
    public function catecustomerInsert(Request $request)
    {
        try{
            $about_aboutcatecustomer = new AboutCategoryCustomer;
            $about_aboutcatecustomer->about_category_customer_name = (!empty($request->about_category_customer_name) ? $request->about_category_customer_name : '');
            $about_aboutcatecustomer->save();

            DB::commit();
            return redirect('admin/about/aboutcatecustomer')->with('message', 'Insert catecustomer "'.$request->about_category_customer_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function catecustomerEdit($id)
    {
        $data['page_before'] = 'Category customer us';
        $data['page'] = 'Edit';
        $data['page_url'] = 'about';
        $data['action'] = "../update/$id";

        $data['about_aboutcatecustomer'] = AboutCategoryCustomer::find($id);

        return view('admin/abouts/catecustomer/add', $data);
    }
    public function catecustomerUpdate(Request $request, $id)
    {
        try{

            $about_aboutcatecustomer = AboutCategoryCustomer::find($id);
            $about_aboutcatecustomer->about_category_customer_name = (!empty($request->about_category_customer_name) ? $request->about_category_customer_name : '');
            $about_aboutcatecustomer->save();

            DB::commit();
            return redirect("admin/about/aboutcatecustomer/edit/$id")->with('message', 'Update catecustomer "'.$request->about_category_customer_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function catecustomerDestroy($id)
    {
        $id = explode(',',$id);
        try{
            AboutCategoryCustomer::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function aboutcustomerIndex(Request $request){
        $data['module'] = $this->moduleAboutCustomer();
        $data['page'] = 'about customer us';
        $data['page_url'] = $this->moduleAboutCustomer();
        $category = AboutCategoryCustomer::get();
        $data['category'] = $category;

        $results = AboutCustomer::select('about_customers.*','about_category_customers.about_category_customer_name as category_name');

        if(@$request->about_customer_name){
            $results = $results->Where('about_customer_name','LIKE','%'.$request->about_customer_name.'%');
        }
        if(@$request->ref_category_id){
            $results = $results->Where('ref_category_id', $request->ref_category_id);
        }
        $results = $results->leftJoin('about_category_customers','about_category_customers.id','about_customers.ref_category_id')
        ->orderBy('id','DESC')
        ->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/abouts/customer/index', $data);

    }
    public function aboutcustomerAdd(){

        $data['page_before'] = 'about customer us';
        $data['page'] = 'Add';
        $data['page_url'] = 'Add';
        $data['action'] = "insert";
        $category = AboutCategoryCustomer::get();
        $data['category'] = $category;
        // $data['about'] = About::find(9);
        return view('admin/abouts/customer/add', $data);
    }
    public function aboutcustomerInsert(Request $request)
    {
        $nameExtension = '';
        if($request->file('about_customer_image')){
            $file = $request->file('about_customer_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/about/aboutcustomer/";
            $about_customer_image_name = $request->about_customer_image_name.'.'.$extension;

        }
        try{
            $about_aboutcustomer = new AboutCustomer;
            $about_aboutcustomer->about_customer_name = (!empty($request->about_customer_name) ? $request->about_customer_name : '');
            $about_aboutcustomer->about_customer_image = $about_customer_image_name;
            $about_aboutcustomer->ref_category_id = (!empty($request->category_id) ? $request->category_id : '');
            $about_aboutcustomer->save();

            if(@$file) $file->move($path, $about_customer_image_name);
            DB::commit();
            return redirect('admin/about/aboutcustomer')->with('message', 'Insert customer "'.$request->about_customer_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function aboutcustomerEdit($id)
    {
        $data['page_before'] = 'about customer us';
        $data['page'] = 'Edit';
        $data['page_url'] = 'about';
        $data['action'] = "../update/$id";
        $category = AboutCategoryCustomer::get();
        
        $data['category'] = $category;
        $data['about_customer'] = AboutCustomer::find($id);

        return view('admin/abouts/customer/add', $data);
    }
    public function aboutcustomerUpdate(Request $request, $id)
    {
        
        try{
            $about_aboutcustomer = AboutCustomer::find($id);
            $last_about_customer_image = $about_aboutcustomer->about_customer_image;
            $path = "upload/about/aboutcustomer/";

            if($request->file('about_customer_image')){
                $file = $request->file('about_customer_image');
                $nameExtension = $file->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $about_customer_image_name = $request->about_customer_image_name.'.'.$extension;
            }else{
                if(pathinfo($last_about_customer_image, PATHINFO_FILENAME)!=$request->about_customer_image_name){
                    $about_customer_image_name = str_replace(' ','_',$request->about_customer_image_name).'.'.pathinfo($last_about_customer_image, PATHINFO_EXTENSION);
                }
            }

            $about_aboutcustomer->about_customer_name = (!empty($request->about_customer_name) ? $request->about_customer_name : '');
            if($about_customer_image_name){
                $about_aboutcustomer->about_customer_image = $about_customer_image_name;
            }
            $about_aboutcustomer->ref_category_id = (!empty($request->category_id) ? $request->category_id : '');
            $about_aboutcustomer->save();

            if(@$file) {
                @unlink("$path/$last_about_customer_image");
                $file->move($path, $about_customer_image_name);
            }else{
                if(pathinfo($last_about_customer_image, PATHINFO_FILENAME)!=$request->about_customer_image_name){
                    @rename($path.$last_about_customer_image, $path.$about_customer_image_name);
                }
            }
            DB::commit();
            return redirect("admin/about/aboutcustomer/edit/$id")->with('message', 'Update customer "'.$request->about_customer_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function aboutcustomerDestroy($id)
    {
        $id = explode(',',$id);
        try{
            $data = AboutCustomer::whereIn('id',$id)->get();
            foreach($data as $row){
                unlink('upload/about/aboutcustomer/'.$row->about_customer_image);
            }
            AboutCustomer::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function certificateIndex(Request $request){
        $data['module'] = $this->moduleAboutCertificate();
        $data['page'] = 'certificate';
        $data['page_url'] = $this->moduleAboutCertificate();

        $results = AboutCertificate::orderBy('id','DESC');

        if(@$request->about_certificate_name){
            $results = $results->Where('about_certificate_name','LIKE','%'.$request->about_certificate_name.'%');
        }
        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/abouts/certificate/index', $data);

    }
    public function certificateAdd(){

        $data['page_before'] = 'certificate';
        $data['page'] = 'Add';
        $data['page_url'] = 'Add';
        $data['action'] = "insert";
        return view('admin/abouts/certificate/add', $data);
    }
    public function certificateInsert(Request $request)
    {
        $nameExtension = '';
        if($request->file('about_certificate_image')){
            $file = $request->file('about_certificate_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/about/certificate/";
            $about_certificate_image_name = $request->about_certificate_image_name.'.'.$extension;
        }
        try{
            $about_certificate = new AboutCertificate;
            $about_certificate->about_certificate_name = $request->about_certificate_name;
            $about_certificate->about_certificate_image = $about_certificate_image_name;
            $about_certificate->save();

            DB::commit();
            if(@$file) $file->move($path, $about_certificate_image_name);
            return redirect('admin/about/certificate')->with('message', 'Insert certificate "'.$request->about_certificate_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function certificateEdit($id)
    {
        $data['page_before'] = 'certificate';
        $data['page'] = 'Edit';
        $data['page_url'] = 'about';
        $data['action'] = "../update/$id";
        
        $data['about_certificate'] = AboutCertificate::find($id);

        return view('admin/abouts/certificate/add', $data);
    }
    public function certificateUpdate(Request $request, $id)
    {
        $about_certificate = AboutCertificate::find($id);
        $last_about_certificate_image = $about_certificate->about_certificate_image;
        $path = "upload/about/certificate/";
        if($request->file('about_certificate_image')){
            $file = $request->file('about_certificate_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $about_certificate_image_name = $request->about_certificate_image_name.'.'.$extension;
        }else{
            if(pathinfo($last_about_certificate_image, PATHINFO_FILENAME)!=$request->about_certificate_image_name){
                $about_certificate_image_name = str_replace(' ','_',$request->about_certificate_image_name).'.'.pathinfo($last_about_certificate_image, PATHINFO_EXTENSION);
            }
        }
        try{

            $about_certificate->about_certificate_name = $request->about_certificate_name;
            if($about_certificate_image_name){
                $about_certificate->about_certificate_image = $about_certificate_image_name;
            }
            $about_certificate->save();

            if(@$file) {
                $file->move($path, $about_certificate_image_name);
            }else{
                if(pathinfo($last_about_certificate_image, PATHINFO_FILENAME)!=$request->about_certificate_image_name){
                    @rename($path.$last_about_certificate_image, $path.$about_certificate_image_name);
                }
            }
            DB::commit();
            return redirect("admin/about/certificate/edit/$id")->with('message', 'Update certificate "'.$request->about_certificate_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function certificateDestroy($id)
    {
        $id = explode(',',$id);
        try{
            $data = AboutCertificate::whereIn('id',$id)->get();
            AboutCertificate::destroy($id);
            foreach($data as $row){
                unlink('upload/about/certificate/'.$row->about_certificate_image);
            }
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function holidayIndex(Request $request){
        $data['module'] = $this->moduleAboutHoliday();
        $data['page_before'] = $this->moduleAboutHoliday();
        $data['page'] = 'holiday';
        $data['action'] = 'holiday/update/1';

        $data['page_url'] = $this->moduleAboutHoliday();

        $results = AboutHoliday::find(1);
        $results->about_holiday_name = explode('?|?',$results->about_holiday_name);
        $results->about_holiday_date = explode('?|?',$results->about_holiday_date);
        $data['holiday'] = $results;
        $data['holidaydate'] = $results;
        return view('admin/abouts/holiday/add', $data);

    }
    public function holidayUpdate(Request $request, $id)
    {
        try{
        // return $request->about_holiday_name;
        $about_holiday = AboutHoliday::find($id);
        $last_about_holiday_image = $about_holiday->about_holiday_image;
        $path = "upload/about/holiday/";


        if($request->file('about_holiday_image')){
            $file = $request->file('about_holiday_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $lastName = $about_holiday->about_holiday_image;
            $about_holiday_image_name = $request->about_holiday_image_name.'.'.$extension;


            $about_holiday_name = array_diff($request->about_holiday_name, [null]);
            $about_holiday_date = array_diff($request->about_holiday_date, [null]);

            $about_holiday->about_holiday_name = implode('?|?',$about_holiday_name);
            $about_holiday->about_holiday_date = implode('?|?',$about_holiday_date);
            if($about_holiday_image_name){
                $about_holiday->about_holiday_image = $about_holiday_image_name;
            }
            $about_holiday->save();
        }else{
            if(pathinfo($last_about_holiday_image, PATHINFO_FILENAME)!=$request->about_holiday_image_name){
                $about_holiday_image_name = str_replace(' ','_',$request->about_holiday_image_name).'.'.pathinfo($last_about_holiday_image, PATHINFO_EXTENSION);
            }
        }
            

            DB::commit();
            if(@$file) {
                @unlink("$path/$last_about_holiday_image");
                $file->move($path, $about_holiday_image_name);
            }else{
                if(pathinfo($last_about_holiday_image, PATHINFO_FILENAME)!=$request->about_holiday_image_name){
                    @rename($path.$last_about_holiday_image, $path.$about_holiday_image_name);
                }
            }

            for($i = 0; $i < count($request->input('about_holiday_name')); $i++) {
                $data5 = [     
                    'about_holidaysdate_name'                           =>   $request->input('about_holiday_name')[$i],
                    'about_holidaysdate_date'                           =>   $request->input('about_holiday_date')[$i],
                    'about_holidaysdate_created_at'	                    =>   new DateTime(),
                    'about_holidaysdate_updated_at'	                    =>   new DateTime(),
                ];
                DB::table('about_holidaysdate')->insert($data5);
            }
            return redirect("admin/about/holiday")->with('message', 'Update holiday success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy_holiday($id)
    {
       
        try{
            $data = DB::table('about_holidaysdate')->where('about_holidaysdate_id',$id)->delete();
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }

    public function insert_banner(Request $request)
    {
           
        try{
            $data3 = [
                'about_holidaysdate_name'		    =>  $request->input('about_holidaysdate_name'),
                'about_holidaysdate_date'	        =>  $request->input('about_holidaysdate_date'),
                'about_holidaysdate_created_at'	    =>  new DateTime(),
                'about_holidaysdate_updated_at'	    =>  new DateTime(),
            ];
            DB::table('about_holidaysdate')->insert($data3);
            DB::commit();
            
            return redirect('admin/about/holiday')->with('message', 'Insert banner success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function mapIndex(Request $request){
        $data['module'] = $this->moduleMap();
        $data['page'] = 'Map';
        $data['page_url'] = $this->moduleMap();
        $data['action'] = "map/update/1";

        $results = AboutMap::orderBy('id','ASC')->where('id','!=',1)->paginate(10);
        $data['about'] = AboutMap::find(1);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();

        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/abouts/map/index', $data);

    }

    public function mapAdd(){

        $data['page_before'] = 'Map';
        $data['page'] = 'Add';
        $data['page_url'] = 'Add';
        $data['action'] = "insert";
        // $data['about'] = About::find(9);
        return view('admin/abouts/map/add', $data);
    }
    public function mapInsert(Request $request)
    {
        try{
            $about_map = new AboutMap;
            $about_map->name = $request->name;
            $about_map->detail = $request->detail;
            $about_map->save();

            DB::commit();
            return redirect('admin/about/map')->with('message', 'Insert map "'.$request->about_map_year.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
public function mapEdit($id)
    {
        $data['page_before'] = 'Map';
        $data['page'] = 'Edit';
        $data['page_url'] = 'about';
        $data['action'] = "../update/$id";

        $data['about_map'] = AboutMap::find($id);

        return view('admin/abouts/map/add', $data);
    }
    public function mapUpdate(Request $request, $id)
    {
        try{
            // return $request;
            $update = AboutMap::find($id);
            if(!is_null($request->file('image'))){
                $img = $request->file('image');
                $nameExtension = $img->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                // SA04074_หน้ากากกรองฝุ่น_1
                $path = "upload/about/";
                $image_name = $nameExtension;
                // if( file_exists($path.$nameExtension) )
                //     {
                //         $nameExtension = $img_name.$request->position.'.'.$extension;
                //     }
            }

            // return $request;
            $update = AboutMap::find($id);
            $update->name = $request->name;
            $update->detail = $request->detail;
            // $update->factory = $request->factory;
            if($request->file('image')){
                @unlink("$path/$image_name");
                $img->move($path, $image_name);
                $update->image = $image_name;
            }
            $update->save();

            DB::commit();
            return redirect('admin/about/map')->with('message', 'Update About success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
public function map_detail(Request $request, $id)
    {
        try{
            // return $request;
            $update = About::find($id);
            if(!is_null($request->file('image'))){
                $img = $request->file('image');
                $nameExtension = $img->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                // SA04074_หน้ากากกรองฝุ่น_1
                $path = "upload/about/";
                $image_name = $nameExtension;
                // if( file_exists($path.$nameExtension) )
                //     {
                //         $nameExtension = $img_name.$request->position.'.'.$extension;
                //     }
            }

            // return $request;
            $update = About::find($id);
            $update->name = $request->name;
            // $update->factory = $request->factory;
            if($request->file('image')){
                @unlink("$path/$image_name");
                $img->move($path, $image_name);
                $update->image = $image_name;
            }
            $update->save();

            DB::commit();
            return redirect('admin/about/map')->with('message', 'Update About success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
public function mapDestroy($id)
    {
        $id = explode(',',$id);
        try{
            AboutCompany::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }


}
