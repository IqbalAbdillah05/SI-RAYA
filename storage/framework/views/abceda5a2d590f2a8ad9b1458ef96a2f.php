

<?php $__env->startSection('title', 'Manajemen Jadwal'); ?>

<?php $__env->startSection('content'); ?>
<div class="jadwal-management">
    <!-- Header -->
    <div class="page-header">
        <h1>Manajemen Jadwal</h1>
        <a href="<?php echo e(route('admin.jadwal-mahasiswa.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if(session('success')): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <?php echo e(session('success')); ?>

        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo e(session('error')); ?>

        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    <?php endif; ?>

    <!-- Controls -->
    <div class="controls">
        <div class="show-entries">
            <label>Show 
                <select id="entriesPerPage" onchange="changeEntries(this.value)">
                    <option value="10" <?php echo e(request('entries') == 10 || !request('entries') ? 'selected' : ''); ?>>10</option>
                    <option value="25" <?php echo e(request('entries') == 25 ? 'selected' : ''); ?>>25</option>
                    <option value="50" <?php echo e(request('entries') == 50 ? 'selected' : ''); ?>>50</option>
                    <option value="100" <?php echo e(request('entries') == 100 ? 'selected' : ''); ?>>100</option>
                </select>
                entries
            </label>
        </div>
        <div class="search-box">
            <label>Search: 
                <input type="text" id="searchInput" placeholder="" value="<?php echo e(request('search')); ?>">
            </label>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Program Studi</th>
                    <th>Hari</th>
                    <th>Jam</th>
                    <th>Ruang</th>
                    <th>Semester/TA</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $jadwalList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $jadwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($jadwalList->firstItem() + $index); ?></td>
                    <td>
                        <strong><?php echo e($jadwal->mataKuliah->nama_matakuliah ?? '-'); ?></strong>
                    </td>
                    <td>
                        <div class="user-info">
                            <div>
                                <strong><?php echo e($jadwal->dosen->nama_lengkap ?? '-'); ?></strong>
                            </div>
                        </div>
                    </td>
                    <td><?php echo e($jadwal->prodi->nama_prodi ?? '-'); ?></td>
                    <td>
                        <span class="badge badge-hari">
                            <?php echo e($jadwal->hari); ?>

                        </span>
                    </td>
                    <td>
                        <span class="jam-horizontal">
                            <?php echo e(date('H:i', strtotime($jadwal->jam_mulai))); ?> - 
                            <?php echo e(date('H:i', strtotime($jadwal->jam_selesai))); ?>

                        </span>
                    </td>
                    <td><?php echo e($jadwal->ruang ?? '-'); ?></td>
                    <td>
                        <span class="badge badge-semester">
                            Sem <?php echo e($jadwal->semester); ?>

                        </span>
                        <small><?php echo e($jadwal->tahun_ajaran); ?></small>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?php echo e(route('admin.jadwal-mahasiswa.show', $jadwal->id)); ?>" class="btn-action btn-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.jadwal-mahasiswa.edit', $jadwal->id)); ?>" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.jadwal-mahasiswa.destroy', $jadwal->id)); ?>" method="POST" style="display: inline;" class="delete-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="button" class="btn-action btn-delete" title="Hapus" onclick="confirmDelete(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" style="text-align: center; padding: 40px;">
                        <div class="empty-state">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                            <p>Belum ada data jadwal</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Info -->
    <?php if($jadwalList->hasPages() || $jadwalList->total() > 0): ?>
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan <?php echo e($jadwalList->firstItem() ?? 0); ?> sampai <?php echo e($jadwalList->lastItem() ?? 0); ?> dari <?php echo e($jadwalList->total()); ?> data
        </div>
        <div class="pagination-links">
            <?php echo e($jadwalList->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    * {
        box-sizing: border-box;
    }

    .jadwal-management {
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

    /* Table */
    .table-wrapper {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 14px;
    }

    .data-table thead th {
        background: #f8f9fa;
        border-bottom: 2px solid #ddd;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        white-space: nowrap;
    }

    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: #f9f9f9;
    }

    /* Kolom dengan lebar tetap */
    .data-table th:nth-child(1), .data-table td:nth-child(1) { 
        width: 50px; 
        text-align: center; 
    }

    .data-table th:nth-child(2), .data-table td:nth-child(2) { 
        width: 200px; 
    }

    .data-table th:nth-child(3), .data-table td:nth-child(3) { 
        width: 180px; 
    }

    .data-table th:nth-child(4), .data-table td:nth-child(4) { 
        width: 150px; 
    }

    .data-table th:nth-child(5), .data-table td:nth-child(5) { 
        width: 100px; 
    }

    .data-table th:nth-child(6), .data-table td:nth-child(6) { 
        width: 120px; 
    }

    .data-table th:nth-child(7), .data-table td:nth-child(7) { 
        width: 100px; 
    }

    .data-table th:nth-child(8), .data-table td:nth-child(8) { 
        width: 120px; 
    }

    .data-table th:nth-child(9), .data-table td:nth-child(9) { 
        width: 100px; 
        text-align: center; 
    }

    .data-table td small {
        display: block;
        color: #666;
        font-size: 12px;
        margin-top: 2px;
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
    }

    .user-info strong {
        color: #333;
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

    .badge-hari {
        background: #d1ecf1;
        color: #0c5460;
    }

    .badge-semester {
        background: #d4edda;
        color: #155724;
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

    .jam-horizontal {
        display: inline-block;
        white-space: nowrap;
    }

    .jam-horizontal::before,
    .jam-horizontal::after {
        display: none;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
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
    
    function confirmDelete(button) {
        if (confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
            // Submit form jika dikonfirmasi
            button.closest('form.delete-form').submit();
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/jadwalMahasiswa/index.blade.php ENDPATH**/ ?>