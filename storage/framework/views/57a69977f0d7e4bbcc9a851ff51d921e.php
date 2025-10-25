

<?php $__env->startSection('title', 'Manajemen Presensi Mahasiswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="presensi-management">
    <!-- Header -->
    <div class="page-header">
        <h1>Manajemen Presensi Mahasiswa</h1>
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
    <form method="GET" action="<?php echo e(route('admin.manajemen-presensi-mahasiswa.index')); ?>">
        <div class="controls">
            <div class="left-controls">
                <div class="show-entries">
                    <label>Show 
                        <select id="entriesPerPage" name="entries" onchange="this.form.submit()">
                            <option value="10" <?php echo e(request('entries') == 10 || !request('entries') ? 'selected' : ''); ?>>10</option>
                            <option value="25" <?php echo e(request('entries') == 25 ? 'selected' : ''); ?>>25</option>
                            <option value="50" <?php echo e(request('entries') == 50 ? 'selected' : ''); ?>>50</option>
                            <option value="100" <?php echo e(request('entries') == 100 ? 'selected' : ''); ?>>100</option>
                        </select>
                        entries
                    </label>
                </div>
                <div class="export-buttons">
                    <a href="<?php echo e(route('admin.manajemen-presensi-mahasiswa.export', request()->all())); ?>" 
                       class="btn btn-success btn-sm" 
                       title="Export data yang sedang ditampilkan">
                        <i class="fas fa-file-excel"></i> Export Data
                    </a>
                </div>
            </div>
            <div class="search-box">
                <label>Search: 
                    <input type="text" name="search" id="searchInput" placeholder="" value="<?php echo e(request('search')); ?>">
                </label>
            </div>
        </div>

        <!-- Filter Tambahan -->
        <div class="filter-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
            <div class="form-group" style="flex: 1;">
                <label>Tanggal Dari</label>
                <input type="date" name="tanggal_dari" class="form-control" 
                       value="<?php echo e(request('tanggal_dari')); ?>"
                       style="width: 100%; padding: 5px; border: 1px solid #ddd; border-radius: 3px;">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Tanggal Sampai</label>
                <input type="date" name="tanggal_sampai" class="form-control" 
                       value="<?php echo e(request('tanggal_sampai')); ?>"
                       style="width: 100%; padding: 5px; border: 1px solid #ddd; border-radius: 3px;">
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Bulan</label>
                <select name="bulan" class="form-control" 
                        style="width: 100%; padding: 5px; border: 1px solid #ddd; border-radius: 3px;">
                    <option value="">Pilih Bulan</option>
                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthNumber => $monthName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($monthNumber); ?>" 
                            <?php echo e(request('bulan') == $monthNumber ? 'selected' : ''); ?>>
                            <?php echo e($monthName); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group" style="flex: 1;">
                <label>Tahun</label>
                <select name="tahun" class="form-control" 
                        style="width: 100%; padding: 5px; border: 1px solid #ddd; border-radius: 3px;">
                    <option value="">Pilih Tahun</option>
                    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($year); ?>" 
                            <?php echo e(request('tahun') == $year ? 'selected' : ''); ?>>
                            <?php echo e($year); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="form-group" style="align-self: flex-end;">
                <button type="submit" class="btn btn-primary" style="padding: 5px 15px;">Filter</button>
            </div>
        </div>
    </form>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Mahasiswa</th>
                    <th>Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Prodi</th>
                    <th>Waktu Presensi</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $presensiMahasiswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($presensiMahasiswas->firstItem() + $index); ?></td>
                    <td>
                        <?php if($item->mahasiswa && $item->mahasiswa->mahasiswaProfile): ?>
                            <?php echo e($item->mahasiswa->mahasiswaProfile->nama_lengkap); ?>

                        <?php else: ?>
                            <?php echo e($item->mahasiswa->name ?? '-'); ?>

                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($item->dosen): ?>
                            <?php echo e($item->dosen->nama_lengkap); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($item->mataKuliah->nama_matakuliah ?? '-'); ?></td>
                    <td><?php echo e($item->prodi->nama_prodi ?? '-'); ?></td>
                    <td><?php echo e($item->waktu_presensi ? $item->waktu_presensi->format('d M Y, H:i') : '-'); ?></td>
                    <td>
                        <span class="badge badge-<?php echo e($item->status_badge); ?>">
                            <?php echo e(ucfirst($item->status)); ?>

                        </span>
                    </td>
                    <td><?php echo e($item->keterangan ?? '-'); ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?php echo e(route('admin.manajemen-presensi-mahasiswa.show', $item)); ?>" 
                               class="btn-action btn-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.manajemen-presensi-mahasiswa.edit', $item)); ?>" 
                               class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.manajemen-presensi-mahasiswa.destroy', $item)); ?>" 
                                  method="POST" 
                                  style="display: inline;"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi ini?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
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
                            <p>Tidak ada data presensi mahasiswa</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Info -->
    <?php if($presensiMahasiswas->hasPages() || $presensiMahasiswas->total() > 0): ?>
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan <?php echo e($presensiMahasiswas->firstItem() ?? 0); ?> sampai <?php echo e($presensiMahasiswas->lastItem() ?? 0); ?> dari <?php echo e($presensiMahasiswas->total()); ?> data
        </div>
        <div class="pagination-links">
            <?php echo e($presensiMahasiswas->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    * {
        box-sizing: border-box;
    }

    .presensi-management {
        padding: 20px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    .page-header {
        margin-bottom: 20px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: normal;
        margin: 0;
        color: #333;
    }

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

    .user-info-simple strong {
        color: #333;
        font-size: 14px;
    }

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
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

    .badge {
        display: inline-block;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 3px;
    }

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

    .empty-state {
        text-align: center;
        color: #999;
    }

    .empty-state p {
        margin: 5px 0 0 0;
        font-size: 14px;
    }

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

    @media (max-width: 768px) {
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenPresensiMahasiswa/index.blade.php ENDPATH**/ ?>