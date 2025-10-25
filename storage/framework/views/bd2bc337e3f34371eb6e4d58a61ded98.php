

<?php $__env->startSection('title', 'Tambah Mata Kuliah'); ?>

<?php $__env->startSection('content'); ?>
<div class="mata-kuliah-create">
    <div class="page-header">
        <h1>Tambah Mata Kuliah Baru</h1>
        <a href="<?php echo e(route('admin.manajemen-mata-kuliah.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        Terdapat kesalahan dalam pengisian formulir
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    <?php endif; ?>

    <div class="form-wrapper">
        <form action="<?php echo e(route('admin.manajemen-mata-kuliah.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="form-group">
                <label for="prodi_id">Program Studi <span class="required">*</span></label>
                <select name="prodi_id" id="prodi_id" class="form-control <?php echo e($errors->has('prodi_id') ? 'is-invalid' : ''); ?>">
                    <option value="">Pilih Program Studi</option>
                    <?php $__currentLoopData = $prodis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($prodi->id); ?>" <?php echo e(old('prodi_id') == $prodi->id ? 'selected' : ''); ?>>
                        <?php echo e($prodi->nama_prodi); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['prodi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="kode_matakuliah">Kode Mata Kuliah <span class="required">*</span></label>
                <input type="text" name="kode_matakuliah" id="kode_matakuliah" 
                       class="form-control <?php echo e($errors->has('kode_matakuliah') ? 'is-invalid' : ''); ?>"
                       value="<?php echo e(old('kode_matakuliah')); ?>"
                       placeholder="Masukkan Kode Mata Kuliah">
                <?php $__errorArgs = ['kode_matakuliah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label for="nama_matakuliah">Nama Mata Kuliah <span class="required">*</span></label>
                <input type="text" name="nama_matakuliah" id="nama_matakuliah" 
                       class="form-control <?php echo e($errors->has('nama_matakuliah') ? 'is-invalid' : ''); ?>"
                       value="<?php echo e(old('nama_matakuliah')); ?>"
                       placeholder="Masukkan Nama Mata Kuliah">
                <?php $__errorArgs = ['nama_matakuliah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="sks">SKS <span class="required">*</span></label>
                    <input type="number" name="sks" id="sks" 
                           class="form-control <?php echo e($errors->has('sks') ? 'is-invalid' : ''); ?>"
                           value="<?php echo e(old('sks')); ?>"
                           min="1" max="6"
                           placeholder="Jumlah SKS">
                    <?php $__errorArgs = ['sks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="js">JS (Jam Simulasi)</label>
                    <input type="number" name="js" id="js" 
                           class="form-control <?php echo e($errors->has('js') ? 'is-invalid' : ''); ?>"
                           value="<?php echo e(old('js')); ?>"
                           min="1" max="6"
                           placeholder="Jumlah Jam Simulasi">
                    <?php $__errorArgs = ['js'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="semester">Semester <span class="required">*</span></label>
                    <input type="number" name="semester" id="semester" 
                           class="form-control <?php echo e($errors->has('semester') ? 'is-invalid' : ''); ?>"
                           value="<?php echo e(old('semester')); ?>"
                           min="1" max="8"
                           placeholder="Semester">
                    <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="jenis_mk">Jenis Mata Kuliah <span class="required">*</span></label>
                    <select name="jenis_mk" id="jenis_mk" 
                            class="form-control <?php echo e($errors->has('jenis_mk') ? 'is-invalid' : ''); ?>">
                        <option value="">Pilih Jenis Mata Kuliah</option>
                        <?php $__currentLoopData = $jenisMkOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php echo e(old('jenis_mk') == $key ? 'selected' : ''); ?>>
                            <?php echo e($label); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['jenis_mk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="<?php echo e(route('admin.manajemen-mata-kuliah.index')); ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .mata-kuliah-create {
        padding: 20px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: normal;
        margin: 0;
        color: #333;
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
        background: #007bff;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .alert {
        padding: 12px 15px;
        margin-bottom: 15px;
        border-radius: 3px;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .close-alert {
        position: absolute;
        right: 10px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: inherit;
        opacity: 0.5;
    }

    .close-alert:hover {
        opacity: 1;
    }

    .form-wrapper {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-row .form-group {
        flex: 1;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
        color: #333;
    }

    .required {
        color: red;
        margin-left: 3px;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 14px;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 13px;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 15px;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenMataKuliah/create.blade.php ENDPATH**/ ?>