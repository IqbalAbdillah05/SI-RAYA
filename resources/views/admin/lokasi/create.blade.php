@extends('layouts.admin')

@section('title', 'Tambah Lokasi Presensi')

@section('content')
<div class="lokasi-create">
    <!-- Header -->
    <div class="page-header">
        <h1>Tambah Lokasi Presensi</h1>
        <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">
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
        <form action="{{ route('admin.lokasi.store') }}" method="POST" id="lokasiForm">
            @csrf

            <div class="form-section">
                <h3>Informasi Lokasi</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Nama Lokasi <span class="required">*</span></label>
                        <input type="text" name="nama_lokasi" class="form-control" value="{{ old('nama_lokasi') }}" placeholder="Contoh: Kampus Utama, Gedung A, dll" required>
                        @error('nama_lokasi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Latitude <span class="required">*</span></label>
                        <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}" placeholder="-6.200000" step="any" required>
                        @error('latitude')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Contoh: -6.200000 (rentang: -90 sampai 90)</small>
                    </div>

                    <div class="form-group">
                        <label>Longitude <span class="required">*</span></label>
                        <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}" placeholder="106.816666" step="any" required>
                        @error('longitude')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Contoh: 106.816666 (rentang: -180 sampai 180)</small>
                    </div>

                    <div class="form-group full-width">
                        <label>Radius (meter) <span class="required">*</span></label>
                        <input type="number" name="radius" id="radius" class="form-control" value="{{ old('radius', 100) }}" placeholder="100" min="10" max="10000" required>
                        @error('radius')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Jarak maksimal dari lokasi untuk presensi (10-10000 meter)</small>
                    </div>
                </div>
            </div>

            <!-- Map Helper Section -->
            <div class="form-section">
                <h3><i class="fas fa-map-marked-alt"></i> Petunjuk Mendapatkan Koordinat</h3>
                <div class="map-helper">
                    <div class="helper-step">
                        <span class="step-number">1</span>
                        <div class="step-content">
                            <strong>Buka Google Maps</strong>
                            <p>Kunjungi <a href="https://www.google.com/maps" target="_blank">Google Maps</a></p>
                        </div>
                    </div>
                    <div class="helper-step">
                        <span class="step-number">2</span>
                        <div class="step-content">
                            <strong>Cari Lokasi</strong>
                            <p>Cari lokasi yang ingin Anda jadikan titik presensi</p>
                        </div>
                    </div>
                    <div class="helper-step">
                        <span class="step-number">3</span>
                        <div class="step-content">
                            <strong>Klik Kanan pada Peta</strong>
                            <p>Klik kanan pada titik lokasi, lalu pilih koordinat yang muncul untuk menyalin</p>
                        </div>
                    </div>
                    <div class="helper-step">
                        <span class="step-number">4</span>
                        <div class="step-content">
                            <strong>Paste Koordinat</strong>
                            <p>Format: Latitude, Longitude (contoh: -6.200000, 106.816666)</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-info" onclick="getCurrentLocation()">
                    <i class="fas fa-crosshairs"></i> Gunakan Lokasi Saat Ini
                </button>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
                <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    .lokasi-create {
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

    .btn-info {
        background: #17a2b8;
        color: white;
        margin-top: 10px;
    }

    .btn-info:hover {
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
        display: flex;
        align-items: center;
        gap: 8px;
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

    .form-text {
        color: #6c757d;
        font-size: 12px;
        margin-top: 3px;
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 3px;
    }

    /* Map Helper */
    .map-helper {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 15px;
    }

    .helper-step {
        display: flex;
        gap: 12px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 3px;
        border-left: 3px solid #007bff;
    }

    .step-number {
        width: 30px;
        height: 30px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        flex-shrink: 0;
    }

    .step-content strong {
        display: block;
        margin-bottom: 3px;
        color: #333;
        font-size: 14px;
    }

    .step-content p {
        margin: 0;
        color: #666;
        font-size: 13px;
    }

    .step-content a {
        color: #007bff;
        text-decoration: none;
    }

    .step-content a:hover {
        text-decoration: underline;
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

        .map-helper {
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
    // Get current location
    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude.toFixed(8);
                document.getElementById('longitude').value = position.coords.longitude.toFixed(8);
                alert('Lokasi berhasil didapatkan!');
            }, function(error) {
                alert('Gagal mendapatkan lokasi: ' + error.message);
            });
        } else {
            alert('Browser Anda tidak mendukung Geolocation');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('lokasiForm');
        
        form.addEventListener('submit', function(e) {
            const latitude = document.getElementById('latitude').value;
            const longitude = document.getElementById('longitude').value;
            const radius = document.getElementById('radius').value;

            // Validate latitude
            if (latitude < -90 || latitude > 90) {
                e.preventDefault();
                alert('Latitude harus antara -90 sampai 90');
                return false;
            }

            // Validate longitude
            if (longitude < -180 || longitude > 180) {
                e.preventDefault();
                alert('Longitude harus antara -180 sampai 180');
                return false;
            }

            // Validate radius
            if (radius < 10 || radius > 10000) {
                e.preventDefault();
                alert('Radius harus antara 10 sampai 10000 meter');
                return false;
            }
        });

        // Update radius display
        const radiusInput = document.getElementById('radius');
        if (radiusInput) {
            radiusInput.addEventListener('input', function() {
                console.log('Radius:', this.value + ' meter');
            });
        }
    });
</script>
@endpush
@endsection