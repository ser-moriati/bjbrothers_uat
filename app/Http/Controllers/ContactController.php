<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Contact;
use App\Seo;
use Auth;

use DateTime;
use Session;
use Response;
use Datatables;
use File;
use Illuminate\Http\Request;
DB::beginTransaction();

class ContactController extends Controller
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
    //     return view('contact');
    // }
    public function module() {
        return 'contact';
    } 
    public function index()
    {
        $contact = Contact::first();
        $seo = Seo::where('module', $this->module())->first();
        $data['contact'] = $contact;
        
        $data['module'] = $this->module();
        $data['page'] = 'contact';
        $data['action'] = $this->module().'/update/'.$contact->id;
        $data['seo'] = $seo;
        $contact_social = DB::table('contact_social')->orderBy('contact_social_id','DESC');
        $results = DB::table('contact_social')->orderBy('contact_social_id','DESC');
        if(@$request->title){
            $results = $results->Where('contact_social_text','LIKE','%'.$request->title.'%');
        }
        if(@$request->detail){
            $results = $results->Where('contact_social_img','LIKE','%'.$request->detail.'%');
        }
    $results = $results->paginate(10);

    $data['list_data'] = $results->appends(request()->query());
    $data['query'] = request()->query();
    $dataPaginate = $results->toArray();
    $data['num'] = $dataPaginate['from'];
    $data['from'] = $dataPaginate['from'];
    $data['to'] = $dataPaginate['to'];
    $data['total'] = $dataPaginate['total'];
    $data['contact_social'] = $contact_social;
    $data['page_url'] = $this->module();
        return view('admin/contact/index', $data);
    }

    public function add(){

        $asset = asset('/');
        $data['page_before'] = 'contact';
        $data['page'] = 'contact Add';
        $data['page_url'] = $this->module();
        $data['action'] = "insert";

        return view('admin/contact/add', $data);
    }
    public function insert(Request $request)
    {
            $path = "upload/contact/";
        // return $request;
        if($request->file('title_image')){
            $file = $request->file('title_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $title_image_name = $request->title_image_name.'.'.$extension;
        }
        if($request->file('title_image1')){
            $file1 = $request->file('title_image1');
            $nameExtension1 = $file1->getClientOriginalName();
            $extension1 = pathinfo($nameExtension1, PATHINFO_EXTENSION);
            $img_name1 = pathinfo($nameExtension1, PATHINFO_FILENAME);
            $title_image_name1 = $request->title_image_name1.'.'.$extension1;
        }

        try{
            $data3 = [
                'contact_social_img'		                =>  $title_image_name,
                'contact_social_text'		                =>  $request->input('title'),
                'contact_social_img1'		                =>  $title_image_name1,
                'contact_social_created_at'	                =>  date("Y/m/d"),
                'contact_social_updated_at'	                =>  new DateTime(),
            ];
            DB::table('contact_social')->insert($data3);
            DB::commit();
            if(@$file) $file->move($path, $title_image_name);
            if(@$file1) $file1->move($path, $title_image_name1);
            return redirect('admin/contact')->with('message', 'Insert social icon "'.$request->title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function edit($id){
        $asset = asset('/');
        $data['page_before'] = 'contact';
        $data['page'] = 'contact Edit';
        $data['page_url'] = $this->module();
        $data['action'] = "Edit";    
        $contact_social = DB::table('contact_social')->where('contact_social_id',$id)->get();
        $data['row']= $contact_social;

    return view('admin/contact/edit', $data);
    }

    public function updatet_(Request $request)
    {
        
        try{
            $home = DB::table('contact_social')->where('contact_social_id',$request->input('id'))->get();
           
            foreach($home as $home){
            $lastName = $home->contact_social_img;
            $lastName1 = $home->contact_social_img1;
            }
          
            if(!is_null($request->file('contact_social_img'))){
                $img = $request->file('contact_social_img');
                $img_name = $img->getClientOriginalName();
                $extension = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_name = pathinfo($img_name, PATHINFO_FILENAME);
                $banner_name_name = $request->banner_name_name.'.'.$extension;
            }else{
                if(pathinfo($lastName, PATHINFO_FILENAME)!=$request->banner_name_name){
                    $banner_name_name = $request->banner_name_name.'.'.pathinfo($lastName, PATHINFO_EXTENSION);
                }
            }
            if(!is_null($request->file('contact_social_img1'))){
                $img1 = $request->file('contact_social_img1');
                $img_name1 = $img1->getClientOriginalName();
                $extension1 = pathinfo($img_name1, PATHINFO_EXTENSION);
                $img_name1 = pathinfo($img_name1, PATHINFO_FILENAME);
                $banner_name_name1 = $request->banner_name_name1.'.'.$extension1;
            }else{
                if(pathinfo($lastName1, PATHINFO_FILENAME)!=$request->banner_name_name1){
                    $banner_name_name1 = $request->banner_name_name1.'.'.pathinfo($lastName1, PATHINFO_EXTENSION);
                }
            }
       
            if(isset($banner_name_name)){
              
            $data3 = [
                'contact_social_img'		                =>  $banner_name_name,
                'contact_social_img1'		                =>  $banner_name_name1,
                'contact_social_text'		                =>  $request->input('text'),
                'contact_social_updated_at'	                =>  new DateTime(),
            ];
            }
        
            DB::table('contact_social')->where('contact_social_id',$request->input('id'))->update($data3);
            if(!is_null($request->file('contact_social_img'))){
                
                // return $banner_name_name;
                @unlink("upload/contact/$lastName");
                $img->move('upload/contact', $banner_name_name);
            }else{
                if(isset($banner_name_name)){
                    @rename("upload/contact/".$lastName, "upload/contact/".str_replace(' ','_',$request->banner_name_name).'.'.pathinfo($lastName, PATHINFO_EXTENSION));
                }
            }
            if(!is_null($request->file('contact_social_img1'))){
                
                // return $banner_name_name;
                @unlink("upload/contact/$lastName1");
                $img1->move('upload/contact', $banner_name_name1);
            }else{
                if(isset($banner_name_name1)){
                    @rename("upload/contact/".$lastName1, "upload/contact/".str_replace(' ','_',$request->banner_name_name1).'.'.pathinfo($lastName1, PATHINFO_EXTENSION));
                }
            }
            DB::commit();
            return redirect("admin/contact");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        try{
            $contact = Contact::find($id);
            $lastNameQr = $contact->line_qr;
            $lastNameMap = $contact->map_image;
            $path = "upload/contact/";

            if(!is_null($request->file('line_qr'))){
                $img_line_qr = $request->file('line_qr');
                $img_qr_name = $img_line_qr->getClientOriginalName();
                $extension = pathinfo($img_qr_name, PATHINFO_EXTENSION);
                $line_qr_name = $request->line_qr_name.'.'.$extension;
    
            }else{
                if(pathinfo($lastNameQr, PATHINFO_FILENAME)!=$request->line_qr_name){
                    $line_qr_name = str_replace(' ','_',$request->line_qr_name).'.'.pathinfo($lastNameQr, PATHINFO_EXTENSION);
                }
            }
            if(!is_null($request->file('map_image'))){
                $img_map_image = $request->file('map_image');
                $img_map_name = $img_map_image->getClientOriginalName();
                $extension = pathinfo($img_map_name, PATHINFO_EXTENSION);
                $map_image_name = $request->map_image_name.'.'.$extension;
    
            }else{
                if(pathinfo($lastNameMap, PATHINFO_FILENAME)!=$request->map_image_name){
                    $map_image_name = str_replace(' ','_',$request->map_image_name).'.'.pathinfo($lastNameMap, PATHINFO_EXTENSION);
                }
            }
            
            $contact->address = $request->address;
            $contact->business_hours = $request->business_hours;
            $contact->phone = $request->phone;
            $contact->mobile_phone = $request->mobile_phone;
            $contact->fax = $request->fax;
            $contact->email = $request->email;
            $contact->line_id = $request->line_id;
            
            if(isset($line_qr_name)){
                $contact->line_qr = $line_qr_name;
            }
            if(isset($map_image_name)){
                $contact->map_image = $map_image_name;
            }
            $contact->save();
            
            Seo::where('module',$this->module())->update([
                'meta_title' => $request->meta_title,
                'meta_keywords' => $request->meta_keywords,
                'meta_description' => $request->meta_description,
            ]);

            if(!is_null($request->file('line_qr'))){
                @unlink("upload/contact/$lastNameQr");
                $img_line_qr->move('upload/contact', $line_qr_name);
            }else{
                if(pathinfo($lastNameQr, PATHINFO_FILENAME)!=$request->line_qr_name){
                    @rename($path.$lastNameQr, $path.$line_qr_name);
                }
            }
            if(!is_null($request->file('map_image'))){
                @unlink("upload/contact/$lastNameMap");
                $img_map_image->move('upload/contact', $img_map_name);
            }else{
                if(pathinfo($lastNameMap, PATHINFO_FILENAME)!=$request->map_image_name){
                    @rename($path.$lastNameMap, $path.$map_image_name);
                }
            }
            DB::commit();
            return redirect("admin/contact");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function select_product(Request $request){
        $results = Product::select('id','product_code','product_name','product_image','product_price')->whereIn('id',$request->id)->get();
        return response($results);

    }
    public function contact_social()
    {
        $contact_social = DB::table('contact_social')->orderBy('contact_social_id','DESC');
      
        $data['contact_social'] = $contact_social;
        
        $data['module'] = $this->module();
        $data['page'] = 'contact';
        return view('admin/contact/index', $data);
    }
    public function destroy($id)
    {
       
        try{
            $data = DB::table('contact_social')->where('contact_social_id',$id)->delete();
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
