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
            'kode_matakuliah' => 'required|string|max:20|unique:mata_kuliah,kode_matakuliah',
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'js' => 'nullable|integer|min:1|max:6',
            'jenis_mk' => 'required|in:wajib,pilihan,tugas akhir',
            'semester' => 'required|integer|min:1|max:8'
        ], [
            'prodi_id.required' => 'Program Studi harus dipilih',
            'prodi_id.exists' => 'Program Studi tidak valid',
            'kode_matakuliah.required' => 'Kode Mata Kuliah harus diisi',
            'kode_matakuliah.max' => 'Kode Mata Kuliah maksimal 20 karakter',
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
            'kode_matakuliah' => 'required|string|max:20|unique:mata_kuliah,kode_matakuliah,' . $mataKuliah->id,
            'nama_matakuliah' => 'required|string|max:100',
            'sks' => 'required|integer|min:1|max:6',
            'js' => 'nullable|integer|min:1|max:6',
            'jenis_mk' => 'required|in:wajib,pilihan,tugas akhir',
            'semester' => 'required|integer|min:1|max:8'
        ], [
            'prodi_id.required' => 'Program Studi harus dipilih',
            'prodi_id.exists' => 'Program Studi tidak valid',
            'kode_matakuliah.required' => 'Kode Mata Kuliah harus diisi',
            'kode_matakuliah.max' => 'Kode Mata Kuliah maksimal 20 karakter',
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

    /**
     * Show import form (optional - jika ingin halaman import terpisah)
     */
    public function showImport()
    {
        return view('admin.manajemenMataKuliah.import');
    }

    /**
     * Process import Mata Kuliah
     */
    public function processImport(Request $request)
    {
        // Validasi file upload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ], [
            'file.required' => 'File Excel harus diupload',
            'file.mimes' => 'Format file harus Excel (.xlsx, .xls, .csv)',
            'file.max' => 'Ukuran file maksimal 5MB'
        ]);

        try {
            $file = $request->file('file');
            
            // Log untuk debugging
            \Log::info('Starting Mata Kuliah import', [
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime' => $file->getMimeType()
            ]);
            
            $import = new \App\Imports\MataKuliahImport();
            
            \Maatwebsite\Excel\Facades\Excel::import($import, $file);

            $errors = $import->getErrors();
            $successCount = $import->getSuccessCount();
            
            \Log::info('Import completed', [
                'success_count' => $successCount,
                'error_count' => count($errors)
            ]);
            
            // Jika ada error, kembalikan dengan pesan warning
            if (count($errors) > 0) {
                return redirect()->back()
                    ->with('warning', "Import selesai. {$successCount} data berhasil diimport, " . count($errors) . " data gagal.")
                    ->with('import_errors', $errors);
            }

            // Jika tidak ada data yang berhasil
            if ($successCount === 0) {
                return redirect()->back()
                    ->with('error', 'Tidak ada data yang berhasil diimport. Periksa format file Excel Anda!');
            }

            // Jika sukses semua
            return redirect()->route('admin.manajemen-mata-kuliah.index')
                ->with('success', "Data Mata Kuliah berhasil diimport! Total {$successCount} data.");

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            \Log::error('Import validation error', ['errors' => $errorMessages]);
            
            return redirect()->back()
                ->with('error', 'Validasi gagal!')
                ->with('validation_errors', $errorMessages);
                
        } catch (\Exception $e) {
            \Log::error('Import exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk import Mata Kuliah
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/template_mata_kuliah.xlsx');
        
        // Debugging
        \Log::info('Attempting to download template', [
            'file_path' => $filePath,
            'file_exists' => file_exists($filePath),
            'file_readable' => is_readable($filePath),
            'public_path' => public_path(),
            'templates_dir_exists' => file_exists(public_path('templates'))
        ]);
        
        if (file_exists($filePath)) {
            return response()->download($filePath, 'template_mata_kuliah.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="template_mata_kuliah.xlsx"'
            ]);
        }
        
        // Log error jika file tidak ditemukan
        \Log::error('Template file not found', [
            'file_path' => $filePath,
            'public_path' => public_path(),
            'templates_exists' => file_exists(public_path('templates'))
        ]);
        
        return redirect()->back()->with('error', 'Template tidak ditemukan! Silakan hubungi administrator.');
    }
}