@extends('layouts.admin')

@section('title', 'Edit Mata Kuliah')

@section('content')
<div class="mata-kuliah-edit">
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Mata Kuliah</h1>
            <p class="subtitle">Perbarui informasi mata kuliah</p>
        </div>
        <a href="{{ route('admin.manajemen-mata-kuliah.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

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

    <div class="form-wrapper">
        <form action="{{ route('admin.manajemen-mata-kuliah.update', $mataKuliah->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h3>Informasi Mata Kuliah</h3>

                <div class="form-group">
                    <label for="prodi_id">Program Studi <span class="required">*</span></label>
                    <select name="prodi_id" id="prodi_id" class="form-control {{ $errors->has('prodi_id') ? 'is-invalid' : '' }}">
                        <option value="">Pilih Program Studi</option>
                        @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('prodi_id', $mataKuliah->prodi_id) == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                        @endforeach
                    </select>
                    @error('prodi_id')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="kode_matakuliah">Kode Mata Kuliah <span class="required">*</span></label>
                    <input type="text" name="kode_matakuliah" id="kode_matakuliah" 
                           class="form-control {{ $errors->has('kode_matakuliah') ? 'is-invalid' : '' }}"
                           value="{{ old('kode_matakuliah', $mataKuliah->kode_matakuliah) }}"
                           placeholder="Masukkan Kode Mata Kuliah">
                    @error('kode_matakuliah')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_matakuliah">Nama Mata Kuliah <span class="required">*</span></label>
                    <input type="text" name="nama_matakuliah" id="nama_matakuliah" 
                           class="form-control {{ $errors->has('nama_matakuliah') ? 'is-invalid' : '' }}"
                           value="{{ old('nama_matakuliah', $mataKuliah->nama_matakuliah) }}"
                           placeholder="Masukkan Nama Mata Kuliah">
                    @error('nama_matakuliah')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="sks">SKS <span class="required">*</span></label>
                        <input type="number" name="sks" id="sks" 
                               class="form-control {{ $errors->has('sks') ? 'is-invalid' : '' }}"
                               value="{{ old('sks', $mataKuliah->sks) }}"
                               min="1" max="6"
                               placeholder="Jumlah SKS">
                        @error('sks')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="js">JS (Jam Simulasi)</label>
                        <input type="number" name="js" id="js" 
                               class="form-control {{ $errors->has('js') ? 'is-invalid' : '' }}"
                               value="{{ old('js', $mataKuliah->js) }}"
                               min="1" max="6"
                               placeholder="Jumlah Jam Simulasi">
                        @error('js')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="semester">Semester <span class="required">*</span></label>
                        <input type="number" name="semester" id="semester" 
                               class="form-control {{ $errors->has('semester') ? 'is-invalid' : '' }}"
                               value="{{ old('semester', $mataKuliah->semester) }}"
                               min="1" max="8"
                               placeholder="Semester">
                        @error('semester')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenis_mk">Jenis Mata Kuliah <span class="required">*</span></label>
                        <select name="jenis_mk" id="jenis_mk" 
                                class="form-control {{ $errors->has('jenis_mk') ? 'is-invalid' : '' }}">
                            <option value="">Pilih Jenis Mata Kuliah</option>
                            @foreach($jenisMkOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('jenis_mk', $mataKuliah->jenis_mk) == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                        @error('jenis_mk')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.manajemen-mata-kuliah.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .mata-kuliah-edit {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }

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

    .form-wrapper {
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

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-row:last-child {
        margin-bottom: 0;
    }

    .form-row .form-group {
        margin-bottom: 0;
    }

    label {
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

    .is-invalid {
        border-color: #ef4444;
    }

    .is-invalid:focus {
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

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 20px 24px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    @media (max-width: 768px) {
        .mata-kuliah-edit {
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