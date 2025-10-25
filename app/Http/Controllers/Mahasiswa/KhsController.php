<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Khs;
use App\Models\KhsDetail;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class KhsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        // Ambil semester yang dipilih, default ke semester mahasiswa saat ini
        $selectedSemester = $request->get('semester', $mahasiswa->semester);

        // List semester untuk dropdown (1-8)
        $semesterList = range(1, 8);

        // Ambil data KHS berdasarkan mahasiswa dan semester
        // Hanya tampilkan KHS yang sudah divalidasi oleh admin
        $khs = Khs::where('mahasiswa_id', $mahasiswa->id)
            ->where('semester', $selectedSemester)
            ->where('status_validasi', 'Disetujui')
            ->with(['details.mataKuliah', 'prodi'])
            ->first();

        return view('mahasiswa.khs.index', compact(
            'mahasiswa',
            'khs',
            'selectedSemester',
            'semesterList'
        ));
    }

    public function downloadPdf($semester)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan');
        }

        // Ambil data KHS berdasarkan mahasiswa dan semester
        // Hanya tampilkan KHS yang sudah divalidasi oleh admin
        $khs = Khs::where('mahasiswa_id', $mahasiswa->id)
            ->where('semester', $semester)
            ->where('status_validasi', 'Disetujui')
            ->with(['details.mataKuliah', 'prodi'])
            ->first();

        if (!$khs) {
            return redirect()->back()->with('error', 'Data KHS untuk semester ' . $semester . ' tidak ditemukan');
        }

        // Generate PDF
        $pdf = Pdf::loadView('mahasiswa.khs.pdf', compact('khs', 'mahasiswa'));
        
        // Set paper size dan orientasi
        $pdf->setPaper('A4', 'portrait');
        
        // Download dengan nama file
        $filename = 'KHS_' . $mahasiswa->nim . '_Semester_' . $semester . '.pdf';
        
        return $pdf->download($filename);
    }
}
