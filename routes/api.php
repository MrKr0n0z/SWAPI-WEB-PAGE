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

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Sin Autenticación)
|--------------------------------------------------------------------------
*/

// Endpoint de autenticación (con CORS habilitado)
Route::middleware(['cors'])->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    
    // RUTA TEMPORAL SOLO PARA TESTING (NO usar en producción)
    Route::get('/auth/login', function() {
        return response()->json([
            'message' => 'Este endpoint requiere POST con credenciales',
            'example' => [
                'method' => 'POST',
                'body' => [
                    'email' => 'admin@test.com',
                    'password' => 'password123'
                ]
            ]
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Autenticación + Rate Limiting)
|--------------------------------------------------------------------------
| Middlewares aplicados:
| - auth:sanctum: Valida token Bearer válido y no expirado
| - throttle:60,1: Limita a 60 peticiones por minuto por usuario
*/

Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {
    
    // Rutas de gestión de usuario autenticado
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    // API SWAPI v1 - PROTEGIDA CON AUTENTICACIÓN Y RATE LIMITING
    Route::prefix('v1')->group(function () {
        Route::apiResource('films', FilmController::class)->only(['index', 'show']);
        Route::apiResource('people', PersonController::class)->only(['index', 'show']);
        Route::apiResource('planets', PlanetController::class)->only(['index', 'show']);
        Route::apiResource('species', SpeciesController::class)->only(['index', 'show']);
        Route::apiResource('starships', StarshipController::class)->only(['index', 'show']);
        Route::apiResource('vehicles', VehicleController::class)->only(['index', 'show']);
    });

    // Sincronización de datos (protegida para producción)
    Route::post('/sync', [SyncController::class, 'sync']);
    
    // Ruta de usuario heredada (compatibilidad)
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    });
});
