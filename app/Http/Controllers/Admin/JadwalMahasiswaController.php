<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;

class JadwalMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Jadwal::with(['mataKuliah', 'dosen', 'prodi']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('mataKuliah', function($subQuery) use ($search) {
                    $subQuery->where('kode_matakuliah', 'like', '%' . $search . '%')
                             ->orWhere('nama_matakuliah', 'like', '%' . $search . '%');
                })
                ->orWhereHas('dosen', function($subQuery) use ($search) {
                    $subQuery->where('nama_lengkap', 'like', '%' . $search . '%')
                             ->orWhere('nidn', 'like', '%' . $search . '%');
                })
                ->orWhereHas('prodi', function($subQuery) use ($search) {
                    $subQuery->where('nama_prodi', 'like', '%' . $search . '%');
                })
                ->orWhere('hari', 'like', '%' . $search . '%')
                ->orWhere('ruang', 'like', '%' . $search . '%');
            });
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        $jadwalList = $query->latest()->paginate($perPage);

        // Append query parameters to pagination links
        $jadwalList->appends($request->only(['search', 'entries']));

        return view('admin.jadwalMahasiswa.index', compact('jadwalList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mahasiswa = Mahasiswa::orderBy('nama_lengkap')->get();
        $jadwal = Jadwal::with('dosen')
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();
        
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        
        $dosenList = Dosen::orderBy('nama_lengkap')->get();
        
        $prodis = Prodi::orderBy('nama_prodi')->get();
        
        $hariOptions = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu'
        ];

        return view('admin.jadwalMahasiswa.create', compact(
            'mahasiswa', 
            'jadwal', 
            'mataKuliahs', 
            'dosenList', 
            'prodis', 
            'hariOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data umum jadwal terlebih dahulu
        $request->validate([
            'prodi_id' => 'required|exists:prodi,id',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'semester' => 'required|integer|min:1|max:8',
            'tahun_ajaran' => 'required|string|max:20',
            'semester_type' => 'required|in:ganjil,genap',
        ], [
            'prodi_id.required' => 'Program Studi harus dipilih',
            'prodi_id.exists' => 'Program Studi tidak ditemukan',
            'hari.required' => 'Hari harus dipilih',
            'hari.in' => 'Hari tidak valid',
            'semester.required' => 'Semester harus diisi',
            'semester.integer' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 8',
            'tahun_ajaran.required' => 'Tahun Ajaran harus diisi',
            'tahun_ajaran.max' => 'Tahun Ajaran maksimal 20 karakter',
            'semester_type.required' => 'Tipe semester harus dipilih',
            'semester_type.in' => 'Tipe semester tidak valid',
        ]);
        
        // Ambil semua data
        $jadwalItems = $request->input('jadwal_items', []);
        
        // Debug: Log data yang diterima (bisa dihapus nanti)
        \Log::info('Jadwal Items Received:', $jadwalItems);
        
        // Filter hanya yang dipilih (checked)
        $selectedItems = [];
        foreach ($jadwalItems as $mkId => $item) {
            if (isset($item['selected']) && $item['selected'] == 1) {
                $selectedItems[$mkId] = $item;
            }
        }
        
        // Debug: Log items yang dipilih
        \Log::info('Selected Items:', $selectedItems);
        
        // Validasi minimal 1 mata kuliah dipilih
        if (empty($selectedItems)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Minimal satu mata kuliah harus dipilih');
        }
        
        // Validasi setiap item yang dipilih
        $validationErrors = [];
        foreach ($selectedItems as $mkId => $item) {
            if (empty($item['mata_kuliah_id'])) {
                $validationErrors[] = "Mata kuliah ID tidak valid";
            }
            if (empty($item['dosen_id'])) {
                $validationErrors[] = "Dosen harus dipilih untuk mata kuliah";
            } else {
                // Cek apakah dosen_id valid
                $dosenExists = \App\Models\Dosen::where('id', $item['dosen_id'])->exists();
                if (!$dosenExists) {
                    $validationErrors[] = "Dosen yang dipilih tidak ditemukan di database (ID: {$item['dosen_id']})";
                }
            }
            if (empty($item['jam_mulai'])) {
                $validationErrors[] = "Jam mulai harus diisi";
            }
            if (empty($item['jam_selesai'])) {
                $validationErrors[] = "Jam selesai harus diisi";
            }
            if (!empty($item['jam_mulai']) && !empty($item['jam_selesai']) && $item['jam_mulai'] >= $item['jam_selesai']) {
                $validationErrors[] = "Jam selesai harus lebih besar dari jam mulai";
            }
        }
        
        if (!empty($validationErrors)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terdapat kesalahan: ' . implode(', ', $validationErrors));
        }

        if (!empty($validationErrors)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terdapat kesalahan: ' . implode(', ', $validationErrors));
        }

        // Format tahun ajaran dengan tipe semester
        $tahunAjaran = $request->tahun_ajaran . ' ' . ($request->semester_type === 'ganjil' ? 'Ganjil' : 'Genap');

        $successCount = 0;
        $errorCount = 0;
        $errorMessages = [];

        // Iterasi setiap item jadwal (mata kuliah + dosen) yang dipilih
        foreach ($selectedItems as $mataKuliahId => $item) {
            // Cek apakah jadwal dengan kombinasi yang sama sudah ada
            $query = Jadwal::where('mata_kuliah_id', $item['mata_kuliah_id'])
                ->where('dosen_id', $item['dosen_id'])
                ->where('prodi_id', $request->prodi_id)
                ->where('hari', $request->hari)
                ->where('jam_mulai', $item['jam_mulai'])
                ->where('jam_selesai', $item['jam_selesai'])
                ->where('semester', $request->semester)
                ->where('tahun_ajaran', $tahunAjaran);
                
            // Jika ruang diisi, tambahkan ke query
            if (isset($item['ruang']) && !empty($item['ruang'])) {
                $query->where('ruang', $item['ruang']);
            }
                
            $exists = $query->exists();

            if ($exists) {
                $errorCount++;
                $mataKuliah = MataKuliah::find($item['mata_kuliah_id']);
                if ($mataKuliah) {
                    $errorMessages[] = "Jadwal untuk mata kuliah {$mataKuliah->nama_matakuliah} sudah ada";
                }
                continue;
            }

            // Buat jadwal baru
            $jadwalData = [
                'mata_kuliah_id' => $item['mata_kuliah_id'],
                'dosen_id' => $item['dosen_id'],
                'prodi_id' => $request->prodi_id,
                'ruang' => isset($item['ruang']) && !empty($item['ruang']) ? $item['ruang'] : null,
                'hari' => $request->hari,
                'jam_mulai' => $item['jam_mulai'],
                'jam_selesai' => $item['jam_selesai'],
                'semester' => $request->semester,
                'tahun_ajaran' => $tahunAjaran,
            ];

            $jadwal = Jadwal::create($jadwalData);
            $successCount++;
        }

        // Buat pesan berdasarkan hasil
        if ($successCount > 0 && $errorCount == 0) {
            $message = "Berhasil menambahkan {$successCount} jadwal baru";
            return redirect()->route('admin.jadwal-mahasiswa.index')->with('success', $message);
        } else if ($successCount > 0 && $errorCount > 0) {
            $message = "Berhasil menambahkan {$successCount} jadwal baru, namun {$errorCount} jadwal gagal dibuat karena sudah ada";
            return redirect()->route('admin.jadwal-mahasiswa.index')->with('warning', $message);
        } else {
            $message = "Gagal menambahkan jadwal. Semua jadwal yang dipilih sudah ada atau data tidak valid.";
            return redirect()->back()->withInput()->with('error', $message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        
        $mahasiswa = Mahasiswa::orderBy('nama_lengkap')->get();
        
        $mataKuliahs = MataKuliah::orderBy('nama_matakuliah')->get();
        
        $dosenList = Dosen::orderBy('nama_lengkap')->get();
        
        $prodis = Prodi::orderBy('nama_prodi')->get();
        
        $hariOptions = [
            'Senin' => 'Senin',
            'Selasa' => 'Selasa',
            'Rabu' => 'Rabu',
            'Kamis' => 'Kamis',
            'Jumat' => 'Jumat',
            'Sabtu' => 'Sabtu',
            'Minggu' => 'Minggu'
        ];

        return view('admin.jadwalMahasiswa.edit', compact(
            'jadwal', 
            'mahasiswa', 
            'mataKuliahs', 
            'dosenList', 
            'prodis', 
            'hariOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'dosen_id' => 'required|exists:dosen_profiles,id',
            'prodi_id' => 'required|exists:prodi,id',
            'ruang' => 'nullable|string|max:50',
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'semester' => 'required|integer|min:1|max:8',
            'tahun_ajaran' => 'required|string|max:20',
        ], [
            'mata_kuliah_id.required' => 'Mata Kuliah harus dipilih',
            'mata_kuliah_id.exists' => 'Mata Kuliah tidak ditemukan',
            'dosen_id.required' => 'Dosen harus dipilih',
            'dosen_id.exists' => 'Dosen tidak ditemukan',
            'prodi_id.required' => 'Program Studi harus dipilih',
            'prodi_id.exists' => 'Program Studi tidak ditemukan',
            'hari.required' => 'Hari harus dipilih',
            'hari.in' => 'Hari tidak valid',
            'jam_mulai.required' => 'Jam Mulai harus diisi',
            'jam_mulai.date_format' => 'Format Jam Mulai tidak valid',
            'jam_selesai.required' => 'Jam Selesai harus diisi',
            'jam_selesai.date_format' => 'Format Jam Selesai tidak valid',
            'jam_selesai.after' => 'Jam Selesai harus setelah Jam Mulai',
            'semester.required' => 'Semester harus diisi',
            'semester.integer' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 8',
            'tahun_ajaran.required' => 'Tahun Ajaran harus diisi',
            'tahun_ajaran.max' => 'Tahun Ajaran maksimal 20 karakter',
        ]);

        // Cek apakah jadwal dengan kombinasi yang sama sudah ada
        $exists = Jadwal::where('mata_kuliah_id', $validated['mata_kuliah_id'])
            ->where('dosen_id', $validated['dosen_id'])
            ->where('prodi_id', $validated['prodi_id'])
            ->where('hari', $validated['hari'])
            ->where('jam_mulai', $validated['jam_mulai'])
            ->where('jam_selesai', $validated['jam_selesai'])
            ->where('semester', $validated['semester'])
            ->where('tahun_ajaran', $validated['tahun_ajaran'])
            ->where('id', '!=', $jadwal->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal dengan detail yang sama sudah ada');
        }

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal-mahasiswa.index')
            ->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('admin.jadwalMahasiswa.show', compact('jadwal'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-mahasiswa.index')
            ->with('success', 'Jadwal berhasil dihapus');
    }
    
    /**
     * Get mata kuliah by prodi and semester
     */
    public function getMataKuliah(Request $request)
    {
        $prodiId = $request->input('prodi_id');
        $semester = $request->input('semester');
        
        if (!$prodiId || !$semester) {
            return response()->json([
                'success' => false,
                'message' => 'Prodi dan semester diperlukan',
                'data' => []
            ]);
        }
        
        $mataKuliahs = MataKuliah::where('prodi_id', $prodiId)
            ->where('semester', $semester)
            ->orderBy('nama_matakuliah')
            ->get();
            
        // Ambil juga daftar dosen untuk setiap mata kuliah
        $dosen = Dosen::orderBy('nama_lengkap')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diambil',
            'data' => [
                'mata_kuliah' => $mataKuliahs,
                'dosen' => $dosen
            ]
        ]);
    }
}
