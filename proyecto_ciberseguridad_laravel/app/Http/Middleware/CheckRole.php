<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * Uso: middleware('role:admin') o middleware('role:alumno')
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check() || Auth::user()->rol !== $role) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
