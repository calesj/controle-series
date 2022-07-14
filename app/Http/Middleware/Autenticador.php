<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class Autenticador
{

    public function handle($request, Closure $next)
    {
        if (!$request->is('entrar', 'registrar') && !Auth::check()) {
            return redirect('/entrar');
        }

        return $next($request);
    }
}
