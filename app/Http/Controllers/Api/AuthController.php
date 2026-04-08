<?php



namespace App\Http\Controllers\Api;
use App\Handlers\AuthHandler;     
use App\Helpers\ResponsHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authHandler;

    public function __construct(AuthHandler $authHandler)
    {
        $this->authHandler = $authHandler;
    }
    public function register(Request $request)
    {
        try {
            $credentials = $request->only('name', 'email', 'password');
        $user = $this->authHandler->register($credentials);          
  return ResponsHelper::success($user, 'Registration successful');
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return ResponsHelper::error('Registration failed: ' . $e->getMessage(), 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $token = $this->authHandler->login($credentials);
            if (!$token) {
                return ResponsHelper::error('Invalid credentials', 401);
            }
            return ResponsHelper::success(['token' => $token], 'Login successful');
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return ResponsHelper::error('Login failed: ' . $e->getMessage(), 500);
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
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (! $user) {
                return ResponsHelper::error('User not found', 404);
            }
            $user->update($request->all());
            Cache::forget("user:{$id}");
            return ResponsHelper::success($user, 'User updated and cache cleared');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return ResponsHelper::error('Gagal memperbarui user', 500);
        }
    }
}