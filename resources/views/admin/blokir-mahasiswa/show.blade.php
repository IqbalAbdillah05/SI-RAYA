@extends('layouts.admin')

@section('title', 'Detail Blokir Mahasiswa')

@section('content')
<div class="blokir-mahasiswa-detail">
    <!-- Header -->
    <div class="page-header">
        <h1>Detail Blokir Mahasiswa</h1>
        <div class="header-actions">
            <a href="{{ route('admin.blokir-mahasiswa.index') }}" class="btn btn-secondary">
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
                <span>{{ $blokirMahasiswa->mahasiswa->nama_lengkap }}</span>
            </div>
            <div class="detail-item">
                <strong>NIM</strong>
                <span>{{ $blokirMahasiswa->mahasiswa->nim }}</span>
            </div>
            <div class="detail-item">
                <strong>Program Studi</strong>
                <span>{{ $blokirMahasiswa->prodi->nama_prodi }}</span>
            </div>
            <div class="detail-item">
                <strong>Semester</strong>
                <span>Semester {{ $blokirMahasiswa->semester ?? 'Tidak Ditentukan' }}</span>
            </div>
            <div class="detail-item">
                <strong>Tahun Ajaran</strong>
                <span>{{ $blokirMahasiswa->tahun_ajaran ?? 'Tidak Ditentukan' }}</span>
            </div>
            <div class="detail-item">
                <strong>Status Blokir</strong>
                <span class="badge badge-{{ 
                    $blokirMahasiswa->status_blokir == 'Dibuka' ? 'success' : 'danger' 
                }}">
                    {{ $blokirMahasiswa->status_blokir }}
                </span>
            </div>
        </div>
    </div>

    <!-- Detail Pemblokiran -->
    <div class="info-card">
        <h3>Detail Pemblokiran</h3>
        <div class="detail-grid">
            <div class="detail-item full-width">
                <strong>Keterangan</strong>
                <span>{{ $blokirMahasiswa->keterangan ?? 'Tidak ada keterangan' }}</span>
            </div>
            <div class="detail-item">
                <strong>Tanggal Blokir</strong>
                <span>{{ $blokirMahasiswa->tanggal_blokir->format('d F Y') }}</span>
            </div>
            <div class="detail-item">
                <strong>Admin yang Memblokir</strong>
                <span>{{ $blokirMahasiswa->admin->name ?? 'Tidak diketahui' }}</span>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="{{ route('admin.blokir-mahasiswa.edit', $blokirMahasiswa) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.blokir-mahasiswa.destroy', $blokirMahasiswa) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pemblokiran ini?')">
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
    .blokir-mahasiswa-detail {
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

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn:hover {
        opacity: 0.9;
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

    .detail-item.full-width {
        grid-column: 1 / -1;
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
        .blokir-mahasiswa-detail {
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
