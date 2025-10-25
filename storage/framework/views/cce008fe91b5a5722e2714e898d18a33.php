

<?php $__env->startSection('title', 'Edit Nilai Mahasiswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="nilai-edit">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Nilai Mahasiswa</h1>
        </div>
        <a href="<?php echo e(route('admin.manajemen-nilai-mahasiswa.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Container -->
    <div class="form-card">
        <form action="<?php echo e(route('admin.manajemen-nilai-mahasiswa.update', $nilai->id)); ?>" method="POST" id="nilaiForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-section">
                <h3>Informasi Mahasiswa & Dosen</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Mahasiswa <span class="required">*</span></label>
                        <div class="readonly-input">
                            <input type="text" class="form-control" 
                                   value="<?php echo e($nilai->mahasiswa->nama_lengkap); ?>" 
                                   readonly>
                            <input type="hidden" name="mahasiswa_id" value="<?php echo e($nilai->mahasiswa_id); ?>">
                        </div>
                        <?php $__errorArgs = ['mahasiswa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label>Dosen Pengampu</label>
                        <div class="readonly-input">
                            <input type="text" class="form-control" 
                                   value="<?php echo e($nilai->dosen_name ?? 'Tidak Ada Dosen'); ?>" 
                                   readonly>
                            <input type="hidden" name="dosen_id" value="<?php echo e($nilai->dosen_id ?? ''); ?>">
                        </div>
                        <?php $__errorArgs = ['dosen_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Data Mata Kuliah & Nilai</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Mata Kuliah <span class="required">*</span></label>
                        <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-control" required>
                            <option value="">Pilih Mata Kuliah</option>
                            <?php $__currentLoopData = $mataKuliahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mataKuliah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($mataKuliah->id); ?>" 
                                    <?php echo e(old('mata_kuliah_id', $nilai->mata_kuliah_id) == $mataKuliah->id ? 'selected' : ''); ?>>
                                    <?php echo e($mataKuliah->nama_matakuliah); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['mata_kuliah_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label>Program Studi <span class="required">*</span></label>
                        <select name="prodi_id" id="prodi_id" class="form-control" required>
                            <option value="">Pilih Program Studi</option>
                            <?php $__currentLoopData = $prodis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($prodi->id); ?>" 
                                    <?php echo e(old('prodi_id', $nilai->prodi_id) == $prodi->id ? 'selected' : ''); ?>>
                                    <?php echo e($prodi->nama_prodi); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['prodi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label>Nilai Angka (0-100) <span class="required">*</span></label>
                        <input type="number" name="nilai_angka" id="nilai_angka" class="form-control" 
                               value="<?php echo e(old('nilai_angka', $nilai->nilai_angka)); ?>" 
                               min="0" max="100" step="0.01" required>
                        <?php $__errorArgs = ['nilai_angka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                        <small class="form-text">Nilai huruf dan indeks akan otomatis dihitung</small>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Semester & Tahun Ajaran</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Semester <span class="required">*</span></label>
                        <select name="semester" id="semester" class="form-control" required>
                            <option value="">Pilih Semester</option>
                            <?php for($i = 1; $i <= 14; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(old('semester', $nilai->semester) == $i ? 'selected' : ''); ?>>
                                    Semester <?php echo e($i); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                        <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label>Tahun Ajaran <span class="required">*</span></label>
                        <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" 
                               value="<?php echo e(old('tahun_ajaran', $nilai->tahun_ajaran)); ?>" 
                               placeholder="Contoh: 2024/2025" required>
                        <?php $__errorArgs = ['tahun_ajaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Preview nilai huruf dan indeks -->
            <div class="form-section">
                <div class="preview-box">
                    <strong><i class="fas fa-info-circle"></i> Preview Nilai:</strong>
                    <div id="preview-nilai" class="preview-content">
                        <p>Masukkan nilai angka untuk melihat nilai huruf dan indeks</p>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="<?php echo e(route('admin.manajemen-nilai-mahasiswa.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    * {
        box-sizing: border-box;
    }

    .nilai-edit {
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
        background: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .form-section {
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 15px 0;
        color: #1f2937;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        color: #374151;
    }

    .required {
        color: #ef4444;
    }

    .form-control {
        padding: 9px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.2s;
        color: #1f2937;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    .form-text {
        color: #6b7280;
        font-size: 12px;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        font-weight: 500;
    }

    /* Readonly Input */
    .readonly-input {
        position: relative;
    }

    .readonly-input input[readonly] {
        background-color: #f9f9f9;
        cursor: not-allowed;
        color: #1f2937;
    }

    /* Preview Box */
    .preview-box {
        padding: 15px 20px;
        background: #d1ecf1;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    .preview-box strong {
        color: #0c5460;
        font-size: 14px;
    }

    .preview-content {
        margin-top: 10px;
    }

    .preview-content p {
        margin: 0;
        font-size: 14px;
        color: #1f2937;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 16px 20px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .nilai-edit {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.getElementById('nilai_angka').addEventListener('input', function() {
    const nilaiAngka = parseFloat(this.value) || 0;
    let nilaiHuruf = '';
    let nilaiIndeks = 0;

    // Sesuaikan dengan logika di Model NilaiMahasiswa
    if (nilaiAngka >= 96) { nilaiHuruf = 'A+'; nilaiIndeks = 4.00; }
    else if (nilaiAngka >= 86) { nilaiHuruf = 'A'; nilaiIndeks = 3.50; }
    else if (nilaiAngka >= 81) { nilaiHuruf = 'A-'; nilaiIndeks = 3.25; }
    else if (nilaiAngka >= 76) { nilaiHuruf = 'B+'; nilaiIndeks = 3.00; }
    else if (nilaiAngka >= 71) { nilaiHuruf = 'B'; nilaiIndeks = 2.75; }
    else if (nilaiAngka >= 66) { nilaiHuruf = 'B-'; nilaiIndeks = 2.50; }
    else if (nilaiAngka >= 61) { nilaiHuruf = 'C+'; nilaiIndeks = 2.25; }
    else if (nilaiAngka >= 56) { nilaiHuruf = 'C'; nilaiIndeks = 2.00; }
    else if (nilaiAngka >= 41) { nilaiHuruf = 'D'; nilaiIndeks = 1.00; }
    else { nilaiHuruf = 'E'; nilaiIndeks = 0.00; }

    document.getElementById('preview-nilai').innerHTML = `
        <p style="margin: 0; font-weight: 600;">
            Nilai Angka: <strong style="color: #3b82f6;">${nilaiAngka.toFixed(2)}</strong> → 
            Nilai Huruf: <strong style="color: #10b981;">${nilaiHuruf}</strong> → 
            Indeks: <strong style="color: #0ea5e9;">${nilaiIndeks.toFixed(2)}</strong>
        </p>
    `;
});

// Trigger saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('nilai_angka').dispatchEvent(new Event('input'));
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenNilaiMahasiswa/edit.blade.php ENDPATH**/ ?>