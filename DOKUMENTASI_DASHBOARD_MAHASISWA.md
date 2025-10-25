# 📊 Update Dashboard Mahasiswa - Dokumentasi

## 🎯 Tujuan Update
Menyesuaikan dashboard mahasiswa agar memiliki gaya tata letak dan fungsionalitas yang sama dengan dashboard dosen, menggunakan data real dari database.

## 🔄 Perubahan yang Dilakukan

### 1. **Controller Update** (`app/Http/Controllers/Mahasiswa/DashboardController.php`)

#### ✅ Import Model Tambahan
```php
use App\Models\JadwalMahasiswa;
use App\Models\Khs;
use App\Models\KhsDetail;
use App\Models\Krs;
use App\Models\KrsDetail;
use Carbon\Carbon;
```

#### ✅ Statistik Real dari Database
```php
$stats = [
    'total_sks' => Total SKS yang diambil (dari KRS yang disetujui),
    'ipk' => IPK terbaru dari tabel KHS,
    'ips_terakhir' => IPS semester terakhir,
    'total_jadwal' => Total jadwal tahun ajaran aktif,
];
```

#### ✅ Data Jadwal Hari Ini
- Filter berdasarkan hari saat ini
- Urutkan berdasarkan jam mulai
- Include relasi: mataKuliah, dosen, prodi

#### ✅ Data KHS Terbaru
- Ambil 3 semester terakhir
- Include detail mata kuliah
- Urutkan dari semester terbaru

### 2. **View Update** (`resources/views/mahasiswa/dashboard.blade.php`)

#### ✅ Quick Stats - Data Real
**Sebelum:**
```php
<h3 class="stat-value">85%</h3>  // Hardcoded
<h3 class="stat-value">3.45</h3> // Hardcoded
<h3 class="stat-value">21</h3>   // Hardcoded
```

**Sesudah:**
```php
<h3 class="stat-value">{{ $stats['total_sks'] }}</h3>
<h3 class="stat-value">{{ number_format($stats['ips_terakhir'], 2) }}</h3>
<h3 class="stat-value">{{ number_format($stats['ipk'], 2) }}</h3>
```

#### ✅ Profile Card - Data Mahasiswa Real
**Ditambahkan:**
- NIM mahasiswa
- Nama lengkap
- Program studi (dari relasi)
- Jenis kelamin
- Email
- No. telepon
- Status aktif

#### ✅ Jadwal Hari Ini - Dynamic dengan Status
**Fitur:**
- Loop `@forelse` untuk handle data kosong
- Status dinamis: `Sedang Berlangsung`, `Akan Datang`, `Selesai`
- Perbandingan waktu real-time menggunakan Carbon
- Empty state dengan icon dan pesan

**Status Logic:**
```php
@if($now->between($startTime, $endTime))
    <div class="schedule-status ongoing">...</div>
@elseif($now->lt($startTime))
    <div class="schedule-status upcoming">...</div>
@else
    <div class="schedule-status finished">...</div>
@endif
```

#### ✅ Riwayat KHS Terbaru - Section Baru
**Fitur:**
- Menampilkan 3 KHS terakhir
- Badge predikat berdasarkan IPS:
  - IPS ≥ 3.5: "Dengan Pujian" (hijau)
  - IPS ≥ 3.0: "Sangat Memuaskan" (biru)
  - IPS ≥ 2.5: "Memuaskan" (kuning)
  - IPS < 2.5: "Cukup" (merah)
- Tombol download PDF per semester
- Empty state jika belum ada KHS

### 3. **CSS Enhancements**

#### ✅ Status Badge Baru
```css
.schedule-status.finished {
    background: #e5e7eb;
    color: #6b7280;
}
```

#### ✅ Activity Card Styling
```css
.activity-card
.activity-list
.activity-item
.activity-icon
.activity-content
.activity-time
```

#### ✅ Download Button Mini
```css
.btn-download-mini {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: var(--primary);
    ...
}
```

## 📋 Fitur-fitur Dashboard Mahasiswa

### 1. **Welcome Banner** 
- Nama mahasiswa
- Tanggal dengan format Indonesia
- Gradient background dengan ilustrasi

### 2. **Quick Stats (4 Cards)**
- ✅ Status Akademik: Aktif/Non-aktif
- ✅ Total SKS: Dari KRS yang disetujui
- ✅ IPS Terakhir: Dari KHS semester terakhir
- ✅ IPK: Indeks Prestasi Kumulatif

### 3. **Profile Card**
- Avatar dengan inisial nama
- 7 informasi personal:
  - NIM
  - Nama
  - Program Studi
  - Jenis Kelamin
  - Email
  - No. Telepon
  - Status

### 4. **Jadwal Hari Ini**
- Filter otomatis berdasarkan hari
- Tampilan waktu mulai-selesai
- Nama mata kuliah
- Nama dosen
- Ruangan
- Status real-time (Berlangsung/Akan Datang/Selesai)
- Empty state jika tidak ada jadwal

### 5. **Quick Actions (4 Buttons)**
- Lihat Jadwal
- Lihat KHS
- Pengisian KRS
- Riwayat Presensi

### 6. **Riwayat KHS Terbaru**
- Menampilkan 3 semester terakhir
- Informasi per KHS:
  - Semester & Tahun Ajaran
  - IPS & IPK
  - Total SKS
  - Predikat (Dengan Pujian/Sangat Memuaskan/dll)
  - Tombol download PDF
- Empty state jika belum ada KHS

## 🎨 Konsistensi dengan Dashboard Dosen

### Similarities:
✅ Layout 2 kolom (Profile Card | Content Section)  
✅ Welcome banner dengan gradient  
✅ Quick stats dengan 4 cards  
✅ Icon styling konsisten  
✅ Color scheme sama (primary green)  
✅ Card styling dengan shadow & border  
✅ Responsive design  
✅ Empty state handling  

### Differences (sesuai kebutuhan):
📊 Dosen: Presensi dosen, Presensi mahasiswa, Nilai input  
👨‍🎓 Mahasiswa: Total SKS, IPS, IPK, Riwayat KHS  

## 🔍 Data Flow

```
Controller
├── Get Mahasiswa data (by user_id)
├── Calculate Statistics
│   ├── Total SKS (from KrsDetail + Krs)
│   ├── IPK (latest from Khs)
│   ├── IPS (latest from Khs)
│   └── Total Jadwal (from JadwalMahasiswa)
├── Get Jadwal Hari Ini
│   ├── Filter by current day
│   ├── Include relations (mataKuliah, dosen, prodi)
│   └── Sort by jam_mulai
└── Get KHS Terbaru (3 last semesters)
    └── Include KhsDetail with mataKuliah

View
├── Display Welcome Banner with real name
├── Show Quick Stats with real numbers
├── Render Profile Card with mahasiswa data
├── Loop Jadwal with real-time status
└── Loop KHS with download links
```

## 🧪 Testing Checklist

- [ ] Login sebagai mahasiswa
- [ ] Cek statistik menampilkan data real
- [ ] Cek profile card menampilkan data lengkap
- [ ] Cek jadwal hari ini (jika ada)
- [ ] Cek empty state jadwal (jika tidak ada)
- [ ] Cek riwayat KHS tampil
- [ ] Test download PDF KHS
- [ ] Cek responsive di mobile
- [ ] Cek semua link quick actions berfungsi

## 🚀 Cara Testing

1. **Login sebagai Mahasiswa**
   ```
   http://localhost/si-raya/login
   ```

2. **Akses Dashboard**
   ```
   http://localhost/si-raya/mahasiswa/dashboard
   ```

3. **Cek Fitur:**
   - Stats cards menampilkan angka real
   - Profile card lengkap
   - Jadwal hari ini (jika ada data)
   - KHS terbaru (jika ada data)
   - Download PDF berfungsi

## 📝 Notes

### Jika Data Kosong:
- **Total SKS = 0**: Mahasiswa belum mengambil KRS atau KRS belum disetujui
- **IPK/IPS = 0.00**: Belum ada data KHS
- **Jadwal Kosong**: Hari ini tidak ada jadwal atau belum ada data jadwal
- **KHS Kosong**: Belum ada riwayat KHS

### Perhitungan:
- **Total SKS**: Sum dari KrsDetail yang Krs-nya statusnya 'disetujui'
- **IPK**: Ambil dari kolom `ipk` di tabel Khs (record terbaru)
- **IPS**: Ambil dari kolom `ips` di tabel Khs (record terbaru)

### Format Tanggal:
- Menggunakan Carbon dengan locale 'id' (Indonesia)
- Format: `dddd, D MMMM Y` (contoh: "Senin, 22 Oktober 2025")

## 🎯 Next Steps (Optional Enhancements)

1. **Grafik Prestasi**
   - Chart IPS per semester
   - Tren IPK

2. **Presensi Mahasiswa**
   - Persentase kehadiran
   - Riwayat presensi per mata kuliah

3. **Notifikasi**
   - Pengumuman kampus
   - Deadline KRS
   - Jadwal ujian

4. **Calendar View**
   - Kalender akademik
   - Jadwal mingguan

## 📞 Support

Jika ada bug atau pertanyaan, silakan hubungi tim development.

---

**Update Terakhir:** 22 Oktober 2025  
**Version:** 2.0 - Dashboard Mahasiswa Fungsional  
**Developer:** SI-RAYA Development Team
