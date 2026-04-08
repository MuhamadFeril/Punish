<?php

namespace App\Interface;

interface AuthInterface
{
    public function register(array $data);

    public function login(array $credentials);

    public function logout();
}