<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sig;

class PerfilController extends Controller
{

    public function index(Request $request)
    {
        $shape = \DB::table('manzanaswgs84')->select('geom')->get();
      //  return view('perfil');

      return $shape;
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:6'],
        ];

        $messages = [
            'name.required' => 'Debes ingresar un nombre!',
            'name.string' => 'Solo se permiten letras en este campo!',
            'name.max' => 'El nombre es demasiado extenso',

            'password.required' => 'Debes ingresar una contraseña!',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres!',
        ];

        $this->validate($request, $rules, $messages);
       
        if($request->ajax()){
            
            $user = User::find($id);
            

            $user->name = $request->input('name');
            $user->password = bcrypt($request->input('password'));
                
            $user->save();
            
           return response()->json([
                    "message" => "Datos actualizados con éxito.",
                    "user" =>  $user
            ], 200);
        }
    }

    
}
