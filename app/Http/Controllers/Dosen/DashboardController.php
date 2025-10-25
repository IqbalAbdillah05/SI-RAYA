<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PresensiDosen;
use App\Models\PresensiMahasiswa;
use App\Models\NilaiMahasiswa;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user || !$user->dosen) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai dosen');
        }
        
        $dosen = $user->dosen;
        
        // Get today's date
        $today = Carbon::today();
        $currentDay = Carbon::now()->locale('id')->dayName;
        
        // Mapping hari Indonesia ke Inggris untuk query
        $hariMap = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu'
        ];
        
        // Statistics
        $stats = [
            // Total presensi dosen bulan ini
            'presensi_dosen' => PresensiDosen::where('dosen_id', $dosen->id)
                ->whereMonth('waktu_presensi', Carbon::now()->month)
                ->whereYear('waktu_presensi', Carbon::now()->year)
                ->count(),
            
            // Total presensi mahasiswa bulan ini
            'presensi_mahasiswa' => PresensiMahasiswa::where('dosen_id', $dosen->id)
                ->whereMonth('waktu_presensi', Carbon::now()->month)
                ->whereYear('waktu_presensi', Carbon::now()->year)
                ->count(),
            
            // Total nilai yang sudah diinput
            'nilai_mahasiswa' => NilaiMahasiswa::where('dosen_id', $dosen->id)->count(),
            
            // Total jadwal mengajar
            'total_jadwal' => Jadwal::where('dosen_id', $dosen->id)->count()
        ];
        
        // Jadwal hari ini
        $jadwalHariIni = Jadwal::with(['mataKuliah', 'prodi'])
            ->where('dosen_id', $dosen->id)
            ->where('hari', $currentDay)
            ->orderBy('jam_mulai')
            ->get();
        
        // Presensi dosen terbaru (5 terakhir)
        $presensiDosenTerbaru = PresensiDosen::with('lokasi')
            ->where('dosen_id', $dosen->id)
            ->latest('waktu_presensi')
            ->take(5)
            ->get();
        
        // Presensi mahasiswa terbaru (5 terakhir)
        $presensiMahasiswaTerbaru = PresensiMahasiswa::with(['mahasiswa', 'mataKuliah'])
            ->where('dosen_id', $dosen->id)
            ->latest('waktu_presensi')
            ->take(5)
            ->get();
        
        // Nilai mahasiswa terbaru (5 terakhir)
        $nilaiTerbaru = NilaiMahasiswa::with(['mahasiswa', 'mataKuliah'])
            ->where('dosen_id', $dosen->id)
            ->latest('created_at')
            ->take(5)
            ->get();
        
        return view('dosen.dashboard', compact(
            'user',
            'stats',
            'jadwalHariIni',
            'presensiDosenTerbaru',
            'presensiMahasiswaTerbaru',
            'nilaiTerbaru',
            'currentDay'
        ));
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'pas_foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'pas_foto.required' => 'Foto profil wajib diupload',
            'pas_foto.image' => 'File harus berupa gambar',
            'pas_foto.mimes' => 'Format foto harus jpeg, png, atau jpg',
            'pas_foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        $user = Auth::user();
        $dosen = $user->dosen;

        if (!$dosen) {
            return redirect()->back()->with('error', 'Data dosen tidak ditemukan');
        }

        try {
            // Hapus foto lama jika ada
            if ($dosen->pas_foto && \Storage::disk('public')->exists($dosen->pas_foto)) {
                \Storage::disk('public')->delete($dosen->pas_foto);
            }

            // Upload foto baru
            $path = $request->file('pas_foto')->store('pas_foto', 'public');
            
            // Update database
            $dosen->pas_foto = $path;
            $dosen->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }
}
