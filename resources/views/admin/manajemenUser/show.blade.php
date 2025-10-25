@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="user-detail">
    <!-- Header -->
    <div class="page-header">
        <h1>Detail User</h1>
        <div class="header-actions">
            <a href="{{ route('admin.manajemen-user.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <!-- User Profile -->
    <div class="profile-section">
        <div class="profile-photo">
            @php
                $pasFoto = null;
                if ($user->role === 'mahasiswa' && $user->mahasiswaProfile) {
                    $pasFoto = $user->mahasiswaProfile->pas_foto;
                } elseif ($user->role === 'dosen' && $user->dosenProfile) {
                    $pasFoto = $user->dosenProfile->pas_foto;
                }
            @endphp
            @if($pasFoto)
                <img src="{{ asset('storage/' . $pasFoto) }}" alt="{{ $user->name }}">
            @else
                <div class="avatar-placeholder">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            @endif
        </div>
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <span class="role-badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
            <p class="text-muted">Bergabung: {{ $user->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <!-- Detail Information -->
    @if($user->role == 'admin')
        <!-- Admin Details -->
        <div class="info-card">
            <h3>Informasi Admin</h3>
            <table class="detail-table">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
            </table>
        </div>

    @elseif($user->role == 'dosen' && $user->dosenProfile)
        <!-- Dosen Details -->
        <div class="info-card">
            <h3>Informasi Identitas</h3>
            <table class="detail-table">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $user->dosenProfile->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIDN</th>
                    <td>{{ $user->dosenProfile->nidn }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->dosenProfile->email }}</td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td>{{ $user->dosenProfile->no_telp ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="info-card">
            <h3>Data Pribadi</h3>
            <table class="detail-table">
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $user->dosenProfile->jenis_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>{{ $user->dosenProfile->tempat_lahir ?? '-' }}, {{ $user->dosenProfile->tanggal_lahir ? \Carbon\Carbon::parse($user->dosenProfile->tanggal_lahir)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Agama</th>
                    <td>{{ $user->dosenProfile->agama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $user->dosenProfile->alamat ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="info-card">
            <h3>Informasi Akademik</h3>
            <table class="detail-table">
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $user->dosenProfile->program_studi ?? '-' }}</td>
                </tr>
            </table>
        </div>

    @elseif($user->role == 'mahasiswa' && $user->mahasiswaProfile)
        <!-- Mahasiswa Details -->
        <div class="info-card">
            <h3>Informasi Identitas</h3>
            <table class="detail-table">
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $user->mahasiswaProfile->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td>{{ $user->mahasiswaProfile->nim }}</td>
                </tr>
                <tr>
                    <th>NIK</th>
                    <td>{{ $user->mahasiswaProfile->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->mahasiswaProfile->email }}</td>
                </tr>
                <tr>
                    <th>No. Telepon</th>
                    <td>{{ $user->mahasiswaProfile->no_telp ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="info-card">
            <h3>Data Pribadi</h3>
            <table class="detail-table">
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $user->mahasiswaProfile->jenis_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>{{ $user->mahasiswaProfile->tempat_lahir ?? '-' }}, {{ $user->mahasiswaProfile->tanggal_lahir ? \Carbon\Carbon::parse($user->mahasiswaProfile->tanggal_lahir)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Agama</th>
                    <td>{{ $user->mahasiswaProfile->agama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $user->mahasiswaProfile->alamat ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="info-card">
            <h3>Informasi Akademik</h3>
            <table class="detail-table">
                <tr>
                    <th>Program Studi</th>
                    <td>{{ $user->mahasiswaProfile->program_studi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Semester</th>
                    <td>Semester {{ $user->mahasiswaProfile->semester ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Masuk</th>
                    <td>{{ $user->mahasiswaProfile->tanggal_masuk ? \Carbon\Carbon::parse($user->mahasiswaProfile->tanggal_masuk)->format('d F Y') : '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $user->mahasiswaProfile->status_mahasiswa ?? 'Aktif' }}</td>
                </tr>
            </table>
        </div>

        <div class="info-card">
            <h3>Informasi Keuangan</h3>
            <table class="detail-table">
                <tr>
                    <th>Biaya Masuk</th>
                    <td>Rp {{ number_format($user->mahasiswaProfile->biaya_masuk ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Status Sync</th>
                    <td>{{ $user->mahasiswaProfile->status_sync ?? 'Belum Sync' }}</td>
                </tr>
            </table>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-section">
        <a href="{{ route('admin.manajemen-user.edit', $user) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('admin.manajemen-user.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </form>
    </div>
</div>

@push('styles')
<style>
    .user-detail {
        max-width: 900px;
        margin: 0 auto;
        padding: 24px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-size: 24px;
        font-weight: 600;
        margin: 0;
        color: #1f2937;
    }

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

    .btn-primary {
       background: #ffc107;
        color: #000;
    }

    .btn-primary:hover {
        background: #e0a800;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .profile-section {
        background: white;
        border-radius: 8px;
        padding: 32px;
        text-align: center;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .profile-photo {
        margin-bottom: 16px;
    }

    .profile-photo img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e5e7eb;
    }

    .avatar-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #6b7280;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 32px;
    }

    .profile-info h2 {
        margin: 0 0 8px 0;
        font-size: 22px;
        font-weight: 600;
        color: #1f2937;
    }

    .role-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .role-admin {
        background: #fee2e2;
        color: #991b1b;
    }

    .role-dosen {
        background: #dcfce7;
        color: #166534;
    }

    .role-mahasiswa {
        background: #dbeafe;
        color: #1e40af;
    }

    .text-muted {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .info-card {
        background: white;
        border-radius: 8px;
        margin-bottom: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .info-card h3 {
        background: #f9fafb;
        padding: 12px 20px;
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .detail-table tr {
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-table tr:last-child {
        border-bottom: none;
    }

    .detail-table th {
        width: 180px;
        padding: 12px 20px;
        text-align: left;
        font-weight: 500;
        font-size: 14px;
        color: #6b7280;
        background: #fafafa;
    }

    .detail-table td {
        padding: 12px 20px;
        font-size: 14px;
        color: #1f2937;
    }

    .action-section {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    @media (max-width: 768px) {
        .user-detail {
            padding: 16px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .detail-table th {
            width: 120px;
            font-size: 13px;
            padding: 10px 16px;
        }

        .detail-table td {
            font-size: 13px;
            padding: 10px 16px;
        }

        .action-section {
            flex-direction: column;
        }

        .action-section .btn,
        .action-section form {
            width: 100%;
        }

        .action-section .btn {
            justify-content: center;
        }
    }
</style>
@endpush
@endsection