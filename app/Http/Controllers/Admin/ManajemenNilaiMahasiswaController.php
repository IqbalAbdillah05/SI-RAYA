<?php

namespace App\Http\Controllers\Admin;

use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Exports\NilaiMahasiswaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenNilaiMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = NilaiMahasiswa::with(['mahasiswa', 'dosen', 'mataKuliah', 'prodi']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search di mahasiswa (nama_lengkap, nim, email)
                $q->whereHas('mahasiswa', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('nim', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%');
                })
                // Search di mata kuliah
                ->orWhereHas('mataKuliah', function($subQuery) use ($search) {
                    $subQuery->where('nama_matakuliah', 'like', '%' . $search . '%')
                             ->orWhere('kode_matakuliah', 'like', '%' . $search . '%');
                })
                // Search di dosen
                ->orWhereHas('dosen', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('nidn', 'like', '%' . $search . '%');
                })
                // Search di prodi
                ->orWhereHas('prodi', function($subQuery) use ($search) {
                    $subQuery->where('nama_prodi', 'like', '%' . $search . '%');
                })
                // Search di nilai dan tahun ajaran
                ->orWhere('nilai_angka', 'like', '%' . $search . '%')
                ->orWhere('nilai_huruf', 'like', '%' . $search . '%')
                ->orWhere('tahun_ajaran', 'like', '%' . $search . '%')
                ->orWhere('semester', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan mahasiswa
        if ($request->filled('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        // Filter berdasarkan mata kuliah
        if ($request->filled('mata_kuliah_id')) {
            $query->where('mata_kuliah_id', $request->mata_kuliah_id);
        }

        // Filter berdasarkan prodi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        
        $nilaiList = $query->latest()->paginate($perPage);

        // Append query parameters to pagination links
        $nilaiList->appends($request->only(['search', 'entries', 'mahasiswa_id', 'mata_kuliah_id', 'prodi_id', 'semester', 'tahun_ajaran']));

        // Data untuk filter
        $mahasiswaList = Mahasiswa::orderBy('nama_lengkap')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        $semesterList = NilaiMahasiswa::select('semester')->distinct()->orderBy('semester')->pluck('semester');
        $tahunAjaranList = NilaiMahasiswa::select('tahun_ajaran')->distinct()->orderBy('tahun_ajaran', 'desc')->pluck('tahun_ajaran');

        return view('admin.manajemenNilaiMahasiswa.index', compact('nilaiList', 'mahasiswaList', 'mataKuliahs', 'prodis', 'semesterList', 'tahunAjaranList'));
    }

    public function create()
    {
        $mahasiswaList = Mahasiswa::orderBy('nama_lengkap')->get();
        $dosenList = Dosen::orderBy('nama_lengkap')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        
        return view('admin.manajemenNilaiMahasiswa.create', compact('mahasiswaList', 'dosenList', 'mataKuliahs', 'prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa_profiles,id',
            'dosen_id' => 'nullable|exists:dosen_profiles,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'prodi_id' => 'required|exists:prodi,id',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'semester' => 'required|string|max:10',
            'tahun_ajaran' => 'required|string|max:20',
        ]);

        NilaiMahasiswa::create($validated);

        return redirect()->route('admin.manajemen-nilai-mahasiswa.index')
            ->with('success', 'Nilai mahasiswa berhasil ditambahkan');
    }

    public function show($id)
    {
        $nilai = NilaiMahasiswa::with(['mahasiswa', 'dosen', 'mataKuliah', 'prodi'])->findOrFail($id);
        
        // Ambil nilai lain dari mahasiswa yang sama
        $nilaiLainnya = NilaiMahasiswa::with('dosen', 'mataKuliah', 'prodi')
            ->where('mahasiswa_id', $nilai->mahasiswa_id)
            ->where('id', '!=', $id)
            ->where('tahun_ajaran', $nilai->tahun_ajaran)
            ->where('semester', $nilai->semester)
            ->get();

        // Hitung statistik nilai mahasiswa
        $statistik = NilaiMahasiswa::where('mahasiswa_id', $nilai->mahasiswa_id)
            ->selectRaw('
                AVG(nilai_angka) as rata_rata,
                AVG(nilai_indeks) as ipk,
                COUNT(*) as total_matkul,
                MAX(nilai_angka) as nilai_tertinggi,
                MIN(nilai_angka) as nilai_terendah
            ')
            ->first();

        return view('admin.manajemenNilaiMahasiswa.show', compact('nilai', 'nilaiLainnya', 'statistik'));
    }

    public function edit($id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);
        $mahasiswaList = Mahasiswa::orderBy('nama_lengkap')->get();
        $dosenList = Dosen::orderBy('nama_lengkap')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        
        return view('admin.manajemenNilaiMahasiswa.edit', compact('nilai', 'mahasiswaList', 'dosenList', 'mataKuliahs', 'prodis'));
    }

    public function update(Request $request, $id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);

        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa_profiles,id',
            'dosen_id' => 'nullable|exists:dosen_profiles,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'prodi_id' => 'required|exists:prodi,id',
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'semester' => 'required|string|max:10',
            'tahun_ajaran' => 'required|string|max:20',
        ]);

        $nilai->update($validated);

        return redirect()->route('admin.manajemen-nilai-mahasiswa.index')
            ->with('success', 'Nilai mahasiswa berhasil diperbarui');
    }

    public function destroy($id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);
        $nilai->delete();

        return redirect()->route('admin.manajemen-nilai-mahasiswa.index')
            ->with('success', 'Nilai mahasiswa berhasil dihapus');
    }

    /**
     * Export nilai mahasiswa data to Excel
     */
    public function export(Request $request)
    {
        try {
            // Get all filters from request
            $filters = [
                'search' => $request->get('search'),
                'mahasiswa_id' => $request->get('mahasiswa_id'),
                'mata_kuliah_id' => $request->get('mata_kuliah_id'),
                'prodi_id' => $request->get('prodi_id'),
                'semester' => $request->get('semester'),
                'tahun_ajaran' => $request->get('tahun_ajaran'),
            ];

            // Create filename with timestamp
            $fileName = 'data_nilai_mahasiswa_' . date('Ymd_His') . '.xlsx';

            return Excel::download(new NilaiMahasiswaExport($filters), $fileName);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }
}