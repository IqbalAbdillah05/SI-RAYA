

<?php $__env->startSection('title', 'Detail Nilai Mahasiswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="nilai-show">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Detail Nilai Mahasiswa</h1>
        </div>
        <a href="<?php echo e(route('admin.manajemen-nilai-mahasiswa.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="detail-container">
        <div class="main-content">
            <!-- Detail Nilai Card -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Informasi Nilai</h3>
                </div>
                <div class="card-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Mata Kuliah</span>
                            <span class="detail-value"><?php echo e($nilai->matkul_name); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Program Studi</span>
                            <span class="detail-value"><?php echo e($nilai->prodi_name); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Dosen Pengampu</span>
                            <span class="detail-value"><?php echo e($nilai->dosen_name); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Semester</span>
                            <span class="detail-value">Semester <?php echo e($nilai->semester); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Tahun Ajaran</span>
                            <span class="detail-value"><?php echo e($nilai->tahun_ajaran); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Nilai Angka</span>
                            <span class="badge badge-info-large"><?php echo e(number_format($nilai->nilai_angka, 2)); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Nilai Huruf</span>
                            <span class="badge 
                                <?php if(in_array($nilai->nilai_huruf, ['A', 'A-'])): ?> badge-success
                                <?php elseif(in_array($nilai->nilai_huruf, ['B+', 'B', 'B-'])): ?> badge-primary
                                <?php elseif(in_array($nilai->nilai_huruf, ['C+', 'C', 'C-'])): ?> badge-warning
                                <?php else: ?> badge-danger
                                <?php endif; ?>">
                                <?php echo e($nilai->nilai_huruf); ?>

                            </span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Nilai Indeks</span>
                            <span class="badge badge-success-large"><?php echo e(number_format($nilai->nilai_indeks, 2)); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Tanggal Input</span>
                            <span class="detail-value"><?php echo e($nilai->created_at->format('d F Y, H:i')); ?></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">Terakhir Diupdate</span>
                            <span class="detail-value"><?php echo e($nilai->updated_at->format('d F Y, H:i')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nilai Lainnya di Semester yang Sama -->
            <?php if($nilaiLainnya->count() > 0): ?>
            <div class="detail-card">
                <div class="card-header">
                    <h3>Nilai Lain Semester <?php echo e($nilai->semester); ?> - <?php echo e($nilai->tahun_ajaran); ?></h3>
                </div>
                <div class="card-body">
                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Mata Kuliah</th>
                                    <th>Dosen</th>
                                    <th>Nilai Angka</th>
                                    <th>Nilai Huruf</th>
                                    <th>Indeks</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $nilaiLainnya; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($nl->matkul_name); ?></td>
                                    <td><?php echo e($nl->dosen_name); ?></td>
                                    <td><?php echo e(number_format($nl->nilai_angka, 2)); ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php if(in_array($nl->nilai_huruf, ['A', 'A-'])): ?> badge-success
                                            <?php elseif(in_array($nl->nilai_huruf, ['B+', 'B', 'B-'])): ?> badge-primary
                                            <?php elseif(in_array($nl->nilai_huruf, ['C+', 'C', 'C-'])): ?> badge-warning
                                            <?php else: ?> badge-danger
                                            <?php endif; ?>">
                                            <?php echo e($nl->nilai_huruf); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e(number_format($nl->nilai_indeks, 2)); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.manajemen-nilai-mahasiswa.show', $nl->id)); ?>" 
                                           class="btn-action btn-view">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div class="sidebar-content">
            <!-- Info Mahasiswa -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Data Mahasiswa</h3>
                </div>
                <div class="card-body">
                    <div class="student-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    
                    <div class="student-info">
                        <div class="info-item">
                            <small>NIM</small>
                            <strong><?php echo e($nilai->mahasiswa->nim ?? '-'); ?></strong>
                        </div>
                        
                        <div class="info-item">
                            <small>Nama Lengkap</small>
                            <strong><?php echo e($nilai->mahasiswa_name); ?></strong>
                        </div>
                        
                        <?php if(isset($nilai->mahasiswa->program_studi)): ?>
                        <div class="info-item">
                            <small>Program Studi</small>
                            <p><?php echo e($nilai->mahasiswa->program_studi); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Statistik Nilai -->
            <div class="detail-card">
                <div class="card-header">
                    <h3>Statistik Nilai</h3>
                </div>
                <div class="card-body">
                    <div class="stat-item">
                        <div class="stat-header">
                            <small>Rata-rata Nilai</small>
                            <strong class="text-primary"><?php echo e(number_format($statistik->rata_rata ?? 0, 2)); ?></strong>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-primary" style="width: <?php echo e(($statistik->rata_rata ?? 0)); ?>%"></div>
                        </div>
                    </div>

                    <div class="stat-item">
                        <div class="stat-header">
                            <small>IPK</small>
                            <strong class="text-success"><?php echo e(number_format($statistik->ipk ?? 0, 2)); ?></strong>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill progress-success" style="width: <?php echo e((($statistik->ipk ?? 0) / 4) * 100); ?>%"></div>
                        </div>
                    </div>

                    <div class="stat-grid">
                        <div class="stat-box">
                            <small>Total Mata Kuliah</small>
                            <h4 class="text-info"><?php echo e($statistik->total_matkul ?? 0); ?></h4>
                        </div>
                        <div class="stat-box">
                            <small>Nilai Tertinggi</small>
                            <h4 class="text-success"><?php echo e(number_format($statistik->nilai_tertinggi ?? 0, 0)); ?></h4>
                        </div>
                        <div class="stat-box">
                            <small>Nilai Terendah</small>
                            <h4 class="text-danger"><?php echo e(number_format($statistik->nilai_terendah ?? 0, 0)); ?></h4>
                        </div>
                        <div class="stat-box">
                            <small>Semester</small>
                            <h4 class="text-primary"><?php echo e($nilai->semester); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="<?php echo e(route('admin.manajemen-nilai-mahasiswa.edit', $nilai->id)); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="<?php echo e(route('admin.manajemen-nilai-mahasiswa.destroy', $nilai->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus nilai ini?')">
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

    .nilai-show {
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
        grid-template-columns: 2fr 1fr;
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

    .badge-large {
        padding: 6px 12px;
        font-size: 16px;
    }

    .badge-info-large, .badge-success-large {
        padding: 6px 12px;
        font-size: 16px;
        border-radius: 4px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-info-large {
        background: #0ea5e9;
        color: white;
    }

    .badge-success-large {
        background: #10b981;
        color: white;
    }

    .badge-success {
        background: #10b981;
        color: white;
    }

    .badge-primary {
        background: #3b82f6;
        color: white;
    }

    .badge-warning {
        background: #ffc107;
        color: #333;
    }

    .badge-danger {
        background: #ef4444;
        color: white;
    }

    /* Table */
    .table-wrapper {
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
        padding: 10px;
        text-align: left;
        font-weight: 600;
        color: #333;
    }

    .data-table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .data-table tbody tr:hover {
        background: #f9f9f9;
    }

    .btn-action {
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: white;
        font-size: 13px;
        text-decoration: none;
        display: inline-block;
        transition: opacity 0.2s;
    }

    .btn-view {
        background: #0ea5e9;
    }

    .btn-view:hover {
        opacity: 0.85;
    }

    /* Student Info */
    .student-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    .student-avatar i {
        font-size: 2.5rem;
        color: #999;
    }

    .student-info {
        text-align: center;
    }

    .info-item {
        margin-bottom: 15px;
    }

    .info-item small {
        display: block;
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 3px;
    }

    .info-item strong {
        display: block;
        color: #1f2937;
        font-size: 14px;
    }

    .info-item p {
        margin: 0;
        color: #1f2937;
        font-size: 14px;
    }

    /* Statistics */
    .stat-item {
        margin-bottom: 15px;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .stat-header small {
        color: #6b7280;
        font-size: 12px;
    }

    .stat-header strong {
        font-size: 14px;
    }

    .progress-bar {
        height: 8px;
        background: #f0f0f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        transition: width 0.3s;
    }

    .progress-primary {
        background: #3b82f6;
    }

    .progress-success {
        background: #10b981;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        text-align: center;
        margin-top: 15px;
    }

    .stat-box small {
        display: block;
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 5px;
    }

    .stat-box h4 {
        margin: 0;
        font-size: 1.5rem;
    }

    .text-primary {
        color: #3b82f6;
    }

    .text-success {
        color: #10b981;
    }

    .text-info {
        color: #0ea5e9;
    }

    .text-danger {
        color: #ef4444;
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
    @media (max-width: 1024px) {
        .detail-container {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .stat-grid {
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
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenNilaiMahasiswa/show.blade.php ENDPATH**/ ?>