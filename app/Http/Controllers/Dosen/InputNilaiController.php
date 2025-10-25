<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\NilaiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Krs;
use App\Models\KrsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InputNilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->dosen) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai dosen');
        }
        
        $dosen = $user->dosen;
        
        // Get filter parameters
        $searchNama = $request->get('search_nama');
        $matakuliahId = $request->get('matakuliah_id');
        $prodiId = $request->get('prodi_id');
        
        // Build query
        $query = NilaiMahasiswa::with(['mahasiswa', 'mataKuliah', 'prodi'])
            ->where('dosen_id', $dosen->id);
        
        // Apply filters
        if ($searchNama) {
            $query->whereHas('mahasiswa', function($q) use ($searchNama) {
                $q->where('nama_lengkap', 'like', '%' . $searchNama . '%')
                  ->orWhere('nim', 'like', '%' . $searchNama . '%');
            });
        }
        
        if ($matakuliahId) {
            $query->where('mata_kuliah_id', $matakuliahId);
        }
        
        if ($prodiId) {
            $query->where('prodi_id', $prodiId);
        }
        
        // Get data - Fixed 15 items per page
        $nilaiList = $query->latest()->paginate(15);
        
        // Get mata kuliah list for filter - Get unique mata kuliah from nilai
        $matakuliahList = MataKuliah::select('id', 'kode_matakuliah', 'nama_matakuliah')
            ->whereIn('id', function($query) use ($dosen) {
                $query->select('mata_kuliah_id')
                    ->from('nilai_mahasiswa')
                    ->where('dosen_id', $dosen->id)
                    ->distinct();
            })
            ->get();
        
        // Get prodi list for filter - Get unique prodi from nilai
        $prodiList = Prodi::select('id', 'nama_prodi')
            ->whereIn('id', function($query) use ($dosen) {
                $query->select('prodi_id')
                    ->from('nilai_mahasiswa')
                    ->where('dosen_id', $dosen->id)
                    ->distinct();
            })
            ->get();
        
        return view('dosen.inputNilaiMahasiswa.index', compact(
            'nilaiList',
            'matakuliahList',
            'prodiList',
            'searchNama',
            'matakuliahId',
            'prodiId'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || !$user->dosen) {
            return redirect()->route('login')->with('error', 'Anda harus login sebagai dosen');
        }
        
        $dosen = $user->dosen;
        
        // Get filter parameters
        $prodiId = $request->get('prodi_id');
        $semester = $request->get('semester');
        $matakuliahId = $request->get('matakuliah_id');
        
        // Get list of prodi
        $prodiList = Prodi::all();
        
        // Get list of semester (1-8)
        $semesterList = range(1, 8);
        
        // Get mata kuliah based on prodi and semester from KRS that are approved
        $matakuliahList = [];
        if ($prodiId && $semester) {
            // Ambil mata kuliah dari KRS yang sudah disetujui untuk prodi dan semester tertentu
            $matakuliahList = MataKuliah::whereIn('id', function($query) use ($prodiId, $semester) {
                $query->select('krs_detail.mata_kuliah_id')
                    ->from('krs_detail')
                    ->join('krs', 'krs_detail.krs_id', '=', 'krs.id')
                    ->join('mahasiswa_profiles', 'krs.mahasiswa_id', '=', 'mahasiswa_profiles.id')
                    ->where('mahasiswa_profiles.prodi_id', $prodiId)
                    ->where('krs.semester', $semester)
                    ->where('krs.status_validasi', 'Disetujui')
                    ->distinct();
            })
            ->where('prodi_id', $prodiId)
            ->where('semester', $semester)
            ->get();
        }
        
        // Get mahasiswa based on filters - only those who have KRS for selected mata kuliah
        $mahasiswaList = collect();
        if ($prodiId && $semester && $matakuliahId) {
            // Ambil mahasiswa yang mengambil mata kuliah ini di KRS mereka yang sudah disetujui
            $mahasiswaList = Mahasiswa::where('prodi_id', $prodiId)
                ->where('status_mahasiswa', 'aktif')
                ->whereHas('krs', function($query) use ($matakuliahId, $semester) {
                    $query->where('semester', $semester)
                          ->where('status_validasi', 'Disetujui')
                          ->whereHas('krsDetail', function($subQuery) use ($matakuliahId) {
                              $subQuery->where('mata_kuliah_id', $matakuliahId);
                          });
                })
                ->get()
                ->map(function($mahasiswa) use ($dosen, $matakuliahId) {
                    // Check if nilai already exists
                    $existingNilai = NilaiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                        ->where('dosen_id', $dosen->id)
                        ->where('mata_kuliah_id', $matakuliahId)
                        ->first();
                    
                    $mahasiswa->existing_nilai = $existingNilai;
                    return $mahasiswa;
                });
        }
        
        // Get selected mata kuliah
        $selectedMatakuliah = null;
        if ($matakuliahId) {
            $selectedMatakuliah = MataKuliah::find($matakuliahId);
        }
        
        return view('dosen.inputNilaiMahasiswa.create', compact(
            'prodiList', 
            'semesterList', 
            'matakuliahList', 
            'mahasiswaList',
            'selectedMatakuliah',
            'prodiId',
            'semester',
            'matakuliahId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'prodi_id' => 'required|exists:prodi,id',
            'semester' => 'required|integer|min:1|max:8',
            'matakuliah_id' => 'required|exists:mata_kuliah,id',
            'tahun_ajaran' => 'required|string',
            'mahasiswa_id' => 'required|array',
            'mahasiswa_id.*' => 'required|exists:mahasiswa_profiles,id',
            'nilai_angka' => 'required|array',
            'nilai_angka.*' => 'required|numeric|min:0|max:100',
        ]);
        
        $dosen = Auth::user()->dosen;
        $successCount = 0;
        $updateCount = 0;
        
        DB::beginTransaction();
        try {
            foreach ($request->mahasiswa_id as $index => $mahasiswaId) {
                $nilaiAngka = $request->nilai_angka[$index];
                
                if (!empty($nilaiAngka)) {
                    $data = [
                        'mahasiswa_id' => $mahasiswaId,
                        'dosen_id' => $dosen->id,
                        'mata_kuliah_id' => $request->matakuliah_id,
                        'prodi_id' => $request->prodi_id,
                        'nilai_angka' => $nilaiAngka,
                        'semester' => $request->semester,
                        'tahun_ajaran' => $request->tahun_ajaran,
                    ];
                    
                    $existing = NilaiMahasiswa::where('mahasiswa_id', $mahasiswaId)
                        ->where('dosen_id', $dosen->id)
                        ->where('mata_kuliah_id', $request->matakuliah_id)
                        ->where('semester', $request->semester)
                        ->where('tahun_ajaran', $request->tahun_ajaran)
                        ->first();
                    
                    if ($existing) {
                        $existing->update($data);
                        $updateCount++;
                    } else {
                        NilaiMahasiswa::create($data);
                        $successCount++;
                    }
                }
            }
            
            DB::commit();
            
            $message = "Berhasil menyimpan {$successCount} nilai baru";
            if ($updateCount > 0) {
                $message .= " dan memperbarui {$updateCount} nilai";
            }
            
            return redirect()->route('dosen.inputNilai.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan nilai: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nilai = NilaiMahasiswa::with(['mahasiswa', 'mataKuliah', 'prodi', 'dosen'])
            ->findOrFail($id);
        
        return view('dosen.inputNilaiMahasiswa.show', compact('nilai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $nilai = NilaiMahasiswa::with(['mahasiswa', 'mataKuliah', 'prodi'])
            ->findOrFail($id);
        
        return view('dosen.inputNilaiMahasiswa.edit', compact('nilai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nilai_angka' => 'required|numeric|min:0|max:100',
            'tahun_ajaran' => 'required|string',
        ]);
        
        $nilai = NilaiMahasiswa::findOrFail($id);
        
        $nilai->update([
            'nilai_angka' => $request->nilai_angka,
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);
        
        return redirect()->route('dosen.inputNilai.index')
            ->with('success', 'Nilai berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nilai = NilaiMahasiswa::findOrFail($id);
        $nilai->delete();
        
        return redirect()->route('dosen.inputNilai.index')
            ->with('success', 'Nilai berhasil dihapus');
    }
    
    /**
     * Get mata kuliah by prodi and semester (AJAX)
     */
    public function getMatakuliah(Request $request)
    {
        $matakuliah = MataKuliah::where('prodi_id', $request->prodi_id)
            ->where('semester', $request->semester)
            ->get(['id', 'kode_matakuliah', 'nama_matakuliah', 'sks']);
        
        return response()->json($matakuliah);
    }
    
    /**
     * Get mahasiswa by prodi and semester (AJAX)
     * Filter only mahasiswa who have approved KRS for selected mata kuliah
     */
    public function getMahasiswaByProdiSemester(Request $request)
    {
        $prodiId = $request->prodi_id;
        $semester = $request->semester;
        $matakuliahId = $request->matakuliah_id;
        
        // Filter mahasiswa berdasarkan KRS yang disetujui dan mata kuliah yang dipilih
        $mahasiswa = Mahasiswa::with('prodi')
            ->where('prodi_id', $prodiId)
            ->where('status_mahasiswa', 'aktif')
            ->whereHas('krs', function($query) use ($semester, $matakuliahId) {
                $query->where('semester', $semester)
                      ->where('status_validasi', 'Disetujui')
                      ->whereHas('krsDetail', function($subQuery) use ($matakuliahId) {
                          $subQuery->where('mata_kuliah_id', $matakuliahId);
                      });
            })
            ->orderBy('nim')
            ->get(['id', 'nim', 'nama_lengkap', 'prodi_id', 'semester']);
        
        return response()->json($mahasiswa);
    }
}
