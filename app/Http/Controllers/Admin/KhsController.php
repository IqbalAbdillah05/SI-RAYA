<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Khs;
use App\Models\KhsDetail;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\NilaiMahasiswa;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\KrsDetail;

class KhsController extends Controller
{
    /**
     * Menampilkan daftar KHS
     */
    public function index(Request $request)
    {
        $query = Khs::with(['mahasiswa', 'prodi']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search di mahasiswa (nama_lengkap, nim)
                $q->whereHas('mahasiswa', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('nim', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%');
                })
                // Search di prodi
                ->orWhereHas('prodi', function($subQuery) use ($search) {
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
        $khs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Append query parameters to pagination links
        $khs->appends($request->only(['search', 'entries']));

        return view('admin.khs.index', compact('khs'));
    }

    /**
     * Menampilkan form tambah KHS
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::with(['user', 'prodi'])
            ->orderBy('nama_lengkap')
            ->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();

        // Ambil daftar mata kuliah dari KRS dan nilai mahasiswa
        $mataKuliah = [];
        $nilaiMahasiswa = [];
        $mahasiswaSemesters = [];

        foreach ($mahasiswas as $mahasiswa) {
            // Ambil semester mahasiswa
            $mahasiswaSemesters[$mahasiswa->id] = $mahasiswa->semester ?? 1;

            // Ambil mata kuliah dari KRS mahasiswa yang sudah disetujui
            $krsDetails = KrsDetail::whereHas('krs', function($query) use ($mahasiswa) {
                $query->where('mahasiswa_id', $mahasiswa->id)
                      ->where('status_validasi', 'Disetujui');
            })->with('mataKuliah')->get();

            // Map mata kuliah dari KRS
            $mataKuliah[$mahasiswa->id] = $krsDetails->map(function($detail) {
                return $detail->mataKuliah;
            })->unique('id')->values();

            // Ambil nilai mahasiswa untuk semester saat ini
            $nilaiMahasiswaQuery = NilaiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                ->where('semester', '<=', $mahasiswaSemesters[$mahasiswa->id])
                ->with('mataKuliah');

            // Simpan nilai mahasiswa
            $nilaiMahasiswa[$mahasiswa->id] = $nilaiMahasiswaQuery->get();
        }

        return view('admin.khs.create', compact('mahasiswas', 'prodis', 'mataKuliah', 'nilaiMahasiswa', 'mahasiswaSemesters'));
    }

    /**
     * Menyimpan KHS baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:mahasiswa_profiles,id',
            'prodi_id' => 'nullable|exists:prodi,id',
            'semester' => 'nullable|integer|min:1|max:14',
            'tahun_ajaran' => 'required|string|max:25',
            'mata_kuliah' => 'required|array',
            'mata_kuliah.*' => 'exists:mata_kuliah,id',
            'sks' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Jika prodi tidak dipilih, ambil dari mahasiswa
            $mahasiswa = Mahasiswa::findOrFail($request->mahasiswa_id);
            $prodiId = $request->prodi_id ?? $mahasiswa->prodi_id;
            $semester = $request->semester ?? $mahasiswa->semester ?? 1;

            // Hitung total SKS dan IPS
            $totalSks = 0;
            $totalNilaiIndeks = 0;

            // Buat KHS
            $khs = Khs::create([
                'mahasiswa_id' => $request->mahasiswa_id,
                'prodi_id' => $prodiId,
                'semester' => $semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status_validasi' => 'Menunggu'
            ]);

            // Simpan detail KHS
            foreach ($request->mata_kuliah as $index => $mataKuliahId) {
                $sks = $request->sks[$index];
                $nilaiMahasiswaId = $request->input("nilai_mahasiswa.{$index}");

                // Jika ada nilai mahasiswa, gunakan nilainya
                $nilaiAngka = $nilaiMahasiswaId 
                    ? NilaiMahasiswa::findOrFail($nilaiMahasiswaId)->nilai_angka 
                    : $request->input("nilai_angka.{$index}", 0);

                $nilaiHuruf = KhsDetail::konversiNilaiHuruf($nilaiAngka);
                $nilaiIndeks = KhsDetail::konversiNilaiIndeks($nilaiAngka);

                KhsDetail::create([
                    'khs_id' => $khs->id,
                    'mata_kuliah_id' => $mataKuliahId,
                    'nilai_mahasiswa_id' => $nilaiMahasiswaId,
                    'nilai_angka' => $nilaiAngka,
                    'sks' => $sks,
                    'nilai_huruf' => $nilaiHuruf,
                    'nilai_indeks' => $nilaiIndeks
                ]);

                // Akumulasi total SKS dan Nilai Indeks
                $totalSks += $sks;
                $totalNilaiIndeks += $nilaiIndeks * $sks;
            }

            // Hitung IPS
            $ips = $totalSks > 0 ? round($totalNilaiIndeks / $totalSks, 2) : 0;

            // Update total SKS dan IPS
            $khs->update([
                'total_sks' => $totalSks,
                'ips' => $ips
            ]);

            DB::commit();

            return redirect()->route('admin.khs.index')
                ->with('success', 'KHS berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan KHS: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal menyimpan KHS: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail KHS
     */
    public function show(Khs $khs)
    {
        // Load relasi yang diperlukan
        $khs->load(['mahasiswa', 'prodi', 'details.mataKuliah']);

        return view('admin.khs.show', compact('khs'));
    }

    /**
     * Menampilkan form edit KHS
     */
    public function edit(Khs $khs)
    {
        $khs->load('details');
        $mahasiswas = Mahasiswa::with(['user', 'prodi'])
            ->orderBy('nama_lengkap')
            ->get();
        $prodis = Prodi::orderBy('nama_prodi')->get();

        // Ambil daftar mata kuliah dan nilai mahasiswa
        $mataKuliah = [];
        $nilaiMahasiswa = [];
        $mahasiswaSemesters = [];

        foreach ($mahasiswas as $mahasiswa) {
            // Ambil semester mahasiswa
            $mahasiswaSemesters[$mahasiswa->id] = $mahasiswa->semester ?? 1;

            // Ambil nilai mahasiswa untuk semester saat ini
            $nilaiMahasiswaQuery = NilaiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                ->where('semester', '<=', $mahasiswaSemesters[$mahasiswa->id])
                ->with(['mataKuliah' => function($query) {
                    // Pastikan mata kuliah selalu memiliki sks
                    $query->select('id', 'kode_matakuliah', 'nama_matakuliah', 
                        \DB::raw('COALESCE(sks, 0) as sks'));
                }]);

            // Ambil mata kuliah yang ada di nilai mahasiswa
            $mataKuliah[$mahasiswa->id] = $nilaiMahasiswaQuery->get()
                ->map(function($nilai) {
                    // Pastikan mata kuliah memiliki default value
                    $mataKuliah = $nilai->mataKuliah ?? new \App\Models\MataKuliah();
                    $mataKuliah->sks = $mataKuliah->sks ?? 0;
                    return $mataKuliah;
                })
                ->unique('id')
                ->values();

            // Simpan nilai mahasiswa dengan transformasi
            $nilaiMahasiswa[$mahasiswa->id] = $nilaiMahasiswaQuery->get()
                ->map(function($nm) {
                    // Pastikan mata kuliah selalu ada
                    $nm->mata_kuliah = $nm->mataKuliah ?? new \App\Models\MataKuliah([
                        'kode_mata_kuliah' => '',
                        'nama_mata_kuliah' => '',
                        'sks' => 0
                    ]);
                    return $nm;
                });
        }

        return view('admin.khs.edit', compact('khs', 'mahasiswas', 'prodis', 'mataKuliah', 'nilaiMahasiswa', 'mahasiswaSemesters'));
    }

    /**
     * Update KHS
     */
    public function update(Request $request, Khs $khs)
    {
        // Validasi input (sama seperti store)
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:mahasiswa_profiles,id',
            'prodi_id' => 'required|exists:prodi,id',
            'semester' => 'required|integer|min:1|max:14',
            'tahun_ajaran' => 'required|string|max:25',
            'mata_kuliah' => 'required|array',
            'mata_kuliah.*' => 'exists:mata_kuliah,id',
            'nilai_angka' => 'required|array',
            'sks' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Hapus detail KHS lama
            $khs->details()->delete();

            // Hitung total SKS dan IPS
            $totalSks = 0;
            $totalNilaiIndeks = 0;

            // Update data KHS
            $khs->update([
                'mahasiswa_id' => $request->mahasiswa_id,
                'prodi_id' => $request->prodi_id,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'status_validasi' => 'Menunggu'
            ]);

            // Simpan detail KHS baru
            foreach ($request->mata_kuliah as $index => $mataKuliahId) {
                $nilaiAngka = $request->nilai_angka[$index];
                $sks = $request->sks[$index];

                $nilaiHuruf = KhsDetail::konversiNilaiHuruf($nilaiAngka);
                $nilaiIndeks = KhsDetail::konversiNilaiIndeks($nilaiAngka);

                KhsDetail::create([
                    'khs_id' => $khs->id,
                    'mata_kuliah_id' => $mataKuliahId,
                    'nilai_angka' => $nilaiAngka,
                    'sks' => $sks,
                    'nilai_huruf' => $nilaiHuruf,
                    'nilai_indeks' => $nilaiIndeks
                ]);

                // Akumulasi total SKS dan Nilai Indeks
                $totalSks += $sks;
                $totalNilaiIndeks += $nilaiIndeks * $sks;
            }

            // Hitung IPS
            $ips = $totalSks > 0 ? round($totalNilaiIndeks / $totalSks, 2) : 0;

            // Update total SKS dan IPS
            $khs->update([
                'total_sks' => $totalSks,
                'ips' => $ips
            ]);

            DB::commit();

            return redirect()->route('admin.khs.index')
                ->with('success', 'KHS berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui KHS: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal memperbarui KHS: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus KHS
     */
    public function destroy(Khs $khs)
    {
        try {
            DB::beginTransaction();

            // Hapus detail KHS terlebih dahulu
            $khs->details()->delete();
            
            // Hapus KHS
            $khs->delete();

            DB::commit();

            return redirect()->route('admin.khs.index')
                ->with('success', 'KHS berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menghapus KHS: ' . $e->getMessage());

            return redirect()->route('admin.khs.index')
                ->with('error', 'Gagal menghapus KHS: ' . $e->getMessage());
        }
    }

    /**
     * Validasi KHS
     */
    public function validate(Request $request, Khs $khs)
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
            $khs->update([
                'status_validasi' => $request->status_validasi
            ]);

            return redirect()->route('admin.khs.index')
                ->with('success', 'Status KHS berhasil diperbarui');

        } catch (\Exception $e) {
            Log::error('Gagal memvalidasi KHS: ' . $e->getMessage());

            return redirect()->route('admin.khs.index')
                ->with('error', 'Gagal memvalidasi KHS: ' . $e->getMessage());
        }
    }
}
