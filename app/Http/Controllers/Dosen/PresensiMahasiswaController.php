<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PresensiMahasiswa;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Jadwal;
use App\Models\Krs;
use App\Models\KrsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PresensiMahasiswaController extends Controller
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
        
        // Get list of prodi
        $prodiList = Prodi::all();
        
        // Get daftar presensi yang sudah dilakukan
        $presensiList = PresensiMahasiswa::with(['mahasiswa', 'mataKuliah', 'prodi'])
            ->where('dosen_id', $dosen->id)
            ->latest('waktu_presensi')
            ->paginate(15);
        
        // Group presensi by date, mata kuliah, and prodi for summary
        $presensiSummary = PresensiMahasiswa::select(
                DB::raw('DATE(waktu_presensi) as tanggal'),
                'mata_kuliah_id',
                'prodi_id',
                'semester',
                DB::raw('COUNT(*) as total_mahasiswa'),
                DB::raw('SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) as hadir'),
                DB::raw('SUM(CASE WHEN status = "izin" THEN 1 ELSE 0 END) as izin'),
                DB::raw('SUM(CASE WHEN status = "sakit" THEN 1 ELSE 0 END) as sakit'),
                DB::raw('SUM(CASE WHEN status = "alpha" THEN 1 ELSE 0 END) as alpha')
            )
            ->where('dosen_id', $dosen->id)
            ->with(['mataKuliah', 'prodi'])
            ->groupBy('tanggal', 'mata_kuliah_id', 'prodi_id', 'semester')
            ->orderBy('tanggal', 'desc')
            ->paginate(15);
        
        return view('dosen.presensiMahasiswa.index', compact('prodiList', 'presensiList', 'presensiSummary'));
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
        
        // Get mata kuliah based on dosen's jadwal
        $matakuliahList = [];
        if ($prodiId && $semester) {
            $matakuliahList = MataKuliah::whereHas('jadwal', function($query) use ($dosen, $prodiId, $semester) {
                $query->where('dosen_id', $dosen->id)
                    ->where('prodi_id', $prodiId)
                    ->where('semester', $semester);
            })->get();
        }
        
        // Get mahasiswa based on filters - only those who have approved KRS
        $mahasiswaList = collect();
        if ($prodiId && $semester && $matakuliahId) {
            // Ambil mahasiswa yang mengambil mata kuliah ini di KRS mereka yang sudah disetujui
            $mahasiswaList = Mahasiswa::where('prodi_id', $prodiId)
                ->where('status_mahasiswa', 'aktif')
                ->whereHas('krs', function($query) use ($semester, $matakuliahId) {
                    $query->where('semester', $semester)
                          ->where('status_validasi', 'Disetujui')
                          ->whereHas('krsDetail', function($subQuery) use ($matakuliahId) {
                              $subQuery->where('mata_kuliah_id', $matakuliahId);
                          });
                })
                ->orderBy('nim')
                ->get()
                ->map(function($mahasiswa) use ($dosen, $matakuliahId) {
                    // Check if presensi already exists today
                    $today = Carbon::today();
                    $existingPresensi = PresensiMahasiswa::where('mahasiswa_id', $mahasiswa->id)
                        ->where('dosen_id', $dosen->id)
                        ->where('mata_kuliah_id', $matakuliahId)
                        ->whereDate('waktu_presensi', $today)
                        ->first();
                    
                    $mahasiswa->existing_presensi = $existingPresensi;
                    return $mahasiswa;
                });
        }
        
        // Get selected mata kuliah
        $selectedMatakuliah = null;
        if ($matakuliahId) {
            $selectedMatakuliah = MataKuliah::find($matakuliahId);
        }
        
        return view('dosen.presensiMahasiswa.create', compact(
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
            'tanggal_presensi' => 'required|date',
            'mahasiswa_id' => 'required|array',
            'mahasiswa_id.*' => 'required|exists:mahasiswa_profiles,id',
            'status' => 'required|array',
            'status.*' => 'required|in:hadir,izin,sakit,alpha',
            'foto_bukti.*' => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // max 2MB
        ]);
        
        // Custom validation: foto_bukti required for sakit/izin status
        foreach ($request->status as $index => $status) {
            if (($status == 'sakit' || $status == 'izin') && !$request->hasFile("foto_bukti.{$index}")) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['foto_bukti' => "Foto bukti wajib dilampirkan untuk mahasiswa dengan status {$status}."]);
            }
        }
        
        $dosen = Auth::user()->dosen;
        $successCount = 0;
        $updateCount = 0;
        $skippedCount = 0;
        $skippedMahasiswa = [];
        
        DB::beginTransaction();
        try {
            // Waktu presensi otomatis menggunakan waktu server saat ini
            // Tapi tetap menggunakan tanggal yang dipilih user
            $tanggalDipilih = Carbon::parse($request->tanggal_presensi)->format('Y-m-d');
            $waktuSekarang = Carbon::now()->format('H:i:s');
            $waktuPresensi = Carbon::parse($tanggalDipilih . ' ' . $waktuSekarang);
            
            foreach ($request->mahasiswa_id as $index => $mahasiswaId) {
                $status = $request->status[$index];
                $keterangan = $request->keterangan[$index] ?? null;
                
                // Cek apakah mahasiswa sudah dipresensi di tanggal dan mata kuliah yang sama
                $existing = PresensiMahasiswa::where('mahasiswa_id', $mahasiswaId)
                    ->where('mata_kuliah_id', $request->matakuliah_id)
                    ->whereDate('waktu_presensi', $request->tanggal_presensi)
                    ->first();
                
                if ($existing) {
                    // Skip mahasiswa yang sudah dipresensi
                    $mahasiswa = Mahasiswa::find($mahasiswaId);
                    $skippedMahasiswa[] = $mahasiswa->nama_lengkap . ' (' . $mahasiswa->nim . ')';
                    $skippedCount++;
                    continue;
                }
                
                $data = [
                    'mahasiswa_id' => $mahasiswaId,
                    'dosen_id' => $dosen->id,
                    'mata_kuliah_id' => $request->matakuliah_id,
                    'prodi_id' => $request->prodi_id,
                    'status' => $status,
                    'semester' => $request->semester,
                    'waktu_presensi' => $waktuPresensi,
                    'keterangan' => $keterangan,
                ];
                
                // Handle upload foto bukti untuk status izin atau sakit
                if (($status == 'izin' || $status == 'sakit') && $request->hasFile("foto_bukti.{$index}")) {
                    $file = $request->file("foto_bukti.{$index}");
                    
                    // Generate unique filename
                    $mahasiswa = Mahasiswa::find($mahasiswaId);
                    $filename = 'presensi_' . $mahasiswa->nim . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    
                    // Store file
                    $path = $file->storeAs('presensi/mahasiswa', $filename, 'public');
                    $data['foto_bukti'] = $path;
                }
                
                // Create new presensi
                PresensiMahasiswa::create($data);
                $successCount++;
            }
            
            DB::commit();
            
            $message = "Berhasil menyimpan {$successCount} presensi";
            if ($skippedCount > 0) {
                $message .= ". {$skippedCount} mahasiswa dilewati (sudah presensi hari ini)";
                if (count($skippedMahasiswa) <= 5) {
                    $message .= ": " . implode(', ', $skippedMahasiswa);
                }
            }
            
            return redirect()->route('dosen.presensiMahasiswa.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menyimpan presensi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $presensi = PresensiMahasiswa::with(['mahasiswa', 'mataKuliah', 'prodi', 'dosen'])
            ->findOrFail($id);
        
        return view('dosen.presensiMahasiswa.show', compact('presensi'));
    }

    /**
     * Show riwayat presensi mahasiswa
     */
    public function riwayat(Request $request)
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
        $query = PresensiMahasiswa::with(['mahasiswa', 'mataKuliah', 'prodi'])
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
        $presensiList = $query->latest('waktu_presensi')->paginate(15);
        
        // Get mata kuliah list for filter
        $matakuliahList = MataKuliah::select('id', 'kode_matakuliah', 'nama_matakuliah')
            ->whereHas('presensiMahasiswa', function($q) use ($dosen) {
                $q->where('dosen_id', $dosen->id);
            })
            ->get();
        
        // Get prodi list for filter - Get unique prodi from presensi
        $prodiList = Prodi::select('id', 'nama_prodi')
            ->whereIn('id', function($query) use ($dosen) {
                $query->select('prodi_id')
                    ->from('presensi_mahasiswa')
                    ->where('dosen_id', $dosen->id)
                    ->distinct();
            })
            ->get();
        
        return view('dosen.presensiMahasiswa.riwayat', compact(
            'presensiList', 
            'matakuliahList',
            'prodiList',
            'searchNama',
            'matakuliahId',
            'prodiId'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presensi = PresensiMahasiswa::with(['mahasiswa', 'mataKuliah', 'prodi'])
            ->findOrFail($id);
        
        return view('dosen.presensiMahasiswa.edit', compact('presensi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        
        // Custom validation: foto_bukti required for sakit/izin status if changing to those statuses
        if (($request->status == 'sakit' || $request->status == 'izin') && $request->hasFile('foto_bukti') == false) {
            $presensi = PresensiMahasiswa::findOrFail($id);
            // If no existing foto and no new file uploaded
            if (!$presensi->foto_bukti) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['foto_bukti' => "Foto bukti wajib dilampirkan untuk status {$request->status}."]);
            }
        }
        
        $presensi = PresensiMahasiswa::findOrFail($id);
        
        $data = [
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];
        
        // Handle upload foto bukti untuk status izin atau sakit
        if (($request->status == 'izin' || $request->status == 'sakit') && $request->hasFile('foto_bukti')) {
            // Delete old foto if exists
            if ($presensi->foto_bukti && Storage::disk('public')->exists($presensi->foto_bukti)) {
                Storage::disk('public')->delete($presensi->foto_bukti);
            }
            
            $file = $request->file('foto_bukti');
            
            // Generate unique filename
            $mahasiswa = $presensi->mahasiswa;
            $filename = 'presensi_' . $mahasiswa->nim . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store file
            $path = $file->storeAs('presensi/mahasiswa', $filename, 'public');
            $data['foto_bukti'] = $path;
        } elseif ($request->status == 'hadir' || $request->status == 'alpha') {
            // Remove foto if status changed to hadir or alpha
            if ($presensi->foto_bukti && Storage::disk('public')->exists($presensi->foto_bukti)) {
                Storage::disk('public')->delete($presensi->foto_bukti);
            }
            $data['foto_bukti'] = null;
        }
        
        $presensi->update($data);
        
        return redirect()->route('dosen.presensiMahasiswa.index')
            ->with('success', 'Presensi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $presensi = PresensiMahasiswa::findOrFail($id);
        
        // Delete foto if exists
        if ($presensi->foto_bukti && Storage::disk('public')->exists($presensi->foto_bukti)) {
            Storage::disk('public')->delete($presensi->foto_bukti);
        }
        
        $presensi->delete();
        
        return redirect()->route('dosen.presensiMahasiswa.index')
            ->with('success', 'Presensi berhasil dihapus');
    }
    
    /**
 * Get mata kuliah by prodi and semester based on dosen's jadwal (AJAX)
 */
public function getMatakuliah(Request $request)
{
    try {
        \Log::info('getMatakuliah called', [
            'prodi_id' => $request->prodi_id,
            'semester' => $request->semester,
            'user_id' => Auth::id()
        ]);

        $user = Auth::user();
        
        if (!$user || !$user->dosen) {
            \Log::error('User tidak memiliki relasi dosen');
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $dosen = $user->dosen;
        $prodiId = $request->prodi_id;
        $semester = $request->semester;
        
        // Validasi input
        if (!$prodiId || !$semester) {
            \Log::error('Prodi atau semester kosong');
            return response()->json(['error' => 'Prodi dan semester harus diisi'], 400);
        }
        
        // Gunakan DB::table untuk query lebih robust
        $matakuliah = DB::table('mata_kuliah')
            ->join('jadwal', 'mata_kuliah.id', '=', 'jadwal.mata_kuliah_id')
            ->where('jadwal.dosen_id', $dosen->id)
            ->where('jadwal.prodi_id', $prodiId)
            ->where('jadwal.semester', $semester)
            ->select(
                'mata_kuliah.id',
                'mata_kuliah.kode_matakuliah',
                'mata_kuliah.nama_matakuliah',
                'mata_kuliah.sks'
            )
            ->distinct()
            ->get();
        
        \Log::info('Mata kuliah found: ' . $matakuliah->count());
        
        return response()->json($matakuliah);
        
    } catch (\Exception $e) {
        \Log::error('Error getMatakuliah: ' . $e->getMessage());
        return response()->json([
            'error' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
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
        
        // Cek mahasiswa yang sudah presensi hari ini untuk mata kuliah tertentu
        if ($request->has('matakuliah_id') && $request->has('tanggal')) {
            $tanggal = $request->tanggal;
            $matakuliahId = $request->matakuliah_id;
            
            // Get IDs mahasiswa yang sudah presensi
            $sudahPresensi = PresensiMahasiswa::where('mata_kuliah_id', $matakuliahId)
                ->whereDate('waktu_presensi', $tanggal)
                ->pluck('mahasiswa_id')
                ->toArray();
            
            // Filter out mahasiswa yang sudah presensi
            $mahasiswa = $mahasiswa->filter(function($mhs) use ($sudahPresensi) {
                return !in_array($mhs->id, $sudahPresensi);
            })->values(); // Reset array keys
        }
        
        return response()->json($mahasiswa);
    }
    
    /**
     * Get presensi detail by date, prodi, semester, and mata kuliah
     */
    public function getPresensiDetail(Request $request)
    {
        $tanggal = $request->get('tanggal');
        $prodiId = $request->get('prodi_id');
        $semester = $request->get('semester');
        $matakuliahId = $request->get('matakuliah_id');
        
        $dosen = Auth::user()->dosen;
        
        $presensiList = PresensiMahasiswa::with(['mahasiswa'])
            ->where('dosen_id', $dosen->id)
            ->whereDate('waktu_presensi', $tanggal)
            ->where('prodi_id', $prodiId)
            ->where('semester', $semester)
            ->where('mata_kuliah_id', $matakuliahId)
            ->get();
        
        return view('dosen.presensiMahasiswa.detail', compact('presensiList', 'tanggal'));
    }
}
