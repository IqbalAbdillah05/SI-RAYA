@extends('layouts.admin')

@section('title', 'Tambah Mata Kuliah')

@section('content')
<div class="mata-kuliah-create">
    <!-- Header -->
    <div class="page-header">
        <h1>Tambah Mata Kuliah Baru</h1>
        <a href="{{ route('admin.manajemen-mata-kuliah.index') }}" class="btn btn-secondary">
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
        <h2><i class="fas fa-file-excel"></i> Import Data Mata Kuliah</h2>
        <p class="import-description">Upload file Excel untuk menambahkan banyak mata kuliah sekaligus</p>
        
        <div class="import-cards">
            <div class="import-card">
                <div class="import-card-header">
                    <i class="fas fa-book"></i>
                    <h3>Import Mata Kuliah</h3>
                </div>
                <div class="import-card-body">
                    <p>Upload file Excel berisi data mata kuliah</p>
                    <form action="{{ route('admin.manajemen-mata-kuliah.import.process') }}" method="POST" enctype="multipart/form-data" class="import-form">
                        @csrf
                        <div class="file-input-wrapper">
                            <input type="file" name="file" id="fileMataKuliah" accept=".xlsx,.xls,.csv" required class="file-input">
                            <label for="fileMataKuliah" class="file-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Pilih File Excel</span>
                            </label>
                        </div>
                        <div class="import-actions">
                            <a href="{{ route('admin.manajemen-mata-kuliah.template') }}" class="btn btn-outline" target="_blank">
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

    <h2 style="margin-bottom: 20px; text-align: center;">Tambah Mata Kuliah Manual</h2>

    <!-- Form Container -->
    <div class="form-container">
        <form action="{{ route('admin.manajemen-mata-kuliah.store') }}" method="POST">
            @csrf
            <div class="form-section">
                <h3>Data Mata Kuliah</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Program Studi <span class="required">*</span></label>
                        <select name="prodi_id" class="form-control">
                            <option value="">Pilih Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" 
                                    {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kode Mata Kuliah <span class="required">*</span></label>
                        <input type="text" name="kode_matakuliah" class="form-control" 
                               value="{{ old('kode_matakuliah') }}" 
                               placeholder="Masukkan Kode Mata Kuliah">
                    </div>

                    <div class="form-group full-width">
                        <label>Nama Mata Kuliah <span class="required">*</span></label>
                        <input type="text" name="nama_matakuliah" class="form-control" 
                               value="{{ old('nama_matakuliah') }}" 
                               placeholder="Masukkan Nama Mata Kuliah">
                    </div>

                    <div class="form-group">
                        <label>SKS <span class="required">*</span></label>
                        <input type="number" name="sks" class="form-control" 
                               value="{{ old('sks') }}" 
                               min="1" max="6"
                               placeholder="Jumlah SKS">
                    </div>

                    <div class="form-group">
                        <label>JS (Jam Simulasi)</label>
                        <input type="number" name="js" class="form-control" 
                               value="{{ old('js') }}" 
                               min="1" max="6"
                               placeholder="Jumlah Jam Simulasi">
                    </div>

                    <div class="form-group">
                        <label>Semester <span class="required">*</span></label>
                        <input type="number" name="semester" class="form-control" 
                               value="{{ old('semester') }}" 
                               min="1" max="8"
                               placeholder="Semester">
                    </div>

                    <div class="form-group">
                        <label>Jenis Mata Kuliah <span class="required">*</span></label>
                        <select name="jenis_mk" class="form-control">
                            <option value="">Pilih Jenis Mata Kuliah</option>
                            @foreach($jenisMkOptions as $key => $label)
                            <option value="{{ $key }}" {{ old('jenis_mk') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
                <a href="{{ route('admin.manajemen-mata-kuliah.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    .mata-kuliah-create {
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
        const fileInput = document.getElementById('fileMataKuliah');
        
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
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
    });
</script>
@endpush