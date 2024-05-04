<?php

namespace App\Http\Controllers\Web;

use App\Subscribe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

DB::beginTransaction();
// DB::beginTransaction();

class SubscribeController extends Controller
{
    public function insert(Request $request){

        try{
            $subscribe = new Subscribe;
            $subscribe->email = $request->email;
            $subscribe->save();

            DB::commit();

            return response(true);
        } catch (QueryException $err) {
            DB::rollBack();
            return response($err);
        }
    }
}
