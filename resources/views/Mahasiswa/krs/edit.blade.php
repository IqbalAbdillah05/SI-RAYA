@extends('layouts.mahasiswa')

@section('title', 'Edit KRS')

@section('content')

    <div class="card-info" style="background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%); border: none; padding: 24px; border-radius: 12px; margin-bottom: 20px; color: white;">
        <div>
            <h4 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600;">
                <i class="fas fa-edit"></i> Edit KRS
            </h4>
            <p style="margin: 0; opacity: 0.95; font-size: 14px;">
                Ubah mata kuliah yang akan diambil semester {{ $krs->semester }}
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('mahasiswa.krs.update', $krs->id) }}" method="POST" id="krsForm">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card-simple">
                    <h5 class="mb-3" style="color: #0B6623; font-weight: 600;">
                        <i class="fas fa-info-circle me-2"></i>Informasi KRS
                    </h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="semester" class="form-label">Semester</label>
                            <input type="text" class="form-control" id="semester" value="{{ $krs->semester }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                                   id="tahun_ajaran" name="tahun_ajaran" 
                                   placeholder="Contoh: 2024/2025" 
                                   value="{{ old('tahun_ajaran', $krs->tahun_ajaran) }}" required>
                            @error('tahun_ajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Perhatian:</strong> Pilih mata kuliah dengan mencentang checkbox di bawah. Total SKS yang dapat diambil maksimal 24 SKS.
                    </div>
                    
                    @if($krs->status_validasi == 'pending')
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Informasi:</strong> KRS ini masih dalam status menunggu validasi. Anda masih dapat mengubah pilihan mata kuliah.
                        </div>
                    @endif
                </div>

                @if($mataKuliahList->count() > 0)
                    @foreach($mataKuliahList as $mataKuliah)
                        <div class="matakuliah-item-krs" onclick="toggleMataKuliah({{ $mataKuliah->id }})">
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                <input type="checkbox" 
                                       class="matakuliah-checkbox-krs" 
                                       name="mata_kuliah_ids[]" 
                                       value="{{ $mataKuliah->id }}" 
                                       id="matakuliah_{{ $mataKuliah->id }}"
                                       data-sks="{{ $mataKuliah->sks ?? 0 }}"
                                       onchange="updateTotalSks()"
                                       {{ in_array($mataKuliah->id, $selectedMataKuliahIds) ? 'checked' : '' }}>
                                
                                <div class="flex-grow-1">
                                    <div class="matakuliah-title-krs">
                                        {{ $mataKuliah->kode_matakuliah ?? '-' }} - {{ $mataKuliah->nama_matakuliah ?? '-' }}
                                    </div>
                                    <div class="matakuliah-meta-krs">
                                        <span><i class="fas fa-layer-group"></i> Semester {{ $mataKuliah->semester ?? '-' }}</span>
                                    </div>
                                </div>
                                
                                <div class="sks-badge-krs">
                                    {{ $mataKuliah->sks ?? 0 }} SKS
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card-simple">
                        <div class="empty-state">
                            <div class="empty-icon"><i class="fas fa-book-open"></i></div>
                            <h3>Tidak Ada Mata Kuliah Tersedia</h3>
                            <p>Belum ada mata kuliah untuk semester dan program studi Anda.</p>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <div class="total-sks-card-krs">
                    <h4><i class="fas fa-graduation-cap me-2"></i>Total SKS</h4>
                    <div class="total-sks-display-krs" id="totalSks">0</div>
                    <div class="total-sks-label-krs">SKS Terpilih</div>
                    
                    <hr style="border-color: rgba(255,255,255,0.3); margin: 1.5rem 0;">
                    
                    <div class="mb-3">
                        <small class="d-block mb-1">Jumlah Mata Kuliah:</small>
                        <strong style="font-size: 1.5rem;" id="totalMk">0</strong> MK
                    </div>
                    
                    <div class="mb-4">
                        <small class="d-block mb-1">Batas Maksimal SKS:</small>
                        <strong style="font-size: 1.5rem;">24</strong> SKS
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn-green-krs" id="submitBtn" disabled>
                            <i class="fas fa-save"></i>
                            <span>Update KRS</span>
                        </button>
                        <a href="{{ route('mahasiswa.krs.show', $krs->id) }}" class="btn-secondary-krs">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

@push('styles')
<style>
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
    
    .day-section-krs {
        background: white;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }
    
    .day-header-krs {
        background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%);
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-weight: 600;
        font-size: 16px;
    }
    
    .matakuliah-item-krs {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
    }
    
    .matakuliah-item-krs:hover {
        border-color: #0B6623;
        background: #f0fdf4;
    }
    
    .matakuliah-item-krs.selected {
        border-color: #0B6623;
        background: #dcfce7;
    }
    
    .matakuliah-checkbox-krs {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #0B6623;
    }
    
    .matakuliah-title-krs {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        font-size: 15px;
    }
    
    .matakuliah-meta-krs {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        color: #64748b;
        font-size: 13px;
    }
    
    .matakuliah-meta-krs i {
        color: #0B6623;
        margin-right: 4px;
    }
    
    .sks-badge-krs {
        background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
    }
    
    .total-sks-card-krs {
        position: sticky;
        top: 20px;
        background: linear-gradient(135deg, #0B6623 0%, #0a5a1f 100%);
        color: white;
        padding: 24px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(11, 102, 35, 0.3);
    }
    
    .total-sks-card-krs h4 {
        color: white;
        margin: 0 0 16px 0;
        font-size: 18px;
        font-weight: 600;
    }
    
    .total-sks-display-krs {
        font-size: 48px;
        font-weight: 700;
        text-align: center;
        margin: 16px 0;
    }
    
    .total-sks-label-krs {
        text-align: center;
        opacity: 0.9;
        font-size: 16px;
    }
    
    .btn-green-krs {
        background: white;
        color: #0B6623;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        font-weight: 600;
        width: 100%;
    }
    
    .btn-green-krs:hover:not(:disabled) {
        background: #f0fdf4;
        color: #0B6623;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255,255,255,0.3);
    }
    
    .btn-green-krs:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .btn-secondary-krs {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid white;
        padding: 12px 24px;
        border-radius: 6px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s ease;
        font-weight: 500;
        width: 100%;
    }
    
    .btn-secondary-krs:hover {
        background: rgba(255,255,255,0.3);
        color: white;
    }
    
    .alert {
        padding: 16px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }
    
    .alert-info {
        background-color: #dbeafe;
        border-color: #bfdbfe;
        color: #1e40af;
    }
    
    .alert-danger {
        background-color: #fee2e2;
        border-color: #fecaca;
        color: #991b1b;
    }
    
    .alert-warning {
        background-color: #fef3c7;
        border-color: #fde68a;
        color: #92400e;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 64px;
        color: #ccc;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #333;
        margin-bottom: 10px;
        font-size: 20px;
    }

    .empty-state p {
        color: #666;
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleMataKuliah(mataKuliahId) {
        const checkbox = document.getElementById('matakuliah_' + mataKuliahId);
        checkbox.checked = !checkbox.checked;
        updateTotalSks();
    }
    
    function updateTotalSks() {
        const checkboxes = document.querySelectorAll('.matakuliah-checkbox-krs:checked');
        let totalSks = 0;
        let totalMk = 0;
        
        checkboxes.forEach(checkbox => {
            const sks = parseInt(checkbox.dataset.sks) || 0;
            totalSks += sks;
            totalMk++;
            
            const matakuliahItem = checkbox.closest('.matakuliah-item-krs');
            matakuliahItem.classList.add('selected');
        });
        
        document.querySelectorAll('.matakuliah-checkbox-krs:not(:checked)').forEach(checkbox => {
            const matakuliahItem = checkbox.closest('.matakuliah-item-krs');
            matakuliahItem.classList.remove('selected');
        });
        
        document.getElementById('totalSks').textContent = totalSks;
        document.getElementById('totalMk').textContent = totalMk;
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = !(totalMk > 0 && totalSks <= 24);
        
        const existingWarning = document.getElementById('sksWarning');
        if (totalSks > 24) {
            if (!existingWarning) {
                const warning = document.createElement('div');
                warning.id = 'sksWarning';
                warning.className = 'alert alert-warning mt-3';
                warning.style.marginTop = '16px';
                warning.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Total SKS melebihi batas maksimal (24 SKS)!';
                document.querySelector('.total-sks-card-krs').appendChild(warning);
            }
        } else if (existingWarning) {
            existingWarning.remove();
        }
    }
    
    document.querySelectorAll('.matakuliah-checkbox-krs').forEach(checkbox => {
        checkbox.addEventListener('click', function(e) {
            e.stopPropagation();
            updateTotalSks();
        });
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        updateTotalSks();
    });
    
    document.getElementById('krsForm').addEventListener('submit', function(e) {
        const totalMk = parseInt(document.getElementById('totalMk').textContent);
        const totalSks = parseInt(document.getElementById('totalSks').textContent);
        
        if (totalMk === 0) {
            e.preventDefault();
            alert('Silakan pilih minimal 1 mata kuliah!');
            return false;
        }
        
        if (totalSks > 24) {
            e.preventDefault();
            alert('Total SKS tidak boleh melebihi 24 SKS!');
            return false;
        }
    });
</script>
@endpush
@endsection
