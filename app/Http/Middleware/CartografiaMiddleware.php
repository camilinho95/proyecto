<?php

namespace App\Http\Middleware;

use Closure;

class CartografiaMiddleware
{
    
    public function handle($request, Closure $next)
    {
        if (! auth()->check())
             return redirect('login');

        if(auth()->user()->role != 2) //  No es cartografía
             return redirect('/perfil');
        
        return $next($request);
    }
}
