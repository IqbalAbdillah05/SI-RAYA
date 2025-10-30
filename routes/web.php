<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\PresensiDosenController;
use App\Http\Controllers\Dosen\PresensiMahasiswaController;
use App\Http\Controllers\Dosen\InputNilaiController;
use App\Http\Controllers\Dosen\JadwalMengajarController;
use App\Http\Controllers\Dosen\BantuanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ManajemenUserController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\ManajemenPresensiDosenController; 
use App\Http\Controllers\Admin\ManajemenPresensiMahasiswaController;
use App\Http\Controllers\Admin\ManajemenNilaiMahasiswaController;
use App\Http\Controllers\Admin\JadwalMahasiswaController;
use App\Http\Controllers\Admin\ManajemenJadwalController;
use App\Http\Controllers\Admin\ManajemenProdiController;
use App\Http\Controllers\Admin\ManajemenMataKuliahController;
use App\Http\Controllers\Admin\KhsController as AdminKhsController;
use App\Http\Controllers\Admin\KrsController as AdminKrsController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Admin\BlokirMahasiswaController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\JadwalController as MahasiswaJadwalController;
use App\Http\Controllers\Mahasiswa\KhsController as MahasiswaKhsController;
use App\Http\Controllers\Mahasiswa\KrsController as MahasiswaKrsController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ========== ADMIN ROUTES ==========
    Route::prefix('admin')->name('admin.')->middleware(RoleMiddleware::class . ':admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen User
        Route::prefix('manajemen-user')->name('manajemen-user.')->group(function () {
            Route::get('/', [ManajemenUserController::class, 'index'])->name('index');
            Route::get('/create', [ManajemenUserController::class, 'create'])->name('create');
            Route::post('/', [ManajemenUserController::class, 'store'])->name('store');
            Route::delete('/bulk-destroy', [ManajemenUserController::class, 'bulkDestroy'])->name('bulkDestroy');
            Route::get('/export-dosen-mahasiswa', [ManajemenUserController::class, 'exportDosenMahasiswa'])->name('exportDosenMahasiswa');
            Route::post('/import-mahasiswa', [ManajemenUserController::class, 'importMahasiswa'])->name('importMahasiswa');
            Route::post('/import-dosen', [ManajemenUserController::class, 'importDosen'])->name('importDosen');
            Route::get('/template-mahasiswa', [ManajemenUserController::class, 'downloadTemplateMahasiswa'])->name('templateMahasiswa');
            Route::get('/template-dosen', [ManajemenUserController::class, 'downloadTemplateDosen'])->name('templateDosen');
            Route::get('/{user}', [ManajemenUserController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [ManajemenUserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [ManajemenUserController::class, 'update'])->name('update');
            Route::delete('/{user}', [ManajemenUserController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Lokasi Presensi
        Route::prefix('lokasi')->name('lokasi.')->group(function () {
            Route::get('/', [LokasiController::class, 'index'])->name('index');
            Route::get('/create', [LokasiController::class, 'create'])->name('create');
            Route::post('/', [LokasiController::class, 'store'])->name('store');
            Route::get('/{lokasi}', [LokasiController::class, 'show'])->name('show');
            Route::get('/{lokasi}/edit', [LokasiController::class, 'edit'])->name('edit');
            Route::put('/{lokasi}', [LokasiController::class, 'update'])->name('update');
            Route::delete('/{lokasi}', [LokasiController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Presensi Dosen
        Route::prefix('manajemen-presensi-dosen')->name('manajemen-presensi-dosen.')->group(function () {
            Route::get('/', [ManajemenPresensiDosenController::class, 'index'])->name('index');
            Route::get('/export', [ManajemenPresensiDosenController::class, 'export'])->name('export');
            Route::get('/create', [ManajemenPresensiDosenController::class, 'create'])->name('create');
            Route::post('/', [ManajemenPresensiDosenController::class, 'store'])->name('store');
            Route::get('/{manajemenPresensi}', [ManajemenPresensiDosenController::class, 'show'])->name('show');
            Route::get('/{manajemenPresensi}/edit', [ManajemenPresensiDosenController::class, 'edit'])->name('edit');
            Route::put('/{manajemenPresensi}', [ManajemenPresensiDosenController::class, 'update'])->name('update');
            Route::delete('/{manajemenPresensi}', [ManajemenPresensiDosenController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Presensi Mahasiswa
        Route::prefix('manajemen-presensi-mahasiswa')->name('manajemen-presensi-mahasiswa.')->group(function () {
            Route::get('/', [ManajemenPresensiMahasiswaController::class, 'index'])->name('index');
            Route::get('/export', [ManajemenPresensiMahasiswaController::class, 'export'])->name('export');
            Route::get('/create', [ManajemenPresensiMahasiswaController::class, 'create'])->name('create');
            Route::post('/', [ManajemenPresensiMahasiswaController::class, 'store'])->name('store');
            Route::get('/{manajemenPresensiMahasiswa}', [ManajemenPresensiMahasiswaController::class, 'show'])->name('show');
            Route::get('/{manajemenPresensiMahasiswa}/edit', [ManajemenPresensiMahasiswaController::class, 'edit'])->name('edit');
            Route::put('/{manajemenPresensiMahasiswa}', [ManajemenPresensiMahasiswaController::class, 'update'])->name('update');
            Route::delete('/{manajemenPresensiMahasiswa}', [ManajemenPresensiMahasiswaController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Nilai Mahasiswa
        Route::prefix('manajemen-nilai-mahasiswa')->name('manajemen-nilai-mahasiswa.')->group(function () {
            Route::get('/', [ManajemenNilaiMahasiswaController::class, 'index'])->name('index');
            Route::get('/export', [ManajemenNilaiMahasiswaController::class, 'export'])->name('export');
            Route::get('/create', [ManajemenNilaiMahasiswaController::class, 'create'])->name('create');
            Route::post('/', [ManajemenNilaiMahasiswaController::class, 'store'])->name('store');
            Route::get('/{id}', [ManajemenNilaiMahasiswaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ManajemenNilaiMahasiswaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ManajemenNilaiMahasiswaController::class, 'update'])->name('update');
            Route::delete('/{id}', [ManajemenNilaiMahasiswaController::class, 'destroy'])->name('destroy');
        });

        // Jadwal Mahasiswa
        Route::prefix('jadwal-mahasiswa')->name('jadwal-mahasiswa.')->group(function () {
            Route::get('/', [JadwalMahasiswaController::class, 'index'])->name('index');
            Route::get('/create', [JadwalMahasiswaController::class, 'create'])->name('create');
            Route::post('/', [JadwalMahasiswaController::class, 'store'])->name('store');
            Route::get('/{id}', [JadwalMahasiswaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [JadwalMahasiswaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JadwalMahasiswaController::class, 'update'])->name('update');
            Route::delete('/{id}', [JadwalMahasiswaController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Prodi
        Route::prefix('manajemen-prodi')->name('manajemen-prodi.')->group(function () {
            Route::get('/', [ManajemenProdiController::class, 'index'])->name('index');
            Route::get('/create', [ManajemenProdiController::class, 'create'])->name('create');
            Route::post('/', [ManajemenProdiController::class, 'store'])->name('store');
            Route::get('/{prodi}', [ManajemenProdiController::class, 'show'])->name('show');
            Route::get('/{prodi}/edit', [ManajemenProdiController::class, 'edit'])->name('edit');
            Route::put('/{prodi}', [ManajemenProdiController::class, 'update'])->name('update');
            Route::delete('/{prodi}', [ManajemenProdiController::class, 'destroy'])->name('destroy');
        });

        // Manajemen Mata Kuliah
        Route::prefix('manajemen-mata-kuliah')->name('manajemen-mata-kuliah.')->group(function () {
            Route::get('/', [ManajemenMataKuliahController::class, 'index'])->name('index');
            Route::get('/create', [ManajemenMataKuliahController::class, 'create'])->name('create');
            Route::post('/', [ManajemenMataKuliahController::class, 'store'])->name('store');
            Route::post('/import', [ManajemenMataKuliahController::class, 'processImport'])->name('import.process');
            Route::get('/template', [ManajemenMataKuliahController::class, 'downloadTemplate'])->name('template');
            Route::get('/{mataKuliah}', [ManajemenMataKuliahController::class, 'show'])->name('show');
            Route::get('/{mataKuliah}/edit', [ManajemenMataKuliahController::class, 'edit'])->name('edit');
            Route::put('/{mataKuliah}', [ManajemenMataKuliahController::class, 'update'])->name('update');
            Route::delete('/{mataKuliah}', [ManajemenMataKuliahController::class, 'destroy'])->name('destroy');
        });

        // Route untuk KHS
        Route::prefix('khs')->name('khs.')->group(function () {
            Route::get('/', [AdminKhsController::class, 'index'])->name('index');
            Route::get('/create', [AdminKhsController::class, 'create'])->name('create');
            Route::post('/', [AdminKhsController::class, 'store'])->name('store');
            Route::get('/{khs}', [AdminKhsController::class, 'show'])->name('show');
            Route::get('/{khs}/edit', [AdminKhsController::class, 'edit'])->name('edit');
            Route::put('/{khs}', [AdminKhsController::class, 'update'])->name('update');
            Route::delete('/{khs}', [AdminKhsController::class, 'destroy'])->name('destroy');
            Route::post('/{khs}/validate', [AdminKhsController::class, 'validate'])
                ->name('validate');
        });

        // KRS Routes
        Route::prefix('krs')->name('krs.')->group(function () {
            Route::get('/', [AdminKrsController::class, 'index'])->name('index');
            Route::get('/export', [AdminKrsController::class, 'export'])->name('export');
            Route::get('/{krs}', [AdminKrsController::class, 'show'])->name('show');
            Route::get('/{krs}/edit', [AdminKrsController::class, 'edit'])->name('edit');
            Route::put('/{krs}', [AdminKrsController::class, 'update'])->name('update');
            Route::delete('/{krs}', [AdminKrsController::class, 'destroy'])->name('destroy');
            Route::post('/{krs}/validate', [AdminKrsController::class, 'validate'])->name('validate');
        });

        // Blokir Mahasiswa Routes
        Route::prefix('blokir-mahasiswa')->name('blokir-mahasiswa.')->group(function () {
            Route::get('/', [BlokirMahasiswaController::class, 'index'])->name('index');
            Route::get('/create', [BlokirMahasiswaController::class, 'create'])->name('create');
            Route::post('/', [BlokirMahasiswaController::class, 'store'])->name('store');
            Route::get('/{blokirMahasiswa}', [BlokirMahasiswaController::class, 'show'])->name('show');
            Route::get('/{blokirMahasiswa}/edit', [BlokirMahasiswaController::class, 'edit'])->name('edit');
            Route::put('/{blokirMahasiswa}', [BlokirMahasiswaController::class, 'update'])->name('update');
            Route::delete('/{blokirMahasiswa}', [BlokirMahasiswaController::class, 'destroy'])->name('destroy');
        });
    });

    // ========== MAHASISWA ROUTES ==========
    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware(RoleMiddleware::class . ':mahasiswa')->group(function () {
        // Dashboard
        Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');
        Route::post('/update-foto', [MahasiswaDashboardController::class, 'updateFoto'])->name('update-foto');
        
        // Jadwal
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [MahasiswaJadwalController::class, 'index'])->name('index');
            Route::post('/tambah', [MahasiswaJadwalController::class, 'tambahJadwal'])->name('tambah');
        });
        
        // KHS
        Route::prefix('khs')->name('khs.')->group(function () {
            Route::get('/', [MahasiswaKhsController::class, 'index'])->name('index');
            Route::get('/download/{semester}', [MahasiswaKhsController::class, 'downloadPdf'])->name('download');
        });
        
        // KRS
        Route::prefix('krs')->name('krs.')->group(function () {
            Route::get('/', [MahasiswaKrsController::class, 'index'])->name('index');
            Route::get('/create', [MahasiswaKrsController::class, 'create'])->name('create');
            Route::post('/', [MahasiswaKrsController::class, 'store'])->name('store');
            Route::get('/{krs}', [MahasiswaKrsController::class, 'show'])->name('show');
            Route::get('/{krs}/edit', [MahasiswaKrsController::class, 'edit'])->name('edit');
            Route::put('/{krs}', [MahasiswaKrsController::class, 'update'])->name('update');
            Route::delete('/{krs}', [MahasiswaKrsController::class, 'destroy'])->name('destroy');
        });
        
        // Bantuan
        Route::prefix('bantuan')->name('bantuan.')->group(function () {
            Route::get('/', function () {
                return view('Mahasiswa.bantuan.index');
            })->name('index');
            Route::get('/dokumentasi', function () {
                return view('Mahasiswa.bantuan.dokumentasi');
            })->name('dokumentasi');
            Route::get('/kontak', function () {
                return view('Mahasiswa.bantuan.kontak');
            })->name('kontak');
        });
    });

    // ========== DOSEN ROUTES ==========
    Route::prefix('dosen')->name('dosen.')->middleware(RoleMiddleware::class . ':dosen')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DosenDashboardController::class, 'index'])->name('dashboard');
        Route::post('/update-foto', [DosenDashboardController::class, 'updateFoto'])->name('update-foto');
        
        // Presensi Dosen
        Route::prefix('presensi')->name('presensi.')->group(function () {
            Route::get('/', [PresensiDosenController::class, 'index'])->name('index');
            Route::get('/create', [PresensiDosenController::class, 'create'])->name('create');
            Route::post('/', [PresensiDosenController::class, 'store'])->name('store');
            Route::get('/riwayat', [PresensiDosenController::class, 'riwayat'])->name('riwayat');
            Route::get('/{id}', [PresensiDosenController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PresensiDosenController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PresensiDosenController::class, 'update'])->name('update');
        });
        
        // Presensi Mahasiswa Routes
        Route::prefix('presensi-mahasiswa')->name('presensiMahasiswa.')->group(function () {
            Route::get('/', [PresensiMahasiswaController::class, 'index'])->name('index');
            Route::get('/create', [PresensiMahasiswaController::class, 'create'])->name('create');
            Route::post('/', [PresensiMahasiswaController::class, 'store'])->name('store');
            Route::get('/riwayat', [PresensiMahasiswaController::class, 'riwayat'])->name('riwayat');
            Route::get('/get-matakuliah', [PresensiMahasiswaController::class, 'getMatakuliah'])->name('getMatakuliah');
            Route::get('/get-mahasiswa', [PresensiMahasiswaController::class, 'getMahasiswaByProdiSemester'])->name('getMahasiswa');
            Route::get('/{id}', [PresensiMahasiswaController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PresensiMahasiswaController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PresensiMahasiswaController::class, 'update'])->name('update');
            Route::delete('/{id}', [PresensiMahasiswaController::class, 'destroy'])->name('destroy');
        });
        
        // Input Nilai Mahasiswa
        Route::prefix('input-nilai')->name('inputNilai.')->group(function () {
            Route::get('/', [InputNilaiController::class, 'index'])->name('index');
            Route::get('/create', [InputNilaiController::class, 'create'])->name('create');
            Route::post('/', [InputNilaiController::class, 'store'])->name('store');
            Route::get('/get-matakuliah', [InputNilaiController::class, 'getMatakuliah'])->name('getMatakuliah');
            Route::get('/{id}', [InputNilaiController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [InputNilaiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [InputNilaiController::class, 'update'])->name('update');
            Route::delete('/{id}', [InputNilaiController::class, 'destroy'])->name('destroy');
        });
        
        // Get Mahasiswa by Prodi and Semester (untuk AJAX)
        Route::get('/mahasiswa/by-prodi-semester', [InputNilaiController::class, 'getMahasiswaByProdiSemester'])->name('mahasiswa.byProdiSemester');
        
        // Jadwal Mengajar
        Route::prefix('jadwal-mengajar')->name('jadwalMengajar.')->group(function () {
            Route::get('/', [JadwalMengajarController::class, 'index'])->name('index');
        });
        
        // Bantuan & Dukungan
        Route::prefix('bantuan')->name('bantuan.')->group(function () {
            Route::get('/', [BantuanController::class, 'index'])->name('index');
            Route::get('/dokumentasi', [BantuanController::class, 'dokumentasi'])->name('dokumentasi');
            Route::get('/kontak', [BantuanController::class, 'kontak'])->name('kontak');
        });
    });

    // Route group yang sudah tidak dipakai - dihapus untuk menghindari duplikasi
});