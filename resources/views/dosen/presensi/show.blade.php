@extends('layouts.dosen')

@section('title', 'Detail Presensi')

@push('styles')
<style>
    .presensi-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .card-simple {
        background: white;
        border-radius: 8px;
        padding: 30px;
        margin-bottom: 20px;
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

    .detail-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #333;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e0e0e0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 12px;
        margin-bottom: 12px;
    }

    .info-label {
        font-weight: 600;
        color: #666;
    }

    .info-value {
        color: #333;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-hadir { 
        background-color: #e8f5e9; 
        color: #2e7d32; 
    }
    
    .status-izin { 
        background-color: #e3f2fd; 
        color: #1565c0; 
    }
    
    .status-sakit { 
        background-color: #fff3e0; 
        color: #e65100; 
    }
    
    .status-alpha { 
        background-color: #ffebee; 
        color: #c62828; 
    }

    .foto-container {
        margin-top: 16px;
        text-align: center;
    }

    .foto-presensi {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .map-container {
        margin-top: 16px;
        height: 300px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
    }

    .btn-primary {
        background-color: #1976d2;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
        margin-right: 8px;
    }

    .btn-primary:hover {
        background-color: #1565c0;
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background-color: #666;
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-secondary:hover {
        background-color: #555;
        color: white;
        text-decoration: none;
    }

    .button-group {
        display: flex;
        gap: 8px;
        margin-top: 24px;
        justify-content: center;
    }

    .no-data {
        color: #999;
        font-style: italic;
    }
</style>
@endpush

@section('content')
<div class="presensi-container">
    <div class="page-header">
        <h1 class="page-title">Detail Presensi</h1>
    </div>

    <div class="card-simple">
        <!-- Informasi Waktu -->
        <div class="detail-section">
            <h3 class="section-title">Informasi Waktu</h3>
            <div class="info-grid">
                <div class="info-label">Tanggal:</div>
                <div class="info-value">{{ $presensi->waktu_presensi->format('d F Y') }}</div>
            </div>
            <div class="info-grid">
                <div class="info-label">Waktu:</div>
                <div class="info-value">{{ $presensi->waktu_presensi->format('H:i:s') }} WIB</div>
            </div>
            <div class="info-grid">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $presensi->status }}">
                        {{ $presensi->status_formatted }}
                    </span>
                </div>
            </div>
            <div class="info-grid">
                <div class="info-label">Presensi:</div>
                <div class="info-value">{{ $presensi->presensi_ke ?? '-' }}</div>
            </div>
            <div class="info-grid">
                <div class="info-label">Waktu Presensi:</div>
                <div class="info-value">{{ $presensi->waktu_presensi->format('d M Y H:i') }}</div>
            </div>
        </div>

        <!-- Informasi Lokasi -->
        <div class="detail-section">
            <h3 class="section-title">Informasi Lokasi</h3>
            <div class="info-grid">
                <div class="info-label">Lokasi:</div>
                <div class="info-value">
                    @if($presensi->status === 'hadir')
                        {{ $presensi->lokasi->nama_lokasi }}
                    @else
                        Tidak Ditentukan (Status {{ ucfirst($presensi->status) }})
                    @endif
                </div>
            </div>
            <div class="info-grid">
                <div class="info-label">Koordinat:</div>
                <div class="info-value">
                    @if($presensi->status === 'hadir')
                        {{ number_format($presensi->latitude, 6) }}, 
                        {{ number_format($presensi->longitude, 6) }}
                    @else
                        -
                    @endif
                </div>
            </div>
            @if($presensi->status === 'hadir')
            <div class="info-grid">
                <div class="info-label">Jarak Masuk:</div>
                <div class="info-value">
                    {{ number_format($presensi->jarak_masuk, 2) }} meter
                </div>
            </div>
            @endif
        </div>

        <!-- Keterangan -->
        <div class="detail-section">
            <h3 class="section-title">Keterangan</h3>
            <div class="info-value">
                @if($presensi->keterangan)
                    {{ $presensi->keterangan }}
                @else
                    <span class="no-data">Tidak ada keterangan</span>
                @endif
            </div>
        </div>

        <!-- Foto Bukti -->
        @if($presensi->foto_bukti)
            <div class="detail-section">
                <h3 class="section-title">Foto Bukti</h3>
                <div class="foto-container">
                    <img src="{{ $presensi->foto_bukti_url }}" 
                         alt="Foto Presensi" 
                         class="foto-presensi">
                </div>
            </div>
        @endif

        <!-- Map (Opsional) -->
        @if($presensi->status === 'hadir' && $presensi->latitude && $presensi->longitude)
            <div class="detail-section">
                <h3 class="section-title">Lokasi pada Peta</h3>
                <div class="map-container">
                    <iframe 
                        width="100%" 
                        height="400" 
                        frameborder="0" 
                        style="border:0; border-radius: 3px;" 
                        src="https://maps.google.com/maps?q={{ $presensi->latitude }},{{ $presensi->longitude }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="button-group" style="display: flex; justify-content: flex-end; margin-top: 10px;">
                    <a href="https://www.google.com/maps?q={{ $presensi->latitude }},{{ $presensi->longitude }}" 
                       target="_blank"
                       class="btn-primary">
                        Lihat di Google Maps
                    </a>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="button-group" style="display: flex; justify-content: flex-end; margin-bottom: 15px;">
            <a href="{{ route('dosen.presensi.riwayat') }}" class="btn-secondary" style="margin-right: 0;">
                Kembali ke Riwayat
            </a>
        </div>
    </div>
</div>
@endsection