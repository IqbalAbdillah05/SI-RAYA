# DOKUMENTASI IMPORT EXCEL USER

## Fitur Import Excel untuk Mahasiswa dan Dosen

### Cara Penggunaan:

1. **Akses Halaman Create User**
   - Login sebagai Admin
   - Menu: Admin > Manajemen User > Tambah User Baru
   
2. **Download Template Excel**
   - Klik tombol "Download Template" untuk Mahasiswa atau Dosen
   - Template akan otomatis terdownload

3. **Isi Data di Excel**
   - Buka file template yang sudah didownload
   - Isi data sesuai kolom yang tersedia
   - Hapus baris contoh data (baris 2)
   - Baca keterangan di bawah tabel untuk panduan

4. **Upload File Excel**
   - Klik area "Pilih File Excel"
   - Pilih file Excel yang sudah diisi
   - Klik tombol "Upload & Import"
   - Tunggu proses import selesai

### Format Template Mahasiswa:

| Kolom | Wajib | Keterangan |
|-------|-------|------------|
| nama_lengkap | Ya | Nama lengkap mahasiswa |
| nim | Ya | Nomor Induk Mahasiswa (harus unique) |
| nik | Tidak | Nomor Induk Kependudukan (16 digit) |
| email | Ya | Email mahasiswa (harus unique) |
| prodi | Ya | **NAMA PRODI** (bukan ID), contoh: Pendidikan Bahasa Arab |
| semester | Tidak | 1-14, default: 1 |
| jenis_kelamin | Tidak | Laki-laki atau Perempuan |
| tempat_lahir | Tidak | Tempat lahir |
| tanggal_lahir | Tidak | Format: YYYY-MM-DD |
| tanggal_masuk | Tidak | Format: YYYY-MM-DD |
| agama | Tidak | Agama mahasiswa |
| alamat | Tidak | Alamat lengkap |
| no_telp | Tidak | Nomor telepon |
| biaya_masuk | Tidak | Biaya masuk (angka) |
| status_mahasiswa | Tidak | **Aktif** atau **Tidak Aktif** |
| status_sync | Tidak | **Sudah Sync** atau **Belum Sync** |
| password | Tidak | Password login (default: NIM) |

### Format Template Dosen:

| Kolom | Wajib | Keterangan |
|-------|-------|------------|
| nama_lengkap | Ya | Nama lengkap dosen |
| nidn | Ya | Nomor Induk Dosen Nasional (harus unique) |
| email | Ya | Email dosen (harus unique) |
| prodi | Tidak | **BEBAS**, tidak harus sesuai database (contoh: Bahasa Arab, Matematika) |
| jenis_kelamin | Tidak | Laki-laki atau Perempuan |
| tempat_lahir | Tidak | Tempat lahir |
| tanggal_lahir | Tidak | Format: YYYY-MM-DD |
| agama | Tidak | Agama dosen |
| alamat | Tidak | Alamat lengkap |
| no_telp | Tidak | Nomor telepon |
| password | Tidak | Password login (default: NIDN) |

### Catatan Penting:

1. **Format Tanggal**: Gunakan format YYYY-MM-DD (contoh: 2005-01-01)
2. **NIK Mahasiswa**: Harus 16 digit jika diisi (contoh: 3509040801060001)
3. **Prodi**: 
   - **Mahasiswa**: Gunakan **NAMA PRODI LENGKAP** yang sesuai dengan database
     - Contoh: "Pendidikan Bahasa Arab", "Pendidikan Bahasa Inggris"
     - Tidak case sensitive (bisa huruf besar/kecil)
     - Sistem akan otomatis mencari ID prodi
   - **Dosen**: **BEBAS**, tidak harus sesuai database. Bisa tulis apa saja (contoh: Bahasa Arab, Matematika, dsb)
4. **Semester**: Batasan 1-14 (untuk mahasiswa yang mungkin semester panjang)
5. **Status Mahasiswa**: Hanya **Aktif** atau **Tidak Aktif**
6. **Status Sync**: Hanya **Sudah Sync** atau **Belum Sync**
7. **Password Default**: 
   - Mahasiswa: Default password = NIM
   - Dosen: Default password = NIDN
8. **Email**: Harus unik, tidak boleh sama dengan user lain
9. **NIM/NIDN**: Harus unik, tidak boleh sama dengan user lain

### Error Handling:

Sistem akan menampilkan pesan error jika:
- Format file tidak sesuai (.xlsx, .xls, .csv)
- Ada data yang tidak valid (email/nim/nidn duplikat)
- Kolom wajib tidak diisi
- Format tanggal salah
- Prodi ID tidak ditemukan

### Contoh Data di Excel:

**Mahasiswa:**
```
nama_lengkap: Ahmad Fauzi
nim: 24114001001
nik: 3509040801060001
email: ahmad.fauzi@example.com
prodi: Pendidikan Bahasa Arab
semester: 1
jenis_kelamin: Laki-laki
status_mahasiswa: Aktif
status_sync: Belum Sync
...
```

**Dosen:**
```
nama_lengkap: Dr. Budi Santoso, M.Pd
nidn: 0123456789
email: budi.santoso@example.com
prodi: Bahasa Arab (atau apa saja, bebas)
jenis_kelamin: Laki-laki
...
```

### File Template Lokasi:
- Template Mahasiswa: `public/templates/template_mahasiswa.xlsx`
- Template Dosen: `public/templates/template_dosen.xlsx`

### Package yang Digunakan:
- maatwebsite/excel v3.1
- phpoffice/phpspreadsheet v1.30

---

**Update**: Fitur import Excel sudah berhasil diimplementasikan!
**Tanggal**: 23 Oktober 2025
