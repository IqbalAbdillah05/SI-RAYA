<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\Jadwal;
use App\Exports\KrsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class KrsController extends Controller
{
    /**
     * Menampilkan daftar KRS
     */
    public function index(Request $request)
    {
        $query = Krs::with(['mahasiswa.prodi', 'details.mataKuliah']);

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
                // Search di prodi (via mahasiswa)
                ->orWhereHas('mahasiswa.prodi', function($subQuery) use ($search) {
                    $subQuery->where('nama_prodi', 'like', '%' . $search . '%');
                })
                // Search di semester, tahun ajaran, status
                ->orWhere('semester', 'like', '%' . $search . '%')
                ->orWhere('tahun_ajaran', 'like', '%' . $search . '%')
                ->orWhere('status_validasi', 'like', '%' . $search . '%');
            });
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        $krs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Append query parameters to pagination links
        $krs->appends($request->only(['search', 'entries']));

        return view('admin.krs.index', compact('krs'));
    }

    /**
     * Menampilkan detail KRS
     */
    public function show(Krs $krs)
    {
        // Load relasi yang diperlukan
        $krs->load(['mahasiswa.prodi', 'details.mataKuliah']);

        return view('admin.krs.show', compact('krs'));
    }

    /**
     * Menampilkan form edit KRS
     */
    public function edit(Krs $krs)
    {
        $krs->load('details.mataKuliah');
        $mahasiswas = Mahasiswa::with(['user', 'prodi'])
            ->orderBy('nama_lengkap')
            ->get();
        
        $prodis = Prodi::orderBy('nama_prodi')->get();

        // Ambil semua mata kuliah
        $mataKuliah = \App\Models\MataKuliah::orderBy('kode_matakuliah')->get();

        return view('admin.krs.edit', compact('krs', 'mahasiswas', 'prodis', 'mataKuliah'));
    }

    /**
     * Update KRS
     */
    public function update(Request $request, Krs $krs)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:mahasiswa_profiles,id',
            'semester' => 'nullable|integer|min:1|max:14',
            'tahun_ajaran' => 'required|string|max:25',
            'tanggal_pengisian' => 'nullable|date',
            'mata_kuliah' => 'required|array|min:1',
            'mata_kuliah.*' => 'exists:mata_kuliah,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Hapus detail KRS lama
            $krs->details()->delete();

            // Update KRS
            $krs->update([
                'mahasiswa_id' => $request->mahasiswa_id,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'tanggal_pengisian' => $request->tanggal_pengisian ?? now(),
                'status_validasi' => 'Menunggu'
            ]);

            // Simpan detail KRS baru
            foreach ($request->mata_kuliah as $mataKuliahId) {
                KrsDetail::create([
                    'krs_id' => $krs->id,
                    'mata_kuliah_id' => $mataKuliahId
                ]);
            }

            DB::commit();

            return redirect()->route('admin.krs.index')
                ->with('success', 'KRS berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui KRS: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal memperbarui KRS: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus KRS
     */
    public function destroy(Krs $krs)
    {
        try {
            DB::beginTransaction();

            // Hapus detail KRS terlebih dahulu
            $krs->details()->delete();
            
            // Hapus KRS
            $krs->delete();

            DB::commit();

            return redirect()->route('admin.krs.index')
                ->with('success', 'KRS berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus KRS: ' . $e->getMessage());

            return redirect()->route('admin.krs.index')
                ->with('error', 'Gagal menghapus KRS: ' . $e->getMessage());
        }
    }

    /**
     * Validasi KRS
     */
    public function validate(Request $request, Krs $krs)
    {
        $validator = Validator::make($request->all(), [
            'status_validasi' => 'required|in:Disetujui,Ditolak'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $krs->update([
                'status_validasi' => $request->status_validasi
            ]);

            return redirect()->route('admin.krs.index')
                ->with('success', 'Status KRS berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Gagal memvalidasi KRS: ' . $e->getMessage());

            return redirect()->route('admin.krs.index')
                ->with('error', 'Gagal memvalidasi KRS: ' . $e->getMessage());
        }
    }

    /**
     * Export KRS data to Excel
     */
    public function export(Request $request)
    {
        try {
            // Get all filters from request
            $filters = [
                'search' => $request->get('search'),
            ];

            // Create filename with timestamp
            $fileName = 'data_krs_' . date('Ymd_His') . '.xlsx';

            return Excel::download(new KrsExport($filters), $fileName);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengekspor data: ' . $e->getMessage());
        }
    }
}
