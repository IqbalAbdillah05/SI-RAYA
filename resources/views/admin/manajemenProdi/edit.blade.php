@extends('layouts.admin')

@section('title', 'Edit Program Studi')

@section('content')
<div class="prodi-form">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Program Studi</h1>
            <p class="subtitle">Perbarui informasi program studi</p>
        </div>
        <a href="{{ route('admin.manajemen-prodi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
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
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.manajemen-prodi.update', $prodi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3>Informasi Program Studi</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_prodi" class="form-label">
                            Kode Prodi <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('kode_prodi') is-invalid @enderror" 
                               id="kode_prodi" 
                               name="kode_prodi" 
                               value="{{ old('kode_prodi', $prodi->kode_prodi) }}"
                               placeholder="Contoh: TI, SI, MI"
                               maxlength="10"
                               required>
                        @error('kode_prodi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_prodi" class="form-label">
                            Nama Prodi <span class="required">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nama_prodi') is-invalid @enderror" 
                               id="nama_prodi" 
                               name="nama_prodi" 
                               value="{{ old('nama_prodi', $prodi->nama_prodi) }}"
                               placeholder="Contoh: Teknik Informatika"
                               maxlength="100"
                               required>
                        @error('nama_prodi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="jenjang" class="form-label">
                        Jenjang <span class="required">*</span>
                    </label>
                    <select name="jenjang" 
                            id="jenjang" 
                            class="form-control @error('jenjang') is-invalid @enderror" 
                            required>
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach($jenjangOptions as $key => $value)
                            <option value="{{ $key }}" {{ old('jenjang', $prodi->jenjang) == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenjang')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ketua_prodi" class="form-label">
                        Ketua Prodi
                    </label>
                    <input type="text" 
                           class="form-control @error('ketua_prodi') is-invalid @enderror" 
                           id="ketua_prodi" 
                           name="ketua_prodi" 
                           value="{{ old('ketua_prodi', $prodi->ketua_prodi) }}"
                           placeholder="Contoh: Dr. Ahmad Fauzi, M.Pd"
                           maxlength="100">
                    @error('ketua_prodi')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nidn_ketua_prodi" class="form-label">
                        NIDN Ketua Prodi
                    </label>
                    <input type="text" 
                           class="form-control @error('nidn_ketua_prodi') is-invalid @enderror" 
                           id="nidn_ketua_prodi" 
                           name="nidn_ketua_prodi" 
                           value="{{ old('nidn_ketua_prodi', $prodi->nidn_ketua_prodi) }}"
                           placeholder="Contoh: 1234567890"
                           maxlength="20">
                    @error('nidn_ketua_prodi')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.manajemen-prodi.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .prodi-form {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }

    /* Header */
    .page-header {
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

    /* Button */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
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

    .close-alert {
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

    .close-alert:hover {
        opacity: 1;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .form-section {
        padding: 24px;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }

    /* Form Row */
    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }

    /* Form Group */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .required {
        color: #ef4444;
    }

    .form-control {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s;
        color: #1f2937;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        font-weight: 500;
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
        padding: 20px 24px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .prodi-form {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .form-section {
            padding: 20px 16px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
            padding: 16px;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush
@endsection