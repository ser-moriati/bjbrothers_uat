<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Faq;
DB::beginTransaction();

class FaqController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'faq';
        $data['asset'] = asset('/');
        $data['page'] = 'Faq';
        $data['page_url'] = 'faq';

        $data['lastSort'] = Faq::max('sort');
        $results = Faq::orderBy('sort','ASC');
        
        if(@$request->faq_question){
            $results = $results->Where('faq_question','LIKE','%'.$request->faq_question.'%');
        }
        if(@$request->faq_answer){
            $results = $results->Where('faq_answer','LIKE','%'.$request->faq_answer.'%');
        }

        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/faqs/index', $data);

    }
    public function add(){

        $asset = asset('/');
        $data['page_before'] = 'Faq';
        $data['page'] = 'Faq Add';
        $data['page_url'] = 'faq Add';
        $data['action'] = "insert";
        return view('admin/faqs/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Faq';
        $data['page'] = 'Faq Edit';
        $data['page_url'] = 'faq';
        $data['action'] = "../update/$id";
        $data['faq'] = Faq::find($id);

        return view('admin/faqs/add', $data);
    }
    public function insert(Request $request)
    {

        try{
            $lastSort = Faq::select('sort')->orderBy('sort','DESC')->first();

            $faq = new Faq;
            $faq->faq_question = $request->faq_question;
            $faq->faq_answer = $request->faq_answer;
            $faq->sort = $lastSort->sort+1;
            $faq->save();
            DB::commit();
            return redirect('admin/faq')->with('message', 'Insert faq "'.$request->faq_question.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        try{
            $faq = Faq::find($id);
            $faq->faq_question = $request->faq_question;
            $faq->faq_answer = $request->faq_answer;
            $faq->save();
            DB::commit();
            return redirect("admin/faq/edit/$id")->with('message', 'Update faq "'.$request->faq_question.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function changeSort(Request $request)
    {
        try{
            if($request->sort_more > $request->sort){
                Faq::whereBetween('sort',[$request->sort, $request->sort_more])->decrement('sort');
            }else{
                Faq::whereBetween('sort',[$request->sort_more,$request->sort])->increment('sort');
            }
            Faq::where('id',$request->id)->update(['sort'=>$request->sort_more]);
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
            $faq = Faq::select('sort')->whereIn('id',$id)->orderBy('sort','DESC')->get();
            Faq::destroy($id);
                // return $faq;
            foreach($faq as $row){
                Faq::where('sort','>',$row->sort)->decrement('sort');
            }
            // return 1;
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
