<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout
{
    public function handle(Request $request, Closure $next)
    {
        // Solo usuarios autenticados
        if (! $request->user()) {
            return $next($request);
        }

        $timeoutMinutes = (int) config('session.lifetime', 15);
        $timeout = $timeoutMinutes * 60;
        $last = session('lastActivityTime');

        if ($last && (time() - $last) > $timeout) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('status', 'Sesión cerrada por inactividad.');
        }

        // Actualizar timestamp de actividad
        session(['lastActivityTime' => time()]);

        return $next($request);
    }
}