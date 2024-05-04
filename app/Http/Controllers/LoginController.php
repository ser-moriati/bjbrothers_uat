<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index(){
        $asset = asset('/');
        // return view('index', compact('asset'));
        return view('auth/login', compact('asset'));
    }
}
