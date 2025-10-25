@extends('layouts.admin')

@section('title', 'Edit Jadwal')

@section('content')
<div class="jadwal-edit">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Jadwal</h1>
        </div>
        <a href="{{ route('admin.jadwal-mahasiswa.index') }}" class="btn btn-secondary">
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
        <strong>Terdapat kesalahan:</strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.jadwal-mahasiswa.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3>Mata Kuliah & Dosen</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="mata_kuliah_id">Mata Kuliah <span class="required">*</span></label>
                        <select name="mata_kuliah_id" 
                                id="mata_kuliah_id" 
                                class="form-control @error('mata_kuliah_id') is-invalid @enderror" 
                                required
                                onchange="updateSemester(this)">
                            <option value="">Pilih Mata Kuliah</option>
                            @foreach($mataKuliahs as $mk)
                                <option value="{{ $mk->id }}" 
                                        data-semester="{{ $mk->semester }}"
                                        {{ old('mata_kuliah_id', $jadwal->mata_kuliah_id) == $mk->id ? 'selected' : '' }}>
                                    {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_kuliah_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="dosen_id">Dosen <span class="required">*</span></label>
                        <select name="dosen_id" 
                                id="dosen_id" 
                                class="form-control @error('dosen_id') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Dosen</option>
                            @foreach($dosenList as $dosen)
                                <option value="{{ $dosen->id }}" {{ old('dosen_id', $jadwal->dosen_id) == $dosen->id ? 'selected' : '' }}>
                                    {{ $dosen->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                        @error('dosen_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Program Studi</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="prodi_id">Program Studi <span class="required">*</span></label>
                        <select name="prodi_id" 
                                id="prodi_id" 
                                class="form-control @error('prodi_id') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('prodi_id', $jadwal->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }} ({{ $prodi->jenjang }})
                                </option>
                            @endforeach
                        </select>
                        @error('prodi_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Waktu & Tempat</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="hari">Hari <span class="required">*</span></label>
                        <select name="hari" 
                                id="hari" 
                                class="form-control @error('hari') is-invalid @enderror" 
                                required>
                            <option value="">Pilih Hari</option>
                            @foreach($hariOptions as $key => $value)
                                <option value="{{ $key }}" {{ old('hari', $jadwal->hari) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('hari')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ruang">Ruang</label>
                        <input type="text" 
                               class="form-control @error('ruang') is-invalid @enderror" 
                               id="ruang" 
                               name="ruang" 
                               value="{{ old('ruang', $jadwal->ruang) }}"
                               placeholder="Contoh: A101"
                               maxlength="50">
                        @error('ruang')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai <span class="required">*</span></label>
                        <input type="time" 
                               class="form-control @error('jam_mulai') is-invalid @enderror" 
                               id="jam_mulai" 
                               name="jam_mulai" 
                               value="{{ old('jam_mulai', date('H:i', strtotime($jadwal->jam_mulai))) }}"
                               required>
                        @error('jam_mulai')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai <span class="required">*</span></label>
                        <input type="time" 
                               class="form-control @error('jam_selesai') is-invalid @enderror" 
                               id="jam_selesai" 
                               name="jam_selesai" 
                               value="{{ old('jam_selesai', date('H:i', strtotime($jadwal->jam_selesai))) }}"
                               required>
                        @error('jam_selesai')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Periode Akademik</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="semester">Semester <span class="required">*</span></label>
                        <input type="text" 
                               class="form-control @error('semester') is-invalid @enderror" 
                               id="semester" 
                               name="semester" 
                               value="{{ old('semester', $jadwal->semester) }}"
                               placeholder="Contoh: Ganjil/Genap"
                               maxlength="10"
                               required>
                        @error('semester')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun_ajaran">Tahun Ajaran <span class="required">*</span></label>
                        <input type="text" 
                               class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                               id="tahun_ajaran" 
                               name="tahun_ajaran" 
                               value="{{ old('tahun_ajaran', $jadwal->tahun_ajaran) }}"
                               placeholder="Contoh: 2024/2025"
                               maxlength="20"
                               required>
                        @error('tahun_ajaran')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.jadwal-mahasiswa.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
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

    .jadwal-edit {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px;
        font-family: 'Nunito', sans-serif;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .header-left h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    /* Buttons */
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

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
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
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .form-section {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 15px 0;
        color: #1f2937;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
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

    .form-control {
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

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
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
        gap: 10px;
        justify-content: flex-end;
        padding: 16px 20px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .jadwal-edit {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .form-grid {
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

@push('scripts')
<script>
    function updateSemester(selectElement) {
        const semesterInput = document.getElementById('semester');
        const mataKuliahId = selectElement.value;
        const mataKuliah = Array.from(selectElement.options).find(option => option.value === mataKuliahId);

        if (mataKuliah) {
            const semester = mataKuliah.dataset.semester;

            if (semester) {
                semesterInput.value = semester;
            }
        }
    }

    // Tambahkan event listener saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const mataKuliahSelect = document.getElementById('mata_kuliah_id');
        
        // Jalankan updateSemester jika sudah ada mata kuliah yang dipilih
        if (mataKuliahSelect.value) {
            updateSemester(mataKuliahSelect);
        }

        // Tambahkan event listener untuk perubahan mata kuliah
        mataKuliahSelect.addEventListener('change', function() {
            updateSemester(this);
        });
    });
</script>
@endpush
@endsection