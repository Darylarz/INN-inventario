<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\logcatModel;

class logcatMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log only write actions
        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            return $response;
        }

        try {
            $user = $request->user();
            logcatModel::create([
                'user_id' => $user ? $user->id : null,
                'accion' => strtolower($request->method()),
                'tipo_sujeto' => optional($request->route())->getActionMethod() ? $request->route()->getName() : null,
                'sujeto_id' => $request->route('id') ?? $request->route('inventario') ?? null,
                'descripcion' => json_encode($this->safePayload($request)),
                'ip' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 1000),
                'propiedades' => [
                    'route' => $request->route()?->getName(),
                    'uri' => $request->getPathInfo(),
                    'status' => $response->getStatusCode(),
                ],
            ]);
        } catch (\Throwable $e) {
            // don't break the request on logging failure
        }

        return $response;
    }

    protected function safePayload(Request $request)
    {
        $payload = $request->except(['_token', '_method', 'password', 'password_confirmation']);
        return $payload;
    }
}