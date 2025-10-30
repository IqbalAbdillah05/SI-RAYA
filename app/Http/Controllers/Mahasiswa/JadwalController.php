<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Krs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->mahasiswa) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai mahasiswa');
        }
        
        $mahasiswa = $user->mahasiswa;
        
        // Get selected semester from request or use mahasiswa's current semester
        $selectedSemester = $request->get('semester', $mahasiswa->semester);
        
        // Get list of available semesters (1-8)
        $semesterList = range(1, 8);
        
        // Cari KRS mahasiswa untuk semester yang dipilih
        $krs = Krs::with(['details.mataKuliah'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('semester', $selectedSemester)
            ->first();
        
        // Jika tidak ada KRS, tampilkan pesan
        if (!$krs) {
            return view('Mahasiswa.jadwal.index', compact(
                'semesterList',
                'selectedSemester',
                'mahasiswa'
            ))->with([
                'jadwalList' => collect([]),
                'jadwalByHari' => collect([]),
                'hasKrs' => false
            ]);
        }
        
        // Ambil ID mata kuliah yang diambil di KRS
        $mataKuliahIds = $krs->details->pluck('mata_kuliah_id')->toArray();
        
        // Get jadwal hanya untuk mata kuliah yang ada di KRS
        $jadwalList = Jadwal::with(['mataKuliah', 'dosen', 'prodi'])
            ->where('prodi_id', $mahasiswa->prodi_id)
            ->where('semester', $selectedSemester)
            ->whereIn('mata_kuliah_id', $mataKuliahIds)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();
        
        // Group jadwal by hari
        $jadwalByHari = $jadwalList->groupBy('hari');
        
        return view('Mahasiswa.jadwal.index', compact(
            'jadwalList',
            'jadwalByHari',
            'semesterList',
            'selectedSemester',
            'mahasiswa',
            'krs'
        ))->with('hasKrs', true);
    }
}
