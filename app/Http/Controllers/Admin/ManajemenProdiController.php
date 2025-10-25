<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ManajemenProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Prodi::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_prodi', 'like', '%' . $search . '%')
                  ->orWhere('nama_prodi', 'like', '%' . $search . '%')
                  ->orWhere('jenjang', 'like', '%' . $search . '%');
            });
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        $prodis = $query->latest()->paginate($perPage);

        // Append query parameters to pagination links
        $prodis->appends($request->only(['search', 'entries']));

        return view('admin.manajemenProdi.index', compact('prodis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenjangOptions = Prodi::getJenjangOptions();
        return view('admin.manajemenProdi.create', compact('jenjangOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_prodi' => 'required|string|max:10|unique:prodi,kode_prodi',
            'nama_prodi' => 'required|string|max:100',
            'jenjang' => 'required|in:D3,D4,S1,S2,S3',
            'ketua_prodi' => 'nullable|string|max:100',
            'nidn_ketua_prodi' => 'nullable|string|max:20',
        ], [
            'kode_prodi.required' => 'Kode prodi harus diisi',
            'kode_prodi.unique' => 'Kode prodi sudah digunakan',
            'nama_prodi.required' => 'Nama prodi harus diisi',
            'jenjang.required' => 'Jenjang harus dipilih',
        ]);

        Prodi::create($request->all());

        return redirect()->route('admin.manajemen-prodi.index')
            ->with('success', 'Program studi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prodi $prodi)
    {
        return view('admin.manajemenProdi.show', compact('prodi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        $jenjangOptions = Prodi::getJenjangOptions();
        return view('admin.manajemenProdi.edit', compact('prodi', 'jenjangOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $request->validate([
            'kode_prodi' => 'required|string|max:10|unique:prodi,kode_prodi,' . $prodi->id,
            'nama_prodi' => 'required|string|max:100',
            'jenjang' => 'required|in:D3,D4,S1,S2,S3',
            'ketua_prodi' => 'nullable|string|max:100',
            'nidn_ketua_prodi' => 'nullable|string|max:20',
        ], [
            'kode_prodi.required' => 'Kode prodi harus diisi',
            'kode_prodi.unique' => 'Kode prodi sudah digunakan',
            'nama_prodi.required' => 'Nama prodi harus diisi',
            'jenjang.required' => 'Jenjang harus dipilih',
        ]);

        $prodi->update($request->all());

        return redirect()->route('admin.manajemen-prodi.index')
            ->with('success', 'Program studi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodi $prodi)
    {
        $prodi->delete();

        return redirect()->route('admin.manajemen-prodi.index')
            ->with('success', 'Program studi berhasil dihapus');
    }
}