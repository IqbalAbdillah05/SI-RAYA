@extends('layouts.dosen')

@section('title', 'Presensi Mahasiswa')

@push('styles')
<style>
    .presensi-container {
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

    .alert-danger,
    .alert-error {
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

    .stats-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
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

    .summary-table {
        margin-top: 20px;
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

    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #e0e0e0;
    }

    .tab {
        padding: 10px 20px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: #666;
        position: relative;
        transition: color 0.2s;
    }

    .tab.active {
        color: #1976d2;
    }

    .tab.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #1976d2;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
</style>
@endpush

@section('content')
<div class="presensi-container">
    <div class="page-header">
        <h1 class="page-title">Presensi Mahasiswa</h1>
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
                <h4 style="margin: 0 0 8px 0; color: #1565c0;">Kelola Presensi Mahasiswa</h4>
                <p style="margin: 0; color: #0d47a1;">
                    Input dan kelola presensi mahasiswa berdasarkan program studi, semester, dan mata kuliah
                </p>
            </div>
            <a href="{{ route('dosen.presensiMahasiswa.create') }}" class="btn-primary">
                Presensi Baru
            </a>
        </div>
    </div>

    <div class="card-simple">
        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" onclick="switchTab('summary')">
                <i class="fas fa-chart-bar"></i> Ringkasan
            </button>
            <button class="tab" onclick="switchTab('detail')">
                <i class="fas fa-list"></i> Detail Presensi
            </button>
        </div>

        <!-- Tab Content: Summary -->
        <div id="summary-tab" class="tab-content active">
            <h3 class="card-title">Ringkasan Presensi per Kelas</h3>
            
            @if($presensiSummary->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 10%;">Tanggal</th>
                                <th style="width: 20%;">Mata Kuliah</th>
                                <th style="width: 15%;">Prodi</th>
                                <th style="width: 8%;">Semester</th>
                                <th style="width: 8%;">Total</th>
                                <th style="width: 8%;">Hadir</th>
                                <th style="width: 8%;">Izin</th>
                                <th style="width: 8%;">Sakit</th>
                                <th style="width: 8%;">Alpha</th>
                                <th style="width: 7%;">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presensiSummary as $summary)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($summary->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $summary->mataKuliah->nama_matakuliah }}</td>
                                    <td>{{ $summary->prodi->nama_prodi }}</td>
                                    <td>{{ $summary->semester }}</td>
                                    <td><strong>{{ $summary->total_mahasiswa }}</strong></td>
                                    <td>
                                        <span class="badge badge-success">{{ $summary->hadir }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $summary->izin }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">{{ $summary->sakit }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">{{ $summary->alpha }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $persentase = $summary->total_mahasiswa > 0 
                                                ? round(($summary->hadir / $summary->total_mahasiswa) * 100, 1) 
                                                : 0;
                                        @endphp
                                        <strong>{{ $persentase }}%</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="color: #666; font-size: 14px;">
                        Menampilkan {{ $presensiSummary->firstItem() }} - {{ $presensiSummary->lastItem() }} dari {{ $presensiSummary->total() }} data
                    </div>
                    <div>
                        {{ $presensiSummary->links() }}
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i class="fas fa-clipboard-list" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p>Belum ada data presensi</p>
                    <a href="{{ route('dosen.presensiMahasiswa.create') }}" class="btn-primary" style="margin-top: 16px;">
                        Buat Presensi Pertama
                    </a>
                </div>
            @endif
        </div>

        <!-- Tab Content: Detail -->
        <div id="detail-tab" class="tab-content">
            <h3 class="card-title">Detail Presensi Mahasiswa</h3>
            
            @if($presensiList->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Mata Kuliah</th>
                                <th>Prodi</th>
                                <th>Semester</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($presensiList as $index => $presensi)
                                <tr>
                                    <td>{{ $presensiList->firstItem() + $index }}</td>
                                    <td>{{ $presensi->waktu_presensi->format('d/m/Y H:i') }}</td>
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
                                        <div style="display: flex; gap: 4px; align-items: center;">
                                            <a href="{{ route('dosen.presensiMahasiswa.show', $presensi->id) }}" class="btn-success" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('dosen.presensiMahasiswa.edit', $presensi->id) }}" class="btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="color: #666; font-size: 14px;">
                        Menampilkan {{ $presensiList->firstItem() }} - {{ $presensiList->lastItem() }} dari {{ $presensiList->total() }} data
                    </div>
                    <div>
                        {{ $presensiList->links() }}
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #666;">
                    <i class="fas fa-clipboard-list" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                    <p>Belum ada data presensi</p>
                    <a href="{{ route('dosen.presensiMahasiswa.create') }}" class="btn-primary" style="margin-top: 16px;">
                        Buat Presensi Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.add('active');
    
    // Add active class to clicked tab
    event.target.closest('.tab').classList.add('active');
}
</script>
@endpush
