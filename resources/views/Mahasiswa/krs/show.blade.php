@extends('layouts.mahasiswa')

@section('title', 'Detail KRS')

@section('content')

    <div class="card-info" style="background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); border: none; padding: 24px; border-radius: 12px; margin-bottom: 20px; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">
                    <i class="fas fa-file-alt"></i> Detail KRS
                </h4>
                <p style="margin: 0; opacity: 0.95; font-size: 14px;">
                    Semester {{ $krs->semester }} - Tahun Ajaran {{ $krs->tahun_ajaran }}
                </p>
            </div>
            <div style="display: flex; gap: 8px;">
                @if($krs->status_validasi != 'Disetujui')
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Info Mahasiswa -->
            <div class="card-simple">
                <h5 class="mb-3" style="color: #0B6623; font-weight: 600;">
                    <i class="fas fa-user me-2"></i>Informasi Mahasiswa
                </h5>
                
                <div class="info-grid-krs">
                    <div class="info-row-krs">
                        <div class="info-label-krs">NIM</div>
                        <div class="info-value-krs">{{ $mahasiswa->nim }}</div>
                    </div>
                    <div class="info-row-krs">
                        <div class="info-label-krs">Nama</div>
                        <div class="info-value-krs">{{ $mahasiswa->nama_lengkap }}</div>
                    </div>
                    <div class="info-row-krs">
                        <div class="info-label-krs">Program Studi</div>
                        <div class="info-value-krs">{{ $mahasiswa->prodi->nama_prodi ?? '-' }}</div>
                    </div>
                    <div class="info-row-krs">
                        <div class="info-label-krs">Semester</div>
                        <div class="info-value-krs">{{ $krs->semester }}</div>
                    </div>
                    <div class="info-row-krs">
                        <div class="info-label-krs">Tahun Ajaran</div>
                        <div class="info-value-krs">{{ $krs->tahun_ajaran }}</div>
                    </div>
                    <div class="info-row-krs">
                        <div class="info-label-krs">Tanggal Pengisian</div>
                        <div class="info-value-krs">{{ \Carbon\Carbon::parse($krs->tanggal_pengisian)->format('d F Y') }}</div>
                    </div>
                    <div class="info-row-krs">
                        <div class="info-label-krs">Status Validasi</div>
                        <div class="info-value-krs">
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
                </div>
            </div>

            <!-- Table Mata Kuliah -->
            <div class="card-simple" style="padding: 0;">
                <div style="padding: 24px; background: linear-gradient(135deg, #e8f5ec 0%, #d4edda 100%); border-bottom: 1px solid #e0e0e0;">
                    <h5 style="margin: 0; color: #0B6623; font-weight: 600;">
                        <i class="fas fa-list me-2"></i>Daftar Mata Kuliah
                    </h5>
                </div>
                
                <div style="padding: 24px; overflow-x: auto;">
                    <table class="khs-table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">Kode MK</th>
                                <th style="width: 50%;">Mata Kuliah</th>
                                <th style="width: 15%;">SKS</th>
                                <th style="width: 10%;">Semester</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($krs->details as $index => $detail)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td><strong>{{ $detail->mataKuliah->kode_matakuliah ?? '-' }}</strong></td>
                                    <td>{{ $detail->mataKuliah->nama_matakuliah ?? '-' }}</td>
                                    <td class="text-center">
                                        <span class="badge-nilai" style="background-color: #d4edda; color: #155724; padding: 4px 12px; border-radius: 12px; font-weight: 600;">
                                            {{ $detail->mataKuliah->sks ?? 0 }} SKS
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $detail->mataKuliah->semester ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="total-row">
                                <td colspan="3" class="text-right"><strong>Total</strong></td>
                                <td class="text-center"><strong>{{ $totalSks }} SKS</strong></td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('mahasiswa.krs.index') }}" class="btn-action-krs btn-secondary-show">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                
                @if($krs->status_validasi != 'approved')
                    <a href="{{ route('mahasiswa.krs.edit', $krs->id) }}" class="btn-action-krs btn-edit-show">
                        <i class="fas fa-edit"></i>
                        <span>Edit KRS</span>
                    </a>
                    
                    <form action="{{ route('mahasiswa.krs.destroy', $krs->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus KRS ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action-krs btn-delete-show">
                            <i class="fas fa-trash"></i>
                            <span>Hapus KRS</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="total-card-show">
                <h4><i class="fas fa-calculator me-2"></i>Ringkasan</h4>
                
                <div class="summary-item-show">
                    <span>Jumlah Mata Kuliah:</span>
                    <strong>{{ $krs->details->count() }} MK</strong>
                </div>
                
                <div class="total-sks-large">
                    <div style="opacity: 0.8; font-size: 14px; margin-bottom: 8px;">Total SKS</div>
                    <div style="font-size: 48px; font-weight: 700;">{{ $totalSks }}</div>
                    <small style="font-size: 16px;">SKS</small>
                </div>
                
                <div class="status-info-show">
                    <div style="opacity: 0.9; margin-bottom: 8px; font-size: 14px;">
                        <i class="fas fa-info-circle me-2"></i>Status:
                    </div>
                    @if($krs->status_validasi == 'Menunggu')
                        <div style="font-size: 16px; font-weight: 600;">
                            <i class="fas fa-clock me-1"></i>Menunggu Validasi
                        </div>
                        <small style="opacity: 0.8; display: block; margin-top: 8px;">
                            KRS Anda sedang dalam proses validasi oleh dosen pembimbing akademik.
                        </small>
                    @elseif($krs->status_validasi == 'Disetujui')
                        <div style="font-size: 16px; font-weight: 600;">
                            <i class="fas fa-check-circle me-1"></i>Disetujui
                        </div>
                        <small style="opacity: 0.8; display: block; margin-top: 8px;">
                            KRS Anda telah disetujui. Anda dapat mengikuti perkuliahan sesuai jadwal.
                        </small>
                    @else
                        <div style="font-size: 16px; font-weight: 600;">
                            <i class="fas fa-times-circle me-1"></i>Ditolak
                        </div>
                        <small style="opacity: 0.8; display: block; margin-top: 8px;">
                            KRS Anda ditolak. Silakan hubungi dosen pembimbing akademik.
                        </small>
                    @endif
                </div>
            </div>
        </div>
    </div>

@push('styles')
<style>
    .card-simple {
        background: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }
    
    .info-grid-krs {
        display: grid;
        gap: 12px;
    }
    
    .info-row-krs {
        display: flex;
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .info-row-krs:last-child {
        border-bottom: none;
    }
    
    .info-label-krs {
        font-weight: 600;
        color: #64748b;
        width: 180px;
        flex-shrink: 0;
        font-size: 14px;
    }
    
    .info-value-krs {
        color: #1f2937;
        flex: 1;
        font-size: 14px;
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
    
    /* KHS Table Style */
    .khs-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .khs-table thead {
        background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%);
        color: white;
    }

    .khs-table thead th {
        padding: 14px 12px;
        text-align: left;
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .khs-table tbody tr {
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.2s;
    }

    .khs-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .khs-table tbody td {
        padding: 14px 12px;
        color: #333;
    }

    .khs-table tfoot tr {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .khs-table tfoot td {
        padding: 14px 12px;
        border-top: 2px solid #0B6623;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
    
    .total-card-show {
        position: sticky;
        top: 20px;
        background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%);
        color: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 4px 8px rgba(11, 102, 35, 0.3);
    }
    
    .total-card-show h4 {
        color: white;
        margin: 0 0 20px 0;
        padding-bottom: 16px;
        border-bottom: 2px solid rgba(255,255,255,0.3);
        font-size: 18px;
        font-weight: 600;
    }
    
    .summary-item-show {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-size: 15px;
    }
    
    .total-sks-large {
        text-align: center;
        margin: 24px 0;
        padding: 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
    }
    
    .status-info-show {
        padding: 16px;
        background: rgba(255,255,255,0.1);
        border-radius: 8px;
        margin-top: 20px;
    }
    
    .btn-action-krs {
        padding: 10px 20px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
    }
    
    .btn-secondary-show {
        background-color: #6b7280;
        color: white;
    }
    
    .btn-secondary-show:hover {
        background-color: #4b5563;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-edit-show {
        background-color: #f59e0b;
        color: white;
    }
    
    .btn-edit-show:hover {
        background-color: #d97706;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-delete-show {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-delete-show:hover {
        background-color: #dc2626;
        transform: translateY(-1px);
    }
    
    @media (max-width: 768px) {
        .info-row-krs {
            flex-direction: column;
            gap: 4px;
        }
        
        .info-label-krs {
            width: 100%;
        }
    }
</style>
@endpush
@endsection
