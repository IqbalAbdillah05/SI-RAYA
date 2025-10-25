<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    echo "Mencoba membuat user admin...\n";
    
    $userData = [
        'role' => 'admin',
        'username' => 'admin123',
        'name' => 'admin123',
        'email' => 'admin@example.com',
        'password' => Hash::make('password123')
    ];
    
    echo "Data user yang akan dibuat: " . json_encode($userData, JSON_PRETTY_PRINT) . "\n";
    
    $user = User::create($userData);
    
    echo "User berhasil dibuat dengan ID: " . $user->id . "\n";
    echo "Detail user: " . json_encode($user->toArray(), JSON_PRETTY_PRINT) . "\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}