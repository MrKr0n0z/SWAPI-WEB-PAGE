<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\Api\V1\FilmController;
use App\Http\Controllers\Api\V1\PersonController;
use App\Http\Controllers\Api\V1\PlanetController;
use App\Http\Controllers\Api\V1\SpeciesController;
use App\Http\Controllers\Api\V1\StarshipController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas OAuth — públicas
Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->where('provider', 'google|github');

Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->where('provider', 'google|github');

// Autenticación email/password — pública
Route::middleware(['cors'])->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::get('/auth/login', function () {
        return response()->json([
            'message' => 'Este endpoint requiere POST con credenciales',
            'example' => ['method' => 'POST', 'body' => ['email' => 'admin@test.com', 'password' => 'password123']]
        ]);
    });
});

// Rutas protegidas
Route::middleware(['auth:sanctum', 'throttle:60,1'])->group(function () {

    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::prefix('v1')->group(function () {
        Route::apiResource('films', FilmController::class)->only(['index', 'show']);
        Route::apiResource('people', PersonController::class)->only(['index', 'show']);
        Route::apiResource('planets', PlanetController::class)->only(['index', 'show']);
        Route::apiResource('species', SpeciesController::class)->only(['index', 'show']);
        Route::apiResource('starships', StarshipController::class)->only(['index', 'show']);
        Route::apiResource('vehicles', VehicleController::class)->only(['index', 'show']);
    });

    Route::post('/sync', [SyncController::class, 'sync']);

    Route::get('/user', function (Request $request) {
        return response()->json(['success' => true, 'data' => $request->user()]);
    });
});