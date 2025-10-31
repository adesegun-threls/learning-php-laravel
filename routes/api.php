<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
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
