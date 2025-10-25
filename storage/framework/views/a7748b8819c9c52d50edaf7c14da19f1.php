

<?php $__env->startSection('title', 'Detail Presensi Mahasiswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="presensi-show">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Detail Presensi Mahasiswa</h1>
        </div>
        <a href="<?php echo e(route('admin.manajemen-presensi-mahasiswa.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Detail Container -->
    <div class="detail-container">
        <!-- Informasi Mahasiswa Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Mahasiswa</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nama Mahasiswa</span>
                        <span class="detail-value">
                            <?php if($presensi->mahasiswa && $presensi->mahasiswa->mahasiswaProfile): ?>
                                <?php echo e($presensi->mahasiswa->mahasiswaProfile->nama_lengkap); ?>

                            <?php else: ?>
                                <?php echo e($presensi->mahasiswa->name ?? '-'); ?>

                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">NIM</span>
                        <span class="detail-value"><?php echo e($presensi->mahasiswa->nim ?? '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Dosen Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Dosen Pengampu</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Nama Dosen</span>
                        <span class="detail-value">
                            <?php if($presensi->dosen): ?>
                                <?php echo e($presensi->dosen->nama_lengkap ?? $presensi->dosen->name ?? '-'); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </span>
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
                        <span class="detail-label">Mata Kuliah</span>
                        <span class="detail-value"><?php echo e($presensi->mataKuliah->nama_matakuliah ?? '-'); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Program Studi</span>
                        <span class="detail-value"><?php echo e($presensi->prodi->nama_prodi ?? '-'); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Waktu Presensi</span>
                        <span class="detail-value"><?php echo e($presensi->waktu_presensi ? $presensi->waktu_presensi->format('d F Y, H:i') : '-'); ?></span>
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
                        <span class="detail-label">Semester</span>
                        <span class="detail-value">
                            <?php if($presensi->semester): ?>
                                Semester <?php echo e($presensi->semester); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item full-width">
                        <span class="detail-label">Keterangan</span>
                        <span class="detail-value">
                            <?php if($presensi->keterangan): ?>
                                <?php echo e($presensi->keterangan); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php if(in_array($presensi->status, ['izin', 'sakit'])): ?>
                    <div class="detail-item full-width">
                        <span class="detail-label">Foto Bukti</span>
                        <span class="detail-value">
                            <?php if($presensi->foto_bukti): ?>
                                <div class="foto-bukti-container">
                                    <img src="<?php echo e(asset('storage/' . $presensi->foto_bukti)); ?>" alt="Foto Bukti" class="foto-bukti">
                                    <a href="<?php echo e(asset('storage/' . $presensi->foto_bukti)); ?>" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-expand"></i> Lihat Foto
                                    </a>
                                </div>
                            <?php else: ?>
                                Tidak ada foto bukti
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Informasi Tambahan Card -->
        <div class="detail-card">
            <div class="card-header">
                <h3>Informasi Tambahan</h3>
            </div>
            <div class="card-body">
                <div class="detail-grid">
                    <div class="detail-item">
                        <span class="detail-label">Dibuat Pada</span>
                        <span class="detail-value"><?php echo e($presensi->created_at ? $presensi->created_at->format('d F Y, H:i') : '-'); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Diperbarui Pada</span>
                        <span class="detail-value"><?php echo e($presensi->updated_at ? $presensi->updated_at->format('d F Y, H:i') : '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="<?php echo e(route('admin.manajemen-presensi-mahasiswa.edit', $presensi)); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="<?php echo e(route('admin.manajemen-presensi-mahasiswa.destroy', $presensi)); ?>" 
              method="POST" 
              style="display: inline;"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data presensi ini?')">
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
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
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
        color: #000;
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

    /* Foto Bukti */
    .foto-bukti-container {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
    }

    .foto-bukti {
        max-width: 300px;
        max-height: 300px;
        object-fit: contain;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 12px;
    }

    .btn-info {
        background: #0ea5e9;
        color: white;
    }

    .btn-info:hover {
        background: #0284c7;
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenPresensiMahasiswa/show.blade.php ENDPATH**/ ?>