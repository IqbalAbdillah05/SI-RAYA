@extends('layouts.dosen')

@section('title', 'Detail Presensi')

@push('styles')
<style>
    .detail-container {
        max-width: 800px;
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

    .detail-row {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .detail-label {
        font-weight: 600;
        color: #666;
        width: 200px;
    }

    .detail-value {
        flex: 1;
        color: #333;
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

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-success {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background-color: #fff3cd;
        color: #856404;
    }

    .badge-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .badge-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
@endpush

@section('content')
<div class="detail-container">
    <div class="card-simple">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="card-title" style="margin: 0;">Detail Presensi Mahasiswa</h2>
            <a href="{{ route('dosen.presensiMahasiswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="detail-row">
            <div class="detail-label">NIM</div>
            <div class="detail-value">{{ $presensi->mahasiswa->nim }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Nama Mahasiswa</div>
            <div class="detail-value">{{ $presensi->mahasiswa->nama_lengkap }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Program Studi</div>
            <div class="detail-value">{{ $presensi->prodi->nama_prodi }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Semester</div>
            <div class="detail-value">{{ $presensi->semester }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Mata Kuliah</div>
            <div class="detail-value">
                <strong>{{ $presensi->mataKuliah->kode_matakuliah }}</strong> - {{ $presensi->mataKuliah->nama_matakuliah }}
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Dosen</div>
            <div class="detail-value">{{ $presensi->dosen->nama_lengkap }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Waktu Presensi</div>
            <div class="detail-value">{{ $presensi->waktu_presensi->format('d/m/Y H:i:s') }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                @if($presensi->status == 'hadir')
                    <span class="badge badge-success">Hadir</span>
                @elseif($presensi->status == 'izin')
                    <span class="badge badge-info">Izin</span>
                @elseif($presensi->status == 'sakit')
                    <span class="badge badge-warning">Sakit</span>
                @else
                    <span class="badge badge-danger">Alpha</span>
                @endif
            </div>
        </div>

        @if($presensi->keterangan)
        <div class="detail-row">
            <div class="detail-label">Keterangan</div>
            <div class="detail-value">{{ $presensi->keterangan }}</div>
        </div>
        @endif

        @if($presensi->foto_bukti && ($presensi->status == 'sakit' || $presensi->status == 'izin'))
        <div class="detail-row">
            <div class="detail-label">Foto Bukti</div>
            <div class="detail-value">
                <a href="{{ asset('storage/' . $presensi->foto_bukti) }}" target="_blank">
                    <img src="{{ asset('storage/' . $presensi->foto_bukti) }}" 
                         alt="Foto Bukti" 
                         style="max-width: 300px; max-height: 300px; border-radius: 8px; border: 2px solid #ddd; cursor: pointer;">
                </a>
                <div style="margin-top: 8px; font-size: 12px; color: #666;">
                    <i class="fas fa-info-circle"></i> Klik gambar untuk memperbesar
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
