<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    
    use AuthenticatesUsers;

    protected $redirectTo = '/perfil';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /*
    public function redirectPath(){
        if (auth()->user()->role == 0) {
            return '/usuarios';
        }
        if (auth()->user()->role == 1) {
            return '/perfil';
        }
        return '/perfil';
    }
    */
    

}
