@extends('layouts.admin')

@section('title', 'Detail Kartu Hasil Studi (KHS)')

@section('content')
<div class="khs-detail">
    <!-- Header -->
    <div class="page-header">
        <h1>Detail Kartu Hasil Studi (KHS)</h1>
        <div class="header-actions">
            <a href="{{ route('admin.khs.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Informasi Mahasiswa -->
    <div class="info-card">
        <h3>Informasi Mahasiswa</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <strong>Nama Lengkap</strong>
                <span>{{ $khs->mahasiswa->nama_lengkap }}</span>
            </div>
            <div class="detail-item">
                <strong>NIM</strong>
                <span>{{ $khs->mahasiswa->nim }}</span>
            </div>
            <div class="detail-item">
                <strong>Program Studi</strong>
                <span>{{ $khs->prodi->nama_prodi }}</span>
            </div>
            <div class="detail-item">
                <strong>Semester</strong>
                <span>Semester {{ $khs->semester }}</span>
            </div>
            <div class="detail-item">
                <strong>Tahun Ajaran</strong>
                <span>{{ $khs->tahun_ajaran }}</span>
            </div>
            <div class="detail-item">
                <strong>Status Validasi</strong>
                <span class="badge badge-{{ 
                    $khs->status_validasi == 'Disetujui' ? 'success' : 
                    ($khs->status_validasi == 'Ditolak' ? 'danger' : 'warning') 
                }}">
                    {{ $khs->status_validasi }}
                </span>
            </div>
        </div>
    </div>

    <!-- Detail Mata Kuliah -->
    <div class="info-card">
        <h3>Detail Mata Kuliah</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Nilai Angka</th>
                    <th>Nilai Huruf</th>
                    <th>Nilai Indeks</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalSks = 0;
                    $totalNilaiIndeks = 0;
                @endphp
                @foreach($khs->details as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->mataKuliah->kode_matakuliah }}</td>
                    <td>{{ $detail->mataKuliah->nama_matakuliah }}</td>
                    <td>{{ $detail->sks }}</td>
                    <td>{{ $detail->nilai_angka }}</td>
                    <td>{{ $detail->nilai_huruf }}</td>
                    <td>{{ $detail->nilai_indeks }}</td>
                </tr>
                @php
                    $totalSks += $detail->sks;
                    $totalNilaiIndeks += $detail->nilai_indeks * $detail->sks;
                @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                    <td>{{ $totalSks }}</td>
                    <td colspan="2" class="text-right"><strong>IPS</strong></td>
                    <td>{{ $totalSks > 0 ? round($totalNilaiIndeks / $totalSks, 2) : 0 }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Validasi KHS -->
    @if($khs->status_validasi == 'Menunggu')
    <div class="info-card">
        <h3>Validasi KHS</h3>
        <form action="{{ route('admin.khs.validate', $khs) }}" method="POST">
            @csrf
            <div class="form-actions">
                <button type="submit" name="status_validasi" value="Disetujui" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui
                </button>
                <button type="submit" name="status_validasi" value="Ditolak" class="btn btn-danger">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="{{ route('admin.khs.edit', $khs) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.khs.destroy', $khs) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus KHS ini?')">
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
    .khs-detail {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px;
        font-family: 'Nunito', sans-serif;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

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
        background: #ffc107;
        color: #000 ;
    }

    .btn-primary:hover {
        background: #e0a800;
    }

    .btn-warning {
        background: #ffc107;
        color: #000;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .info-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }

    .info-card h3 {
        background: #f8f9fa;
        padding: 12px 15px;
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        border-bottom: 1px solid #ddd;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        padding: 15px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-item strong {
        color: #666;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .detail-item span {
        color: #333;
        font-size: 15px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .data-table th, .data-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .data-table thead {
        background: #f8f9fa;
        font-weight: 600;
    }

    .data-table tfoot {
        font-weight: 600;
        background: #f8f9fa;
    }

    .text-right {
        text-align: right;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        padding: 15px;
    }

    /* Action Section */
    .action-section {
        max-width: 1000px;
        margin: 24px auto;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f9fafb;
        padding: 16px;
        border-top: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .khs-detail {
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

        .action-section {
            flex-direction: column;
            gap: 10px;
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
@endsection
