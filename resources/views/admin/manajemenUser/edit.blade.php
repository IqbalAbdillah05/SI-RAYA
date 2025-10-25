@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="edit-container">
    <!-- Header -->
    <div class="edit-header">
        <div class="header-left">
            <h1>Edit User</h1>
            <p class="subtitle">Perbarui informasi data user</p>
        </div>
        <a href="{{ route('admin.manajemen-user.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Terdapat kesalahan validasi:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button class="close-btn" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <!-- Role Badge -->
        <div class="role-indicator">
            <span class="role-badge role-{{ $user->role }}">
                {{ ucfirst($user->role) }}
            </span>
        </div>

        <form action="{{ route('admin.manajemen-user.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ===================== ADMIN ===================== --}}
            @if($user->role == 'admin')
                <div class="form-section">
                    <h3>Data Admin</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                            @error('name')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                            @error('email')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-input" placeholder="Biarkan kosong jika tidak ingin mengubah">
                            <small>Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
                        </div>
                    </div>
                </div>

            {{-- ===================== DOSEN ===================== --}}
            @elseif($user->role == 'dosen')
                @php
                    $dosen = $user->dosen;
                @endphp

                @if($dosen && $dosen->pas_foto)
                    <div class="current-photo-section">
                        <label>Foto Profil Saat Ini</label>
                        <img src="{{ asset('storage/' . $dosen->pas_foto) }}" alt="Foto Dosen">
                    </div>
                @endif

                <div class="form-section">
                    <h3>Informasi Identitas</h3>
                    
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="nama_lengkap_dosen" class="form-input" value="{{ old('nama_lengkap_dosen', $user->name) }}" required>
                            @error('nama_lengkap_dosen')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>NIDN <span class="required">*</span></label>
                            <input type="text" name="nidn" class="form-input" value="{{ old('nidn', $user->nidn) }}" required>
                            @error('nidn')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                            @error('email')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Program Studi</label>
                            <input type="text" name="program_studi" class="form-input" value="{{ old('program_studi', $dosen->program_studi ?? '') }}">
                            @error('program_studi')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>No. Telepon</label>
                            <input type="text" name="no_telp" class="form-input" value="{{ old('no_telp', $dosen->no_telp ?? '') }}" placeholder="08xxxxxxxxxx">
                            @error('no_telp')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Data Pribadi</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $dosen->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $dosen->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Agama</label>
                            <select name="agama" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="Islam" {{ old('agama', $dosen->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama', $dosen->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama', $dosen->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama', $dosen->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama', $dosen->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama', $dosen->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-input" value="{{ old('tempat_lahir', $dosen->tempat_lahir ?? '') }}">
                            @error('tempat_lahir')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir', $dosen->tanggal_lahir ?? '') }}">
                            @error('tanggal_lahir')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-input" rows="3">{{ old('alamat', $dosen->alamat ?? '') }}</textarea>
                            @error('alamat')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Foto & Keamanan</h3>
                    
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Upload Pas Foto Baru</label>
                            <input type="file" name="pas_foto" class="form-input" accept="image/*">
                            <small>JPG, PNG. Maks 2MB. Kosongkan jika tidak ingin mengubah</small>
                            @error('pas_foto')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-input" placeholder="Biarkan kosong jika tidak ingin mengubah">
                            <small>Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
                        </div>
                    </div>
                </div>

            {{-- ===================== MAHASISWA ===================== --}}
            @else
                @php
                    $mhs = $user->mahasiswaProfile;
                @endphp

                @if($mhs && $mhs->pas_foto)
                    <div class="current-photo-section">
                        <label>Foto Profil Saat Ini</label>
                        <img src="{{ asset('storage/' . $mhs->pas_foto) }}" alt="Foto Mahasiswa">
                    </div>
                @endif

                <div class="form-section">
                    <h3>Informasi Identitas</h3>
                    
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Nama Lengkap <span class="required">*</span></label>
                            <input type="text" name="nama_lengkap_mhs" class="form-input" value="{{ old('nama_lengkap_mhs', $user->name) }}" required>
                            @error('nama_lengkap_mhs')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>NIM <span class="required">*</span></label>
                            <input type="text" name="nim" class="form-input" value="{{ old('nim', $user->nim) }}" required>
                            @error('nim')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" name="nik" class="form-input" value="{{ old('nik', $mhs->nik ?? '') }}" maxlength="16">
                            @error('nik')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                            @error('email')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>No. Telepon</label>
                            <input type="text" name="no_telp_mhs" class="form-input" value="{{ old('no_telp_mhs', $mhs->no_telp ?? '') }}" placeholder="08xxxxxxxxxx">
                            @error('no_telp_mhs')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Informasi Akademik</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Program Studi</label>
                            <select name="prodi_id" class="form-input">
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->id }}" {{ old('prodi_id', $mhs->prodi_id ?? '') == $prodi->id ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prodi_id')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Semester</label>
                            <input type="number" name="semester" class="form-input" min="1" max="14" value="{{ old('semester', $mhs->semester ?? '') }}">
                            @error('semester')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-input" value="{{ old('tanggal_masuk', $mhs->tanggal_masuk ?? '') }}">
                            @error('tanggal_masuk')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Status Mahasiswa</label>
                            <select name="status_mahasiswa" class="form-input">
                                <option value="Aktif" {{ old('status_mahasiswa', $mhs->status_mahasiswa ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Tidak Aktif" {{ old('status_mahasiswa', $mhs->status_mahasiswa ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status_mahasiswa')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Data Pribadi</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin_mhs" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin_mhs', $mhs->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin_mhs', $mhs->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin_mhs')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Agama</label>
                            <select name="agama_mhs" class="form-input">
                                <option value="">-- Pilih --</option>
                                <option value="Islam" {{ old('agama_mhs', $mhs->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama_mhs', $mhs->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama_mhs', $mhs->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama_mhs', $mhs->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama_mhs', $mhs->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama_mhs', $mhs->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama_mhs')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir_mhs" class="form-input" value="{{ old('tempat_lahir_mhs', $mhs->tempat_lahir ?? '') }}">
                            @error('tempat_lahir_mhs')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir_mhs" class="form-input" value="{{ old('tanggal_lahir_mhs', $mhs->tanggal_lahir ?? '') }}">
                            @error('tanggal_lahir_mhs')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Alamat</label>
                            <textarea name="alamat_mhs" class="form-input" rows="3">{{ old('alamat_mhs', $mhs->alamat ?? '') }}</textarea>
                            @error('alamat_mhs')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Informasi Keuangan</h3>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Biaya Masuk (Rp)</label>
                            <input type="number" name="biaya_masuk" class="form-input" min="0" value="{{ old('biaya_masuk', $mhs->biaya_masuk ?? '') }}">
                            @error('biaya_masuk')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Status Sync</label>
                            <select name="status_sync" class="form-input">
                                <option value="Sudah Sync" {{ old('status_sync', $mhs->status_sync ?? '') == 'Sudah Sync' ? 'selected' : '' }}>Sudah Sync</option>
                                <option value="Belum Sync" {{ old('status_sync', $mhs->status_sync ?? 'Belum Sync') == 'Belum Sync' ? 'selected' : '' }}>Belum Sync</option>
                            </select>
                            @error('status_sync')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Foto & Keamanan</h3>
                    
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Upload Pas Foto Baru</label>
                            <input type="file" name="pas_foto" class="form-input" accept="image/*">
                            <small>JPG, PNG. Maks 2MB. Kosongkan jika tidak ingin mengubah</small>
                            @error('pas_foto')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-input" placeholder="Biarkan kosong jika tidak ingin mengubah">
                            <small>Kosongkan jika tidak ingin mengubah password</small>
                            @error('password')<span class="error-text">{{ $message }}</span>@enderror
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="Konfirmasi password baru">
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-check"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.manajemen-user.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .edit-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }

    /* Header */
    .edit-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .header-left h1 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-back {
        background: #6b7280;
        color: white;
    }

    .btn-back:hover {
        background: #4b5563;
    }

    .btn-save {
        background: #10b981;
        color: white;
    }

    .btn-save:hover {
        background: #059669;
    }

    .btn-cancel {
        background: #6b7280;
        color: white;
    }

    .btn-cancel:hover {
        background: #4b5563;
    }

    /* Alert */
    .alert {
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 6px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        position: relative;
        border-left: 3px solid;
    }

    .alert-danger {
        background: #fef2f2;
        border-color: #ef4444;
        color: #991b1b;
    }

    .alert i {
        font-size: 18px;
        margin-top: 1px;
    }

    .alert ul {
        margin: 6px 0 0 0;
        padding-left: 18px;
    }

    .alert li {
        margin: 3px 0;
    }

    .close-btn {
        position: absolute;
        right: 12px;
        top: 12px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: inherit;
        opacity: 0.6;
        line-height: 1;
    }

    .close-btn:hover {
        opacity: 1;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    /* Role Indicator */
    .role-indicator {
        background: #f9fafb;
        padding: 16px;
        text-align: center;
        border-bottom: 1px solid #e5e7eb;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        border-radius: 16px;
        font-size: 13px;
        font-weight: 500;
    }

    .role-admin {
        background: #fee2e2;
        color: #991b1b;
    }

    .role-dosen {
        background: #dcfce7;
        color: #166534;
    }

    .role-mahasiswa {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Current Photo */
    .current-photo-section {
        padding: 20px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
    }

    .current-photo-section label {
        display: block;
        font-weight: 500;
        margin-bottom: 12px;
        color: #1f2937;
        font-size: 14px;
    }

    .current-photo-section img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e5e7eb;
    }

    /* Form Sections */
    .form-section {
        padding: 24px;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        margin: 0 0 20px 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }

    /* Form Row & Group */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .required {
        color: #ef4444;
    }

    .form-input {
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s;
        color: #1f2937;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    textarea.form-input {
        resize: vertical;
        min-height: 70px;
    }

    .form-group small {
        color: #6b7280;
        font-size: 12px;
    }

    .error-text {
        color: #ef4444;
        font-size: 12px;
        font-weight: 500;
    }

    /* Form Actions */
    .form-actions {
        padding: 20px 24px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .edit-container {
            padding: 16px;
        }

        .edit-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .form-section {
            padding: 20px 16px;
        }

        .form-actions {
            flex-direction: column-reverse;
            padding: 16px;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush
@endsection