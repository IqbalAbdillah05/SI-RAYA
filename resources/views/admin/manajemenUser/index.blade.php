@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="user-management">
    <!-- Header -->
    <div class="page-header">
        <h1>Manajemen User</h1>
        <a href="{{ route('admin.manajemen-user.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a>
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

    <!-- Role Filter Tabs -->
    <div class="role-tabs">
        <a href="{{ route('admin.manajemen-user.index', array_merge(request()->only(['search', 'entries']), ['role' => 'all'])) }}" 
           class="role-tab {{ (!request('role') || request('role') == 'all') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Semua 
            <span class="badge">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('admin.manajemen-user.index', array_merge(request()->only(['search', 'entries']), ['role' => 'admin'])) }}" 
           class="role-tab {{ request('role') == 'admin' ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> Admin 
            <span class="badge badge-admin">{{ $counts['admin'] }}</span>
        </a>
        <a href="{{ route('admin.manajemen-user.index', array_merge(request()->only(['search', 'entries']), ['role' => 'dosen'])) }}" 
           class="role-tab {{ request('role') == 'dosen' ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher"></i> Dosen 
            <span class="badge badge-dosen">{{ $counts['dosen'] }}</span>
        </a>
        <a href="{{ route('admin.manajemen-user.index', array_merge(request()->only(['search', 'entries']), ['role' => 'mahasiswa'])) }}" 
           class="role-tab {{ request('role') == 'mahasiswa' ? 'active' : '' }}">
            <i class="fas fa-user-graduate"></i> Mahasiswa 
            <span class="badge badge-mahasiswa">{{ $counts['mahasiswa'] }}</span>
        </a>
    </div>

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
                @if(request('role') == 'dosen')
                    <a href="{{ route('admin.manajemen-user.exportDosenMahasiswa', ['role' => 'dosen']) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Data Dosen
                    </a>
                @elseif(request('role') == 'mahasiswa')
                    <a href="{{ route('admin.manajemen-user.exportDosenMahasiswa', ['role' => 'mahasiswa']) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export Data Mahasiswa
                    </a>
                @endif
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
                    <th>Nama & Email</th>
                    <th>Role</th>
                    <th>NIM/NIDN</th>
                    <th>Program Studi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                @php
                    $programStudi = '-';
                    $statusMahasiswa = 'Aktif';
                    
                    if ($user->role === 'mahasiswa' && $user->mahasiswaProfile) {
                        $programStudi = $user->mahasiswaProfile->program_studi ?? '-';
                        $statusMahasiswa = $user->mahasiswaProfile->status_mahasiswa ?? 'Aktif';
                    } elseif ($user->role === 'dosen' && $user->dosenProfile) {
                        $programStudi = $user->dosenProfile->program_studi ?? '-';
                    }

                    $pasFoto = null;
                    if ($user->role === 'mahasiswa' && $user->mahasiswaProfile) {
                        $pasFoto = $user->mahasiswaProfile->pas_foto;
                    } elseif ($user->role === 'dosen' && $user->dosenProfile) {
                        $pasFoto = $user->dosenProfile->pas_foto;
                    }

                    // Status badge color
                    $statusBadge = match(strtolower($statusMahasiswa)) {
                        'aktif' => 'success',
                        'cuti' => 'warning',
                        'lulus' => 'info',
                        'keluar', 'drop out' => 'danger',
                        default => 'secondary'
                    };
                @endphp
                <tr data-role="{{ $user->role }}" data-status="{{ $statusMahasiswa }}">
                    <td>{{ $users->firstItem() + $index }}</td>
                    <td>
                        <div class="user-info">
                            <div class="user-avatar">
                                @if($pasFoto)
                                    <img src="{{ asset('storage/' . $pasFoto) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <strong>{{ $user->name }}</strong>
                                <small>{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-role-{{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        @if($user->role == 'dosen')
                            {{ $user->nidn ?? '-' }}
                        @elseif($user->role == 'mahasiswa')
                            {{ $user->nim ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $programStudi }}</td>
                    <td>
                        @if($user->role == 'mahasiswa')
                            <span class="badge badge-{{ $statusBadge }}">
                                {{ $statusMahasiswa }}
                            </span>
                        @else
                            <span class="badge badge-success">Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.manajemen-user.show', $user) }}" class="btn-action btn-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.manajemen-user.edit', $user) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.manajemen-user.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
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
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        <div class="empty-state">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                            <p>Belum ada data user</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Info -->
    @if($users->hasPages() || $users->total() > 0)
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
        </div>
        <div class="pagination-links">
            {{ $users->links() }}
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    .user-management {
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

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        opacity: 0.9;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
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

    .export-buttons {
        display: flex;
        gap: 10px;
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
    }

    .data-table tbody tr:hover {
        background: #f9f9f9;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* User Info with Avatar */
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-info > div {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .user-info strong {
        color: #333;
        font-size: 14px;
    }

    .user-info small {
        color: #666;
        font-size: 12px;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #6c757d;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
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

    /* Status Badges */
    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .badge-info {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-secondary {
        background: #e2e3e5;
        color: #383d41;
    }

    /* Role Badges */
    .badge-role-admin {
        background: #e7e3fc;
        color: #5b21b6;
    }

    .badge-role-dosen {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-role-mahasiswa {
        background: #dcfce7;
        color: #166534;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-view {
        background: #17a2b8;
    }

    .btn-edit {
        background: #ffc107;
        color: #000;
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

    /* Role Tabs */
    .role-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0;
    }

    .role-tab {
        padding: 12px 20px;
        background: white;
        border: 2px solid #e9ecef;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        text-decoration: none;
        color: #495057;
        font-weight: 500;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        bottom: -2px;
    }

    .role-tab:hover {
        background: #f8f9fa;
        color: #007bff;
    }

    .role-tab.active {
        background: white;
        color: #007bff;
        border-color: #007bff;
        border-bottom-color: white;
        font-weight: 600;
    }

    .role-tab i {
        font-size: 16px;
    }

    .role-tab .badge {
        background: #6c757d;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        min-width: 24px;
        text-align: center;
    }

    .role-tab.active .badge {
        background: #007bff;
    }

    .badge-admin {
        background: #dc3545 !important;
    }

    .badge-dosen {
        background: #28a745 !important;
    }

    .badge-mahasiswa {
        background: #ffc107 !important;
        color: #000 !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .role-tabs {
            flex-wrap: wrap;
            gap: 5px;
        }

        .role-tab {
            padding: 8px 12px;
            font-size: 13px;
        }

        .role-tab .badge {
            font-size: 10px;
            padding: 2px 6px;
        }

        .controls {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .left-controls {
            flex-direction: column;
            align-items: flex-start;
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
@endsection