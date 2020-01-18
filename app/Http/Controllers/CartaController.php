<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartaController extends Controller
{
     public function solicitarCarta(Request $request){
      
        return view('solicitar_carta');       
    }
    

    public function gestionarSolicitud(Request $request){
      
        return view('gestionar_solicitud');       
    }
}
