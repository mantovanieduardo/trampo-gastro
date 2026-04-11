<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTipo
{
    public function handle(Request $request, Closure $next, string $tipo): Response
    {
        // Se não estiver logado ou o tipo for diferente do que a rota exige
        if (!$request->user() || $request->user()->tipo !== $tipo) {
            abort(403, 'Acesso negado. Você não possui o perfil de ' . $tipo);
        }

        return $next($request);
    }
}