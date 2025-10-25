<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Log percobaan login
        Log::info('Login Attempt', [
            'username' => $credentials['username'],
            'ip' => $request->ip(),
        ]);

        // Coba login dengan berbagai kemungkinan field
        $user = User::where(function($query) use ($credentials) {
            $query->where('email', $credentials['username'])
                  ->orWhere('nidn', $credentials['username'])
                  ->orWhere('username', $credentials['username'])
                  ->orWhere('nim', $credentials['username']);
        })->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Cek status khusus untuk mahasiswa
            if ($user->role === 'mahasiswa') {
                $mahasiswa = Mahasiswa::where('user_id', $user->id)
                    ->where('status_mahasiswa', 'Aktif')
                    ->first();

                if (!$mahasiswa) {
                    return back()->withErrors([
                        'username' => 'Akun mahasiswa tidak aktif.',
                    ])->withInput($request->except('password'));
                }
                
                // Blokir functionality has been removed
            }

            Auth::login($user);
            $request->session()->regenerate();

            // Log sukses
            if ($user->role === 'mahasiswa') {
                $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
                Log::info('Mahasiswa Login Successful', [
                    'nim' => $user->nim,
                    'nama' => $mahasiswa->nama_lengkap
                ]);
            } else {
                Log::info('User Login Successful', [
                    'email' => $user->email,
                    'role' => $user->role
                ]);
            }

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'dosen') {
                return redirect()->route('dosen.dashboard');
            } elseif ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }

            return redirect('/');
        }

        Log::warning('Login Failed - Invalid Credentials', [
            'username' => $credentials['username']
        ]);

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}