<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Models\BlokirMahasiswa;
use App\Models\Mahasiswa;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        // Cek apakah role diberikan
        if ($role === null) {
            return $next($request);
        }

        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Cek role pengguna
        if ($user->role !== $role) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        // Khusus untuk mahasiswa, cek status blokir
        if ($role === 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            
            if ($mahasiswa) {
                $blokirAktif = BlokirMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                    ->where('status_blokir', 'Diblokir')
                    ->first();

                if ($blokirAktif) {
                    Auth::logout();
                    return redirect('login')->with([
                        'error' => 'Akun Anda diblokir.',
                        'blokir_detail' => [
                            'keterangan' => $blokirAktif->keterangan,
                            'tanggal_blokir' => $blokirAktif->tanggal_blokir->format('d F Y'),
                            'admin' => $blokirAktif->admin->name ?? 'Admin'
                        ]
                    ]);
                }
            }
        }

        return $next($request);
    }
}
