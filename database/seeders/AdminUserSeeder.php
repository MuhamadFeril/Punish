<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = 'admin@gmail.com';
        $name = 'Admin King';
        $password = 'qwertyuiop';

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'admin',
                'otp_verified_at' => now(),
            ]
        );

        $this->command?->info('Admin user seeded: admin@gmail.com / qwertyuiop');
    }
}
