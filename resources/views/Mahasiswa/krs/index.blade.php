@extends('layouts.mahasiswa')

@section('title', 'Kartu Rencana Studi (KRS)')

@section('content')

    <div class="card-info" style="background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); border: none; padding: 24px; border-radius: 12px; margin-bottom: 20px; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">
                    <i class="fas fa-list-alt"></i> Kartu Rencana Studi (KRS)
                </h4>
                <p style="margin: 0; opacity: 0.95; font-size: 14px;">
                    Daftar KRS yang telah diisi
                </p>
            </div>
            <a href="{{ route('mahasiswa.krs.create') }}" class="btn-download" style="background: white; color: #0B6623; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;">
                <i class="fas fa-plus"></i>
                Isi KRS Baru
            </a>
        </div>
    </div>


    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($krsList->count() > 0)
        <div class="card-simple" style="padding: 0;">
            @foreach($krsList as $krs)
                <div class="krs-card">
                    <div class="krs-info">
                        <div>
                            <h5 class="mb-1">
                                <i class="fas fa-book me-2"></i>Semester {{ $krs->semester }}
                            </h5>
                            <div class="info-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Tahun Ajaran: <strong>{{ $krs->tahun_ajaran }}</strong></span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-clock"></i>
                                <span>Tanggal Pengisian: <strong>{{ \Carbon\Carbon::parse($krs->tanggal_pengisian)->format('d M Y') }}</strong></span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-book-open"></i>
                                <span>Jumlah Mata Kuliah: <strong>{{ $krs->details->count() }} MK</strong></span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="sks-badge mb-2">
                                <i class="fas fa-graduation-cap me-1"></i>
                                                                    @php
                                        $totalSks = $krs->details->sum(function($detail) {
                                            return $detail->mataKuliah->sks ?? 0;
                                        });
                                    @endphp
                            </div>
                            @if($krs->status_validasi == 'Menunggu')
                                <span class="krs-badge badge-pending">
                                    <i class="fas fa-clock me-1"></i>Menunggu Validasi
                                </span>
                            @elseif($krs->status_validasi == 'Disetujui')
                                <span class="krs-badge badge-approved">
                                    <i class="fas fa-check-circle me-1"></i>Disetujui
                                </span>
                            @else
                                <span class="krs-badge badge-rejected">
                                    <i class="fas fa-times-circle me-1"></i>Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="krs-actions">
                        <a href="{{ route('mahasiswa.krs.show', $krs->id) }}" class="btn-action btn-view">
                            <i class="fas fa-eye"></i>
                            <span>Lihat Detail</span>
                        </a>
                        
                        @if($krs->status_validasi != 'Disetujui')
                            <a href="{{ route('mahasiswa.krs.edit', $krs->id) }}" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </a>
                            
                            <form action="{{ route('mahasiswa.krs.destroy', $krs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus KRS ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card-simple">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Belum Ada KRS</h3>
                <p>Anda belum mengisi KRS. Silakan klik tombol di atas untuk mengisi KRS.</p>
            </div>
        </div>
    @endif

@push('styles')
<style>
    .krs-card {
        background: white;
        padding: 20px;
        border-bottom: 1px solid #e0e0e0;
        transition: all 0.2s;
    }
    
    .krs-card:first-child {
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    
    .krs-card:last-child {
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        border-bottom: none;
    }
    
    .krs-card:hover {
        background-color: #f8f9fa;
    }
    
    .krs-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .krs-info h5 {
        color: #0B6623;
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 8px 0;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.3rem;
        color: #64748b;
        font-size: 14px;
    }
    
    .info-item i {
        color: #0B6623;
        width: 20px;
        text-align: center;
    }
    
    .sks-badge {
        background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 15px;
        display: inline-block;
    }
    
    .krs-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .badge-approved {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-rejected {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .krs-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .btn-action {
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 13px;
        font-weight: 500;
    }
    
    .btn-view {
        background-color: #3b82f6;
        color: white;
    }
    
    .btn-view:hover {
        background-color: #2563eb;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-edit {
        background-color: #f59e0b;
        color: white;
    }
    
    .btn-edit:hover {
        background-color: #d97706;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-delete {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-delete:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }
    
    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Empty State - sama seperti KHS */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 64px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 20px;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 8px;
    }
    
    .card-simple {
        background: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }
    
    .alert {
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }
    
    .alert-success {
        background-color: #d1fae5;
        border-color: #a7f3d0;
        color: #065f46;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        border-color: #fecaca;
        color: #991b1b;
    }
    
    @media (max-width: 768px) {
        .krs-info {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .krs-actions {
            width: 100%;
        }
        
        .btn-action {
            flex: 1;
            justify-content: center;
        }
    }
</style>
@endpush
@endsection
