<?php $__env->startSection('title', 'Detail Presensi Dosen'); ?>

<?php $__env->startSection('content'); ?>
<div class="presensi-show">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Detail Presensi Dosen</h1>
        </div>
        <a href="<?php echo e(route('admin.manajemen-presensi-dosen.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Detail Container -->
    <div class="detail-container">
        <!-- Informasi Dosen Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Dosen</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nama Dosen</span>
                        <span class="detail-value"><?php echo e($presensi->dosen->nama_lengkap ?? $presensi->dosen->name); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Email</span>
                        <span class="detail-value"><?php echo e($presensi->dosen->email); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">NIDN</span>
                        <span class="detail-value"><?php echo e($presensi->dosen->nidn ?? '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Presensi Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Presensi</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Waktu Presensi</span>
                        <span class="detail-value"><?php echo e($presensi->waktu_presensi->format('d F Y, H:i')); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Status</span>
                        <span class="detail-value">
                            <span class="badge badge-<?php echo e($presensi->status_badge); ?>">
                                <?php echo e(ucfirst($presensi->status)); ?>

                            </span>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Presensi</span>
                        <span class="detail-value"><?php echo e($presensi->presensi_ke ?? '-'); ?></span>
                    </div>
                    <div class="detail-item full-width">
                        <span class="detail-label">Keterangan</span>
                        <span class="detail-value"><?php echo e($presensi->keterangan ?? '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <?php if($presensi->status === 'hadir'): ?>
        <!-- Lokasi Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Lokasi</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nama Lokasi</span>
                        <span class="detail-value"><?php echo e($presensi->lokasi->nama_lokasi); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Latitude</span>
                        <span class="detail-value"><?php echo e($presensi->latitude); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Longitude</span>
                        <span class="detail-value"><?php echo e($presensi->longitude); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Jarak Masuk</span>
                        <span class="detail-value"><?php echo e(number_format($presensi->jarak_masuk, 2)); ?> meter</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peta Lokasi Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Peta Lokasi</h3>
            </div>
            <div class="card-body">
                <div class="map-container">
                    <iframe 
                        width="100%" 
                        height="400" 
                        frameborder="0" 
                        style="border:0; border-radius: 6px;" 
                        src="https://maps.google.com/maps?q=<?php echo e($presensi->latitude); ?>,<?php echo e($presensi->longitude); ?>&t=&z=15&ie=UTF8&iwloc=&output=embed"
                        allowfullscreen>
                    </iframe>
                </div>
                <div class="map-actions">
                    <a href="https://www.google.com/maps?q=<?php echo e($presensi->latitude); ?>,<?php echo e($presensi->longitude); ?>" target="_blank" class="btn btn-info">
                        <i class="fas fa-external-link-alt"></i> Buka di Google Maps
                    </a>
                    <button type="button" class="btn btn-success" onclick="copyCoordinates()">
                        <i class="fas fa-copy"></i> Salin Koordinat
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Informasi Tambahan Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Tambahan</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Dibuat Pada</span>
                        <span class="detail-value"><?php echo e($presensi->created_at->format('d F Y, H:i')); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Terakhir Diupdate</span>
                        <span class="detail-value"><?php echo e($presensi->updated_at->format('d F Y, H:i')); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="<?php echo e(route('admin.manajemen-presensi-dosen.edit', $presensi)); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="<?php echo e(route('admin.manajemen-presensi-dosen.destroy', $presensi)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus presensi ini?')">
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
    * {
        box-sizing: border-box;
    }

    .presensi-show {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px;
        font-family: 'Nunito', sans-serif;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .header-left h1 {
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
    }

    /* Buttons */
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
        background: #e0a800;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-info {
        background: #0ea5e9;
        color: white;
    }

    .btn-info:hover {
        background: #0284c7;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    /* Detail Container */
    .detail-container {
        display: grid;
        gap: 20px;
    }

    .detail-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .card-header {
        background: #f9fafb;
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .card-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h3 i {
        color: #3b82f6;
    }

    .card-body {
        padding: 20px;
    }

    /* Detail Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .detail-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 500;
    }

    .detail-value {
        font-size: 14px;
        color: #1f2937;
        font-weight: 500;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 4px;
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

    /* Map Container */
    .map-container {
        margin-bottom: 16px;
        border-radius: 6px;
        overflow: hidden;
    }

    .map-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Action Section */
    .action-section {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f9fafb;
        padding: 16px;
        border-top: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .presensi-show {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .map-actions {
            flex-direction: column;
        }

        .map-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .action-section {
            flex-direction: column;
            gap: 10px;
        }

        .action-section .btn,
        .action-section form {
            width: 100%;
        }

        .action-section .btn {
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function copyCoordinates() {
        const coordinates = '<?php echo e($presensi->latitude); ?>, <?php echo e($presensi->longitude); ?>';
        
        // Create temporary input element
        const tempInput = document.createElement('input');
        tempInput.value = coordinates;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        alert('Koordinat berhasil disalin: ' + coordinates);
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenPresensiDosen/show.blade.php ENDPATH**/ ?>