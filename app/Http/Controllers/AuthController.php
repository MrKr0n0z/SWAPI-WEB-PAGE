<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Autenticar usuario y generar token con expiración y seguridad
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe tener un formato válido',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas. Verifica tu email y contraseña.',
                'errors' => [
                    'credentials' => ['Email o contraseña incorrectos']
                ]
            ], 401);
        }

        // SEGURIDAD: Revocar todos los tokens anteriores del usuario
        $user->tokens()->delete();

        // Actualizar último acceso
        $user->update([
            'last_login_at' => now(),
        ]);

        // Generar nuevo token con nombre específico y expiración (60 minutos configurado en sanctum.php)
        $token = $user->createToken(
            'api-token', 
            ['*'], // Permisos (todas las abilities)
            now()->addMinutes(60) // Expiración explícita de 60 minutos
        )->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Autenticación exitosa',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'last_login_at' => $user->last_login_at,
                ],
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 3600, // 60 minutos en segundos
            ],
        ], 200);
    }

    /**
     * Obtener datos del usuario autenticado
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Datos del usuario obtenidos correctamente',
            'data' => [
                'user' => $request->user(),
            ],
        ]);
    }

    /**
     * Cambiar contraseña del usuario
     */
    public function changePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['La contraseña actual es incorrecta.'],
            ]);
        }

        // Actualizar contraseña
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contraseña cambiada exitosamente',
        ]);
    }

    /**
     * Cerrar sesión y revocar token
     */
    public function logout(Request $request): JsonResponse
    {
        // Revocar el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente',
        ]);
    }
}
