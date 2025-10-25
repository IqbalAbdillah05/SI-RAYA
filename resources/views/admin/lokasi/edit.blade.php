@extends('layouts.admin')

@section('title', 'Edit Lokasi Presensi')

@section('content')
<div class="lokasi-edit">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Lokasi Presensi</h1>
            <p class="subtitle">Perbarui informasi lokasi presensi</p>
        </div>
        <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            <strong>Terdapat kesalahan validasi:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <form action="{{ route('admin.lokasi.update', $lokasi) }}" method="POST" id="lokasiForm">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h3>Informasi Lokasi</h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Nama Lokasi <span class="required">*</span></label>
                        <input type="text" name="nama_lokasi" class="form-control" value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" placeholder="Contoh: Kampus Utama, Gedung A, dll" required>
                        @error('nama_lokasi')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Latitude <span class="required">*</span></label>
                        <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $lokasi->latitude) }}" placeholder="-6.200000" step="any" required>
                        @error('latitude')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Contoh: -6.200000 (rentang: -90 sampai 90)</small>
                    </div>

                    <div class="form-group">
                        <label>Longitude <span class="required">*</span></label>
                        <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $lokasi->longitude) }}" placeholder="106.816666" step="any" required>
                        @error('longitude')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Contoh: 106.816666 (rentang: -180 sampai 180)</small>
                    </div>

                    <div class="form-group full-width">
                        <label>Radius (meter) <span class="required">*</span></label>
                        <input type="number" name="radius" id="radius" class="form-control" value="{{ old('radius', $lokasi->radius) }}" placeholder="100" min="10" max="10000" required>
                        @error('radius')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <small class="form-text">Jarak maksimal dari lokasi untuk presensi (10-10000 meter)</small>
                    </div>
                </div>
            </div>

            <!-- Map Preview Section -->
            <div class="form-section">
                <h3>Preview Lokasi</h3>
                <div class="location-preview">
                    <div class="preview-info">
                        <div class="info-item">
                            <span class="info-label">Lokasi Saat Ini:</span>
                            <span class="info-value">{{ $lokasi->nama_lokasi }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Koordinat:</span>
                            <span class="info-value">{{ $lokasi->latitude }}, {{ $lokasi->longitude }}</span>
                        </div>
                    </div>
                    <div class="preview-actions">
                        <a href="https://www.google.com/maps?q={{ $lokasi->latitude }},{{ $lokasi->longitude }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-map-marker-alt"></i> Lihat di Google Maps
                        </a>
                        <button type="button" class="btn btn-success" onclick="getCurrentLocation()">
                            <i class="fas fa-crosshairs"></i> Update ke Lokasi Saat Ini
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.lokasi.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .lokasi-edit {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .header-left h1 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    /* Button */
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

    .btn-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-cancel {
        background: #6b7280;
        color: white;
    }

    .btn-cancel:hover {
        background: #4b5563;
    }

    .btn-info {
        background: #0ea5e9;
        color: white;
    }

    .btn-info:hover {
        background: #0284c7;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
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

    /* Form Container */
    .form-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .form-section {
        padding: 24px;
        border-bottom: 1px solid #f3f4f6;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 20px 0;
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

    .form-text {
        color: #6b7280;
        font-size: 12px;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        font-weight: 500;
    }

    /* Location Preview */
    .location-preview {
        padding: 16px;
        background: #f9fafb;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
    }

    .preview-info {
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .info-item {
        display: flex;
        gap: 8px;
        font-size: 14px;
    }

    .info-label {
        color: #6b7280;
        font-weight: 500;
    }

    .info-value {
        color: #1f2937;
        font-weight: 500;
    }

    .preview-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 20px 24px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .lokasi-edit {
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

        .form-section {
            padding: 20px 16px;
        }

        .preview-actions {
            flex-direction: column;
        }

        .preview-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .form-actions {
            flex-direction: column-reverse;
            padding: 16px;
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
                alert('Lokasi berhasil diupdate!');
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
            const latitude = parseFloat(document.getElementById('latitude').value);
            const longitude = parseFloat(document.getElementById('longitude').value);
            const radius = parseInt(document.getElementById('radius').value);

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
    });
</script>
@endpush
@endsection