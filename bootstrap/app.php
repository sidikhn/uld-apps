<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(dirname(__DIR__))
    ->withRouting(
        null,
        __DIR__.'/../routes/web.php',
        __DIR__.'/../routes/api.php',
        __DIR__.'/../routes/console.php',
        null,
        null,
        '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Tambahkan middleware group API
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        $middleware->alias([
            'superadmin' => \App\Http\Middleware\EnsureSuperadmin::class,
            'view-only' => \App\Http\Middleware\EnsureViewOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
