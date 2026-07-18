<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPanitiaRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = auth()->guard('panitia')->user();

        if (!$user || $user->role_panitia !== $role) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang untuk membuka halaman ini.');
        }

        return $next($request);
    }
}
