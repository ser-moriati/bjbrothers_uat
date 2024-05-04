<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Ecatalogue;
use Illuminate\Database\QueryException;

DB::beginTransaction();

class EcatalogueController extends Controller
{
    //
    public function index(Request $request){
        $data['module'] = 'ecatalogue';
        $data['asset'] = asset('/');
        $data['page'] = 'Ecatalogue';
        $data['page_url'] = 'ecatalogue';

        $results = Ecatalogue::orderBy('id','DESC');
            if(@$request->ecatalogue_name){
                $results = $results->Where('ecatalogue_name','LIKE','%'.$request->ecatalogue_name.'%');
            }
        $results = $results->paginate(10);

        $data['list_data'] = $results->appends(request()->query());
        $data['query'] = request()->query();
        $dataPaginate = $results->toArray();

        $data['num'] = $dataPaginate['from'];
        $data['from'] = $dataPaginate['from'];
        $data['to'] = $dataPaginate['to'];
        $data['total'] = $dataPaginate['total'];
        return view('admin/ecatalogues/index', $data);

    }
    public function add(){

        $data['page_before'] = 'Ecatalogue';
        $data['page'] = 'Ecatalogue Add';
        $data['page_url'] = 'ecatalogue Add';
        $data['action'] = "insert";
        return view('admin/ecatalogues/add', $data);
    }
    public function edit($id)
    {
        $data['asset'] = asset('/');
        $data['page_before'] = 'Ecatalogue';
        $data['page'] = 'Ecatalogue Edit';
        $data['page_url'] = 'ecatalogue';
        $data['action'] = "../update/$id";
        $data['ecatalogue'] = Ecatalogue::find($id);

        return view('admin/ecatalogues/add', $data);
    }
    public function insert(Request $request)
    {
            $path = "upload/ecatalogue/";

        if($request->file('ecatalogue_image')){
            $file = $request->file('ecatalogue_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                if( file_exists($path.$nameExtension) )
                {
                    $nameExtension = $img_name.$request->ecatalogue_title.'.'.$extension;
                }
        }
        if($request->file('ecatalogue_file')){
            $file_pdf = $request->file('ecatalogue_file');
            $nameExtension_pdf = $file_pdf->getClientOriginalName();
            $extension = pathinfo($nameExtension_pdf, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension_pdf, PATHINFO_FILENAME);
                if( file_exists($path.$nameExtension_pdf) )
                {
                    $nameExtension_pdf = $img_name.$request->ecatalogue_title.'.'.$extension;
                }
        }

        try{
            $ecatalogue = new Ecatalogue;
            $ecatalogue->ecatalogue_title = $request->ecatalogue_title;
            $ecatalogue->ecatalogue_image = @$nameExtension;
            $ecatalogue->ecatalogue_pdf_name = @$nameExtension_pdf;
            $ecatalogue->save();

            DB::commit();
            if(@$file) $file->move($path, $nameExtension);
            if(@$file_pdf) $file_pdf->move($path."pdf/", $nameExtension_pdf);
            return redirect('admin/ecatalogue')->with('message', 'Insert ecatalogue "'.$ecatalogue->ecatalogue_title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function update(Request $request, $id)
    {
        // return $request->file_gallery_name;
        $ecatalogue = Ecatalogue::find($id);

        $path = "upload/ecatalogue/";

        if(!is_null($request->file('ecatalogue_image'))){
            $file = $request->file('ecatalogue_image');
            $nameExtension = $file->getClientOriginalName();
            $extension = pathinfo($nameExtension, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension, PATHINFO_FILENAME);
                if( file_exists($path.$nameExtension) )
                {
                    $nameExtension = $img_name.$request->ecatalogue_title.'.'.$extension;
                }
                $lastImage = $ecatalogue->ecatalogue_image;
        }
        if(!is_null($request->file('ecatalogue_file'))){
            $file_pdf = $request->file('ecatalogue_file');
            $nameExtension_pdf = $file_pdf->getClientOriginalName();
            $extension = pathinfo($nameExtension_pdf, PATHINFO_EXTENSION);
            $img_name = pathinfo($nameExtension_pdf, PATHINFO_FILENAME);
                if( file_exists($path.$nameExtension_pdf) )
                {
                    $nameExtension_pdf = $img_name.$request->ecatalogue_title.'.'.$extension;
                }
                $lastImagePDF = $ecatalogue->ecatalogue_pdf_name;
        }
        try{

                $ecatalogue->ecatalogue_title = $request->ecatalogue_title;
            if(isset($nameExtension)){
                $ecatalogue->ecatalogue_image = $nameExtension;
            }
            if(isset($nameExtension_pdf)){
                $ecatalogue->ecatalogue_pdf_name = $nameExtension_pdf;
            }
            $ecatalogue->save();
            if(!is_null($request->file('ecatalogue_image'))){
                $file->move($path, $nameExtension);
                @unlink("$path/$lastImage");
            }
            if(!is_null($request->file('ecatalogue_file'))){
                $file_pdf->move($path."pdf/", $nameExtension_pdf);
                @unlink($path."pdf/$lastImagePDF");
            }
            DB::commit();
            return redirect("admin/ecatalogue/edit/$id")->with('message', 'Update ecatalogue "'.$ecatalogue->ecatalogue_title.'" success');
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
    public function destroy($id)
    {
        $id = explode(',',$id);
        try{
        $path = "upload/ecatalogue/";
            $ecatalogue = Ecatalogue::whereIn('id', $id)->get();
            Ecatalogue::destroy($id);
            foreach($ecatalogue as $ecat){
                @unlink("$path/$ecat->ecatalogue_image");
                @unlink($path."pdf/$ecat->ecatalogue_pdf_name");
            }
            DB::commit();
            return true;
        } catch (QueryException $err) {
            DB::rollBack();
        }
    }
}
