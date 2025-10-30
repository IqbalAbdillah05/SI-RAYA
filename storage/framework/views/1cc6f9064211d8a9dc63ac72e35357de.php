<?php $__env->startSection('title', 'Input Nilai Mahasiswa'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .nilai-container {
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

    .alert-danger {
        background-color: #ffebee;
        color: #c62828;
        border: 1px solid #ef9a9a;
    }

    .alert-warning {
        background-color: #fff3e0;
        color: #e65100;
        border: 1px solid #ffcc80;
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
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: 600;
        color: #333;
    }

    .table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-success:hover {
        background-color: #218838;
        color: white;
        text-decoration: none;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #333;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        color: #333;
        text-decoration: none;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .btn-danger:hover {
        background-color: #c82333;
        color: white;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
    }

    .nilai-a { 
        background-color: #e8f5e9; 
        color: #2e7d32; 
    }
    
    .nilai-b { 
        background-color: #e3f2fd; 
        color: #1565c0; 
    }
    
    .nilai-c { 
        background-color: #fff3e0; 
        color: #e65100; 
    }
    
    .nilai-d { 
        background-color: #ffebee; 
        color: #c62828; 
    }

    .nilai-e { 
        background-color: #f3e5f5; 
        color: #6a1b9a; 
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="nilai-container">
    <div class="page-header">
        <h1 class="page-title">Input Nilai Mahasiswa</h1>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="card-simple" style="background-color: #e3f2fd; border-color: #1976d2;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h4 style="margin: 0 0 8px 0; color: #1565c0;">Kelola Nilai Mahasiswa</h4>
                <p style="margin: 0; color: #0d47a1;">
                    Input dan kelola nilai mahasiswa berdasarkan program studi, semester, dan mata kuliah
                </p>
            </div>
            <a href="<?php echo e(route('dosen.inputNilai.create')); ?>" class="btn-primary">
                Input Nilai Baru
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-simple">
        <form method="GET" action="<?php echo e(route('dosen.inputNilai.index')); ?>" id="filterForm">
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 0;">
                <h4 style="margin-bottom: 16px; color: #333;">Filter Data Nilai</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; margin-bottom: 6px;">Search Nama / NIM</label>
                            <input type="text" 
                                   name="search_nama" 
                                   id="searchNama" 
                                   class="form-control" 
                                   style="height: 38px; font-size: 14px;"
                                   placeholder="Ketik nama atau NIM..."
                                   value="<?php echo e($searchNama ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" style="font-size: 13px; margin-bottom: 6px;">Mata Kuliah</label>
                            <select name="matakuliah_id" id="matakuliahSelect" class="form-control" style="height: 38px; font-size: 14px;">
                                <option value="">Semua Mata Kuliah</option>
                                <?php $__currentLoopData = $matakuliahList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($mk->id); ?>" <?php echo e(($matakuliahId ?? '') == $mk->id ? 'selected' : ''); ?>>
                                        <?php echo e($mk->nama_matakuliah); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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
                </div>
            </div>
        </form>
    </div>

    <div class="card-simple">
        <h3 class="card-title">Daftar Nilai yang Telah Diinput</h3>
        
        <?php if($nilaiList->count() > 0): ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>Prodi</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $nilaiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $nilai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($nilaiList->firstItem() + $index); ?></td>
                                <td><?php echo e($nilai->mahasiswa->nim ?? '-'); ?></td>
                                <td><?php echo e($nilai->mahasiswa->nama_lengkap ?? '-'); ?></td>
                                <td><?php echo e($nilai->mataKuliah->nama_matakuliah ?? '-'); ?></td>
                                <td><?php echo e($nilai->prodi->nama_prodi ?? '-'); ?></td>
                                <td><?php echo e($nilai->semester); ?></td>
                                <td><?php echo e($nilai->tahun_ajaran); ?></td>
                                <td>
                                    <span class="status-badge nilai-<?php echo e(strtolower(substr($nilai->nilai_huruf, 0, 1))); ?>">
                                        <?php echo e($nilai->nilai_angka); ?> (<?php echo e($nilai->nilai_huruf); ?>)
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 4px; align-items: center;">
                                        <a href="<?php echo e(route('dosen.inputNilai.show', $nilai->id)); ?>" class="btn-success" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('dosen.inputNilai.edit', $nilai->id)); ?>" class="btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('dosen.inputNilai.destroy', $nilai->id)); ?>" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #666; font-size: 14px;">
                    Menampilkan <?php echo e($nilaiList->firstItem() ?? 0); ?> - <?php echo e($nilaiList->lastItem() ?? 0); ?> dari <?php echo e($nilaiList->total()); ?> data
                </div>
                <div>
                    <?php echo e($nilaiList->appends(request()->query())->links()); ?>

                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <strong>Belum ada nilai yang diinput.</strong>
                <br>
                <a href="<?php echo e(route('dosen.inputNilai.create')); ?>" class="btn-primary" style="margin-top: 12px;">
                    Input Nilai Sekarang
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Real-time filtering
const filterForm = document.getElementById('filterForm');
const searchNamaInput = document.getElementById('searchNama');
const matakuliahSelect = document.getElementById('matakuliahSelect');
const prodiSelect = document.getElementById('prodiSelect');

let searchTimeout;

// Auto-submit on search input with debounce (wait 500ms after user stops typing)
searchNamaInput.addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(function() {
        filterForm.submit();
    }, 500);
});

// Auto-submit on mata kuliah change
matakuliahSelect.addEventListener('change', function() {
    filterForm.submit();
});

// Auto-submit on prodi change
prodiSelect.addEventListener('change', function() {
    filterForm.submit();
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dosen', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/dosen/inputNilaiMahasiswa/index.blade.php ENDPATH**/ ?>