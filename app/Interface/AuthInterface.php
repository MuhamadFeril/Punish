<?php

namespace App\Interface;

interface AuthInterface
{
    public function register(array $data);

    public function login(array $credentials);

    public function logout();

    // OTP Methods
    public function createOtpRecord(array $data);
    public function findOtpRecord(string $identifier, string $type);
    public function deleteOtpRecord(int $otpId);
    public function markUserAsVerified($user);
}