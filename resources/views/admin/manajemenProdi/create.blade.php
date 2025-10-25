@extends('layouts.admin')

@section('title', 'Tambah Program Studi')

@section('content')
<div class="prodi-form">
    <!-- Header -->
    <div class="page-header">
        <h1>Tambah Program Studi</h1>
        <a href="{{ route('admin.manajemen-prodi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Terdapat kesalahan:</strong>
        <ul style="margin: 5px 0 0 20px; padding: 0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.manajemen-prodi.store') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="kode_prodi" class="form-label">
                        <i class="fas fa-code"></i> Kode Prodi <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('kode_prodi') is-invalid @enderror" 
                           id="kode_prodi" 
                           name="kode_prodi" 
                           value="{{ old('kode_prodi') }}"
                           placeholder="Contoh: 12345, PBA"
                           maxlength="10"
                           required>
                    @error('kode_prodi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_prodi" class="form-label">
                        <i class="fas fa-graduation-cap"></i> Nama Prodi <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="form-control @error('nama_prodi') is-invalid @enderror" 
                           id="nama_prodi" 
                           name="nama_prodi" 
                           value="{{ old('nama_prodi') }}"
                           placeholder="Contoh: Pendidikan Bahasa Arab"
                           maxlength="100"
                           required>
                    @error('nama_prodi')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="jenjang" class="form-label">
                    <i class="fas fa-layer-group"></i> Jenjang <span class="required">*</span>
                </label>
                <select name="jenjang" 
                        id="jenjang" 
                        class="form-control @error('jenjang') is-invalid @enderror" 
                        required>
                    <option value="">-- Pilih Jenjang --</option>
                    @foreach($jenjangOptions as $key => $value)
                        <option value="{{ $key }}" {{ old('jenjang') == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @error('jenjang')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ketua_prodi" class="form-label">
                    <i class="fas fa-user-tie"></i> Ketua Prodi
                </label>
                <input type="text" 
                       class="form-control @error('ketua_prodi') is-invalid @enderror" 
                       id="ketua_prodi" 
                       name="ketua_prodi" 
                       value="{{ old('ketua_prodi') }}"
                       placeholder="Contoh: Dr. Ahmad Fauzi, M.Pd"
                       maxlength="100">
                @error('ketua_prodi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nidn_ketua_prodi" class="form-label">
                    <i class="fas fa-id-card"></i> NIDN Ketua Prodi
                </label>
                <input type="text" 
                       class="form-control @error('nidn_ketua_prodi') is-invalid @enderror" 
                       id="nidn_ketua_prodi" 
                       name="nidn_ketua_prodi" 
                       value="{{ old('nidn_ketua_prodi') }}"
                       placeholder="Contoh: 1234567890"
                       maxlength="20">
                @error('nidn_ketua_prodi')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.manajemen-prodi.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    .prodi-form {
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

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn:hover {
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

    .alert ul {
        margin: 5px 0 0 20px;
        padding: 0;
    }

    .alert li {
        margin: 3px 0;
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

    /* Form Card */
    .form-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 30px;
        max-width: 900px;
    }

    /* Form Row */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }

    .form-label i {
        color: #666;
        margin-right: 3px;
        width: 16px;
        display: inline-block;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .error-message {
        display: block;
        margin-top: 5px;
        font-size: 13px;
        color: #dc3545;
    }

    select.form-control {
        cursor: pointer;
        background: white;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 30px;
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

        .form-card {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush
@endsection