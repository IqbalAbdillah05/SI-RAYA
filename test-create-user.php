<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::create([
    'role' => 'admin',
    'username' => 'admin123',
    'name' => 'admin123',
    'email' => 'admin@example.com',
    'password' => Hash::make('password123')
]);

var_dump($user);