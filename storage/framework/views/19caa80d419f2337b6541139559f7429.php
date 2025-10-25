

<?php $__env->startSection('title', 'Jadwal Kuliah'); ?>

<?php $__env->startSection('content'); ?>

    <div class="card-info" style="background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); border: none; padding: 24px; border-radius: 12px; margin-bottom: 20px; color: white;">
        <div>
            <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">
                <i class="fas fa-calendar-alt"></i> Jadwal Kuliah
            </h4>
            <p style="margin: 0; opacity: 0.95; font-size: 14px;">
                Jadwal perkuliahan semester <?php echo e($selectedSemester); ?> - <?php echo e($mahasiswa->prodi->nama_prodi ?? '-'); ?>

                <?php if(isset($krs)): ?>
                    <br>
                    <small style="opacity: 0.9;">
                        <i class="fas fa-info-circle"></i> Berdasarkan KRS yang telah Anda isi (<?php echo e($krs->details->count()); ?> mata kuliah)
                    </small>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-simple">
        <div style="background-color: #e8f5ec; padding: 20px; border-radius: 8px; margin-bottom: 0;">
            <h4 style="margin-bottom: 16px; color: #0B6623; font-size: 16px; font-weight: 600;">
                <i class="fas fa-filter"></i> Semester
            </h4>
            <form method="GET" action="<?php echo e(route('mahasiswa.jadwal.index')); ?>" id="filterForm">
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

    <!-- Jadwal Cards by Day -->
    <?php if(!isset($hasKrs) || !$hasKrs): ?>
        <div class="card-simple">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <h3>Belum Ada KRS</h3>
                <p>Anda belum mengisi KRS untuk semester <?php echo e($selectedSemester); ?>.</p>
                <p class="empty-hint">Silakan isi KRS terlebih dahulu untuk melihat jadwal kuliah Anda.</p>
                <a href="<?php echo e(route('mahasiswa.krs.index')); ?>" class="btn-krs" style="display: inline-flex; align-items: center; gap: 8px; margin-top: 16px; padding: 12px 24px; background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-plus-circle"></i>
                    Isi KRS Sekarang
                </a>
            </div>
        </div>
    <?php elseif($jadwalList->count() > 0): ?>
        <div class="card-simple" style="padding: 0;">
        <?php $__currentLoopData = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hari): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($jadwalByHari[$hari]) && $jadwalByHari[$hari]->count() > 0): ?>
                <div class="day-section">
                    <div class="day-header">
                        <div class="day-badge <?php echo e(strtolower($hari)); ?>">
                            <i class="fas fa-calendar-alt"></i>
                            <?php echo e($hari); ?>

                        </div>
                        <div class="day-count">
                            <?php echo e($jadwalByHari[$hari]->count()); ?> Mata Kuliah
                        </div>
                    </div>
                    
                    <div class="schedule-grid">
                        <?php $__currentLoopData = $jadwalByHari[$hari]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jadwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="schedule-card">
                                <div class="schedule-header">
                                    <div class="schedule-time">
                                        <i class="fas fa-clock"></i>
                                        <?php echo e(\Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')); ?> - 
                                        <?php echo e(\Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')); ?>

                                    </div>
                                    <div class="schedule-room">
                                        <i class="fas fa-door-open"></i>
                                        <?php echo e($jadwal->ruang); ?>

                                    </div>
                                </div>
                                
                                <div class="schedule-body">
                                    <h3 class="schedule-title">
                                        <?php echo e($jadwal->mataKuliah->nama_matakuliah ?? 'Mata Kuliah Tidak Ditemukan'); ?>

                                    </h3>
                                    
                                    <div class="schedule-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-book-open"></i>
                                            <span><?php echo e($jadwal->mataKuliah->sks ?? '-'); ?> SKS</span>
                                        </div>
                                    </div>
                                    
                                    <div class="schedule-divider"></div>
                                    
                                    <div class="schedule-info">
                                        <div class="info-item">
                                            <div class="info-icon dosen">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            </div>
                                            <div class="info-content">
                                                <div class="info-label">Dosen Pengajar</div>
                                                <div class="info-value"><?php echo e($jadwal->dosen->nama_lengkap ?? 'Belum Ditentukan'); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="card-simple">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3>Belum Ada Jadwal</h3>
                <p>Jadwal untuk mata kuliah yang Anda ambil di KRS belum tersedia.</p>
                <p class="empty-hint">Admin sedang menyusun jadwal untuk mata kuliah Anda. Silakan cek kembali nanti.</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .jadwal-container {
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

    /* Day Section */
    .day-section {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .day-section:last-child {
        border-bottom: none;
    }

    .day-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .day-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1rem;
        color: white;
    }

    .day-badge.senin { background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); }
    .day-badge.selasa { background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); }
    .day-badge.rabu { background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); }
    .day-badge.kamis { background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); }
    .day-badge.jumat { background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); }
    .day-badge.sabtu { background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); }
    .day-badge.minggu { background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); }

    .day-count {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 600;
    }

    /* Schedule Grid */
    .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1rem;
    }

    .schedule-card {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s;
    }

    .schedule-card:hover {
        border-color: #0B6623;
        box-shadow: 0 4px 12px rgba(11, 102, 35, 0.15);
        transform: translateY(-2px);
    }

    .schedule-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: linear-gradient(135deg, #e8f5ec 0%, #d4edda 100%);
        border-bottom: 1px solid #e5e7eb;
    }

    .schedule-time,
    .schedule-room {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: #374151;
    }

    .schedule-time i,
    .schedule-room i {
        color: #0B6623;
        font-size: 0.875rem;
    }

    .schedule-body {
        padding: 1.25rem;
    }

    .schedule-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .schedule-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        color: #6b7280;
        font-weight: 500;
    }

    .meta-item i {
        color: #0B6623;
    }

    .schedule-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 1rem 0;
    }

    .schedule-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .info-item {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }

    .info-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-icon.dosen {
        background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%);
        color: white;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
        margin-bottom: 0.125rem;
    }

    .info-value {
        font-size: 0.875rem;
        color: #1f2937;
        font-weight: 600;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #e8f5ec 0%, #d4edda 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon i {
        font-size: 2rem;
        color: #6b7280;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        color: #1f2937;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 0.9375rem;
        margin-bottom: 0.5rem;
    }

    .empty-hint {
        color: #0B6623;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-text h1 {
            font-size: 1.5rem;
        }

        .schedule-grid {
            grid-template-columns: 1fr;
        }

        .day-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .schedule-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }

    @media (max-width: 768px) {
        .jadwal-container {
            padding: 15px;
        }

        .schedule-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: 24px;
        }
    }
</style>
<?php $__env->stopPush(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mahasiswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/mahasiswa/jadwal/index.blade.php ENDPATH**/ ?>