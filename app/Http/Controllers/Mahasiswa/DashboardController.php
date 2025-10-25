<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\JadwalMahasiswa;
use App\Models\Khs;
use App\Models\KhsDetail;
use App\Models\Krs;
use App\Models\KrsDetail;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        
        // Get semester dan tahun ajaran aktif
        $tahunSekarang = date('Y');
        $bulanSekarang = date('n');
        
        // Tentukan semester (Ganjil: Agustus-Januari, Genap: Februari-Juli)
        if ($bulanSekarang >= 8) {
            $semesterAktif = 'Ganjil';
            $tahunAjaranAktif = $tahunSekarang . '/' . ($tahunSekarang + 1);
        } elseif ($bulanSekarang <= 1) {
            $semesterAktif = 'Ganjil';
            $tahunAjaranAktif = ($tahunSekarang - 1) . '/' . $tahunSekarang;
        } else {
            $semesterAktif = 'Genap';
            $tahunAjaranAktif = ($tahunSekarang - 1) . '/' . $tahunSekarang;
        }
        
        if (!$mahasiswa) {
            return view('mahasiswa.dashboard', [
                'user' => $user,
                'mahasiswa' => null,
                'semesterAktif' => $semesterAktif,
                'tahunAjaranAktif' => $tahunAjaranAktif,
                'stats' => [
                    'total_sks' => 0,
                    'ipk' => 0,
                    'ips_terakhir' => 0,
                    'total_jadwal' => 0,
                ],
                'jadwalHariIni' => collect(),
                'khsTerbaru' => collect(),
            ]);
        }
        
        // Get statistics
        $stats = [
            'total_sks' => KrsDetail::whereHas('krs', function($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id)
                      ->where('status_validasi', 'Disetujui');
            })
            ->with('mataKuliah')
            ->get()
            ->sum(function($detail) {
                return $detail->mataKuliah->sks ?? 0;
            }) ?? 0,
            
            'ipk' => Khs::where('mahasiswa_id', $mahasiswa->id)
                       ->where('status_validasi', 'Disetujui')
                       ->latest()
                       ->value('ipk') ?? 0,
            
            'ips_terakhir' => Khs::where('mahasiswa_id', $mahasiswa->id)
                                 ->where('status_validasi', 'Disetujui')
                                 ->latest()
                                 ->value('ips') ?? 0,
            
            'total_jadwal' => JadwalMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                                            ->whereHas('jadwal', function($query) use ($tahunAjaranAktif) {
                                                $query->where('tahun_ajaran', $tahunAjaranAktif);
                                            })
                                            ->count() ?? 0,
        ];
        
        // Get jadwal hari ini
        $hariIni = Carbon::now()->locale('id')->dayName;
        $jadwalHariIni = JadwalMahasiswa::where('mahasiswa_id', $mahasiswa->id)
            ->with(['jadwal.mataKuliah', 'jadwal.dosen', 'jadwal.prodi'])
            ->whereHas('jadwal', function($query) use ($hariIni, $tahunAjaranAktif) {
                $query->where('hari', $hariIni)
                      ->where('tahun_ajaran', $tahunAjaranAktif);
            })
            ->get()
            ->map(function($item) {
                return $item->jadwal;
            })
            ->sortBy('jam_mulai');
        
        // Get KHS terbaru (3 semester terakhir) - Hanya yang sudah divalidasi
        $khsTerbaru = Khs::where('mahasiswa_id', $mahasiswa->id)
            ->where('status_validasi', 'Disetujui')
            ->with(['details.mataKuliah'])
            ->orderBy('semester', 'desc')
            ->take(3)
            ->get();
        
        // Get KRS terbaru
        $krsTerbaru = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->with(['details.mataKuliah', 'details.jadwal'])
            ->orderBy('created_at', 'desc')
            ->first();
        
        return view('mahasiswa.dashboard', [
            'user' => $user,
            'mahasiswa' => $mahasiswa,
            'semesterAktif' => $semesterAktif,
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'stats' => $stats,
            'jadwalHariIni' => $jadwalHariIni,
            'khsTerbaru' => $khsTerbaru,
            'krsTerbaru' => $krsTerbaru,
        ]);
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

        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        try {
            // Hapus foto lama jika ada
            if ($mahasiswa->pas_foto && \Storage::disk('public')->exists($mahasiswa->pas_foto)) {
                \Storage::disk('public')->delete($mahasiswa->pas_foto);
            }

            // Upload foto baru
            $path = $request->file('pas_foto')->store('pas_foto', 'public');
            
            // Update database
            $mahasiswa->pas_foto = $path;
            $mahasiswa->save();

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }
}

