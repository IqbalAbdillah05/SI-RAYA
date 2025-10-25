@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="dashboard-dosen">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
                <p><i class="fas fa-calendar-day"></i> {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <div class="welcome-illustration">
                <div class="illustration-circle">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="stat-item stat-primary">
            <div class="stat-icon">
                <i class="fas fa-fingerprint"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Presensi Saya (Bulan Ini)</span>
                <h3 class="stat-value">{{ $stats['presensi_dosen'] }} Hari</h3>
                <span class="stat-time">{{ now()->locale('id')->isoFormat('MMMM Y') }}</span>
            </div>
            <div class="stat-badge success">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>

        <div class="stat-item stat-info">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Presensi Mahasiswa (Bulan Ini)</span>
                <h3 class="stat-value">{{ $stats['presensi_mahasiswa'] }} Data</h3>
                <span class="stat-time">{{ now()->locale('id')->isoFormat('MMMM Y') }}</span>
            </div>
            <div class="stat-badge info">
                <i class="fas fa-arrow-up"></i>
            </div>
        </div>

        <div class="stat-item stat-warning">
            <div class="stat-icon">
                <i class="fas fa-award"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Nilai Mahasiswa</span>
                <h3 class="stat-value">{{ $stats['nilai_mahasiswa'] }} Nilai</h3>
                <span class="stat-time">Total Diinput</span>
            </div>
            <div class="stat-badge warning">
                <i class="fas fa-graduation-cap"></i>
            </div>
        </div>

        <div class="stat-item stat-accent">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-details">
                <span class="stat-label">Jadwal Mengajar</span>
                <h3 class="stat-value">{{ $stats['total_jadwal'] }} Jadwal</h3>
                <span class="stat-time">Total Aktif</span>
            </div>
            <div class="stat-badge accent">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="dashboard-grid">
        <!-- Profile Card -->
        <div class="profile-section">
            <div class="card profile-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-id-card-alt"></i>
                        <h3>Profil Dosen</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="profile-photo-wrapper">
                        @if(Auth::user()->dosen && Auth::user()->dosen->pas_foto)
                            <div class="profile-photo-container">
                                <img src="{{ asset('storage/' . Auth::user()->dosen->pas_foto) }}" alt="Foto Profil" class="profile-photo">
                                <button type="button" class="edit-photo-btn" onclick="document.getElementById('editFotoModal').style.display='block'">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        @else
                            <div class="profile-avatar-large">
                                {{ strtoupper(substr(Auth::user()->dosen->nama_lengkap ?? Auth::user()->name, 0, 2)) }}
                                <button type="button" class="edit-photo-btn" onclick="document.getElementById('editFotoModal').style.display='block'">
                                    <i class="fas fa-camera"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="profile-info-list">
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-user"></i> Nama Lengkap</span>
                            <span class="info-value">{{ Auth::user()->dosen->nama_lengkap ?? Auth::user()->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-id-badge"></i> NIDN</span>
                            <span class="info-value">{{ Auth::user()->dosen->nidn ?? Auth::user()->nidn ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-graduation-cap"></i> Program Studi</span>
                            <span class="info-value">{{ Auth::user()->dosen->program_studi ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-venus-mars"></i> Jenis Kelamin</span>
                            <span class="info-value">{{ Auth::user()->dosen->jenis_kelamin ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                            <span class="info-value">{{ Auth::user()->dosen->email ?? Auth::user()->email ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-phone"></i> No. Telepon</span>
                            <span class="info-value">{{ Auth::user()->dosen->no_telp ?? '-' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="fas fa-circle"></i> Status</span>
                            <span class="status-badge active">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="content-section">
            <!-- Jadwal Hari Ini -->
            <div class="card schedule-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-calendar-check"></i>
                        <h3>Jadwal Mengajar Hari Ini</h3>
                    </div>
                    <a href="{{ route('dosen.jadwalMengajar.index') }}" class="view-all-link">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="schedule-list">
                        @forelse($jadwalHariIni as $jadwal)
                            <div class="schedule-item">
                                <div class="schedule-time">
                                    <span class="time">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}</span>
                                    <span class="separator">-</span>
                                    <span class="time">{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</span>
                                </div>
                                <div class="schedule-details">
                                    <h4>{{ $jadwal->mataKuliah->nama_matakuliah ?? '-' }}</h4>
                                    <p><i class="fas fa-door-open"></i> {{ $jadwal->ruang }}</p>
                                    <span class="class-badge">{{ $jadwal->prodi->nama_prodi ?? '-' }} - Semester {{ $jadwal->semester }}</span>
                                </div>
                                <div class="schedule-status upcoming">
                                    <i class="fas fa-calendar"></i> {{ $jadwal->tahun_ajaran }}
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 40px 20px; color: #999;">
                                <i class="fas fa-calendar-times" style="font-size: 48px; opacity: 0.3; margin-bottom: 12px;"></i>
                                <p style="margin: 0;">Tidak ada jadwal mengajar hari ini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Presensi Dosen Terbaru -->
            <div class="card activity-card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-fingerprint"></i>
                        <h3>Presensi Saya Terbaru</h3>
                    </div>
                    <a href="{{ route('dosen.presensi.riwayat') }}" class="view-all-link">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="activity-list">
                        @forelse($presensiDosenTerbaru as $presensi)
                            <div class="activity-item">
                                <div class="activity-icon {{ $presensi->status == 'hadir' ? 'success' : 'warning' }}">
                                    <i class="fas fa-{{ $presensi->status == 'hadir' ? 'check' : 'info' }}"></i>
                                </div>
                                <div class="activity-content">
                                    <h4>{{ ucfirst($presensi->status) }}</h4>
                                    <p><i class="fas fa-map-marker-alt"></i> {{ $presensi->lokasi->nama_lokasi ?? '-' }}</p>
                                    <span class="activity-time"><i class="fas fa-clock"></i> {{ $presensi->waktu_presensi->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div style="text-align: center; padding: 20px; color: #999;">
                                <p style="margin: 0;">Belum ada riwayat presensi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Grid 2 Kolom untuk Presensi Mahasiswa dan Nilai -->
            <div class="activity-grid-2col">
                <!-- Presensi Mahasiswa Terbaru -->
                <div class="card activity-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-user-check"></i>
                            <h3>Presensi Mahasiswa Terbaru</h3>
                        </div>
                        <a href="{{ route('dosen.presensiMahasiswa.riwayat') }}" class="view-all-link">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            @forelse($presensiMahasiswaTerbaru as $presensi)
                                <div class="activity-item">
                                    <div class="activity-icon {{ $presensi->status == 'hadir' ? 'success' : ($presensi->status == 'izin' || $presensi->status == 'sakit' ? 'warning' : 'danger') }}">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>{{ $presensi->mahasiswa->nama_lengkap ?? '-' }} - {{ ucfirst($presensi->status) }}</h4>
                                        <p><i class="fas fa-book"></i> {{ $presensi->mataKuliah->nama_matakuliah ?? '-' }}</p>
                                        <span class="activity-time"><i class="fas fa-clock"></i> {{ $presensi->waktu_presensi->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: #999;">
                                    <p style="margin: 0;">Belum ada riwayat presensi mahasiswa</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Nilai Mahasiswa Terbaru -->
                <div class="card activity-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-award"></i>
                            <h3>Nilai Mahasiswa Terbaru</h3>
                        </div>
                        <a href="{{ route('dosen.inputNilai.index') }}" class="view-all-link">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            @forelse($nilaiTerbaru as $nilai)
                                <div class="activity-item">
                                    <div class="activity-icon info">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>{{ $nilai->mahasiswa->nama_lengkap ?? '-' }} - {{ $nilai->nilai_huruf }}</h4>
                                        <p><i class="fas fa-book"></i> {{ $nilai->mataKuliah->nama_matakuliah ?? '-' }} ({{ $nilai->nilai_angka }})</p>
                                        <span class="activity-time"><i class="fas fa-clock"></i> {{ $nilai->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: #999;">
                                    <p style="margin: 0;">Belum ada nilai yang diinput</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dashboard-dosen {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Alert Messages */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-size: 0.95rem;
        animation: slideInDown 0.4s ease;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert i {
        font-size: 1.25rem;
        margin-top: 2px;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    .alert-success i {
        color: #10b981;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    .alert-error i {
        color: #ef4444;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
        border-radius: var(--radius);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .welcome-text h1 {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .welcome-text p {
        font-size: 1rem;
        color: var(--accent);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .welcome-illustration {
        display: flex;
        align-items: center;
    }

    .illustration-circle {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--accent);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    /* Quick Stats */
    .quick-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.25rem;
    }

    .stat-item {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        transition: width 0.3s ease;
    }

    .stat-item.stat-primary::before { background: var(--primary); }
    .stat-item.stat-info::before { background: #3b82f6; }
    .stat-item.stat-warning::before { background: #f59e0b; }
    .stat-item.stat-accent::before { background: var(--accent); }

    .stat-item:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .stat-item:hover::before {
        width: 8px;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .stat-primary .stat-icon {
        background: var(--primary-light);
        color: var(--primary);
    }

    .stat-info .stat-icon {
        background: #dbeafe;
        color: #3b82f6;
    }

    .stat-warning .stat-icon {
        background: #fef3c7;
        color: #f59e0b;
    }

    .stat-accent .stat-icon {
        background: var(--accent-light);
        color: var(--accent);
    }

    .stat-details {
        flex: 1;
    }

    .stat-label {
        font-size: 0.813rem;
        color: var(--text-secondary);
        font-weight: 600;
        display: block;
        margin-bottom: 0.25rem;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        line-height: 1.2;
    }

    .stat-time {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .stat-badge {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .stat-badge.success {
        background: #dcfce7;
        color: #16a34a;
    }

    .stat-badge.info {
        background: #dbeafe;
        color: #3b82f6;
    }

    .stat-badge.warning {
        background: #fef3c7;
        color: #f59e0b;
    }

    .stat-badge.accent {
        background: var(--accent-light);
        color: var(--accent);
    }

    /* Dashboard Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 1.5rem;
    }

    /* Card Styles */
    .card {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        overflow: hidden;
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--background);
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        font-size: 1.25rem;
        color: var(--primary);
    }

    .card-title h3 {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .view-all-link {
        font-size: 0.875rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: gap 0.2s ease;
    }

    .view-all-link:hover {
        gap: 0.75rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Profile Card */
    .profile-card .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .profile-photo-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(11, 102, 35, 0.3);
        border: 4px solid white;
    }

    .profile-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar-large {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary), var(--hover));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 16px rgba(11, 102, 35, 0.3);
    }

    .profile-info-list {
        width: 100%;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 0;
        border-bottom: 1px solid var(--border);
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.813rem;
        color: var(--text-secondary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        width: 16px;
        text-align: center;
    }

    .info-value {
        font-size: 0.813rem;
        color: var(--text-primary);
        font-weight: 700;
        text-align: right;
    }

    .status-badge {
        background: #dcfce7;
        color: #16a34a;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    /* Schedule Card */
    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .schedule-item {
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 1rem;
        padding: 1.25rem;
        background: var(--background);
        border: 1px solid var(--border);
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .schedule-item:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(11, 102, 35, 0.1);
    }

    .schedule-time {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
    }

    .schedule-time .time {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary);
    }

    .schedule-time .separator {
        color: var(--text-secondary);
    }

    .schedule-details h4 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .schedule-details p {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .class-badge {
        display: inline-block;
        background: var(--accent-light);
        color: var(--accent);
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .schedule-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.813rem;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        white-space: nowrap;
    }

    .schedule-status.ongoing {
        background: #dcfce7;
        color: #16a34a;
    }

    .schedule-status.upcoming {
        background: #dbeafe;
        color: #3b82f6;
    }

    /* Quick Actions Grid */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .action-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
        padding: 1.5rem;
        background: var(--background);
        border: 1px solid var(--border);
        border-radius: 10px;
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.2s ease;
    }

    .action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    .action-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .action-icon.primary {
        background: var(--primary-light);
        color: var(--primary);
    }

    .action-icon.success {
        background: #dcfce7;
        color: #16a34a;
    }

    .action-icon.warning {
        background: #fef3c7;
        color: #f59e0b;
    }

    .action-icon.info {
        background: #dbeafe;
        color: #3b82f6;
    }

    .action-card span {
        font-size: 0.875rem;
        font-weight: 600;
        text-align: center;
    }

    /* Activity List */
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        background: var(--background);
        border-radius: 10px;
        border: 1px solid var(--border);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .activity-icon.success {
        background: #dcfce7;
        color: #16a34a;
    }

    .activity-icon.primary {
        background: var(--primary-light);
        color: var(--primary);
    }

    .activity-icon.warning {
        background: #fef3c7;
        color: #f59e0b;
    }

    .activity-content {
        flex: 1;
    }

    .activity-content h4 {
        font-size: 0.938rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .activity-content p {
        font-size: 0.813rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }

    .activity-time {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Content Section */
    .content-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Grid untuk Presensi & Nilai Mahasiswa */
    .activity-grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .profile-section {
            order: 2;
        }

        .content-section {
            order: 1;
        }
    }

    @media (max-width: 768px) {
        .activity-grid-2col {
            grid-template-columns: 1fr;
        }

        .welcome-banner {
            padding: 1.5rem;
        }

        .welcome-text h1 {
            font-size: 1.5rem;
        }

        .illustration-circle {
            width: 70px;
            height: 70px;
            font-size: 2rem;
        }

        .quick-stats {
            grid-template-columns: 1fr;
        }

        .schedule-item {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .schedule-time {
            flex-direction: row;
            justify-content: flex-start;
        }

        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Modal Edit Foto */
    .modal-overlay {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.3s;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: var(--primary);
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.2s;
    }

    .close-modal:hover {
        background-color: #f3f4f6;
        color: var(--primary);
    }

    .modal-body {
        padding: 1.5rem;
    }

    .upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        background-color: #f9fafb;
        transition: all 0.3s;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: var(--primary);
        background-color: #f0fdf4;
    }

    .upload-area.dragover {
        border-color: var(--primary);
        background-color: #dcfce7;
    }

    .upload-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .upload-text {
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        font-size: 0.875rem;
        color: #9ca3af;
    }

    .file-input {
        display: none;
    }

    .preview-area {
        margin-top: 1rem;
        display: none;
    }

    .preview-image {
        max-width: 100%;
        max-height: 250px;
        width: 100%;
        object-fit: contain;
        border-radius: 8px;
        margin-bottom: 1rem;
        background-color: #f3f4f6;
    }

    .file-info {
        background-color: #f3f4f6;
        padding: 0.75rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .file-name {
        font-size: 0.875rem;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .remove-file {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .remove-file:hover {
        background-color: #fee2e2;
    }

    .modal-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.75rem;
        justify-content: flex-end;
        background-color: #f9fafb;
        position: sticky;
        bottom: 0;
        z-index: 10;
    }

    .btn-modal {
        padding: 0.625rem 1.25rem;
        border-radius: 6px;
        border: none;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-cancel {
        background-color: #f3f4f6;
        color: #374151;
    }

    .btn-cancel:hover {
        background-color: #e5e7eb;
    }

    .btn-upload {
        background: linear-gradient(135deg, var(--primary) 0%, #065f46 100%);
        color: white;
    }

    .btn-upload:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(11, 102, 35, 0.3);
    }

    .btn-upload:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .profile-photo-wrapper {
        position: relative;
        display: inline-block;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }

    .profile-photo-container,
    .profile-avatar-large {
        position: relative;
    }

    .edit-photo-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, #065f46 100%);
        color: white;
        border: 3px solid white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .edit-photo-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(11, 102, 35, 0.4);
    }
</style>
@endpush

<!-- Modal Edit Foto -->
<div id="editFotoModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-camera"></i> Edit Foto Profil</h3>
            <button type="button" class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <form action="{{ route('dosen.update-foto') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
            @csrf
            <div class="modal-body">
                <div class="upload-area" id="uploadArea" onclick="document.getElementById('fileInput').click()">
                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                    <p class="upload-text"><strong>Klik untuk upload</strong> atau drag & drop</p>
                    <p class="upload-hint">Format: JPG, JPEG, PNG (Max: 2MB)</p>
                </div>
                <input type="file" name="pas_foto" id="fileInput" class="file-input" accept="image/jpeg,image/png,image/jpg" required>
                
                <div class="preview-area" id="previewArea">
                    <img id="previewImage" class="preview-image" alt="Preview">
                    <div class="file-info">
                        <span class="file-name">
                            <i class="fas fa-file-image"></i>
                            <span id="fileName"></span>
                        </span>
                        <button type="button" class="remove-file" onclick="removeFile()">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-modal btn-upload" id="btnUpload" disabled>
                    <i class="fas fa-upload"></i> Upload Foto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('editFotoModal');
    const fileInput = document.getElementById('fileInput');
    const uploadArea = document.getElementById('uploadArea');
    const previewArea = document.getElementById('previewArea');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const btnUpload = document.getElementById('btnUpload');

    function closeModal() {
        modal.style.display = 'none';
        removeFile();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        }
    }

    // File input change
    fileInput.addEventListener('change', function(e) {
        handleFile(this.files[0]);
    });

    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            fileInput.files = e.dataTransfer.files;
            handleFile(file);
        }
    });

    function handleFile(file) {
        if (!file) return;

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar!');
            return;
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB!');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            fileName.textContent = file.name;
            uploadArea.style.display = 'none';
            previewArea.style.display = 'block';
            btnUpload.disabled = false;
        }
        reader.readAsDataURL(file);
    }

    function removeFile() {
        fileInput.value = '';
        uploadArea.style.display = 'block';
        previewArea.style.display = 'none';
        btnUpload.disabled = true;
    }

    // Auto hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s, transform 0.5s';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 5000);
        });
    });
</script>

@endsection
