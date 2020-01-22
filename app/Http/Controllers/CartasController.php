<?php

namespace App\Http\Controllers;

use App\Cartas;
use Illuminate\Http\Request;

class CartasController extends Controller
{
   
    public function index()
    {
       return view('gestionar_cartas');
    }

    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        $rules = [
            'idManzana' => ['required', 'integer', 'min:8', 'max:8', 'unique:cartas'],
            'manzana' => ['required', 'integer','min:4', 'max:4'],
            'comuna' => ['required', 'integer','min:2', 'max:2'],
            'barrio' => ['required', 'integer','min:2', 'max:2'],
            'pdf' => ['required','mimes:pdf'],
            'cad' => ['required'],            
        ];

        $messages = [

            'idManzana.unique' => 'Ya existe un registro con este ID manzana',
            'idManzana.required' => 'El ID de la manzana es requerido!',
            'idManzana.integer' => 'Solo se permiten números en este campo!',
            'idManzana.max' => 'El ID de la manzana debe tener máximo 8 dígitos',
            'idManzana.min' => 'El ID de la manzana debe tener mínimo 8 dígitos',

            'manzana.required' => 'Debes ingresar el número de la manzana!',
            'manzana.integer' => 'Solo se permiten números en este campo!',
            'manzana.max' => 'El número de la manzana debe tener máximo 4 dígitos',
            'manzana.min' => 'El número de la manzana debe tener mínimo 4 dígitos',

            'comuna.required' => 'Debes ingresar el número de la comuna!',
            'comuna.integer' => 'Solo se permiten números en este campo!',
            'comuna.max' => 'El número de la comuna debe tener máximo 2 dígitos',
            'comuna.min' => 'El número de la comuna debe tener mínimo 2 dígitos',

            'barrio.required' => 'Debes ingresar el número del barrio!',
            'barrio.integer' => 'Solo se permiten números en este campo!',
            'barrio.max' => 'El número del barrio debe tener máximo 2 dígitos',
            'barrio.min' => 'El número del barrio debe tener mínimo 2 dígitos',

            'pdf.required' => 'El archivo PDF es requerido!',
            'pdf.mimes' => 'El archivo seleccionado debe estar en formato PDF!',

            'cad.required' => 'El archivo CAD es requerido!',

        ];

        $this->validate($request, $rules, $messages);
       
        if($request->ajax()){

            if ($request->hasFile('pdf')) {
                $archivoPdf = $request->file('pdf');
                $nombrePdf = time().$archivoPdf->getClientOriginalName();
                $archivoPdf->move(public_path().'/archivos/', $nombrePdf);
            }

            if ($request->hasFile('cad')) {
                $archivoCad = $request->file('cad');
                $nombreCad = time().$archivoCad->getClientOriginalName();
                $archivoCad->move(public_path().'/archivos/', $nombreCad);
            }

            $carta = new Cartas();
            $carta->idManzana = $request->input('idManzana');
            $carta->manzana = $request->input('manzana');
            $carta->comuna = $request->input('comuna');
            $carta->comuna = $request->input('barrio');
            $carta->pdf =  $nombrePdf;
            $carta->cad =  $nombreCad;


            $carta->save();
            
                return response()->json([
                    "message" => "Carta creada con éxito.",
                    "carta" =>  $carta
            ], 200);
        }
    }
    
    public function update(Request $request, Cartas $cartas)
    {
        //
    }

    public function destroy($id) 
    {
        //
    }
}
