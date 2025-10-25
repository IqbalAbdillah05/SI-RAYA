@extends('layouts.admin')

@section('title', 'Edit Kartu Rencana Studi (KRS)')

@section('content')
<div class="krs-edit">
    <!-- Header -->
    <div class="page-header">
        <h1>Edit Kartu Rencana Studi (KRS)</h1>
        <a href="{{ route('admin.krs.index') }}" class="btn btn-secondary">
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
        <form action="{{ route('admin.krs.update', $krs) }}" method="POST" id="krsForm">
            @csrf
            @method('PUT')

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
                                    {{ $krs->mahasiswa_id == $mahasiswa->id ? 'selected' : '' }}>
                                    {{ $mahasiswa->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" id="prodi" class="form-control" readonly 
                               value="{{ $krs->mahasiswa->prodi->nama_prodi ?? 'N/A' }}">
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <input type="number" name="semester" id="semester" class="form-control" 
                               min="1" max="14" value="{{ $krs->semester }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Tahun Ajaran <span class="required">*</span></label>
                        <input type="text" name="tahun_ajaran" class="form-control" 
                               placeholder="Contoh: 2024/2025" 
                               value="{{ $krs->tahun_ajaran }}" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Pengisian</label>
                        <input type="date" name="tanggal_pengisian" class="form-control" 
                               value="{{ $krs->tanggal_pengisian ? $krs->tanggal_pengisian->format('Y-m-d') : date('Y-m-d') }}">
                    </div>
                </div>
            </div>

            <!-- Mata Kuliah Selection -->
            <div class="form-section mata-kuliah-section">
                <h3>Pilih Mata Kuliah</h3>
                <div id="mataKuliahContainer">
                    @foreach($krs->details as $index => $detail)
                    <div class="mata-kuliah-row form-grid" data-row-index="{{ $index }}">
                        <div class="form-group">
                            <label>Mata Kuliah <span class="required">*</span></label>
                            <select name="mata_kuliah[]" class="form-control mata-kuliah-select" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($mataKuliah as $mk)
                                    <option value="{{ $mk->id }}" 
                                        {{ $detail->mata_kuliah_id == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }} ({{ $mk->sks }} SKS)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group remove-button-group">
                            <button type="button" class="btn btn-danger remove-mata-kuliah">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="form-group full-width">
                    <button type="button" id="tambahMataKuliah" class="btn btn-secondary">
                        <i class="fas fa-plus"></i> Tambah Mata Kuliah
                    </button>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.krs.index') }}" class="btn btn-secondary">
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
        const semesterInput = document.getElementById('semester');
        const mataKuliahContainer = document.getElementById('mataKuliahContainer');
        const tambahMataKuliahBtn = document.getElementById('tambahMataKuliah');

        // Data dari backend
        const mataKuliah = @json($mataKuliah);
        const mahasiswas = @json($mahasiswas);

        let rowCounter = {{ $krs->details->count() }};

        // Update prodi dan semester saat mahasiswa dipilih
        mahasiswaSelect.addEventListener('change', function() {
            const selectedMahasiswaId = this.value;
            const selectedMahasiswa = mahasiswas.find(m => m.id == selectedMahasiswaId);
            
            if (selectedMahasiswa) {
                prodiInput.value = selectedMahasiswa.prodi ? selectedMahasiswa.prodi.nama_prodi : '';
                semesterInput.value = selectedMahasiswa.semester || 1;
            } else {
                prodiInput.value = '';
                semesterInput.value = '';
            }
        });

        // Fungsi untuk menghasilkan opsi mata kuliah berdasarkan semester
        function generateMataKuliahOptions(selectedSemester) {
            let options = '<option value="">Pilih Mata Kuliah</option>';
            
            mataKuliah.forEach(mk => {
                // Filter berdasarkan semester jika ada
                if (!selectedSemester || mk.semester == selectedSemester) {
                    options += `
                        <option value="${mk.id}">
                            ${mk.kode_matakuliah} - ${mk.nama_matakuliah} (${mk.sks} SKS)
                        </option>
                    `;
                }
            });
            return options;
        }

        // Fungsi untuk menambah baris mata kuliah
        function tambahMataKuliahRow() {
            const selectedSemester = semesterInput.value || null;

            const row = document.createElement('div');
            row.className = 'mata-kuliah-row form-grid';
            row.setAttribute('data-row-index', rowCounter);
            
            row.innerHTML = `
                <div class="form-group">
                    <label>Mata Kuliah <span class="required">*</span></label>
                    <select name="mata_kuliah[]" class="form-control mata-kuliah-select" required>
                        ${generateMataKuliahOptions(selectedSemester)}
                    </select>
                </div>
                <div class="form-group remove-button-group">
                    <button type="button" class="btn btn-danger remove-mata-kuliah">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

            // Tambahkan event listener untuk tombol hapus
            const removeButton = row.querySelector('.remove-mata-kuliah');
            removeButton.addEventListener('click', function() {
                row.remove();
                updateRemoveButtons();
            });

            mataKuliahContainer.appendChild(row);
            rowCounter++;
            updateRemoveButtons();
        }

        // Fungsi untuk memperbarui tombol hapus
        function updateRemoveButtons() {
            const rows = mataKuliahContainer.querySelectorAll('.mata-kuliah-row');
            rows.forEach((row, index) => {
                const removeButton = row.querySelector('.remove-mata-kuliah');
                removeButton.style.display = rows.length > 1 ? 'inline-block' : 'none';
            });
        }

        // Event listener untuk tombol tambah mata kuliah
        tambahMataKuliahBtn.addEventListener('click', tambahMataKuliahRow);

        // Event listener untuk tombol hapus yang sudah ada
        document.querySelectorAll('.remove-mata-kuliah').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.mata-kuliah-row').remove();
                updateRemoveButtons();
            });
        });

        // Validasi form
        document.getElementById('krsForm').addEventListener('submit', function(e) {
            const rows = mataKuliahContainer.querySelectorAll('.mata-kuliah-row');
            
            if (rows.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 mata kuliah!');
                return false;
            }

            const mataKuliahSelects = document.querySelectorAll('select[name="mata_kuliah[]"]');
            
            // Validasi mata kuliah tidak boleh duplikat
            const mataKuliahValues = Array.from(mataKuliahSelects)
                .map(select => select.value)
                .filter(val => val !== '');
            
            const uniqueMataKuliah = new Set(mataKuliahValues);
            
            if (mataKuliahValues.length !== uniqueMataKuliah.size) {
                e.preventDefault();
                alert('Mata kuliah tidak boleh duplikat!');
                return false;
            }
        });

        // Inisialisasi tombol hapus
        updateRemoveButtons();
    });
</script>
@endpush

@push('styles')
<style>
    .krs-edit {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px;
        font-family: 'Nunito', sans-serif;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .form-section {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        padding: 20px;
    }

    .form-section h3 {
        margin: 0 0 15px 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 5px;
        color: #666;
        font-size: 14px;
    }

    .form-group .form-control {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .mata-kuliah-row {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        background: #f9f9f9;
        border-radius: 4px;
    }

    .remove-button-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .remove-mata-kuliah {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-actions {
        max-width: 1000px;
        margin: 24px auto;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f9fafb;
        padding: 16px;
        border-top: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .btn-primary, .btn-secondary {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .required {
        color: red;
        margin-left: 4px;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    @media (max-width: 768px) {
        .krs-edit {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .form-grid, .mata-kuliah-row {
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
