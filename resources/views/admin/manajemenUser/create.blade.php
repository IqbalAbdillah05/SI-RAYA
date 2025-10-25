@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@section('content')
<div class="user-create">
    <!-- Header -->
    <div class="page-header">
        <h1>Tambah User Baru</h1>
        <a href="{{ route('admin.manajemen-user.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Error Validasi:</strong>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif


    @if(session('warning'))
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        {{ session('warning') }}
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    @if(session('import_errors'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Detail Error Import:</strong>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach(session('import_errors') as $index => $error)
                <li><strong>Baris {{ $index + 2 }}:</strong> {{ $error['error'] ?? 'Error tidak diketahui' }}</li>
            @endforeach
        </ul>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    @if(session('validation_errors'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Error Validasi Import:</strong>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            @foreach(session('validation_errors') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    <!-- Import Excel Section -->
    <div class="import-section">
        <h2><i class="fas fa-file-excel"></i> Import Data dari Excel</h2>
        <p class="import-description">Upload file Excel untuk menambahkan banyak user sekaligus</p>
        
        <div class="import-cards">
            <!-- Import Mahasiswa -->
            <div class="import-card">
                <div class="import-card-header">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Import Mahasiswa</h3>
                </div>
                <div class="import-card-body">
                    <p>Upload file Excel berisi data mahasiswa</p>
                    <form action="{{ route('admin.manajemen-user.importMahasiswa') }}" method="POST" enctype="multipart/form-data" class="import-form">
                        @csrf
                        <div class="file-input-wrapper">
                            <input type="file" name="file" id="fileMahasiswa" accept=".xlsx,.xls,.csv" required class="file-input">
                            <label for="fileMahasiswa" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Pilih File Excel</span>
                            </label>
                        </div>
                        <div class="import-actions">
                            <a href="{{ route('admin.manajemen-user.templateMahasiswa') }}" class="btn btn-outline" target="_blank">
                                <i class="fas fa-download"></i> Download Template
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload"></i> Upload & Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Import Dosen -->
            <div class="import-card">
                <div class="import-card-header">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h3>Import Dosen</h3>
                </div>
                <div class="import-card-body">
                    <p>Upload file Excel berisi data dosen</p>
                    <form action="{{ route('admin.manajemen-user.importDosen') }}" method="POST" enctype="multipart/form-data" class="import-form">
                        @csrf
                        <div class="file-input-wrapper">
                            <input type="file" name="file" id="fileDosen" accept=".xlsx,.xls,.csv" required class="file-input">
                            <label for="fileDosen" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Pilih File Excel</span>
                            </label>
                        </div>
                        <div class="import-actions">
                            <a href="{{ route('admin.manajemen-user.templateDosen') }}" class="btn btn-outline" target="_blank">
                                <i class="fas fa-download"></i> Download Template
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload"></i> Upload & Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="divider">
        <span>ATAU</span>
    </div>

    <h2 style="margin-bottom: 20px; text-align: center;">Tambah User Manual</h2>

    <!-- Form Container -->
    <div class="form-container">
        <form action="{{ route('admin.manajemen-user.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
            @csrf

            <!-- Role Selection -->
            <div class="form-section">
                <h3>Pilih Role User</h3>
                <div class="role-selection">
                    <label class="role-card">
                        <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }} required>
                        <div class="role-card-content">
                            <i class="fas fa-user-shield"></i>
                            <span>Admin</span>
                        </div>
                    </label>
                    <label class="role-card">
                        <input type="radio" name="role" value="dosen" {{ old('role') == 'dosen' ? 'checked' : '' }} required>
                        <div class="role-card-content">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Dosen</span>
                        </div>
                    </label>
                    <label class="role-card">
                        <input type="radio" name="role" value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'checked' : '' }} required>
                        <div class="role-card-content">
                            <i class="fas fa-user-graduate"></i>
                            <span>Mahasiswa</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Admin Form -->
            <div class="form-section" id="adminForm" style="display: none;">
                <h3>Data Admin</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                    </div>
                </div>
            </div>

            <!-- Dosen Form -->
            <div class="form-section" id="dosenForm" style="display: none;">
                <h3>Data Dosen</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama_lengkap_dosen" class="form-control" value="{{ old('nama_lengkap_dosen') }}" placeholder="Masukkan Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label>NIDN <span class="required">*</span></label>
                        <input type="text" name="nidn" class="form-control" value="{{ old('nidn') }}" placeholder="Masukkan NIDN">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" name="program_studi" class="form-control" value="{{ old('program_studi') }}" placeholder="Masukkan Program Studi">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" placeholder="Masukkan Tempat Lahir">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <select name="agama" class="form-control">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp') }}" placeholder="Masukkan Nomor Telepon">
                    </div>
                    <div class="form-group full-width">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan Alamat Lengkap">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="form-group full-width">
                        <label>Pas Foto</label>
                        <input type="file" name="pas_foto" class="form-control" accept="image/*">
                        <small class="form-text">Format: JPG, PNG. Maksimal 2MB</small>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                    </div>
                </div>
            </div>

            <!-- Mahasiswa Form -->
            <div class="form-section" id="mahasiswaForm" style="display: none;">
                <h3>Data Mahasiswa</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="required">*</span></label>
                        <input type="text" name="nama_lengkap_mhs" class="form-control" value="{{ old('nama_lengkap_mhs') }}" placeholder="Masukkan Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label>NIM <span class="required">*</span></label>
                        <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" placeholder="Masukkan NIM">
                    </div>
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" placeholder="Masukkan NIK">
                    </div>
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan Email">
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi_id" class="form-control">
                            <option value="">Pilih Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" 
                                    {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" class="form-control">
                            <option value="">Pilih Semester</option>
                            @for($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin_mhs" class="form-control">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin_mhs') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin_mhs') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir_mhs" class="form-control" value="{{ old('tempat_lahir_mhs') }}" placeholder="Masukkan Tempat Lahir">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir_mhs" class="form-control" value="{{ old('tanggal_lahir_mhs') }}">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk') }}">
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <select name="agama_mhs" class="form-control">
                            <option value="">Pilih Agama</option>
                            <option value="Islam" {{ old('agama_mhs') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama_mhs') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama_mhs') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama_mhs') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama_mhs') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama_mhs') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="no_telp_mhs" class="form-control" value="{{ old('no_telp_mhs') }}" placeholder="Masukkan Nomor Telepon">
                    </div>
                    <div class="form-group full-width">
                        <label>Alamat</label>
                        <textarea name="alamat_mhs" class="form-control" rows="3" placeholder="Masukkan Alamat Lengkap">{{ old('alamat_mhs') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Biaya Masuk</label>
                        <input type="number" name="biaya_masuk" class="form-control" value="{{ old('biaya_masuk') }}" placeholder="Masukkan Biaya Masuk">
                    </div>
                    <div class="form-group">
                        <label>Status Mahasiswa</label>
                        <select name="status_mahasiswa" class="form-control">
                            <option value="">Pilih Status</option>
                            <option value="Aktif" {{ old('status_mahasiswa') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status_mahasiswa') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Sync</label>
                        <select name="status_sync" class="form-control">
                            <option value="Belum Sync" {{ old('status_sync') == 'Belum Sync' ? 'selected' : '' }}>Belum Sync</option>
                            <option value="Sudah Sync" {{ old('status_sync') == 'Sudah Sync' ? 'selected' : '' }}>Sudah Sync</option>
                        </select>
                    </div>
                    <div class="form-group full-width">
                        <label>Pas Foto</label>
                        <input type="file" name="pas_foto" class="form-control" accept="image/*">
                        <small class="form-text">Format: JPG, PNG. Maksimal 2MB</small>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="required">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="required">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password">
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
                <a href="{{ route('admin.manajemen-user.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    .user-create {
        padding: 20px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: normal;
        margin: 0;
        color: #333;
    }

    /* Import Section */
    .import-section {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 30px;
    }

    .import-section h2 {
        margin: 0 0 10px 0;
        font-size: 22px;
        color: #333;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .import-section h2 i {
        color: #28a745;
    }

    .import-description {
        color: #666;
        margin-bottom: 25px;
    }

    .import-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
    }

    .import-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
    }

    .import-card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .import-card-header i {
        font-size: 24px;
    }

    .import-card-header h3 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .import-card-body {
        padding: 20px;
    }

    .import-card-body p {
        color: #666;
        margin-bottom: 15px;
    }

    .file-input-wrapper {
        margin-bottom: 15px;
    }

    .file-input {
        display: none;
    }

    .file-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 30px;
        border: 2px dashed #ccc;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        background: #f8f9fa;
    }

    .file-label:hover {
        border-color: #007bff;
        background: #e7f1ff;
    }

    .file-label i {
        font-size: 48px;
        color: #007bff;
        margin-bottom: 10px;
    }

    .file-label span {
        color: #666;
        font-size: 14px;
    }

    .file-input:focus + .file-label {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .import-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-outline {
        background: white;
        border: 1px solid #007bff;
        color: #007bff;
    }

    .btn-outline:hover {
        background: #007bff;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .divider {
        position: relative;
        text-align: center;
        margin: 40px 0;
    }

    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
        height: 1px;
        background: #ddd;
        z-index: 0;
    }

    .divider span {
        position: relative;
        background: white;
        padding: 0 20px;
        color: #999;
        font-weight: 600;
        z-index: 1;
    }

    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-warning {
        background: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
    }

    /* Button */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 15px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        opacity: 0.9;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        opacity: 0.9;
    }

    /* Alert */
    .alert {
        padding: 12px 15px;
        margin-bottom: 15px;
        border-radius: 3px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        position: relative;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .close-alert {
        position: absolute;
        right: 10px;
        top: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: inherit;
        opacity: 0.5;
    }

    .close-alert:hover {
        opacity: 1;
    }

    /* Form Container */
    .form-container {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 20px;
    }

    .form-section {
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 15px 0;
        color: #333;
    }

    /* Role Selection */
    .role-selection {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .role-card {
        cursor: pointer;
    }

    .role-card input[type="radio"] {
        display: none;
    }

    .role-card-content {
        border: 2px solid #ddd;
        border-radius: 3px;
        padding: 20px;
        text-align: center;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .role-card input[type="radio"]:checked + .role-card-content {
        border-color: #007bff;
        background: #e7f3ff;
    }

    .role-card-content:hover {
        border-color: #007bff;
    }

    .role-card-content i {
        font-size: 2rem;
        color: #007bff;
    }

    .role-card-content span {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
    }

    .form-control:disabled {
        background-color: #f5f5f5;
        cursor: not-allowed;
        opacity: 0.6;
    }

    textarea.form-control {
        resize: vertical;
    }

    .form-text {
        color: #6c757d;
        font-size: 12px;
        margin-top: 3px;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .role-selection {
            grid-template-columns: 1fr;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // File input handler
        const fileMahasiswaInput = document.getElementById('fileMahasiswa');
        const fileDosenInput = document.getElementById('fileDosen');

        if (fileMahasiswaInput) {
            fileMahasiswaInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Pilih File Excel';
                const label = e.target.nextElementSibling;
                if (label) {
                    label.querySelector('span').textContent = fileName;
                    if (e.target.files[0]) {
                        label.style.borderColor = '#28a745';
                        label.style.background = '#d4edda';
                    }
                }
            });
        }

        if (fileDosenInput) {
            fileDosenInput.addEventListener('change', function(e) {
                const fileName = e.target.files[0]?.name || 'Pilih File Excel';
                const label = e.target.nextElementSibling;
                if (label) {
                    label.querySelector('span').textContent = fileName;
                    if (e.target.files[0]) {
                        label.style.borderColor = '#28a745';
                        label.style.background = '#d4edda';
                    }
                }
            });
        }

        // Role selection handler
        const roleInputs = document.querySelectorAll('input[name="role"]');
        const adminForm = document.getElementById('adminForm');
        const dosenForm = document.getElementById('dosenForm');
        const mahasiswaForm = document.getElementById('mahasiswaForm');

        function disableOtherForms(selectedRole) {
            if (selectedRole !== 'admin') {
                adminForm.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = true;
                    input.removeAttribute('required');
                });
            } else {
                adminForm.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = false;
                });
            }
            
            if (selectedRole !== 'dosen') {
                dosenForm.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = true;
                    input.removeAttribute('required');
                });
            } else {
                dosenForm.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = false;
                });
            }
            
            if (selectedRole !== 'mahasiswa') {
                mahasiswaForm.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = true;
                    input.removeAttribute('required');
                });
            } else {
                mahasiswaForm.querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = false;
                });
            }
        }

        function showFormByRole(role) {
            adminForm.style.display = 'none';
            dosenForm.style.display = 'none';
            mahasiswaForm.style.display = 'none';

            disableOtherForms(role);

            if (role === 'admin') {
                adminForm.style.display = 'block';
            } else if (role === 'dosen') {
                dosenForm.style.display = 'block';
            } else if (role === 'mahasiswa') {
                mahasiswaForm.style.display = 'block';
            }
        }

        roleInputs.forEach(input => {
            input.addEventListener('change', function() {
                showFormByRole(this.value);
            });
        });

        const checkedRole = document.querySelector('input[name="role"]:checked');
        if (checkedRole) {
            showFormByRole(checkedRole.value);
        }

        // Validasi khusus untuk input file FOTO (pas_foto) - bukan file Excel
        const imageInputs = document.querySelectorAll('input[type="file"][name="pas_foto"]');
        imageInputs.forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    if (file.size > 2048000) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB');
                        this.value = '';
                        return;
                    }

                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        alert('Format file tidak valid! Gunakan JPG atau PNG');
                        this.value = '';
                        return;
                    }
                }
            });
        });

        // Validasi khusus untuk file Excel import
        const excelInputs = document.querySelectorAll('#fileMahasiswa, #fileDosen');
        excelInputs.forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validasi ukuran max 5MB untuk Excel
                    if (file.size > 5242880) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB');
                        this.value = '';
                        return;
                    }

                    // Validasi tipe file Excel
                    const validTypes = [
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
                        'application/vnd.ms-excel', // .xls
                        'text/csv' // .csv
                    ];
                    
                    if (!validTypes.includes(file.type) && 
                        !file.name.endsWith('.xlsx') && 
                        !file.name.endsWith('.xls') && 
                        !file.name.endsWith('.csv')) {
                        alert('Format file tidak valid! Gunakan file Excel (.xlsx, .xls, .csv)');
                        this.value = '';
                        return;
                    }
                }
            });
        });

        const form = document.getElementById('userForm');
        form.addEventListener('submit', function(e) {
            const role = document.querySelector('input[name="role"]:checked');
            
            if (!role) {
                e.preventDefault();
                alert('Silakan pilih role terlebih dahulu!');
                return false;
            }
        });
    });
</script>
@endpush
@endsection