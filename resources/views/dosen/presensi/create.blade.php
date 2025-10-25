@extends('layouts.dosen')

@section('title', 'Tambah Presensi')

@push('styles')
<style>
    .presensi-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .card-simple {
        background: white;
        border-radius: 8px;
        padding: 30px;
        border: 1px solid #e0e0e0;
    }

    .page-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e0e0e0;
    }

    .page-title {
        color: #333;
        font-size: 24px;
        font-weight: 600;
        margin: 0;
    }

    .info-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .info-warning {
        background-color: #fff3e0;
        color: #e65100;
        border: 1px solid #ffb74d;
    }

    .info-success {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #81c784;
    }

    .info-error {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #e57373;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d0d0d0;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #1976d2;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    }

    .form-control-file {
        display: block;
        width: 100%;
        padding: 8px 0;
        font-size: 14px;
    }

    .foto-preview {
        max-width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 12px;
        border: 1px solid #e0e0e0;
    }

    .btn-primary {
        background-color: #1976d2;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        width: 100%;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #1565c0;
    }

    .btn-primary:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }

    .btn-secondary {
        background-color: #666;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: background-color 0.2s;
    }

    .btn-secondary:hover {
        background-color: #555;
        color: white;
        text-decoration: none;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .button-group > * {
        flex: 1;
    }

    .help-text {
        font-size: 12px;
        color: #666;
        margin-top: 4px;
    }

    select.form-control {
        cursor: pointer;
    }

    #lokasiStatus {
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 16px;
        font-size: 14px;
        display: none;
    }

    .loading {
        display: inline-block;
        width: 14px;
        height: 14px;
        border: 2px solid #f3f3f3;
        border-top: 2px solid #1976d2;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 8px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .lokasi-info {
        background-color: #f5f5f5;
        padding: 12px;
        border-radius: 4px;
        margin-top: 8px;
        font-size: 13px;
        color: #666;
    }
</style>
@endpush

@section('content')
<div class="presensi-container">
    <div class="page-header">
        <h1 class="page-title">Form Presensi Dosen</h1>
        <p style="margin: 8px 0 0 0; color: #666;">
            Presensi ke-{{ $jumlahPresensiHariIni + 1 }} dari 2 hari ini
        </p>
    </div>

    <div class="card-simple">
        <div class="info-badge info-warning">
            ⚠️ <strong>Penting:</strong> Pastikan GPS Anda aktif dan Anda berada di lokasi yang ditentukan
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="lokasiStatus"></div>

        <form action="{{ route('dosen.presensi.store') }}" method="POST" enctype="multipart/form-data" id="formPresensi">
            @csrf

            <div class="form-group" id="lokasiGroup">
                <label for="lokasi_id" class="form-label">
                    Lokasi Presensi <span style="color: red;">*</span>
                </label>
                <select name="lokasi_id" id="lokasi_id" class="form-control" required>
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach($lokasi as $item)
                        <option value="{{ $item->id }}" 
                            data-lat="{{ $item->latitude }}"
                            data-lng="{{ $item->longitude }}"
                            data-radius="{{ $item->radius }}"
                            {{ (old('lokasi_id', $selectedLokasiId ?? '') == $item->id) ? 'selected' : '' }}>
                            {{ $item->nama_lokasi }} (Radius: {{ number_format($item->radius, 0) }}m)
                        </option>
                    @endforeach
                </select>
                <div class="help-text">Pilih lokasi tempat Anda melakukan presensi</div>
                <div id="lokasiInfo" class="lokasi-info" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">
                    Status Presensi <span style="color: red;">*</span>
                </label>
                <select name="status" id="status" class="form-control" required onchange="handleStatusChange()">
                    <option value="hadir" {{ old('status', 'hadir') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                </select>
                <div class="help-text" id="statusHelp">Status Hadir: Foto bukti tidak wajib</div>
            </div>

            <div class="form-group">
                <label for="keterangan" class="form-label">
                    Keterangan <span id="keteranganRequired" style="color: red; display: none;">*</span>
                </label>
                <textarea name="keterangan" 
                          id="keterangan" 
                          class="form-control" 
                          rows="4" 
                          placeholder="Berikan keterangan tambahan jika diperlukan">{{ old('keterangan') }}</textarea>
                <div class="help-text" id="keteranganHelp">Maksimal 500 karakter (opsional untuk status Hadir)</div>
            </div>

            <div class="form-group" id="fotoBuktiGroup">
                <label for="foto_bukti" class="form-label">
                    Foto Bukti Presensi <span id="fotoRequired" style="color: red; display: none;">*</span>
                </label>
                <input type="file" 
                       name="foto_bukti" 
                       id="foto_bukti" 
                       class="form-control-file" 
                       accept="image/jpeg,image/jpg,image/png"
                       onchange="previewImage(event)">
                <div class="help-text" id="fotoHelp">Format: JPG, JPEG, PNG. Maksimal 2MB. Wajib untuk status Izin/Sakit</div>
                <img id="preview" class="foto-preview" style="display:none;" alt="Preview">
            </div>

            <!-- Hidden fields untuk koordinat GPS -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            
            <!-- Hidden field untuk presensi_ke -->
            <input type="hidden" 
                   name="presensi_ke" 
                   id="presensi_ke" 
                   value="{{ $jumlahPresensiHariIni == 0 ? 'ke-1' : 'ke-2' }}"
            >

            <div class="button-group">
                <a href="{{ route('dosen.presensi.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary" id="btnSubmit" disabled>
                    <span id="btnText">Mengecek Lokasi...</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let userLat = null;
    let userLng = null;
    let lokasiValid = false;

    // Preview gambar
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }

    // Tampilkan status
    function showStatus(message, type) {
        const statusDiv = document.getElementById('lokasiStatus');
        statusDiv.style.display = 'block';
        statusDiv.className = 'info-badge info-' + type;
        statusDiv.innerHTML = message;
    }

    // Hitung jarak menggunakan formula Haversine
    function hitungJarak(lat1, lon1, lat2, lon2) {
        const R = 6371000; // Radius bumi dalam meter
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    // Validasi lokasi
    function validasiLokasi() {
        const lokasiSelect = document.getElementById('lokasi_id');
        const selectedOption = lokasiSelect.options[lokasiSelect.selectedIndex];
        const status = document.getElementById('status').value;
        
        // Untuk status izin/sakit, tidak perlu validasi lokasi
        if (status !== 'hadir') {
            lokasiValid = true;
            showStatus('✅ Lokasi akan dideteksi otomatis', 'success');
            document.getElementById('btnSubmit').disabled = false;
            document.getElementById('btnText').textContent = 'Simpan Presensi';
            return;
        }

        if (!selectedOption.value) {
            showStatus('Pilih lokasi terlebih dahulu', 'warning');
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnText').textContent = 'Pilih Lokasi';
            document.getElementById('lokasiInfo').style.display = 'none';
            return;
        }

        if (userLat === null || userLng === null) {
            showStatus('⏳ Menunggu GPS...', 'warning');
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnText').textContent = 'Menunggu GPS...';
            return;
        }

        const lokasiLat = parseFloat(selectedOption.dataset.lat);
        const lokasiLng = parseFloat(selectedOption.dataset.lng);
        const radius = parseFloat(selectedOption.dataset.radius);

        // Hitung jarak
        const jarak = hitungJarak(userLat, userLng, lokasiLat, lokasiLng);

        // Tampilkan info lokasi
        const lokasiInfo = document.getElementById('lokasiInfo');
        lokasiInfo.style.display = 'block';
        lokasiInfo.innerHTML = `
            <strong>📍 Informasi Lokasi:</strong><br>
            Jarak Anda dari lokasi: <strong>${jarak.toFixed(2)} meter</strong><br>
            Radius yang diizinkan: <strong>${radius} meter</strong>
        `;

        // Validasi jarak
        if (jarak <= radius) {
            lokasiValid = true;
            showStatus('✅ Lokasi Valid! Anda berada dalam radius yang diizinkan', 'success');
            document.getElementById('btnSubmit').disabled = false;
            document.getElementById('btnText').textContent = 'Simpan Presensi';
        } else {
            lokasiValid = false;
            showStatus(`❌ Untuk status Hadir, Anda harus berada dalam radius lokasi! (${jarak.toFixed(2)}m dari lokasi)`, 'error');
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnText').textContent = 'Lokasi Tidak Valid';
        }
    }

    // Get lokasi GPS user
    if (navigator.geolocation) {
        showStatus('<span class="loading"></span> Mendapatkan lokasi GPS Anda...', 'warning');
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                
                document.getElementById('latitude').value = userLat;
                document.getElementById('longitude').value = userLng;
                
                showStatus('✅ GPS berhasil diaktifkan. Silakan pilih lokasi presensi.', 'success');
                
                // Validasi jika lokasi sudah dipilih
                if (document.getElementById('lokasi_id').value) {
                    validasiLokasi();
                } else {
                    document.getElementById('btnSubmit').disabled = false;
                    document.getElementById('btnText').textContent = 'Pilih Lokasi Terlebih Dahulu';
                }
            },
            function(error) {
                let errorMsg = '';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMsg = 'Anda menolak akses lokasi. Harap izinkan akses GPS.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMsg = 'Informasi lokasi tidak tersedia.';
                        break;
                    case error.TIMEOUT:
                        errorMsg = 'Waktu permintaan lokasi habis.';
                        break;
                    default:
                        errorMsg = 'Terjadi kesalahan saat mendapatkan lokasi.';
                }
                showStatus('❌ ' + errorMsg, 'error');
                document.getElementById('btnSubmit').disabled = true;
                document.getElementById('btnText').textContent = 'GPS Tidak Aktif';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );

        // Update lokasi setiap 5 detik
        setInterval(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        userLat = position.coords.latitude;
                        userLng = position.coords.longitude;
                        document.getElementById('latitude').value = userLat;
                        document.getElementById('longitude').value = userLng;
                        
                        // Validasi ulang jika lokasi sudah dipilih
                        if (document.getElementById('lokasi_id').value) {
                            validasiLokasi();
                        }
                    },
                    function(error) {
                        console.log('Error updating location:', error);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                );
            }
        }, 5000);
    } else {
        showStatus('❌ Browser Anda tidak mendukung GPS', 'error');
        document.getElementById('btnSubmit').disabled = true;
        document.getElementById('btnText').textContent = 'GPS Tidak Didukung';
    }

    // Event listener untuk perubahan lokasi
    document.getElementById('lokasi_id').addEventListener('change', function() {
        validasiLokasi();
    });

    // Validasi sebelum submit
    document.getElementById('formPresensi').addEventListener('submit', function(e) {
        // Untuk status hadir, validasi lokasi
        if (document.getElementById('status').value === 'hadir') {
            if (!lokasiValid) {
                e.preventDefault();
                alert('Anda tidak berada dalam radius lokasi yang valid!');
                return false;
            }
        }

        // Hapus validasi foto bukti untuk status hadir
        if (document.getElementById('status').value !== 'hadir' && !document.getElementById('foto_bukti').files.length) {
            e.preventDefault();
            alert('Foto bukti presensi wajib diunggah untuk status Izin/Sakit!');
            return false;
        }

        // Tambahkan loading state
        const btnSubmit = document.getElementById('btnSubmit');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="loading"></span> Menyimpan...';
    });

    // Tampilkan petunjuk status
    function handleStatusChange() {
        const status = document.getElementById('status').value;
        const statusHelp = document.getElementById('statusHelp');
        const fotoHelp = document.getElementById('fotoHelp');
        const keteranganHelp = document.getElementById('keteranganHelp');
        const lokasiGroup = document.getElementById('lokasiGroup');
        const lokasiInfo = document.getElementById('lokasiInfo');

        if (status === 'hadir') {
            statusHelp.textContent = 'Status Hadir: Foto bukti tidak wajib';
            fotoHelp.textContent = 'Format: JPG, JPEG, PNG. Maksimal 2MB. Wajib untuk status Izin/Sakit';
            keteranganHelp.textContent = 'Maksimal 500 karakter (opsional untuk status Hadir)';
            
            // Lokasi wajib untuk status hadir
            lokasiGroup.style.display = 'block';
            document.getElementById('lokasi_id').required = true;
            lokasiInfo.style.display = 'block';
        } else {
            statusHelp.textContent = 'Status Izin/Sakit: Foto bukti dan keterangan wajib';
            fotoHelp.textContent = 'Format: JPG, JPEG, PNG. Maksimal 2MB. WAJIB untuk status Izin/Sakit';
            keteranganHelp.textContent = 'Keterangan wajib diisi untuk status Izin/Sakit';
            
            // Lokasi tidak wajib untuk status izin/sakit
            lokasiGroup.style.display = 'none';
            document.getElementById('lokasi_id').required = false;
            lokasiInfo.style.display = 'none';
        }
    }

    // Panggil fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', handleStatusChange);

    // Tambahkan event listener untuk perubahan status
    document.getElementById('status').addEventListener('change', handleStatusChange);
</script>
@endpush