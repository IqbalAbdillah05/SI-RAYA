<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PresensiDosen;
use App\Models\User;
use App\Models\Lokasi;
use App\Exports\PresensiDosenExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ManajemenPresensiDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PresensiDosen::with(['dosen', 'lokasi']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('dosen', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%')
                             ->orWhere('nidn', 'like', '%' . $search . '%');
                })
                ->orWhereHas('lokasi', function($subQuery) use ($search) {
                    $subQuery->where('nama_lokasi', 'like', '%' . $search . '%');
                })
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('keterangan', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by dosen
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }

        // Filter by lokasi
        if ($request->filled('lokasi_id')) {
            $query->where('lokasi_id', $request->lokasi_id);
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
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();
        
        // Tambahkan data untuk filter bulan dan tahun
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $years = range(date('Y') - 5, date('Y') + 1);
        
        $presensiDosens = $query->latest('waktu_presensi')->paginate($perPage);

        // Append query parameters to pagination links
        $presensiDosens->appends($request->only([
            'search', 'entries', 'status', 'dosen_id', 'lokasi_id', 
            'tanggal_dari', 'tanggal_sampai', 'bulan', 'tahun'
        ]));
        
        return view('admin.manajemenPresensiDosen.index', compact(
            'presensiDosens', 'dosens', 'lokasis', 
            'months', 'years'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();
        
        return view('admin.manajemenPresensiDosen.create', compact('dosens', 'lokasis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi berbeda berdasarkan status
        $rules = [
            'dosen_id' => 'required|exists:users,id',
            'waktu_presensi' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'presensi_ke' => 'nullable|in:ke-1,ke-2',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Lokasi, koordinat, dan jarak hanya required jika status hadir atau alpha
        if (in_array($request->status, ['hadir', 'alpha'])) {
            $rules['lokasi_id'] = 'required|exists:lokasi_presensi,id';
            $rules['latitude'] = 'nullable|numeric|between:-90,90';
            $rules['longitude'] = 'nullable|numeric|between:-180,180';
            $rules['jarak_masuk'] = 'nullable|numeric|min:0';
        } else {
            // Untuk izin/sakit, lokasi tidak wajib
            $rules['lokasi_id'] = 'nullable|exists:lokasi_presensi,id';
            $rules['latitude'] = 'nullable|numeric|between:-90,90';
            $rules['longitude'] = 'nullable|numeric|between:-180,180';
            $rules['jarak_masuk'] = 'nullable|numeric|min:0';
        }

        $validated = $request->validate($rules);

        try {
            // Set default values untuk izin/sakit
            if (in_array($validated['status'], ['izin', 'sakit'])) {
                $validated['lokasi_id'] = null;
                $validated['latitude'] = 0;
                $validated['longitude'] = 0;
                $validated['jarak_masuk'] = 0;
            }

            // Handle foto bukti upload
            if ($request->hasFile('foto_bukti')) {
                $path = $request->file('foto_bukti')->store('presensi-dosen/bukti', 'public');
                $validated['foto_bukti'] = $path;
            }

            // Cek jumlah presensi hari ini
            $presensiHariIni = PresensiDosen::where('dosen_id', $validated['dosen_id'])
                ->whereDate('waktu_presensi', now()->toDateString())
                ->count();

            // Tentukan presensi ke-1 atau ke-2 jika tidak ditentukan
            if (!isset($validated['presensi_ke'])) {
                $validated['presensi_ke'] = $presensiHariIni == 0 ? 'ke-1' : 'ke-2';
            }

            if ($presensiHariIni >= 2) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Dosen sudah melakukan presensi 2 kali hari ini');
            }

            PresensiDosen::create($validated);

            return redirect()
                ->route('admin.manajemen-presensi-dosen.index')
                ->with('success', 'Data presensi berhasil ditambahkan');
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
    public function show(PresensiDosen $manajemenPresensi)
    {
        // Gunakan relasi yang benar dari model
        $manajemenPresensi->load(['dosen', 'lokasi']);
        
        return view('admin.manajemenPresensiDosen.show', [
            'presensi' => $manajemenPresensi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PresensiDosen $manajemenPresensi)
    {
        $dosens = User::where('role', 'dosen')->orderBy('name')->get();
        $lokasis = Lokasi::orderBy('nama_lokasi')->get();
        
        return view('admin.manajemenPresensiDosen.edit', [
            'presensi' => $manajemenPresensi,
            'dosens' => $dosens,
            'lokasis' => $lokasis
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PresensiDosen $manajemenPresensi)
    {
        // Validasi berbeda berdasarkan status
        $rules = [
            'dosen_id' => 'required|exists:users,id',
            'waktu_presensi' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'presensi_ke' => 'nullable|in:ke-1,ke-2',
            'keterangan' => 'nullable|string|max:255',
            'foto_bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Lokasi, koordinat, dan jarak hanya required jika status hadir atau alpha
        if (in_array($request->status, ['hadir', 'alpha'])) {
            $rules['lokasi_id'] = 'required|exists:lokasi_presensi,id';
            $rules['latitude'] = 'nullable|numeric|between:-90,90';
            $rules['longitude'] = 'nullable|numeric|between:-180,180';
            $rules['jarak_masuk'] = 'nullable|numeric|min:0';
        } else {
            // Untuk izin/sakit, lokasi tidak wajib
            $rules['lokasi_id'] = 'nullable|exists:lokasi_presensi,id';
            $rules['latitude'] = 'nullable|numeric|between:-90,90';
            $rules['longitude'] = 'nullable|numeric|between:-180,180';
            $rules['jarak_masuk'] = 'nullable|numeric|min:0';
        }

        $validated = $request->validate($rules);

        try {
            // Set default values untuk izin/sakit
            if (in_array($validated['status'], ['izin', 'sakit'])) {
                $validated['lokasi_id'] = null;
                $validated['latitude'] = 0;
                $validated['longitude'] = 0;
                $validated['jarak_masuk'] = 0;
            }

            // Handle foto bukti upload
            if ($request->hasFile('foto_bukti')) {
                // Delete old file if exists
                if ($manajemenPresensi->foto_bukti) {
                    Storage::delete('public/' . $manajemenPresensi->foto_bukti);
                }
                
                $path = $request->file('foto_bukti')->store('presensi-dosen/bukti', 'public');
                $validated['foto_bukti'] = $path;
            }

            // If status is changed to 'hadir' or 'alpha', remove foto_bukti
            if (in_array($validated['status'], ['hadir', 'alpha']) && $manajemenPresensi->foto_bukti) {
                Storage::delete('public/' . $manajemenPresensi->foto_bukti);
                $validated['foto_bukti'] = null;
            }

            $manajemenPresensi->update($validated);

            return redirect()
                ->route('admin.manajemen-presensi-dosen.index')
                ->with('success', 'Data presensi berhasil diperbarui');
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
    public function destroy(PresensiDosen $manajemenPresensi)
    {
        try {
            $manajemenPresensi->delete();

            return redirect()
                ->route('admin.manajemen-presensi-dosen.index')
                ->with('success', 'Data presensi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data presensi: ' . $e->getMessage());
        }
    }

    /**
     * Export presensi dosen data to Excel
     */
    public function export(Request $request)
    {
        try {
            // Get all filters from request
            $filters = [
                'search' => $request->get('search'),
                'status' => $request->get('status'),
                'dosen_id' => $request->get('dosen_id'),
                'lokasi_id' => $request->get('lokasi_id'),
                'tanggal_dari' => $request->get('tanggal_dari'),
                'tanggal_sampai' => $request->get('tanggal_sampai'),
            ];

            // Create filename with timestamp
            $fileName = 'data_presensi_dosen_' . date('Ymd_His') . '.xlsx';

            return Excel::download(new PresensiDosenExport($filters), $fileName);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }
}