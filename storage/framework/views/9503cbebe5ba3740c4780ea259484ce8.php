

<?php $__env->startSection('title', 'Jadwal Mengajar'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .jadwal-container {
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

    .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
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
        border-color: #1976d2;
        box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .col-md-4 {
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
        padding: 0 10px;
    }

    @media (max-width: 768px) {
        .col-md-4 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 15px;
        }
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        font-size: 14px;
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: 600;
        color: #333;
        font-size: 13px;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-senin { background-color: #e3f2fd; color: #1565c0; }
    .badge-selasa { background-color: #e8f5e9; color: #2e7d32; }
    .badge-rabu { background-color: #fff3e0; color: #e65100; }
    .badge-kamis { background-color: #f3e5f5; color: #6a1b9a; }
    .badge-jumat { background-color: #fce4ec; color: #c2185b; }
    .badge-sabtu { background-color: #e0f2f1; color: #00695c; }
    .badge-minggu { background-color: #ffebee; color: #c62828; }

    .time-badge {
        background-color: #f5f5f5;
        color: #333;
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Pagination Styles */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 4px;
    }

    .pagination li {
        margin: 0;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        color: #333;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .pagination a:hover {
        background-color: #1976d2;
        color: white;
        border-color: #1976d2;
    }

    .pagination .active span {
        background-color: #1976d2;
        color: white;
        border-color: #1976d2;
    }

    .pagination .disabled span {
        color: #999;
        cursor: not-allowed;
        background-color: #f5f5f5;
    }

    .alert {
        padding: 12px 16px;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .alert-info {
        background-color: #e3f2fd;
        color: #1565c0;
        border: 1px solid #90caf9;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="jadwal-container">
    <div class="page-header">
        <h1 class="page-title">Jadwal Mengajar</h1>
    </div>

    <div class="card-simple" style="background-color: #e3f2fd; border-color: #1976d2;">
        <div>
            <h4 style="margin: 0 0 8px 0; color: #1565c0;">
                <i class="fas fa-calendar-alt"></i> Jadwal Mengajar Anda
            </h4>
            <p style="margin: 0; color: #0d47a1;">
                Berikut adalah jadwal mengajar yang telah ditetapkan oleh admin
            </p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-simple">
        <form method="GET" action="<?php echo e(route('dosen.jadwalMengajar.index')); ?>" id="filterForm">
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 0;">
                <h4 style="margin-bottom: 16px; color: #333;">Filter Jadwal</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; margin-bottom: 6px;">Search Mata Kuliah</label>
                            <input type="text" 
                                   name="search_matakuliah" 
                                   id="searchMatakuliah" 
                                   class="form-control" 
                                   style="height: 38px; font-size: 14px;"
                                   placeholder="Ketik nama atau kode mata kuliah..."
                                   value="<?php echo e($searchMatakuliah ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; margin-bottom: 6px;">Program Studi</label>
                            <select name="prodi_id" id="prodiSelect" class="form-control" style="height: 38px; font-size: 14px;">
                                <option value="">Semua Prodi</option>
                                <?php $__currentLoopData = $prodiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prodi->id); ?>" <?php echo e(($prodiId ?? '') == $prodi->id ? 'selected' : ''); ?>>
                                        <?php echo e($prodi->nama_prodi); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; margin-bottom: 6px;">Hari</label>
                            <select name="hari" id="hariSelect" class="form-control" style="height: 38px; font-size: 14px;">
                                <option value="">Semua Hari</option>
                                <?php $__currentLoopData = $hariOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>" <?php echo e(($hari ?? '') == $key ? 'selected' : ''); ?>>
                                        <?php echo e($value); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-simple">
        <h3 class="card-title">Daftar Jadwal Mengajar</h3>
        
        <?php if($jadwalList->count() > 0): ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 10%;">Hari</th>
                            <th style="width: 20%;">Mata Kuliah</th>
                            <th style="width: 15%;">Prodi</th>
                            <th style="width: 8%;">Semester</th>
                            <th style="width: 10%;">Ruang</th>
                            <th style="width: 12%;">Waktu</th>
                            <th style="width: 12%;">Tahun Ajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $jadwalList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $jadwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($jadwalList->firstItem() + $index); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo e(strtolower($jadwal->hari)); ?>">
                                        <?php echo e($jadwal->hari); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php echo e($jadwal->mataKuliah->nama_matakuliah ?? '-'); ?>

                                </td>
                                <td><?php echo e($jadwal->prodi->nama_prodi ?? '-'); ?></td>
                                <td style="text-align: center;"><?php echo e($jadwal->semester); ?></td>
                                <td>
                                    <i class="fas fa-door-open" style="color: #666; margin-right: 4px;"></i>
                                    <?php echo e($jadwal->ruang); ?>

                                </td>
                                <td>
                                    <span class="time-badge">
                                        <i class="fas fa-clock"></i>
                                        <?php echo e(\Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')); ?>

                                    </span>
                                </td>
                                <td><?php echo e($jadwal->tahun_ajaran); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #666; font-size: 14px;">
                    Menampilkan <?php echo e($jadwalList->firstItem() ?? 0); ?> - <?php echo e($jadwalList->lastItem() ?? 0); ?> dari <?php echo e($jadwalList->total()); ?> jadwal
                </div>
                <div>
                    <?php echo e($jadwalList->appends(request()->query())->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 16px; opacity: 0.3;"></i>
                <p style="margin: 0; font-size: 16px;">
                    <?php if(!empty($searchMatakuliah) || !empty($prodiId) || !empty($hari)): ?>
                        Tidak ditemukan jadwal dengan filter yang dipilih
                    <?php else: ?>
                        Belum ada jadwal mengajar yang ditetapkan
                    <?php endif; ?>
                </p>
                <p style="margin: 8px 0 0 0; font-size: 14px; color: #999;">
                    Hubungi admin untuk menambahkan jadwal mengajar Anda
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Real-time filtering
const filterForm = document.getElementById('filterForm');
const searchMatakuliahInput = document.getElementById('searchMatakuliah');
const prodiSelect = document.getElementById('prodiSelect');
const hariSelect = document.getElementById('hariSelect');

let searchTimeout;

// Auto-submit on search input with debounce (wait 500ms after user stops typing)
searchMatakuliahInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        filterForm.submit();
    }, 500);
});

// Auto-submit on prodi change
prodiSelect.addEventListener('change', function() {
    filterForm.submit();
});

// Auto-submit on hari change
hariSelect.addEventListener('change', function() {
    filterForm.submit();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dosen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/dosen/jadwalMengajar/index.blade.php ENDPATH**/ ?>