# Modern Laravel 11+ Route Configuration Guide

## Overview
Laravel 11+ removed `RouteServiceProvider.php` and moved configuration to `bootstrap/app.php`.

## Common Customizations

### 1. Change API Prefix (from /api to something else)

**bootstrap/app.php:**
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    apiPrefix: 'v1/api',  // Changes /api to /v1/api
    health: '/up',
)
```

### 2. Add API Rate Limiting

**bootstrap/app.php:**
```php
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
        then: function () {
            // Custom rate limiting
            RateLimiter::for('api', function (Request $request) {
                return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
            });
        }
    )
    // ... rest of config
```

### 3. Add Custom Route Files

**bootstrap/app.php:**
```php
->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    health: '/up',
    then: function () {
        // Load additional route files
        Route::middleware('web')
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));
            
        Route::middleware('api')
            ->prefix('v2')
            ->group(base_path('routes/api-v2.php'));
    }
)
```

### 4. Configure API Middleware Stack

**bootstrap/app.php:**
```php
->withMiddleware(function (Middleware $middleware): void {
    // Add middleware to API routes
    $middleware->api(prepend: [
        \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ]);
    
    // Or append middleware
    $middleware->api(append: [
        \App\Http\Middleware\CustomApiMiddleware::class,
    ]);

    // Add middleware aliases
    $middleware->alias([
        'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        'admin' => \App\Http\Middleware\IsAdmin::class,
    ]);
})
```

### 5. Set Home Route (Like OLD RouteServiceProvider::HOME)

**app/Providers/AppServiceProvider.php:**
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to redirect after login
     */
    public const HOME = '/dashboard';
    
    public function boot(): void
    {
        // Any boot logic
    }
}
```

Then use it:
```php
return redirect(AppServiceProvider::HOME);
```

## Complete Example: Custom API Setup

**bootstrap/app.php with all customizations:**
```php
<?php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api/v1',  // Custom API prefix
        health: '/up',
        then: function () {
            // Custom rate limiting
            RateLimiter::for('api', function (Request $request) {
                return Limit::perMinute(60)
                    ->by($request->user()?->id ?: $request->ip())
                    ->response(function () {
                        return response()->json([
                            'message' => 'Too many requests. Please try again later.'
                        ], 429);
                    });
            });
            
            // Additional route files
            Route::middleware('api')
                ->prefix('api/v2')
                ->group(base_path('routes/api-v2.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // API middleware
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // Middleware aliases
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
        
        // Throttle middleware for web routes
        $middleware->web(append: [
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom exception handling
    })->create();
```

## Comparison Table

| Feature | Laravel 10 Location | Laravel 11+ Location |
|---------|---------------------|----------------------|
| Route loading | RouteServiceProvider::boot() | bootstrap/app.php withRouting() |
| API prefix | RouteServiceProvider::boot() | bootstrap/app.php apiPrefix |
| Rate limiting | RouteServiceProvider::configureRateLimiting() | bootstrap/app.php then() |
| Middleware config | RouteServiceProvider or Kernel | bootstrap/app.php withMiddleware() |
| Home constant | RouteServiceProvider::HOME | AppServiceProvider::HOME |
| Additional routes | RouteServiceProvider::boot() | bootstrap/app.php then() |

## Key Takeaways

1. **No more RouteServiceProvider** - It's been removed in Laravel 11+
2. **Everything is in bootstrap/app.php** - More centralized configuration
3. **Cleaner syntax** - Fluent API instead of manual route registration
4. **Still flexible** - Can do everything the old way did, just differently

## Migration from Old Tutorials

If you're following an old tutorial that mentions `RouteServiceProvider`, look for these patterns:

**Old Tutorial Says:** "Edit RouteServiceProvider"
**You Should:** Edit `bootstrap/app.php` instead

**Old Tutorial Says:** "Add to RouteServiceProvider::boot()"
**You Should:** Add to `withRouting(then: function() { ... })`

**Old Tutorial Says:** "Configure RouteServiceProvider::HOME"
**You Should:** Define constant in `AppServiceProvider` or use config file
