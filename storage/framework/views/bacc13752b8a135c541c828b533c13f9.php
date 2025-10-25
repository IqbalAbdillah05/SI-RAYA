

<?php $__env->startSection('title', 'Detail Mata Kuliah'); ?>

<?php $__env->startSection('content'); ?>
<div class="mata-kuliah-detail">
    <div class="page-header">
        <h1>Detail Mata Kuliah</h1>
        <div class="header-actions">
            <a href="<?php echo e(route('admin.manajemen-mata-kuliah.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="detail-wrapper">
        <div class="detail-card">
            <div class="detail-header">
                <h2><?php echo e($mataKuliah->nama_matakuliah); ?></h2>
                <span class="badge-jenis-mk badge-<?php echo e($mataKuliah->jenis_mk); ?>">
                    <?php if($mataKuliah->jenis_mk == 'wajib'): ?>
                        Wajib
                    <?php elseif($mataKuliah->jenis_mk == 'pilihan'): ?>
                        Pilihan
                    <?php elseif($mataKuliah->jenis_mk == 'tugas akhir'): ?>
                        Tugas Akhir
                    <?php endif; ?>
                </span>
            </div>

            <div class="detail-body">
                <div class="detail-row">
                    <span class="detail-label">Kode Mata Kuliah</span>
                    <span class="detail-value"><?php echo e($mataKuliah->kode_matakuliah); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Program Studi</span>
                    <span class="detail-value"><?php echo e($mataKuliah->prodi->nama_prodi); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">SKS</span>
                    <span class="detail-value"><?php echo e($mataKuliah->sks); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Jam Simulasi (JS)</span>
                    <span class="detail-value"><?php echo e($mataKuliah->js ?? '-'); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Semester</span>
                    <span class="detail-value"><?php echo e($mataKuliah->semester); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="<?php echo e(route('admin.manajemen-mata-kuliah.edit', $mataKuliah->id)); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="<?php echo e(route('admin.manajemen-mata-kuliah.destroy', $mataKuliah->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .mata-kuliah-detail {
        max-width: 700px;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #ffc107;
        color: #000 ;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .detail-wrapper {
        margin-bottom: 20px;
    }

    .detail-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .detail-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .badge-jenis-mk {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-wajib {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-pilihan {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-tugas.akhir,
    .badge-tugas {
        background: #dcfce7;
        color: #166534;
    }

    .detail-body {
        padding: 24px;
    }

    .detail-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        width: 180px;
        font-weight: 500;
        color: #6b7280;
        font-size: 14px;
        flex-shrink: 0;
    }

    .detail-value {
        flex: 1;
        color: #1f2937;
        font-size: 14px;
        font-weight: 500;
    }

    .action-section {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .mata-kuliah-detail {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .detail-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
        }

        .detail-body {
            padding: 20px;
        }

        .detail-row {
            flex-direction: column;
            gap: 4px;
            padding: 8px 0;
        }

        .detail-label {
            width: 100%;
        }

        .action-section {
            flex-direction: row;
            gap: 10px;
        }

        .action-section .btn,
        .action-section form {
            flex: 1;
        }

        .action-section .btn {
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenMataKuliah/show.blade.php ENDPATH**/ ?>