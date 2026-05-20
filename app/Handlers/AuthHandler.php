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

    // ==========================================
    // OTP Methods
    // ==========================================

    public function sendOtp(array $data)
    {
        $email = strtolower(trim($data['email']));
        
        $existing = $this->authRepo->findOtpRecord($email, 'register');
        if ($existing) {
            $this->authRepo->deleteOtpRecord($existing->id);
        }

        $otp = random_int(100000, 999999);

        $otpRecord = $this->authRepo->createOtpRecord([
            'email'      => $email,
            'type'       => 'register',
            'otp'        => Hash::make($otp),
            'expired_at' => now()->addMinutes(10),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($email)->send(
                new \App\Mail\SendOtpMail($otp)
            );
        } catch (\Exception $e) {
            $this->authRepo->deleteOtpRecord($otpRecord->id);
            throw $e;
        }

        return true;
    }

    public function verifyOtp(array $data)
    {
        $type = $data['type'];
        $identifier = $type === 'register' ? strtolower(trim($data['email'])) : $data['user_id'];
        
        $otpRecord = $this->authRepo->findOtpRecord($identifier, $type);
        
        if (!$otpRecord || now()->greaterThan($otpRecord->expired_at)) {
            throw new \Exception('Kode OTP tidak valid atau telah kedaluwarsa.');
        }

        if (!Hash::check($data['otp'], $otpRecord->otp)) {
            throw new \Exception('Kode OTP tidak valid.');
        }

        $this->authRepo->deleteOtpRecord($otpRecord->id);

        if ($type === 'login') {
            // Retrieve user and mark as verified
            $user = $this->authRepo->findByEmail($otpRecord->email);
            if ($user) {
                $this->authRepo->markUserAsVerified($user);
            }
        }

        return true;
    }

    public function resendOtp(int $userId)
    {
        // Ambil user
        $user = \App\Models\User::find($userId);
        if (!$user) {
            throw new \Exception('User tidak ditemukan.');
        }

        $existing = $this->authRepo->findOtpRecord($userId, 'login');
        if ($existing) {
            $this->authRepo->deleteOtpRecord($existing->id);
        }

        $otp = random_int(100000, 999999);

        $otpRecord = $this->authRepo->createOtpRecord([
            'user_id'    => $user->id,
            'email'      => $user->email,
            'type'       => 'login',
            'otp'        => Hash::make($otp),
            'expired_at' => now()->addMinutes(10),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(
                new \App\Mail\SendOtpMail($otp)
            );
        } catch (\Exception $e) {
            $this->authRepo->deleteOtpRecord($otpRecord->id);
            throw $e;
        }

        return true;
    }
}