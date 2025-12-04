<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\Api\V1\FilmController;
use App\Http\Controllers\Api\V1\PersonController;
use App\Http\Controllers\Api\V1\PlanetController;
use App\Http\Controllers\Api\V1\SpeciesController;
use App\Http\Controllers\Api\V1\StarshipController;
use App\Http\Controllers\Api\V1\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas públicas de autenticación
Route::post('/auth/login', [AuthController::class, 'login']);

// Ruta de sincronización (pública para desarrollo)
Route::post('/sync', [SyncController::class, 'sync']);

// Rutas API v1 - SWAPI Compatible
Route::prefix('v1')->group(function () {
    Route::apiResource('films', FilmController::class)->only(['index', 'show']);
    Route::apiResource('people', PersonController::class)->only(['index', 'show']);
    Route::apiResource('planets', PlanetController::class)->only(['index', 'show']);
    Route::apiResource('species', SpeciesController::class)->only(['index', 'show']);
    Route::apiResource('starships', StarshipController::class)->only(['index', 'show']);
    Route::apiResource('vehicles', VehicleController::class)->only(['index', 'show']);
});

// Rutas protegidas con autenticación Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Rutas de autenticación
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Ruta de usuario heredada (opcional, mantenida por compatibilidad)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
