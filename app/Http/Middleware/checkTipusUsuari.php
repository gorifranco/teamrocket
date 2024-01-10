<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkTipusUsuari
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $tipusUsuaris): Response
    {
        {
            if ($tipusUsuaris == 'administrador' && !$request->user()->esAdministrador()) {
                abort(403);
            }
            if ($tipusUsuaris == 'gestor' && !$request->user()->esGestor()) {
                abort(403);
            }
            if ($tipusUsuaris == 'usuari' && !$request->user()->esUsuari()) {
                abort(403);
            }
            return $next($request);
        }
    }
}
