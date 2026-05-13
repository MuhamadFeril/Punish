<?php

namespace App\Http\Controllers\Api;
use App\Handlers\AuthHandler;
use App\Helpers\ResponsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\GoogleRequest;
use App\Http\Requests\UpdateUserRequest;

class AuthController extends Controller
{
    protected AuthHandler $authHandler;

    public function __construct(AuthHandler $authHandler)
    {
        $this->authHandler = $authHandler;
    }
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authHandler->register($request->validated());
            return ResponsHelper::success($user, 'Registration successful');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponsHelper::error($e->errors(), 422);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return ResponsHelper::error('Registration failed: ' . $e->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authHandler->login($request->validated());
            if (!$token) {
                return ResponsHelper::error('Invalid credentials', 401);
            }

            return ResponsHelper::success(['token' => $token], 'Login successful');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponsHelper::error($e->errors(), 422);
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return ResponsHelper::error('Login failed: ' . $e->getMessage(), 500);
        }
    }

    public function google(GoogleRequest $request)
    {
        try {
            $token = $this->authHandler->google($request->validated());
            if (!$token) {
                return ResponsHelper::error('Invalid Google credentials', 401);
            }

            return ResponsHelper::success(['token' => $token], 'Google login successful');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ResponsHelper::error($e->errors(), 422);
        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            return ResponsHelper::error('Google login failed: ' . $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authHandler->logout($request);
            return ResponsHelper::success(null, 'Logout successful');
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return ResponsHelper::error('Logout failed: ' . $e->getMessage(), 500);
        }
    }

    // Get user by id with Redis cache (10 minutes)
    public function show($id)
    {
        try {
            $cacheKey = "user:{$id}";
            $user = Cache::get($cacheKey);
            if (!$user) {
                $user = User::find($id);
                if (! $user) {
                    return ResponsHelper::error('User not found', 404);
                }
                Cache::put($cacheKey, $user, 600);
                return ResponsHelper::success($user, 'Data diambil dari DATABASE dan disimpan ke cache');
            }
            return ResponsHelper::success($user, 'Data diambil dari CACHE Redis');
        } catch (\Exception $e) {
            Log::error('Error fetching user: ' . $e->getMessage());
            return ResponsHelper::error('Gagal mengambil user', 500);
        }
    }

    // Update user and clear cache
}