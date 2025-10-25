@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="admin-dashboard">
    <!-- Header -->
    <div class="dashboard-header">
        <div class="header-left">
            <h1>Dashboard Admin</h1>
            <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <div class="header-right">
            <div class="current-date">
                <i class="fas fa-calendar-alt"></i>
                <span id="current-date"></span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <h3>Total Mahasiswa</h3>
                <p class="stat-number">{{ $totalMahasiswa ?? 0 }}</p>
                <a href="{{ route('admin.manajemen-user.index') }}?role=mahasiswa" class="stat-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-content">
                <h3>Total Dosen</h3>
                <p class="stat-number">{{ $totalDosen ?? 0 }}</p>
                <a href="{{ route('admin.manajemen-user.index') }}?role=dosen" class="stat-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-content">
                <h3>Total Admin</h3>
                <p class="stat-number">{{ $totalAdmin ?? 0 }}</p>
                <a href="{{ route('admin.manajemen-user.index') }}?role=admin" class="stat-link">Lihat Detail <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Charts and Activity Section -->
    <div class="dashboard-content">
        <!-- Recent Activities -->
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-history"></i> Aktivitas Terbaru</h2>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon {{ $activity->type }}">
                                <i class="fas fa-{{ $activity->icon }}"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-title">{{ $activity->title }}</p>
                                <p class="activity-description">{{ $activity->description }}</p>
                                <span class="activity-time">{{ $activity->time }}</span>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada aktivitas terbaru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-clipboard-list"></i> Status KRS</h2>
            </div>
            <div class="card-body">
                <div class="krs-stats">
                    <div class="krs-stat-item">
                        <div class="krs-stat-header">
                            <span class="krs-label">Total KRS</span>
                            <span class="krs-number total">{{ $totalKrs }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill total" style="width: 100%"></div>
                        </div>
                    </div>
                    
                    <div class="krs-stat-item">
                        <div class="krs-stat-header">
                            <span class="krs-label">Menunggu Validasi</span>
                            <span class="krs-number warning">{{ $krsMenunggu }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill warning" style="width: {{ $totalKrs > 0 ? ($krsMenunggu / $totalKrs * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="krs-stat-item">
                        <div class="krs-stat-header">
                            <span class="krs-label">Disetujui</span>
                            <span class="krs-number success">{{ $krsDisetujui }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill success" style="width: {{ $totalKrs > 0 ? ($krsDisetujui / $totalKrs * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="krs-stat-item">
                        <div class="krs-stat-header">
                            <span class="krs-label">Ditolak</span>
                            <span class="krs-number danger">{{ $krsDitolak }}</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill danger" style="width: {{ $totalKrs > 0 ? ($krsDitolak / $totalKrs * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
                
                <div style="margin-top: 15px; text-align: center;">
                    <a href="{{ route('admin.krs.index') }}" class="btn-link">
                        <i class="fas fa-eye"></i> Lihat Semua KRS
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="dashboard-statistics">
        <div class="content-card">
            <div class="card-header">
                <h2><i class="fas fa-chart-pie"></i> Statistik Kehadiran Bulan Ini</h2>
            </div>
            <div class="card-body">
                <div class="statistics-grid">
                    <div class="stat-item">
                        <div class="stat-circle green">
                            <span class="percentage">{{ $attendancePercentage }}</span>
                        </div>
                        <p class="stat-label">Kehadiran Mahasiswa</p>
                    </div>
                    <div class="stat-item">
                        <div class="stat-circle blue">
                            <span class="percentage">{{ $lecturerAttendance }}</span>
                        </div>
                        <p class="stat-label">Kehadiran Dosen</p>
                    </div>
                </div>
            </div>
        </div>

       <div class="content-card">
    <div class="card-header">
        <h2><i class="fas fa-calendar-week"></i> Jadwal Mendatang</h2>
    </div>
    <div class="card-body">
        <div class="schedule-list">
            @if(isset($upcomingSchedules) && count($upcomingSchedules) > 0)
                @foreach($upcomingSchedules as $schedule)
                <div class="schedule-item">
                    <div class="schedule-time">
                        <span class="date">{{ $schedule->date }}</span>
                        <span class="time">{{ $schedule->time }} - {{ $schedule->end_time }}</span>
                        <span class="semester">Semester {{ $schedule->semester }}</span>
                        <span class="year">{{ $schedule->tahun_ajaran }}</span>
                    </div>
                    <div class="schedule-details">
                        <h4>{{ $schedule->subject }}</h4>
                        <p>{{ $schedule->lecturer }}</p>
                        <span class="location">
                            <i class="fas fa-map-marker-alt"></i> {{ $schedule->room }}
                        </span>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-calendar-times"></i>
                    <p>Tidak ada jadwal mendatang</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    * {
        box-sizing: border-box;
    }

    .admin-dashboard {
        padding: 20px;
        font-family: Arial, sans-serif;
        color: #333;
    }

    /* Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background: white;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 3px;
    }

    .dashboard-header h1 {
        font-size: 24px;
        font-weight: normal;
        margin: 0 0 5px 0;
        color: #333;
    }

    .dashboard-header p {
        color: #666;
        margin: 0;
        font-size: 14px;
    }

    .current-date {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #007bff;
        font-weight: 600;
        font-size: 14px;
    }

    /* Stats Cards */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        display: flex;
        align-items: center;
        padding: 20px;
        gap: 15px;
        transition: all 0.3s;
        cursor: pointer;
    }

    .stat-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 3px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .stat-icon.blue { background: #007bff; }
    .stat-icon.green { background: #28a745; }
    .stat-icon.orange { background: #fd7e14; }
    .stat-icon.red { background: #dc3545; }

    .stat-content {
        flex-grow: 1;
    }

    .stat-content h3 {
        margin: 0 0 8px 0;
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        margin: 0 0 8px 0;
    }

    .stat-link {
        color: #666;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        transition: color 0.2s;
    }

    .stat-link:hover {
        color: #007bff;
    }

    /* Content Cards */
    .dashboard-content {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 15px;
        margin-bottom: 20px;
    }

    .content-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 3px;
        overflow: hidden;
    }

    .card-header {
        background: #007bff;
        color: white;
        padding: 15px 20px;
        border-bottom: 1px solid #ddd;
    }

    .card-header h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-body {
        padding: 20px;
    }

    /* Recent Activities */
    .activity-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .activity-icon.info { background: #e3f2fd; color: #2196f3; }
    .activity-icon.success { background: #e8f5e9; color: #4caf50; }
    .activity-icon.warning { background: #fff3e0; color: #ff9800; }
    .activity-icon.danger { background: #ffebee; color: #f44336; }

    .activity-content {
        flex-grow: 1;
    }

    .activity-title {
        font-weight: 600;
        color: #333;
        margin: 0 0 3px 0;
        font-size: 14px;
    }

    .activity-description {
        color: #666;
        margin: 0 0 3px 0;
        font-size: 13px;
    }

    .activity-time {
        color: #999;
        font-size: 12px;
    }

    /* Quick Actions */
    .krs-stats {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .krs-stat-item {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 4px;
    }

    .krs-stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .krs-label {
        font-size: 14px;
        color: #666;
        font-weight: 600;
    }

    .krs-number {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .krs-number.total { color: #007bff; }
    .krs-number.warning { color: #ffc107; }
    .krs-number.success { color: #28a745; }
    .krs-number.danger { color: #dc3545; }

    .progress-bar {
        height: 8px;
        background: #e9ecef;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        transition: width 0.5s ease;
        border-radius: 4px;
    }

    .progress-fill.total { background: #007bff; }
    .progress-fill.warning { background: #ffc107; }
    .progress-fill.success { background: #28a745; }
    .progress-fill.danger { background: #dc3545; }

    .btn-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .btn-link:hover {
        background: #e7f3ff;
        color: #0056b3;
    }

    /* Statistics Section */
    .dashboard-statistics {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .statistics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        text-align: center;
    }

    .stat-circle {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.3rem;
        font-weight: bold;
        color: white;
    }

    .stat-circle.green { background: #28a745; }
    .stat-circle.blue { background: #007bff; }
    .stat-circle.orange { background: #fd7e14; }

    .stat-label {
        color: #666;
        font-weight: 600;
        font-size: 13px;
        margin: 0;
    }

    /* Schedule List */
    .schedule-list {
        max-height: 350px;
        overflow-y: auto;
    }

    .schedule-item {
        display: flex;
        gap: 12px;
        padding: 12px;
        border-left: 3px solid #007bff;
        background: #f8f9fa;
        border-radius: 3px;
        margin-bottom: 10px;
    }

    .schedule-time {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 120px;
        text-align: center;
    }

    .schedule-time .date {
        font-weight: bold;
        color: #007bff;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .schedule-time .time {
        color: #007bff;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .schedule-time .semester,
    .schedule-time .year {
        font-size: 12px;
        color: #666;
        display: block;
        margin-top: 2px;
    }

    .schedule-details h4 {
        margin: 0 0 5px 0;
        color: #333;
        font-size: 14px;
        font-weight: 600;
    }

    .schedule-details p {
        margin: 0 0 5px 0;
        color: #666;
        font-size: 13px;
    }

    .schedule-details .location {
        color: #999;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .schedule-details .location i {
        color: #007bff;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #999;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .dashboard-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-content {
            grid-template-columns: 1fr;
        }

        .dashboard-statistics {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .action-grid {
            grid-template-columns: 1fr;
        }

        .statistics-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update current date
        const dateElement = document.getElementById('current-date');
        if (dateElement) {
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const currentDate = new Date().toLocaleDateString('id-ID', options);
            dateElement.textContent = currentDate;
        }
    });
</script>
@endpush
@endsection