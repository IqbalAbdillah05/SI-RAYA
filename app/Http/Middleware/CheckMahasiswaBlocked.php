<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckMahasiswaBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check authenticated users
        if (!Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Only apply to mahasiswa role
        if ($user->role !== 'mahasiswa') {
            return $next($request);
        }

        // Check if mahasiswa profile exists
        if (!$user->mahasiswaProfile) {
            Log::warning('Mahasiswa profile not found for user ID: ' . $user->id);
            
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->withErrors([
                'username' => 'Profile mahasiswa tidak ditemukan. Silakan hubungi administrator.'
            ]);
        }

        // Check if mahasiswa is blocked
        if ($user->isBlocked()) {
            $blockInfo = $user->getBlockInfo();
            
            // Build error message
            $message = 'Akun Anda telah diblokir oleh administrator.';
            
            if ($blockInfo) {
                if ($blockInfo->keterangan) {
                    $message .= ' Alasan: ' . $blockInfo->keterangan;
                }
                
                if ($blockInfo->tanggal_blokir) {
                    $message .= ' (Tanggal blokir: ' . $blockInfo->tanggal_blokir->format('d F Y') . ')';
                }
            }
            
            $message .= ' Silakan hubungi administrator untuk informasi lebih lanjut.';
            
            // Log the blocked attempt
            Log::info('Blocked mahasiswa attempted to access: ' . $request->fullUrl(), [
                'user_id' => $user->id,
                'mahasiswa_id' => $user->mahasiswaProfile->id,
                'ip_address' => $request->ip()
            ]);
            
            // Logout the user
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->withErrors([
                'username' => $message
            ]);
        }

        return $next($request);
    }
}