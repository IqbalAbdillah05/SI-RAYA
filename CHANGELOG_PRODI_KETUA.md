# Update Prodi - Tambah Kolom Ketua Prodi

## Overview
Penambahan kolom `ketua_prodi` pada tabel prodi untuk menyimpan informasi ketua program studi.

## Perubahan yang Dilakukan

### 1. Database Migration ✅
**File:** `database/migrations/2025_10_22_095345_add_ketua_prodi_to_prodi_table.php`

```php
Schema::table('prodi', function (Blueprint $table) {
    $table->string('ketua_prodi', 100)->nullable()->after('jenjang');
});
```

**Migrasi dijalankan:** ✅
```bash
php artisan migrate
```

### 2. Model Prodi ✅
**File:** `app/Models/Prodi.php`

**Penambahan:**
- `ketua_prodi` ditambahkan ke `$fillable` array

```php
protected $fillable = [
    'kode_prodi',
    'nama_prodi',
    'jenjang',
    'ketua_prodi'  // ← Baru
];
```

### 3. Controller ✅
**File:** `app/Http/Controllers/Admin/ManajemenProdiController.php`

**Method store():**
```php
'ketua_prodi' => 'nullable|string|max:100',
```

**Method update():**
```php
'ketua_prodi' => 'nullable|string|max:100',
```

### 4. Views ✅

#### a. Index (Tabel List)
**File:** `resources/views/admin/manajemenProdi/index.blade.php`
- Menambahkan kolom "Ketua Prodi" di tabel
- Update colspan empty state dari 5 ke 6
- Menampilkan: `{{ $prodi->ketua_prodi ?? '-' }}`

#### b. Create Form
**File:** `resources/views/admin/manajemenProdi/create.blade.php`
- Menambahkan input field untuk ketua prodi
- Icon: `fa-user-tie`
- Placeholder: "Contoh: Dr. Ahmad Fauzi, M.Pd"
- Helper text: "Opsional - Nama lengkap Ketua Program Studi"

#### c. Edit Form
**File:** `resources/views/admin/manajemenProdi/edit.blade.php`
- Menambahkan input field untuk ketua prodi (sama seperti create)
- Pre-filled dengan data existing: `{{ old('ketua_prodi', $prodi->ketua_prodi) }}`

#### d. Show/Detail Page
**File:** `resources/views/admin/manajemenProdi/show.blade.php`
- Menambahkan baris detail untuk ketua prodi
- Icon: `fa-user-tie`
- Menampilkan: `{{ $prodi->ketua_prodi ?? '-' }}`

## Struktur Database

### Tabel: prodi
| Kolom | Tipe | Length | Nullable | Keterangan |
|-------|------|--------|----------|------------|
| id | bigint | - | No | Primary Key |
| kode_prodi | varchar | 10 | No | Unique |
| nama_prodi | varchar | 100 | No | - |
| jenjang | enum | - | No | D3, D4, S1, S2, S3 |
| **ketua_prodi** | **varchar** | **100** | **Yes** | **Nama Ketua Prodi (BARU)** |
| created_at | timestamp | - | Yes | - |
| updated_at | timestamp | - | Yes | - |

## Validasi

### Create & Update:
- **Type:** String
- **Max Length:** 100 karakter
- **Required:** No (nullable/opsional)
- **Format:** Nama lengkap ketua prodi

## Status
✅ **SELESAI - SIAP DIGUNAKAN**

## Testing Checklist
- [x] Migration berhasil dijalankan
- [x] Model updated
- [x] Controller validation added
- [x] View Index: kolom baru ditampilkan
- [x] View Create: input field ditambahkan
- [x] View Edit: input field ditambahkan
- [x] View Show: detail ditampilkan
- [ ] Test manual: Create prodi dengan ketua prodi
- [ ] Test manual: Update prodi dengan ketua prodi
- [ ] Test manual: Verifikasi tampilan di index

## Notes
- Field ketua_prodi bersifat opsional (nullable)
- Jika tidak diisi, akan menampilkan tanda "-" di UI
- Icon yang digunakan: `fas fa-user-tie` (Font Awesome)
