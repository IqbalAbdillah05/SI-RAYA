@extends('layouts.dosen')

@section('title', 'Input Nilai Mahasiswa')

@push('styles')
<style>
    .nilai-container {
        max-width: 1400px;
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
    }

    .btn-primary {
        background-color: #1976d2;
        color: white;
    }

    .btn-primary:hover {
        background-color: #1565c0;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
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

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 10px;
    }

    .col-md-4 {
        flex: 0 0 33.333%;
        max-width: 33.333%;
        padding: 0 10px;
    }

    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0 10px;
    }

    .input-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .loading-overlay.active {
        display: flex;
    }

    .loading-spinner {
        background: white;
        padding: 30px;
        border-radius: 8px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .col-md-3,
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="nilai-container">
    <div class="card-simple">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="card-title" style="margin: 0;">Input Nilai Mahasiswa</h2>
            <a href="{{ route('dosen.inputNilai.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
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

        <form id="filterForm">
            <div class="filter-section">
                <h4 style="margin-bottom: 16px; color: #333;">Filter Data Mahasiswa</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Program Studi</label>
                            <select name="prodi_id" id="prodiSelect" class="form-control" required>
                                <option value="">Pilih Prodi</option>
                                @foreach($prodiList as $prodi)
                                    <option value="{{ $prodi->id }}">{{ $prodi->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Semester</label>
                            <select name="semester" id="semesterSelect" class="form-control" required>
                                <option value="">Pilih Semester</option>
                                @for($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" id="matakuliahSelect" class="form-control" required disabled>
                                <option value="">Pilih Mata Kuliah</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Tahun Ajaran</label>
                            <select name="tahun_ajaran" id="tahunAjaranInput" class="form-control" required>
                                <option value="">Pilih Tahun Ajaran</option>
                                @php
                                    $currentYear = date('Y');
                                    $startYear = 2020;
                                    $endYear = $currentYear + 2; // Tambah 2 tahun ke depan untuk perencanaan
                                @endphp
                                @for($year = $endYear; $year >= $startYear; $year--)
                                    @php
                                        $nextYear = $year + 1;
                                        $tahunRange = $year . '/' . $nextYear;
                                        $isCurrentYear = $year == $currentYear;
                                    @endphp
                                    <option value="{{ $tahunRange }} Ganjil" {{ $isCurrentYear ? 'selected' : '' }}>
                                        {{ $tahunRange }} Ganjil
                                    </option>
                                    <option value="{{ $tahunRange }} Genap">
                                        {{ $tahunRange }} Genap
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <button type="button" id="loadMahasiswaBtn" class="btn btn-primary" disabled>
                    <i class="fas fa-search"></i> Tampilkan Mahasiswa
                </button>
            </div>
        </form>

        <form action="{{ route('dosen.inputNilai.store') }}" method="POST" id="nilaiForm">
            @csrf
            <input type="hidden" name="prodi_id" id="hiddenProdi">
            <input type="hidden" name="semester" id="hiddenSemester">
            <input type="hidden" name="matakuliah_id" id="hiddenMatakuliah">
            <input type="hidden" name="tahun_ajaran" id="hiddenTahunAjaran">

            <div id="mahasiswaTableContainer" style="display: none;">
                <h4 style="margin-bottom: 16px; color: #333;">Daftar Mahasiswa</h4>
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 15%;">NIM</th>
                                <th style="width: 30%;">Nama Mahasiswa</th>
                                <th style="width: 20%;">Prodi</th>
                                <th style="width: 15%;">Nilai Angka</th>
                                <th style="width: 15%;">Nilai Huruf</th>
                            </tr>
                        </thead>
                        <tbody id="mahasiswaTableBody">
                            <tr>
                                <td colspan="6" style="text-align: center; color: #666;">
                                    Pilih filter dan klik tombol "Tampilkan Mahasiswa"
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 24px; display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Nilai
                    </button>
                    <a href="{{ route('dosen.inputNilai.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #1976d2;"></i>
        <p style="margin-top: 12px; color: #333;">Memuat data...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const prodiSelect = document.getElementById('prodiSelect');
    const semesterSelect = document.getElementById('semesterSelect');
    const matakuliahSelect = document.getElementById('matakuliahSelect');
    const loadMahasiswaBtn = document.getElementById('loadMahasiswaBtn');
    const mahasiswaTableContainer = document.getElementById('mahasiswaTableContainer');
    const mahasiswaTableBody = document.getElementById('mahasiswaTableBody');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // Load mata kuliah when prodi and semester selected
    function loadMataKuliah() {
        const prodiId = prodiSelect.value;
        const semester = semesterSelect.value;

        console.log('=== LOADING MATA KULIAH ===');
        console.log('Prodi ID:', prodiId);
        console.log('Semester:', semester);

        if (prodiId && semester) {
            loadingOverlay.classList.add('active');
            
            const url = `{{ route('dosen.inputNilai.getMatakuliah') }}?prodi_id=${prodiId}&semester=${semester}`;
            console.log('Fetch URL:', url);
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('Response Status:', response.status);
                console.log('Response OK:', response.ok);
                
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Error Response:', text);
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                
                matakuliahSelect.innerHTML = '<option value="">Pilih Mata Kuliah</option>';
                
                if (data.error) {
                    console.error('Server error:', data.error);
                    alert('Error: ' + data.error);
                    matakuliahSelect.innerHTML += '<option value="" disabled>Error memuat data</option>';
                } else if (data.length === 0) {
                    console.warn('No data found');
                    matakuliahSelect.innerHTML += '<option value="" disabled>Tidak ada mata kuliah untuk prodi dan semester ini</option>';
                } else {
                    console.log('Adding options, count:', data.length);
                    data.forEach(mk => {
                        const option = document.createElement('option');
                        option.value = mk.id;
                        option.textContent = `${mk.kode_matakuliah} - ${mk.nama_matakuliah}`;
                        matakuliahSelect.appendChild(option);
                    });
                    matakuliahSelect.disabled = false;
                }
                
                loadingOverlay.classList.remove('active');
                console.log('=== DONE ===');
            })
            .catch(error => {
                console.error('=== FETCH ERROR ===');
                console.error('Error:', error);
                
                matakuliahSelect.innerHTML = '<option value="">Pilih Mata Kuliah</option>';
                matakuliahSelect.innerHTML += '<option value="" disabled>Gagal memuat data</option>';
                
                alert('Gagal memuat data mata kuliah. Error: ' + error.message + '\n\nCek console browser (F12) untuk detail.');
                loadingOverlay.classList.remove('active');
            });
        } else {
            matakuliahSelect.innerHTML = '<option value="">Pilih Mata Kuliah</option>';
            matakuliahSelect.disabled = true;
        }
    }

    prodiSelect.addEventListener('change', function() {
        loadMataKuliah();
        checkFormComplete();
    });

    semesterSelect.addEventListener('change', function() {
        loadMataKuliah();
        checkFormComplete();
    });

    matakuliahSelect.addEventListener('change', checkFormComplete);

    function checkFormComplete() {
        const isComplete = prodiSelect.value && semesterSelect.value && matakuliahSelect.value;
        loadMahasiswaBtn.disabled = !isComplete;
    }

    loadMahasiswaBtn.addEventListener('click', function() {
        const prodiId = prodiSelect.value;
        const semester = semesterSelect.value;
        const matakuliahId = matakuliahSelect.value;
        const tahunAjaran = document.getElementById('tahunAjaranInput').value;

        console.log('=== LOADING MAHASISWA ===');
        console.log('Prodi ID:', prodiId);
        console.log('Semester:', semester);
        console.log('Mata Kuliah ID:', matakuliahId);

        if (!prodiId || !semester || !matakuliahId) {
            alert('Mohon lengkapi semua filter terlebih dahulu');
            return;
        }

        document.getElementById('hiddenProdi').value = prodiId;
        document.getElementById('hiddenSemester').value = semester;
        document.getElementById('hiddenMatakuliah').value = matakuliahId;
        document.getElementById('hiddenTahunAjaran').value = tahunAjaran;

        loadingOverlay.classList.add('active');

        const url = `{{ route('dosen.mahasiswa.byProdiSemester') }}?prodi_id=${prodiId}&semester=${semester}&matakuliah_id=${matakuliahId}`;
        console.log('Fetch URL:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Response Status:', response.status);
            console.log('Response OK:', response.ok);

            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Error Response:', text);
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data);

            mahasiswaTableBody.innerHTML = '';

            if (data.length === 0) {
                mahasiswaTableBody.innerHTML = `
                    <tr>
                        <td colspan="6" style="text-align: center; color: #666;">
                            Tidak ada mahasiswa ditemukan untuk mata kuliah yang dipilih
                        </td>
                    </tr>
                `;
            } else {
                data.forEach((mhs, index) => {
                    mahasiswaTableBody.innerHTML += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${mhs.nim}</td>
                            <td>${mhs.nama_lengkap}</td>
                            <td>${mhs.prodi ? mhs.prodi.nama_prodi : '-'}</td>
                            <td>
                                <input type="hidden" name="mahasiswa_id[]" value="${mhs.id}">
                                <input type="number" name="nilai_angka[]" class="form-control nilai-angka" 
                                       min="0" max="100" step="0.01" required 
                                       data-index="${index}">
                            </td>
                            <td>
                                <input type="text" class="form-control nilai-huruf" 
                                       readonly style="background-color: #f5f5f5;" 
                                       data-index="${index}">
                            </td>
                        </tr>
                    `;
                });

                // Add event listeners for auto-conversion
                document.querySelectorAll('.nilai-angka').forEach(input => {
                    input.addEventListener('input', function() {
                        const index = this.dataset.index;
                        const nilaiHurufInput = document.querySelector(`.nilai-huruf[data-index="${index}"]`);
                        const nilai = parseFloat(this.value);

                        if (!isNaN(nilai)) {
                            // Conversion based on NilaiMahasiswa model
                            if (nilai >= 96) nilaiHurufInput.value = 'A+';
                            else if (nilai >= 86) nilaiHurufInput.value = 'A';
                            else if (nilai >= 81) nilaiHurufInput.value = 'A-';
                            else if (nilai >= 76) nilaiHurufInput.value = 'B+';
                            else if (nilai >= 71) nilaiHurufInput.value = 'B';
                            else if (nilai >= 66) nilaiHurufInput.value = 'B-';
                            else if (nilai >= 61) nilaiHurufInput.value = 'C+';
                            else if (nilai >= 56) nilaiHurufInput.value = 'C';
                            else if (nilai >= 41) nilaiHurufInput.value = 'D';
                            else nilaiHurufInput.value = 'E';
                        } else {
                            nilaiHurufInput.value = '';
                        }
                    });
                });
            }

            mahasiswaTableContainer.style.display = 'block';
            loadingOverlay.classList.remove('active');
            console.log('=== DONE ===');
        })
        .catch(error => {
            console.error('=== FETCH ERROR ===');
            console.error('Error:', error);

            mahasiswaTableBody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; color: #666;">
                        Gagal memuat data mahasiswa. Error: ${error.message}
                    </td>
                </tr>
            `;

            alert('Gagal memuat data mahasiswa. Error: ' + error.message + '\n\nCek console browser (F12) untuk detail.');
            loadingOverlay.classList.remove('active');
        });
    });
});
</script>
@endpush