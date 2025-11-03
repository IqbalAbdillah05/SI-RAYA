<?php $__env->startSection('title', 'Manajemen Mata Kuliah'); ?>

<?php $__env->startSection('content'); ?>
<div class="mata-kuliah-management">
    <!-- Header -->
    <div class="page-header">
        <h1>Manajemen Mata Kuliah</h1>
        <a href="<?php echo e(route('admin.manajemen-mata-kuliah.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Mata Kuliah
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
        <div class="filter-section">
            <div class="filter-item">
                <label>Program Studi: 
                    <select id="prodiFilter">
                        <option value="">Semua Prodi</option>
                        <?php $__currentLoopData = $prodis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prodi->id); ?>" <?php echo e(request('prodi') == $prodi->id ? 'selected' : ''); ?>>
                                <?php echo e($prodi->nama_prodi); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
            </div>
            <div class="filter-item">
                <label>Semester: 
                    <select id="semesterFilter">
                        <option value="">Semua Semester</option>
                        <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($semester); ?>" <?php echo e(request('semester') == $semester ? 'selected' : ''); ?>>
                                <?php echo e($semester); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </label>
            </div>
        </div>
        <div class="search-box">
            <label>Search: 
                <input type="text" id="searchInput" value="<?php echo e(request('search')); ?>">
            </label>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode MK</th>
                    <th>Mata Kuliah</th>
                    <th>Program Studi</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $mataKuliahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $mataKuliah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($mataKuliahs->firstItem() + $index); ?></td>
                    <td>
                        <strong><?php echo e($mataKuliah->kode_matakuliah); ?></strong>
                    </td>
                    <td><?php echo e($mataKuliah->nama_matakuliah); ?></td>
                    <td><?php echo e($mataKuliah->prodi->nama_prodi); ?></td>
                    <td><?php echo e($mataKuliah->sks); ?></td>
                    <td><?php echo e($mataKuliah->semester); ?></td>
                    <td>
                        <span class="badge badge-jenis-mk">
                            <?php if($mataKuliah->jenis_mk == 'wajib'): ?>
                                Wajib
                            <?php elseif($mataKuliah->jenis_mk == 'pilihan'): ?>
                                Pilihan
                            <?php elseif($mataKuliah->jenis_mk == 'tugas akhir'): ?>
                                Tugas Akhir
                            <?php endif; ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?php echo e(route('admin.manajemen-mata-kuliah.show', $mataKuliah->id)); ?>" class="btn-action btn-view" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.manajemen-mata-kuliah.edit', $mataKuliah->id)); ?>" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.manajemen-mata-kuliah.destroy', $mataKuliah->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">
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
                    <td colspan="8" style="text-align: center; padding: 40px;">
                        <div class="empty-state">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 10px;"></i>
                            <p>Belum ada data mata kuliah</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Info -->
    <?php if($mataKuliahs->hasPages() || $mataKuliahs->total() > 0): ?>
    <div class="pagination-wrapper">
        <div class="pagination-info">
            Menampilkan <?php echo e($mataKuliahs->firstItem() ?? 0); ?> sampai <?php echo e($mataKuliahs->lastItem() ?? 0); ?> dari <?php echo e($mataKuliahs->total()); ?> data
        </div>
        <div class="pagination-links">
            <?php echo e($mataKuliahs->links()); ?>

        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    * {
        box-sizing: border-box;
    }

    .mata-kuliah-management {
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

    .filter-section {
        display: flex;
        gap: 15px;
    }

    .filter-item {
        display: flex;
        align-items: center;
    }

    .filter-item label {
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

    /* Badges */
    .badge {
        display: inline-block;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 3px;
        white-space: nowrap;
    }

    .badge-jenis-mk {
        background: #e2e3e5;
        color: #383d41;
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

        .filter-section {
            flex-direction: column;
            width: 100%;
            gap: 10px;
        }

        .filter-item {
            width: 100%;
        }

        .filter-item select,
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
        const prodiFilter = document.getElementById('prodiFilter');
        const semesterFilter = document.getElementById('semesterFilter');
        let searchTimeout;

        function applyFilters() {
            const url = new URL(window.location.href);
            
            // Search filter
            const searchTerm = searchInput.value;
            if (searchTerm) {
                url.searchParams.set('search', searchTerm);
            } else {
                url.searchParams.delete('search');
            }

            // Prodi filter
            const prodiValue = prodiFilter.value;
            if (prodiValue) {
                url.searchParams.set('prodi', prodiValue);
            } else {
                url.searchParams.delete('prodi');
            }

            // Semester filter
            const semesterValue = semesterFilter.value;
            if (semesterValue) {
                url.searchParams.set('semester', semesterValue);
            } else {
                url.searchParams.delete('semester');
            }

            // Reset page to first page
            url.searchParams.delete('page');

            // Navigate to the new URL
            window.location.href = url.toString();
        }

        // Search input
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(applyFilters, 500);
            });
        }

        // Prodi filter
        if (prodiFilter) {
            prodiFilter.addEventListener('change', applyFilters);
        }

        // Semester filter
        if (semesterFilter) {
            semesterFilter.addEventListener('change', applyFilters);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenMataKuliah/index.blade.php ENDPATH**/ ?>