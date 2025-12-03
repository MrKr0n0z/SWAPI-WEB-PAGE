<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rutas públicas de autenticación
Route::post('/auth/login', [AuthController::class, 'login']);

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
