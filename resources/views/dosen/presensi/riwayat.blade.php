@extends('layouts.dosen')

@section('title', 'Riwayat Presensi')

@push('styles')
<style>
    .presensi-container {
        max-width: 1400px;
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

    .page-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 2px solid #e0e0e0;
    }

    .page-title {
        color: #333;
        font-size: 28px;
        font-weight: 600;
        margin: 0;
    }

    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 0;
    }

    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #1976d2;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    }

    .btn-primary {
        background-color: #1976d2;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #1565c0;
        color: white;
        text-decoration: none;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-hadir {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .badge-izin {
        background-color: #fff3e0;
        color: #e65100;
    }

    .badge-sakit {
        background-color: #ffebee;
        color: #c62828;
    }

    .badge-alpha {
        background-color: #f3e5f5;
        color: #6a1b9a;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    /* Pagination Styles */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 4px;
    }

    .pagination li {
        margin: 0;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .pagination a:hover {
        background-color: #1976d2;
        color: white;
        border-color: #1976d2;
    }

    .pagination .active span {
        background-color: #1976d2;
        color: white;
        border-color: #1976d2;
    }

    .pagination .disabled span {
        color: #999;
        cursor: not-allowed;
        background-color: #f5f5f5;
    }
</style>
@endpush

@section('content')
<div class="presensi-container">
    <div class="page-header">
        <h1 class="page-title">Riwayat Presensi</h1>
    </div>

    <!-- Filter Section -->
    <div class="card-simple">
        <h4 style="margin-bottom: 16px; color: #333; font-size: 16px; font-weight: 600;">Filter Data</h4>
        <div class="filter-section">
            <form action="{{ route('dosen.presensi.riwayat') }}" method="GET">
                <div class="form-group">
                    <label for="status" class="form-label">Status Presensi</label>
                    <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card-simple">
        <h3 class="card-title">Daftar Riwayat Presensi</h3>
        
        @if($riwayat->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Presensi Ke</th>
                            <th>Keterangan</th>
                            <th>Jarak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $index => $presensi)
                            <tr>
                                <td>{{ $riwayat->firstItem() + $index }}</td>
                                <td>{{ $presensi->waktu_presensi->format('d M Y') }}</td>
                                <td>
                                    @if($presensi->status === 'hadir')
                                        {{ $presensi->lokasi->nama_lokasi ?? '-' }}
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $presensi->status }}">
                                        {{ ucfirst($presensi->status) }}
                                    </span>
                                </td>
                                <td>{{ $presensi->presensi_ke ?? '-' }}</td>
                                <td>{{ $presensi->keterangan ?? '-' }}</td>
                                <td>
                                    @if($presensi->status === 'hadir' && $presensi->jarak_masuk)
                                        {{ number_format($presensi->jarak_masuk, 2) }} m
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('dosen.presensi.show', $presensi->id) }}" 
                                       class="btn-primary" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #666; font-size: 14px;">
                    Menampilkan {{ $riwayat->firstItem() }} - {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} data
                </div>
                <div>
                    {{ $riwayat->appends(request()->input())->links() }}
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-clipboard-list" style="font-size: 48px; color: #ddd; margin-bottom: 16px;"></i>
                <p style="margin: 0; font-size: 16px; color: #666;">Tidak ada riwayat presensi.</p>
            </div>
        @endif
    </div>
</div>
@endsection