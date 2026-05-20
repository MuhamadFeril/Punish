<?php

namespace App\Repositories;

use App\Interface\AuthInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthRepositories implements AuthInterface
{
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (!empty($data['google_id'])) {
            $user->google_id = $data['google_id'];
        }

        if (!empty($data['avatar'])) {
            $user->avatar = $data['avatar'];
        }

        $user->save();

        return $user;
    }

    public function login(array $credentials)
    {
        $user = $this->findByEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            return $user;
        }

   

        return null;
    }
    public function logout()
    {
        Auth::logout();
        return true;
    }
    public  function googleLogin(array $data)
    {
        $user = User::where('google_id', $data['google_id'])->first();

        if (!$user) {
            $user = $this->register($data);
        }

        return $user;
    }
    public function googleRegister(array $data)
    {
        return $this->register($data);
    }

    // ==========================================
    // OTP Methods
    // ==========================================

    public function createOtpRecord(array $data)
    {
        return \App\Models\Otp::create($data);
    }

    public function findOtpRecord(string $identifier, string $type)
    {
        $query = \App\Models\Otp::where('type', $type);
        if ($type === 'register') {
            $query->where('email', $identifier);
        } else {
            $query->where('user_id', $identifier);
        }
        
        return $query->latest()->first();
    }

    public function deleteOtpRecord(int $otpId)
    {
        return \App\Models\Otp::where('id', $otpId)->delete();
    }

    public function markUserAsVerified($user)
    {
        $user->forceFill(['otp_verified_at' => now()])->save();
        return $user;
    }
}
