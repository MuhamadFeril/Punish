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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
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
}
