

<?php $__env->startSection('title', 'Kartu Hasil Studi (KHS)'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card-info" style="background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); border: none; padding: 24px; border-radius: 12px; margin-bottom: 20px; color: white;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">
                    <i class="fas fa-chart-line"></i> Kartu Hasil Studi
                </h4>
                <p style="margin: 0; opacity: 0.95; font-size: 14px;">
                    Hasil studi semester <?php echo e($selectedSemester); ?> - <?php echo e($mahasiswa->prodi->nama_prodi ?? '-'); ?>

                </p>
            </div>
            <?php if($khs): ?>
                <a href="<?php echo e(route('mahasiswa.khs.download', $selectedSemester)); ?>" class="btn-download" style="background: white; color: #0B6623; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;">
                    <i class="fas fa-download"></i>
                    Download PDF
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-simple">
        <div style="background-color: #e8f5ec; padding: 20px; border-radius: 8px; margin-bottom: 0;">
            <h4 style="margin-bottom: 16px; color: #0B6623; font-size: 16px; font-weight: 600;">
                <i class="fas fa-filter"></i> Semester
            </h4>
            <form method="GET" action="<?php echo e(route('mahasiswa.khs.index')); ?>" id="filterForm">
                <select name="semester" id="semester" class="form-control" style="max-width: 300px;" onchange="document.getElementById('filterForm').submit()">
                    <?php $__currentLoopData = $semesterList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sem); ?>" <?php echo e($selectedSemester == $sem ? 'selected' : ''); ?>>
                            Semester <?php echo e($sem); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
        </div>
    </div>

    <!-- KHS Data -->
    <?php if($khs): ?>
        <div class="card-simple" style="padding: 0;">
            <!-- Summary Section -->
            <div class="khs-summary">
                <h4 class="summary-title">
                    <i class="fas fa-info-circle"></i> Ringkasan Semester <?php echo e($selectedSemester); ?>

                </h4>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-label">Tahun Ajaran</div>
                        <div class="summary-value"><?php echo e($khs->tahun_ajaran ?? '-'); ?></div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Total SKS</div>
                        <div class="summary-value"><?php echo e($khs->total_sks ?? 0); ?> SKS</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">IP Semester (IPS)</div>
                        <div class="summary-value <?php echo e($khs->ips >= 3.0 ? 'text-success' : ($khs->ips >= 2.5 ? 'text-warning' : 'text-danger')); ?>">
                            <?php echo e(number_format($khs->ips ?? 0, 2)); ?>

                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">IP Kumulatif (IPK)</div>
                        <div class="summary-value <?php echo e($khs->ipk >= 3.0 ? 'text-success' : ($khs->ipk >= 2.5 ? 'text-warning' : 'text-danger')); ?>">
                            <?php echo e(number_format($khs->ipk ?? 0, 2)); ?>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="khs-table-container">
                <table class="khs-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 15%;">Kode</th>
                            <th style="width: 40%;">Mata Kuliah</th>
                            <th style="width: 10%;">SKS</th>
                            <th style="width: 10%;">Nilai Angka</th>
                            <th style="width: 10%;">Nilai Huruf</th>
                            <th style="width: 10%;">Nilai Indeks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $khs->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($index + 1); ?></td>
                                <td><?php echo e($detail->mataKuliah->kode_matakuliah ?? '-'); ?></td>
                                <td><?php echo e($detail->mataKuliah->nama_matakuliah ?? '-'); ?></td>
                                <td class="text-center"><?php echo e($detail->sks ?? 0); ?></td>
                                <td class="text-center"><?php echo e(number_format($detail->nilai_angka ?? 0, 2)); ?></td>
                                <td class="text-center">
                                    <span class="badge-nilai nilai-<?php echo e(strtolower($detail->nilai_huruf ?? 'e')); ?>">
                                        <?php echo e($detail->nilai_huruf ?? '-'); ?>

                                    </span>
                                </td>
                                <td class="text-center"><?php echo e(number_format($detail->nilai_indeks ?? 0, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="3" class="text-right"><strong>Total</strong></td>
                            <td class="text-center"><strong><?php echo e($khs->total_sks ?? 0); ?></strong></td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="card-simple">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h3>Belum Ada Data KHS</h3>
                <p>KHS untuk semester <?php echo e($selectedSemester); ?> belum tersedia.</p>
                <p class="empty-hint">Silakan pilih semester lain atau hubungi bagian akademik.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .khs-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
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

    .card-simple {
        background: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
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

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* KHS Summary */
    .khs-summary {
        padding: 24px;
        background: linear-gradient(135deg, #e8f5ec 0%, #d4edda 100%);
        border-bottom: 2px solid #e0e0e0;
    }

    .summary-title {
        margin: 0 0 20px 0;
        color: #0B6623;
        font-size: 18px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .summary-item {
        background: white;
        padding: 16px;
        border-radius: 8px;
        border: 1px solid #c3e6cb;
    }

    .summary-label {
        font-size: 13px;
        color: #666;
        margin-bottom: 8px;
        font-weight: 500;
    }

    .summary-value {
        font-size: 24px;
        font-weight: 700;
        color: #0B6623;
    }

    .text-success {
        color: #28a745 !important;
    }

    .text-warning {
        color: #ffc107 !important;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    /* KHS Table */
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

    .khs-table tfoot tr {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .khs-table tfoot td {
        padding: 14px 12px;
        border-top: 2px solid #0B6623;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    /* Badge Nilai */
    .badge-nilai {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 12px;
    }

    .nilai-a, .nilai-a+ {
        background-color: #d4edda;
        color: #155724;
    }

    .nilai-a- {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .nilai-b, .nilai-b+ {
        background-color: #cfe2ff;
        color: #084298;
    }

    .nilai-b- {
        background-color: #e7f1ff;
        color: #052c65;
    }

    .nilai-c, .nilai-c+ {
        background-color: #fff3cd;
        color: #856404;
    }

    .nilai-c- {
        background-color: #fff8e1;
        color: #6c5400;
    }

    .nilai-d {
        background-color: #ffebee;
        color: #c62828;
    }

    .nilai-e {
        background-color: #f3e5f5;
        color: #6a1b9a;
    }

    /* Empty State */
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
        .khs-container {
            padding: 15px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .khs-table {
            font-size: 12px;
        }

        .khs-table thead th,
        .khs-table tbody td,
        .khs-table tfoot td {
            padding: 10px 8px;
        }

        .card-info > div {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .btn-download {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 24px;
        }

        .khs-table-container {
            padding: 16px;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mahasiswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/Mahasiswa/khs/index.blade.php ENDPATH**/ ?>