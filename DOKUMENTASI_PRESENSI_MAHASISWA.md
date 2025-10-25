# Dokumentasi Sistem Presensi Mahasiswa

## Deskripsi
Sistem presensi mahasiswa memungkinkan dosen untuk melakukan presensi mahasiswa berdasarkan jadwal mengajar. Dosen dapat memilih program studi, semester, dan mata kuliah yang diampu, kemudian melakukan presensi untuk semua mahasiswa dalam kelas tersebut.

## Fitur Utama

### 1. Halaman Index (Daftar Presensi)
**Route:** `/dosen/presensi-mahasiswa`
**File:** `resources/views/dosen/presensiMahasiswa/index.blade.php`

Fitur:
- **Tab Ringkasan**: Menampilkan ringkasan presensi per kelas dengan statistik (hadir, izin, sakit, alpha)
- **Tab Detail**: Menampilkan detail presensi individual mahasiswa
- Tombol untuk membuat presensi baru
- Pagination untuk navigasi data

### 2. Halaman Create (Input Presensi)
**Route:** `/dosen/presensi-mahasiswa/create`
**File:** `resources/views/dosen/presensiMahasiswa/create.blade.php`

Fitur:
- Filter berdasarkan:
  - Program Studi
  - Semester
  - Mata Kuliah (hanya yang diampu dosen)
  - Tanggal Presensi
- Mata kuliah yang ditampilkan hanya yang ada di jadwal dosen
- Daftar mahasiswa berdasarkan filter
- Status presensi: Hadir, Izin, Sakit, Alpha
- Kolom keterangan opsional
- Tombol quick action:
  - "Semua Hadir" - set semua mahasiswa hadir
  - "Semua Alpha" - set semua mahasiswa alpha

### 4. Halaman Show (Detail Presensi)
**Route:** `/dosen/presensi-mahasiswa/{id}`
**File:** `resources/views/dosen/presensiMahasiswa/show.blade.php`

Menampilkan detail lengkap presensi mahasiswa tertentu.

### 5. Halaman Edit (Edit Presensi)
**Route:** `/dosen/presensi-mahasiswa/{id}/edit`
**File:** `resources/views/dosen/presensiMahasiswa/edit.blade.php`

Fitur:
- Edit status presensi mahasiswa
- Edit keterangan
- Informasi mahasiswa dan mata kuliah

### 6. Halaman Riwayat (History Presensi)
**Route:** `/dosen/presensi-mahasiswa/riwayat`
**File:** `resources/views/dosen/presensiMahasiswa/riwayat.blade.php`

Fitur:
- Filter berdasarkan:
  - Mahasiswa (dropdown semua mahasiswa yang pernah dipresensi)
  - Mata Kuliah
  - Range Tanggal (dari - sampai)
- Statistik kehadiran jika mahasiswa dipilih:
  - Total pertemuan
  - Jumlah hadir, izin, sakit, alpha
  - Persentase kehadiran
- Tabel riwayat dengan pagination
- Aksi: Lihat detail dan Edit

## Alur Sistem

1. **Dosen memilih filter**
   - Pilih Program Studi
   - Pilih Semester
   - Pilih Mata Kuliah (otomatis load mata kuliah yang diampu dosen)
   - Pilih Tanggal Presensi

2. **Tampilkan Mahasiswa**
   - Klik tombol "Tampilkan Mahasiswa"
   - Sistem menampilkan daftar mahasiswa sesuai filter
   - Default status: Hadir

3. **Input Presensi**
   - Centang status untuk setiap mahasiswa (Hadir/Izin/Sakit/Alpha)
   - Tambahkan keterangan jika diperlukan
   - Gunakan quick action untuk mempercepat (opsional)

4. **Simpan**
   - Klik "Simpan Presensi"
   - Sistem menyimpan atau update presensi
   - Redirect ke halaman index dengan notifikasi sukses

## Database

### Tabel: presensi_mahasiswa
Kolom utama:
- `mahasiswa_id` - ID mahasiswa
- `dosen_id` - ID dosen yang melakukan presensi
- `mata_kuliah_id` - ID mata kuliah
- `prodi_id` - ID program studi
- `semester` - Semester mahasiswa
- `waktu_presensi` - Timestamp presensi
- `status` - Status: hadir, izin, sakit, alpha
- `keterangan` - Keterangan tambahan (opsional)

## Controller

**File:** `app/Http/Controllers/Dosen/PresensiMahasiswaController.php`

Method utama:
- `index()` - Tampilkan daftar presensi
- `create()` - Form input presensi
- `store()` - Simpan presensi baru atau update
- `show($id)` - Detail presensi
- `riwayat()` - Halaman riwayat dengan filter & statistik
- `edit($id)` - Form edit presensi
- `update($id)` - Update presensi
- `destroy($id)` - Hapus presensi
- `getMatakuliah()` - AJAX: ambil mata kuliah berdasarkan jadwal dosen
- `getMahasiswaByProdiSemester()` - AJAX: ambil mahasiswa berdasarkan filter

## Routes

```php
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
```

## Model Relations

### MataKuliah
```php
public function jadwal()
{
    return $this->hasMany(Jadwal::class, 'mata_kuliah_id');
}

public function presensiMahasiswa()
{
    return $this->hasMany(PresensiMahasiswa::class, 'mata_kuliah_id');
}
```

### Mahasiswa
```php
public function presensi()
{
    return $this->hasMany(PresensiMahasiswa::class, 'mahasiswa_id');
}
```

## Validasi

### Store Request
- `prodi_id` - required, exists
- `semester` - required, integer, 1-8
- `matakuliah_id` - required, exists
- `tanggal_presensi` - required, date
- `mahasiswa_id` - required, array
- `status` - required, array, in:hadir,izin,sakit,alpha

### Update Request
- `status` - required, in:hadir,izin,sakit,alpha
- `keterangan` - nullable, string

## Menu Navigasi

**Desktop & Mobile:**
- Presensi Mahasiswa > Kelola Presensi
- Presensi Mahasiswa > Riwayat Mahasiswa

## Desain & Styling

Mengikuti gaya dari halaman Input Nilai dengan:
- Card-based layout
- Responsive design
- Color-coded status badges
- Loading overlay untuk AJAX
- Form validation
- Clean & modern UI

## Keamanan

- Authentication required (middleware: auth, dosen)
- Hanya dosen yang login dapat mengakses
- Validasi semua input
- CSRF protection
- Database transaction untuk konsistensi data

## Tips Penggunaan

1. **Quick Action**: Gunakan tombol "Semua Hadir" untuk kelas dengan kehadiran penuh, lalu ubah hanya yang tidak hadir
2. **Keterangan**: Tambahkan keterangan untuk mahasiswa yang izin/sakit untuk dokumentasi
3. **Update Presensi**: Presensi dapat diupdate jika ada kesalahan input
4. **Filter Mata Kuliah**: Sistem otomatis hanya menampilkan mata kuliah yang ada di jadwal mengajar dosen

## File-file Penting

### Controller
- `app/Http/Controllers/Dosen/PresensiMahasiswaController.php`

### Views
- `resources/views/dosen/presensiMahasiswa/index.blade.php`
- `resources/views/dosen/presensiMahasiswa/create.blade.php`
- `resources/views/dosen/presensiMahasiswa/show.blade.php`
- `resources/views/dosen/presensiMahasiswa/edit.blade.php`
- `resources/views/dosen/presensiMahasiswa/riwayat.blade.php`

### Routes
- `routes/web.php` (section: Dosen Routes > Presensi Mahasiswa)

### Models
- `app/Models/PresensiMahasiswa.php`
- `app/Models/MataKuliah.php` (updated with jadwal relation)

---

## Update Log
- Dibuat: 21 Oktober 2025
- Versi: 1.0
- Developer: System
