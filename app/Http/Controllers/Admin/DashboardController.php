<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\PresensiMahasiswa;
use App\Models\PresensiDosen;
use App\Models\Jadwal;
use App\Models\Krs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Total Users by Role
        $totalMahasiswa = Mahasiswa::count();
        $totalDosen = Dosen::count();
        $totalAdmin = User::where('role', 'admin')->count();
        
        // Attendance Statistics (bulan ini)
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        // Kehadiran Mahasiswa
        $totalPresensiMahasiswa = PresensiMahasiswa::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $hadirMahasiswa = PresensiMahasiswa::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Hadir')->count();
        $attendancePercentage = $totalPresensiMahasiswa > 0 
            ? round(($hadirMahasiswa / $totalPresensiMahasiswa) * 100) . '%' 
            : '0%';
        
        // Kehadiran Dosen
        $totalPresensiDosen = PresensiDosen::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $hadirDosen = PresensiDosen::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'Hadir')->count();
        $lecturerAttendance = $totalPresensiDosen > 0 
            ? round(($hadirDosen / $totalPresensiDosen) * 100) . '%' 
            : '0%';
        
        // Recent Activities (5 aktivitas terbaru)
        $recentActivities = $this->getRecentActivities();
        
        // Upcoming Schedules (jadwal 3 hari ke depan)
        $upcomingSchedules = $this->getUpcomingSchedules();
        
        // KRS Statistics
        $totalKrs = Krs::count();
        $krsMenunggu = Krs::where('status_validasi', 'Menunggu')->count();
        $krsDisetujui = Krs::where('status_validasi', 'Disetujui')->count();
        $krsDitolak = Krs::where('status_validasi', 'Ditolak')->count();
        
        return view('admin.dashboard', compact(
            'user',
            'totalMahasiswa',
            'totalDosen',
            'totalAdmin',
            'attendancePercentage',
            'lecturerAttendance',
            'recentActivities',
            'upcomingSchedules',
            'totalKrs',
            'krsMenunggu',
            'krsDisetujui',
            'krsDitolak'
        ));
    }
    
    /**
     * Get recent activities from various tables
     */
    private function getRecentActivities()
    {
        $activities = [];
        
        // Presensi Dosen terbaru
        $recentDosenPresensi = PresensiDosen::with('dosen')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();
        
        foreach ($recentDosenPresensi as $presensi) {
            $activities[] = (object)[
                'type' => 'success',
                'icon' => 'check-circle',
                'title' => 'Absensi Dosen',
                'description' => ($presensi->dosen->nama_lengkap ?? 'Dosen') . ' telah melakukan absensi',
                'time' => $presensi->created_at->diffForHumans(),
                'created_at' => $presensi->created_at
            ];
        }
        
        // KRS terbaru
        $recentKrs = Krs::with('mahasiswa')
            ->orderBy('created_at', 'desc')
            ->limit(2)
            ->get();
        
        foreach ($recentKrs as $krs) {
            $activities[] = (object)[
                'type' => 'info',
                'icon' => 'file-alt',
                'title' => 'KRS Baru',
                'description' => ($krs->mahasiswa->nama_lengkap ?? 'Mahasiswa') . ' mengisi KRS semester ' . $krs->semester,
                'time' => $krs->created_at->diffForHumans(),
                'created_at' => $krs->created_at
            ];
        }
        
        // User baru terdaftar
        $recentUsers = User::whereIn('role', ['mahasiswa', 'dosen'])
            ->orderBy('created_at', 'desc')
            ->limit(1)
            ->get();
        
        foreach ($recentUsers as $userItem) {
            $activities[] = (object)[
                'type' => 'info',
                'icon' => 'user-plus',
                'title' => 'User Baru',
                'description' => $userItem->name . ' terdaftar sebagai ' . ucfirst($userItem->role),
                'time' => $userItem->created_at->diffForHumans(),
                'created_at' => $userItem->created_at
            ];
        }
        
        // Sort by created_at and take 5 most recent
        usort($activities, function($a, $b) {
            return $b->created_at <=> $a->created_at;
        });
        
        return array_slice($activities, 0, 5);
    }
    
    private function formatJam($jamString)
    {
        if (!$jamString) {
            return '-';
        }

        // Coba berbagai format parsing
        $formats = [
            'H:i:s',
            'H:i',
            'H.i',
            'Hi'
        ];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $jamString)->format('H:i');
            } catch (\Exception $e) {
                // Lanjutkan ke format berikutnya
                continue;
            }
        }

        // Jika semua format gagal, kembalikan string asli atau '-'
        return $jamString ? substr($jamString, 0, 5) : '-';
    }

    /**
     * Get upcoming schedules for next 3 days
     */
    private function getUpcomingSchedules()
    {
        $today = Carbon::today();
        $currentDay = $today->dayOfWeekIso; // 1=Senin, 7=Minggu
        $dayNames = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        // Ambil semua jadwal dengan relasi mata kuliah dan dosen
        $allJadwal = Jadwal::with(['mataKuliah', 'dosen'])
            ->whereNotNull('mata_kuliah_id')
            ->whereNotNull('dosen_id')
            ->get();

        // Log untuk debugging
        \Log::info('Total Jadwal: ' . $allJadwal->count());
        \Log::info('Jadwal Data: ' . json_encode($allJadwal->map(function($jadwal) {
            return [
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
                'mata_kuliah' => $jadwal->mataKuliah ? $jadwal->mataKuliah->nama_matakuliah : 'N/A',
                'dosen' => $jadwal->dosen ? $jadwal->dosen->nama_lengkap : 'N/A'
            ];
        })));

        // Buat array jadwal dengan info hari ke depan
        $jadwalList = [];
        foreach ($allJadwal as $jadwal) {
            // Log setiap jadwal untuk debugging
            \Log::info('Processing Jadwal: ' . json_encode([
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai
            ]));

            // Pastikan semua data yang diperlukan tersedia
            if (!$jadwal->mataKuliah || !$jadwal->dosen) {
                \Log::warning('Skipping Jadwal due to missing mata kuliah or dosen');
                continue;
            }

            $jadwalDay = array_search($jadwal->hari, $dayNames);
            if ($jadwalDay === false) {
                \Log::warning('Skipping Jadwal due to invalid day: ' . $jadwal->hari);
                continue;
            }

            // Hitung selisih hari dari hari ini (0 = hari ini, 1 = besok, dst)
            $diff = ($jadwalDay - $currentDay + 7) % 7;
            $jadwalList[] = [
                'diff' => $diff,
                'jadwal' => $jadwal
            ];
        }

        // Urutkan berdasarkan diff (hari terdekat dulu), lalu jam_mulai
        usort($jadwalList, function($a, $b) {
            if ($a['diff'] == $b['diff']) {
                return strcmp($a['jadwal']->jam_mulai, $b['jadwal']->jam_mulai);
            }
            return $a['diff'] <=> $b['diff'];
        });

        // Ambil maksimal 5 jadwal terdekat
        $upcomingSchedules = [];
        foreach (array_slice($jadwalList, 0, 5) as $item) {
            $jadwal = $item['jadwal'];
            
            // Log detail setiap jadwal yang akan ditampilkan
            \Log::info('Upcoming Jadwal: ' . json_encode([
                'hari' => $jadwal->hari,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai
            ]));

            // Parse jam dari timestamp
            $jamMulai = $jadwal->jam_mulai ? 
                Carbon::parse($jadwal->jam_mulai)->format('H:i') : 
                '-';
            
            $jamSelesai = $jadwal->jam_selesai ? 
                Carbon::parse($jadwal->jam_selesai)->format('H:i') : 
                '-';

            $upcomingSchedules[] = (object)[
                'date' => $jadwal->hari ?? '-',
                'time' => $jamMulai,
                'end_time' => $jamSelesai,
                'subject' => $jadwal->mataKuliah->nama_matakuliah ?? '-',
                'lecturer' => $jadwal->dosen->nama_lengkap ?? '-',
                'room' => $jadwal->ruang ?? '-',
                'semester' => $jadwal->semester ?? '-',
                'tahun_ajaran' => $jadwal->tahun_ajaran ?? '-'
            ];
        }
        
        return $upcomingSchedules;
    }
}
