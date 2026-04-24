<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)
            ->stateless()
            ->redirect();
    }

    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');
            return redirect()->away($frontendUrl . '/?error=oauth_failed');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name'     => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Usuario',
                'email'    => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(32)),
                'role'     => 'user',
            ]);
        }

        $user->tokens()->delete();
        $user->update(['last_login_at' => now()]);

        $token = $user->createToken(
            'api-token',
            ['*'],
            now()->addMinutes(60)
        )->plainTextToken;

        $frontendUrl = env('FRONTEND_URL', 'http://localhost:3000');

        return redirect()->away(
            $frontendUrl . '/auth/callback?token=' . $token .
            '&name=' . urlencode($user->name) .
            '&email=' . urlencode($user->email) .
            '&role=' . urlencode($user->role)
        );
    }

    private function validateProvider(string $provider): void
    {
        if (!in_array($provider, ['google', 'github'])) {
            abort(400, 'Proveedor no soportado');
        }
    }
}