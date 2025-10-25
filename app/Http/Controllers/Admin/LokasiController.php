<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lokasi::with('pembuatUser');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lokasi', 'like', '%' . $search . '%')
                  ->orWhere('latitude', 'like', '%' . $search . '%')
                  ->orWhere('longitude', 'like', '%' . $search . '%')
                  ->orWhere('radius', 'like', '%' . $search . '%');
            });
        }

        // Pagination with entries per page
        $perPage = $request->get('entries', 10);
        $lokasis = $query->latest()->paginate($perPage);

        // Append query parameters to pagination links
        $lokasis->appends($request->only(['search', 'entries']));

        return view('admin.lokasi.index', compact('lokasis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:10|max:10000',
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi',
            'nama_lokasi.max' => 'Nama lokasi maksimal 100 karakter',
            'latitude.required' => 'Latitude wajib diisi',
            'latitude.numeric' => 'Latitude harus berupa angka',
            'latitude.between' => 'Latitude harus antara -90 sampai 90',
            'longitude.required' => 'Longitude wajib diisi',
            'longitude.numeric' => 'Longitude harus berupa angka',
            'longitude.between' => 'Longitude harus antara -180 sampai 180',
            'radius.required' => 'Radius wajib diisi',
            'radius.integer' => 'Radius harus berupa angka bulat',
            'radius.min' => 'Radius minimal 10 meter',
            'radius.max' => 'Radius maksimal 10000 meter',
        ]);

        $validated['dibuat_oleh'] = Auth::id();

        Lokasi::create($validated);

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi presensi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lokasi $lokasi)
    {
        $lokasi->load('pembuatUser');
        return view('admin.lokasi.show', compact('lokasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lokasi $lokasi)
    {
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:10|max:10000',
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi',
            'nama_lokasi.max' => 'Nama lokasi maksimal 100 karakter',
            'latitude.required' => 'Latitude wajib diisi',
            'latitude.numeric' => 'Latitude harus berupa angka',
            'latitude.between' => 'Latitude harus antara -90 sampai 90',
            'longitude.required' => 'Longitude wajib diisi',
            'longitude.numeric' => 'Longitude harus berupa angka',
            'longitude.between' => 'Longitude harus antara -180 sampai 180',
            'radius.required' => 'Radius wajib diisi',
            'radius.integer' => 'Radius harus berupa angka bulat',
            'radius.min' => 'Radius minimal 10 meter',
            'radius.max' => 'Radius maksimal 10000 meter',
        ]);

        $lokasi->update($validated);

        return redirect()->route('admin.lokasi.index')
            ->with('success', 'Lokasi presensi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lokasi $lokasi)
    {
        try {
            $lokasi->delete();
            return redirect()->route('admin.lokasi.index')
                ->with('success', 'Lokasi presensi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.lokasi.index')
                ->with('error', 'Gagal menghapus lokasi presensi: ' . $e->getMessage());
        }
    }
}