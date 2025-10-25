@extends('layouts.dosen')

@section('title', 'Detail Nilai Mahasiswa')

@push('styles')
<style>
    .nilai-container {
        max-width: 900px;
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

    .detail-group {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e0e0e0;
    }

    .detail-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-label {
        font-size: 13px;
        font-weight: 600;
        color: #666;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }

    .nilai-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 18px;
        font-weight: 700;
    }

    .nilai-a {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .nilai-b {
        background-color: #e3f2fd;
        color: #1565c0;
    }

    .nilai-c {
        background-color: #fff3e0;
        color: #e65100;
    }

    .nilai-d {
        background-color: #ffebee;
        color: #c62828;
    }

    .nilai-e {
        background-color: #f3e5f5;
        color: #6a1b9a;
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
        margin-right: 8px;
    }

    .btn-primary {
        background-color: #1976d2;
        color: white;
    }

    .btn-primary:hover {
        background-color: #1565c0;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #333;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .info-header {
        background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
        color: white;
        padding: 24px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .info-header h2 {
        margin: 0 0 8px 0;
        font-size: 24px;
    }

    .info-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 10px;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="nilai-container">
    <div class="info-header">
        <h2>Detail Nilai Mahasiswa</h2>
        <p>Informasi lengkap nilai yang telah diinput</p>
    </div>

    <div class="card-simple">
        <h3 class="card-title">Informasi Mahasiswa</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">NIM</div>
                    <div class="detail-value">{{ $nilai->mahasiswa->nim ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Nama Lengkap</div>
                    <div class="detail-value">{{ $nilai->mahasiswa->nama_lengkap ?? '-' }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Program Studi</div>
                    <div class="detail-value">{{ $nilai->prodi->nama_prodi ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Semester</div>
                    <div class="detail-value">Semester {{ $nilai->semester }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-simple">
        <h3 class="card-title">Informasi Mata Kuliah</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Kode Mata Kuliah</div>
                    <div class="detail-value">{{ $nilai->mataKuliah->kode_matakuliah ?? '-' }}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Nama Mata Kuliah</div>
                    <div class="detail-value">{{ $nilai->mataKuliah->nama_matakuliah ?? '-' }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">SKS</div>
                    <div class="detail-value">{{ $nilai->mataKuliah->sks ?? '-' }} SKS</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Tahun Ajaran</div>
                    <div class="detail-value">{{ $nilai->tahun_ajaran }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-simple">
        <h3 class="card-title">Nilai</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Nilai Angka</div>
                    <div class="detail-value" style="font-size: 32px; font-weight: 700; color: #1976d2;">
                        {{ number_format($nilai->nilai_angka, 2) }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="detail-group">
                    <div class="detail-label">Nilai Huruf</div>
                    <div>
                        <span class="nilai-badge nilai-{{ strtolower(substr($nilai->nilai_huruf, 0, 1)) }}">
                            {{ $nilai->nilai_huruf }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail-group">
            <div class="detail-label">Indeks Nilai</div>
            <div class="detail-value">{{ $nilai->indeks_nilai }}</div>
        </div>
    </div>

    <div class="card-simple">
        <h3 class="card-title">Informasi Dosen</h3>
        <div class="detail-group">
            <div class="detail-label">Dosen Pengampu</div>
            <div class="detail-value">{{ $nilai->dosen->nama_lengkap ?? '-' }}</div>
        </div>
    </div>

    <div class="card-simple" style="background-color: #f8f9fa; border: none;">
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('dosen.inputNilai.edit', $nilai->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Nilai
            </a>
            <a href="{{ route('dosen.inputNilai.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection