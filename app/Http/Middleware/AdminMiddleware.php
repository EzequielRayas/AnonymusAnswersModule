<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //         // Verificar si el usuario está autenticado y es admin
        // if (!auth()->check()) {
        //     return redirect()->route('login');
        // }

        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
        }

        return $next($request);
    }
}
