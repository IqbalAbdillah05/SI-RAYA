<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\KrsDetail;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KrsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        // Ambil semua KRS mahasiswa
        $krsList = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->with(['details.mataKuliah'])
            ->orderBy('semester', 'desc')
            ->orderBy('tahun_ajaran', 'desc')
            ->get();

        return view('mahasiswa.krs.index', compact('mahasiswa', 'krsList'));
    }

    public function create()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        // Cek apakah sudah ada KRS untuk semester saat ini
        $existingKrs = Krs::where('mahasiswa_id', $mahasiswa->id)
            ->where('semester', $mahasiswa->semester)
            ->first();

        if ($existingKrs) {
            return redirect()->route('mahasiswa.krs.edit', $existingKrs->id)
                ->with('info', 'KRS untuk semester ini sudah ada. Silakan edit KRS yang sudah ada.');
        }

        // Ambil mata kuliah berdasarkan prodi dan semester
        $mataKuliahList = MataKuliah::where('prodi_id', $mahasiswa->prodi_id)
            ->where('semester', $mahasiswa->semester)
            ->orderBy('nama_matakuliah')
            ->get();

        return view('mahasiswa.krs.create', compact('mahasiswa', 'mataKuliahList'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        $request->validate([
            'mata_kuliah_ids' => 'required|array|min:1',
            'mata_kuliah_ids.*' => 'exists:mata_kuliah,id',
            'tahun_ajaran' => 'required|string',
        ], [
            'mata_kuliah_ids.required' => 'Pilih minimal 1 mata kuliah',
            'mata_kuliah_ids.min' => 'Pilih minimal 1 mata kuliah',
            'tahun_ajaran.required' => 'Tahun ajaran harus diisi',
        ]);

        DB::beginTransaction();
        try {
            // Cek apakah sudah ada KRS untuk semester ini
            $existingKrs = Krs::where('mahasiswa_id', $mahasiswa->id)
                ->where('semester', $mahasiswa->semester)
                ->first();

            if ($existingKrs) {
                DB::rollBack();
                return redirect()->back()->with('error', 'KRS untuk semester ini sudah ada');
            }

            // Buat KRS baru
            $krs = Krs::create([
                'mahasiswa_id' => $mahasiswa->id,
                'semester' => $mahasiswa->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'tanggal_pengisian' => now(),
                'status_validasi' => 'Menunggu'
            ]);

            // Simpan detail KRS
            foreach ($request->mata_kuliah_ids as $mataKuliahId) {
                KrsDetail::create([
                    'krs_id' => $krs->id,
                    'mata_kuliah_id' => $mataKuliahId
                ]);
            }

            DB::commit();
            return redirect()->route('mahasiswa.krs.show', $krs->id)
                ->with('success', 'KRS berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan KRS: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        $krs = Krs::where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->with(['details.mataKuliah'])
            ->firstOrFail();

        // Hitung total SKS
        $totalSks = $krs->details->sum(function($detail) {
            return $detail->mataKuliah->sks ?? 0;
        });

        return view('mahasiswa.krs.show', compact('mahasiswa', 'krs', 'totalSks'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        $krs = Krs::where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->with(['details.mataKuliah'])
            ->firstOrFail();

        // Ambil mata kuliah yang tersedia
        $mataKuliahList = MataKuliah::where('prodi_id', $mahasiswa->prodi_id)
            ->where('semester', $krs->semester)
            ->orderBy('nama_matakuliah')
            ->get();

        // Ambil ID mata kuliah yang sudah dipilih
        $selectedMataKuliahIds = $krs->details->pluck('mata_kuliah_id')->toArray();

        return view('mahasiswa.krs.edit', compact('mahasiswa', 'krs', 'mataKuliahList', 'selectedMataKuliahIds'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        $krs = Krs::where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->firstOrFail();

        $request->validate([
            'mata_kuliah_ids' => 'required|array|min:1',
            'mata_kuliah_ids.*' => 'exists:mata_kuliah,id',
            'tahun_ajaran' => 'required|string',
        ], [
            'mata_kuliah_ids.required' => 'Pilih minimal 1 mata kuliah',
            'mata_kuliah_ids.min' => 'Pilih minimal 1 mata kuliah',
            'tahun_ajaran.required' => 'Tahun ajaran harus diisi',
        ]);

        DB::beginTransaction();
        try {
            // Update KRS
            $krs->update([
                'tahun_ajaran' => $request->tahun_ajaran,
            ]);

            // Hapus detail lama
            $krs->details()->delete();

            // Simpan detail baru
            foreach ($request->mata_kuliah_ids as $mataKuliahId) {
                KrsDetail::create([
                    'krs_id' => $krs->id,
                    'mata_kuliah_id' => $mataKuliahId
                ]);
            }

            DB::commit();
            return redirect()->route('mahasiswa.krs.show', $krs->id)
                ->with('success', 'KRS berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui KRS: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        $krs = Krs::where('id', $id)
            ->where('mahasiswa_id', $mahasiswa->id)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            $krs->details()->delete();
            $krs->delete();

            DB::commit();
            return redirect()->route('mahasiswa.krs.index')
                ->with('success', 'KRS berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus KRS: ' . $e->getMessage());
        }
    }
}
