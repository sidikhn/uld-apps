<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureViewOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== 'admin' || $request->routeIs('logout')) {
            return $next($request);
        }

        $allowedReadRoutes = [
            'dashboard',
            'mahasiswa.index',
            'mahasiswa.show',
            'mahasiswa.document',
            'mahasiswa.downloadPdf',
            'api.studyPrograms',
        ];

        $isReadRequest = in_array($request->method(), ['GET', 'HEAD'], true);
        $isAllowedReadRoute = $request->routeIs($allowedReadRoutes);

        if ($isReadRequest && $isAllowedReadRoute) {
            return $next($request);
        }

        abort(403, 'Akun admin hanya memiliki akses untuk melihat data.');
    }
}
