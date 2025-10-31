<?php

use Illuminate\Support\Facades\Route;

// API-first application - no web routes needed
// All routes are in routes/api.php

Route::get('/', function () {
    return [
        'name' => 'Event Management API',
        'version' => '1.0',
        'laravel' => app()->version(),
        'documentation' => url('/api/documentation'),
    ];
});
