<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_admin_user()
    {
        $userData = [
            'username' => 'admin123',
            'email' => 'admin@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin'
        ];

        $response = $this->post(route('admin.manajemen-user.store'), $userData);
        
        $this->assertDatabaseHas('users', [
            'username' => 'admin123',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ]);
    }

    public function test_can_create_dosen_user()
    {
        $userData = [
            'username' => 'dosen123',
            'email' => 'dosen@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'dosen',
            'nidn' => 'D12345',
            'program_studi' => 'Informatika'
        ];

        $response = $this->post(route('admin.manajemen-user.store'), $userData);
        
        $this->assertDatabaseHas('users', [
            'username' => 'dosen123',
            'email' => 'dosen@test.com',
            'role' => 'dosen',
            'nidn' => 'D12345'
        ]);
    }
}