<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Career;
DB::beginTransaction();

class CareerController extends Controller
{
    //
    public function module() {
        return 'career';
    } 

    public function index(Request $request){
        $data['module'] = $this->module();
        $data['page'] = 'Career';
        $data['page_url'] = $this->module();

        $results = Career::orderBy('id','DESC');
            if(@$request->position){
                $results = $results->Where('position','LIKE','%'.$request->position.'%');
            }
            if(@$request->description){
                $results = $results->Where('description','LIKE','%'.$request->description.'%');
            }
        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/careers/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Career';
        $data['page'] = 'Career Add';
        $data['page_url'] = $this->module();
        $data['action'] = "insert";
        $data['career']['detail'] = '<div class="txt-content">
                                        <p>ผู้สนใจสมัครด้วยตนเองหรือส่งจดหมาย พร้อมหลักฐานการสมัครงาน มายังแผนกทรัพยากรมนุษย์</p>
                                    </div>
                                    <ul class="career-contact">
                                        <li>บริษัท บี.เจ.บราเดอร์ส แอนด์ ซัน จำกัด</li>
                                        <li><i class="fas fa-map-marker-alt"></i>9-9/4,24-24/3 แยก 1-3-2, 1-3-4 ซอยเอกชัย 76 ถนนเอกชัย แขวงบางบอน <br>เขตบางบอน กรุงเทพฯ 10150</li>
                                        <li class="w-50"><i class="fas fa-phone-alt"></i><span>TEL. :</span>(+662) 451-1824-7</li>
                                        <li class="w-50"><i class="fas fa-fax"></i><span>FAX :</span>(+662) 451-1354</li>
                                        <li><i class="fas fa-envelope"></i><span>EMAIL :</span><a href="mailto:hr@bjbrothers.com">hr@bjbrothers.com</a></li>
                                    </ul>';

        return view('admin/careers/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Career';
        $data['page'] = 'Career Edit';
        $data['page_url'] = $this->module();
        $data['action'] = "../update/$id";

        $data['career'] = Career::find($id);

        $data['career']->workplace = explode('|i|',$data['career']->workplace);
        $data['career']->description = explode('|i|',$data['career']->description);

        return view('admin/careers/add', $data);
    }
    public function insert(Request $request)
    {
        // return $request;
        if($request->file('banner')){
            $file = $request->file('banner');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/career/";
            $banner_name = $request->banner_name.'.'.$extension;

        }
        
        $workplace = implode("|i|",$request->workplace);
        $description = implode("|i|",$request->description);

        try{
            $career = new Career;
            $career->position = $request->position;
            $career->workplace = $workplace;
            $career->description = $description;
            $career->detail = $request->detail;
            $career->banner = $banner_name;
            $career->meta_title = $request->meta_title;
            $career->meta_keywords = $request->meta_keywords;
            $career->meta_description = $request->meta_description;
            $career->save();
            DB::commit();
            if(@$file) $file->move($path, $banner_name);
            return redirect('admin/career')->with('message', 'Insert career "'.$request->position.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
// return 555;
            $career = Career::find($id);
            $path = "upload/career/";
            $lastBanner = $career->banner;

        if(!is_null($request->file('banner'))){
            $file = $request->file('banner');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $banner_name = $request->banner_name.'.'.$extension;

        }else{
            if(pathinfo($lastBanner, PATHINFO_FILENAME)!=$request->banner_name){
                $banner_name = str_replace(' ','_',$request->banner_name).'.'.pathinfo($lastBanner, PATHINFO_EXTENSION);
            }
        }
        
        $workplace = implode("|i|",$request->workplace);
        $description = implode("|i|",$request->description);
        try{
            $career->position = $request->position;
            $career->workplace = $workplace;
            $career->description = $description;
            $career->detail = $request->detail;
            if(isset($banner_name)){
                $career->banner = $banner_name;
            }
            $career->meta_title = $request->meta_title;
            $career->meta_keywords = $request->meta_keywords;
            $career->meta_description = $request->meta_description;
            $career->save();

            if(!is_null($request->file('banner'))){
                @unlink("$path/$lastBanner");
                $file->move($path, $banner_name);
            }else{
                if(pathinfo($lastBanner, PATHINFO_FILENAME)!=$request->banner_name){
                    @rename($path.$lastBanner, $path.$banner_name);
                }
            }
            DB::commit();
            return redirect("admin/career/edit/$id");
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            Career::destroy($id);
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
