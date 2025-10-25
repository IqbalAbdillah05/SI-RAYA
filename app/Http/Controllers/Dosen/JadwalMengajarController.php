<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Prodi;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalMengajarController extends Controller
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
        $searchMatakuliah = $request->get('search_matakuliah');
        $prodiId = $request->get('prodi_id');
        $hari = $request->get('hari');
        
        // Build query
        $query = Jadwal::with(['mataKuliah', 'prodi'])
            ->where('dosen_id', $dosen->id);
        
        // Apply filters
        if ($searchMatakuliah) {
            $query->whereHas('mataKuliah', function($q) use ($searchMatakuliah) {
                $q->where('nama_matakuliah', 'like', '%' . $searchMatakuliah . '%')
                  ->orWhere('kode_matakuliah', 'like', '%' . $searchMatakuliah . '%');
            });
        }
        
        if ($prodiId) {
            $query->where('prodi_id', $prodiId);
        }
        
        if ($hari) {
            $query->where('hari', $hari);
        }
        
        // Get data - Fixed 15 items per page, ordered by hari and jam_mulai
        $jadwalList = $query->orderByRaw("
            CASE hari
                WHEN 'Senin' THEN 1
                WHEN 'Selasa' THEN 2
                WHEN 'Rabu' THEN 3
                WHEN 'Kamis' THEN 4
                WHEN 'Jumat' THEN 5
                WHEN 'Sabtu' THEN 6
                WHEN 'Minggu' THEN 7
            END
        ")
        ->orderBy('jam_mulai')
        ->paginate(15);
        
        // Get prodi list for filter - Get unique prodi from jadwal
        $prodiList = Prodi::select('id', 'nama_prodi')
            ->whereIn('id', function($query) use ($dosen) {
                $query->select('prodi_id')
                    ->from('jadwal')
                    ->where('dosen_id', $dosen->id)
                    ->distinct();
            })
            ->get();
        
        // Get hari options
        $hariOptions = Jadwal::getHariOptions();
        
        return view('dosen.jadwalMengajar.index', compact(
            'jadwalList',
            'prodiList',
            'hariOptions',
            'searchMatakuliah',
            'prodiId',
            'hari'
        ));
    }
}
