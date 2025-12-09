<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y tiene rol de admin
        if (!auth()->check() || (auth()->user()->role ?? null) !== 'admin') {
            // Redirigir a la página anterior con mensaje de error
            return redirect()->back()
                ->with('error', 'Acceso no autorizado. No tienes permisos para esta página.')
                ->withInput();
        }

        return $next($request);
    }
}
