<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlokirMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BlokirMahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa yang diblokir
     */
    public function index(Request $request)
    {
        $query = BlokirMahasiswa::with(['mahasiswa', 'prodi', 'admin']);

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
                // Search di prodi
                ->orWhereHas('prodi', function($subQuery) use ($search) {
                    $subQuery->where('nama_prodi', 'like', '%' . $search . '%');
                })
                // Search di admin (yang memblokir)
                ->orWhereHas('admin', function($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%');
                })
                // Search di keterangan, status, semester, tahun_ajaran
                ->orWhere('keterangan', 'like', '%' . $search . '%')
                ->orWhere('status_blokir', 'like', '%' . $search . '%')
                ->orWhere('semester', 'like', '%' . $search . '%')
                ->orWhere('tahun_ajaran', 'like', '%' . $search . '%');
            });
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        $blokirMahasiswas = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Append query parameters to pagination links
        $blokirMahasiswas->appends($request->only(['search', 'entries']));

        return view('admin.blokir-mahasiswa.index', compact('blokirMahasiswas'));
    }

    /**
     * Menampilkan form tambah blokir mahasiswa
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::with('prodi')
            ->orderBy('nama_lengkap')
            ->get();
        
        $prodis = Prodi::orderBy('nama_prodi')->get();

        return view('admin.blokir-mahasiswa.create', compact('mahasiswas', 'prodis'));
    }

    /**
     * Menyimpan data blokir mahasiswa
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => [
                'required', 
                'exists:mahasiswa_profiles,id',
                function($attribute, $value, $fail) {
                    // Cek apakah mahasiswa sudah diblokir
                    $blokirAktif = BlokirMahasiswa::where('mahasiswa_id', $value)
                        ->where('status_blokir', 'Diblokir')
                        ->exists();
                    
                    if ($blokirAktif) {
                        $fail('Mahasiswa ini sudah diblokir sebelumnya.');
                    }
                }
            ],
            'prodi_id' => [
                'required', 
                'exists:prodi,id',
                function($attribute, $value, $fail) use ($request) {
                    // Validasi tambahan: pastikan prodi sesuai dengan mahasiswa
                    $mahasiswa = Mahasiswa::find($request->mahasiswa_id);
                    if ($mahasiswa && $mahasiswa->prodi_id != $value) {
                        $fail('Program studi tidak sesuai dengan mahasiswa yang dipilih.');
                    }
                }
            ],
            'semester' => 'nullable|integer|min:1|max:14',
            'tahun_ajaran' => 'nullable|string|max:9',
            'keterangan' => 'nullable|string',
            'tanggal_blokir' => 'nullable|date',
            'status_blokir' => 'required|in:Diblokir,Dibuka'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Pastikan prodi_id benar-benar ada
            $prodi = Prodi::findOrFail($request->prodi_id);

            // Buat data blokir mahasiswa
            $blokirMahasiswa = BlokirMahasiswa::create([
                'mahasiswa_id' => $request->mahasiswa_id,
                'prodi_id' => $prodi->id,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'keterangan' => $request->keterangan,
                'tanggal_blokir' => $request->tanggal_blokir ?? now(),
                'admin_id' => Auth::id(),
                'status_blokir' => $request->status_blokir
            ]);

            DB::commit();

            Log::info('Mahasiswa diblokir', [
                'mahasiswa_id' => $request->mahasiswa_id,
                'admin_id' => Auth::id(),
                'keterangan' => $request->keterangan,
                'tahun_ajaran' => $request->tahun_ajaran
            ]);

            return redirect()->route('admin.blokir-mahasiswa.index')
                ->with('success', 'Data blokir mahasiswa berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menyimpan data blokir mahasiswa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan detail blokir mahasiswa
     */
    public function show(BlokirMahasiswa $blokirMahasiswa)
    {
        $blokirMahasiswa->load(['mahasiswa', 'prodi', 'admin']);
        return view('admin.blokir-mahasiswa.show', compact('blokirMahasiswa'));
    }

    /**
     * Menampilkan form edit blokir mahasiswa
     */
    public function edit(BlokirMahasiswa $blokirMahasiswa)
    {
        $mahasiswas = Mahasiswa::with('prodi')
            ->orderBy('nama_lengkap')
            ->get();
        
        $prodis = Prodi::orderBy('nama_prodi')->get();

        return view('admin.blokir-mahasiswa.edit', compact('blokirMahasiswa', 'mahasiswas', 'prodis'));
    }

    /**
     * Update data blokir mahasiswa
     */
    public function update(Request $request, BlokirMahasiswa $blokirMahasiswa)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'mahasiswa_id' => 'required|exists:mahasiswa_profiles,id',
            'prodi_id' => [
                'required', 
                'exists:prodi,id',
                function($attribute, $value, $fail) use ($request) {
                    // Validasi tambahan: pastikan prodi sesuai dengan mahasiswa
                    $mahasiswa = Mahasiswa::find($request->mahasiswa_id);
                    if ($mahasiswa && $mahasiswa->prodi_id != $value) {
                        $fail('Program studi tidak sesuai dengan mahasiswa yang dipilih.');
                    }
                }
            ],
            'semester' => 'nullable|integer|min:1|max:14',
            'tahun_ajaran' => 'nullable|string|max:9',
            'keterangan' => 'nullable|string',
            'tanggal_blokir' => 'nullable|date',
            'status_blokir' => 'required|in:Diblokir,Dibuka'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Pastikan prodi_id benar-benar ada
            $prodi = Prodi::findOrFail($request->prodi_id);

            // Update data blokir mahasiswa
            $blokirMahasiswa->update([
                'mahasiswa_id' => $request->mahasiswa_id,
                'prodi_id' => $prodi->id,
                'semester' => $request->semester,
                'tahun_ajaran' => $request->tahun_ajaran,
                'keterangan' => $request->keterangan,
                'tanggal_blokir' => $request->tanggal_blokir ?? now(),
                'admin_id' => Auth::id(),
                'status_blokir' => $request->status_blokir
            ]);

            DB::commit();

            Log::info('Status blokir mahasiswa diubah', [
                'mahasiswa_id' => $blokirMahasiswa->mahasiswa_id,
                'admin_id' => Auth::id(),
                'status_lama' => $blokirMahasiswa->status_blokir,
                'status_baru' => $request->status_blokir
            ]);

            return redirect()->route('admin.blokir-mahasiswa.index')
                ->with('success', 'Data blokir mahasiswa berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal memperbarui data blokir mahasiswa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Hapus data blokir mahasiswa
     */
    public function destroy(BlokirMahasiswa $blokirMahasiswa)
    {
        try {
            $blokirMahasiswa->delete();

            Log::info('Data blokir mahasiswa dihapus', [
                'mahasiswa_id' => $blokirMahasiswa->mahasiswa_id,
                'admin_id' => Auth::id()
            ]);

            return redirect()->route('admin.blokir-mahasiswa.index')
                ->with('success', 'Data blokir mahasiswa berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->route('admin.blokir-mahasiswa.index')
                ->with('error', 'Gagal menghapus data blokir mahasiswa: ' . $e->getMessage());
        }
    }
}
