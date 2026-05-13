<?php

namespace App\Handlers;

use App\Repositories\AuthRepositories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthHandler
{
    protected $authRepo;

    public function __construct(AuthRepositories $authRepo)
    {
        $this->authRepo = $authRepo;
    }
    public function register(array $data)
    {
        return $this->authRepo->register($data);
    }

    public function login(array $credentials)
    {
        $user = $this->authRepo->findByEmail($credentials['email']);
        // debug logging to help diagnose invalid credential issues
        Log::info('AuthHandler login attempt', [
            'email' => $credentials['email'] ?? null,
            'user_found' => (bool) $user,
        ]);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user->createToken('auth_token')->plainTextToken;
        }

        Log::warning('AuthHandler login failed', [
            'email' => $credentials['email'] ?? null,
            'user_found' => (bool) $user,
        ]);

        return null;
    }

    public function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function google(array $data)
    {
        $user = $this->authRepo->findByEmail($data['email']);

        if ($user) {
            // Update existing user with Google info
            $user->update([
                'google_id' => $data['google_id'] ?? null,
                'avatar' => $data['avatar'] ?? null,
            ]);
        } else {
            // Create new user from Google data
            $user = $this->authRepo->register([
                'name' => $data['name'],
                'email' => $data['email'],
                'google_id' => $data['google_id'] ?? null,
                'avatar' => $data['avatar'] ?? null,
                'password' => Hash::make(uniqid()), // Random password for OAuth users
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }
}