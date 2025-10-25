@extends('layouts.dosen')

@section('title', 'Edit Nilai Mahasiswa')

@push('styles')
<style>
    .nilai-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .card-simple {
        background: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }

    .card-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #1976d2;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    }

    .form-control:disabled {
        background-color: #f5f5f5;
        cursor: not-allowed;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
        margin-right: 8px;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .info-header {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
        color: #333;
        padding: 24px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .info-header h2 {
        margin: 0 0 8px 0;
        font-size: 24px;
    }

    .info-header p {
        margin: 0;
        opacity: 0.8;
        font-size: 14px;
    }

    .info-box {
        background-color: #f8f9fa;
        padding: 16px;
        border-radius: 6px;
        margin-bottom: 24px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #e0e0e0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #666;
        font-size: 14px;
    }

    .info-value {
        color: #333;
        font-weight: 500;
        font-size: 14px;
    }

    .nilai-preview {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        padding: 20px;
        border-radius: 8px;
        text-align: center;
        margin-top: 16px;
    }

    .nilai-preview-label {
        font-size: 13px;
        font-weight: 600;
        color: #1565c0;
        margin-bottom: 8px;
    }

    .nilai-preview-value {
        font-size: 48px;
        font-weight: 800;
        color: #1976d2;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 10px;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="nilai-container">
    <div class="info-header">
        <h2>Edit Nilai Mahasiswa</h2>
        <p>Perbarui nilai mahasiswa untuk mata kuliah yang dipilih</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-simple">
        <h3 class="card-title">Informasi Mahasiswa & Mata Kuliah</h3>
        <div class="info-box">
            <div class="info-item">
                <span class="info-label">NIM</span>
                <span class="info-value">{{ $nilai->mahasiswa->nim ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Mahasiswa</span>
                <span class="info-value">{{ $nilai->mahasiswa->nama_lengkap ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Program Studi</span>
                <span class="info-value">{{ $nilai->prodi->nama_prodi ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Mata Kuliah</span>
                <span class="info-value">{{ $nilai->mataKuliah->kode_matakuliah ?? '-' }} - {{ $nilai->mataKuliah->nama_matakuliah ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Semester</span>
                <span class="info-value">Semester {{ $nilai->semester }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tahun Ajaran</span>
                <span class="info-value">{{ $nilai->tahun_ajaran }}</span>
            </div>
        </div>
    </div>

    <form action="{{ route('dosen.inputNilai.update', $nilai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-simple">
            <h3 class="card-title">Edit Nilai</h3>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Tahun Ajaran</label>
                        <select name="tahun_ajaran" class="form-control" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            @php
                                $currentYear = date('Y');
                                $startYear = 2020;
                                $endYear = $currentYear + 2; // Tambah 2 tahun ke depan
                                // Parse tahun ajaran yang ada (format: 2024/2025 Ganjil)
                                $selectedTahunAjaran = $nilai->tahun_ajaran;
                                $parts = explode(' ', $selectedTahunAjaran);
                                $selectedYearRange = $parts[0] ?? '';
                                $selectedSemester = $parts[1] ?? '';
                            @endphp
                            @for($year = $endYear; $year >= $startYear; $year--)
                                @php
                                    $nextYear = $year + 1;
                                    $tahunRange = $year . '/' . $nextYear;
                                @endphp
                                <option value="{{ $tahunRange }} Ganjil" 
                                    {{ ($selectedYearRange == $tahunRange && $selectedSemester == 'Ganjil') ? 'selected' : '' }}>
                                    {{ $tahunRange }} Ganjil
                                </option>
                                <option value="{{ $tahunRange }} Genap" 
                                    {{ ($selectedYearRange == $tahunRange && $selectedSemester == 'Genap') ? 'selected' : '' }}>
                                    {{ $tahunRange }} Genap
                                </option>
                            @endfor
                        </select>
                        <small style="color: #666; font-size: 12px; margin-top: 4px; display: block;">
                            Pilih tahun ajaran dan semester (Ganjil/Genap)
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Nilai Angka (0-100)</label>
                <input type="number" name="nilai_angka" id="nilaiAngkaInput" class="form-control" 
                       min="0" max="100" step="0.01" value="{{ old('nilai_angka', $nilai->nilai_angka) }}" required>
                <small style="color: #666; font-size: 12px; margin-top: 4px; display: block;">
                    Masukkan nilai dalam skala 0-100
                </small>
            </div>

            <div class="form-group">
                <label class="form-label">Nilai Huruf</label>
                <input type="text" id="nilaiHurufInput" class="form-control" 
                       value="{{ old('nilai_huruf', $nilai->nilai_huruf) }}" readonly 
                       style="background-color: #f5f5f5; font-weight: 700; font-size: 18px;">
                <small style="color: #666; font-size: 12px; margin-top: 4px; display: block;">
                    Nilai huruf akan otomatis terisi berdasarkan nilai angka (otomatis dari sistem)
                </small>
            </div>

            <div class="nilai-preview" id="nilaiPreview">
                <div class="nilai-preview-label">Preview Nilai</div>
                <div class="nilai-preview-value" id="previewValue">{{ $nilai->nilai_huruf }}</div>
            </div>
        </div>

        <div class="card-simple" style="background-color: #f8f9fa; border: none;">
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('dosen.inputNilai.show', $nilai->id) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nilaiAngkaInput = document.getElementById('nilaiAngkaInput');
    const nilaiHurufInput = document.getElementById('nilaiHurufInput');
    const previewValue = document.getElementById('previewValue');
    const nilaiPreview = document.getElementById('nilaiPreview');

    function updateNilaiHuruf() {
        const nilai = parseFloat(nilaiAngkaInput.value);
        let nilaiHuruf = '';
        
        if (!isNaN(nilai)) {
            // Konversi sesuai dengan model NilaiMahasiswa
            if (nilai >= 96) {
                nilaiHuruf = 'A+';
                nilaiPreview.style.background = 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)';
            } else if (nilai >= 86) {
                nilaiHuruf = 'A';
                nilaiPreview.style.background = 'linear-gradient(135deg, #e8f5e9 0%, #a5d6a7 100%)';
            } else if (nilai >= 81) {
                nilaiHuruf = 'A-';
                nilaiPreview.style.background = 'linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%)';
            } else if (nilai >= 76) {
                nilaiHuruf = 'B+';
                nilaiPreview.style.background = 'linear-gradient(135deg, #e3f2fd 0%, #90caf9 100%)';
            } else if (nilai >= 71) {
                nilaiHuruf = 'B';
                nilaiPreview.style.background = 'linear-gradient(135deg, #e3f2fd 0%, #90caf9 100%)';
            } else if (nilai >= 66) {
                nilaiHuruf = 'B-';
                nilaiPreview.style.background = 'linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)';
            } else if (nilai >= 61) {
                nilaiHuruf = 'C+';
                nilaiPreview.style.background = 'linear-gradient(135deg, #fff3e0 0%, #ffcc80 100%)';
            } else if (nilai >= 56) {
                nilaiHuruf = 'C';
                nilaiPreview.style.background = 'linear-gradient(135deg, #fff3e0 0%, #ffcc80 100%)';
            } else if (nilai >= 41) {
                nilaiHuruf = 'D';
                nilaiPreview.style.background = 'linear-gradient(135deg, #ffebee 0%, #ef9a9a 100%)';
            } else {
                nilaiHuruf = 'E';
                nilaiPreview.style.background = 'linear-gradient(135deg, #f3e5f5 0%, #ce93d8 100%)';
            }
            
            nilaiHurufInput.value = nilaiHuruf;
            previewValue.textContent = nilaiHuruf;
        } else {
            nilaiHurufInput.value = '';
            previewValue.textContent = '-';
            nilaiPreview.style.background = 'linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%)';
        }
    }

    nilaiAngkaInput.addEventListener('input', updateNilaiHuruf);
    
    // Initialize on load
    updateNilaiHuruf();
});
</script>
@endpush