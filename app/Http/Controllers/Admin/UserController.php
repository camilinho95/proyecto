<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    // List of users

    public function index(Request $request){
     
        if($request->ajax()){
            $users = User:: withTrashed()->orderBy('id', 'DESC')->paginate(4);
            
            return [
                'pagination' => [
                    'total' => $users->total(),
                    'current_page' => $users->currentPage(),
                    'per_page' => $users->perPage(),
                    'last_page' => $users->lastPage(),
                    'from' => $users->firstitem(),
                    'to' => $users->lastPage(),
                ],
                 'users' => $users
            ];
        }
        return view('admin.users.index');
    }     
    
    //Create a new user

    public function store(Request $request)
    {
        

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:6'],
            'role' => ['required', 'integer', 'max:255'],
        ];

        $messages = [
            'name.required' => 'Debes ingresar un nombre!',
            'name.string' => 'Solo se permiten letras en este campo!',
            'name.max' => 'El nombre es demasiado extenso',

            'email.required' => 'Debes ingresar un correo!',
            'email.string' => 'Solo se permiten letras en este campo!',
            'email.max' => 'El correo es demasiado extenso!',
            'email.email' => 'El correo ingresado es inválido!',
            'email.unique' => 'El correo ya se encuentra en uso!',

            'password.required' => 'Debes ingresar una contraseña!',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres!',

            'role.required' => 'Debes seleccionar un cargo!'
        ];

        $this->validate($request, $rules, $messages);
       
        if($request->ajax()){
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role = $request->input('role');
            $user->password = bcrypt($request->input('password'));
                
            $user->save();
            
                return response()->json([
                    "message" => "Usuario creado con éxito.",
                    "user" =>  $user
            ], 200);
        }
    }

    // Edit user's View

    public function edit($id)
    {        
        $user = User::find($id);         
        return $user;
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:6'],
            'role' => ['required', 'integer', 'max:255'],
        ];

        $messages = [
            'name.required' => 'Debes ingresar un nombre!',
            'name.string' => 'Solo se permiten letras en este campo!',
            'name.max' => 'El nombre es demasiado extenso',

            'password.required' => 'Debes ingresar una contraseña!',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres!',

            'role.required' => 'Debes seleccionar un cargo!'
        ];

        $this->validate($request, $rules, $messages);
       
        if($request->ajax()){
            
            $user = User::find($id);
            

            $user->name = $request->input('name');
            $user->role = $request->input('role');
            $user->password = bcrypt($request->input('password'));
                
            $user->save();
            
           return response()->json([
                    "message" => "Datos actualizados con éxito.",
                    "user" =>  $user
            ], 200);
        }
    }

    //Softdelete user

    public function destroy($id){
       $user = User::find($id);
       $user->delete();

       return response()->json([
        "message" => "Usuario inactivado con éxito.",
        "user" =>  $user
        ], 200);
    }

    // Restore user

    public function restore($id){
        $user = User:: onlyTrashed()->where('id', $id)->restore();

        return response()->json([
            "message" => "Usuario activado con éxito.",
            "user" =>  $user
            ], 200);
    }
}
