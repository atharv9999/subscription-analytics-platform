<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MetricsController;

Route::get('/metrics', [MetricsController::class, 'index']);
Route::get('/metrics/trend', [MetricsController::class, 'trend']);