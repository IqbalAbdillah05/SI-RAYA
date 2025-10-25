@extends('layouts.admin')

@section('title', 'Detail Lokasi Presensi')

@section('content')
<div class="lokasi-show">
    <!-- Header -->
    <div class="page-header">
        <h1>Detail Lokasi Presensi</h1>
        <div class="header-actions">
            <a href="{{ route('admin.lokasi.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Detail Container -->
    <div class="detail-container">
        <!-- Information Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Lokasi</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nama Lokasi</span>
                        <span class="detail-value">{{ $lokasi->nama_lokasi }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Latitude</span>
                        <span class="detail-value">{{ $lokasi->latitude }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Longitude</span>
                        <span class="detail-value">{{ $lokasi->longitude }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Radius</span>
                        <span class="detail-value">{{ $lokasi->radius }} meter</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Koordinat</span>
                        <span class="detail-value">{{ $lokasi->latitude }}, {{ $lokasi->longitude }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Dibuat Oleh</span>
                        <span class="detail-value">{{ $lokasi->pembuatUser->name ?? '-' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Tanggal Dibuat</span>
                        <span class="detail-value">{{ $lokasi->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Terakhir Diupdate</span>
                        <span class="detail-value">{{ $lokasi->updated_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Peta Lokasi</h3>
            </div>
            <div class="card-body">
                <div class="map-container">
                    <iframe 
                        width="100%" 
                        height="400" 
                        frameborder="0" 
                        style="border:0; border-radius: 6px;" 
                        src="https://maps.google.com/maps?q={{ $lokasi->latitude }},{{ $lokasi->longitude }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="map-actions">
                    <a href="https://www.google.com/maps?q={{ $lokasi->latitude }},{{ $lokasi->longitude }}" target="_blank" class="btn btn-info">
                        <i class="fas fa-external-link-alt"></i> Buka di Google Maps
                    </a>
                    <button type="button" class="btn btn-success" onclick="copyCoordinates()">
                        <i class="fas fa-copy"></i> Salin Koordinat
                    </button>
                </div>
            </div>
        </div>

        <!-- Radius Info Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Radius</h3>
            </div>
            <div class="card-body">
                <div class="radius-info">
                    <div class="radius-visual">
                        <div class="radius-circle">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $lokasi->radius }}m</span>
                        </div>
                    </div>
                    <div class="radius-description">
                        <p><strong>Radius Presensi:</strong> {{ $lokasi->radius }} meter</p>
                        <p>Dosen dapat melakukan presensi dalam jarak maksimal <strong>{{ $lokasi->radius }} meter</strong> dari titik koordinat yang telah ditentukan.</p>
                        <ul>
                            <li>Jarak diukur dari koordinat: {{ $lokasi->latitude }}, {{ $lokasi->longitude }}</li>
                            <li>Presensi akan berhasil jika berada dalam radius yang ditentukan</li>
                            <li>Sistem menggunakan GPS untuk mengukur jarak</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="{{ route('admin.lokasi.edit', $lokasi) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.lokasi.destroy', $lokasi) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
    .lokasi-show {
        max-width: 1000px;
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

    .page-header h1 {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
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
        background: #ffc107;
        color: #000 ;
    }

    .btn-primary:hover {
        background: #e0a800;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
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

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* Detail Container */
    .detail-container {
        display: grid;
        gap: 20px;
    }

    .detail-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: #f9fafb;
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
    }

    .card-body {
        padding: 20px;
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        font-size: 14px;
        color: #1f2937;
        font-weight: 500;
    }

    /* Map Container */
    .map-container {
        margin-bottom: 16px;
    }

    .map-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Radius Info */
    .radius-info {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 24px;
        align-items: start;
    }

    .radius-visual {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .radius-circle {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 3px dashed #3b82f6;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
    }

    .radius-circle i {
        font-size: 32px;
        color: #3b82f6;
        margin-bottom: 8px;
    }

    .radius-circle span {
        font-size: 18px;
        font-weight: 600;
        color: #3b82f6;
    }

    .radius-description p {
        margin: 0 0 12px 0;
        font-size: 14px;
        color: #374151;
        line-height: 1.6;
    }

    .radius-description ul {
        margin: 12px 0 0 0;
        padding-left: 20px;
    }

    .radius-description li {
        margin-bottom: 6px;
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
    }

    /* Action Section */
    .action-section {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .lokasi-show {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .map-actions {
            flex-direction: column;
        }

        .map-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .radius-info {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .action-section {
            flex-direction: column;
        }

        .action-section .btn,
        .action-section form {
            width: 100%;
        }

        .action-section .btn {
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function copyCoordinates() {
        const coordinates = '{{ $lokasi->latitude }}, {{ $lokasi->longitude }}';
        
        // Create temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = coordinates;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        alert('Koordinat berhasil disalin: ' + coordinates);
    }
</script>
@endpush
@endsection