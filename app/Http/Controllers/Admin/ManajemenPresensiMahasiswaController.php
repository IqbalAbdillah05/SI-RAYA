<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PresensiMahasiswa;
use App\Models\User;
use App\Exports\PresensiMahasiswaExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Dosen;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenPresensiMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PresensiMahasiswa::with(['mahasiswa', 'dosen', 'mataKuliah', 'prodi']);

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
                // Search di status dan keterangan
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by mahasiswa
        if ($request->filled('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        // Filter by dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Filter by mata kuliah
        if ($request->filled('mata_kuliah_id')) {
            $query->where('mata_kuliah_id', $request->mata_kuliah_id);
        }

        // Filter by prodi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('waktu_presensi', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('waktu_presensi', '<=', $request->tanggal_sampai);
        }

        // Filter by month and year
        if ($request->filled('bulan')) {
            $query->whereMonth('waktu_presensi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('waktu_presensi', $request->tahun);
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        
        // Get data for filters
        $mahasiswas = User::where('role', 'mahasiswa')->orderBy('name')->get();
        $dosens = Dosen::orderBy('nama_lengkap')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        
        // Tambahkan data untuk filter bulan dan tahun
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $years = range(date('Y') - 5, date('Y') + 1);
        
        $presensiMahasiswas = $query->latest('waktu_presensi')->paginate($perPage);

        // Append query parameters to pagination links
        $presensiMahasiswas->appends($request->only([
            'search', 'entries', 'status', 'mahasiswa_id', 'dosen_id', 
            'mata_kuliah_id', 'prodi_id', 'semester', 
            'tanggal_dari', 'tanggal_sampai', 'bulan', 'tahun'
        ]));
        
        return view('admin.manajemenPresensiMahasiswa.index', compact(
            'presensiMahasiswas', 'mahasiswas', 'dosens', 
            'mataKuliahs', 'prodis', 'months', 'years'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswas = User::where('role', 'mahasiswa')->orderBy('name')->get();
        $dosens = Dosen::orderBy('nama_lengkap')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        
        return view('admin.manajemenPresensiMahasiswa.create', compact('mahasiswas', 'dosens', 'mataKuliahs', 'prodis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_id' => 'required|exists:dosen_profiles,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'prodi_id' => 'required|exists:prodi,id',
            'waktu_presensi' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'semester' => 'nullable|integer|min:1|max:14',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            PresensiMahasiswa::create($validated);

            return redirect()
                ->route('admin.manajemen-presensi-mahasiswa.index')
                ->with('success', 'Data presensi mahasiswa berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data presensi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PresensiMahasiswa $manajemenPresensiMahasiswa)
    {
        $manajemenPresensiMahasiswa->load(['mahasiswa.mahasiswaProfile', 'dosen', 'mataKuliah', 'prodi']);
        
        return view('admin.manajemenPresensiMahasiswa.show', [
            'presensi' => $manajemenPresensiMahasiswa
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PresensiMahasiswa $manajemenPresensiMahasiswa)
    {
        $mahasiswas = User::where('role', 'mahasiswa')->orderBy('name')->get();
        $dosens = Dosen::orderBy('nama_lengkap')->get();
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();
        
        return view('admin.manajemenPresensiMahasiswa.edit', [
            'presensi' => $manajemenPresensiMahasiswa,
            'mahasiswas' => $mahasiswas,
            'dosens' => $dosens,
            'mataKuliahs' => $mataKuliahs,
            'prodis' => $prodis
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PresensiMahasiswa $manajemenPresensiMahasiswa)
    {
        $validated = $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'dosen_id' => 'required|exists:dosen_profiles,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'prodi_id' => 'required|exists:prodi,id',
            'waktu_presensi' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'semester' => 'nullable|integer|min:1|max:14',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // Handle foto bukti upload
            if ($request->hasFile('foto_bukti')) {
                // Delete old file if exists
                if ($manajemenPresensiMahasiswa->foto_bukti) {
                    Storage::delete('public/' . $manajemenPresensiMahasiswa->foto_bukti);
                }
                
                $path = $request->file('foto_bukti')->store('presensi-mahasiswa/bukti', 'public');
                $validated['foto_bukti'] = $path;
            }

            // If status is changed to 'hadir' or 'alpha', remove foto_bukti
            if (in_array($validated['status'], ['hadir', 'alpha']) && $manajemenPresensiMahasiswa->foto_bukti) {
                Storage::delete('public/' . $manajemenPresensiMahasiswa->foto_bukti);
                $validated['foto_bukti'] = null;
            }

            $manajemenPresensiMahasiswa->update($validated);

            return redirect()
                ->route('admin.manajemen-presensi-mahasiswa.index')
                ->with('success', 'Data presensi mahasiswa berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data presensi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PresensiMahasiswa $manajemenPresensiMahasiswa)
    {
        try {
            $manajemenPresensiMahasiswa->delete();

            return redirect()
                ->route('admin.manajemen-presensi-mahasiswa.index')
                ->with('success', 'Data presensi mahasiswa berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data presensi: ' . $e->getMessage());
        }
    }

    /**
     * Export presensi mahasiswa data to Excel
     */
    public function export(Request $request)
    {
        try {
            // Get all filters from request
            $filters = [
                'search' => $request->get('search'),
                'status' => $request->get('status'),
                'mahasiswa_id' => $request->get('mahasiswa_id'),
                'dosen_id' => $request->get('dosen_id'),
                'mata_kuliah_id' => $request->get('mata_kuliah_id'),
                'prodi_id' => $request->get('prodi_id'),
                'semester' => $request->get('semester'),
                'tanggal_dari' => $request->get('tanggal_dari'),
                'tanggal_sampai' => $request->get('tanggal_sampai'),
            ];

            // Create filename with timestamp
            $fileName = 'data_presensi_mahasiswa_' . date('Ymd_His') . '.xlsx';

            return Excel::download(new PresensiMahasiswaExport($filters), $fileName);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }
}