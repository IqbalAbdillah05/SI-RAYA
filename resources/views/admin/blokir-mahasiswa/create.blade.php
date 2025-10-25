@extends('layouts.admin')

@section('title', 'Tambah Blokir Mahasiswa')

@section('content')
<div class="blokir-mahasiswa-create">
    <!-- Header -->
    <div class="page-header">
        <h1>Tambah Blokir Mahasiswa</h1>
        <a href="{{ route('admin.blokir-mahasiswa.index') }}" class="btn btn-secondary">
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

    <!-- Form Container -->
    <div class="form-container">
        <form action="{{ route('admin.blokir-mahasiswa.store') }}" method="POST" id="blokirForm" novalidate>
            @csrf

            <!-- Mahasiswa Selection -->
            <div class="form-section">
                <h3>Informasi Mahasiswa</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Mahasiswa <span class="required">*</span></label>
                        <select name="mahasiswa_id" id="mahasiswa_id" class="form-control" required>
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswas as $mahasiswa)
                                <option value="{{ $mahasiswa->id }}" 
                                    data-prodi="{{ $mahasiswa->prodi_id }}" 
                                    data-semester="{{ $mahasiswa->semester }}">
                                    {{ $mahasiswa->nama_lengkap }} ({{ $mahasiswa->nim }})
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Pilih mahasiswa yang akan diblokir</div>
                    </div>

                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="hidden" name="prodi_id" id="prodi_id" value="">
                        <input type="text" id="prodi" class="form-control" readonly>
                        <div class="invalid-feedback">Program studi harus diisi</div>
                    </div>

                    <div class="form-group">
                        <label>Semester</label>
                        <input type="number" name="semester" id="semester" class="form-control" min="1" max="14">
                    </div>

                    <div class="form-group">
                        <label>Tahun Ajaran</label>
                        <input type="text" name="tahun_ajaran" class="form-control" placeholder="Contoh: 2024/2025">
                    </div>
                </div>
            </div>

            <!-- Blokir Details -->
            <div class="form-section">
                <h3>Detail Pemblokiran</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Alasan pemblokiran"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Blokir</label>
                        <input type="date" name="tanggal_blokir" class="form-control" value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label>Status Blokir <span class="required">*</span></label>
                        <select name="status_blokir" class="form-control" required>
                            <option value="Diblokir">Diblokir</option>
                            <option value="Dibuka">Dibuka</option>
                        </select>
                        <div class="invalid-feedback">Pilih status blokir</div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.blokir-mahasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mahasiswaSelect = document.getElementById('mahasiswa_id');
    const prodiInput = document.getElementById('prodi');
    const prodiIdInput = document.getElementById('prodi_id');
    const semesterInput = document.getElementById('semester');

    mahasiswaSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const prodiId = selectedOption.getAttribute('data-prodi');
        const semester = selectedOption.getAttribute('data-semester');

        // Cari nama prodi dari opsi yang dipilih
        const prodis = @json($prodis);
        const selectedProdi = prodis.find(p => p.id == prodiId);
        
        // Set prodi
        prodiInput.value = selectedProdi ? selectedProdi.nama_prodi : '';
        prodiIdInput.value = prodiId || '';

        // Set semester
        semesterInput.value = semester || '';
    });
});
</script>
@endpush

@push('styles')
<style>
    /* Styles from KHS create view */
    * {
        box-sizing: border-box;
    }

    .blokir-mahasiswa-create {
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

    /* Form Validation Styles */
    .was-validated .form-control:invalid,
    .form-control.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .was-validated .form-control:valid,
    .form-control.is-valid {
        border-color: #28a745;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: #dc3545;
    }

    .was-validated .invalid-feedback {
        display: block;
    }
</style>
@endpush
@endsection
