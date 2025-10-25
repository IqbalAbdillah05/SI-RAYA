<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ManajemenMataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MataKuliah::with('prodi');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_matakuliah', 'like', '%' . $search . '%')
                  ->orWhere('nama_matakuliah', 'like', '%' . $search . '%')
                  ->orWhereHas('prodi', function($subQuery) use ($search) {
                      $subQuery->where('nama_prodi', 'like', '%' . $search . '%');
                  });
            });
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        $mataKuliahs = $query->latest()->paginate($perPage);

        // Append query parameters to pagination links
        $mataKuliahs->appends($request->only(['search', 'entries']));

        return view('admin.manajemenMataKuliah.index', compact(
            'mataKuliahs'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodis = Prodi::orderBy('nama_prodi')->get();
        $jenisMkOptions = [
            'wajib' => 'Wajib',
            'pilihan' => 'Pilihan',
            'tugas akhir' => 'Tugas Akhir'
        ];

        return view('admin.manajemenMataKuliah.create', compact(
            'prodis', 
            'jenisMkOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prodi_id' => 'required|exists:prodi,id',
            'kode_matakuliah' => 'required|string|max:10|unique:mata_kuliah,kode_matakuliah',
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'js' => 'nullable|integer|min:1|max:6',
            'jenis_mk' => 'required|in:wajib,pilihan,tugas akhir',
            'semester' => 'required|integer|min:1|max:8'
        ], [
            'prodi_id.required' => 'Program Studi harus dipilih',
            'prodi_id.exists' => 'Program Studi tidak valid',
            'kode_matakuliah.required' => 'Kode Mata Kuliah harus diisi',
            'kode_matakuliah.unique' => 'Kode Mata Kuliah sudah digunakan',
            'nama_matakuliah.required' => 'Nama Mata Kuliah harus diisi',
            'sks.required' => 'SKS harus diisi',
            'sks.integer' => 'SKS harus berupa angka',
            'sks.min' => 'SKS minimal 1',
            'sks.max' => 'SKS maksimal 6',
            'js.integer' => 'JS harus berupa angka',
            'js.min' => 'JS minimal 1',
            'js.max' => 'JS maksimal 6',
            'jenis_mk.required' => 'Jenis Mata Kuliah harus dipilih',
            'jenis_mk.in' => 'Jenis Mata Kuliah tidak valid',
            'semester.required' => 'Semester harus diisi',
            'semester.integer' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 8'
        ]);

        MataKuliah::create($validated);

        return redirect()->route('admin.manajemen-mata-kuliah.index')
            ->with('success', 'Mata Kuliah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $mataKuliah)
    {
        $mataKuliah->load('prodi');
        return view('admin.manajemenMataKuliah.show', compact('mataKuliah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MataKuliah $mataKuliah)
    {
        $prodis = Prodi::orderBy('nama_prodi')->get();
        $jenisMkOptions = [
            'wajib' => 'Wajib',
            'pilihan' => 'Pilihan',
            'tugas akhir' => 'Tugas Akhir'
        ];

        return view('admin.manajemenMataKuliah.edit', compact(
            'mataKuliah', 
            'prodis', 
            'jenisMkOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'prodi_id' => 'required|exists:prodi,id',
            'kode_matakuliah' => 'required|string|max:10|unique:mata_kuliah,kode_matakuliah,' . $mataKuliah->id,
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'js' => 'nullable|integer|min:1|max:6',
            'jenis_mk' => 'required|in:wajib,pilihan,tugas akhir',
            'semester' => 'required|integer|min:1|max:8'
        ], [
            'prodi_id.required' => 'Program Studi harus dipilih',
            'prodi_id.exists' => 'Program Studi tidak valid',
            'kode_matakuliah.required' => 'Kode Mata Kuliah harus diisi',
            'kode_matakuliah.unique' => 'Kode Mata Kuliah sudah digunakan',
            'nama_matakuliah.required' => 'Nama Mata Kuliah harus diisi',
            'sks.required' => 'SKS harus diisi',
            'sks.integer' => 'SKS harus berupa angka',
            'sks.min' => 'SKS minimal 1',
            'sks.max' => 'SKS maksimal 6',
            'js.integer' => 'JS harus berupa angka',
            'js.min' => 'JS minimal 1',
            'js.max' => 'JS maksimal 6',
            'jenis_mk.required' => 'Jenis Mata Kuliah harus dipilih',
            'jenis_mk.in' => 'Jenis Mata Kuliah tidak valid',
            'semester.required' => 'Semester harus diisi',
            'semester.integer' => 'Semester harus berupa angka',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 8'
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('admin.manajemen-mata-kuliah.index')
            ->with('success', 'Mata Kuliah berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();

        return redirect()->route('admin.manajemen-mata-kuliah.index')
            ->with('success', 'Mata Kuliah berhasil dihapus');
    }
}