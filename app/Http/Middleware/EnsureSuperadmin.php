<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperadmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role !== 'superadmin') {
            abort(403, 'Halaman ini hanya dapat diakses oleh superadmin.');
        }

        return $next($request);
    }
}
