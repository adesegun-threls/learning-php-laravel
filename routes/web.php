<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

// Web-based authentication routes are disabled
// This is an API-first application using token-based authentication
// See routes/api.php for API authentication endpoints
// require __DIR__.'/auth.php';
