# DOKUMENTASI EXPORT KRS (KARTU RENCANA STUDI)

## Fitur Export Excel untuk Kartu Rencana Studi (KRS)

### Deskripsi:
Fitur ini memungkinkan admin untuk mengekspor data KRS mahasiswa ke dalam format Excel (.xlsx). Export akan mengikuti filter yang sedang aktif di halaman, sehingga admin bisa mengekspor data yang spesifik sesuai kebutuhan.

### Cara Penggunaan:

#### 1. **Akses Halaman KRS**
   - Login sebagai Admin
   - Menu: Admin > Kartu Rencana Studi (KRS)

#### 2. **Gunakan Filter (Opsional)**
   - **Search**: Cari berdasarkan nama mahasiswa, NIM, program studi, semester, tahun ajaran, atau status validasi

#### 3. **Export Data**
   - Klik tombol **"Export Data"** (icon Excel hijau)
   - File Excel akan otomatis terdownload
   - Nama file: `data_krs_YYYYMMDD_HHMMSS.xlsx`

### Format File Excel:

File Excel yang dihasilkan berisi kolom-kolom berikut:

| Kolom | Keterangan |
|-------|------------|
| No | Nomor urut |
| Nama Mahasiswa | Nama lengkap mahasiswa |
| NIM | Nomor Induk Mahasiswa |
| Program Studi | Nama program studi |
| Semester | Semester KRS |
| Tahun Ajaran | Tahun ajaran (contoh: 2024/2025) |
| Tanggal Pengisian | Tanggal pengisian KRS (dd/mm/yyyy) |
| Total SKS | Total SKS yang diambil |
| Jumlah MK | Jumlah mata kuliah yang diambil |
| Mata Kuliah yang Diambil | Daftar mata kuliah lengkap dengan kode dan SKS |
| Status Validasi | Status persetujuan KRS (Menunggu/Disetujui/Ditolak) |

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
   - Semua informasi KRS mahasiswa
   - Detail mata kuliah yang diambil
   - Total SKS dan jumlah mata kuliah
   - Status validasi KRS

✅ **Informasi Detail**
   - Daftar mata kuliah dengan format: Kode - Nama (SKS)
   - **Tampilan vertikal** dengan text wrapping (satu mata kuliah per baris)
   - Kolom mata kuliah dengan lebar optimal (45 karakter)
   - Auto row height untuk menampung semua mata kuliah
   - Format rapi dan mudah dibaca

### Contoh Use Case:

**1. Export Semua KRS**
   - Tanpa filter apapun
   - Klik "Export Data"
   - Mendapat semua data KRS

**2. Export KRS Semester Tertentu**
   - Search "Semester 5"
   - Klik "Export Data"
   - Mendapat data KRS semester 5

**3. Export KRS Tahun Ajaran**
   - Search "2024/2025"
   - Klik "Export Data"
   - Mendapat data KRS tahun ajaran 2024/2025

**4. Export KRS Menunggu Persetujuan**
   - Search "Menunggu"
   - Klik "Export Data"
   - Mendapat KRS yang belum divalidasi

**5. Export KRS Prodi Tertentu**
   - Search nama prodi (contoh: "Pendidikan Bahasa Arab")
   - Klik "Export Data"
   - Mendapat KRS mahasiswa prodi tersebut

**6. Export KRS Mahasiswa Tertentu**
   - Search nama atau NIM mahasiswa
   - Klik "Export Data"
   - Mendapat KRS mahasiswa tersebut

### File yang Terlibat:

#### 1. Export Class
- **Path**: `app/Exports/KrsExport.php`
- **Function**: 
  - Mengambil data KRS dari database dengan filter
  - Menghitung total SKS dan jumlah mata kuliah
  - Mapping data ke format Excel dengan 11 kolom
  - Styling header dan kolom

#### 2. Controller Method
- **Path**: `app/Http/Controllers/Admin/KrsController.php`
- **Method**: `export(Request $request)`
- **Function**: 
  - Menerima request dengan filter
  - Memanggil Export class
  - Mengirim file Excel ke browser

#### 3. Route
- **Path**: `routes/web.php`
- **Route**: `GET /admin/krs/export`
- **Name**: `admin.krs.export`

#### 4. View (Button)
- **Path**: `resources/views/admin/krs/index.blade.php`
- **Element**: Tombol "Export Data" dengan icon Excel

### Dependencies:

Package yang digunakan:
- **maatwebsite/excel** v3.1
- **phpoffice/phpspreadsheet** v1.30

### Catatan Teknis:

1. **Performance**: 
   - Export menggunakan lazy loading untuk data besar
   - Tidak ada limit jumlah data

2. **Format Data**:
   - Tanggal format Indonesia (dd/mm/yyyy)
   - Total SKS dihitung otomatis dari mata kuliah
   - Jumlah mata kuliah dihitung dari detail KRS

3. **Data Kosong**:
   - Jika tidak ada data, file tetap dibuat dengan header saja
   - Kolom kosong ditampilkan dengan tanda "-"

4. **Relasi Data**:
   - Data mahasiswa dari tabel `mahasiswa_profiles`
   - Data prodi dari tabel `prodi`
   - Data mata kuliah dari tabel `mata_kuliah`
   - Detail KRS dari tabel `krs_detail`

5. **Kolom Mata Kuliah**:
   - Lebar kolom 45 karakter (optimal untuk tampilan vertikal)
   - Format: `Kode - Nama (SKS SKS)`
   - **Tampilan vertikal**: Satu mata kuliah per baris dengan line break
   - Text wrapping aktif untuk menampilkan semua mata kuliah
   - Auto row height untuk menyesuaikan tinggi baris
   - Contoh tampilan:
     ```
     MK001 - Bahasa Arab I (3 SKS)
     MK002 - Fiqh (2 SKS)
     MK003 - Hadits (3 SKS)
     ```

### Informasi Tambahan:

**Status Validasi KRS:**
- **Menunggu**: KRS baru diisi, menunggu persetujuan admin
- **Disetujui**: KRS telah disetujui oleh admin
- **Ditolak**: KRS ditolak, mahasiswa perlu revisi

**Batas SKS:**
- Batas normal: 24 SKS per semester
- Mahasiswa dengan IPK tinggi bisa mengambil lebih
- Total SKS dihitung otomatis dalam export

### Manfaat Export KRS:

1. **Rekap Pengisian KRS**: 
   - Export untuk monitoring pengisian KRS
   - Cek mahasiswa yang belum mengisi

2. **Validasi Admin**: 
   - Export KRS yang menunggu persetujuan
   - Untuk proses validasi massal

3. **Laporan Akademik**: 
   - Export per semester/tahun ajaran
   - Untuk laporan ke pimpinan

4. **Analisis Program Studi**: 
   - Export per prodi
   - Untuk evaluasi kurikulum

5. **Arsip Data**: 
   - Export semua KRS
   - Untuk backup dan arsip

### Perbandingan dengan Export Lainnya:

| Aspek | KRS | Nilai Mahasiswa | Presensi Mahasiswa |
|-------|-----|----------------|-------------------|
| Kolom Excel | 11 kolom | 12 kolom | 10 kolom |
| Filter | 1 filter (search) | 6 filter | 9 filter |
| Data Mata Kuliah | ✅ Detail lengkap | ✅ Per MK | ✅ Per MK |
| Total SKS | ✅ Ada | ❌ Tidak ada | ❌ Tidak ada |
| Status Validasi | ✅ Ada | ❌ Tidak ada | ❌ Tidak ada |
| Tahun Ajaran | ✅ Ada | ✅ Ada | ❌ Tidak ada |
| Use Case | Pengisian KRS | Transkrip Nilai | Rekap Kehadiran |

### Testing:

**Test Export Tanpa Filter:**
```bash
# Akses: http://localhost/admin/krs/export
# Expected: Download file dengan semua data KRS
```

**Test Export dengan Search:**
```bash
# Akses: http://localhost/admin/krs/export?search=Semester%205
# Expected: Download file dengan KRS semester 5
```

**Test Export KRS Menunggu:**
```bash
# Akses: http://localhost/admin/krs/export?search=Menunggu
# Expected: Download file dengan KRS yang belum divalidasi
```

**Test Export KRS Mahasiswa:**
```bash
# Akses: http://localhost/admin/krs/export?search=Ahmad
# Expected: Download file dengan KRS mahasiswa bernama Ahmad
```

### Tips Penggunaan:

1. **Validasi Massal**: 
   - Export KRS dengan status "Menunggu"
   - Review offline sebelum approve di sistem

2. **Monitoring Semester**: 
   - Export KRS semester aktif
   - Cek mahasiswa yang belum mengisi

3. **Laporan Bulanan**: 
   - Export KRS per bulan
   - Untuk laporan ke pimpinan

4. **Evaluasi Prodi**: 
   - Export KRS per prodi
   - Analisis mata kuliah populer

5. **Arsip Tahunan**: 
   - Export semua KRS per tahun ajaran
   - Untuk dokumentasi dan backup

### Keamanan Data:

⚠️ **Perhatian**:
- File Excel berisi data akademik mahasiswa yang sensitif
- Pastikan hanya admin yang memiliki akses
- Jangan share file ke pihak yang tidak berwenang
- Simpan file di tempat yang aman

### Format Mata Kuliah dalam Excel:

**Tampilan Vertikal (Lebih Rapi):**

Setiap mata kuliah ditampilkan dalam baris terpisah di dalam satu cell dengan text wrapping:

```
MK001 - Bahasa Arab I (3 SKS)
MK002 - Fiqh (2 SKS)
MK003 - Hadits (3 SKS)
MK004 - Tafsir (2 SKS)
MK005 - Aqidah (2 SKS)
```

**Keuntungan Tampilan Vertikal:**
- ✅ Lebih mudah dibaca
- ✅ Tidak terlalu panjang horizontal
- ✅ Setiap mata kuliah jelas terpisah
- ✅ Auto row height menyesuaikan jumlah mata kuliah
- ✅ Cocok untuk print/PDF

---

**Status**: ✅ Fitur sudah selesai diimplementasikan dan siap digunakan!

**Tanggal**: 24 Oktober 2025
