# DOKUMENTASI EXPORT PRESENSI MAHASISWA

## Fitur Export Excel untuk Manajemen Presensi Mahasiswa

### Deskripsi:
Fitur ini memungkinkan admin untuk mengekspor data presensi mahasiswa ke dalam format Excel (.xlsx). Export akan mengikuti filter yang sedang aktif di halaman, sehingga admin bisa mengekspor data yang spesifik sesuai kebutuhan.

### Cara Penggunaan:

#### 1. **Akses Halaman Manajemen Presensi Mahasiswa**
   - Login sebagai Admin
   - Menu: Admin > Manajemen Presensi Mahasiswa

#### 2. **Gunakan Filter (Opsional)**
   - **Search**: Cari berdasarkan nama mahasiswa, NIM, email, mata kuliah, dosen, prodi, atau status
   - **Status**: Filter berdasarkan status (Hadir, Izin, Sakit, Alpha)
   - **Mahasiswa**: Filter berdasarkan mahasiswa tertentu
   - **Dosen**: Filter berdasarkan dosen pengampu
   - **Mata Kuliah**: Filter berdasarkan mata kuliah
   - **Prodi**: Filter berdasarkan program studi
   - **Semester**: Filter berdasarkan semester
   - **Tanggal Dari**: Filter tanggal mulai
   - **Tanggal Sampai**: Filter tanggal akhir

#### 3. **Export Data**
   - Klik tombol **"Export Data"** (icon Excel hijau)
   - File Excel akan otomatis terdownload
   - Nama file: `data_presensi_mahasiswa_YYYYMMDD_HHMMSS.xlsx`

### Format File Excel:

File Excel yang dihasilkan berisi kolom-kolom berikut:

| Kolom | Keterangan |
|-------|------------|
| No | Nomor urut |
| Nama Mahasiswa | Nama lengkap mahasiswa |
| NIM | Nomor Induk Mahasiswa |
| Program Studi | Nama program studi |
| Semester | Semester mahasiswa |
| Mata Kuliah | Nama dan kode mata kuliah |
| Dosen Pengampu | Nama dosen pengampu |
| Waktu Presensi | Tanggal dan waktu presensi (dd/mm/yyyy HH:mm:ss) |
| Status | Status presensi (Hadir/Izin/Sakit/Alpha) |
| Keterangan | Keterangan tambahan |

### Fitur Export:

✅ **Filter-Aware Export**
   - Export hanya data yang sesuai dengan filter aktif
   - Jika tidak ada filter, export semua data

✅ **Styling Excel**
   - Header dengan background biru (#4472C4) dan teks putih
   - Font bold untuk header
   - Kolom dengan lebar yang sudah disesuaikan
   - Format tanggal Indonesia (dd/mm/yyyy)

✅ **Data Lengkap**
   - Semua informasi presensi mahasiswa
   - Relasi dengan data mahasiswa, dosen, mata kuliah, dan prodi
   - Format yang rapi dan mudah dibaca

### Contoh Use Case:

**1. Export Semua Presensi Mahasiswa**
   - Tanpa filter apapun
   - Klik "Export Data"
   - Mendapat semua data presensi

**2. Export Presensi Bulan Ini**
   - Set "Tanggal Dari": 01/11/2024
   - Set "Tanggal Sampai": 30/11/2024
   - Klik "Export Data"
   - Mendapat data presensi November 2024

**3. Export Presensi Mahasiswa Tertentu**
   - Pilih mahasiswa dari dropdown
   - Klik "Export Data"
   - Mendapat data presensi mahasiswa tersebut

**4. Export Presensi Per Mata Kuliah**
   - Pilih mata kuliah dari dropdown
   - Klik "Export Data"
   - Mendapat data presensi mata kuliah tersebut

**5. Export Presensi Per Prodi dan Semester**
   - Pilih prodi dari dropdown
   - Pilih semester
   - Klik "Export Data"
   - Mendapat data presensi prodi dan semester tersebut

**6. Export Presensi dengan Status Tertentu**
   - Pilih status "Izin" atau "Sakit"
   - Klik "Export Data"
   - Mendapat data presensi dengan status tersebut

### File yang Terlibat:

#### 1. Export Class
- **Path**: `app/Exports/PresensiMahasiswaExport.php`
- **Function**: 
  - Mengambil data dari database dengan filter
  - Mapping data ke format Excel
  - Styling header dan kolom

#### 2. Controller Method
- **Path**: `app/Http/Controllers/Admin/ManajemenPresensiMahasiswaController.php`
- **Method**: `export(Request $request)`
- **Function**: 
  - Menerima request dengan filter
  - Memanggil Export class
  - Mengirim file Excel ke browser

#### 3. Route
- **Path**: `routes/web.php`
- **Route**: `GET /admin/manajemen-presensi-mahasiswa/export`
- **Name**: `admin.manajemen-presensi-mahasiswa.export`

#### 4. View (Button)
- **Path**: `resources/views/admin/manajemenPresensiMahasiswa/index.blade.php`
- **Element**: Tombol "Export Data" dengan icon Excel

### Dependencies:

Package yang digunakan:
- **maatwebsite/excel** v3.1
- **phpoffice/phpspreadsheet** v1.30

### Catatan Teknis:

1. **Performance**: 
   - Export menggunakan lazy loading untuk data besar
   - Tidak ada limit jumlah data

2. **Format Date**:
   - Format tanggal Indonesia (dd/mm/yyyy)
   - Waktu 24 jam (HH:mm:ss)

3. **Data Kosong**:
   - Jika tidak ada data, file tetap dibuat dengan header saja
   - Kolom kosong ditampilkan dengan tanda "-"

4. **Relasi Data**:
   - Data mahasiswa dari tabel `mahasiswa`
   - Data dosen dari tabel `dosen_profiles`
   - Data mata kuliah dari tabel `mata_kuliah`
   - Data prodi dari tabel `prodi`

5. **Filter Multiple**:
   - Semua filter bisa dikombinasikan
   - Filter diterapkan dengan operator AND
   - Search menggunakan operator LIKE dengan OR

### Perbandingan dengan Export Presensi Dosen:

| Aspek | Presensi Mahasiswa | Presensi Dosen |
|-------|-------------------|----------------|
| Kolom Excel | 10 kolom | 12 kolom |
| Filter | 9 filter | 6 filter |
| Relasi | Mahasiswa, Dosen, MataKuliah, Prodi | Dosen, Lokasi |
| Data Lokasi | ❌ Tidak ada | ✅ Ada (Latitude, Longitude, Jarak) |
| Data Akademik | ✅ Ada (Semester, MataKuliah, Prodi) | ❌ Tidak ada |
| Foto Bukti | ✅ Ada | ✅ Ada |

### Testing:

**Test Export Tanpa Filter:**
```bash
# Akses: http://localhost/admin/manajemen-presensi-mahasiswa/export
# Expected: Download file dengan semua data
```

**Test Export dengan Filter:**
```bash
# Akses: http://localhost/admin/manajemen-presensi-mahasiswa/export?status=hadir&semester=5
# Expected: Download file dengan data filtered
```

**Test Export Data Kosong:**
```bash
# Filter dengan kriteria yang tidak ada datanya
# Expected: File Excel dengan header saja
```

**Test Export Kombinasi Filter:**
```bash
# Akses: http://localhost/admin/manajemen-presensi-mahasiswa/export?prodi_id=1&semester=3&tanggal_dari=2024-10-01&tanggal_sampai=2024-10-31
# Expected: Download file dengan data mahasiswa prodi tertentu, semester 3, Oktober 2024
```

### Tips Penggunaan:

1. **Export Data Bulanan**: 
   - Gunakan filter tanggal untuk export data per bulan
   - Berguna untuk laporan bulanan

2. **Export Per Mata Kuliah**: 
   - Filter berdasarkan mata kuliah
   - Berguna untuk rekap kehadiran per mata kuliah

3. **Export Per Prodi**: 
   - Filter berdasarkan prodi dan semester
   - Berguna untuk laporan per program studi

4. **Export Mahasiswa Bermasalah**: 
   - Filter status "Alpha" atau "Izin"
   - Berguna untuk monitoring kehadiran

5. **Export untuk Evaluasi Dosen**: 
   - Filter berdasarkan dosen pengampu
   - Berguna untuk evaluasi pengajaran

---

**Status**: ✅ Fitur sudah selesai diimplementasikan dan siap digunakan!

**Tanggal**: 24 Oktober 2025
