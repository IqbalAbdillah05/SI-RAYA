@extends('layouts.dosen')

@section('title', 'Riwayat Presensi Mahasiswa')

@push('styles')
<style>
    .riwayat-container {
        max-width: 1200px;
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

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
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
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: background-color 0.2s;
        font-size: 14px;
    }

    .btn-primary:hover {
        background-color: #1565c0;
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.2s;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.2s;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #333;
        border: none;
        padding: 6px 10px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.2s;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }

    .alert-danger {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .alert-warning {
        background-color: #fff3e0;
        color: #e65100;
        border: 1px solid #ffcc80;
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
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
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

    .filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .col-md-3 {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 10px;
    }

    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding: 0 10px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 10px;
    }

    .col-md-12 {
        flex: 0 0 100%;
        max-width: 100%;
        padding: 0 10px;
    }

    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .stat-item {
        text-align: center;
        background: rgba(255, 255, 255, 0.1);
        padding: 15px;
        border-radius: 6px;
    }

    .stat-number {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        opacity: 0.9;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        gap: 5px;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination li a,
    .pagination li span {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #333;
        text-decoration: none;
    }

    .pagination li.active span {
        background-color: #1976d2;
        color: white;
        border-color: #1976d2;
    }

    .pagination li a:hover {
        background-color: #f5f5f5;
    }

    @media (max-width: 768px) {
        .col-md-3,
        .col-md-4,
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 15px;
        }
    }
</style>
@endpush

@section('content')
<div class="riwayat-container">
    <div class="page-header">
        <h1 class="page-title">Riwayat Presensi Mahasiswa</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card-simple" style="background-color: #e3f2fd; border-color: #1976d2;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 8px 0; color: #1565c0;">Riwayat & Filter Presensi</h4>
                <p style="margin: 0; color: #0d47a1;">
                    Lihat dan filter riwayat presensi mahasiswa berdasarkan periode dan mata kuliah
                </p>
            </div>
            <a href="{{ route('dosen.presensiMahasiswa.index') }}" class="btn-secondary">
                Kembali
            </a>
        </div>
    </div>

    <div class="card-simple">
        <!-- Filter Section -->
        <form method="GET" action="{{ route('dosen.presensiMahasiswa.riwayat') }}" id="filterForm">
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 24px;">
                <h4 style="margin-bottom: 16px; color: #333;">Filter Riwayat</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Search Nama / NIM Mahasiswa</label>
                            <input type="text" 
                                   name="search_nama" 
                                   id="searchNama" 
                                   class="form-control" 
                                   placeholder="Ketik nama atau NIM mahasiswa..."
                                   value="{{ $searchNama ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Mata Kuliah</label>
                            <select name="matakuliah_id" id="matakuliahSelect" class="form-control">
                                <option value="">Semua Mata Kuliah</option>
                                @foreach($matakuliahList as $mk)
                                    <option value="{{ $mk->id }}" {{ ($matakuliahId ?? '') == $mk->id ? 'selected' : '' }}>
                                        {{ $mk->nama_matakuliah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Program Studi</label>
                            <select name="prodi_id" id="prodiSelect" class="form-control">
                                <option value="">Semua Prodi</option>
                                @foreach($prodiList as $prodi)
                                    <option value="{{ $prodi->id }}" {{ ($prodiId ?? '') == $prodi->id ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Statistics Card removed -->

        <!-- Table -->
        <h3 class="card-title">Daftar Riwayat Presensi</h3>
        
        @if($presensiList->count() > 0)
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 12%;">Tanggal</th>
                            <th style="width: 12%;">NIM</th>
                            <th style="width: 22%;">Nama Mahasiswa</th>
                            <th style="width: 20%;">Mata Kuliah</th>
                            <th style="width: 13%;">Prodi</th>
                            <th style="width: 6%;">Sem</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($presensiList as $index => $presensi)
                            <tr>
                                <td>{{ $presensiList->firstItem() + $index }}</td>
                                <td>{{ $presensi->waktu_presensi->format('d/m/Y') }}</td>
                                <td>{{ $presensi->mahasiswa->nim }}</td>
                                <td>{{ $presensi->mahasiswa->nama_lengkap }}</td>
                                <td>{{ $presensi->mataKuliah->nama_matakuliah }}</td>
                                <td>{{ $presensi->prodi->nama_prodi }}</td>
                                <td>{{ $presensi->semester }}</td>
                                <td>
                                    @if($presensi->status == 'hadir')
                                        <span class="badge badge-success">Hadir</span>
                                    @elseif($presensi->status == 'izin')
                                        <span class="badge badge-info">Izin</span>
                                        @if($presensi->foto_bukti)
                                            <i class="fas fa-image" style="color: #17a2b8; margin-left: 4px;" title="Dengan foto bukti"></i>
                                        @endif
                                    @elseif($presensi->status == 'sakit')
                                        <span class="badge badge-warning">Sakit</span>
                                        @if($presensi->foto_bukti)
                                            <i class="fas fa-image" style="color: #ffc107; margin-left: 4px;" title="Dengan foto bukti"></i>
                                        @endif
                                    @else
                                        <span class="badge badge-danger">Alpha</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <a href="{{ route('dosen.presensiMahasiswa.show', $presensi->id) }}" 
                                           class="btn btn-success btn-sm" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dosen.presensiMahasiswa.edit', $presensi->id) }}" 
                                           class="btn btn-warning btn-sm" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <div style="color: #666; font-size: 14px;">
                    Menampilkan {{ $presensiList->firstItem() ?? 0 }} - {{ $presensiList->lastItem() ?? 0 }} dari {{ $presensiList->total() }} data
                </div>
                <div class="pagination">
                    {{ $presensiList->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-clipboard-list" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                <p>Tidak ada data riwayat presensi</p>
                @if(empty($searchNama) && empty($matakuliahId) && empty($prodiId))
                    <p style="font-size: 14px; margin-top: 8px;">
                        Gunakan filter di atas untuk mencari riwayat presensi
                    </p>
                @else
                    <p style="font-size: 14px; margin-top: 8px;">
                        Tidak ditemukan hasil dengan filter yang dipilih
                    </p>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Real-time filtering
const filterForm = document.getElementById('filterForm');
const searchNamaInput = document.getElementById('searchNama');
const matakuliahSelect = document.getElementById('matakuliahSelect');
const prodiSelect = document.getElementById('prodiSelect');

let searchTimeout;

// Auto-submit on search input with debounce (wait 500ms after user stops typing)
searchNamaInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        filterForm.submit();
    }, 500);
});

// Auto-submit on mata kuliah change
matakuliahSelect.addEventListener('change', function() {
    filterForm.submit();
});

// Auto-submit on prodi change
prodiSelect.addEventListener('change', function() {
    filterForm.submit();
});
</script>
@endpush
