<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HrMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Comprobar si el usuario es autorizado y si es hr
        if (Auth::check() && Auth::user()->role === 'hr') {
            // Si sale verdadero, dejar entrar
            return $next($request);
        }

        // Si es un empleado, bloqueamos el acesso
        abort(403, 'Acceso denegado. Esta sección es solo para Recursos Humanos.');
    }
}
