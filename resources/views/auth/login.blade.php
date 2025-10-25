@extends('layouts.auth')

@section('title', 'Login - SI-Raya STAI RAYA')

@push('styles')
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
@endpush

@section('content')
<div class="login-container">
    <div class="login-header">
        <img src="{{ asset('images/stai-raya-logo.png') }}" alt="STAI RAYA Logo" class="logo">
        
        <!-- Judul simple -->
        <h1>SI-RAYA</h1>
        <p>Sistem Informasi STAI RAYA</p>
    </div>

    <!-- Label form simple -->
    <div class="form-label">
        <h2>Login</h2>
    </div>

    <!-- Tampilkan error blokir mahasiswa -->
    @if (session('error') && session('blokir_detail'))
        <div class="alert alert-danger blokir-detail">
            <h3>Akun Anda Diblokir</h3>
            <div class="blokir-info">
                <p><strong>Alasan Pemblokiran:</strong> {{ session('blokir_detail')['keterangan'] }}</p>
                <p><strong>Tanggal Blokir:</strong> {{ session('blokir_detail')['tanggal_blokir'] }}</p>
                <p><strong>Admin yang Memblokir:</strong> {{ session('blokir_detail')['admin'] }}</p>
                <p class="kontak-admin">Silakan hubungi admin untuk informasi lebih lanjut.</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf

        <div class="form-group">
            <input 
                type="text" 
                id="username" 
                name="username" 
                required 
                autofocus
                value="{{ old('username') }}"
                placeholder="Masukkan Username"
            >
            <label for="username">Username</label>
            @error('username')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
                value="{{ old('password') }}"
            >
            <label for="password">Kata Sandi</label>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn-login">
                <span>Masuk</span>
                <div class="btn-loader"></div>
            </button>
        </div>
    </form>

    <div class="login-footer">
        &copy; {{ date('Y') }} STAI RAYA Mlokorejo - Jember.