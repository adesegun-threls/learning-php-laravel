<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    // ROUTE CONFIGURATION (replaces RouteServiceProvider from Laravel 10)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',          // Web routes (session-based auth)
        api: __DIR__.'/../routes/api.php',          // API routes (auto-prefixed with /api)
        commands: __DIR__.'/../routes/console.php', // Artisan commands
        health: '/up',                               // Health check endpoint
    )
    // MIDDLEWARE CONFIGURATION (replaces Kernel from Laravel 10)
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases (shorthand names)
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        //
    })
    // EXCEPTION HANDLING
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
