<?php

namespace App\Http\Middleware;

use App\Models\User;
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
    public function handle(Request $request, Closure $next, ...$tipusUsuaris): Response
    {
        {
                $key = explode(' ', $request->header('Authorization'));
                    $token = $key[1];
                $user = User::where('api_token', $token)->first();
                if(!$user) abort(401, "Usuari no trobat");
                if(!in_array($user->tipusUsuari, $tipusUsuaris)) abort(401, "Unauthorized");
                    return $next($request); // Usuari trobat. Token correcta. Continuam am la petició
        }
    }
}
