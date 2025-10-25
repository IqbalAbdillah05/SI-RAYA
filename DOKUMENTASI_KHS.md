# Dokumentasi Fitur KHS Mahasiswa

## Overview
Fitur Kartu Hasil Studi (KHS) memungkinkan mahasiswa untuk melihat hasil studi mereka per semester yang telah diinput oleh admin.

## Fitur Utama
1. **Filter Semester**: Dropdown untuk memilih semester (1-8)
2. **Ringkasan KHS**: Menampilkan Total SKS, IPS, IPK, dan Status
3. **Tabel Nilai**: Menampilkan daftar mata kuliah dengan nilai
4. **Download PDF**: Tombol untuk mengunduh KHS dalam format PDF

## Struktur File

### Controller
- `app/Http/Controllers/Mahasiswa/KhsController.php`
  - `index()`: Menampilkan halaman KHS dengan data semester
  - `downloadPdf()`: Generate dan download KHS dalam format PDF

### Views
- `resources/views/mahasiswa/khs/index.blade.php`: Halaman utama KHS
- `resources/views/mahasiswa/khs/pdf.blade.php`: Template PDF untuk KHS

### Routes
```php
Route::prefix('khs')->name('khs.')->group(function () {
    Route::get('/', [MahasiswaKhsController::class, 'index'])->name('index');
    Route::get('/download/{semester}', [MahasiswaKhsController::class, 'downloadPdf'])->name('download');
});
```

## Model Relationships
- **Khs** belongsTo **Mahasiswa**
- **Khs** belongsTo **Prodi**
- **Khs** hasMany **KhsDetail**
- **KhsDetail** belongsTo **MataKuliah**

## Alur Kerja
1. Mahasiswa login dan mengakses menu KHS
2. Default semester ditampilkan sesuai semester mahasiswa saat ini
3. Mahasiswa dapat memilih semester lain dari dropdown
4. Sistem menampilkan data KHS jika tersedia
5. Mahasiswa dapat download KHS dalam format PDF

## Kolom Database

### Table: khs
- id
- mahasiswa_id
- prodi_id
- semester
- tahun_ajaran
- total_sks
- ips (IP Semester)
- ipk (IP Kumulatif)
- status_validasi
- created_at
- updated_at

### Table: khs_detail
- id
- khs_id
- mata_kuliah_id
- nilai_mahasiswa_id
- nilai_angka
- nilai_huruf
- nilai_indeks
- sks
- created_at
- updated_at

## Styling
- Menggunakan gradient hijau (#0B6623) untuk tema mahasiswa
- Konsisten dengan halaman Jadwal Kuliah
- Responsive design untuk mobile dan desktop
- Badge berwarna untuk grade nilai (A+, A, A-, B+, B, B-, C+, C, C-, D, E)

## Dependencies
- Laravel 11
- barryvdh/laravel-dompdf: untuk generate PDF

## Instalasi Package PDF
```bash
composer require barryvdh/laravel-dompdf
```

## Status Nilai Berdasarkan IPS
- **BAIK**: IPS >= 3.0 (hijau)
- **CUKUP**: IPS >= 2.5 dan < 3.0 (kuning)
- **KURANG**: IPS < 2.5 (merah)

## Format File PDF
- Paper: A4 Portrait
- Nama File: `KHS_{NIM}_Semester_{semester}.pdf`
- Header: Logo dan nama kampus
- Isi: Data mahasiswa, ringkasan, tabel nilai
- Footer: Tanda tangan Kaprodi dan Mahasiswa, tanggal cetak
