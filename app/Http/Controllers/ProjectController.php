<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Project;
use App\ProjectFile;
use App\ProjectGallery;
use App\ProjectCategory;
use App\SubCategory;
use App\Brand;
use App\Color;
use App\Size;
DB::beginTransaction();

class ProjectController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'project';
        $data['asset'] = asset('/');
        $data['page'] = 'Project';
        $data['page_url'] = 'project';

        $results = Project::selectRaw('projects.*,project_categorys.project_category_name');
            if(@$request->project_name){
                $results = $results->Where('project_name','LIKE','%'.$request->project_name.'%');
            }
        $results = $results->leftJoin('project_categorys','project_categorys.id','=','projects.ref_category_id')
                ->orderBy('id','DESC')
                ->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/projects/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Project';
        $data['page'] = 'Project Add';
        $data['page_url'] = 'project Add';
        $data['action'] = "insert";
        $data['project_category'] = ProjectCategory::orderBy('id','DESC')->get();
        return view('admin/projects/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Project';
        $data['page'] = 'Project Edit';
        $data['page_url'] = 'project';
        $data['action'] = "../update/$id";
        $data['project_category'] = ProjectCategory::orderBy('id','DESC')->get();
        $data['project'] = Project::find($id);
        $data['project']['gallerys'] = ProjectGallery::where('ref_project_id',$id)->get();

        return view('admin/projects/add', $data);
    }
    public function insert(Request $request)
    {
        if($request->file('project_image')){
            $file = $request->file('project_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            $path = "upload/project/";
            $project_image_name = $request->project_image_name.'.'.$extension;

        }

        try{
            $project = new Project;
            $project->project_name = $request->project_name;
            $project->project_owner = $request->project_owner;
            $project->project_address = $request->project_address;
            $project->project_detail = $request->project_detail;
            $project->project_image = @$project_image_name;
            $project->meta_title = $request->meta_title;
            $project->meta_keywords = $request->meta_keywords;
            $project->meta_description = $request->meta_description;
            $project->ref_category_id = $request->category_id;
            $project->save();
            if(@$request->file_gallery_name){
                $gallery = explode(',',$request->file_gallery_name);
                foreach($gallery as $gall){
                    $Pgallery = new ProjectGallery;
                    $Pgallery->image_name = $gall;
                    $Pgallery->ref_project_id = $project->id;
                    $Pgallery->save();
                }
            }
            DB::commit();
            if(@$file) $file->move($path, $project_image_name);
            return redirect('admin/project')->with('message', 'Insert project "'.$request->project_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;
        $project = Project::find($id);
        $lastTitleName = $project->project_image;

        $path = "upload/project/";

        if(!is_null($request->file('project_image'))){
            $file = $request->file('project_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
            
            $project_image_name = $request->project_image_name.'.'.$extension;
        }else{
            if(pathinfo($lastTitleName, PATHINFO_FILENAME)!=$request->project_image_name){
                $project_image_name = str_replace(' ','_',$request->project_image_name).'.'.pathinfo($lastTitleName, PATHINFO_EXTENSION);
            }
        }
        try{
            $project->project_name = $request->project_name;
            $project->project_owner = $request->project_owner;
            $project->project_address = $request->project_address;
            $project->project_detail = $request->project_detail;
            $project->meta_title = $request->meta_title;
            $project->meta_keywords = $request->meta_keywords;
            $project->meta_description = $request->meta_description;
            $project->ref_category_id = $request->category_id;
            if(isset($project_image_name)){
                $project->project_image = $project_image_name;
            }
            $project->save();

            
            if(!@$request->last_gallery){
                $request->last_gallery = [];
            }

            $gallery = ProjectGallery::where('ref_project_id',$id)->WhereNotIn('id',$request->last_gallery)->get();
            ProjectGallery::where('ref_project_id',$id)->WhereNotIn('id',$request->last_gallery)->delete();

            if(@$request->file_gallery_name){
                // return $request->file_gallery_name;
                $gallery = explode(',',$request->file_gallery_name);
                // return $gallery;
                foreach($gallery as $gall){
                    $Pgallery = new ProjectGallery;
                    $Pgallery->image_name = $gall;
                    $Pgallery->ref_project_id = $project->id;
                    $Pgallery->save();
                }
            }

            if(@$gallery){
                foreach($gallery as $unlink){
                    // echo "$path/gallerys/$unlink->image_name";
                    @unlink("$path/gallerys/$unlink->image_name");
                }
            }

            if(!is_null($request->file('project_image'))){
                @unlink("$path/$lastTitleName");
                $file->move($path, $project_image_name);
            }else{
                if(pathinfo($lastTitleName, PATHINFO_FILENAME)!=$request->project_image_name){
                    @rename($path.$lastTitleName, $path.$project_image_name);
                }
            }

            DB::commit();
            return redirect("admin/project/edit/$id")->with('message', 'Update project "'.$request->project_name.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function uploadGallery(Request $request)
    {
        if($request->file('file')){
    
            try{
                $img = $request->file('file');
                $nameExtension = $img->getClientOriginalName();
                $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
                $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                $path = "upload/project/gallerys/";
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
                    @unlink('upload/project/gallerys/'.$request->file);
                DB::commit();
            } catch (QueryException $err) {
                DB::rollBack();
            }
            return $request->file; 
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
            $galleryGet = ProjectGallery::whereIn('ref_project_id',$id)->get();
            ProjectGallery::whereIn('ref_project_id',$id)->delete();
            Project::destroy($id);
            
            foreach($galleryGet as $unlink){
                @unlink('upload/project/gallerys/'.$unlink->image_name);
            }
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
