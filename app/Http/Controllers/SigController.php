<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SigController extends Controller
{

    public function index(){

        $shape = \DB::table('manzanaswgs84')->select('geom')->get();
     
        return  $shape ;

    }     
}
