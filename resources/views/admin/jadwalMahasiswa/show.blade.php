@extends('layouts.admin')

@section('title', 'Detail Jadwal')

@section('content')
<div class="jadwal-show">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Detail Jadwal</h1>
        </div>
        <a href="{{ route('admin.jadwal-mahasiswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="detail-container">
        <div class="main-content">
            <!-- Informasi Mata Kuliah Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Informasi Mata Kuliah</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Kode Mata Kuliah</span>
                            <span class="detail-value">{{ $jadwal->mataKuliah->kode_matakuliah ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Nama Mata Kuliah</span>
                            <span class="detail-value">{{ $jadwal->mataKuliah->nama_matakuliah ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Dosen Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Informasi Dosen</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">NIDN</span>
                            <span class="detail-value">{{ $jadwal->dosen->nidn ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Nama Dosen</span>
                            <span class="detail-value">{{ $jadwal->dosen->nama_lengkap ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Program Studi Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Program Studi</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Kode Prodi</span>
                            <span class="detail-value">{{ $jadwal->prodi->kode_prodi ?? '-' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Nama Program Studi</span>
                            <span class="detail-value">{{ $jadwal->prodi->nama_prodi ?? '-' }}</span>
                        </div>
                        <div class="detail-item full-width">
                            <span class="detail-label">Jenjang</span>
                            <span class="badge badge-jenjang">{{ $jadwal->prodi->jenjang ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Waktu & Tempat Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Waktu & Tempat</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Hari</span>
                            <span class="badge badge-hari">{{ $jadwal->hari }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Jam Mulai</span>
                            <span class="detail-value">{{ date('H:i', strtotime($jadwal->jam_mulai)) }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Jam Selesai</span>
                            <span class="detail-value">{{ date('H:i', strtotime($jadwal->jam_selesai)) }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Ruang</span>
                            <span class="detail-value">{{ $jadwal->ruang ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Periode Akademik Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Periode Akademik</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Semester</span>
                            <span class="badge badge-semester">{{ $jadwal->semester }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Tahun Ajaran</span>
                            <span class="detail-value">{{ $jadwal->tahun_ajaran }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Sistem Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Informasi Sistem</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Dibuat Pada</span>
                            <span class="detail-value">{{ $jadwal->created_at->format('d F Y, H:i') }} WIB</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Terakhir Diupdate</span>
                            <span class="detail-value">{{ $jadwal->updated_at->format('d F Y, H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="{{ route('admin.jadwal-mahasiswa.edit', $jadwal->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.jadwal-mahasiswa.destroy', $jadwal->id) }}" 
              method="POST" 
              style="display: inline;"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
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
    * {
        box-sizing: border-box;
    }

    .jadwal-show {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px;
        font-family: 'Nunito', sans-serif;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .header-left h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    /* Buttons */
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

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-primary {
        background: #ffc107;
        color: #000;
    }

    .btn-primary:hover {
        background: #e0a800;
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
        border: 1px solid #e5e7eb;
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

    .detail-item.full-width {
        grid-column: 1 / -1;
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

    /* Badges */
    .badge {
        display: inline-block;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 4px;
        white-space: nowrap;
    }

    .badge-hari {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-semester {
        background: #d4edda;
        color: #155724;
    }

    .badge-jenjang {
        background: #fff3cd;
        color: #856404;
    }

    /* Action Section */
    .action-section {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f9fafb;
        padding: 16px;
        border-top: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .jadwal-show {
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