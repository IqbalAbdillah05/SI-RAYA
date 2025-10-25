# Dokumentasi Input Nilai Mahasiswa

## Deskripsi
Sistem input nilai mahasiswa yang memungkinkan dosen untuk menginput nilai mahasiswa berdasarkan Program Studi, Semester, dan Mata Kuliah.

## Fitur Utama

### 1. Halaman Index (Daftar Nilai)
- **Route**: `dosen.inputNilai.index`
- **URL**: `/dosen/input-nilai`
- **Fitur**:
  - Menampilkan daftar nilai yang sudah diinput
  - Tabel dengan informasi: NIM, Nama, Mata Kuliah, Prodi, Semester, Tahun Ajaran, Nilai
  - Badge warna untuk nilai (A = hijau, B = biru, C = oranye, D = merah, E = ungu)
  - Tombol aksi: Detail, Edit, Hapus
  - Pagination

### 2. Halaman Create (Input Nilai Baru)
- **Route**: `dosen.inputNilai.create`
- **URL**: `/dosen/input-nilai/create`
- **Alur Kerja**:
  1. **Step 1**: Pilih filter
     - Program Studi (dropdown)
     - Semester (1-8)
     - Mata Kuliah (otomatis load via AJAX berdasarkan prodi & semester)
  
  2. **Step 2**: Input nilai
     - Menampilkan daftar mahasiswa aktif berdasarkan filter
     - Form tabel untuk input nilai per mahasiswa
     - Input: Tahun Ajaran, Nilai Angka (0-100)
     - Status badge: "Sudah Ada" (jika nilai sudah pernah diinput) atau "Baru"
     - Nilai huruf dan indeks otomatis dihitung saat simpan

### 3. Halaman Show (Detail Nilai)
- **Route**: `dosen.inputNilai.show`
- **URL**: `/dosen/input-nilai/{id}`
- **Fitur**:
  - Tampilan detail lengkap nilai mahasiswa
  - Display nilai besar dengan gradient background
  - Informasi: Data Mahasiswa, Data Mata Kuliah, Data Nilai
  - Tombol: Edit Nilai, Kembali

### 4. Halaman Edit (Edit Nilai)
- **Route**: `dosen.inputNilai.edit`
- **URL**: `/dosen/input-nilai/{id}/edit`
- **Fitur**:
  - Form edit nilai angka dan tahun ajaran
  - Preview real-time konversi nilai (huruf & indeks)
  - Menampilkan nilai saat ini sebagai referensi
  - Data mahasiswa dan mata kuliah read-only

## Konversi Nilai

### Nilai Angka ke Huruf
- 96-100: A+
- 86-95: A
- 81-85: A-
- 76-80: B+
- 71-75: B
- 66-70: B-
- 61-65: C+
- 56-60: C
- 41-55: D
- 0-40: E

### Nilai Angka ke Indeks
- 96-100: 4.00
- 86-95: 3.50
- 81-85: 3.25
- 76-80: 3.00
- 71-75: 2.75
- 66-70: 2.50
- 61-65: 2.25
- 56-60: 2.00
- 41-55: 1.00
- 0-40: 0.00

## File-file Terkait

### Controller
- `app/Http/Controllers/Dosen/InputNilaiController.php`

### Views
- `resources/views/dosen/inputNilaiMahasiswa/index.blade.php`
- `resources/views/dosen/inputNilaiMahasiswa/create.blade.php`
- `resources/views/dosen/inputNilaiMahasiswa/show.blade.php`
- `resources/views/dosen/inputNilaiMahasiswa/edit.blade.php`

### Models
- `app/Models/NilaiMahasiswa.php` (dengan observer untuk auto konversi)
- `app/Models/Mahasiswa.php`
- `app/Models/MataKuliah.php`
- `app/Models/Prodi.php`
- `app/Models/Dosen.php`

### Routes
```php
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
```

## Styling & Design

### Konsep Design
- Mengikuti gaya halaman presensi (clean, modern, minimalis)
- Konsistensi warna:
  - Primary: #1976d2 (biru)
  - Success: #28a745 (hijau)
  - Warning: #ffc107 (kuning)
  - Danger: #dc3545 (merah)
  - Info: #17a2b8 (cyan)

### Komponen CSS
- Card simple dengan border radius 8px
- Form elements dengan focus state
- Button dengan hover effect
- Table dengan hover row
- Status badge dengan warna berbeda
- Alert boxes untuk notifikasi
- Responsive design untuk mobile

## Validasi

### Create/Store
- `prodi_id`: required, exists di tabel prodi
- `semester`: required, integer, min:1, max:8
- `mata_kuliah_id`: required, exists di tabel mata_kuliah
- `nilai.*.mahasiswa_id`: required, exists di tabel mahasiswa_profiles
- `nilai.*.nilai_angka`: required, numeric, min:0, max:100
- `nilai.*.tahun_ajaran`: required, string

### Update
- `nilai_angka`: required, numeric, min:0, max:100
- `tahun_ajaran`: required, string

## Fitur Khusus

1. **AJAX Loading Mata Kuliah**: Mata kuliah di-load otomatis saat prodi dan semester dipilih
2. **Batch Input**: Bisa input nilai untuk banyak mahasiswa sekaligus
3. **Update/Insert**: Otomatis update jika nilai sudah ada, insert jika baru
4. **Auto Konversi**: Nilai huruf dan indeks otomatis dihitung via model observer
5. **Preview Real-time**: Di halaman edit, preview konversi nilai tampil saat input

## Cara Penggunaan

1. Login sebagai dosen
2. Klik menu "Input Nilai" di navbar
3. Klik tombol "Input Nilai Baru"
4. Pilih Program Studi, Semester, lalu Mata Kuliah
5. Klik "Tampilkan Mahasiswa"
6. Input nilai untuk masing-masing mahasiswa
7. Klik "Simpan Nilai"
8. Nilai tersimpan dan bisa dilihat di halaman index

## Catatan Penting

- Nilai yang sudah ada akan di-update jika diinput ulang
- Sistem otomatis menghitung nilai huruf dan indeks
- Hanya mahasiswa dengan status "aktif" yang ditampilkan
- Dosen harus sudah memiliki profile lengkap
- Validasi memastikan nilai antara 0-100
