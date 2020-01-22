<?php

namespace App\Http\Controllers;

use App\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function index()
    {
       return view('solicitar_carta');
    }

    public function solicitudes(){
        return view('gestionar_solicitud');
    }

    
    public function store(Request $request)
    {

    }

  public function resolverSolicitud(){

  }
}
