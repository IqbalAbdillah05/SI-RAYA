<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PresensiMahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PresensiMahasiswaController extends Controller
{
    /**
     * Menampilkan daftar presensi mahasiswa
     */
    public function index(Request $request)
    {
        try {
            // Ambil mahasiswa yang sedang login
            $mahasiswa = Auth::user()->mahasiswaProfile;

            // Pastikan mahasiswa memiliki profile
            if (!$mahasiswa) {
                return redirect()
                    ->route('mahasiswa.dashboard')
                    ->with('error', 'Profil mahasiswa tidak ditemukan');
            }

            // Ambil riwayat presensi
            $presensiQuery = PresensiMahasiswa::with(['mataKuliah', 'dosen'])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->orderBy('waktu_presensi', 'desc');

            // Ambil data presensi dengan pagination
            $presensi = $presensiQuery->paginate(10);

            return view('Mahasiswa.presensiMahasiswa.index', compact('presensi'));
        } catch (\Exception $e) {
            Log::error('Error in PresensiMahasiswaController index method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('mahasiswa.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan riwayat presensi mahasiswa
     */
    public function riwayat(Request $request)
    {
        try {
            // Ambil mahasiswa yang sedang login
            $mahasiswa = Auth::user()->mahasiswaProfile;

            // Pastikan mahasiswa memiliki profile
            if (!$mahasiswa) {
                return redirect()
                    ->route('mahasiswa.dashboard')
                    ->with('error', 'Profil mahasiswa tidak ditemukan');
            }

            // Tentukan jumlah baris per halaman
            $rowsPerPage = $request->input('rows', 10);
            $rowsPerPage = in_array($rowsPerPage, [10, 25, 50, 100]) ? $rowsPerPage : 10;

            // Ambil riwayat presensi
            $presensiQuery = PresensiMahasiswa::with(['mataKuliah', 'dosen'])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->orderBy('waktu_presensi', 'desc');

            // Filter semester jika diperlukan
            $semester = $request->input('semester');
            if ($semester) {
                $presensiQuery->where('semester', $semester);
            }

            // Filter status jika diperlukan
            $status = $request->input('status');
            if ($status) {
                $presensiQuery->where('status', $status);
            }

            // Ambil data presensi dengan pagination
            $presensi = $presensiQuery->paginate($rowsPerPage);

            // Tambahkan parameter ke pagination links
            $presensi->appends($request->only(['semester', 'status', 'rows']));

            // Opsi filter semester
            $semesters = range(1, 8);

            // Opsi filter status
            $statusOptions = [
                'hadir' => 'Hadir',
                'izin' => 'Izin',
                'sakit' => 'Sakit',
                'alpha' => 'Alpha'
            ];

            // Hitung statistik presensi
            $statistikPresensi = [
                'total' => PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->count(),
                'hadir' => PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->where('status', 'hadir')->count(),
                'izin' => PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->where('status', 'izin')->count(),
                'sakit' => PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->where('status', 'sakit')->count(),
                'alpha' => PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)->where('status', 'alpha')->count(),
            ];

            // Hitung persentase kehadiran
            if ($statistikPresensi['total'] > 0) {
                $statistikPresensi['persentase_hadir'] = round(($statistikPresensi['hadir'] / $statistikPresensi['total']) * 100, 2);
            } else {
                $statistikPresensi['persentase_hadir'] = 0;
            }

            return view('Mahasiswa.presensiMahasiswa.riwayat', compact(
                'presensi', 
                'semesters', 
                'statusOptions',
                'statistikPresensi'
            ));
        } catch (\Exception $e) {
            Log::error('Error in PresensiMahasiswaController riwayat method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->route('mahasiswa.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form tambah presensi
     */
    public function create()
    {
        try {
            $mahasiswa = Auth::user()->mahasiswaProfile;

            if (!$mahasiswa) {
                return redirect()
                    ->route('mahasiswa.dashboard')
                    ->with('error', 'Profil mahasiswa tidak ditemukan');
            }

            // Ambil mata kuliah yang bisa diajukan presensi
            // Sesuaikan dengan struktur database Anda
            $mataKuliah = MataKuliah::all();

            return view('Mahasiswa.presensiMahasiswa.create', compact('mataKuliah'));
        } catch (\Exception $e) {
            Log::error('Error in PresensiMahasiswaController create method', [
                'message' => $e->getMessage()
            ]);

            return redirect()
                ->route('mahasiswa.presensi.riwayat')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menyimpan presensi baru
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:500',
            'tanggal' => 'nullable|date'
        ], [
            'mata_kuliah_id.required' => 'Mata kuliah harus dipilih',
            'mata_kuliah_id.exists' => 'Mata kuliah tidak valid',
            'status.required' => 'Status presensi harus dipilih',
            'status.in' => 'Status presensi tidak valid',
            'keterangan.max' => 'Keterangan maksimal 500 karakter',
            'tanggal.date' => 'Format tanggal tidak valid'
        ]);

        try {
            DB::beginTransaction();

            $mahasiswa = Auth::user()->mahasiswaProfile;

            if (!$mahasiswa) {
                return redirect()
                    ->route('mahasiswa.dashboard')
                    ->with('error', 'Profil mahasiswa tidak ditemukan');
            }

            // Cek apakah sudah ada presensi untuk mata kuliah dan tanggal yang sama
            $tanggal = $validatedData['tanggal'] ?? now()->format('Y-m-d');
            $existingPresensi = PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                ->where('mata_kuliah_id', $validatedData['mata_kuliah_id'])
                ->whereDate('waktu_presensi', $tanggal)
                ->first();

            if ($existingPresensi) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Anda sudah melakukan presensi untuk mata kuliah ini pada tanggal tersebut');
            }

            $presensi = PresensiMahasiswa::create([
                'mahasiswa_id' => $mahasiswa->id,
                'mata_kuliah_id' => $validatedData['mata_kuliah_id'],
                'status' => $validatedData['status'],
                'keterangan' => $validatedData['keterangan'] ?? null,
                'waktu_presensi' => $tanggal,
                'semester' => $mahasiswa->semester ?? 1
            ]);

            DB::commit();

            return redirect()
                ->route('mahasiswa.presensi.riwayat')
                ->with('success', 'Presensi berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in PresensiMahasiswaController store method', [
                'message' => $e->getMessage(),
                'data' => $validatedData
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan presensi: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail presensi
     */
    public function show($id)
    {
        try {
            $mahasiswa = Auth::user()->mahasiswaProfile;

            $presensi = PresensiMahasiswa::with(['mataKuliah', 'dosen', 'mahasiswa'])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->findOrFail($id);

            return view('Mahasiswa.presensiMahasiswa.show', compact('presensi'));
        } catch (\Exception $e) {
            Log::error('Error in PresensiMahasiswaController show method', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return redirect()
                ->route('mahasiswa.presensi.riwayat')
                ->with('error', 'Presensi tidak ditemukan');
        }
    }

    /**
     * Menampilkan form edit presensi
     */
    public function edit($id)
    {
        try {
            $mahasiswa = Auth::user()->mahasiswaProfile;

            $presensi = PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                ->findOrFail($id);

            $mataKuliah = MataKuliah::all();

            return view('Mahasiswa.presensiMahasiswa.edit', compact('presensi', 'mataKuliah'));
        } catch (\Exception $e) {
            Log::error('Error in PresensiMahasiswaController edit method', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return redirect()
                ->route('mahasiswa.presensi.riwayat')
                ->with('error', 'Presensi tidak ditemukan');
        }
    }

    /**
     * Memperbarui presensi
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:500'
        ], [
            'status.required' => 'Status presensi harus dipilih',
            'status.in' => 'Status presensi tidak valid',
            'keterangan.max' => 'Keterangan maksimal 500 karakter'
        ]);

        try {
            DB::beginTransaction();

            $mahasiswa = Auth::user()->mahasiswaProfile;

            $presensi = PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                ->findOrFail($id);

            $presensi->update($validatedData);

            DB::commit();

            return redirect()
                ->route('mahasiswa.presensi.riwayat')
                ->with('success', 'Presensi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in PresensiMahasiswaController update method', [
                'message' => $e->getMessage(),
                'id' => $id,
                'data' => $validatedData
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui presensi: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus presensi
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $mahasiswa = Auth::user()->mahasiswaProfile;

            $presensi = PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                ->findOrFail($id);

            $presensi->delete();

            DB::commit();

            return redirect()
                ->route('mahasiswa.presensi.riwayat')
                ->with('success', 'Presensi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in PresensiMahasiswaController destroy method', [
                'message' => $e->getMessage(),
                'id' => $id
            ]);

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus presensi: ' . $e->getMessage());
        }
    }

    /**
     * Filter presensi secara realtime (AJAX)
     */
    public function filterPresensi(Request $request)
    {
        try {
            $mahasiswa = Auth::user()->mahasiswaProfile;

            if (!$mahasiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil mahasiswa tidak ditemukan'
                ], 404);
            }

            // Tentukan jumlah baris per halaman
            $rowsPerPage = $request->input('rows', 10);
            $rowsPerPage = in_array($rowsPerPage, [10, 25, 50, 100]) ? $rowsPerPage : 10;

            // Query presensi
            $presensiQuery = PresensiMahasiswa::with(['mataKuliah', 'dosen'])
                ->where('mahasiswa_id', $mahasiswa->id)
                ->orderBy('waktu_presensi', 'desc');

            // Filter semester
            if ($request->filled('semester')) {
                $presensiQuery->where('semester', $request->semester);
            }

            // Filter status
            if ($request->filled('status')) {
                $presensiQuery->where('status', $request->status);
            }

            // Pagination
            $presensi = $presensiQuery->paginate($rowsPerPage);

            // Format data untuk response
            $data = $presensi->map(function ($item) {
                return [
                    'id' => $item->id,
                    'mata_kuliah' => [
                        'nama' => $item->mataKuliah->nama_matakuliah ?? '-',
                        'kode' => $item->mataKuliah->kode_matakuliah ?? ''
                    ],
                    'dosen' => $item->dosen->nama_lengkap ?? '-',
                    'waktu_presensi' => \Carbon\Carbon::parse($item->waktu_presensi)->format('d M Y, H:i'),
                    'semester' => $item->semester,
                    'status' => $item->status,
                    'keterangan' => $item->keterangan ?? '-'
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'pagination' => [
                    'current_page' => $presensi->currentPage(),
                    'last_page' => $presensi->lastPage(),
                    'per_page' => $presensi->perPage(),
                    'total' => $presensi->total(),
                    'from' => $presensi->firstItem(),
                    'to' => $presensi->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in filterPresensi method', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memfilter presensi'
            ], 500);
        }
    }

    /**
     * Mendapatkan mata kuliah untuk dropdown
     */
    public function getMatakuliah()
    {
        try {
            $mahasiswa = Auth::user()->mahasiswaProfile;

            if (!$mahasiswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil mahasiswa tidak ditemukan'
                ], 404);
            }

            // Ambil mata kuliah sesuai prodi dan semester mahasiswa
            // Sesuaikan dengan struktur database Anda
            $mataKuliah = MataKuliah::select('id', 'nama_matakuliah', 'kode_matakuliah')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $mataKuliah
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getMatakuliah method', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data mata kuliah'
            ], 500);
        }
    }

    /**
     * Mendapatkan mahasiswa berdasarkan prodi dan semester
     */
    public function getMahasiswaByProdiSemester(Request $request)
    {
        try {
            $prodiId = $request->input('prodi_id');
            $semester = $request->input('semester');

            // Implementasi sesuai kebutuhan
            // Biasanya digunakan untuk keperluan admin atau dosen
            $mahasiswa = [];

            return response()->json([
                'success' => true,
                'data' => $mahasiswa
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getMahasiswaByProdiSemester method', [
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data mahasiswa'
            ], 500);
        }
    }
}