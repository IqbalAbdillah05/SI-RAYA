@extends('layouts.admin')

@section('title', 'Edit Presensi Mahasiswa')

@section('content')
<div class="presensi-edit">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Presensi Mahasiswa</h1>
        </div>
        <a href="{{ route('admin.manajemen-presensi-mahasiswa.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.manajemen-presensi-mahasiswa.update', $presensi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Mahasiswa (Locked) -->
                <div class="form-group">
                    <label for="mahasiswa_name">Mahasiswa <span class="required">*</span></label>
                    <input type="text" 
                           id="mahasiswa_name" 
                           class="form-control" 
                           value="{{ $presensi->mahasiswa->nama_lengkap }}"
                           disabled>
                    <input type="hidden" name="mahasiswa_id" value="{{ $presensi->mahasiswa_id }}">
                    <small class="form-text">Data mahasiswa tidak dapat diubah</small>
                </div>

                <!-- Dosen -->
                <div class="form-group">
                    <label for="dosen_id">Dosen Pengampu <span class="required">*</span></label>
                    <select name="dosen_id" id="dosen_id" class="form-control @error('dosen_id') is-invalid @enderror" required>
                        <option value="">Pilih Dosen</option>
                        @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_id', $presensi->dosen_id) == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama_lengkap }}
                        </option>
                        @endforeach
                    </select>
                    @error('dosen_id')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Mata Kuliah -->
                <div class="form-group">
                    <label for="mata_kuliah_id">Mata Kuliah <span class="required">*</span></label>
                    <select name="mata_kuliah_id" id="mata_kuliah_id" class="form-control @error('mata_kuliah_id') is-invalid @enderror" required>
                        <option value="">Pilih Mata Kuliah</option>
                        @foreach($mataKuliahs as $mataKuliah)
                        <option value="{{ $mataKuliah->id }}" {{ old('mata_kuliah_id', $presensi->mata_kuliah_id) == $mataKuliah->id ? 'selected' : '' }}>
                            {{ $mataKuliah->nama_matakuliah }}
                        </option>
                        @endforeach
                    </select>
                    @error('mata_kuliah_id')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Prodi -->
                <div class="form-group">
                    <label for="prodi_id">Program Studi <span class="required">*</span></label>
                    <select name="prodi_id" id="prodi_id" class="form-control @error('prodi_id') is-invalid @enderror" required>
                        <option value="">Pilih Program Studi</option>
                        @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('prodi_id', $presensi->prodi_id) == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->nama_prodi }}
                        </option>
                        @endforeach
                    </select>
                    @error('prodi_id')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Waktu Presensi -->
                <div class="form-group">
                    <label for="waktu_presensi">Waktu Presensi <span class="required">*</span></label>
                    <input type="datetime-local" 
                           name="waktu_presensi" 
                           id="waktu_presensi" 
                           class="form-control @error('waktu_presensi') is-invalid @enderror" 
                           value="{{ old('waktu_presensi', $presensi->waktu_presensi->format('Y-m-d\TH:i')) }}"
                           required>
                    @error('waktu_presensi')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">Pilih Status</option>
                        <option value="hadir" {{ old('status', $presensi->status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin" {{ old('status', $presensi->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ old('status', $presensi->status) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpha" {{ old('status', $presensi->status) == 'alpha' ? 'selected' : '' }}>Alpha</option>
                    </select>
                    @error('status')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Foto Bukti -->
                <div class="form-group foto-bukti-field" style="display: none;">
                    <label for="foto_bukti">Foto Bukti</label>
                    <input type="file" 
                           name="foto_bukti" 
                           id="foto_bukti" 
                           class="form-control @error('foto_bukti') is-invalid @enderror"
                           accept="image/*">
                    <small class="form-text">Upload foto bukti untuk status izin/sakit (jpg, jpeg, png)</small>
                    @if($presensi->foto_bukti)
                        <div class="current-photo mt-2">
                            <p class="mb-1">Foto saat ini:</p>
                            <img src="{{ Storage::url($presensi->foto_bukti) }}" 
                                 alt="Foto Bukti" 
                                 class="img-thumbnail"
                                 style="max-width: 200px;">
                        </div>
                    @endif
                    @error('foto_bukti')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Semester -->
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror">
                        <option value="">Pilih Semester</option>
                        @for($i = 1; $i <= 14; $i++)
                        <option value="{{ $i }}" {{ old('semester', $presensi->semester) == $i ? 'selected' : '' }}>
                            Semester {{ $i }}
                        </option>
                        @endfor
                    </select>
                    
                    @error('semester')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-group full-width">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" 
                              id="keterangan" 
                              class="form-control @error('keterangan') is-invalid @enderror" 
                              rows="3"
                              placeholder="Tambahkan keterangan jika diperlukan">{{ old('keterangan', $presensi->keterangan) }}</textarea>
                    <small class="form-text">Opsional. Maksimal 255 karakter</small>
                    @error('keterangan')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
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
                <a href="{{ route('admin.manajemen-presensi-mahasiswa.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
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
@endpush

@push('scripts')
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
@endpush
@endsection