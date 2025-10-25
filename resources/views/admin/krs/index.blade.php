@extends('layouts.admin')

@section('title', 'Kartu Rencana Studi (KRS)')

@section('content')
<div class="krs-management">
    <!-- Header -->
    <div class="page-header">
        <h1>Kartu Rencana Studi (KRS)</h1>
        {{-- Hapus tombol create --}}
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    <!-- Controls -->
    <div class="controls">
        <div class="left-controls">
            <div class="show-entries">
                <label>Show 
                    <select id="entriesPerPage" onchange="changeEntries(this.value)">
                        <option value="10" {{ request('entries') == 10 || !request('entries') ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('entries') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('entries') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('entries') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div class="export-buttons">
                <a href="{{ route('admin.krs.export', request()->all()) }}" 
                   class="btn btn-success btn-sm" 
                   title="Export data yang sedang ditampilkan">
                    <i class="fas fa-file-excel"></i> Export Data
                </a>
            </div>
        </div>
        <div class="search-box">
            <label>Search: 
                <input type="text" id="searchInput" placeholder="" value="{{ request('search') }}">
            </label>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Mahasiswa</th>
                    <th>Semester</th>
                    <th>Tahun Ajaran</th>
                    <th>Tanggal Pengisian</th>
                    <th>Mata Kuliah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($krs as $index => $krsItem)
                <tr>
                    <td>{{ $krs->firstItem() + $index }}</td>
                    <td>
                        <div class="user-info">
                            <strong>{{ $krsItem->mahasiswa->nama_lengkap ?? 'N/A' }}</strong>
                            <small>{{ $krsItem->mahasiswa->nim ?? 'N/A' }}</small>
                        </div>
                    </td>
                    <td>Semester {{ $krsItem->semester }}</td>
                    <td>{{ $krsItem->tahun_ajaran }}</td>
                    <td>{{ $krsItem->tanggal_pengisian ? $krsItem->tanggal_pengisian->format('d M Y') : 'N/A' }}</td>
                    <td>{{ $krsItem->details->count() }} Mata Kuliah</td>
                    <td>
                        @php
                            $statusBadge = match($krsItem->status_validasi) {
                                'Menunggu' => 'warning',
                                'Disetujui' => 'success',
                                'Ditolak' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge badge-{{ $statusBadge }}">
                            {{ $krsItem->status_validasi }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.krs.show', $krsItem) }}" class="btn-action btn-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.krs.edit', $krsItem) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.krs.destroy', $krsItem) }}" method="POST" style="display: inline;" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus KRS ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px;">
                        <div class="empty-state">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                            <p>Belum ada data KRS</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Info -->
    @if($krs->hasPages() || $krs->total() > 0)
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $krs->firstItem() ?? 0 }} sampai {{ $krs->lastItem() ?? 0 }} dari {{ $krs->total() }} data
        </div>
        <div class="pagination-links">
            {{ $krs->links() }}
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    function changeEntries(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('entries', value);
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value;
                
                searchTimeout = setTimeout(function() {
                    const url = new URL(window.location.href);
                    if (searchTerm) {
                        url.searchParams.set('search', searchTerm);
                    } else {
                        url.searchParams.delete('search');
                    }
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }, 500);
            });
        }
    });
</script>
@endpush

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    .krs-management {
        padding: 20px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: normal;
        margin: 0;
        color: #333;
    }

    /* Button */
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
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        opacity: 0.9;
    }

    /* Alert */
    .alert {
        padding: 12px 15px;
        margin-bottom: 15px;
        border-radius: 3px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }

    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .close-alert {
        position: absolute;
        right: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: inherit;
        opacity: 0.5;
    }

    .close-alert:hover {
        opacity: 1;
    }

    /* Controls */
    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        font-size: 13px;
    }

    .left-controls {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .controls label {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .controls select,
    .controls input {
        padding: 5px 8px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 13px;
    }

    .controls input {
        width: 200px;
    }

    .controls select:focus,
    .controls input:focus {
        outline: none;
        border-color: #aaa;
    }

    /* Export Button */
    .export-buttons {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 6px 12px;
        border-radius: 3px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
    }

    /* Table */
    .table-wrapper {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .data-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #ddd;
    }

    .data-table th {
        padding: 12px 10px;
        text-align: left;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
    }

    .data-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: #f9f9f9;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Kolom Spesifik */
    .data-table th:nth-child(1), /* No. */
    .data-table td:nth-child(1) {
        width: 50px;
        text-align: center;
    }

    .data-table th:nth-child(2), /* Mahasiswa */
    .data-table td:nth-child(2) {
        min-width: 200px;
    }

    .data-table th:nth-child(3), /* Semester */
    .data-table td:nth-child(3),
    .data-table th:nth-child(4), /* Tahun Ajaran */
    .data-table td:nth-child(4) {
        width: 120px;
        text-align: center;
    }

    .data-table th:nth-child(5), /* Tanggal Pengisian */
    .data-table td:nth-child(5) {
        width: 150px;
        text-align: center;
    }

    .data-table th:nth-child(6), /* Mata Kuliah */
    .data-table td:nth-child(6) {
        width: 120px;
        text-align: center;
    }

    .data-table th:nth-child(7), /* Status */
    .data-table td:nth-child(7) {
        width: 120px;
        text-align: center;
    }

    .data-table th:nth-child(8), /* Aksi */
    .data-table td:nth-child(8) {
        width: 120px;
        text-align: center;
    }

    /* User Info */
    .user-info {
        display: flex;
        flex-direction: column;
        line-height: 1.3;
    }

    .user-info strong {
        color: #333;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-info small {
        color: #666;
        font-size: 12px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 3px;
        white-space: nowrap;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 5px;
    }

    .btn-action {
        padding: 6px 10px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        color: white;
        font-size: 13px;
        transition: opacity 0.2s;
    }

    .btn-view {
        background: #17a2b8;
    }

    .btn-edit {
        background: #ffc107;
        color: #000 ;
    }

    .btn-delete {
        background: #dc3545;
        width: 31px;
        height: 29px;
        padding: 0;
    }

    .btn-action:hover {
        opacity: 0.85;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        color: #999;
    }

    .empty-state p {
        margin: 5px 0 0 0;
        font-size: 14px;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        font-size: 13px;
    }

    .pagination-info {
        color: #666;
    }

    .pagination-links {
        display: flex;
        gap: 3px;
    }

    .pagination-links nav {
        display: flex;
        gap: 3px;
    }

    .pagination-links .pagination {
        display: flex;
        gap: 3px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .pagination-links .page-item {
        display: inline-block;
    }

    .pagination-links .page-link {
        display: block;
        padding: 5px 10px;
        border: 1px solid #ddd;
        background: white;
        color: #333;
        text-decoration: none;
        border-radius: 3px;
        font-size: 13px;
        transition: all 0.2s;
    }

    .pagination-links .page-link:hover {
        background: #f8f9fa;
        border-color: #aaa;
    }

    .pagination-links .page-item.active .page-link {
        background: #007bff;
        border-color: #007bff;
        color: white;
    }

    .pagination-links .page-item.disabled .page-link {
        color: #999;
        cursor: not-allowed;
        background: #f8f9fa;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .controls {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .left-controls {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
            width: 100%;
        }

        .export-buttons {
            width: 100%;
        }

        .export-buttons .btn {
            width: 100%;
            justify-content: center;
        }

        .controls input {
            width: 100%;
        }

        .table-wrapper {
            overflow-x: scroll;
        }

        .pagination-wrapper {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
    }
</style>
@endpush
@endsection
