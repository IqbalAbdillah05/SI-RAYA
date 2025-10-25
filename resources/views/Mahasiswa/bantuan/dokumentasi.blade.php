@extends('layouts.mahasiswa')

@section('title', 'Dokumentasi Sistem')

@section('content')
<div class="dokumentasi-mahasiswa">
    <!-- Welcome Header -->
    <div class="page-header-banner">
        <div class="header-content">
            <div class="header-text">
                <h1>📚 Dokumentasi Sistem</h1>
                <p>Panduan lengkap penggunaan Sistem Informasi Akademik STAI RAYA</p>
            </div>
            <div class="header-illustration">
                <div class="illustration-circle">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="documentation-container">
        <!-- Quick Navigation -->
        <div class="doc-navigation-card">
            <h3><i class="fas fa-compass"></i> Navigasi Cepat</h3>
            <ul>
                <li><a href="#getting-started"><i class="fas fa-rocket"></i> Memulai</a></li>
                <li><a href="#krs"><i class="fas fa-edit"></i> Pengisian KRS</a></li>
                <li><a href="#khs"><i class="fas fa-chart-bar"></i> Melihat KHS</a></li>
                <li><a href="#jadwal"><i class="fas fa-calendar-alt"></i> Jadwal Kuliah</a></li>
                <li><a href="#presensi"><i class="fas fa-user-check"></i> Presensi</a></li>
                <li><a href="#profil"><i class="fas fa-user-circle"></i> Pengaturan Profil</a></li>
            </ul>
        </div>

        <!-- Getting Started -->
        <div class="doc-section" id="getting-started">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h2>🚀 Memulai</h2>
            </div>
            
            <div class="doc-content">
                <h3>Login ke Sistem</h3>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <strong>Buka Browser</strong>
                            <p>Akses URL sistem yang diberikan oleh kampus</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <strong>Masukkan NIM dan Password</strong>
                            <p>Gunakan NIM sebagai username dan password yang telah diberikan</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <strong>Klik Login</strong>
                            <p>Anda akan diarahkan ke Dashboard mahasiswa</p>
                        </div>
                    </div>
                </div>

                <div class="doc-note">
                    <i class="fas fa-lightbulb"></i>
                    <div>
                        <strong>Tips Keamanan:</strong>
                        <p>Gunakan browser modern seperti Chrome, Firefox, atau Edge. Jangan simpan password di komputer umum dan selalu logout setelah selesai.</p>
                    </div>
                </div>
            </div>

            <div class="doc-content">
                <h3>Navigasi Dashboard</h3>
                <p>Dashboard menampilkan informasi penting:</p>
                <div class="feature-grid">
                    <div class="feature-item">
                        <i class="fas fa-chart-line"></i>
                        <strong>Statistik Akademik</strong>
                        <p>Total SKS, IPK, dan IPS terkini</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-calendar-check"></i>
                        <strong>Jadwal Hari Ini</strong>
                        <p>Jadwal kuliah untuk hari ini</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-file-alt"></i>
                        <strong>KRS Terbaru</strong>
                        <p>Mata kuliah yang diambil semester ini</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-award"></i>
                        <strong>Riwayat KHS</strong>
                        <p>Nilai dan prestasi akademik</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- KRS Section -->
        <div class="doc-section" id="krs">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <h2>📝 Pengisian KRS</h2>
            </div>
            
            <div class="doc-content">
                <h3>Langkah-langkah Mengisi KRS</h3>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <strong>Buka Menu KRS</strong>
                            <p>Klik menu "KRS" di sidebar navigasi</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <strong>Klik "Isi KRS Baru"</strong>
                            <p>Tombol ini hanya muncul saat periode pengisian KRS dibuka</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <strong>Pilih Mata Kuliah</strong>
                            <p>Centang mata kuliah yang ingin diambil. Perhatikan prasyarat dan total SKS</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <strong>Periksa Total SKS</strong>
                            <p>Pastikan tidak melebihi batas maksimal sesuai IPS Anda</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">5</div>
                        <div class="step-content">
                            <strong>Simpan KRS</strong>
                            <p>Klik "Simpan KRS" dan tunggu persetujuan dosen wali</p>
                        </div>
                    </div>
                </div>

                <div class="doc-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Penting!</strong>
                        <ul>
                            <li>KRS hanya bisa diisi pada periode yang ditentukan</li>
                            <li>Perhatikan batas maksimal SKS sesuai IPS Anda</li>
                            <li>Pastikan tidak ada bentrok jadwal</li>
                            <li>KRS yang sudah disetujui tidak bisa diubah tanpa izin dosen wali</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="doc-content">
                <h3>Batas Maksimal SKS</h3>
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>IPS Semester Lalu</th>
                            <th>Maksimal SKS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>≥ 3.00</strong></td>
                            <td><span class="badge success">24 SKS</span></td>
                        </tr>
                        <tr>
                            <td><strong>2.50 - 2.99</strong></td>
                            <td><span class="badge info">21 SKS</span></td>
                        </tr>
                        <tr>
                            <td><strong>2.00 - 2.49</strong></td>
                            <td><span class="badge warning">18 SKS</span></td>
                        </tr>
                        <tr>
                            <td><strong>< 2.00</strong></td>
                            <td><span class="badge danger">15 SKS</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- KHS Section -->
        <div class="doc-section" id="khs">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h2>📊 Melihat KHS</h2>
            </div>
            
            <div class="doc-content">
                <h3>Cara Mengakses KHS</h3>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <strong>Buka Menu KHS</strong>
                            <p>Klik menu "KHS" di sidebar navigasi</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <strong>Pilih Semester</strong>
                            <p>Gunakan dropdown untuk memilih semester yang ingin dilihat</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <strong>Lihat Detail Nilai</strong>
                            <p>KHS menampilkan semua mata kuliah, nilai, SKS, IPS, dan IPK</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <strong>Download PDF</strong>
                            <p>Klik tombol "Download PDF" untuk menyimpan KHS</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="doc-content">
                <h3>Sistem Penilaian</h3>
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Nilai Huruf</th>
                            <th>Nilai Angka</th>
                            <th>Indeks</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>A+</strong></td>
                            <td>96 - 100</td>
                            <td><span class="badge success">4.00</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>A</strong></td>
                            <td>86 - 95</td>
                            <td><span class="badge success">3.50</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>A-</strong></td>
                            <td>81 - 85</td>
                            <td><span class="badge success">3.25</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>B+</strong></td>
                            <td>76 - 80</td>
                            <td><span class="badge info">3.00</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>B</strong></td>
                            <td>71 - 75</td>
                            <td><span class="badge info">2.75</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>B-</strong></td>
                            <td>66 - 70</td>
                            <td><span class="badge info">2.50</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>C+</strong></td>
                            <td>61 - 65</td>
                            <td><span class="badge warning">2.25</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>C</strong></td>
                            <td>56 - 60</td>
                            <td><span class="badge warning">2.00</span></td>
                            <td>Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>D</strong></td>
                            <td>41 - 55</td>
                            <td><span class="badge danger">1.00</span></td>
                            <td>Tidak Lulus</td>
                        </tr>
                        <tr>
                            <td><strong>E</strong></td>
                            <td>0 - 40</td>
                            <td><span class="badge danger">0.00</span></td>
                            <td>Tidak Lulus</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Jadwal Section -->
        <div class="doc-section" id="jadwal">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h2>📅 Jadwal Kuliah</h2>
            </div>
            
            <div class="doc-content">
                <h3>Melihat Jadwal</h3>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <strong>Akses Menu Jadwal</strong>
                            <p>Klik menu "Jadwal" di sidebar atau lihat di Dashboard</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <strong>Lihat Jadwal Harian/Mingguan</strong>
                            <p>Jadwal ditampilkan per hari atau per minggu dengan detail lengkap</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <strong>Filter Mata Kuliah</strong>
                            <p>Gunakan filter untuk mencari mata kuliah tertentu</p>
                        </div>
                    </div>
                </div>

                <div class="doc-note">
                    <i class="fas fa-lightbulb"></i>
                    <div>
                        <strong>Tips:</strong>
                        <p>Selalu cek jadwal sebelum kuliah. Perubahan jadwal akan otomatis diperbarui di sistem dan diumumkan melalui grup kelas.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Presensi Section -->
        <div class="doc-section" id="presensi">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <h2>✅ Presensi Kehadiran</h2>
            </div>
            
            <div class="doc-content">
                <h3>Sistem Presensi</h3>
                <p><strong>Penting:</strong> Presensi mahasiswa dilakukan oleh <strong>dosen yang mengajar</strong>, bukan mahasiswa yang presensi sendiri.</p>
                
                <div class="doc-warning">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Catatan:</strong>
                        <p>Anda hanya dapat melihat riwayat presensi Anda. Untuk absen, hadir di kelas dan dosen akan mencatat kehadiran Anda.</p>
                    </div>
                </div>
            </div>

            <div class="doc-content">
                <h3>Melihat Riwayat Presensi</h3>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <strong>Buka Menu Presensi</strong>
                            <p>Klik menu "Presensi" di sidebar</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <strong>Pilih Mata Kuliah</strong>
                            <p>Gunakan filter untuk melihat presensi per mata kuliah</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <strong>Lihat Status Kehadiran</strong>
                            <p>Status: Hadir, Izin, Sakit, atau Alpha dengan persentase kehadiran</p>
                        </div>
                    </div>
                </div>

                <div class="doc-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Minimal Kehadiran:</strong>
                        <p>Anda harus memiliki minimal <strong>75% kehadiran</strong> untuk dapat mengikuti ujian. Kehadiran kurang dari 75% akan mengakibatkan nilai E.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profil Section -->
        <div class="doc-section" id="profil">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h2>👤 Pengaturan Profil</h2>
            </div>
            
            <div class="doc-content">
                <h3>Update Profil</h3>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <strong>Buka Menu Profil</strong>
                            <p>Klik nama Anda di pojok kanan atas → Profil</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <strong>Edit Data Diri</strong>
                            <p>Ubah data seperti alamat, nomor telepon, email</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <strong>Upload Foto Profil</strong>
                            <p>Klik area foto untuk upload foto profil baru</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <strong>Simpan Perubahan</strong>
                            <p>Klik "Simpan" untuk menyimpan perubahan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="doc-content">
                <h3>Ubah Password</h3>
                <div class="step-list">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <strong>Buka Tab Password</strong>
                            <p>Di halaman profil, klik tab "Ubah Password"</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <strong>Masukkan Password Lama</strong>
                            <p>Isi password lama untuk verifikasi</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <strong>Masukkan Password Baru</strong>
                            <p>Buat password baru yang kuat dan mudah diingat</p>
                        </div>
                    </div>
                    <div class="step-item">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <strong>Simpan</strong>
                            <p>Password akan langsung diupdate</p>
                        </div>
                    </div>
                </div>

                <div class="doc-note">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>Tips Password Aman:</strong>
                        <ul>
                            <li>Minimal 8 karakter</li>
                            <li>Kombinasi huruf besar, kecil, angka, dan simbol</li>
                            <li>Jangan gunakan tanggal lahir atau nama</li>
                            <li>Ubah password secara berkala</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Help Section -->
        <div class="doc-footer">
            <div class="help-section">
                <div class="help-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <h3>Butuh Bantuan?</h3>
                <p>Jika ada yang kurang jelas atau mengalami kendala, jangan ragu untuk menghubungi kami</p>
                <div class="help-links">
                    <a href="{{ route('mahasiswa.bantuan.index') }}" class="help-link">
                        <i class="fas fa-book"></i> Lihat FAQ
                    </a>
                    <a href="{{ route('mahasiswa.bantuan.kontak') }}" class="help-link">
                        <i class="fas fa-headset"></i> Hubungi Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .dokumentasi-mahasiswa {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Page Header Banner */
    .page-header-banner {
        background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
        border-radius: var(--radius);
        padding: 2.5rem;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .page-header-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .header-text h1 {
        font-size: 2rem;
        font-weight: 800;
        color: white;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .header-text p {
        font-size: 1rem;
        color: var(--accent);
        font-weight: 600;
    }

    .header-illustration {
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

    /* Documentation Container */
    .documentation-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Navigation Card */
    .doc-navigation-card {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 1.75rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
        position: sticky;
        top: 20px;
        z-index: 10;
    }

    .doc-navigation-card h3 {
        font-size: 1.15rem;
        color: var(--text-primary);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .doc-navigation-card h3 i {
        color: var(--primary);
    }

    .doc-navigation-card ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.75rem;
    }

    .doc-navigation-card li {
        margin: 0;
    }

    .doc-navigation-card a {
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
    }

    .doc-navigation-card a:hover {
        color: var(--primary);
        background: var(--primary-light);
    }

    .doc-navigation-card a i {
        width: 20px;
        text-align: center;
    }

    /* Doc Section */
    .doc-section {
        background: var(--surface);
        border-radius: var(--radius);
        padding: 2.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border);
    }

    .section-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .section-header h2 {
        font-size: 1.6rem;
        color: var(--text-primary);
        margin: 0;
    }

    /* Doc Content */
    .doc-content {
        margin-bottom: 2.5rem;
    }

    .doc-content:last-child {
        margin-bottom: 0;
    }

    .doc-content h3 {
        font-size: 1.2rem;
        color: var(--text-primary);
        margin-bottom: 1.25rem;
        font-weight: 700;
    }

    .doc-content p {
        color: var(--text-secondary);
        line-height: 1.7;
        margin-bottom: 1rem;
    }

    /* Step List */
    .step-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        margin: 1.5rem 0;
    }

    .step-item {
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
    }

    .step-number {
        width: 40px;
        height: 40px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .step-content {
        flex: 1;
    }

    .step-content strong {
        display: block;
        color: var(--text-primary);
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .step-content p {
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.6;
    }

    /* Feature Grid */
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin: 1.5rem 0;
    }

    .feature-item {
        background: var(--background);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .feature-item:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(11, 102, 35, 0.1);
    }

    .feature-item i {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 0.75rem;
    }

    .feature-item strong {
        display: block;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .feature-item p {
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin: 0;
    }

    /* Info Table */
    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.5rem 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .info-table thead {
        background: var(--primary);
        color: white;
    }

    .info-table th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .info-table tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background 0.2s;
    }

    .info-table tbody tr:hover {
        background: var(--background);
    }

    .info-table tbody tr:last-child {
        border-bottom: none;
    }

    .info-table td {
        padding: 1rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .info-table td strong {
        color: var(--text-primary);
    }

    /* Badge */
    .badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .badge.success {
        background: #dcfce7;
        color: #16a34a;
    }

    .badge.info {
        background: #dbeafe;
        color: #3b82f6;
    }

    .badge.warning {
        background: #fef3c7;
        color: #f59e0b;
    }

    .badge.danger {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Doc Note/Warning */
    .doc-note,
    .doc-warning {
        display: flex;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 10px;
        margin: 1.5rem 0;
    }

    .doc-note {
        background: #eff6ff;
        border-left: 4px solid #3b82f6;
    }

    .doc-note i {
        color: #3b82f6;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .doc-warning {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
    }

    .doc-warning i {
        color: #f59e0b;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .doc-note strong,
    .doc-warning strong {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .doc-note p,
    .doc-warning p {
        margin: 0;
        line-height: 1.6;
    }

    .doc-note ul,
    .doc-warning ul {
        margin: 0.5rem 0 0 0;
        padding-left: 1.5rem;
    }

    .doc-note li,
    .doc-warning li {
        margin-bottom: 0.25rem;
    }

    /* Footer Help Section */
    .doc-footer {
        margin-top: 3rem;
    }

    .help-section {
        background: linear-gradient(135deg, var(--primary) 0%, var(--hover) 100%);
        border-radius: var(--radius);
        padding: 3rem 2rem;
        text-align: center;
        color: white;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .help-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 15s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .help-section .help-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
    }

    .help-section h3 {
        font-size: 1.75rem;
        margin-bottom: 0.75rem;
        font-weight: 800;
        position: relative;
        z-index: 1;
    }

    .help-section p {
        margin-bottom: 2rem;
        opacity: 0.95;
        font-size: 1.05rem;
        position: relative;
        z-index: 1;
    }

    .help-links {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .help-link {
        background: white;
        color: var(--primary);
        padding: 0.875rem 1.75rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .help-link:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        background: var(--accent);
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header-banner {
            padding: 1.5rem;
        }

        .header-text h1 {
            font-size: 1.5rem;
        }

        .illustration-circle {
            width: 70px;
            height: 70px;
            font-size: 2rem;
        }

        .doc-navigation-card {
            position: static;
        }

        .doc-navigation-card ul {
            grid-template-columns: 1fr;
        }

        .doc-section {
            padding: 1.5rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .section-header h2 {
            font-size: 1.3rem;
        }

        .feature-grid {
            grid-template-columns: 1fr;
        }

        .help-links {
            flex-direction: column;
        }

        .help-link {
            width: 100%;
            justify-content: center;
        }

        .help-section {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endpush
@endsection
