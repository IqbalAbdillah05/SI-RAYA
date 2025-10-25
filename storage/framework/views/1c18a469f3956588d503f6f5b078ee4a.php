

<?php $__env->startSection('title', 'Detail Program Studi'); ?>

<?php $__env->startSection('content'); ?>
<div class="prodi-detail">
    <!-- Header -->
    <div class="page-header">
        <h1>Detail Program Studi</h1>
        <div class="header-actions">
            <a href="<?php echo e(route('admin.manajemen-prodi.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="detail-card">
        <div class="detail-header">
            <h2><?php echo e($prodi->nama_prodi); ?></h2>
            <span class="badge-jenjang"><?php echo e($prodi->jenjang); ?></span>
        </div>

        <div class="detail-body">
            <div class="detail-section">
                <h3>Identitas Prodi</h3>
                <div class="detail-row">
                    <span class="detail-label">Kode Prodi</span>
                    <span class="detail-value"><?php echo e($prodi->kode_prodi); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Nama Prodi</span>
                    <span class="detail-value"><?php echo e($prodi->nama_prodi); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Jenjang</span>
                    <span class="detail-value">
                        <span class="badge-jenjang small"><?php echo e($prodi->jenjang); ?></span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ketua Prodi</span>
                    <span class="detail-value"><?php echo e($prodi->ketua_prodi ?? '-'); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">NIDN Ketua Prodi</span>
                    <span class="detail-value"><?php echo e($prodi->nidn_ketua_prodi ?? '-'); ?></span>
                </div>
            </div>

            <div class="detail-section">
                <h3>Informasi Sistem</h3>
                <div class="detail-row">
                    <span class="detail-label">Dibuat Pada</span>
                    <span class="detail-value"><?php echo e($prodi->created_at->format('d M Y, H:i')); ?> WIB</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Terakhir Diupdate</span>
                    <span class="detail-value"><?php echo e($prodi->updated_at->format('d M Y, H:i')); ?> WIB</span>
                </div>
            </div>
        </div>

        <div class="detail-footer">
            <a href="<?php echo e(route('admin.manajemen-prodi.edit', $prodi->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="<?php echo e(route('admin.manajemen-prodi.destroy', $prodi->id)); ?>" 
                  method="POST" 
                  style="display: inline;"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus program studi ini?')">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .prodi-detail {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }

    /* Header */
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

    /* Button */
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

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-primary {
        background: #ffc107;
        color: #000 ;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    /* Detail Card */
    .detail-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .detail-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-header h2 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
    }

    .detail-body {
        padding: 24px;
    }

    .detail-section {
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-section h3 {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 16px 0;
        padding-bottom: 8px;
        border-bottom: 2px solid #e5e7eb;
    }

    .detail-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #f9fafb;
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

    /* Badges */
    .badge-jenjang {
        display: inline-block;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 500;
        border-radius: 12px;
        background: #fef3c7;
        color: #92400e;
    }

    .badge-jenjang.small {
        padding: 4px 10px;
        font-size: 12px;
    }

    .detail-footer {
        padding: 16px 24px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .prodi-detail {
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

        .detail-footer {
            padding: 16px 20px;
            gap: 8px;
        }

        .detail-footer .btn,
        .detail-footer form {
            flex: 1;
        }

        .detail-footer .btn {
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenProdi/show.blade.php ENDPATH**/ ?>