<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Verificar si el usuario está autenticado
            if (!$request->user()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token no válido o expirado. Inicia sesión nuevamente.',
                    'error' => 'Unauthenticated'
                ], 401);
            }

            return $next($request);
        } catch (AuthenticationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Acceso denegado. Token requerido.',
                'error' => 'Unauthenticated'
            ], 401);
        }
    }
}
