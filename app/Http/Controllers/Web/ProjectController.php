<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\ProjectCategory;
use App\ProjectGallery;
use App\Seo;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class ProjectController extends Controller
{
    public function index(Request $request){
        $data['meta'] = Seo::find(5);
        $project = Project::orderBy('id','DESC');
        if(@$request->cate_id){
            $project = $project->where('ref_category_id',$request->cate_id);
        }
        $data['project'] = $project->paginate(6);
        $data['category'] = ProjectCategory::orderBy('id','DESC')->get();
        return view('project', $data);
    }
    public function detail($id){
        $data['project'] = Project::find($id);
        $data['gallery'] = ProjectGallery::where('ref_project_id',$id)->get();
        $data['meta'] = (object)['meta_title' => $data['project']->meta_title , 'meta_keywords' => $data['project']->meta_keywords , 'meta_description' => $data['project']->meta_description];

        return view('project_detail', $data);
    }
}
