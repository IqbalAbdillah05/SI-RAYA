

<?php $__env->startSection('title', 'Edit Presensi Dosen'); ?>

<?php $__env->startSection('content'); ?>
<div class="presensi-edit">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Presensi Dosen</h1>
            <p class="subtitle">Perbarui informasi presensi dosen</p>
        </div>
        <a href="<?php echo e(route('admin.manajemen-presensi-dosen.index')); ?>" class="btn btn-secondary">
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
        <form action="<?php echo e(route('admin.manajemen-presensi-dosen.update', $presensi)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">
                <!-- Dosen (Locked) -->
                <div class="form-group">
                    <label for="dosen_name">Dosen <span class="required">*</span></label>
                    <input type="text" 
                           id="dosen_name" 
                           class="form-control" 
                           value="<?php echo e($presensi->dosen->nama_lengkap ?? $presensi->dosen->name); ?>"
                           disabled>
                    <input type="hidden" name="dosen_id" value="<?php echo e($presensi->dosen_id); ?>">
                    <small class="form-text">Data dosen tidak dapat diubah</small>
                </div>

                <!-- Lokasi -->
                <div class="form-group">
                    <label for="lokasi_id">Lokasi <span class="required">*</span></label>
                    <select name="lokasi_id" id="lokasi_id" class="form-control <?php $__errorArgs = ['lokasi_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Pilih Lokasi</option>
                        <?php $__currentLoopData = $lokasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lokasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($lokasi->id); ?>" 
                                data-lat="<?php echo e($lokasi->latitude); ?>" 
                                data-lng="<?php echo e($lokasi->longitude); ?>"
                                <?php echo e(old('lokasi_id', $presensi->lokasi_id) == $lokasi->id ? 'selected' : ''); ?>>
                            <?php echo e($lokasi->nama_lokasi); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <small class="form-text" id="lokasi-help-text">Pilih lokasi presensi</small>
                    <?php $__errorArgs = ['lokasi_id'];
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
                           value="<?php echo e(old('waktu_presensi', \Carbon\Carbon::parse($presensi->waktu_presensi)->format('Y-m-d\TH:i'))); ?>"
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

                <!-- Presensi Ke -->
                <div class="form-group">
                    <label for="presensi_ke">Presensi</label>
                    <select name="presensi_ke" id="presensi_ke" class="form-control <?php $__errorArgs = ['presensi_ke'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Pilih Presensi</option>
                        <option value="ke-1" <?php echo e(old('presensi_ke', $presensi->presensi_ke) == 'ke-1' ? 'selected' : ''); ?>>Ke-1</option>
                        <option value="ke-2" <?php echo e(old('presensi_ke', $presensi->presensi_ke) == 'ke-2' ? 'selected' : ''); ?>>Ke-2</option>
                    </select>
                    <small class="form-text">Opsional. Pilih presensi ke-1 atau ke-2</small>
                    <?php $__errorArgs = ['presensi_ke'];
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

                <!-- Latitude -->
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" 
                           name="latitude" 
                           id="latitude" 
                           class="form-control <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('latitude', $presensi->status === 'hadir' ? $presensi->latitude : '0')); ?>"
                           placeholder="Contoh: -8.1234567"
                           <?php echo e($presensi->status === 'izin' || $presensi->status === 'sakit' ? 'readonly' : ''); ?>>
                    <small class="form-text">
                        <?php if($presensi->status === 'izin' || $presensi->status === 'sakit'): ?>
                            Koordinat tidak berlaku untuk status Izin/Sakit
                        <?php else: ?>
                            Otomatis terisi sesuai lokasi yang dipilih
                        <?php endif; ?>
                    </small>
                    <?php $__errorArgs = ['latitude'];
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

                <!-- Longitude -->
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" 
                           name="longitude" 
                           id="longitude" 
                           class="form-control <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('longitude', $presensi->status === 'hadir' ? $presensi->longitude : '0')); ?>"
                           placeholder="Contoh: 113.1234567"
                           <?php echo e($presensi->status === 'izin' || $presensi->status === 'sakit' ? 'readonly' : ''); ?>>
                    <small class="form-text">
                        <?php if($presensi->status === 'izin' || $presensi->status === 'sakit'): ?>
                            Koordinat tidak berlaku untuk status Izin/Sakit
                        <?php else: ?>
                            Otomatis terisi sesuai lokasi yang dipilih
                        <?php endif; ?>
                    </small>
                    <?php $__errorArgs = ['longitude'];
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

                <!-- Jarak Masuk -->
                <div class="form-group">
                    <label for="jarak_masuk">Jarak Masuk (meter)</label>
                    <input type="number" 
                           name="jarak_masuk" 
                           id="jarak_masuk" 
                           class="form-control <?php $__errorArgs = ['jarak_masuk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                           value="<?php echo e(old('jarak_masuk', $presensi->status === 'hadir' ? $presensi->jarak_masuk : '0')); ?>"
                           step="0.01"
                           min="0"
                           placeholder="Contoh: 25.50"
                           <?php echo e($presensi->status === 'izin' || $presensi->status === 'sakit' ? 'readonly' : ''); ?>>
                    <small class="form-text">
                        <?php if($presensi->status === 'izin' || $presensi->status === 'sakit'): ?>
                            Jarak tidak berlaku untuk status Izin/Sakit
                        <?php else: ?>
                            Opsional. Jarak dalam meter
                        <?php endif; ?>
                    </small>
                    <?php $__errorArgs = ['jarak_masuk'];
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
                              placeholder="Masukkan keterangan (opsional)"><?php echo e(old('keterangan', $presensi->keterangan)); ?></textarea>
                    <small class="form-text">Opsional. Tambahkan keterangan jika diperlukan</small>
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

                <!-- Foto Bukti -->
                <div class="form-group full-width" id="fotoBuktiContainer">
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
                    <small class="form-text">Upload foto bukti jika status izin/sakit (format: jpg, jpeg, png, max: 2MB)</small>
                    <?php if($presensi->foto_bukti): ?>
                        <div class="current-foto mt-2">
                            <img src="<?php echo e(asset('storage/' . $presensi->foto_bukti)); ?>" alt="Foto Bukti" style="max-width: 200px; height: auto;">
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
            </div>

            <!-- Info Note -->
            <div class="info-note">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Catatan:</strong>
                    <p>Latitude dan longitude akan otomatis terisi sesuai dengan lokasi yang dipilih. Data dosen tidak dapat diubah untuk menjaga integritas data presensi.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="<?php echo e(route('admin.manajemen-presensi-dosen.index')); ?>" class="btn btn-secondary">
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
        margin: 0 0 4px 0;
        font-size: 24px;
        font-weight: 600;
        color: #1f2937;
    }

    .subtitle {
        margin: 0;
        color: #6b7280;
        font-size: 14px;
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

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
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

    .form-control.is-invalid {
        border-color: #ef4444;
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
        const lokasiSelect = document.getElementById('lokasi_id');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const jarakMasukInput = document.getElementById('jarak_masuk');
        const lokasiHelpText = document.getElementById('lokasi-help-text');

        // Function to update coordinates and location based on status
        function updateLocationFields() {
            const status = statusSelect.value;
            
            if (status === 'izin' || status === 'sakit') {
                // Set lokasi to empty and make it readonly
                lokasiSelect.value = '';
                lokasiSelect.style.pointerEvents = 'none';
                lokasiSelect.style.backgroundColor = '#e9ecef';
                lokasiSelect.removeAttribute('required');
                
                if (lokasiHelpText) {
                    lokasiHelpText.textContent = 'Lokasi tidak diperlukan untuk status Izin/Sakit';
                }
                
                // Clear and make readonly latitude, longitude, jarak_masuk
                latitudeInput.value = '0';
                longitudeInput.value = '0';
                jarakMasukInput.value = '0';
                
                latitudeInput.readOnly = true;
                longitudeInput.readOnly = true;
                jarakMasukInput.readOnly = true;
            } else {
                // Enable fields for 'hadir' or 'alpha' status
                lokasiSelect.style.pointerEvents = 'auto';
                lokasiSelect.style.backgroundColor = '';
                lokasiSelect.setAttribute('required', 'required');
                
                if (lokasiHelpText) {
                    lokasiHelpText.textContent = 'Pilih lokasi presensi';
                }
                
                latitudeInput.readOnly = false;
                longitudeInput.readOnly = false;
                jarakMasukInput.readOnly = false;
                
                // Restore original coordinates if a location was previously selected
                const selectedOption = lokasiSelect.options[lokasiSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    const lat = selectedOption.getAttribute('data-lat');
                    const lng = selectedOption.getAttribute('data-lng');
                    
                    if (lat && lng) {
                        latitudeInput.value = lat;
                        longitudeInput.value = lng;
                    }
                }
            }
        }

        // Initial call to set up fields based on current status
        updateLocationFields();

        // Listen for status change
        statusSelect.addEventListener('change', updateLocationFields);

        // Existing location update logic
        function updateCoordinates() {
            const selectedOption = lokasiSelect.options[lokasiSelect.selectedIndex];
            
            if (selectedOption.value && (statusSelect.value === 'hadir' || statusSelect.value === 'alpha')) {
                const lat = selectedOption.getAttribute('data-lat');
                const lng = selectedOption.getAttribute('data-lng');
                
                if (lat && lng) {
                    latitudeInput.value = lat;
                    longitudeInput.value = lng;
                } else {
                    latitudeInput.value = '';
                    longitudeInput.value = '';
                }
            }
        }

        // Listen for location change
        if (lokasiSelect) {
            lokasiSelect.addEventListener('change', updateCoordinates);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/manajemenPresensiDosen/edit.blade.php ENDPATH**/ ?>