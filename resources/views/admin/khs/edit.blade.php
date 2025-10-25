@extends('layouts.admin')

@section('title', 'Edit Kartu Hasil Studi (KHS)')

@section('content')
<div class="khs-edit">
    <!-- Header -->
    <div class="page-header">
        <h1>Edit Kartu Hasil Studi (KHS)</h1>
        <a href="{{ route('admin.khs.index') }}" class="btn btn-secondary">
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
        <form action="{{ route('admin.khs.update', $khs) }}" method="POST" id="khsForm">
            @csrf
            @method('PUT')

            <!-- Mahasiswa Selection -->
            <div class="form-section">
                <h3>Informasi Mahasiswa</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Mahasiswa</label>
                        <select name="mahasiswa_id" class="form-control" id="mahasiswa_id">
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswas as $mahasiswa)
                                <option value="{{ $mahasiswa->id }}" 
                                    {{ $khs->mahasiswa_id == $mahasiswa->id ? 'selected' : '' }}>
                                    {{ $mahasiswa->nama_lengkap }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi_id" class="form-control" id="prodi_id">
                            <option value="">Pilih Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" 
                                    {{ $khs->prodi_id == $prodi->id ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" class="form-control" id="semester">
                            <option value="">Pilih Semester</option>
                            @for($i = 1; $i <= 14; $i++)
                                <option value="{{ $i }}" 
                                    {{ $khs->semester == $i ? 'selected' : '' }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun Ajaran <span class="required">*</span></label>
                        <input type="text" name="tahun_ajaran" class="form-control" 
                               placeholder="Contoh: 2024/2025" 
                               value="{{ $khs->tahun_ajaran }}" required>
                    </div>
                </div>
            </div>

            <!-- Mata Kuliah Details -->
            <div class="form-section mata-kuliah-section">
                <h3>Detail Mata Kuliah</h3>
                <div id="mataKuliahContainer">
                    @foreach($khs->details as $index => $detail)
                    <div class="mata-kuliah-row form-grid" data-row-index="{{ $index }}">
                        <div class="form-group">
                            <label>Mata Kuliah <span class="required">*</span></label>
                            <select name="mata_kuliah[{{ $index }}]" class="form-control mata-kuliah-select" required>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($mataKuliah[$khs->mahasiswa_id] as $mk)
                                    <option value="{{ $mk->id }}" 
                                        {{ $detail->mata_kuliah_id == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilih Nilai Mahasiswa</label>
                            <select name="nilai_mahasiswa[{{ $index }}]" class="form-control nilai-mahasiswa-select">
                                <option value="">Pilih Nilai (Opsional)</option>
                                @foreach($nilaiMahasiswa[$khs->mahasiswa_id] as $nm)
                                    <option value="{{ $nm->id }}"
                                        data-mk-id="{{ $nm->mata_kuliah_id }}"
                                        data-nilai="{{ $nm->nilai_angka }}"
                                        data-sks="{{ $nm->mata_kuliah->sks }}"
                                        {{ $detail->nilai_mahasiswa_id == $nm->id ? 'selected' : '' }}>
                                        {{ $nm->mata_kuliah->nama_matakuliah }} - Nilai: {{ $nm->nilai_angka }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nilai Angka</label>
                            <input type="number" name="nilai_angka[{{ $index }}]" class="form-control" 
                                   min="0" max="100" step="0.01" value="{{ $detail->nilai_angka }}">
                        </div>
                        <div class="form-group">
                            <label>SKS <span class="required">*</span></label>
                            <input type="number" name="sks[{{ $index }}]" class="form-control" 
                                   min="1" max="6" required value="{{ $detail->sks }}">
                        </div>
                        <div class="form-group remove-button-group">
                            <button type="button" class="btn btn-danger remove-mata-kuliah" 
                                    style="display: {{ $khs->details->count() > 1 ? 'inline-flex' : 'none' }};">
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
                <a href="{{ route('admin.khs.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mahasiswaSemesters = @json($mahasiswaSemesters);
        const mataKuliah = @json($mataKuliah);
        const nilaiMahasiswa = @json($nilaiMahasiswa);
        let rowCounter = {{ $khs->details->count() }};

        const mahasiswaSelect = document.getElementById('mahasiswa_id');
        const prodiSelect = document.getElementById('prodi_id');
        const semesterInput = document.getElementById('semester');
        const tahunAjaranInput = document.getElementById('tahun_ajaran');
        const courseTableBody = document.getElementById('mataKuliahContainer');
        const addCourseButton = document.getElementById('tambahMataKuliah');

        // Fungsi untuk mengatur event listener pada baris mata kuliah
        function setupRowEventListeners(row) {
            const mataKuliahSelect = row.querySelector('.mata-kuliah-select');
            const nilaiMahasiswaSelect = row.querySelector('.nilai-mahasiswa-select');
            const nilaiAngkaInput = row.querySelector('.nilai-angka-input');
            const sksInput = row.querySelector('.sks-input');
            const removeButton = row.querySelector('.remove-mata-kuliah');

            // Event listener untuk mata kuliah
            mataKuliahSelect.addEventListener('change', function() {
                // Reset pilihan mata kuliah dan nilai mahasiswa
                nilaiMahasiswaSelect.innerHTML = '<option value="">Pilih Nilai Mahasiswa</option>';
                nilaiAngkaInput.value = '';
                sksInput.value = '';

                const selectedMataKuliahId = this.value;
                const selectedMahasiswaId = mahasiswaSelect.value;

                if (selectedMahasiswaId && selectedMataKuliahId) {
                    // Filter dan isi dropdown Nilai Mahasiswa
                    const filteredNilaiMahasiswa = nilaiMahasiswa[selectedMahasiswaId].filter(
                        nm => nm.mata_kuliah && nm.mata_kuliah.id == selectedMataKuliahId
                    );

                    filteredNilaiMahasiswa.forEach(nm => {
                        const option = document.createElement('option');
                        option.value = nm.id;
                        option.textContent = `${nm.mata_kuliah?.kode_matakuliah || ''} - ${nm.mata_kuliah?.nama_matakuliah || ''} (${nm.semester})`;
                        nilaiMahasiswaSelect.appendChild(option);
                    });
                }
            });

            // Event listener untuk nilai mahasiswa
            nilaiMahasiswaSelect.addEventListener('change', function() {
                const selectedNilaiMahasiswaId = this.value;
                const selectedMahasiswaId = mahasiswaSelect.value;

                if (selectedNilaiMahasiswaId) {
                    const selectedNilai = nilaiMahasiswa[selectedMahasiswaId].find(
                        nm => nm.id == selectedNilaiMahasiswaId
                    );

                    if (selectedNilai && selectedNilai.mata_kuliah) {
                        nilaiAngkaInput.value = selectedNilai.nilai_angka || 0;
                        sksInput.value = selectedNilai.mata_kuliah.sks || 0;
                    }
                }
            });

            // Event listener untuk tombol hapus
            removeButton.addEventListener('click', function() {
                row.remove();
                updateRemoveButtons();
            });
        }

        // Fungsi untuk memperbarui tombol hapus
        function updateRemoveButtons() {
            const rows = courseTableBody.querySelectorAll('.mata-kuliah-row');
            rows.forEach((row, index) => {
                const removeButton = row.querySelector('.remove-mata-kuliah');
                removeButton.style.display = rows.length > 1 ? 'inline-flex' : 'none';
            });
        }

        // Fungsi untuk memperbarui indeks baris
        function updateRowIndices() {
            const rows = courseTableBody.querySelectorAll('.mata-kuliah-row');
            rows.forEach((row, index) => {
                row.querySelectorAll('select, input').forEach(el => {
                    const nameAttr = el.getAttribute('name');
                    if (nameAttr) {
                        el.setAttribute('name', nameAttr.replace(/\[\d+\]/, `[${index}]`));
                    }
                });
            });
        }

        // Fungsi untuk menghasilkan opsi mata kuliah
        function generateMataKuliahOptions(selectedMataKuliahId = '') {
            const selectedMahasiswaId = mahasiswaSelect.value;
            let options = '';

            if (selectedMahasiswaId) {
                const mataKuliahList = mataKuliah[selectedMahasiswaId] || [];
                mataKuliahList.forEach(mk => {
                    const selected = mk.id == selectedMataKuliahId ? 'selected' : '';
                    options += `<option value="${mk.id}" ${selected}>${mk.kode_matakuliah || ''} - ${mk.nama_matakuliah || ''}</option>`;
                });
            }

            return options;
        }

        // Event listener untuk mahasiswa
        mahasiswaSelect.addEventListener('change', function() {
            const selectedMahasiswaId = this.value;
            const selectedMahasiswa = @json($mahasiswas).find(m => m.id == selectedMahasiswaId);

            // Set semester dan prodi otomatis
            if (selectedMahasiswa) {
                semesterInput.value = mahasiswaSemesters[selectedMahasiswaId] || 1;
                prodiSelect.value = selectedMahasiswa.prodi_id || '';
            }

            // Bersihkan dan isi ulang mata kuliah
            courseTableBody.innerHTML = '';
            rowCounter = 0;

            // Tambahkan baris mata kuliah yang sudah ada di KHS
            @foreach($khs->details as $detail)
                addCourseRow(
                    '{{ $detail->mata_kuliah_id }}', 
                    '{{ $detail->nilai_mahasiswa_id }}', 
                    '{{ $detail->nilai_angka }}', 
                    '{{ $detail->sks }}'
                );
            @endforeach

            // Tambahkan baris mata kuliah baru jika belum ada
            if (courseTableBody.children.length === 0) {
                addCourseRow();
            }
        });

        // Fungsi untuk menambah baris mata kuliah
        function addCourseRow(mataKuliahId = '', nilaiMahasiswaId = '', nilaiAngka = '', sks = '') {
            const row = document.createElement('div');
            row.className = 'mata-kuliah-row form-grid';
            row.setAttribute('data-row-index', rowCounter);
            row.innerHTML = `
                <div class="form-group">
                    <label>Mata Kuliah <span class="required">*</span></label>
                    <select name="mata_kuliah[${rowCounter}]" class="form-control mata-kuliah-select" required>
                        <option value="">Pilih Mata Kuliah</option>
                        ${generateMataKuliahOptions(mataKuliahId)}
                    </select>
                </div>
                <div class="form-group">
                    <label>Pilih Nilai Mahasiswa</label>
                    <select name="nilai_mahasiswa[${rowCounter}]" class="form-control nilai-mahasiswa-select">
                        <option value="">Pilih Nilai (Opsional)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Nilai Angka</label>
                    <input type="number" step="0.01" name="nilai_angka[${rowCounter}]" 
                           class="form-control nilai-angka-input" value="${nilaiAngka}" required>
                </div>
                <div class="form-group">
                    <label>SKS <span class="required">*</span></label>
                    <input type="number" name="sks[${rowCounter}]" 
                           class="form-control sks-input" value="${sks}" required>
                </div>
                <div class="form-group remove-button-group">
                    <button type="button" class="btn btn-danger remove-mata-kuliah">Hapus</button>
                </div>
            `;

            courseTableBody.appendChild(row);
            setupRowEventListeners(row);
            rowCounter++;
            updateRemoveButtons();

            // Jika ada mata kuliah yang dipilih, trigger change event
            const mataKuliahSelect = row.querySelector('.mata-kuliah-select');
            if (mataKuliahId) {
                mataKuliahSelect.value = mataKuliahId;
                mataKuliahSelect.dispatchEvent(new Event('change'));
            }
        }

        // Tambahkan event listener untuk tombol tambah mata kuliah
        addCourseButton.addEventListener('click', function() {
            addCourseRow();
        });

        // Inisialisasi awal
        updateRemoveButtons();

        // Trigger change event untuk mahasiswa yang sudah dipilih
        if (mahasiswaSelect.value) {
            mahasiswaSelect.dispatchEvent(new Event('change'));
        }

        // Tambahkan event listener untuk mengisi dropdown Mata Kuliah dan Nilai Mahasiswa
        document.addEventListener('DOMContentLoaded', function() {
            const rows = courseTableBody.querySelectorAll('.mata-kuliah-row');
            rows.forEach(row => {
                const mataKuliahSelect = row.querySelector('.mata-kuliah-select');
                const nilaiMahasiswaSelect = row.querySelector('.nilai-mahasiswa-select');
                const selectedMahasiswaId = mahasiswaSelect.value;
                const selectedMataKuliahId = mataKuliahSelect.value;

                // Isi dropdown Mata Kuliah
                mataKuliahSelect.innerHTML = `
                    <option value="">Pilih Mata Kuliah</option>
                    ${generateMataKuliahOptions(selectedMataKuliahId)}
                `;

                // Isi dropdown Nilai Mahasiswa
                if (selectedMahasiswaId && selectedMataKuliahId) {
                    const filteredNilaiMahasiswa = nilaiMahasiswa[selectedMahasiswaId].filter(
                        nm => nm.mata_kuliah_id == selectedMataKuliahId
                    );

                    filteredNilaiMahasiswa.forEach(nm => {
                        const option = document.createElement('option');
                        option.value = nm.id;
                        option.textContent = `${nm.mata_kuliah?.kode_matakuliah || ''} - ${nm.mata_kuliah?.nama_matakuliah || ''} (${nm.semester})`;
                        nilaiMahasiswaSelect.appendChild(option);
                    });
                }
            });
        });

        // Validasi form sebelum submit
        document.getElementById('khsForm').addEventListener('submit', function(e) {
            const rows = courseTableBody.querySelectorAll('.mata-kuliah-row');
            
            if (rows.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 mata kuliah!');
                return false;
            }

            const mataKuliahSelects = document.querySelectorAll('select[name^="mata_kuliah"]');
            const sksInputs = document.querySelectorAll('input[name^="sks"]');

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

            // Validasi input
            for (let i = 0; i < mataKuliahSelects.length; i++) {
                if (!mataKuliahSelects[i].value || !sksInputs[i].value) {
                    e.preventDefault();
                    alert('Mata kuliah dan SKS harus diisi!');
                    return false;
                }
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .khs-edit {
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
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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

    .btn-secondary:hover {
        background: #4b5563;
    }

    @media (max-width: 768px) {
        .khs-edit {
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
