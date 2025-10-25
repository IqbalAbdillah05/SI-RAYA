<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PresensiDosen;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PresensiDosenController extends Controller
{
    /**
     * Hitung jarak antara dua koordinat GPS (dalam meter)
     * Menggunakan formula Haversine
     */
    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Jarak dalam meter
    }

    public function index()
    {
        $dosen = Auth::user()->dosenProfile;
        
        // Ambil semua presensi hari ini
        $presensiHariIni = PresensiDosen::where('dosen_id', $dosen->id)
            ->whereDate('waktu_presensi', today())
            ->with('lokasi')
            ->get();

        // Hitung jumlah presensi hari ini
        $jumlahPresensiHariIni = $presensiHariIni->count();

        // Ambil semua lokasi presensi aktif
        $lokasi = Lokasi::all();

        return view('dosen.presensi.index', [
            'presensiHariIni' => $presensiHariIni,
            'jumlahPresensiHariIni' => $jumlahPresensiHariIni,
            'lokasi' => $lokasi
        ]);
    }

    public function create(Request $request)
    {
        $dosen = Auth::user()->dosenProfile;
        
        // Cek jumlah presensi hari ini
        $jumlahPresensiHariIni = PresensiDosen::where('dosen_id', $dosen->id)
            ->whereDate('waktu_presensi', today())
            ->count();

        // Batasi maksimal 2 presensi per hari
        if ($jumlahPresensiHariIni >= 2) {
            return redirect()->route('dosen.presensi.index')
                ->with('error', 'Anda sudah mencapai batas maksimal presensi hari ini (2 kali).');
        }

        $lokasi = Lokasi::all();

        return view('dosen.presensi.create', [
            'lokasi' => $lokasi,
            'selectedLokasiId' => $request->lokasi_id,
            'jumlahPresensiHariIni' => $jumlahPresensiHariIni
        ]);
    }

    public function store(Request $request)
    {
        // Validasi dasar
        $rules = [
            'status' => 'required|in:hadir,izin,sakit',
            'keterangan' => 'nullable|string|max:500'
        ];

        // Koordinat hanya wajib untuk status hadir
        if ($request->status === 'hadir') {
            $rules['latitude'] = 'required|numeric';
            $rules['longitude'] = 'required|numeric';
            $rules['lokasi_id'] = 'required|exists:lokasi_presensi,id';
        }

        // Foto bukti WAJIB untuk izin dan sakit, opsional untuk hadir
        if (in_array($request->status, ['izin', 'sakit'])) {
            $rules['foto_bukti'] = 'required|image|mimes:jpeg,jpg,png|max:2048';
            $rules['keterangan'] = 'required|string|max:500';
        } else {
            $rules['foto_bukti'] = 'nullable|image|mimes:jpeg,jpg,png|max:2048';
        }

        $messages = [
            'foto_bukti.required' => 'Foto bukti wajib diunggah untuk status Izin/Sakit.',
            'keterangan.required' => 'Keterangan wajib diisi untuk status Izin/Sakit.',
            'latitude.required' => 'Koordinat GPS tidak terdeteksi. Pastikan GPS Anda aktif.',
            'longitude.required' => 'Koordinat GPS tidak terdeteksi. Pastikan GPS Anda aktif.',
        ];

        $request->validate($rules, $messages);

        $dosen = Auth::user()->dosenProfile;

        // Cek jumlah presensi hari ini
        $jumlahPresensiHariIni = PresensiDosen::where('dosen_id', $dosen->id)
            ->whereDate('waktu_presensi', today())
            ->count();

        if ($jumlahPresensiHariIni >= 2) {
            return back()->withErrors(['error' => 'Anda sudah mencapai batas maksimal presensi hari ini (2 kali).']);
        }

        // Tentukan presensi ke-1 atau ke-2
        $presensiKe = $jumlahPresensiHariIni == 0 ? 'ke-1' : 'ke-2';

        // Untuk status izin/sakit, gunakan lokasi default
        if ($request->status === 'hadir') {
            // Untuk status hadir, gunakan lokasi yang dipilih
            $lokasi = Lokasi::findOrFail($request->lokasi_id);

            // Hitung jarak antara posisi user dengan lokasi yang ditentukan
            $jarak = $this->hitungJarak(
                $request->latitude,
                $request->longitude,
                $lokasi->latitude,
                $lokasi->longitude
            );

            // Validasi apakah user berada dalam radius lokasi
            if ($jarak > $lokasi->radius) {
                return back()->withErrors([
                    'error' => 'Untuk status Hadir, Anda harus berada dalam radius lokasi presensi. Jarak Anda: ' . 
                              number_format($jarak, 2) . ' meter dari lokasi (radius: ' . 
                              $lokasi->radius . ' meter).'
                ])->withInput();
            }
        } else {
            // Untuk status izin/sakit, gunakan lokasi default pertama
            $lokasi = Lokasi::first();
            $jarak = 0; // Tidak perlu validasi jarak
        }

        $data = [
            'dosen_id' => $dosen->id,
            'lokasi_id' => $lokasi->id,
            'waktu_presensi' => now(),
            'status' => $request->status,
            'presensi_ke' => $presensiKe,
            'keterangan' => $request->keterangan,
            'latitude' => $request->status === 'hadir' ? $request->latitude : 0,
            'longitude' => $request->status === 'hadir' ? $request->longitude : 0,
            'jarak_masuk' => $request->status === 'hadir' ? round($jarak, 2) : 0
        ];

        // Upload foto bukti jika ada
        if ($request->hasFile('foto_bukti')) {
            $path = $request->file('foto_bukti')->store('presensi_dosen', 'public');
            $data['foto_bukti'] = $path;
        }

        PresensiDosen::create($data);

        $presensiBerapa = $jumlahPresensiHariIni + 1;
        $statusText = ucfirst($request->status);
        $message = "Presensi ke-{$presensiBerapa} berhasil disimpan dengan status {$statusText}. ";
        
        if ($presensiBerapa < 2) {
            $message .= "Anda masih bisa melakukan 1 kali presensi lagi hari ini.";
        } else {
            $message .= "Anda telah mencapai batas maksimal presensi hari ini.";
        }

        return redirect()->route('dosen.presensi.index')
            ->with('success', $message);
    }

    public function show($id)
    {
        $dosen = Auth::user()->dosenProfile;
        
        $presensi = PresensiDosen::where('id', $id)
            ->where('dosen_id', $dosen->id)
            ->with('lokasi')
            ->firstOrFail();
            
        return view('dosen.presensi.show', compact('presensi'));
    }

    public function riwayat(Request $request)
    {
        $dosen = Auth::user()->dosenProfile;
        
        $query = PresensiDosen::where('dosen_id', $dosen->id)
            ->with('lokasi');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $riwayat = $query->orderBy('waktu_presensi', 'desc')->paginate(15);

        return view('dosen.presensi.riwayat', [
            'riwayat' => $riwayat
        ]);
    }

    /**
     * API untuk validasi lokasi real-time
     */
    public function validasiLokasi(Request $request)
    {
        $request->validate([
            'lokasi_id' => 'required|exists:lokasi_presensi,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $lokasi = Lokasi::findOrFail($request->lokasi_id);

        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            $lokasi->latitude,
            $lokasi->longitude
        );

        return response()->json([
            'valid' => $jarak <= $lokasi->radius,
            'jarak' => round($jarak, 2),
            'radius' => $lokasi->radius,
            'message' => $jarak <= $lokasi->radius 
                ? 'Anda berada dalam radius lokasi' 
                : 'Anda berada di luar radius lokasi'
        ]);
    }
}