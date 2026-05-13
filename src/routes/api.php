<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MetricsController;
use App\Http\Controllers\Api\AuthController;

// Public route - anyone can try to login
Route::post('/login', [AuthController::class, 'login']);

// Protected routes - only logged-in users with a valid token can enter
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/metrics', [MetricsController::class, 'index']);
    Route::get('/metrics/trend', [MetricsController::class, 'trend']);
    Route::post('/logout', [AuthController::class, 'logout']);
});