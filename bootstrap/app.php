<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->group('api', [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Jika menggunakan Sanctum statefully
            'throttle:api', // Contoh: throttle:60,1 (sesuaikan di Kernel jika perlu)
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'api/*', // Ini akan mengecualikan /api/auth/register, /api/auth/login, dll.
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
