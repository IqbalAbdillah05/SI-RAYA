

<?php $__env->startSection('title', 'Tambah Jadwal'); ?>

<?php $__env->startSection('content'); ?>
<div class="jadwal-form">
    <!-- Header -->
    <div class="page-header">
        <h1>Tambah Jadwal Massal</h1>
        <a href="<?php echo e(route('admin.jadwal-mahasiswa.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Alert Messages -->
    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo e(session('error')); ?>

        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Terdapat kesalahan:</strong>
        <ul style="margin: 5px 0 0 20px; padding: 0;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card">
        <form action="<?php echo e(route('admin.jadwal-mahasiswa.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="form-row">
                <div class="form-group">
                    <label for="prodi_id" class="form-label">
                        <i class="fas fa-graduation-cap"></i> Program Studi <span class="required">*</span>
                    </label>
                    <select name="prodi_id" 
                            id="prodi_id" 
                            class="form-control <?php $__errorArgs = ['prodi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            required
                            onchange="loadMataKuliahBySemester()">
                        <option value="">-- Pilih Program Studi --</option>
                        <?php $__currentLoopData = $prodis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prodi->id); ?>" <?php echo e(old('prodi_id') == $prodi->id ? 'selected' : ''); ?>>
                                <?php echo e($prodi->kode_prodi); ?> - <?php echo e($prodi->nama_prodi); ?> (<?php echo e($prodi->jenjang); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['prodi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="semester" class="form-label">
                        <i class="fas fa-layer-group"></i> Semester <span class="required">*</span>
                    </label>
                    <select name="semester" 
                           id="semester" 
                           class="form-control <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required
                           onchange="loadMataKuliahBySemester()">
                        <option value="">-- Pilih Semester --</option>
                        <?php for($i = 1; $i <= 8; $i++): ?>
                            <option value="<?php echo e($i); ?>" <?php echo e(old('semester') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                        <?php endfor; ?>
                    </select>
                    <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-group matakuliah-dosen-list">
                <label class="form-label">
                    <i class="fas fa-book"></i> Pilih Mata Kuliah dan Dosen <span class="required">*</span>
                </label>
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> 
                    Pilih mata kuliah dan tentukan dosen pengajar untuk masing-masing mata kuliah
                </div>
                <div class="matakuliah-container" id="matakuliah-dosen-container">
                    <div class="no-data">Pilih program studi dan semester terlebih dahulu</div>
                </div>
                <?php $__errorArgs = ['jadwal_items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="hari" class="form-label">
                        <i class="fas fa-calendar-day"></i> Hari <span class="required">*</span>
                    </label>
                    <select name="hari" 
                            id="hari" 
                            class="form-control <?php $__errorArgs = ['hari'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            required>
                        <option value="">-- Pilih Hari --</option>
                        <?php $__currentLoopData = $hariOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>" <?php echo e(old('hari') == $value ? 'selected' : ''); ?>>
                                <?php echo e($value); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['hari'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tahun_ajaran" class="form-label">
                        <i class="fas fa-calendar-alt"></i> Tahun Ajaran <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="form-control <?php $__errorArgs = ['tahun_ajaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           id="tahun_ajaran" 
                           name="tahun_ajaran" 
                           value="<?php echo e(old('tahun_ajaran', '2025/2026')); ?>"
                           placeholder="Contoh: 2025/2026"
                           maxlength="20"
                           required>
                    <?php $__errorArgs = ['tahun_ajaran'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="semester_type" class="form-label">
                        <i class="fas fa-sync-alt"></i> Tipe Semester <span class="required">*</span>
                    </label>
                    <select name="semester_type" 
                            id="semester_type" 
                            class="form-control <?php $__errorArgs = ['semester_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            required>
                        <option value="ganjil" <?php echo e(old('semester_type') == 'ganjil' ? 'selected' : ''); ?>>Ganjil</option>
                        <option value="genap" <?php echo e(old('semester_type') == 'genap' ? 'selected' : ''); ?>>Genap</option>
                    </select>
                    <?php $__errorArgs = ['semester_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="jadwal-summary" id="jadwal-summary" style="display: none;">
                <h3>Ringkasan Jadwal</h3>
                <div class="summary-content">
                    <div class="summary-section">
                        <h4>Informasi Umum</h4>
                        <p><strong>Program Studi:</strong> <span id="summary-prodi"></span></p>
                        <p><strong>Semester:</strong> <span id="summary-semester"></span></p>
                        <p><strong>Hari:</strong> <span id="summary-hari"></span></p>
                        <p><strong>Tahun Akademik:</strong> <span id="summary-tahun-ajaran"></span></p>
                    </div>
                    
                    <div class="summary-section">
                        <h4>Mata Kuliah dan Dosen (<span id="summary-matkul-count">0</span> mata kuliah)</h4>
                        <div id="summary-matkul-list" class="summary-matkul-list"></div>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="<?php echo e(route('admin.jadwal-mahasiswa.index')); ?>" class="btn btn-secondary">
                    Batal
                </a>
                <button type="button" class="btn btn-info" onclick="showSummary()">
                    <i class="fas fa-eye"></i> Pratinjau
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    * {
        box-sizing: border-box;
    }

    .jadwal-form {
        padding: 20px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    /* Header */
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

    /* Button */
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
    
    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    /* Alert */
    .alert {
        padding: 12px 15px;
        margin-bottom: 15px;
        border-radius: 3px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        position: relative;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .alert ul {
        margin: 5px 0 0 20px;
        padding: 0;
    }

    .alert li {
        margin: 3px 0;
    }

    .close-alert {
        position: absolute;
        right: 10px;
        top: 10px;
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

    /* Form Card */
    .form-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 30px;
        max-width: 900px;
    }

    /* Form Row */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }

    .form-label i {
        color: #666;
        margin-right: 3px;
        width: 16px;
        display: inline-block;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .error-message {
        display: block;
        margin-top: 5px;
        font-size: 13px;
        color: #dc3545;
    }

    select.form-control {
        cursor: pointer;
        background: white;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    /* Matakuliah Dosen List */
    .matakuliah-dosen-list {
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 20px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    .matakuliah-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .matakuliah-item {
        display: flex;
        flex-direction: column;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    
    .matakuliah-item:hover {
        background-color: #f3f3f3;
    }
    
    .matakuliah-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }
    
    .matakuliah-info {
        flex-grow: 1;
    }
    
    .matakuliah-title {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 3px;
    }
    
    .matakuliah-details {
        font-size: 13px;
        color: #666;
    }
    
    .dosen-selection {
        margin-top: 10px;
        padding: 15px;
        background: #f8f9fa;
        border-top: 1px solid #eee;
        border-radius: 0 0 4px 4px;
    }
    
    .mk-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 10px;
    }
    
    .mk-form-group {
        margin-bottom: 10px;
    }
    
    .time-input {
        width: 100%;
        padding: 6px 10px;
        font-size: 13px;
    }
    
    .no-data {
        padding: 20px;
        text-align: center;
        color: #666;
        background: #f9f9f9;
        border-radius: 3px;
    }

    /* Jadwal Summary */
    .jadwal-summary {
        margin-top: 30px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 3px;
        background-color: #f9f9f9;
    }
    
    .jadwal-summary h3 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 20px;
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }
    
    .summary-section {
        margin-bottom: 20px;
        background-color: white;
        border: 1px solid #eee;
        border-radius: 5px;
        padding: 15px;
    }
    
    .summary-section h4 {
        margin-top: 0;
        margin-bottom: 15px;
        font-size: 16px;
        color: #555;
        border-bottom: 1px solid #eee;
        padding-bottom: 8px;
    }
    
    .summary-content p {
        margin: 8px 0;
    }
    
    .summary-matkul-list {
        margin-top: 10px;
    }
    
    .summary-matkul-item {
        padding: 10px;
        border-bottom: 1px solid #eee;
        background-color: #f5f5f5;
        border-radius: 3px;
        margin-bottom: 8px;
    }
    
    .summary-matkul-item:last-child {
        border-bottom: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .form-card {
            padding: 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
        
        .matakuliah-checkboxes {
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
    // Fungsi untuk memuat mata kuliah berdasarkan prodi dan semester
    function loadMataKuliahBySemester() {
        const prodiId = document.getElementById('prodi_id').value;
        const semester = document.getElementById('semester').value;
        const matkulContainer = document.getElementById('matakuliah-dosen-container');
        
        if (!prodiId || !semester) {
            matkulContainer.innerHTML = '<div class="no-data">Pilih program studi dan semester terlebih dahulu</div>';
            return;
        }
        
        // Di sini kita pura-pura memuat data, pada implementasi sebenarnya, Anda akan menggunakan AJAX
        // untuk memuat data mata kuliah berdasarkan prodi dan semester dari server
        matkulContainer.innerHTML = '<div class="no-data">Memuat data mata kuliah...</div>';
        
        // Simulasi loading
        setTimeout(() => {
            // Filter mata kuliah berdasarkan prodi_id dan semester
            const matkulList = [
                <?php $__currentLoopData = $mataKuliahs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    id: <?php echo e($mk->id); ?>,
                    kode: "<?php echo e($mk->kode_matakuliah); ?>",
                    nama: "<?php echo e($mk->nama_matakuliah); ?>",
                    sks: <?php echo e($mk->sks); ?>,
                    semester: <?php echo e($mk->semester); ?>,
                    prodi_id: <?php echo e($mk->prodi_id); ?>

                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ];
            
            const dosenList = [
                <?php $__currentLoopData = $dosenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dosen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    id: <?php echo e($dosen->id); ?>,
                    nidn: "<?php echo e($dosen->nidn); ?>",
                    nama: "<?php echo e($dosen->nama_lengkap); ?>"
                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ];
            
            const filteredMatkul = matkulList.filter(mk => 
                mk.prodi_id == prodiId && mk.semester == semester
            );
            
            if (filteredMatkul.length === 0) {
                matkulContainer.innerHTML = '<div class="no-data">Tidak ada mata kuliah yang tersedia untuk program studi dan semester ini</div>';
                return;
            }
            
            let html = '';
            filteredMatkul.forEach(mk => {
                // Create dosen dropdown options
                let dosenOptions = '<option value="">-- Pilih Dosen --</option>';
                dosenList.forEach(dosen => {
                    dosenOptions += `<option value="${dosen.id}">${dosen.nidn} - ${dosen.nama}</option>`;
                });
                
                html += `
                <div class="matakuliah-item">
                    <div class="matakuliah-header">
                        <input type="checkbox" 
                               name="jadwal_items[${mk.id}][selected]" 
                               id="mk-${mk.id}" 
                               value="1" 
                               onchange="toggleDosenSelection(this, ${mk.id})">
                        <div class="matakuliah-info">
                            <div class="matakuliah-title">${mk.kode} - ${mk.nama}</div>
                            <div class="matakuliah-details">${mk.sks} SKS | Semester ${mk.semester}</div>
                        </div>
                    </div>
                    
                    <div class="dosen-selection" id="dosen-selection-${mk.id}" style="display:none;">
                        <input type="hidden" name="jadwal_items[${mk.id}][mata_kuliah_id]" value="${mk.id}">
                        <div class="mk-form-row">
                            <div class="mk-form-group">
                                <label for="dosen-${mk.id}" class="form-label">Pilih Dosen Pengajar:</label>
                                <select name="jadwal_items[${mk.id}][dosen_id]" 
                                        id="dosen-${mk.id}" 
                                        class="form-control dosen-select">
                                    ${dosenOptions}
                                </select>
                            </div>
                        </div>
                        <div class="mk-form-row">
                            <div class="mk-form-group">
                                <label for="jam-mulai-${mk.id}" class="form-label">
                                    <i class="fas fa-clock"></i> Jam Mulai:
                                </label>
                                <input type="time" 
                                       class="form-control time-input" 
                                       id="jam-mulai-${mk.id}" 
                                       name="jadwal_items[${mk.id}][jam_mulai]"
                                       value="08:00"
                                       onchange="updateJamSelesai(${mk.id})">
                            </div>
                            <div class="mk-form-group">
                                <label for="jam-selesai-${mk.id}" class="form-label">
                                    <i class="fas fa-clock"></i> Jam Selesai:
                                </label>
                                <input type="time" 
                                       class="form-control time-input" 
                                       id="jam-selesai-${mk.id}" 
                                       name="jadwal_items[${mk.id}][jam_selesai]"
                                       value="09:40">
                            </div>
                        </div>
                        <div class="mk-form-row">
                            <div class="mk-form-group">
                                <label for="ruang-${mk.id}" class="form-label">
                                    <i class="fas fa-door-open"></i> Ruang:
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="ruang-${mk.id}" 
                                       name="jadwal_items[${mk.id}][ruang]"
                                       placeholder="Contoh: A101"
                                       maxlength="50">
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });
            
            matkulContainer.innerHTML = html;
        }, 500);
    }
    
    // Toggle dosen selection visibility
    function toggleDosenSelection(checkbox, matkulId) {
        const dosenSelection = document.getElementById(`dosen-selection-${matkulId}`);
        const dosenSelect = document.querySelector(`select[name="jadwal_items[${matkulId}][dosen_id]"]`);
        const jamMulaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_mulai]"]`);
        const jamSelesaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_selesai]"]`);
        
        if (checkbox.checked) {
            dosenSelection.style.display = 'block';
            // Enable required validation
            if (dosenSelect) dosenSelect.setAttribute('required', 'required');
            if (jamMulaiInput) jamMulaiInput.setAttribute('required', 'required');
            if (jamSelesaiInput) jamSelesaiInput.setAttribute('required', 'required');
        } else {
            dosenSelection.style.display = 'none';
            // Disable required validation
            if (dosenSelect) dosenSelect.removeAttribute('required');
            if (jamMulaiInput) jamMulaiInput.removeAttribute('required');
            if (jamSelesaiInput) jamSelesaiInput.removeAttribute('required');
        }
        
        // Update ringkasan
        updateSummary();
    }
    
    // Automatically set end time based on start time and SKS
    function updateJamSelesai(matkulId) {
        const jamMulaiInput = document.getElementById(`jam-mulai-${matkulId}`);
        const jamSelesaiInput = document.getElementById(`jam-selesai-${matkulId}`);
        
        if (!jamMulaiInput.value) return;
        
        // Parse jam mulai
        const [hours, minutes] = jamMulaiInput.value.split(':').map(Number);
        
        // Default duration (100 minutes = 1 hour 40 minutes)
        let newHours = hours + 1;
        let newMinutes = minutes + 40;
        
        // Handle overflow
        if (newMinutes >= 60) {
            newHours += Math.floor(newMinutes / 60);
            newMinutes = newMinutes % 60;
        }
        
        // Format back to time string
        const formattedHours = newHours.toString().padStart(2, '0');
        const formattedMinutes = newMinutes.toString().padStart(2, '0');
        
        jamSelesaiInput.value = `${formattedHours}:${formattedMinutes}`;
    }
    
        // Fungsi untuk menampilkan ringkasan jadwal sebelum submit
    function showSummary() {
        const summaryDiv = document.getElementById('jadwal-summary');
        const prodiSelect = document.getElementById('prodi_id');
        const semesterSelect = document.getElementById('semester');
        const hariSelect = document.getElementById('hari');
        const tahunAjaranInput = document.getElementById('tahun_ajaran');
        const semesterTypeSelect = document.getElementById('semester_type');        // Validasi form dasar
        if (!prodiSelect.value || !semesterSelect.value || !hariSelect.value || 
            !tahunAjaranInput.value || !semesterTypeSelect.value) {
            alert('Mohon lengkapi semua informasi jadwal yang diperlukan');
            return;
        }
        
        // Ambil mata kuliah yang dipilih
        const selectedMatkulCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="jadwal_items"]:checked');
        if (selectedMatkulCheckboxes.length === 0) {
            alert('Mohon pilih minimal satu mata kuliah');
            return;
        }
        
        // Validasi semua dosen dan jam telah dipilih
        let allFieldsValid = true;
        let validationMsg = '';
        
        selectedMatkulCheckboxes.forEach(checkbox => {
            const matkulId = checkbox.id.replace('mk-', '');
            const dosenSelect = document.querySelector(`select[name="jadwal_items[${matkulId}][dosen_id]"]`);
            const jamMulaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_mulai]"]`);
            const jamSelesaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_selesai]"]`);
            
            // Validasi dosen
            if (!dosenSelect.value) {
                allFieldsValid = false;
                dosenSelect.classList.add('is-invalid');
                validationMsg = 'Mohon pilih dosen untuk setiap mata kuliah yang dipilih';
            } else {
                dosenSelect.classList.remove('is-invalid');
            }
            
            // Validasi jam mulai
            if (!jamMulaiInput.value) {
                allFieldsValid = false;
                jamMulaiInput.classList.add('is-invalid');
                validationMsg = 'Mohon isi jam mulai untuk setiap mata kuliah yang dipilih';
            } else {
                jamMulaiInput.classList.remove('is-invalid');
            }
            
            // Validasi jam selesai
            if (!jamSelesaiInput.value) {
                allFieldsValid = false;
                jamSelesaiInput.classList.add('is-invalid');
                validationMsg = 'Mohon isi jam selesai untuk setiap mata kuliah yang dipilih';
            } else if (jamMulaiInput.value && jamSelesaiInput.value && jamMulaiInput.value >= jamSelesaiInput.value) {
                allFieldsValid = false;
                jamSelesaiInput.classList.add('is-invalid');
                validationMsg = 'Jam selesai harus lebih besar dari jam mulai';
            } else {
                jamSelesaiInput.classList.remove('is-invalid');
            }
        });
        
        if (!allFieldsValid) {
            alert(validationMsg || 'Mohon lengkapi semua data mata kuliah yang dipilih');
            return;
        }
        
        // Isi summary - informasi umum
        document.getElementById('summary-prodi').textContent = prodiSelect.options[prodiSelect.selectedIndex].text;
        document.getElementById('summary-semester').textContent = semesterSelect.value;
        document.getElementById('summary-hari').textContent = hariSelect.value;
        document.getElementById('summary-tahun-ajaran').textContent = tahunAjaranInput.value + ' (' + semesterTypeSelect.options[semesterTypeSelect.selectedIndex].text + ')';
        document.getElementById('summary-matkul-count').textContent = selectedMatkulCheckboxes.length;
        
        // Tampilkan daftar mata kuliah yang dipilih dengan dosen masing-masing dan jamnya
        let matkulListHtml = '';
        selectedMatkulCheckboxes.forEach(checkbox => {
            const matkulId = checkbox.id.replace('mk-', '');
            const matkulInfo = document.querySelector(`.matakuliah-item #${checkbox.id}`).closest('.matakuliah-item').querySelector('.matakuliah-title').textContent;
            const dosenSelect = document.querySelector(`select[name="jadwal_items[${matkulId}][dosen_id]"]`);
            const jamMulaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_mulai]"]`);
            const jamSelesaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_selesai]"]`);
            const ruangInput = document.querySelector(`input[name="jadwal_items[${matkulId}][ruang]"]`);
            
            const dosenText = dosenSelect.options[dosenSelect.selectedIndex].text;
            const jamText = `${jamMulaiInput.value} - ${jamSelesaiInput.value}`;
            const ruangText = ruangInput.value ? ruangInput.value : '-';
            
            matkulListHtml += `
            <div class="summary-matkul-item">
                <strong>${matkulInfo}</strong>
                <div class="summary-detail">Dosen: ${dosenText}</div>
                <div class="summary-detail">Waktu: ${jamText}</div>
                <div class="summary-detail">Ruang: ${ruangText}</div>
            </div>
            `;
        });
        document.getElementById('summary-matkul-list').innerHTML = matkulListHtml;
        
        // Tampilkan summary
        summaryDiv.style.display = 'block';
        
        // Scroll ke summary
        summaryDiv.scrollIntoView({ behavior: 'smooth' });
    }
    
    // Function to update summary when selections change
    function updateSummary() {
        if (document.getElementById('jadwal-summary').style.display === 'block') {
            showSummary();
        }
    }

    // Event listener saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi event listeners
        const prodiSelect = document.getElementById('prodi_id');
        const semesterSelect = document.getElementById('semester');
        
        prodiSelect.addEventListener('change', loadMataKuliahBySemester);
        semesterSelect.addEventListener('change', loadMataKuliahBySemester);
        
        // Pre-fill tahun ajaran saat ini
        document.getElementById('tahun_ajaran').value = '2025/2026';
        
        // Form submit validation
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            // Check if at least one mata kuliah is selected
            const selectedMatkulCheckboxes = document.querySelectorAll('input[type="checkbox"][name^="jadwal_items"]:checked');
            
            if (selectedMatkulCheckboxes.length === 0) {
                e.preventDefault();
                alert('Mohon pilih minimal satu mata kuliah untuk dijadwalkan');
                return false;
            }
            
            // Validate each selected mata kuliah has dosen and time
            let allValid = true;
            let errorMsg = '';
            
            selectedMatkulCheckboxes.forEach(checkbox => {
                const matkulId = checkbox.id.replace('mk-', '');
                const dosenSelect = document.querySelector(`select[name="jadwal_items[${matkulId}][dosen_id]"]`);
                const jamMulaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_mulai]"]`);
                const jamSelesaiInput = document.querySelector(`input[name="jadwal_items[${matkulId}][jam_selesai]"]`);
                
                if (!dosenSelect.value) {
                    allValid = false;
                    errorMsg = 'Mohon pilih dosen untuk setiap mata kuliah yang dipilih';
                    dosenSelect.classList.add('is-invalid');
                } else {
                    dosenSelect.classList.remove('is-invalid');
                }
                
                if (!jamMulaiInput.value) {
                    allValid = false;
                    errorMsg = 'Mohon isi jam mulai untuk setiap mata kuliah yang dipilih';
                    jamMulaiInput.classList.add('is-invalid');
                } else {
                    jamMulaiInput.classList.remove('is-invalid');
                }
                
                if (!jamSelesaiInput.value) {
                    allValid = false;
                    errorMsg = 'Mohon isi jam selesai untuk setiap mata kuliah yang dipilih';
                    jamSelesaiInput.classList.add('is-invalid');
                } else if (jamMulaiInput.value >= jamSelesaiInput.value) {
                    allValid = false;
                    errorMsg = 'Jam selesai harus lebih besar dari jam mulai';
                    jamSelesaiInput.classList.add('is-invalid');
                } else {
                    jamSelesaiInput.classList.remove('is-invalid');
                }
            });
            
            if (!allValid) {
                e.preventDefault();
                alert(errorMsg);
                return false;
            }
            
            return true;
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/jadwalMahasiswa/create.blade.php ENDPATH**/ ?>