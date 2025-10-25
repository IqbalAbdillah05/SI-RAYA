@extends('layouts.dosen')

@section('title', 'Presensi Mahasiswa')

@push('styles')
<style>
    .presensi-container {
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

    .alert-info {
        background-color: #e3f2fd;
        color: #1565c0;
        border: 1px solid #90caf9;
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

    .form-text.text-muted {
        display: block;
        margin-top: 6px;
        font-size: 12px;
        color: #6c757d;
    }

    .form-text.text-muted i {
        margin-right: 4px;
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

    .status-radio-group {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .status-radio {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .status-radio input[type="radio"] {
        margin: 0;
        cursor: pointer;
    }

    .status-radio label {
        margin: 0;
        cursor: pointer;
        font-weight: 500;
        font-size: 13px;
    }

    .status-hadir {
        color: #28a745;
    }

    .status-izin {
        color: #17a2b8;
    }

    .status-sakit {
        color: #ffc107;
    }

    .status-alpha {
        color: #dc3545;
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

    .quick-action-buttons {
        margin-bottom: 16px;
        display: flex;
        gap: 8px;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .btn-outline-success {
        background-color: white;
        color: #28a745;
        border: 1px solid #28a745;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }

    .btn-outline-danger {
        background-color: white;
        color: #dc3545;
        border: 1px solid #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    .file-upload-wrapper {
        position: relative;
        display: none;
        margin-top: 8px;
    }

    .file-upload-wrapper.show {
        display: block;
    }

    .file-upload-input {
        width: 100%;
        padding: 6px 10px;
        border: 1px dashed #ddd;
        border-radius: 4px;
        font-size: 12px;
        cursor: pointer;
    }

    .file-upload-input::-webkit-file-upload-button {
        padding: 4px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f8f9fa;
        cursor: pointer;
        margin-right: 8px;
        font-size: 12px;
    }

    .file-upload-input::-webkit-file-upload-button:hover {
        background-color: #e9ecef;
    }

    .file-info {
        font-size: 11px;
        color: #666;
        margin-top: 4px;
    }

    .file-preview {
        max-width: 100px;
        max-height: 100px;
        margin-top: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        display: none;
    }

    @media (max-width: 768px) {
        .col-md-3,
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 15px;
        }

        .status-radio-group {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')
<div class="presensi-container">
    <div class="card-simple">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="card-title" style="margin: 0;">Presensi Mahasiswa</h2>
            <a href="{{ route('dosen.presensiMahasiswa.index') }}" class="btn btn-secondary">
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
                                    <option value="{{ $prodi->id }}" {{ $prodiId == $prodi->id ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
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
                                    <option value="{{ $i }}" {{ $semester == $i ? 'selected' : '' }}>
                                        Semester {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" id="matakuliahSelect" class="form-control" required disabled>
                                <option value="">Pilih Mata Kuliah</option>
                                @foreach($matakuliahList as $mk)
                                    <option value="{{ $mk->id }}" {{ $matakuliahId == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->kode_matakuliah }} - {{ $mk->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Tanggal Presensi</label>
                            <input type="date" name="tanggal_presensi" id="tanggalPresensiInput" 
                                   class="form-control" value="{{ date('Y-m-d') }}" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-clock"></i> Waktu: Otomatis (Saat Submit)
                            </small>
                        </div>
                    </div>
                </div>
                <button type="button" id="loadMahasiswaBtn" class="btn btn-primary" disabled>
                    <i class="fas fa-search"></i> Tampilkan Mahasiswa
                </button>
            </div>
        </form>

        <form action="{{ route('dosen.presensiMahasiswa.store') }}" method="POST" id="presensiForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="prodi_id" id="hiddenProdi">
            <input type="hidden" name="semester" id="hiddenSemester">
            <input type="hidden" name="matakuliah_id" id="hiddenMatakuliah">
            <input type="hidden" name="tanggal_presensi" id="hiddenTanggalPresensi">

            <div id="mahasiswaTableContainer" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h4 style="margin: 0; color: #333;">Daftar Mahasiswa</h4>
                    <div class="quick-action-buttons">
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="setAllStatus('hadir')">
                            <i class="fas fa-check"></i> Semua Hadir
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="setAllStatus('alpha')">
                            <i class="fas fa-times"></i> Semua Alpha
                        </button>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Centang status presensi untuk setiap mahasiswa. <strong>Upload foto bukti diperlukan untuk status Sakit dan Izin.</strong>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 4%;">No</th>
                                <th style="width: 10%;">NIM</th>
                                <th style="width: 18%;">Nama Mahasiswa</th>
                                <th style="width: 12%;">Prodi</th>
                                <th style="width: 22%;">Status Presensi</th>
                                <th style="width: 20%;">Keterangan / Foto Bukti</th>
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
                        <i class="fas fa-save"></i> Simpan Presensi
                    </button>
                    <a href="{{ route('dosen.presensiMahasiswa.index') }}" class="btn btn-secondary">
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

        if (prodiId && semester) {
            loadingOverlay.classList.add('active');
            
            fetch(`/dosen/presensi-mahasiswa/get-matakuliah?prodi_id=${prodiId}&semester=${semester}`)
                .then(response => response.json())
                .then(data => {
                    matakuliahSelect.innerHTML = '<option value="">Pilih Mata Kuliah</option>';
                    
                    if (data.length === 0) {
                        matakuliahSelect.innerHTML += '<option value="" disabled>Tidak ada mata kuliah di jadwal Anda</option>';
                        matakuliahSelect.disabled = true;
                    } else {
                        data.forEach(mk => {
                            matakuliahSelect.innerHTML += `<option value="${mk.id}">${mk.kode_matakuliah} - ${mk.nama_matakuliah}</option>`;
                        });
                        matakuliahSelect.disabled = false;
                    }
                    
                    loadingOverlay.classList.remove('active');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data mata kuliah');
                    loadingOverlay.classList.remove('active');
                });
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

    // Load initial if values exist
    if (prodiSelect.value && semesterSelect.value) {
        loadMataKuliah();
    }

    loadMahasiswaBtn.addEventListener('click', function() {
        const prodiId = prodiSelect.value;
        const semester = semesterSelect.value;
        const matakuliahId = matakuliahSelect.value;
        const tanggalPresensi = document.getElementById('tanggalPresensiInput').value;

        document.getElementById('hiddenProdi').value = prodiId;
        document.getElementById('hiddenSemester').value = semester;
        document.getElementById('hiddenMatakuliah').value = matakuliahId;
        document.getElementById('hiddenTanggalPresensi').value = tanggalPresensi;

        loadingOverlay.classList.add('active');

        fetch(`/dosen/presensi-mahasiswa/get-mahasiswa?prodi_id=${prodiId}&semester=${semester}&matakuliah_id=${matakuliahId}&tanggal=${tanggalPresensi}`)
            .then(response => response.json())
            .then(data => {
                mahasiswaTableBody.innerHTML = '';
                
                if (data.length === 0) {
                    mahasiswaTableBody.innerHTML = `
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px;">
                                <i class="fas fa-info-circle" style="font-size: 48px; color: #ffc107; margin-bottom: 16px;"></i>
                                <p style="color: #666; font-size: 16px; margin: 0;">
                                    <strong>Semua mahasiswa sudah dipresensi hari ini</strong><br>
                                    <small>Tidak ada mahasiswa yang perlu dipresensi untuk filter yang dipilih</small>
                                </p>
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
                                    <div class="status-radio-group">
                                        <div class="status-radio status-hadir">
                                            <input type="radio" name="status[${index}]" value="hadir" 
                                                   id="hadir_${index}" checked required
                                                   onchange="toggleFotoUpload(${index}, 'hadir')">
                                            <label for="hadir_${index}">Hadir</label>
                                        </div>
                                        <div class="status-radio status-izin">
                                            <input type="radio" name="status[${index}]" value="izin" 
                                                   id="izin_${index}" required
                                                   onchange="toggleFotoUpload(${index}, 'izin')">
                                            <label for="izin_${index}">Izin</label>
                                        </div>
                                        <div class="status-radio status-sakit">
                                            <input type="radio" name="status[${index}]" value="sakit" 
                                                   id="sakit_${index}" required
                                                   onchange="toggleFotoUpload(${index}, 'sakit')">
                                            <label for="sakit_${index}">Sakit</label>
                                        </div>
                                        <div class="status-radio status-alpha">
                                            <input type="radio" name="status[${index}]" value="alpha" 
                                                   id="alpha_${index}" required
                                                   onchange="toggleFotoUpload(${index}, 'alpha')">
                                            <label for="alpha_${index}">Alpha</label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" name="keterangan[]" class="form-control" 
                                           placeholder="Optional" maxlength="100">
                                    <div class="file-upload-wrapper" id="upload_wrapper_${index}">
                                        <input type="file" 
                                               name="foto_bukti[${index}]" 
                                               id="foto_bukti_${index}"
                                               class="file-upload-input" 
                                               accept="image/jpeg,image/jpg,image/png"
                                               onchange="previewImage(${index})">
                                        <div class="file-info">
                                            <i class="fas fa-info-circle"></i> Maks. 2MB (JPG, PNG)
                                        </div>
                                        <img id="preview_${index}" class="file-preview" alt="Preview">
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }

                mahasiswaTableContainer.style.display = 'block';
                loadingOverlay.classList.remove('active');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data mahasiswa');
                loadingOverlay.classList.remove('active');
            });
    });
});

// Function to set all status
function setAllStatus(status) {
    const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
    radios.forEach((radio, index) => {
        radio.checked = true;
        // Toggle foto upload based on status
        toggleFotoUpload(index, status);
    });
}

// Function to toggle foto upload visibility
function toggleFotoUpload(index, status) {
    const uploadWrapper = document.getElementById(`upload_wrapper_${index}`);
    const fileInput = document.getElementById(`foto_bukti_${index}`);
    const preview = document.getElementById(`preview_${index}`);
    
    if (uploadWrapper) {
        if (status === 'sakit' || status === 'izin') {
            uploadWrapper.style.display = 'block';
        } else {
            uploadWrapper.style.display = 'none';
            // Clear file input and preview when hidden
            if (fileInput) fileInput.value = '';
            if (preview) preview.style.display = 'none';
        }
    }
}

// Function to preview uploaded image
function previewImage(index) {
    const fileInput = document.getElementById(`foto_bukti_${index}`);
    const preview = document.getElementById(`preview_${index}`);
    
    if (fileInput && fileInput.files && fileInput.files[0]) {
        const file = fileInput.files[0];
        
        // Validate file size (max 2MB)
        if (file.size > 2048000) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            fileInput.value = '';
            preview.style.display = 'none';
            return;
        }
        
        // Validate file type
        if (!['image/jpeg', 'image/jpg', 'image/png'].includes(file.type)) {
            alert('Format file tidak valid! Gunakan JPG atau PNG.');
            fileInput.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

// Form validation before submit
document.getElementById('presensiForm').addEventListener('submit', function(e) {
    const mahasiswaIds = document.querySelectorAll('input[name="mahasiswa_id[]"]');
    
    if (mahasiswaIds.length === 0) {
        e.preventDefault();
        alert('Tidak ada data mahasiswa untuk dipresensi. Silakan tampilkan data mahasiswa terlebih dahulu.');
        return false;
    }

    // Check if all radio buttons are checked
    let allChecked = true;
    const statusGroups = document.querySelectorAll('.status-radio-group');
    
    statusGroups.forEach((group, index) => {
        const radios = group.querySelectorAll('input[type="radio"]');
        const isChecked = Array.from(radios).some(radio => radio.checked);
        
        if (!isChecked) {
            allChecked = false;
        }
    });

    if (!allChecked) {
        e.preventDefault();
        alert('Pastikan semua mahasiswa sudah dipilih status presensinya.');
        return false;
    }

    // Validate foto bukti for sakit/izin status
    let missingFoto = false;
    statusGroups.forEach((group, index) => {
        const checkedRadio = group.querySelector('input[type="radio"]:checked');
        if (checkedRadio && (checkedRadio.value === 'sakit' || checkedRadio.value === 'izin')) {
            const fileInput = document.getElementById(`foto_bukti_${index}`);
            if (fileInput && !fileInput.files.length) {
                missingFoto = true;
            }
        }
    });

    if (missingFoto) {
        e.preventDefault();
        alert('Mahasiswa dengan status Sakit atau Izin wajib melampirkan foto bukti.');
        return false;
    }

    // Show loading
    document.getElementById('loadingOverlay').classList.add('active');
});
</script>
@endpush
