# DOKUMENTASI EXPORT PRESENSI DOSEN

## Fitur Export Excel untuk Manajemen Presensi Dosen

### Deskripsi:
Fitur ini memungkinkan admin untuk mengekspor data presensi dosen ke dalam format Excel (.xlsx). Export akan mengikuti filter yang sedang aktif di halaman, sehingga admin bisa mengekspor data yang spesifik sesuai kebutuhan.

### Cara Penggunaan:

#### 1. **Akses Halaman Manajemen Presensi Dosen**
   - Login sebagai Admin
   - Menu: Admin > Manajemen Presensi Dosen

#### 2. **Gunakan Filter (Opsional)**
   - **Search**: Cari berdasarkan nama dosen, NIDN, email, lokasi, status, atau keterangan
   - **Status**: Filter berdasarkan status (Hadir, Izin, Sakit, Alpha)
   - **Dosen**: Filter berdasarkan dosen tertentu
   - **Lokasi**: Filter berdasarkan lokasi presensi
   - **Tanggal Dari**: Filter tanggal mulai
   - **Tanggal Sampai**: Filter tanggal akhir

#### 3. **Export Data**
   - Klik tombol **"Export Data"** (icon Excel hijau)
   - File Excel akan otomatis terdownload
   - Nama file: `data_presensi_dosen_YYYYMMDD_HHMMSS.xlsx`

### Format File Excel:

File Excel yang dihasilkan berisi kolom-kolom berikut:

| Kolom | Keterangan |
|-------|------------|
| No | Nomor urut |
| Nama Dosen | Nama lengkap dosen |
| NIDN | Nomor Induk Dosen Nasional |
| Email | Email dosen |
| Waktu Presensi | Tanggal dan waktu presensi (dd/mm/yyyy HH:mm:ss) |
| Status | Status presensi (Hadir/Izin/Sakit/Alpha) |
| Presensi Ke | Presensi ke-1 atau ke-2 |
| Lokasi | Nama lokasi presensi |
| Latitude | Koordinat latitude |
| Longitude | Koordinat longitude |
| Jarak (meter) | Jarak dari titik lokasi (dalam meter) |
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
   - Semua informasi presensi dosen
   - Relasi dengan data dosen dan lokasi
   - Format yang rapi dan mudah dibaca

### Contoh Use Case:

**1. Export Semua Presensi Dosen**
   - Tanpa filter apapun
   - Klik "Export Data"
   - Mendapat semua data presensi

**2. Export Presensi Bulan Ini**
   - Set "Tanggal Dari": 01/11/2024
   - Set "Tanggal Sampai": 30/11/2024
   - Klik "Export Data"
   - Mendapat data presensi November 2024

**3. Export Presensi Dosen Tertentu**
   - Pilih dosen dari dropdown
   - Klik "Export Data"
   - Mendapat data presensi dosen tersebut

**4. Export Presensi dengan Status Tertentu**
   - Pilih status "Izin" atau "Sakit"
   - Klik "Export Data"
   - Mendapat data presensi dengan status tersebut

### File yang Terlibat:

#### 1. Export Class
- **Path**: `app/Exports/PresensiDosenExport.php`
- **Function**: 
  - Mengambil data dari database dengan filter
  - Mapping data ke format Excel
  - Styling header dan kolom

#### 2. Controller Method
- **Path**: `app/Http/Controllers/Admin/ManajemenPresensiDosenController.php`
- **Method**: `export(Request $request)`
- **Function**: 
  - Menerima request dengan filter
  - Memanggil Export class
  - Mengirim file Excel ke browser

#### 3. Route
- **Path**: `routes/web.php`
- **Route**: `GET /admin/manajemen-presensi-dosen/export`
- **Name**: `admin.manajemen-presensi-dosen.export`

#### 4. View (Button)
- **Path**: `resources/views/admin/manajemenPresensiDosen/index.blade.php`
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

4. **Koordinat**:
   - Untuk status Izin/Sakit, koordinat = 0
   - Untuk status Hadir/Alpha, koordinat sesuai lokasi presensi

### Testing:

**Test Export Tanpa Filter:**
```bash
# Akses: http://localhost/admin/manajemen-presensi-dosen/export
# Expected: Download file dengan semua data
```

**Test Export dengan Filter:**
```bash
# Akses: http://localhost/admin/manajemen-presensi-dosen/export?status=hadir&tanggal_dari=2024-10-01
# Expected: Download file dengan data filtered
```

**Test Export Data Kosong:**
```bash
# Filter dengan kriteria yang tidak ada datanya
# Expected: File Excel dengan header saja
```

---

**Status**: ✅ Fitur sudah selesai diimplementasikan dan siap digunakan!

**Tanggal**: 24 Oktober 2025
