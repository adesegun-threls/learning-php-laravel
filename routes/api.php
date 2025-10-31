<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public authentication routes (no auth required)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);

    // Get authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Event management
    Route::apiResource('events', EventController::class);

    // Attendee management (nested under events)
    Route::apiResource('events.attendees', AttendeeController::class)
        ->except(['show', 'update']); // Only need index, store, destroy
});

