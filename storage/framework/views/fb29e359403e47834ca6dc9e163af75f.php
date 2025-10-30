

<?php $__env->startSection('title', 'Riwayat Presensi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card-info" style="background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); border: none; padding: 24px; border-radius: 12px; margin-bottom: 20px; color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">
                <i class="fas fa-clipboard-list"></i> Riwayat Presensi
            </h4>
            <p style="margin: 0; opacity: 0.95; font-size: 14px;">
                Daftar kehadiran Anda dalam perkuliahan
            </p>
        </div>
        <a href="<?php echo e(route('mahasiswa.dashboard')); ?>" class="btn-back" style="background: white; color: #0B6623; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>
    </div>
</div>

<!-- Statistik Presensi -->
<div class="card-simple" style="padding: 0;">
    <div class="statistik-presensi" style="background: linear-gradient(135deg, #e8f5ec 0%, #d4edda 100%); padding: 24px; border-bottom: 2px solid #e0e0e0;">
        <h4 style="margin: 0 0 20px 0; color: #0B6623; font-size: 18px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-chart-bar"></i> Statistik Presensi
        </h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Total Presensi</div>
                <div style="font-size: 24px; font-weight: 700; color: #0B6623;"><?php echo e($statistikPresensi['total']); ?></div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Hadir</div>
                <div style="font-size: 24px; font-weight: 700; color: #28a745;"><?php echo e($statistikPresensi['hadir']); ?></div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Izin</div>
                <div style="font-size: 24px; font-weight: 700; color: #ffc107;"><?php echo e($statistikPresensi['izin']); ?></div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Sakit</div>
                <div style="font-size: 24px; font-weight: 700; color: #17a2b8;"><?php echo e($statistikPresensi['sakit']); ?></div>
            </div>
            <div style="background: white; padding: 16px; border-radius: 8px; border: 1px solid #c3e6cb;">
                <div style="font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 500;">Alpha</div>
                <div style="font-size: 24px; font-weight: 700; color: #dc3545;"><?php echo e($statistikPresensi['alpha']); ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card-simple">
    <div style="background-color: #e8f5ec; padding: 20px; border-radius: 8px; margin-bottom: 0;">
        <h4 style="margin-bottom: 16px; color: #0B6623; font-size: 16px; font-weight: 600;">
            <i class="fas fa-filter"></i> Filter Presensi
        </h4>
        <form method="GET" action="<?php echo e(route('mahasiswa.presensi.riwayat')); ?>" id="filterForm">
            <div style="display: flex; gap: 1rem;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; color: #0B6623; font-size: 14px;">Semester</label>
                    <select name="semester" id="semesterFilter" class="form-control" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Semester</option>
                        <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($semester); ?>" <?php echo e(request('semester') == $semester ? 'selected' : ''); ?>>
                                Semester <?php echo e($semester); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; color: #0B6623; font-size: 14px;">Status</label>
                    <select name="status" id="statusFilter" class="form-control" onchange="document.getElementById('filterForm').submit()">
                        <option value="">Semua Status</option>
                        <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(request('status') == $key ? 'selected' : ''); ?>>
                                <?php echo e($label); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Riwayat Presensi -->
<div class="card-simple" style="padding: 0;">
    <div class="khs-table-container">
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
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $presensi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-center"><?php echo e($presensi->firstItem() + $index); ?></td>
                    <td><?php echo e($item->mataKuliah->nama_matakuliah); ?></td>
                    <td><?php echo e($item->dosen->nama_lengkap); ?></td>
                    <td><?php echo e($item->formatTanggal); ?></td>
                    <td class="text-center"><?php echo e($item->semester); ?></td>
                    <td class="text-center">
                        <span class="badge-status status-<?php echo e(strtolower($item->status)); ?>">
                            <?php echo e(ucfirst($item->status)); ?>

                        </span>
                    </td>
                    <td><?php echo e($item->keterangan ?? '-'); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if($presensi->hasPages()): ?>
<div class="card-simple">
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="font-size: 14px; color: #666;">
                Tampilkan
                <form method="GET" action="<?php echo e(route('mahasiswa.presensi.riwayat')); ?>" id="rowsPerPageForm" style="display: inline-block; margin: 0 8px;">
                    <select name="rows" id="rowsPerPage" class="form-control" style="width: auto; display: inline-block; padding: 6px 10px; font-size: 13px;" onchange="document.getElementById('rowsPerPageForm').submit()">
                        <option value="10" <?php echo e(request('rows', 10) == 10 ? 'selected' : ''); ?>>10</option>
                        <option value="25" <?php echo e(request('rows') == 25 ? 'selected' : ''); ?>>25</option>
                        <option value="50" <?php echo e(request('rows') == 50 ? 'selected' : ''); ?>>50</option>
                        <option value="100" <?php echo e(request('rows') == 100 ? 'selected' : ''); ?>>100</option>
                    </select>
                </form>
                baris per halaman
            </div>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="font-size: 14px; color: #666;">
                Menampilkan <?php echo e($presensi->firstItem()); ?> sampai <?php echo e($presensi->lastItem()); ?> dari <?php echo e($presensi->total()); ?> data
            </div>
            <div>
                <?php echo e($presensi->appends(request()->except('page'))->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 12px;
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

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
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

    /* Responsive */
    @media (max-width: 768px) {
        .card-info > div {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const semesterFilter = document.getElementById('semesterFilter');
        const statusFilter = document.getElementById('statusFilter');

        // Fungsi untuk menerapkan filter
        function applyFilter() {
            filterForm.submit();
        }

        // Event listener untuk filter semester
        semesterFilter.addEventListener('change', function() {
            applyFilter();
        });

        // Event listener untuk filter status
        statusFilter.addEventListener('change', function() {
            applyFilter();
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.mahasiswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/Mahasiswa/presensiMahasiswa/riwayat.blade.php ENDPATH**/ ?>