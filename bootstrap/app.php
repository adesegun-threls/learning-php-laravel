<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    // ROUTE CONFIGURATION - API-first application
    ->withRouting(
        web: __DIR__.'/../routes/web.php',          // Minimal web routes (health checks, docs)
        api: __DIR__.'/../routes/api.php',          // API routes (JWT authentication)
        commands: __DIR__.'/../routes/console.php', // Artisan commands
        health: '/up',                               // Health check endpoint
    )
    // MIDDLEWARE CONFIGURATION
    ->withMiddleware(function (Middleware $middleware): void {
        // API-first: No session/cookie middleware needed for API routes
        // Passport JWT handles authentication via Authorization header
    })
    // EXCEPTION HANDLING
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
