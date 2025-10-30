

<?php $__env->startSection('title', 'Detail Kartu Hasil Studi (KHS)'); ?>

<?php $__env->startSection('content'); ?>
<div class="khs-detail">
    <!-- Header -->
    <div class="page-header">
        <h1>Detail Kartu Hasil Studi (KHS)</h1>
        <div class="header-actions">
            <a href="<?php echo e(route('admin.khs.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Informasi Mahasiswa -->
    <div class="info-card">
        <h3>Informasi Mahasiswa</h3>
        <div class="detail-grid">
            <div class="detail-item">
                <strong>Nama Lengkap</strong>
                <span><?php echo e($khs->mahasiswa->nama_lengkap); ?></span>
            </div>
            <div class="detail-item">
                <strong>NIM</strong>
                <span><?php echo e($khs->mahasiswa->nim); ?></span>
            </div>
            <div class="detail-item">
                <strong>Program Studi</strong>
                <span><?php echo e($khs->prodi->nama_prodi); ?></span>
            </div>
            <div class="detail-item">
                <strong>Semester</strong>
                <span>Semester <?php echo e($khs->semester); ?></span>
            </div>
            <div class="detail-item">
                <strong>Tahun Ajaran</strong>
                <span><?php echo e($khs->tahun_ajaran); ?></span>
            </div>
            <div class="detail-item">
                <strong>Status Validasi</strong>
                <span class="badge badge-<?php echo e($khs->status_validasi == 'Disetujui' ? 'success' : 
                    ($khs->status_validasi == 'Ditolak' ? 'danger' : 'warning')); ?>">
                    <?php echo e($khs->status_validasi); ?>

                </span>
            </div>
        </div>
    </div>

    <!-- Detail Mata Kuliah -->
    <div class="info-card">
        <h3>Detail Mata Kuliah</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode MK</th>
                    <th>Nama Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Nilai Angka</th>
                    <th>Nilai Huruf</th>
                    <th>Nilai Indeks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalSks = 0;
                    $totalNilaiIndeks = 0;
                ?>
                <?php $__currentLoopData = $khs->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($detail->mataKuliah->kode_matakuliah); ?></td>
                    <td><?php echo e($detail->mataKuliah->nama_matakuliah); ?></td>
                    <td><?php echo e($detail->sks); ?></td>
                    <td><?php echo e($detail->nilai_angka); ?></td>
                    <td><?php echo e($detail->nilai_huruf); ?></td>
                    <td><?php echo e($detail->nilai_indeks); ?></td>
                </tr>
                <?php
                    $totalSks += $detail->sks;
                    $totalNilaiIndeks += $detail->nilai_indeks * $detail->sks;
                ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                    <td><?php echo e($totalSks); ?></td>
                    <td colspan="2" class="text-right"><strong>IPS</strong></td>
                    <td><?php echo e($totalSks > 0 ? round($totalNilaiIndeks / $totalSks, 2) : 0); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Validasi KHS -->
    <?php if($khs->status_validasi == 'Menunggu'): ?>
    <div class="info-card">
        <h3>Validasi KHS</h3>
        <form action="<?php echo e(route('admin.khs.validate', $khs)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-actions">
                <button type="submit" name="status_validasi" value="Disetujui" class="btn btn-success">
                    <i class="fas fa-check"></i> Setujui
                </button>
                <button type="submit" name="status_validasi" value="Ditolak" class="btn btn-danger">
                    <i class="fas fa-times"></i> Tolak
                </button>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="<?php echo e(route('admin.khs.edit', $khs)); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="<?php echo e(route('admin.khs.destroy', $khs)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus KHS ini?')">
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
    .khs-detail {
        max-width: 1000px;
        margin: 0 auto;
        padding: 24px;
        font-family: 'Nunito', sans-serif;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

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
        background: #ffc107;
        color: #000 ;
    }

    .btn-primary:hover {
        background: #e0a800;
    }

    .btn-warning {
        background: #ffc107;
        color: #000;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .info-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }

    .info-card h3 {
        background: #f8f9fa;
        padding: 12px 15px;
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #333;
        border-bottom: 1px solid #ddd;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        padding: 15px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-item strong {
        color: #666;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .detail-item span {
        color: #333;
        font-size: 15px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .data-table th, .data-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .data-table thead {
        background: #f8f9fa;
        font-weight: 600;
    }

    .data-table tfoot {
        font-weight: 600;
        background: #f8f9fa;
    }

    .text-right {
        text-align: right;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-danger {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        padding: 15px;
    }

    /* Action Section */
    .action-section {
        max-width: 1000px;
        margin: 24px auto;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f9fafb;
        padding: 16px;
        border-top: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .khs-detail {
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/khs/show.blade.php ENDPATH**/ ?>