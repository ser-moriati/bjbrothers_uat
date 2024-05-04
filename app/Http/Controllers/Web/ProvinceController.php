<?php

namespace App\Http\Controllers\Web;

use App\Province;
use App\Amphures;
use App\District;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class ProvinceController extends Controller
{
    public function getProvince($id){

        try{
            $data = Province::where('geography_id',$id)->get();

            return response($data);
        } catch (QueryException $err) {
            return response($err);
        }
    }
    public function getAmphures($id){

        try{
            $data = Amphures::where('province_id',$id)->get();

            return response($data);
        } catch (QueryException $err) {
            return response($err);
        }
    }
    public function getDistrict($id){

        try{
            $data = District::where('amphure_id',$id)->get();

            return response($data);
        } catch (QueryException $err) {
            return response($err);
        }
    }
    public function getZipcode($id){

        try{
            $data = District::where('id',$id)->first()->zip_code;

            return response($data);
        } catch (QueryException $err) {
            return response($err);
        }
    }
}
