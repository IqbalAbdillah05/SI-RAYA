@extends('layouts.admin')

@section('title', 'Edit Presensi Dosen')

@section('content')
<div class="presensi-edit">
    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>Edit Presensi Dosen</h1>
            <p class="subtitle">Perbarui informasi presensi dosen</p>
        </div>
        <a href="{{ route('admin.manajemen-presensi-dosen.index') }}" class="btn btn-secondary">
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
        <form action="{{ route('admin.manajemen-presensi-dosen.update', $presensi) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Dosen (Locked) -->
                <div class="form-group">
                    <label for="dosen_name">Dosen <span class="required">*</span></label>
                    <input type="text" 
                           id="dosen_name" 
                           class="form-control" 
                           value="{{ $presensi->dosen->nama_lengkap ?? $presensi->dosen->name }}"
                           disabled>
                    <input type="hidden" name="dosen_id" value="{{ $presensi->dosen_id }}">
                    <small class="form-text">Data dosen tidak dapat diubah</small>
                </div>

                <!-- Lokasi -->
                <div class="form-group">
                    <label for="lokasi_id">Lokasi <span class="required">*</span></label>
                    <select name="lokasi_id" id="lokasi_id" class="form-control @error('lokasi_id') is-invalid @enderror">
                        <option value="">Pilih Lokasi</option>
                        @foreach($lokasis as $lokasi)
                        <option value="{{ $lokasi->id }}" 
                                data-lat="{{ $lokasi->latitude }}" 
                                data-lng="{{ $lokasi->longitude }}"
                                {{ old('lokasi_id', $presensi->lokasi_id) == $lokasi->id ? 'selected' : '' }}>
                            {{ $lokasi->nama_lokasi }}
                        </option>
                        @endforeach
                    </select>
                    <small class="form-text" id="lokasi-help-text">Pilih lokasi presensi</small>
                    @error('lokasi_id')
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
                           value="{{ old('waktu_presensi', \Carbon\Carbon::parse($presensi->waktu_presensi)->format('Y-m-d\TH:i')) }}"
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

                <!-- Presensi Ke -->
                <div class="form-group">
                    <label for="presensi_ke">Presensi</label>
                    <select name="presensi_ke" id="presensi_ke" class="form-control @error('presensi_ke') is-invalid @enderror">
                        <option value="">Pilih Presensi</option>
                        <option value="ke-1" {{ old('presensi_ke', $presensi->presensi_ke) == 'ke-1' ? 'selected' : '' }}>Ke-1</option>
                        <option value="ke-2" {{ old('presensi_ke', $presensi->presensi_ke) == 'ke-2' ? 'selected' : '' }}>Ke-2</option>
                    </select>
                    <small class="form-text">Opsional. Pilih presensi ke-1 atau ke-2</small>
                    @error('presensi_ke')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Latitude -->
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" 
                           name="latitude" 
                           id="latitude" 
                           class="form-control @error('latitude') is-invalid @enderror" 
                           value="{{ old('latitude', $presensi->status === 'hadir' ? $presensi->latitude : '0') }}"
                           placeholder="Contoh: -8.1234567"
                           {{ $presensi->status === 'izin' || $presensi->status === 'sakit' ? 'readonly' : '' }}>
                    <small class="form-text">
                        @if($presensi->status === 'izin' || $presensi->status === 'sakit')
                            Koordinat tidak berlaku untuk status Izin/Sakit
                        @else
                            Otomatis terisi sesuai lokasi yang dipilih
                        @endif
                    </small>
                    @error('latitude')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Longitude -->
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" 
                           name="longitude" 
                           id="longitude" 
                           class="form-control @error('longitude') is-invalid @enderror" 
                           value="{{ old('longitude', $presensi->status === 'hadir' ? $presensi->longitude : '0') }}"
                           placeholder="Contoh: 113.1234567"
                           {{ $presensi->status === 'izin' || $presensi->status === 'sakit' ? 'readonly' : '' }}>
                    <small class="form-text">
                        @if($presensi->status === 'izin' || $presensi->status === 'sakit')
                            Koordinat tidak berlaku untuk status Izin/Sakit
                        @else
                            Otomatis terisi sesuai lokasi yang dipilih
                        @endif
                    </small>
                    @error('longitude')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Jarak Masuk -->
                <div class="form-group">
                    <label for="jarak_masuk">Jarak Masuk (meter)</label>
                    <input type="number" 
                           name="jarak_masuk" 
                           id="jarak_masuk" 
                           class="form-control @error('jarak_masuk') is-invalid @enderror" 
                           value="{{ old('jarak_masuk', $presensi->status === 'hadir' ? $presensi->jarak_masuk : '0') }}"
                           step="0.01"
                           min="0"
                           placeholder="Contoh: 25.50"
                           {{ $presensi->status === 'izin' || $presensi->status === 'sakit' ? 'readonly' : '' }}>
                    <small class="form-text">
                        @if($presensi->status === 'izin' || $presensi->status === 'sakit')
                            Jarak tidak berlaku untuk status Izin/Sakit
                        @else
                            Opsional. Jarak dalam meter
                        @endif
                    </small>
                    @error('jarak_masuk')
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
                              placeholder="Masukkan keterangan (opsional)">{{ old('keterangan', $presensi->keterangan) }}</textarea>
                    <small class="form-text">Opsional. Tambahkan keterangan jika diperlukan</small>
                    @error('keterangan')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Foto Bukti -->
                <div class="form-group full-width" id="fotoBuktiContainer">
                    <label for="foto_bukti">Foto Bukti</label>
                    <input type="file" 
                           name="foto_bukti" 
                           id="foto_bukti" 
                           class="form-control @error('foto_bukti') is-invalid @enderror"
                           accept="image/*">
                    <small class="form-text">Upload foto bukti jika status izin/sakit (format: jpg, jpeg, png, max: 2MB)</small>
                    @if($presensi->foto_bukti)
                        <div class="current-foto mt-2">
                            <img src="{{ asset('storage/' . $presensi->foto_bukti) }}" alt="Foto Bukti" style="max-width: 200px; height: auto;">
                        </div>
                    @endif
                    @error('foto_bukti')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
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
                <a href="{{ route('admin.manajemen-presensi-dosen.index') }}" class="btn btn-secondary">
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
@endpush

@push('scripts')
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
@endpush
@endsection