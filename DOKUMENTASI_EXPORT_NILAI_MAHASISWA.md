# DOKUMENTASI EXPORT NILAI MAHASISWA

## Fitur Export Excel untuk Manajemen Nilai Mahasiswa

### Deskripsi:
Fitur ini memungkinkan admin untuk mengekspor data nilai mahasiswa ke dalam format Excel (.xlsx). Export akan mengikuti filter yang sedang aktif di halaman, sehingga admin bisa mengekspor data yang spesifik sesuai kebutuhan.

### Cara Penggunaan:

#### 1. **Akses Halaman Manajemen Nilai Mahasiswa**
   - Login sebagai Admin
   - Menu: Admin > Manajemen Nilai Mahasiswa

#### 2. **Gunakan Filter (Opsional)**
   - **Search**: Cari berdasarkan nama mahasiswa, NIM, mata kuliah, dosen, prodi, nilai, atau tahun ajaran
   - **Mahasiswa**: Filter berdasarkan mahasiswa tertentu
   - **Mata Kuliah**: Filter berdasarkan mata kuliah
   - **Prodi**: Filter berdasarkan program studi
   - **Semester**: Filter berdasarkan semester
   - **Tahun Ajaran**: Filter berdasarkan tahun ajaran (contoh: 2024/2025)

#### 3. **Export Data**
   - Klik tombol **"Export Data"** (icon Excel hijau)
   - File Excel akan otomatis terdownload
   - Nama file: `data_nilai_mahasiswa_YYYYMMDD_HHMMSS.xlsx`

### Format File Excel:

File Excel yang dihasilkan berisi kolom-kolom berikut:

| Kolom | Keterangan |
|-------|------------|
| No | Nomor urut |
| Nama Mahasiswa | Nama lengkap mahasiswa |
| NIM | Nomor Induk Mahasiswa |
| Program Studi | Nama program studi |
| Semester | Semester mahasiswa |
| Tahun Ajaran | Tahun ajaran (contoh: 2024/2025) |
| Mata Kuliah | Nama mata kuliah |
| Kode MK | Kode mata kuliah |
| Dosen Pengampu | Nama dosen pengampu |
| Nilai Angka | Nilai dalam bentuk angka (0-100) |
| Nilai Huruf | Nilai dalam bentuk huruf (A, B+, B, C+, C, D, E) |
| Nilai Indeks | Nilai indeks prestasi (0.00-4.00) |

### Fitur Export:

✅ **Filter-Aware Export**
   - Export hanya data yang sesuai dengan filter aktif
   - Jika tidak ada filter, export semua data

✅ **Styling Excel**
   - Header dengan background biru (#4472C4) dan teks putih
   - Font bold untuk header
   - Kolom dengan lebar yang sudah disesuaikan
   - Format rapi dan profesional

✅ **Data Lengkap**
   - Semua informasi nilai mahasiswa
   - Relasi dengan data mahasiswa, dosen, mata kuliah, dan prodi
   - Format yang rapi dan mudah dibaca

✅ **Data Akademik Lengkap**
   - Nilai angka, huruf, dan indeks
   - Informasi semester dan tahun ajaran
   - Kode dan nama mata kuliah

### Contoh Use Case:

**1. Export Semua Nilai Mahasiswa**
   - Tanpa filter apapun
   - Klik "Export Data"
   - Mendapat semua data nilai

**2. Export Nilai Per Semester**
   - Pilih semester dari dropdown (contoh: Semester 5)
   - Klik "Export Data"
   - Mendapat data nilai semester 5

**3. Export Nilai Per Tahun Ajaran**
   - Pilih tahun ajaran (contoh: 2024/2025)
   - Klik "Export Data"
   - Mendapat data nilai tahun ajaran 2024/2025

**4. Export Nilai Mahasiswa Tertentu**
   - Pilih mahasiswa dari dropdown
   - Klik "Export Data"
   - Mendapat transkrip nilai mahasiswa tersebut

**5. Export Nilai Per Mata Kuliah**
   - Pilih mata kuliah dari dropdown
   - Klik "Export Data"
   - Mendapat rekap nilai mata kuliah tersebut

**6. Export Nilai Per Prodi**
   - Pilih prodi dari dropdown
   - Pilih semester (opsional)
   - Klik "Export Data"
   - Mendapat data nilai per prodi

**7. Export Nilai Per Prodi dan Semester**
   - Pilih prodi
   - Pilih semester
   - Pilih tahun ajaran
   - Klik "Export Data"
   - Mendapat data nilai spesifik

### File yang Terlibat:

#### 1. Export Class
- **Path**: `app/Exports/NilaiMahasiswaExport.php`
- **Function**: 
  - Mengambil data dari database dengan filter
  - Mapping data ke format Excel dengan 12 kolom
  - Styling header dan kolom

#### 2. Controller Method
- **Path**: `app/Http/Controllers/Admin/ManajemenNilaiMahasiswaController.php`
- **Method**: `export(Request $request)`
- **Function**: 
  - Menerima request dengan filter
  - Memanggil Export class
  - Mengirim file Excel ke browser

#### 3. Route
- **Path**: `routes/web.php`
- **Route**: `GET /admin/manajemen-nilai-mahasiswa/export`
- **Name**: `admin.manajemen-nilai-mahasiswa.export`

#### 4. View (Button)
- **Path**: `resources/views/admin/manajemenNilaiMahasiswa/index.blade.php`
- **Element**: Tombol "Export Data" dengan icon Excel

### Dependencies:

Package yang digunakan:
- **maatwebsite/excel** v3.1
- **phpoffice/phpspreadsheet** v1.30

### Catatan Teknis:

1. **Performance**: 
   - Export menggunakan lazy loading untuk data besar
   - Tidak ada limit jumlah data

2. **Format Nilai**:
   - Nilai angka: Decimal dengan 2 digit
   - Nilai huruf: A, B+, B, C+, C, D, E
   - Nilai indeks: Decimal dengan 2 digit (0.00-4.00)

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

### Konversi Nilai:

Sistem menggunakan konversi nilai standar:

| Nilai Angka | Nilai Huruf | Nilai Indeks |
|-------------|-------------|--------------|
| 85-100 | A | 4.00 |
| 80-84 | B+ | 3.50 |
| 75-79 | B | 3.00 |
| 70-74 | C+ | 2.50 |
| 65-69 | C | 2.00 |
| 50-64 | D | 1.00 |
| 0-49 | E | 0.00 |

### Manfaat Export Nilai:

1. **Transkrip Mahasiswa**: 
   - Export nilai per mahasiswa
   - Untuk pembuatan transkrip nilai

2. **Rekap Per Mata Kuliah**: 
   - Export nilai per mata kuliah
   - Untuk evaluasi pembelajaran

3. **Rekap Per Semester**: 
   - Export nilai per semester
   - Untuk laporan akademik

4. **Rekap Per Prodi**: 
   - Export nilai per prodi
   - Untuk evaluasi program studi

5. **Arsip Data**: 
   - Export semua data nilai
   - Untuk backup dan arsip

### Perbandingan dengan Export Lainnya:

| Aspek | Nilai Mahasiswa | Presensi Mahasiswa | Presensi Dosen |
|-------|----------------|-------------------|----------------|
| Kolom Excel | 12 kolom | 10 kolom | 12 kolom |
| Filter | 6 filter | 9 filter | 6 filter |
| Data Akademik | ✅ Nilai lengkap | ✅ Semester, MK | ❌ Tidak ada |
| Data Lokasi | ❌ Tidak ada | ❌ Tidak ada | ✅ Ada |
| Tahun Ajaran | ✅ Ada | ❌ Tidak ada | ❌ Tidak ada |
| Use Case | Transkrip, Rekap Nilai | Rekap Kehadiran | Rekap Kehadiran Dosen |

### Testing:

**Test Export Tanpa Filter:**
```bash
# Akses: http://localhost/admin/manajemen-nilai-mahasiswa/export
# Expected: Download file dengan semua data nilai
```

**Test Export dengan Filter:**
```bash
# Akses: http://localhost/admin/manajemen-nilai-mahasiswa/export?semester=5&tahun_ajaran=2024/2025
# Expected: Download file dengan data nilai semester 5 tahun ajaran 2024/2025
```

**Test Export Transkrip Mahasiswa:**
```bash
# Akses: http://localhost/admin/manajemen-nilai-mahasiswa/export?mahasiswa_id=1
# Expected: Download file dengan transkrip nilai mahasiswa tertentu
```

**Test Export Per Mata Kuliah:**
```bash
# Akses: http://localhost/admin/manajemen-nilai-mahasiswa/export?mata_kuliah_id=5
# Expected: Download file dengan rekap nilai mata kuliah tertentu
```

**Test Export Kombinasi Filter:**
```bash
# Akses: http://localhost/admin/manajemen-nilai-mahasiswa/export?prodi_id=1&semester=3&tahun_ajaran=2024/2025
# Expected: Download file dengan data nilai prodi tertentu, semester 3, tahun 2024/2025
```

### Tips Penggunaan:

1. **Transkrip Mahasiswa**: 
   - Filter berdasarkan mahasiswa
   - Export untuk mendapat transkrip lengkap

2. **Evaluasi Mata Kuliah**: 
   - Filter berdasarkan mata kuliah
   - Export untuk analisis hasil pembelajaran

3. **Laporan Semester**: 
   - Filter berdasarkan semester dan tahun ajaran
   - Export untuk laporan akhir semester

4. **Monitoring Prodi**: 
   - Filter berdasarkan prodi
   - Export untuk evaluasi program studi

5. **Arsip Tahunan**: 
   - Filter berdasarkan tahun ajaran
   - Export untuk arsip per tahun akademik

### Keamanan Data:

⚠️ **Perhatian**:
- File Excel berisi data nilai mahasiswa yang sensitif
- Pastikan hanya admin yang memiliki akses
- Jangan share file ke pihak yang tidak berwenang
- Simpan file di tempat yang aman

---

**Status**: ✅ Fitur sudah selesai diimplementasikan dan siap digunakan!

**Tanggal**: 24 Oktober 2025
