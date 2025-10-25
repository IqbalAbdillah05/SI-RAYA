

<?php $__env->startSection('title', 'Login - SI-Raya STAI RAYA'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .blokir-detail {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }

    .blokir-detail h3 {
        margin-top: 0;
        margin-bottom: 10px;
        color: #721c24;
        font-size: 18px;
    }

    .blokir-detail .blokir-info p {
        margin: 5px 0;
    }

    .blokir-detail .kontak-admin {
        margin-top: 10px;
        font-style: italic;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="login-container">
    <div class="login-header">
        <img src="<?php echo e(asset('images/stai-raya-logo.png')); ?>" alt="STAI RAYA Logo" class="logo">
        
        <!-- Judul simple -->
        <h1>SI-RAYA</h1>
        <p>Sistem Informasi STAI RAYA</p>
    </div>

    <!-- Label form simple -->
    <div class="form-label">
        <h2>Login</h2>
    </div>

    <!-- Tampilkan error blokir mahasiswa -->
    <?php if(session('error') && session('blokir_detail')): ?>
        <div class="alert alert-danger blokir-detail">
            <h3>Akun Anda Diblokir</h3>
            <div class="blokir-info">
                <p><strong>Alasan Pemblokiran:</strong> <?php echo e(session('blokir_detail')['keterangan']); ?></p>
                <p><strong>Tanggal Blokir:</strong> <?php echo e(session('blokir_detail')['tanggal_blokir']); ?></p>
                <p><strong>Admin yang Memblokir:</strong> <?php echo e(session('blokir_detail')['admin']); ?></p>
                <p class="kontak-admin">Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-error">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="login-form">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <input 
                type="text" 
                id="username" 
                name="username" 
                required 
                autofocus
                value="<?php echo e(old('username')); ?>"
                placeholder="Masukkan Username"
            >
            <label for="username">Username</label>
            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
                value="<?php echo e(old('password')); ?>"
            >
            <label for="password">Kata Sandi</label>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <button type="submit" class="btn-login">
                <span>Masuk</span>
                <div class="btn-loader"></div>
            </button>
        </div>
    </form>

    <div class="login-footer">
        &copy; <?php echo e(date('Y')); ?> STAI RAYA Mlokorejo - Jember.
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/auth/login.blade.php ENDPATH**/ ?>