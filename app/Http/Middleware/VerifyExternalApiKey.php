<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyExternalApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validKey = config('services.external_api.key', env('EXTERNAL_API_KEY'));

        if (empty($validKey)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'API Key eksternal belum dikonfigurasi di server ULD.',
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        // Cek API Key dari Header 'X-API-KEY', 'X-ULD-API-KEY', atau Query Param 'api_key'
        $providedKey = $request->header('X-API-KEY') 
            ?: ($request->header('X-ULD-API-KEY') ?: $request->query('api_key'));

        if (!$providedKey || !hash_equals($validKey, (string) $providedKey)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized: API Key tidak valid atau tidak disertakan pada header (X-API-KEY / X-ULD-API-KEY).',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
