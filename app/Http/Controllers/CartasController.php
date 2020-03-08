<?php

namespace App\Http\Controllers;

use App\Carta;
use App\Http\Controllers\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartasController extends Controller
{
   
    public function index(Request $request)
    {

        if($request->ajax()){
            $cartas = Carta::withTrashed()->orderBy('id', 'DESC')->get();            
            return $cartas;
        }
       return view('gestionar_cartas');
    }

    public function store(Request $request)
    {

        $rules = [
            'comuna' => ['required','size:2'],
            'barrio' => ['required','size:2'],      
            'manzana' => ['required', 'size:4'],
            'idmanzana' => ['required', 'size:8', 'unique:cartas'],
            'pdf' => ['required'],
            'dwg' => ['required'],
        ];
        
        $messages = [
            
            'comuna.required' => 'Debes ingresar el número de la comuna!',
            'comuna.size' => 'El número de la comuna debe tener 2 dígitos',

            'barrio.required' => 'Debes ingresar el número del barrio!',
            'barrio.size' => 'El número del barrio debe tener 2 dígitos',

            'manzana.required' => 'Debes ingresar el número de la manzana!',
            'manzana.size' => 'El número de la manzana debe tener 4 dígitos',

            'idmanzana.required' => 'El ID de la manzana es requerido!',
            'idmanzana.size' => 'El ID de la manzana debe tener 8 dígitos',   
            'idmanzana.unique' => 'Ya existe un registro con el mismo idmanzana',   
            
            'pdf.required' => 'El archivo en formato PDF es requerido!',
            // 'pdf.mimes' => 'El archivo seleccionado no está en formato PDF',

            'dwg.required' => 'El archivo en formato DWG es requerido!',         

        ];

        $this->validate($request, $rules, $messages);
       
        if($request->ajax()){

            $explodedPdf = explode(',', $request->pdf);
            $decodedPdf = base64_decode($explodedPdf[1]);

            $explodedDwg = explode(',', $request->dwg);
            $decodedDwg = base64_decode($explodedDwg[1]);

            $fileNamePdf = "";
            $fileNameDwg = "";

            // if (Str::contains($explodedPdf[0], 'pdf')) {
                $fileNamePdf = $request->input('idmanzana').'.pdf';
                $pathPdf = public_path().'/storage/'.$fileNamePdf;
                file_put_contents($pathPdf, $decodedPdf);
            // }
            // if (Str::contains($explodedDwg[0], 'dwg')) {
                $fileNameDwg = $request->input('idmanzana').'.dwg';
                $pathDwg = public_path().'/storage/'.$fileNameDwg;
                file_put_contents($pathDwg, $decodedDwg);
            // }

            $carta = new Carta();
            $carta->comuna = $request->input('comuna');
            $carta->barrio = $request->input('barrio');
            $carta->manzana = $request->input('manzana');
            $carta->idmanzana = $request->input('idmanzana');
            $carta->pdf = $fileNamePdf;
            $carta->dwg =  $fileNameDwg;

            $carta->save();
            
                return response()->json([
                    "message" => "Carta creada con éxito.",
                    "carta" =>  $carta
            ], 200);
        }
    }

    
    public function update(Request $request, $id)
    {
        $rules = [
            'comuna' => ['required','size:2'],
            'barrio' => ['required','size:2'],      
            'manzana' => ['required', 'size:4'],
            'idmanzana' => ['required', 'size:8', 'unique:cartas'],
            'pdf' => ['required'],
            'dwg' => ['required'],
        ];

        $messages = [
            'comuna.required' => 'Debes ingresar el número de la comuna!',
            'comuna.size' => 'El número de la comuna debe tener 2 dígitos',

            'barrio.required' => 'Debes ingresar el número del barrio!',
            'barrio.size' => 'El número del barrio debe tener 2 dígitos',

            'manzana.required' => 'Debes ingresar el número de la manzana!',
            'manzana.size' => 'El número de la manzana debe tener 4 dígitos',

            'idmanzana.required' => 'El ID de la manzana es requerido!',
            'idmanzana.size' => 'El ID de la manzana debe tener 8 dígitos',   
            'idmanzana.unique' => 'Ya existe un registro con el mismo idmanzana',   
            
            'pdf.required' => 'El archivo en formato PDF es requerido!',
            'dwg.required' => 'El archivo en formato DWG es requerido!',         

        ];

        $this->validate($request, $rules, $messages);
       
        if($request->ajax()){
            $explodedPdf = explode(',', $request->pdf);
            $decodedPdf = base64_decode($explodedPdf[1]);

            $explodedDwg = explode(',', $request->dwg);
            $decodedDwg = base64_decode($explodedDwg[1]);

            $fileNamePdf = "";
            $fileNameDwg = "";

            // if (Str::contains($explodedPdf[0], 'pdf')) {
                $fileNamePdf = $request->input('idmanzana').'.pdf';
                $pathPdf = public_path().'/storage/'.$fileNamePdf;
                file_put_contents($pathPdf, $decodedPdf);
            // }
            // if (Str::contains($explodedDwg[0], 'dwg')) {
                $fileNameDwg = $request->input('idmanzana').'.dwg';
                $pathDwg = public_path().'/storage/'.$fileNameDwg;
                file_put_contents($pathDwg, $decodedDwg);
            // }
            $carta = Carta::find($id);

            $carta->comuna = $request->input('comuna');
            $carta->barrio = $request->input('barrio');
            $carta->manzana = $request->input('manzana');
            $carta->idmanzana = $request->input('idmanzana');

            $carta->pdf = $fileNamePdf;
            $carta->dwg =  $fileNameDwg;
                            
            $carta->save();
            
            return response()->json([
                    "message" => "Datos actualizados con éxito.",
                    "carta" =>  $carta
            ], 200);
        }
    }

    public function destroy($id){
        $carta = Carta::find($id);
        $carta->delete();
 
        return response()->json([
         "message" => "Carta inactivada con éxito.",
         "carta" =>  $carta
         ], 200);
     }
 
     // Restore Carta
 
     public function restore($id){
         $carta = Carta:: onlyTrashed()->where('id', $id)->restore();
 
         return response()->json([
             "message" => "Carta activada con éxito.",
             "carta" =>  $carta
             ], 200);
     }
     

    //  Download carta
    public function download($name){
        return response()->download(public_path('/storage/'.$name),'');
    }

}
