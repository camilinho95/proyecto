<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SigController extends Controller
{

    public function index(){

     $idmanzanas = \DB::table('manzanaswgs84')->select('idmanzana')->get();

      return view('sig', compact($idmanzanas));
 
    }     
        
}
