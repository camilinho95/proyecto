<?php

namespace App\Http\Controllers;

use App\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
        //   $cartas = \DB::table('cartas')->SELECT('idmanzana', 'manzana', 'comuna', 'barrio')->limit(5)->get();
        $cartas = \DB::table('cartas')->SELECT('idmanzana', 'manzana', 'comuna', 'barrio','pdf','dwg')->get();

          return $cartas;
        }
        return view('solicitar_carta');
    }


    public function solicitudes(Request $request){
        if($request->ajax()){
            $results = \DB::select('select * from solicituds');
            return $results;

            
        }

        return view('gestionar_solicitud');
    }
   
    public function getFiles($idmanzana){
        $idmanzana = \DB::table('cartas')->select('pdf','dwg')->where('idmanzana', $idmanzana)->get();
        return $idmanzana;
    }
    
    public function store(Request $request)
    {
       
        if($request->ajax()){
            $solicitud = new Solicitud();
            $solicitud->comuna = $request->input('comuna');
            $solicitud->barrio = $request->input('barrio');                
            $solicitud->manzana = $request->input('manzana');  
            $solicitud->idmanzana = $request->input('idmanzana');
            $solicitud->estado = $request->input('estado');                
            $solicitud->comentario = $request->input('comentario');                
            $solicitud->save();
            
                return response()->json([
                    "message" => "Solicitud creada con éxito.",
                    "solicitud" =>  $solicitud
            ], 200);
        }

    }

  public function resolverSolicitud(Request $request, $id){

    if($request->ajax()){
        
        $solicitud = Solicitud::find($id);
        

        $solicitud->comuna = $request->input('comuna');
        $solicitud->barrio = $request->input('barrio');
        $solicitud->manzana = $request->input('manzana');
        $solicitud->idmanzana = $request->input('idmanzana');
        $solicitud->estado = $request->input('estado');
        $solicitud->comentario = $request->input('comentario');
            
        $solicitud->save();
        
       return response()->json([
                "message" => "Solicitud resuelta con éxito.",
                "solicitud" =>  $solicitud
        ], 200);
    }      
  }
}
