<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function index(){
        return view('static.index');
    }

    public function contact(){
        return view('static.contact');
    }

    public function about(){
        return view('static.about');
    }
}
