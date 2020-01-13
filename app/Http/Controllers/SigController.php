<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SigController extends Controller
{

    public function index(){

     //$consult = \DB::table('manzanaswgs84')->select('geom')->get();
      
      //$consult = \DB::select('SELECT ST_AsGeoJSON(geom) FROM manzanaswgs84');


      return  view('sig');
 
    }     

    public function datos_sig(){
      
       // $consult = \DB::table('manzanaswgs84')->select('geom')->get();
      $consult = \DB::select('SELECT idmanzana, comuna, barrio, manzana, shape_area, (ST_AsGeoJSON(geom) ) AS geoJson FROM manzanaswgs84');


      return ($consult);
    }
}
