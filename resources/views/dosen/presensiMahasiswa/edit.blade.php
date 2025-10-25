@extends('layouts.dosen')

@section('title', 'Edit Presensi')

@push('styles')
<style>
    .edit-container {
        max-width: 700px;
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

    .status-radio-group {
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
    }

    .status-radio {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .status-radio input[type="radio"] {
        margin: 0;
        cursor: pointer;
        width: 18px;
        height: 18px;
    }

    .status-radio label {
        margin: 0;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
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

    .info-box {
        background-color: #f8f9fa;
        padding: 16px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .info-row {
        display: flex;
        padding: 8px 0;
    }

    .info-label {
        font-weight: 600;
        color: #666;
        width: 150px;
    }

    .info-value {
        flex: 1;
        color: #333;
    }

    .file-upload-wrapper {
        margin-top: 12px;
        padding: 16px;
        background-color: #f8f9fa;
        border-radius: 6px;
        border: 1px dashed #dee2e6;
        display: none;
    }

    .file-upload-wrapper.show {
        display: block;
    }

    .file-upload-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
        background-color: white;
    }

    .file-upload-input::-webkit-file-upload-button {
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: #e9ecef;
        cursor: pointer;
        margin-right: 10px;
    }

    .file-upload-input::-webkit-file-upload-button:hover {
        background-color: #dee2e6;
    }

    .file-info {
        margin-top: 6px;
        font-size: 12px;
        color: #6c757d;
    }

    .file-preview {
        margin-top: 12px;
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #dee2e6;
        display: none;
    }

    .current-foto {
        margin-top: 12px;
        max-width: 200px;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }
</style>
@endpush

@section('content')
<div class="edit-container">
    <div class="card-simple">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="card-title" style="margin: 0;">Edit Presensi Mahasiswa</h2>
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

        <div class="info-box">
            <h4 style="margin-bottom: 12px; color: #333;">Informasi Mahasiswa</h4>
            <div class="info-row">
                <div class="info-label">NIM</div>
                <div class="info-value">{{ $presensi->mahasiswa->nim }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Nama</div>
                <div class="info-value">{{ $presensi->mahasiswa->nama_lengkap }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Mata Kuliah</div>
                <div class="info-value">
                    <strong>{{ $presensi->mataKuliah->kode_matakuliah }}</strong> - {{ $presensi->mataKuliah->nama_matakuliah }}
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Waktu Presensi</div>
                <div class="info-value">{{ $presensi->waktu_presensi->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <form action="{{ route('dosen.presensiMahasiswa.update', $presensi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Status Presensi <span style="color: red;">*</span></label>
                <div class="status-radio-group">
                    <div class="status-radio status-hadir">
                        <input type="radio" name="status" value="hadir" id="status_hadir" 
                               {{ $presensi->status == 'hadir' ? 'checked' : '' }} required
                               onchange="toggleFotoUpload('hadir')">
                        <label for="status_hadir">Hadir</label>
                    </div>
                    <div class="status-radio status-izin">
                        <input type="radio" name="status" value="izin" id="status_izin" 
                               {{ $presensi->status == 'izin' ? 'checked' : '' }} required
                               onchange="toggleFotoUpload('izin')">
                        <label for="status_izin">Izin</label>
                    </div>
                    <div class="status-radio status-sakit">
                        <input type="radio" name="status" value="sakit" id="status_sakit" 
                               {{ $presensi->status == 'sakit' ? 'checked' : '' }} required
                               onchange="toggleFotoUpload('sakit')">
                        <label for="status_sakit">Sakit</label>
                    </div>
                    <div class="status-radio status-alpha">
                        <input type="radio" name="status" value="alpha" id="status_alpha" 
                               {{ $presensi->status == 'alpha' ? 'checked' : '' }} required
                               onchange="toggleFotoUpload('alpha')">
                        <label for="status_alpha">Alpha</label>
                    </div>
                </div>
                
                <div class="file-upload-wrapper {{ ($presensi->status == 'sakit' || $presensi->status == 'izin') ? 'show' : '' }}" id="upload_wrapper">
                    <label class="form-label" style="margin-bottom: 8px;">
                        Foto Bukti <span style="color: red;">*</span>
                    </label>
                    <input type="file" 
                           name="foto_bukti" 
                           id="foto_bukti"
                           class="file-upload-input" 
                           accept="image/jpeg,image/jpg,image/png"
                           onchange="previewImage()">
                    <div class="file-info">
                        <i class="fas fa-info-circle"></i> Maks. 2MB (JPG, PNG)
                    </div>
                    
                    @if($presensi->foto_bukti && ($presensi->status == 'sakit' || $presensi->status == 'izin'))
                        <div style="margin-top: 12px;">
                            <label style="font-size: 13px; font-weight: 600; color: #666; display: block; margin-bottom: 6px;">
                                Foto Saat Ini:
                            </label>
                            <a href="{{ asset('storage/' . $presensi->foto_bukti) }}" target="_blank">
                                <img src="{{ asset('storage/' . $presensi->foto_bukti) }}" 
                                     alt="Foto Bukti" 
                                     class="current-foto">
                            </a>
                            <div style="margin-top: 6px; font-size: 12px; color: #666;">
                                <i class="fas fa-info-circle"></i> Upload file baru jika ingin mengganti
                            </div>
                        </div>
                    @endif
                    
                    <img id="preview" class="file-preview" alt="Preview">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="4" 
                          placeholder="Tambahkan keterangan jika diperlukan (opsional)">{{ old('keterangan', $presensi->keterangan) }}</textarea>
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('dosen.presensiMahasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Function to toggle foto upload visibility
function toggleFotoUpload(status) {
    const uploadWrapper = document.getElementById('upload_wrapper');
    const fileInput = document.getElementById('foto_bukti');
    const preview = document.getElementById('preview');
    
    if (status === 'sakit' || status === 'izin') {
        uploadWrapper.classList.add('show');
    } else {
        uploadWrapper.classList.remove('show');
        // Clear file input and preview when hidden
        if (fileInput) fileInput.value = '';
        if (preview) preview.style.display = 'none';
    }
}

// Function to preview uploaded image
function previewImage() {
    const fileInput = document.getElementById('foto_bukti');
    const preview = document.getElementById('preview');
    
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
</script>
@endpush

@endsection
