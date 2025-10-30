@extends('layouts.mahasiswa')

@section('title', 'Riwayat Presensi')

@section('content')
<div class="card-info" style="background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); border: none; padding: 24px; border-radius: 12px; margin-bottom: 20px; color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">
                <i class="fas fa-clipboard-list"></i> Riwayat Presensi Mahasiswa
            </h4>
            <p style="margin: 0; opacity: 0.95; font-size: 14px;">
                Daftar kehadiran Anda dalam perkuliahan
            </p>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; border-left: 4px solid #28a745;">
    <i class="fas fa-check-circle" style="font-size: 20px;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 16px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; border-left: 4px solid #dc3545;">
    <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<!-- Statistik Presensi -->
<div class="card-simple" style="padding: 0; margin-bottom: 20px;">
    <div class="statistik-presensi" style="background: linear-gradient(135deg, #e8f5ec 0%, #d4edda 100%); padding: 24px; border-bottom: 2px solid #e0e0e0;">
        <h4 style="margin: 0 0 20px 0; color: #0B6623; font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-chart-bar"></i> Statistik Presensi
        </h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Total Presensi</div>
                <div style="font-size: 24px; font-weight: 700; color: #0B6623;">{{ $statistikPresensi['total'] }}</div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Hadir</div>
                <div style="font-size: 24px; font-weight: 700; color: #28a745;">{{ $statistikPresensi['hadir'] }}</div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Izin</div>
                <div style="font-size: 24px; font-weight: 700; color: #ffc107;">{{ $statistikPresensi['izin'] }}</div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Sakit</div>
                <div style="font-size: 24px; font-weight: 700; color: #17a2b8;">{{ $statistikPresensi['sakit'] }}</div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Alpha</div>
                <div style="font-size: 24px; font-weight: 700; color: #dc3545;">{{ $statistikPresensi['alpha'] }}</div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">% Kehadiran</div>
                <div style="font-size: 24px; font-weight: 700; color: #0B6623;">{{ $statistikPresensi['persentase_hadir'] }}%</div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card-simple" style="margin-bottom: 20px;">
    <div style="background-color: #e8f5ec; padding: 20px; border-radius: 8px;">
        <h4 style="margin-bottom: 16px; color: #0B6623; font-size: 16px; font-weight: 600;">
            <i class="fas fa-filter"></i> Filter Presensi
        </h4>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
            <div>
                <label style="display: block; margin-bottom: 8px; color: #0B6623; font-size: 14px; font-weight: 500;">Semester</label>
                <select name="semester" id="semesterFilter" class="form-control">
                    <option value="">Semua Semester</option>
                    @foreach($semesters as $sem)
                        <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>
                            Semester {{ $sem }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 8px; color: #0B6623; font-size: 14px; font-weight: 500;">Status</label>
                <select name="status" id="statusFilter" class="form-control">
                    <option value="">Semua Status</option>
                    @foreach($statusOptions as $key => $label)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Riwayat Presensi -->
<div class="card-simple" style="padding: 0;">
    <!-- Loading Indicator -->
    <div id="loadingIndicator" style="display: none; padding: 40px; text-align: center; background: white;">
        <div style="display: inline-block;">
            <div class="spinner" style="border: 4px solid #f3f3f3; border-top: 4px solid #0B6623; border-radius: 50%; width: 40px; height: 40px; animation: spin 1s linear infinite;"></div>
            <p style="margin-top: 16px; color: #666;">Memuat data...</p>
        </div>
    </div>

    <div class="khs-table-container" id="tableContainer">
        <table class="khs-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Mata Kuliah</th>
                    <th style="width: 20%;">Dosen</th>
                    <th style="width: 15%;">Waktu Presensi</th>
                    <th style="width: 10%;">Semester</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Keterangan</th>
                </tr>
            </thead>
            <tbody id="presensiTableBody">
                @forelse($presensi as $index => $item)
                <tr>
                    <td class="text-center">{{ $presensi->firstItem() + $index }}</td>
                    <td>{{ $item->mataKuliah->nama_matakuliah }}</td>
                    <td>{{ $item->dosen->nama_lengkap }}</td>
                    <td>{{ $item->formatTanggal }}</td>
                    <td class="text-center">{{ $item->semester }}</td>
                    <td class="text-center">
                        <span class="badge-status status-{{ strtolower($item->status) }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h3>Tidak Ada Riwayat Presensi</h3>
                            <p>Belum ada data presensi untuk ditampilkan.</p>
                            <p class="empty-hint">Silakan pilih filter lain atau hubungi bagian akademik.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div id="paginationContainer">
    @if($presensi->hasPages())
    <div class="card-simple">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="font-size: 14px; color: #666;">
                    Tampilkan
                    <select name="rows" id="rowsPerPage" class="form-control" style="width: auto; display: inline-block; padding: 6px 10px; font-size: 13px; margin: 0 8px;">
                        <option value="10" {{ request('rows', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('rows') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('rows') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('rows') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    baris per halaman
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                <div id="paginationInfo" style="font-size: 14px; color: #666;">
                    Menampilkan {{ $presensi->firstItem() }} sampai {{ $presensi->lastItem() }} dari {{ $presensi->total() }} data
                </div>
                <div id="paginationLinks">
                    {{ $presensi->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .card-simple {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
    }

    .status-hadir {
        background-color: #d4edda;
        color: #155724;
    }

    .status-izin {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-sakit {
        background-color: #cfe2ff;
        color: #084298;
    }

    .status-alpha {
        background-color: #ffebee;
        color: #c62828;
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
        border-color: #0B6623;
        box-shadow: 0 0 0 3px rgba(11, 102, 35, 0.1);
    }

    .btn-back:hover, .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-filter:hover {
        background: #094d1a;
    }

    .btn-reset:hover {
        background: #5a6268;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-view {
        background: #17a2b8;
        color: white;
    }

    .btn-view:hover {
        background: #138496;
        transform: scale(1.1);
    }

    .btn-edit {
        background: #ffc107;
        color: #333;
    }

    .btn-edit:hover {
        background: #e0a800;
        transform: scale(1.1);
    }

    .btn-delete {
        background: #dc3545;
        color: white;
    }

    .btn-delete:hover {
        background: #c82333;
        transform: scale(1.1);
    }

    .khs-table-container {
        padding: 24px;
        overflow-x: auto;
    }

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

    .text-center {
        text-align: center;
    }

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

    .empty-hint {
        color: #999;
        font-size: 14px;
    }

    .alert {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-info > div {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .btn-back, .btn-add {
            width: 100%;
            justify-content: center;
        }

        .khs-table-container {
            overflow-x: scroll;
        }

        .khs-table {
            min-width: 800px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // CSRF Token untuk AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    // State untuk filter
    let currentFilters = {
        semester: '{{ request("semester") }}',
        status: '{{ request("status") }}',
        rows: {{ request('rows', 10) }},
        page: 1
    };

    // Auto hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Initialize filter listeners
        initializeFilters();
    });

    function initializeFilters() {
        const semesterFilter = document.getElementById('semesterFilter');
        const statusFilter = document.getElementById('statusFilter');
        const rowsPerPage = document.getElementById('rowsPerPage');

        // Semester filter - realtime
        semesterFilter?.addEventListener('change', function() {
            currentFilters.semester = this.value;
            currentFilters.page = 1;
            loadPresensiData();
        });

        // Status filter - realtime
        statusFilter?.addEventListener('change', function() {
            currentFilters.status = this.value;
            currentFilters.page = 1;
            loadPresensiData();
        });

        // Rows per page - realtime
        rowsPerPage?.addEventListener('change', function() {
            currentFilters.rows = this.value;
            currentFilters.page = 1;
            loadPresensiData();
        });
    }

    function loadPresensiData() {
        const loadingIndicator = document.getElementById('loadingIndicator');
        const tableContainer = document.getElementById('tableContainer');
        const tbody = document.getElementById('presensiTableBody');

        // Show loading
        loadingIndicator.style.display = 'block';
        tableContainer.style.opacity = '0.5';

        // Build query string
        const params = new URLSearchParams();
        if (currentFilters.semester) params.append('semester', currentFilters.semester);
        if (currentFilters.status) params.append('status', currentFilters.status);
        params.append('rows', currentFilters.rows);
        params.append('page', currentFilters.page);

        // AJAX request
        fetch(`{{ route('mahasiswa.presensi.filter') }}?${params.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderTable(data.data, data.pagination);
                updatePagination(data.pagination);
            } else {
                showError('Gagal memuat data presensi');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Terjadi kesalahan saat memuat data');
        })
        .finally(() => {
            // Hide loading
            loadingIndicator.style.display = 'none';
            tableContainer.style.opacity = '1';
        });
    }

    function renderTable(data, pagination) {
        const tbody = document.getElementById('presensiTableBody');
        
        if (data.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <h3>Tidak Ada Riwayat Presensi</h3>
                            <p>Belum ada data presensi untuk ditampilkan.</p>
                            <p class="empty-hint">Silakan pilih filter lain atau hubungi bagian akademik.</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        let html = '';
        data.forEach((item, index) => {
            const no = (pagination.from || 1) + index;
            html += `
                <tr>
                    <td class="text-center">${no}</td>
                    <td>
                        <strong>${item.mata_kuliah.nama}</strong><br>
                        <small style="color: #666;">${item.mata_kuliah.kode}</small>
                    </td>
                    <td>${item.dosen}</td>
                    <td>${item.waktu_presensi}</td>
                    <td class="text-center">${item.semester}</td>
                    <td class="text-center">
                        <span class="badge-status status-${item.status.toLowerCase()}">
                            ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                        </span>
                    </td>
                    <td>${item.keterangan}</td>
                </tr>
            `;
        });
        
        tbody.innerHTML = html;
    }

    function updatePagination(pagination) {
        const paginationInfo = document.getElementById('paginationInfo');
        
        if (paginationInfo && pagination.total > 0) {
            paginationInfo.textContent = `Menampilkan ${pagination.from} sampai ${pagination.to} dari ${pagination.total} data`;
        }

        // Update pagination links (if needed)
        // You can implement pagination navigation here
    }

    function showError(message) {
        const tbody = document.getElementById('presensiTableBody');
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center">
                    <div class="empty-state">
                        <div class="empty-icon" style="color: #dc3545;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 style="color: #dc3545;">Error</h3>
                        <p>${message}</p>
                    </div>
                </td>
            </tr>
        `;
    }
</script>
@endpush