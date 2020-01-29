<?php

namespace App\Http\Controllers;

use App\Carta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartasController extends Controller
{
   
    public function index(Request $request)
    {

        if($request->ajax()){
            $cartas = Carta::all();            
            return $cartas;
        }
       return view('gestionar_cartas');
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {


        $rules = [
            'comuna' => ['required','size:2'],
            'barrio' => ['required','size:2'],      
            'manzana' => ['required', 'size:4'],
            'idmanzana' => ['required', 'size:8', 'unique:cartas'],
            // 'pdf' => ['required', 'mimes:pdf'],
            // 'dwg' => ['required'],
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
            
            // 'pdf.required' => 'El archivo en formato PDF es requerido!',
            // 'pdf.mimes' => 'El archivo seleccionado no está en formato PDF',

            // 'dwg.required' => 'El archivo en formato CAD es requerido!',         

        ];


        $this->validate($request, $rules, $messages);
       
        if($request->ajax()){
            
            $explodedPdf = explode(',',$request->pdf);
            $decodedPdf = base64_decode($explodedPdf[1]);
            $extension = 'pdf';
            $fileName = $explodedPdf.'.'.$extension;

            $path = public_path().'/archivos/'.$fileName;
            file_put_contents($path, $decodedPdf);

            $carta = new Carta();
            $carta->comuna = $request->input('comuna');
            $carta->barrio = $request->input('barrio');
            $carta->manzana = $request->input('manzana');
            $carta->idmanzana = $request->input('idmanzana');
            $carta->pdf =   $fileName;
            $carta->dwg =  'TODO';


            // if ($request->hasFile('pdf')) {
            //     $pdf = $request->file('pdf');
            //     $nombrePdf = time().$pdf->getClientOriginalName();
            //     $pdf->move(public_path().'/archivos/', $nombrePdf);
            //     $carta->pdf =  $nombrePdf;

            // }

            // if ($request->hasFile('dwg')) {
            //     $dwg = $request->file('dwg');
            //     $nombreCad = time().$dwg->getClientOriginalName();
            //     $dwg->move(public_path().'/archivos/', $nombreCad);
            //     $carta->dwg =  $nombreCad;

            // }

            $carta->save();
            
                return response()->json([
                    "message" => "Carta creada con éxito.",
                    "carta" =>  $carta
            ], 200);
        }
    }
    
    public function update(Request $request, Carta $cartas)
    {
        //
    }

    public function destroy($id) 
    {
        //
    }
}
