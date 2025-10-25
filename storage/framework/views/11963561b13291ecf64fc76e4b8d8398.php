

<?php $__env->startSection('title', 'Edit Presensi Mahasiswa'); ?>

<?php $__env->startSection('content'); ?>
<div class="presensi-edit">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Presensi Mahasiswa</h1>
        </div>
        <a href="<?php echo e(route('admin.manajemen-presensi-mahasiswa.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card">
        <form action="<?php echo e(route('admin.manajemen-presensi-mahasiswa.update', $presensi)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">
                <!-- Mahasiswa (Locked) -->
                <div class="form-group">
                    <label for="mahasiswa_name">Mahasiswa <span class="required">*</span></label>
                    <input type="text" 
                           id="mahasiswa_name" 
                           class="form-control" 
                           value="<?php echo e($presensi->mahasiswa->nama_lengkap); ?>"
                           disabled>
                    <input type="hidden" name="mahasiswa_id" value="<?php echo e($presensi->mahasiswa_id); ?>">
                    <small class="form-text">Data mahasiswa tidak dapat diubah</small>
                </div>

                <!-- Dosen -->
                <div class="form-group">
                    <label for="dosen_id">Dosen Pengampu <span class="required">*</span></label>
                    <select name="dosen_id" id="dosen_id" class="form-control <?php $__errorArgs = ['dosen_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Pilih Dosen</option>
                        <?php $__currentLoopData = $dosens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dosen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dosen->id); ?>" <?php echo e(old('dosen_id', $presensi->dosen_id) == $dosen->id ? 'selected' : ''); ?>>
                            <?php echo e($dosen->nama_lengkap); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
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

                <!-- Mata Kuliah -->
                <div class="form-group">
                    <label for="mata_kuliah_id">Mata Kuliah <span class="required">*</span></label>
                    <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-control <?php $__errorArgs = ['mata_kuliah_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Pilih Mata Kuliah</option>
                        <?php $__currentLoopData = $mataKuliahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mataKuliah): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($mataKuliah->id); ?>" <?php echo e(old('mata_kuliah_id', $presensi->mata_kuliah_id) == $mataKuliah->id ? 'selected' : ''); ?>>
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

                <!-- Prodi -->
                <div class="form-group">
                    <label for="prodi_id">Program Studi <span class="required">*</span></label>
                    <select name="prodi_id" id="prodi_id" class="form-control <?php $__errorArgs = ['prodi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Pilih Program Studi</option>
                        <?php $__currentLoopData = $prodis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($prodi->id); ?>" <?php echo e(old('prodi_id', $presensi->prodi_id) == $prodi->id ? 'selected' : ''); ?>>
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

                <!-- Waktu Presensi -->
                <div class="form-group">
                    <label for="waktu_presensi">Waktu Presensi <span class="required">*</span></label>
                    <input type="datetime-local" 
                           name="waktu_presensi" 
                           id="waktu_presensi" 
                           class="form-control <?php $__errorArgs = ['waktu_presensi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('waktu_presensi', $presensi->waktu_presensi->format('Y-m-d\TH:i'))); ?>"
                           required>
                    <?php $__errorArgs = ['waktu_presensi'];
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

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select name="status" id="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="">Pilih Status</option>
                        <option value="hadir" <?php echo e(old('status', $presensi->status) == 'hadir' ? 'selected' : ''); ?>>Hadir</option>
                        <option value="izin" <?php echo e(old('status', $presensi->status) == 'izin' ? 'selected' : ''); ?>>Izin</option>
                        <option value="sakit" <?php echo e(old('status', $presensi->status) == 'sakit' ? 'selected' : ''); ?>>Sakit</option>
                        <option value="alpha" <?php echo e(old('status', $presensi->status) == 'alpha' ? 'selected' : ''); ?>>Alpha</option>
                    </select>
                    <?php $__errorArgs = ['status'];
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

                <!-- Foto Bukti -->
                <div class="form-group foto-bukti-field" style="display: none;">
                    <label for="foto_bukti">Foto Bukti</label>
                    <input type="file" 
                           name="foto_bukti" 
                           id="foto_bukti" 
                           class="form-control <?php $__errorArgs = ['foto_bukti'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           accept="image/*">
                    <small class="form-text">Upload foto bukti untuk status izin/sakit (jpg, jpeg, png)</small>
                    <?php if($presensi->foto_bukti): ?>
                        <div class="current-photo mt-2">
                            <p class="mb-1">Foto saat ini:</p>
                            <img src="<?php echo e(Storage::url($presensi->foto_bukti)); ?>" 
                                 alt="Foto Bukti" 
                                 class="img-thumbnail"
                                 style="max-width: 200px;">
                        </div>
                    <?php endif; ?>
                    <?php $__errorArgs = ['foto_bukti'];
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

                <!-- Semester -->
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select name="semester" id="semester" class="form-control <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Pilih Semester</option>
                        <?php for($i = 1; $i <= 14; $i++): ?>
                        <option value="<?php echo e($i); ?>" <?php echo e(old('semester', $presensi->semester) == $i ? 'selected' : ''); ?>>
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

                <!-- Keterangan -->
                <div class="form-group full-width">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" 
                              id="keterangan" 
                              class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              rows="3"
                              placeholder="Tambahkan keterangan jika diperlukan"><?php echo e(old('keterangan', $presensi->keterangan)); ?></textarea>
                    <small class="form-text">Opsional. Maksimal 255 karakter</small>
                    <?php $__errorArgs = ['keterangan'];
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

            <!-- Info Note -->
            <div class="info-note">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Catatan:</strong>
                    <p>Data mahasiswa tidak dapat diubah untuk menjaga integritas data presensi. keterangan bersifat opsional.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="<?php echo e(route('admin.manajemen-presensi-mahasiswa.index')); ?>" class="btn btn-secondary">
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

    .presensi-edit {
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

    /* Alert */
    .alert {
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        padding: 20px;
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

    .form-control:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 80px;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        font-weight: 500;
    }

    .form-text {
        color: #6b7280;
        font-size: 12px;
    }

    /* Info Note */
    .info-note {
        display: flex;
        gap: 10px;
        padding: 15px 20px;
        background: #d1ecf1;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-note i {
        color: #0c5460;
        font-size: 20px;
    }

    .info-note strong {
        color: #0c5460;
        font-size: 14px;
    }

    .info-note p {
        margin: 5px 0 0 0;
        color: #0c5460;
        font-size: 13px;
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
        .presensi-edit {
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
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const fotoBuktiField = document.querySelector('.foto-bukti-field');

        function toggleFotoBukti() {
            const status = statusSelect.value;
            if (status === 'izin' || status === 'sakit') {
                fotoBuktiField.style.display = 'block';
            } else {
                fotoBuktiField.style.display = 'none';
            }
        }

        // Run on page load
        toggleFotoBukti();

        // Run on status change
        statusSelect.addEventListener('change', toggleFotoBukti);
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenPresensiMahasiswa/edit.blade.php ENDPATH**/ ?>