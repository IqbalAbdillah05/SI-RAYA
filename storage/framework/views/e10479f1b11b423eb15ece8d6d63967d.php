

<?php $__env->startSection('title', 'Tambah Kartu Hasil Studi (KHS)'); ?>

<?php $__env->startSection('content'); ?>
<div class="khs-create">
    <!-- Header -->
    <div class="page-header">
        <h1>Tambah Kartu Hasil Studi (KHS)</h1>
        <a href="<?php echo e(route('admin.khs.index')); ?>" class="btn btn-secondary">
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
        <strong>Error Validasi:</strong>
        <ul style="margin: 10px 0 0 0; padding-left: 20px;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button class="close-alert" onclick="this.parentElement.remove()">&times;</button>
    </div>
    <?php endif; ?>

    <!-- Form Container -->
    <div class="form-container">
        <form action="<?php echo e(route('admin.khs.store')); ?>" method="POST" id="khsForm">
            <?php echo csrf_field(); ?>

            <!-- Mahasiswa Selection -->
            <div class="form-section">
                <h3>Informasi Mahasiswa</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Mahasiswa <span class="required">*</span></label>
                        <select name="mahasiswa_id" class="form-control" required>
                            <option value="">Pilih Mahasiswa</option>
                            <?php $__currentLoopData = $mahasiswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mahasiswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($mahasiswa->id); ?>" 
                                    <?php echo e(old('mahasiswa_id') == $mahasiswa->id ? 'selected' : ''); ?>>
                                    <?php echo e($mahasiswa->nama_lengkap); ?> (<?php echo e($mahasiswa->nim); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <select name="prodi_id" class="form-control">
                            <option value="">Pilih Program Studi</option>
                            <?php $__currentLoopData = $prodis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($prodi->id); ?>" 
                                    <?php echo e(old('prodi_id') == $prodi->id ? 'selected' : ''); ?>>
                                    <?php echo e($prodi->nama_prodi); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" class="form-control">
                            <option value="">Pilih Semester</option>
                            <?php for($i = 1; $i <= 14; $i++): ?>
                                <option value="<?php echo e($i); ?>" 
                                    <?php echo e(old('semester') == $i ? 'selected' : ''); ?>>
                                    Semester <?php echo e($i); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun Ajaran <span class="required">*</span></label>
                        <input type="text" name="tahun_ajaran" class="form-control" 
                               placeholder="Contoh: 2024/2025" 
                               value="<?php echo e(old('tahun_ajaran')); ?>" required>
                    </div>
                </div>
            </div>

                    <!-- Mata Kuliah Details -->
                    <div class="form-section mata-kuliah-section">
                        <h3>Detail Mata Kuliah</h3>
                        <div id="mataKuliahContainer">
                            <div class="mata-kuliah-row form-grid" data-row-index="0">
                                <div class="form-group">
                                    <label>Mata Kuliah <span class="required">*</span></label>
                                    <select name="mata_kuliah[0]" class="form-control mata-kuliah-select" required>
                                        <option value="">Pilih Mata Kuliah</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Pilih Nilai Mahasiswa</label>
                                    <select name="nilai_mahasiswa[0]" class="form-control nilai-mahasiswa-select">
                                        <option value="">Pilih Nilai (Opsional)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nilai Angka</label>
                                    <input type="number" name="nilai_angka[0]" class="form-control" 
                                           min="0" max="100" step="0.01">
                                </div>
                                <div class="form-group">
                                    <label>SKS <span class="required">*</span></label>
                                    <input type="number" name="sks[0]" class="form-control" 
                                           min="1" max="6" required>
                                </div>
                                <div class="form-group remove-button-group">
                                    <button type="button" class="btn btn-danger remove-mata-kuliah" style="display:none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <button type="button" id="tambahMataKuliah" class="btn btn-secondary">
                                <i class="fas fa-plus"></i> Tambah Mata Kuliah
                            </button>
                        </div>
                    </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan KHS
                </button>
                <a href="<?php echo e(route('admin.khs.index')); ?>" class="btn btn-secondary">
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

    .khs-create {
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

    .btn-primary:hover {
        opacity: 0.9;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        opacity: 0.9;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
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

    /* Form Container */
    .form-container {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        padding: 20px;
    }

    .form-section {
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .form-section:last-of-type {
        border-bottom: none;
    }

    .form-section h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0 0 15px 0;
        color: #333;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 3px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        outline: none;
        border-color: #007bff;
    }

    .form-control:disabled {
        background-color: #f5f5f5;
        cursor: not-allowed;
        opacity: 0.6;
    }

    /* Mata Kuliah Row */
    .mata-kuliah-row {
        position: relative;
        margin-bottom: 10px;
    }

    .remove-mata-kuliah {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
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
    const mataKuliahContainer = document.getElementById('mataKuliahContainer');
    const tambahMataKuliahBtn = document.getElementById('tambahMataKuliah');
    const mahasiswaSelect = document.querySelector('select[name="mahasiswa_id"]');
    const prodiSelect = document.querySelector('select[name="prodi_id"]');
    const semesterSelect = document.querySelector('select[name="semester"]');

    // Data dari backend
    const mahasiswas = <?php echo json_encode($mahasiswas, 15, 512) ?>;
    const mataKuliah = <?php echo json_encode($mataKuliah, 15, 512) ?>;
    const nilaiMahasiswa = <?php echo json_encode($nilaiMahasiswa, 15, 512) ?>;
    const mahasiswaSemesters = <?php echo json_encode($mahasiswaSemesters, 15, 512) ?>;

    let rowCounter = 0;

    // Fungsi untuk populate mata kuliah dropdown
    function populateMataKuliah(selectElement, mahasiswaId) {
        selectElement.innerHTML = '<option value="">Pilih Mata Kuliah</option>';
        
        if (mahasiswaId && mataKuliah[mahasiswaId]) {
            mataKuliah[mahasiswaId].forEach(mk => {
                const option = document.createElement('option');
                option.value = mk.id;
                option.textContent = `${mk.kode_matakuliah || ''} - ${mk.nama_matakuliah}`;
                option.setAttribute('data-sks', mk.sks || '');
                selectElement.appendChild(option);
            });
        }
    }

    // Fungsi untuk populate nilai mahasiswa dropdown
    function populateNilaiMahasiswa(selectElement, mahasiswaId) {
        selectElement.innerHTML = '<option value="">Pilih Nilai (Opsional)</option>';
        
        if (mahasiswaId && nilaiMahasiswa[mahasiswaId]) {
            nilaiMahasiswa[mahasiswaId].forEach(nm => {
                const option = document.createElement('option');
                option.value = nm.id;
                option.setAttribute('data-mk-id', nm.mata_kuliah_id || nm.mata_kuliah.id);
                option.setAttribute('data-nilai', nm.nilai_angka);
                option.setAttribute('data-sks', nm.mata_kuliah.sks);
                option.textContent = `${nm.mata_kuliah.nama_matakuliah} - Nilai: ${nm.nilai_angka}`;
                selectElement.appendChild(option);
            });
        }
    }

    // Fungsi untuk setup event listeners pada row
    function setupRowEventListeners(row, mahasiswaId) {
        const mataKuliahSelect = row.querySelector('.mata-kuliah-select');
        const nilaiMahasiswaSelect = row.querySelector('.nilai-mahasiswa-select');
        const nilaiAngkaInput = row.querySelector('input[name^="nilai_angka"]');
        const sksInput = row.querySelector('input[name^="sks"]');

        // Event listener untuk memilih mata kuliah
        mataKuliahSelect.addEventListener('change', function() {
            const selectedMataKuliahId = this.value;
            
            if (!mahasiswaId || !selectedMataKuliahId) {
                nilaiAngkaInput.value = '';
                sksInput.value = '';
                nilaiMahasiswaSelect.selectedIndex = 0;
                return;
            }

            // Cari nilai mahasiswa yang sesuai dengan mata kuliah yang dipilih
            const matchingNilai = nilaiMahasiswa[mahasiswaId]?.find(nm => {
                const mkId = nm.mata_kuliah_id || nm.mata_kuliah.id;
                return mkId == selectedMataKuliahId;
            });
            
            if (matchingNilai) {
                // Jika ada nilai mahasiswa untuk mata kuliah ini
                nilaiAngkaInput.value = matchingNilai.nilai_angka;
                sksInput.value = matchingNilai.mata_kuliah.sks;
                nilaiMahasiswaSelect.value = matchingNilai.id;
            } else {
                // Jika tidak ada nilai, ambil SKS dari data mata kuliah
                const selectedOption = this.options[this.selectedIndex];
                const sksFromOption = selectedOption.getAttribute('data-sks');
                
                if (sksFromOption) {
                    sksInput.value = sksFromOption;
                } else {
                    // Fallback: cari dari array mataKuliah
                    const mkData = mataKuliah[mahasiswaId]?.find(mk => mk.id == selectedMataKuliahId);
                    sksInput.value = mkData?.sks || '';
                }
                
                nilaiAngkaInput.value = '';
                nilaiMahasiswaSelect.selectedIndex = 0;
            }
        });

        // Event listener untuk memilih nilai mahasiswa
        nilaiMahasiswaSelect.addEventListener('change', function() {
            const selectedNilaiId = this.value;
            
            if (!mahasiswaId || !selectedNilaiId) {
                nilaiAngkaInput.value = '';
                sksInput.value = '';
                mataKuliahSelect.selectedIndex = 0;
                return;
            }

            const selectedOption = this.options[this.selectedIndex];
            const mkIdFromNilai = selectedOption.getAttribute('data-mk-id');
            const nilaiAngka = selectedOption.getAttribute('data-nilai');
            const sks = selectedOption.getAttribute('data-sks');
            
            // Set nilai dan SKS
            nilaiAngkaInput.value = nilaiAngka || '';
            sksInput.value = sks || '';
            
            // Set mata kuliah yang sesuai
            mataKuliahSelect.value = mkIdFromNilai || '';
        });

        // Event listener untuk tombol hapus
        const removeButton = row.querySelector('.remove-mata-kuliah');
        removeButton.addEventListener('click', function() {
            row.remove();
            updateRowIndices();
            
            // Tampilkan tombol hapus hanya jika ada lebih dari 1 row
            updateRemoveButtons();
        });
    }

    // Fungsi untuk menambah baris mata kuliah
    function tambahMataKuliahRow() {
        const selectedMahasiswaId = mahasiswaSelect.value;
        
        if (!selectedMahasiswaId) {
            alert('Silakan pilih mahasiswa terlebih dahulu!');
            return;
        }

        // Buat elemen row baru
        const row = document.createElement('div');
        row.className = 'mata-kuliah-row form-grid';
        row.setAttribute('data-row-index', rowCounter);
        
        row.innerHTML = `
            <div class="form-group">
                <label>Mata Kuliah <span class="required">*</span></label>
                <select name="mata_kuliah[${rowCounter}]" class="form-control mata-kuliah-select" required>
                    <option value="">Pilih Mata Kuliah</option>
                </select>
            </div>
            <div class="form-group">
                <label>Pilih Nilai Mahasiswa</label>
                <select name="nilai_mahasiswa[${rowCounter}]" class="form-control nilai-mahasiswa-select">
                    <option value="">Pilih Nilai (Opsional)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nilai Angka</label>
                <input type="number" name="nilai_angka[${rowCounter}]" class="form-control" 
                       min="0" max="100" step="0.01">
            </div>
            <div class="form-group">
                <label>SKS <span class="required">*</span></label>
                <input type="number" name="sks[${rowCounter}]" class="form-control" 
                       min="1" max="6" required>
            </div>
            <div class="form-group remove-button-group">
                <button type="button" class="btn btn-danger remove-mata-kuliah">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

        // Populate dropdowns
        const mataKuliahSelect = row.querySelector('.mata-kuliah-select');
        const nilaiMahasiswaSelect = row.querySelector('.nilai-mahasiswa-select');
        
        populateMataKuliah(mataKuliahSelect, selectedMahasiswaId);
        populateNilaiMahasiswa(nilaiMahasiswaSelect, selectedMahasiswaId);

        // Setup event listeners
        setupRowEventListeners(row, selectedMahasiswaId);

        // Tambahkan ke container
        mataKuliahContainer.appendChild(row);
        
        rowCounter++;
        
        // Update tampilan tombol hapus
        updateRemoveButtons();
    }

    // Fungsi untuk memperbarui indeks baris
    function updateRowIndices() {
        const rows = mataKuliahContainer.querySelectorAll('.mata-kuliah-row');
        rows.forEach((row, index) => {
            row.setAttribute('data-row-index', index);
            
            row.querySelector('select[name^="mata_kuliah"]').name = `mata_kuliah[${index}]`;
            row.querySelector('select[name^="nilai_mahasiswa"]').name = `nilai_mahasiswa[${index}]`;
            row.querySelector('input[name^="nilai_angka"]').name = `nilai_angka[${index}]`;
            row.querySelector('input[name^="sks"]').name = `sks[${index}]`;
        });
    }

    // Fungsi untuk update tampilan tombol hapus
    function updateRemoveButtons() {
        const rows = mataKuliahContainer.querySelectorAll('.mata-kuliah-row');
        rows.forEach((row, index) => {
            const removeBtn = row.querySelector('.remove-mata-kuliah');
            if (rows.length > 1) {
                removeBtn.style.display = 'inline-flex';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }

    // Event listener untuk tombol tambah mata kuliah
    tambahMataKuliahBtn.addEventListener('click', function(e) {
        e.preventDefault();
        tambahMataKuliahRow();
    });

    // Event listener untuk mahasiswa select
    mahasiswaSelect.addEventListener('change', function() {
        const selectedMahasiswaId = this.value;
        
        if (!selectedMahasiswaId) {
            // Reset container jika tidak ada mahasiswa dipilih
            mataKuliahContainer.innerHTML = '';
            rowCounter = 0;
            prodiSelect.value = '';
            semesterSelect.value = '';
            return;
        }

        const selectedMahasiswa = mahasiswas.find(m => m.id == selectedMahasiswaId);
        
        if (selectedMahasiswa) {
            // Set prodi sesuai mahasiswa
            prodiSelect.value = selectedMahasiswa.prodi_id || '';

            // Set semester sesuai mahasiswa
            semesterSelect.value = mahasiswaSemesters[selectedMahasiswaId] || '';

            // Reset container dan counter
            mataKuliahContainer.innerHTML = '';
            rowCounter = 0;
            
            // Tambah baris pertama otomatis
            tambahMataKuliahRow();
        }
    });

    // Validasi form sebelum submit
    document.getElementById('khsForm').addEventListener('submit', function(e) {
        const rows = mataKuliahContainer.querySelectorAll('.mata-kuliah-row');
        
        if (rows.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 mata kuliah!');
            return false;
        }

        const mataKuliahSelects = document.querySelectorAll('select[name^="mata_kuliah"]');
        const sksInputs = document.querySelectorAll('input[name^="sks"]');

        // Validasi mata kuliah tidak boleh duplikat
        const mataKuliahValues = Array.from(mataKuliahSelects)
            .map(select => select.value)
            .filter(val => val !== '');
        
        const uniqueMataKuliah = new Set(mataKuliahValues);
        
        if (mataKuliahValues.length !== uniqueMataKuliah.size) {
            e.preventDefault();
            alert('Mata kuliah tidak boleh duplikat!');
            return false;
        }

        // Validasi input
        for (let i = 0; i < mataKuliahSelects.length; i++) {
            if (!mataKuliahSelects[i].value || !sksInputs[i].value) {
                e.preventDefault();
                alert('Mata kuliah dan SKS harus diisi!');
                return false;
            }
        }
    });

    // Inisialisasi: Jika ada mahasiswa yang sudah dipilih (old input)
    if (mahasiswaSelect.value) {
        const selectedMahasiswaId = mahasiswaSelect.value;
        const selectedMahasiswa = mahasiswas.find(m => m.id == selectedMahasiswaId);
        
        if (selectedMahasiswa) {
            prodiSelect.value = selectedMahasiswa.prodi_id || '';
            semesterSelect.value = mahasiswaSemesters[selectedMahasiswaId] || '';
            tambahMataKuliahRow();
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\si-raya\resources\views/admin/khs/create.blade.php ENDPATH**/ ?>