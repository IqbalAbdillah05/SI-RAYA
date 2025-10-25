

<?php $__env->startSection('title', 'Presensi Dosen'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .presensi-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .card-simple {
        background: white;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }

    .card-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #333;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-hadir { 
        background-color: #e8f5e9; 
        color: #2e7d32; 
    }
    
    .status-izin { 
        background-color: #e3f2fd; 
        color: #1565c0; 
    }
    
    .status-sakit { 
        background-color: #fff3e0; 
        color: #e65100; 
    }
    
    .status-alpha { 
        background-color: #ffebee; 
        color: #c62828; 
    }

    .info-row {
        display: flex;
        margin-bottom: 12px;
        align-items: center;
    }

    .info-label {
        font-weight: 600;
        color: #666;
        min-width: 120px;
    }

    .info-value {
        color: #333;
    }

    .lokasi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
        margin-top: 16px;
    }

    .lokasi-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        transition: all 0.2s;
    }

    .lokasi-card:hover {
        border-color: #1976d2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .lokasi-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    .lokasi-info {
        font-size: 13px;
        color: #666;
        margin-bottom: 4px;
    }

    .lokasi-coordinates {
        font-size: 12px;
        color: #999;
        margin-bottom: 16px;
        font-family: monospace;
    }

    .btn-primary {
        background-color: #1976d2;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: background-color 0.2s;
        font-size: 14px;
    }

    .btn-primary:hover {
        background-color: #1565c0;
        color: white;
        text-decoration: none;
    }

    .btn-block {
        display: block;
        width: 100%;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #a5d6a7;
    }

    .alert-warning {
        background-color: #fff3e0;
        color: #e65100;
        border: 1px solid #ffcc80;
    }

    .foto-presensi {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        max-height: 300px;
        object-fit: cover;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #666;
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="presensi-container">
    <div class="page-header">
        <h1 class="page-title">Presensi Dosen</h1>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <!-- Info Batas Presensi -->
    <div class="card-simple" style="background-color: #e3f2fd; border-color: #1976d2;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 8px 0; color: #1565c0;">Status Presensi Hari Ini</h4>
                <p style="margin: 0; color: #0d47a1;">
                    Anda telah melakukan <strong><?php echo e($jumlahPresensiHariIni); ?> dari 2</strong> presensi hari ini
                </p>
            </div>
            <?php if($jumlahPresensiHariIni < 2): ?>
                <a href="<?php echo e(route('dosen.presensi.create')); ?>" class="btn-primary">
                    Lakukan Presensi
                </a>
            <?php else: ?>
                <span class="status-badge" style="background-color: #c62828; color: white;">
                    Batas Tercapai
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Presensi Hari Ini -->
    <div class="card-simple">
        <h3 class="card-title">Riwayat Presensi Hari Ini</h3>
        
        <?php if($presensiHariIni->count() > 0): ?>
            <?php $__currentLoopData = $presensiHariIni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $presensi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="padding: 16px; background-color: #f9f9f9; border-radius: 8px; margin-bottom: 16px;">
                    <h5 style="margin: 0 0 12px 0; color: #333;">Presensi ke-<?php echo e($index + 1); ?></h5>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="info-row">
                                <span class="info-label">Waktu Presensi:</span>
                                <span class="info-value"><?php echo e($presensi->waktu_presensi->format('d M Y H:i')); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Lokasi:</span>
                                <span class="info-value"><?php echo e($presensi->lokasi->nama_lokasi); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="status-badge status-<?php echo e($presensi->status); ?>">
                                    <?php echo e($presensi->status_formatted); ?>

                                </span>
                            </div>
                            <?php if($presensi->keterangan): ?>
                                <div class="info-row">
                                    <span class="info-label">Keterangan:</span>
                                    <span class="info-value"><?php echo e($presensi->keterangan); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if($presensi->jarak_masuk): ?>
                                <div class="info-row">
                                    <span class="info-label">Jarak:</span>
                                    <span class="info-value"><?php echo e(number_format($presensi->jarak_masuk, 2)); ?> meter</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-5">
                            <?php if($presensi->foto_bukti): ?>
                                <img src="<?php echo e($presensi->foto_bukti_url); ?>" 
                                     alt="Foto Presensi" 
                                     class="foto-presensi">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <div class="alert alert-warning">
                <strong>Anda belum melakukan presensi hari ini.</strong>
                <br>
                <a href="<?php echo e(route('dosen.presensi.create')); ?>" class="btn-primary" style="margin-top: 12px;">
                    Lakukan Presensi Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Daftar Lokasi -->
    <div class="card-simple">
        <h3 class="card-title">Pilih Lokasi Presensi</h3>
        
        <?php if($lokasi->count() > 0): ?>
            <div class="lokasi-grid">
                <?php $__currentLoopData = $lokasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="lokasi-card">
                        <h5 class="lokasi-title"><?php echo e($item->nama_lokasi); ?></h5>
                        <p class="lokasi-info">
                            <strong>Radius:</strong> <?php echo e(number_format($item->radius, 0)); ?> meter
                        </p>
                        <?php if($item->latitude && $item->longitude): ?>
                            <p class="lokasi-coordinates">
                                <?php echo e(number_format($item->latitude, 6)); ?>, <?php echo e(number_format($item->longitude, 6)); ?>

                            </p>
                        <?php endif; ?>
                        <a href="<?php echo e(route('dosen.presensi.create', ['lokasi_id' => $item->id])); ?>" 
                           class="btn-primary btn-block">
                            Pilih Lokasi
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <p>Belum ada lokasi presensi yang tersedia.</p>
                <p style="font-size: 14px; color: #999;">Hubungi administrator untuk menambahkan lokasi.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dosen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/dosen/presensi/index.blade.php ENDPATH**/ ?>